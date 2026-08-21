<?php
	$name = $app->getPostVar("name");
	$phone = $app->getPostVar("phone");
	$city = $app->getPostVar("city");

	if($name!='' && $phone!='')
	{

       	$fields_map = array();	
		$fields_map['name'] = $name;
		$fields_map['city'] = $city;
		$fields_map['phone'] = $phone;
		$fields_map['entry_from'] = 'Connect us';
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['date'] =  date('Y-m-d');
		$fields_map['status'] = 'Pending';

		$obj_model_newsletter=$app->load_model('help');
		$obj_model_newsletter->map_fields($fields_map);
		$obj_model_newsletter->execute("INSERT");

		echo "0";
		exit;

		// /*mail*/
		// $obj_model_admin=$app->load_model('admin');
		// $re_admin=$obj_model_admin->execute("SELECT",false,"","","");
		
		// $obj_model_gs=$app->load_model('generel_settings');
		// $re_data=$obj_model_gs->execute("SELECT",false,"","","");
		
		// $mail_title=$re_data[0]['project_title'];
	 	// $mail_header=$app->utility->web_mail_header();
  		// $mail_footer=$app->utility->web_mail_footer();
				
		// $to =  $re_admin[0]['email'];
		// $obj_mailer = $app->load_module("mailer\sender");
		// $mail_body = $app->utility->ParseMailTemplate("contact.html", array("title"=>$mail_title,"header"=>$mail_header,"footer"=>$mail_footer,"c_email"=>$c_email, "name"=>$name, "subject"=>$subject, "message"=>$message, ));
		// if($mail_body==NULL){
		// 	$app->display_error(NULL, "Could not parse the mail template");
		// }
		// $obj_mailer->create();
		// $obj_mailer->subject("New Inquiry From ".$mail_title);
		// $obj_mailer->add_to($re_admin[0]['email']);
		// $obj_mailer->htmlbody($mail_body);						
		// //$flag = $obj_mailer->send();
		// echo "0";
		// exit;
		// if($flag)
		// {
		// 	echo "0";
		// }
		// else
		// {
		// 	echo "1";
		
		
		// }
	}
	else
	{
		
		echo "1";
	}
?>