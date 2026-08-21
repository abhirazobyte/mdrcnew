<?
class _member_addedit extends controller{
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));

		$memberID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('memberID'));
		$memberID=$memberID!=''?$this->app->utility->decrypt($memberID):"";

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";

		$stateID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('stateID'));
		$stateID=$stateID!=''?$this->app->utility->decrypt($stateID):"";

		$first_name=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("first_name"));
		$line1=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("line1"));
		$area=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("area"));
		$phone1=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("phone1"));

		if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='memberAddEdit')
		{
			$obj_model_customer= $this->app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			if($memberID!='') {
				$obj_model_customer= $this->app->load_model("customer_members");
				$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$memberID."'");
				if(count($rs_user)<=0)
				{
					$response=array("message"=>"Customer Member not found.","msgCode"=>"0");
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit; 
				}
			}

			if($cityID=='' || $stateID=='' || $first_name=='' || $line1=='' || $area=='' || $phone1=='') {
				$response=array("message"=>"Please Enter Required Data.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$update_field = array();
			$update_field['city_id'] = $cityID;
			$update_field['state_id'] = $stateID;
			$obj_model_user = $this->app->load_model("customer_members");
			
			if($memberID!='') {
				$obj_model_user->map_fields($update_field);
				$obj_model_user->execute("UPDATE",false,"","id='".$memberID."'");
				$message="Member Profile Updated.";
			}else {
				$update_field['entry_date_time']=date('d-m-Y H:i:s');
				$update_field['status']='Active';
				$update_field['customer_id']=$userID;
				$obj_model_user->map_fields($update_field);
				$memberID=$obj_model_user->execute("INSERT");
				$message="Member Profile Added.";
			}
			$result=["memberID"=>$this->app->utility->encrypt($memberID)];
			$message=array("message"=>$message,"msgCode"=>"1","result"=>$result);
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='memberDelete' && $memberID!='')
		{
			$obj_model_customer= $this->app->load_model("customer_members");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$memberID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Customer Member not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$update_field = array();
			$update_field['status'] = 'Trash';
			$obj_model_customer->map_fields($update_field);
			$obj_model_customer->execute("UPDATE",false,"","id='".$memberID."'");

			$message=array("message"=>"Member Deleted Successfully.","msgCode"=>"1");
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='memberList')
		{
			$obj_model_customer= $this->app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model_customer= $this->app->load_model("customer_members");
			$obj_model_customer->join_table("city", "left", array(), array("city_id"=>"id"));
			$obj_model_customer->join_table(["city"=>"city","state"=>"state"], "left", array(), array("state_id"=>"id"));
			$rs_user=$obj_model_customer->execute("SELECT",false,"","customer_members.customer_id='".$userID."' and customer_members.status='Active'");
			if(count($rs_user)>0)
			{
				foreach($rs_user as $item)
				{
					$memberList[]=[
						"memberID"=>$this->app->utility->encrypt($item['id']),
						"prefix"=>$item['prefix'],
						"first_name"=>$item['first_name'],
						"last_name"=>$item['last_name'],
						"gender"=>$item['gender'],
						"phone1"=>$item['phone1'],
						"relation"=>$item['relation'],
						"age"=>$this->app->utility->getAge($item['dob']),
						"dob"=>$item['dob'],
						"line1"=>$item['line1'],
						"area"=>$item['area'],
						"pincode"=>$item['pincode'],
						"cityID"=>$this->app->utility->encrypt($item['city_id']),
						"stateID"=>$this->app->utility->encrypt($item['state_id']),
						"cityName"=>$item['city_name'],
						"stateName"=>$item['state_name'],
					];
				}
			} else {
				$memberList=[];
			}

			$result=["memberList"=>$memberList];
			$response=array("message"=>"success.","msgCode"=>"1","result"=>$result);
			$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
			$final_response=$this->app->utility->indent($opt);
			echo $final_response; exit; 
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