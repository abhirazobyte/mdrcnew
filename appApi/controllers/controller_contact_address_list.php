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

		if($deviceType!='')
		{
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

				

				$result=["addressList"=>$addressList,"callBlock"=>$callBlock];
				$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
			}
			else
			{
				$result=["addressList"=>[],"callBlock"=>$callBlock];
				$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
			}
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