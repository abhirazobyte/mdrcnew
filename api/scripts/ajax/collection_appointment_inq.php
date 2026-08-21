<?php
	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$age = $app->getPostVar("age");
	$city = $app->getPostVar("city");
	$date = $app->getPostVar("date");
	$gender = $app->getPostVar("gender");
	$address = $app->getPostVar("address");
	$brief_details = $app->getPostVar("brief_details");
	$reference = $app->getPostVar("reference");

	if($name!='' && $email!='' && $phone!='')
	{
       	$fields_map = array();	
		$fields_map['name'] = $name;
		$fields_map['email'] = $email;
		$fields_map['phone'] = $phone;
		$fields_map['age'] = $age;
		$fields_map['city'] = $city;
		$fields_map['date'] = $date;
		$fields_map['gender'] = $gender;
		$fields_map['address'] = $address;
		$fields_map['brief_details'] = $brief_details;
		$fields_map['reference'] = $reference;
		$fields_map['user_id'] = $_SESSION['MDRCCustID'];
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['added_date'] =  date('Y-m-d');

		$obj_model_collection_appointment=$app->load_model('collection_appointment');
		$obj_model_collection_appointment->map_fields($fields_map);
		$appointment_id=$obj_model_collection_appointment->execute("INSERT");

		if($appointment_id>0)
		{
			/*------------------Start for mail function------------------*/
			$template_name='collection_appointment_admin';
			$send_data_arary=['appointment_id'=>"#".$appointment_id,'name'=>$name,'phone'=>$phone,'email'=>$email,'age'=>$age,'city'=>$city,'date'=>$date,'gender'=>$gender,'brief_details'=>$brief_details,'reference'=>$reference];
			$subject='New Collection Appointment from '.$name.' on Website';
			$mail_for='Admin';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$app->utility->sendMial($data);
			/*------------------End for mail function------------------*/
			
			echo "0";
			exit;
		}
		else
		{
			echo "1";
			exit;
		}
	}
	else
	{
		
		echo "1";
	}
?>