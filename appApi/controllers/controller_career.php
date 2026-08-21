<?
class _career extends controller
{
	function init()
	{
	}

	function onload()
	{
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";

		$name = $this->app->getPostVar("name");
		$email = $this->app->getPostVar("email");
		$phone = $this->app->getPostVar("phone");
		$notice_period = $this->app->getPostVar("notice_period");
		$designation = $this->app->getPostVar("designation");
		$current_organization = $this->app->getPostVar("current_organization");
		$experience = $this->app->getPostVar("experience");
		$address = $this->app->getPostVar("address");
		$job_opening_id ='1';

		if($name!='' && $email!='' && $phone!='' && $job_opening_id!='')
		{
			$fields_map = array();
			if(!empty($_FILES['cv_file1']['name']))
			{
				$fields_map['cv_file'] = $this->app->utility->other_upload_file(['path'=>"/uploads/job_opening_cv",'file'=>$_FILES['cv_file1']]);
			}		
			$fields_map['job_opening_id'] = $job_opening_id;
			$fields_map['name'] = $name;
			$fields_map['email'] = $email;
			$fields_map['phone'] = $phone;
			$fields_map['notice_period'] = $notice_period;
			$fields_map['designation'] = $designation;
			$fields_map['current_organization'] = $current_organization;
			$fields_map['experience'] = $experience;
			$fields_map['address'] = $address;
			$fields_map['user_id'] = $_SESSION['MDRCCustID'];
			$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
			$fields_map['added_date'] =  date('Y-m-d');

			$obj_model_job_opning_inq=$this->app->load_model('job_opening_inq');
			$obj_model_job_opning_inq->map_fields($fields_map);
			$obj_model_job_opning_inq->execute("INSERT");

			$message=array("message"=>"success.","msgCode"=>"1");
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