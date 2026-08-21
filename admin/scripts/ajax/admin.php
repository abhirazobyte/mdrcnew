<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$actionType=$app->getPostVar("actionType");


//Function for admin forget password

if($actionType=="adminForgotPass")

{

	//admin forget password

	$forgotEmail=$app->getPostVar("forgotEmail");

	if($forgotEmail!='')

	{

		$obj_model_user = $app->load_model("admin");

		$admin= $obj_model_user->execute("SELECT",false,"","(email='".$forgotEmail."') and status='Active'");

		if(count($admin)>0)

		{

			$phone=$admin[0]['phone'];

			$pass=$admin[0]['login_password'];

			$name=$admin[0]['login_username'];

			$email=$admin[0]['email'];



			$type='Admin';

			$subject = "The Design - Admin Login Detail";

			$to=$email;

			

			$header=$app->utility->web_mail_header();

			$footer=$app->utility->web_mail_footer();

			

			$obj_mailer = $app->load_module("mailer\sender");

			$mail_body = $app->utility->ParseMailTemplate("panel_forgot_password.html", array("email"=>$email,"name"=>$name,"password"=>$pass,"type"=>$type,"header"=>$header,"footer"=>$footer,"server_root"=>SERVER_ROOT));

				

			if($mail_body==NULL)

			{

				$app->display_error(NULL, "Could not parse the mail template");

			}

			$obj_mailer->create();

			$obj_mailer->subject($subject);

			$obj_mailer->add_to($email);

			$obj_mailer->htmlbody($mail_body);						

			$flag = $obj_mailer->send();

			

			$msg='Password sent to Your Email Address.';

			$msgcode='0';

		}

		else

		{

			//email not found

			$msg="We couldn't find a user with that email address.";

			$msgcode='1';

		}

	}

	else

	{

		//email is blank

		$msg="We couldn't find a user with that email address.";

		$msgcode='1';

	}

}



//Function for admin login

if($actionType=="adminLogin")

{

	$loginEmail=$app->getPostVar("loginEmail");

	$loginPass=$app->getPostVar("loginPass");

	$loginRemember=$app->getPostVar("loginRemember");

	

	if($loginEmail!='' && $loginPass!='')

	{

		$obj_model_admin = $app->load_model("admin");

		$rsUser = $obj_model_admin->execute("SELECT",false,"","(phone='".$loginEmail."' or email='".$loginEmail."') and login_password='".$loginPass."' and status='Active'");



		if(count($rsUser)==1)
		{

			$_SESSION['admin'] = $rsUser[0]['id'];

			$_SESSION['adminName'] = $rsUser[0]['login_username'];
			
			//set cookie
			if($loginRemember!='')
			{
				setcookie("Grocery", $loginEmail, time() + 3600, '/');
			}

			$browser=$app->utility->detect_browser();

			$update_field1 = array();

			$update_field1['user_id'] = $rsUser[0]['id'];

			$update_field1['date'] = date('d-m-Y H:i:s');
			
			
			$update_field1['browser'] =$browser;
			
		

			$update_field1['ip'] = $_SERVER['REMOTE_ADDR'];



			$obj_model_admin_logins= $app->load_model("user_logins_admin");		

			$obj_model_admin_logins->map_fields($update_field1);

			$obj_model_admin_logins->execute("INSERT", false, "", "");



			$msg='Login Sucessfully.';

			$msgcode='0';

		}

		else

		{

			//email is blank

			$msg="Please enter correct login details.";

			$msgcode='1';

		}

	}

	else

	{

		//email is blank

		$msg="We couldn't find a user with that email address.";

		$msgcode='1';

	}

}



//Function for admin logout

if($actionType=="adminLogout")

{

	unset($_SESSION['admin']);

	unset($_SESSION['adminName']);


	unset($_COOKIE['Grocery']);

	setcookie("Grocery", "", time() - 3600, "/");



	$msg='Logout Sucessfully.';

	$msgcode='0';

		

}



//if action blank

if($actionType=="")

{

	$msg="We couldn't find any valid call.";

	$msgcode='1';

}

		

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>