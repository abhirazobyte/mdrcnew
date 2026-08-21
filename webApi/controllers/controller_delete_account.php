<?
class _delete_account extends controller{
	function init(){
	}
	function onload()
	{
		

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

		if($userID!='' && $userPhone!='' && $deviceType!='')
		{
			$obj_model_record = $this->app->load_model("customer");
			$result=$obj_model_record->execute("SELECT",false,"","id='".$userID."'");
			if(count($result)<=0)
			{
				$response=array("message"=>"Account not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}
			/* $update_field = array();
			$update_field['status'] = $userFirstName;
			$obj_model_user = $this->app->load_model("customer");
			$obj_model_user->map_fields($update_field);
			$obj_model_user->execute("UPDATE",false,"","id='".$userID."'"); */
			$message=array("message"=>'Account Deleted.',"msgCode"=>"1");
		}
		else
		{
			$message=array("message"=>"Data missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>