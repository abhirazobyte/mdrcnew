<?
class _item_detail extends controller {
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$this->app->utility->decrypt($cityID);
		
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);

		$itemID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('itemID'));
		$itemID=$this->app->utility->decrypt($itemID);

		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

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
		
		if($cityID!='')
		{
			$master_con=" and FIND_IN_SET ('".$cityID."',item.city_ids) and item_price.city_id='".$cityID."'";
			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));					
			$rs_data = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.id='".$itemID."' ".$master_con."","item.sort_order ASC limit 0,1","");
			$test=$rs_data[0];

			$price=$test['item_price_price'];
			$mrp=$test['item_price_mrp'];
			
			$sch_price=$test['item_price_sch_price'];
			$sch_start_date=$test['item_price_sch_start_date'];
			$sch_end_date=$test['item_price_sch_end_date'];
		
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

			$item_type=$rs_data[0]['item_other_data_item_type_id'];
			$item_certificate_ids=$rs_data[0]['item_price_item_certificate_ids'];
			
			$certificateList=[];
			if($item_certificate_ids!='')
			{
				$obj_model_all_certif= $this->app->load_model("item_certificate");
				$rs_certi_data = $obj_model_all_certif->execute("SELECT",false,"","item_certificate.id!=0 and item_certificate.id IN (".$item_certificate_ids.")","item_certificate.sort_order ASC","");
				foreach($rs_certi_data as $item)
				{
					$folder = 'item_certificate';
					$image = $this->app->utility->get_image_path($item['image'], $folder, "large");
					$certificateList[]=[
						"image"=>$image,
						"name"=>$item['name']
					];
				}
			}

			//key fetures
			$featureList=[];
			$item_key_fetures_ids=$rs_data[0]['item_other_data_item_key_fetures_ids'];
			if($item_key_fetures_ids!='')
			{
				$obj_model_item_key_fetures= $this->app->load_model("item_key_fetures");
				$rs_key_fetures_data = $obj_model_item_key_fetures->execute("SELECT",false,"","item_key_fetures.id!=0 and item_key_fetures.id IN (".$item_key_fetures_ids.")","item_key_fetures.sort_order ASC","");
				foreach($rs_key_fetures_data as $item)
				{
					$folder = 'item_key_fetures';
					$image = $this->app->utility->get_image_path($item['image'], $folder, "large");
					$featureList[]=[
						"image"=>$image,
						"name"=>$item['name'],
						"subhead"=>$item['subtext']
					];
				}
			}

			if($item_type==1)
			{
				$obj_model_packages = $this->app->load_model("item_package_data");
				$obj_model_packages->join_table("item_description", "left", array(), array("data_id"=>"item_id"));
				$rs_package_data = $obj_model_packages->execute("SELECT",false,"","item_package_data.item_id='".$rs_data[0]['id']."'","");
			}

			//load banner
			$bannerList=[];
			$item_department_ids=explode(',',$rs_data[0]['item_other_data_item_department_ids']);
			if(in_array(1,$item_department_ids) && in_array(2,$item_department_ids)) {
				$banner_con='(show_page="radiology_item" or show_page="pathology_item")';
			} else if(in_array(1,$item_department_ids)) {
				$banner_con='show_page="radiology_item"';
			} else if(in_array(2,$item_department_ids)) {
				$banner_con='show_page="pathology_item"';
			} else {
				$banner_con='show_page=""';
			}
			$obj_model_banner=$this->app->load_model('banner');
			$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and ".$banner_con." and (FIND_IN_SET ('".$cityID."',banner.city_ids) or city_ids='')","sort_id ASC");
			foreach($rs_banner as $banner)
			{
				$folder = 'main_banner_images';
				$image = $this->app->utility->get_image_path($banner['banner_image'], $folder, "large");
				/*$bannerList[]=[
					"image"=>$image
				];*/
				array_push($bannerList,$image);
			}

			$inCart=in_array($test['id'], $cartItemIds)?true:false;

			$itemDetail=[
				"itemID"=>$this->app->utility->encrypt($test['id']),
				"priceID"=>$this->app->utility->encrypt($test['item_price_id']),
				"name"=>$test['name'],
				"subheading"=>'Includes: '. $test['test_count'].' tests',
				"price"=>$price,
				"mrp"=>$mrp>$price?$mrp:'0.00',
				"discount"=>'',
				"inCart"=>$inCart,
			];

			$itemHeading=$test['item_other_data_item_department_ids']==1?"Test Remark":"Test Parameters";

			if($test['item_other_data_item_type_id']==1) {

				for($i=0;$i<count($rs_package_data);$i++){ 
					$html='';
					if($rs_package_data[$i]['item_description_sample_remark']!='') {
						$html.='<p> <strong>Sample Remark</strong> : '.$rs_package_data[$i]['item_description_sample_remark'].'</p>';
					}
					if($rs_package_data[$i]['item_description_sample_type_name']!='') {
						$html.='<p> <strong>Sample Type</strong> : '.$rs_package_data[$i]['item_description_sample_type_name'].'</p>';
					}
					if($rs_package_data[$i]['item_description_sample_remark1']!='') {
						$html.='<p> <strong>Sample Remark</strong> : '.$rs_package_data[$i]['item_description_sample_remark1'].'</p>';
					}
					if($rs_package_data[$i]['item_description_test_parameters']!='') {
						$html.='<p> <strong>Test Parameters</strong> : '.$rs_package_data[$i]['item_description_test_parameters'].'</p>';
					}
					$itemTabs[]=["tabName"=>$rs_package_data[$i]['item_description_item_name'],"tabDesc"=>$html];
					$html='';
				}

			} else {
				$html='';
				if($test['item_description_sample_remark']!='') {
					$html.='<p> <strong>Sample Remark</strong> : '.$test['item_description_sample_remark'].'</p>';
				}
				if($test['item_description_sample_type_name']!='') {
					$html.='<p> <strong>Sample Type</strong> : '.$test['item_description_sample_type_name'].'</p>';
				}
				if($test['item_description_sample_remark1']!='') {
					$html.='<p> <strong>Sample Remark</strong> : '.$test['item_description_sample_remark1'].'</p>';
				}
				if($test['item_description_test_parameters']!='') {
					$html.='<p> <strong>Test Parameters</strong> : '.$test['item_description_test_parameters'].'</p>';
				}
				$itemTabs[]=["tabName"=>$test['item_description_item_name'],"tabDesc"=>$html];
				$html='';
			}

			$descList=["title"=>"Description","desc"=>$test['item_other_data_description']];

			$callBlock=["heading"=>"Need help with booking your test?","callHeading"=>"Our experts are here to help you","call"=>"+91-124-6712000","whatsappHeading"=>"Whatsapp Chat with MDRC Expert","whatsapp"=>"+91-8586988847"];

			$result=["bannerList"=>$bannerList,"certificateList"=>$certificateList,"featureList"=>$featureList,"itemDetail"=>$itemDetail,"itemTabs"=>$itemTabs,"itemHeading"=>$itemHeading,"descList"=>$descList,"callBlock"=>$callBlock];
			$message=array("message"=>"success","msgCode"=>"1","result"=>$result);
		}
		else
		{
			$message=array("message"=>"Date missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>