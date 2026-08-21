<?php
	
	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$company = $app->getPostVar("company");
	$message = $app->getPostVar("message");

	if($name!='' && $phone!='' && $email!='')
	{
		/* $fields_map = array();
		$fields_map['name'] = $name;
		$fields_map['email'] = $email;
		$fields_map['phone'] = $phone;
		$fields_map['age'] = $age;
		$fields_map['city'] = $city;
		$fields_map['date'] = $date;
		$fields_map['gender'] = $gender;
		$fields_map['address'] = $address;
		$fields_map['brief_details'] = $brief_details;
		$fields_map['user_id'] = $_SESSION['MDRCCustID'];

		if($enquiry_type!='' && $test_type!=''){
			$fields_map['enquiry_type'] = $enquiry_type;
			$fields_map['test_type'] = $test_type;
		}
		
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['added_date'] =  date('Y-m-d');

		$obj_model_prescription_booking=$app->load_model('test_booking_enquiry');
		$obj_model_prescription_booking->map_fields($fields_map);
		$booking_id=$obj_model_prescription_booking->execute("INSERT"); */

		/*------------------Start for mail function------------------*/
		$template_name='corporate_tieup_admin';
		$send_data_arary=['name'=>$name,'phone'=>$phone,'email'=>$email,'company'=>$company,'message'=>$message];

		$subject='New Corporate Tieup Enquiry from '.$name;
		$mail_for='corporate_tieup';
		$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
		$app->utility->sendMial($data);
		/*------------------End for mail function------------------*/

		echo "0";
		exit;	
	}
	else
	{
		echo "1";
	}
?>