<?
class _dashboard extends controller{
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$fcmToken=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("fcmToken"));
		$deviceId=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceId"));
		$appVersion=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("appVersion"));

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID==''?"1":$this->app->utility->decrypt($cityID);

		$cartItemIds=array();
		if($userID!='')
		{
			$obj_model_cart = $this->app->load_model("customer_cart");
			$cart = $obj_model_cart->execute("SELECT", false, "", "customer_cart.customer_id='".$userID."'","customer_cart.id DESC");
			foreach($cart as $item)
			{
				$cartItemIds[]=$item["cart_item_id"];
			}
		}
		
		if($userID!='' && $userPhone!='' && $fcmToken!='') {
			$obj_model = $this->app->load_model("customer_token");
			$obj_model->set_fields_to_get(array("fcm_token"));
			$customer_token = $obj_model->execute("SELECT",false,"","customer_id='".$userID."'");
			
			$data_t=array();
			if($deviceType=='Android') {
				$data_t['android_version']=$appVersion;
				$data_t['fcm_token']=$fcmToken;
				$data_t['android_device']=$deviceId;
				$data_t['android_updated_at']=date('d-m-Y H:i:s');
				$data_t['android_ip_address']=$ip;
			} else {
				$data_t['iphone_version']=$appVersion;
				$data_t['iphone_token']=$fcmToken;
				$data_t['iphone_updated_at']=date('d-m-Y H:i:s');
				$data_t['iphone_ip_address']=$ip;
			}
			$obj_model=$this->app->load_model("customer_token");
			
			if(count($customer_token)>0){
				$obj_model->map_fields($data_t);
				$obj_model->execute("UPDATE",false,"","customer_id='".$userID."'");	
			}else{
				$data_t['customer_id']=$userID;
				$obj_model->map_fields($data_t);
				$obj_model->execute("INSERT");	
			}
		}

		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='home' and (FIND_IN_SET ('".$cityID."',banner.city_ids) or city_ids='')","sort_id ASC");
		foreach($rs_banner as $item){
			if($item['mobile_image']!=''){
				$folder='main_banner_images';
				$image=$this->app->utility->get_image_path($item['mobile_image'],$folder,"large");
				$banner[]=[
					"ID"=>$this->app->utility->encrypt($item['id']),
					"image"=>$image,
					"itemID"=>"",
					"page"=>""
				];
			}
		}
		
		$obj_model_item_diseases=$this->app->load_model('item_diseases');
		$rs_item_diseases=$obj_model_item_diseases->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC limit 0,10");
		foreach($rs_item_diseases as $item) {
			$folder='item_diseases';
			$image=$this->app->utility->get_image_path($item['image'],$folder,"large");
			$diseases[]=[
				"ID"=>$item['id'],
				"image"=>$image,
				"name"=>$item['name']
			];
		}

		$obj_model_item_category=$this->app->load_model('item_category');
		$item_category=$obj_model_item_category->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC limit 0,6");
		foreach($item_category as $item) {
			$folder='item_category';
			$image=$this->app->utility->get_image_path($item['image'],$folder,"large");
			$category[]=[
				"ID"=>$item['id'],
				"image"=>$image,
				"name"=>$item['name']
			];
		}

		$sort_cond="item.sort_order ASC";
		$master_con=" and FIND_IN_SET ('".$cityID."',item.city_ids) and item_price.city_id='".$cityID."'";
		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
		$records = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.status='Active' and  item.set_at_home='Yes' ".$master_con."","".$sort_cond." limit 0,12","");
		foreach($records as $item) {

			$item_price_id=$item['item_price_id'];
			$name=$item['name'];
			$test_count=$item['test_count'];
			$price=$item['item_price_price'];
			$mrp=$item['item_price_mrp'];
			$sch_price=$item['item_price_sch_price'];
			$sch_start_date=$item['item_price_sch_start_date'];
			$sch_end_date=$item['item_price_sch_end_date'];
			if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
			{
				$today_date=date('d-m-Y');
				$todaySlot=strtotime($today_date);
				$startSlot=strtotime($sch_start_date);
				$endSlot=strtotime($sch_end_date);
				if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
				{
					$price=$sch_price;
				}
			}
			$description1=($item['item_other_data_description']);
			$description_li='';
			if($description1!='')
			{
				$description=mysqli_real_escape_string($this->app->set_db_conn(),$description1);
				$description=strip_tags($description);
				$description=str_replace(['\\r', '\\n'], ' ', $description);
				$description=$this->app->utility->string_truncate($description,150);
				$description_li=$description;
			}
			$test_parameters_html=($item['item_description_test_parameters']);
			if($test_parameters_html!='')
			{
				$test_parameters_html=$this->app->utility->string_truncate($test_parameters_html,100);
			}
			$test_parameters_html='';
			
			$inCart=in_array($item['id'], $cartItemIds)?true:false;
	
			$itemInfo[]='Total no.of Tests : '.$test_count;
			$itemInfo[]=$description_li;
			if($test_parameters_html!=''){
			$itemInfo[]=$test_parameters_html;
			}

			$name=$item['name'];
			$item_price_id=$item['item_price_id'];
			$items[]=[
				"itemID"=>$this->app->utility->encrypt($item['id']),
				"priceID"=>$this->app->utility->encrypt($item_price_id),
				"name"=>$name,
				"inCart"=>$inCart,
				"price"=>$price,
				"mrp"=>$mrp>$price?$mrp:'0.00',
				"percentage"=>'',
				"itemInfo"=>$itemInfo
			];
			unset($itemInfo);
		}

		$obj_model_city=$this->app->load_model('city');
		$city=$obj_model_city->execute("SELECT",false,"","id='".$cityID."'");		
		$cityDetail=["ID"=>$this->app->utility->encrypt($city[0]['id']),"name"=>$city[0]['name']];

		$forceUpdate=true;
		$showPopup=false;
		if($appVersion=='1.4'){
			$forceUpdate=false;
			$showPopup=true;
		}
		$appUpdate=["forceUpdate"=>$forceUpdate,"title"=>"Alert","msg"=>"New App available","showPopup"=>$showPopup];

		$otherBanner[]=["imageType"=>"howItWork","actionType"=>"","actionID"=>"","image"=>SERVER_ROOT.'/uploads/otherBanner/how_it_work_image.png'];
		$otherBanner[]=["imageType"=>"certificate","actionType"=>"","actionID"=>"","image"=>SERVER_ROOT.'/uploads/otherBanner/accreditation1.png'];
		$otherBanner[]=["imageType"=>"bottomImage","actionType"=>"","actionID"=>"","image"=>SERVER_ROOT.'/uploads/otherBanner/dashboard_bottom_banner.png'];


		$aboutInfo[]=["name"=>"20 Labs Across 7 State","image"=>SERVER_ROOT.'/uploads/aboutInfo/features.png'];
		$aboutInfo[]=["name"=>"1800+ Touch Points Across India","image"=>SERVER_ROOT.'/uploads/aboutInfo/touch-points.png'];
		$aboutInfo[]=["name"=>"International Reach","image"=>SERVER_ROOT.'/uploads/aboutInfo/international.png'];
		$aboutInfo[]=["name"=>"38+ Year of\nExperience","image"=>SERVER_ROOT.'/uploads/aboutInfo/experience.png'];

		$result=["debug"=>'false',"banner"=>$banner,"diseases"=>$diseases,"category"=>$category,"items"=>$items,"cityDetail"=>$cityDetail,"otherBanner"=>$otherBanner,"aboutInfo"=>$aboutInfo,"appUpdate"=>$appUpdate,"whatsapp"=>"918586988847"];
		$message=array("message"=>"success.","msgCode"=>"1","result"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>