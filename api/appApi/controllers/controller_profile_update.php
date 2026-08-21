<?
class _profile_update extends controller{
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

		$userFirstName=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("userFirstName"));
		$userLastName=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("userLastName"));
		$userEmail=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("userEmail"));
		
		if($userID!='' && $userPhone!='' && $deviceType!='' && $userFirstName!='' && $userLastName!='' && $userEmail!='')
		{
			if($userEmail!='')
			{
				$cond="and (email='".$userEmail."')";
				$obj_model_customer= $this->app->load_model("customer");
				$rs_user=$obj_model_customer->execute("SELECT",false,"","id!='".$userID."' ".$cond."");
				if(count($rs_user)>0)
				{
					$response=array("message"=>"Mobile Number and Email already exists.","msgCode"=>"0");
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit; 
				}
			}

			$obj_model_record = $this->app->load_model("customer");
			$result=$obj_model_record->execute("SELECT",false,"","id='".$userID."'");

			$update_field = array();
			if(!empty($_FILES['userImage']['name']))
			{
				
				$upload_dir='customer';
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
					@unlink('../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);
				}	
				
				$image=$this->app->utility->resize_multi_image_2020($_FILES['userImage']['name'],$_FILES['userImage']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000','750','350');
				$update_field['image']=$image;
			}	

			$update_field['name'] = $userFirstName;
			$update_field['last_name'] = $userLastName;
			$update_field['email'] = $userEmail;
			$obj_model_user = $this->app->load_model("customer");
			$obj_model_user->map_fields($update_field);
			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$userID."'");
			if($rs>0)
			{
				$folder='customer';
				$image=$this->app->utility->get_image_path($image,$folder,'large');

				$customer=array("userID"=>$this->app->utility->encrypt($result[0]["id"]),"userFirstName"=>$userFirstName,"userLastName"=>$userLastName,"userEmail"=>$userEmail,"userPhone"=>$userPhone,"userImage"=>$image,"actionType"=>"");
				$result=["customer"=>$customer];
				$message=array("message"=>'Profile Updated.',"msgCode"=>"1","result"=>$result);
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