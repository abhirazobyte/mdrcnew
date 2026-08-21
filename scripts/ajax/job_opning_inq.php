<?php
	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$notice_period = $app->getPostVar("notice_period");
	$designation = $app->getPostVar("designation");
	$current_organization = $app->getPostVar("current_organization");
	$experience = $app->getPostVar("experience");
	$address = $app->getPostVar("address");
	$job_opening_id = $app->getPostVar("job_opening_id");

	if($name!='' && $email!='' && $phone!='' && $job_opening_id!='')
	{

       	$fields_map = array();	
       	$fields_map['job_opening_id'] = $job_opening_id;
		$fields_map['name'] = $name;
		$fields_map['email'] = $email;
		$fields_map['phone'] = $phone;
		$fields_map['notice_period'] = $notice_period;
		$fields_map['designation'] = $designation;
		$fields_map['current_organization'] = $current_organization;
		$fields_map['experience'] = $experience;
		$fields_map['address'] = $address;

		if(!empty($_FILES['cv_file1']['name']))
		{
			
			$fields_map['cv_file'] = $app->utility->other_upload_file(['path'=>"/uploads/job_opening_cv",'file'=>$_FILES['cv_file1']]);
		}

		$fields_map['user_id'] = $_SESSION['MDRCCustID'];
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['added_date'] =  date('Y-m-d');

		$obj_model_job_opning_inq=$app->load_model('job_opening_inq');
		$obj_model_job_opning_inq->map_fields($fields_map);
		$obj_model_job_opning_inq->execute("INSERT");

		$obj_model_job_opening=$app->load_model('job_opening');
		$re=$obj_model_job_opening->execute("SELECT",false,"","id=".$job_opening_id);


		/*------------------Start for mail function------------------*/
		$template_name='job_apply_to_admin';
		$subject='1 New Job Apply for '.$re[0]['title'].' on '.date('d-m-Y');
		$send_data_arary=['email'=>$email,'name'=>$name,'phone'=>$phone,'experience'=>$experience,'subject'=>$subject];
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
	}
?>