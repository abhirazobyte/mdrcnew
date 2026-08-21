<?
class _contact_address_list extends controller {
	function init(){
	}
	function onload()
	{
		$callBlock=[
			"heading"=>"Need help with booking your test?",
			"callHeading"=>"Our experts are here to help you",
			"call"=>"+91-124-6712000",
			"whatsappHeading"=>"Whatsapp Chat with MDRC Expert",
			"whatsapp"=>"+91-8586988847",
			"email"=>"info@mdrcindia.com"
		];
		
		$ip=$_SERVER['REMOTE_ADDR'];
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$city_id=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("city_id"));
		$cityID=$city_id!=''?$this->app->utility->decrypt($city_id):'';

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='contact_us' and status!='Trash'");
		
		$cond='';
		if($cityID!=''){
			$cond=' and city_id="'.$cityID.'"';
		}
		$obj_model_table= $this->app->load_model("branch");
		$rs_branch= $obj_model_table->execute("SELECT",false,"","status='Active'".$cond,"sort_order ASC");
		if(count($rs_branch)>0)
		{
			foreach($rs_branch as $item) {
				$addressList[]=[
					"name"=>$item['name'],
					"city_id"=>$this->app->utility->encrypt($item['city_id']),
					"address"=>nl2br($item['address']),
					"phone1"=>$item['phone1'],
					"phone2"=>$item['phone2'],
					"email1"=>$item['email1'],
					"email2"=>$item['email2'],
					"mapUrl"=>$item['business_url'],
					"latitude"=>$item['latitude']!=''?$item['latitude']:"",
					"longitude"=>$item['longitude']!=""?$item['longitude']:""
				];
			}

			$result=[
				"meta_title" => $meta_data[0]['page_title'],
				"meta_keyword" => $meta_data[0]['meta_keywords'],
				"meta_description" => $meta_data[0]['meta_description'],
				"meta_schema" => $meta_data[0]['meta_schema'],
				"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
				"addressList"=>$addressList,
				"callBlock"=>$callBlock
			];
			$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
		}
		else
		{
			$result=[
				"meta_title" => $meta_data[0]['page_title'],
				"meta_keyword" => $meta_data[0]['meta_keywords'],
				"meta_description" => $meta_data[0]['meta_description'],
				"meta_schema" => $meta_data[0]['meta_schema'],
				"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
				"addressList"=>[],
				"callBlock"=>$callBlock
			];
			$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
		}
		
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
	
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>