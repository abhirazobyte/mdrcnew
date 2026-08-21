<?php
	$c_email = $app->getPostVar("email");
	if($c_email!='')
	{
		$obj_model_newsletter_rs=$app->load_model('newsletter_receiver');
		$rs_data=$obj_model_newsletter_rs->execute("SELECT",false,"","email='".$c_email."'");
		if(count($rs_data)>0)
		{
			echo 2;
			exit;
		}

       	$fields_map = array();	
		$fields_map['email'] = $c_email;
		$fields_map['registration_date'] =  date('Y-m-d');

		$obj_model_newsletter=$app->load_model('newsletter_receiver');
		$obj_model_newsletter->map_fields($fields_map);
		$newsletter_id=$obj_model_newsletter->execute("INSERT");

		if($newsletter_id>0)
		{
			/*------------------Start for mail function------------------*/
			$template_name='subscribe_newsletter_admin';
			$send_data_arary=['email'=>$c_email];
			$subject='Newsletter Subscriber on Website';
			$mail_for='Admin';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$app->utility->sendMial($data);
			/*------------------End for mail function------------------*/
			
			echo "0";
			exit;
		}
		else
		{
			echo "0";
			exit;
		}
	}
	else
	{
		
		echo "1";
	}
?>