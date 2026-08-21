<?
class _help extends controller{
	function init(){
	}
	function onload()
	{
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID==''?"MQ==":$this->app->utility->decrypt($cityID);

		$helpScreen[]=[
			"image"=>"https://www.mdrcindia.com/images/help-support.png",
			"title"=>"We're here to help!",
			"description"=>"If you have any queries related to any of our tests or packages, you can contact us on the below mentioned phone number or email.",
			"call"=>"+91-124-6712000",
			"email"=>"info@mdrcindia.com",
			"whatsapp"=>"918586988847"
		];
		
		$result=["helpScreen"=>$helpScreen];
		$message=array("message"=>"success","msgCode"=>"1","result"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>