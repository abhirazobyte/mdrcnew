<?
class _UploadPrescription extends controller
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
		$age = $this->app->getPostVar("age");
		$city = $this->app->getPostVar("city");
		$dob = $this->app->getPostVar("dob");
		$gender = $this->app->getPostVar("gender");
		$address = $this->app->getPostVar("address");
		$brief_details = $this->app->getPostVar("prescriptionDetails");

		if($name!='' && $email!='' && $phone!='')
		{
			$fields_map = array();
			if(!empty($_FILES['uploadPrescriptionFile']['name']))
			{
				$upload_dir='test_booking_file';
				//Image Edit
				$file_image=move_uploaded_file($_FILES['uploadPrescriptionFile']['tmp_name'],'../uploads/'.$upload_dir.'/'.$_FILES['uploadPrescriptionFile']['name']);	
				$fields_map['file']=$file_image;
			}			

			$fields_map['name'] = $name;
			$fields_map['email'] = $email;
			$fields_map['phone'] = $phone;
			$fields_map['age'] = $age;
			$fields_map['city'] = $city;
			$fields_map['date'] = $dob;
			$fields_map['gender'] = $gender;
			$fields_map['address'] = $address;
			$fields_map['brief_details'] = $brief_details;
			$fields_map['user_id'] = $userID!=''?$userID:"";
			$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
			$fields_map['added_date'] =  date('Y-m-d');

			$obj_model_prescription_booking=$this->app->load_model('test_booking_enquiry');
			$obj_model_prescription_booking->map_fields($fields_map);
			$obj_model_prescription_booking->execute("INSERT");

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