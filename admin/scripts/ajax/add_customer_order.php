<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType='customer_addedit';
$actionType='customer_addedit';


//Function for zipcode addedit
if($actionType=="customer_addedit")
{
			$name=$app->getPostVar("u_name");
			$email=$app->getPostVar("u_email");
			$phone=$app->getPostVar("u_phone");
			$address=$app->getPostVar("u_address");
			$area_id=$app->getPostVar("u_area_id");
			$zipcode=$app->getPostVar("u_pincode");
			$city=$app->getPostVar("u_city");
			$state=$app->getPostVar("u_state");
			
			
	if($name!='' && $phone!='' && $address!='' && $area_id!='' && $zipcode!='' && $city!='' && $state!='')
		{
		
		
		
		$obj_model_user = $app->load_model("user");
		$rs_data = $obj_model_user->execute("SELECT",false,"","mobilephone='".$phone."'");
		if(count($rs_data)>0)
		{
			$msg='Phone Number is already registered with some account!';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}
		
		
		
		if($email!='')
		  {
			  $obj_model_user = $app->load_model("user");
			  $rs_data = $obj_model_user->execute("SELECT",false,"","email='".$email."'");
			  if(count($rs_data)>0)
			  {
				  
				  $msg='Email Address is already registered with some account!';
				  $msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				  
				  
			  }
		  }
		  
		  
					
					$obj_model_registration_wallet=$app->load_model("registration_wallet");
					$rs_registration_wallet=$obj_model_registration_wallet->execute("SELECT",false,"","");
					$wallet=$rs_registration_wallet[0]['amount'];
					$areaname=$app->utility->getarea_name($area_id);
					$pass=$app->utility->random_password(7);;
					$otp=$app->utility->generate_OTP(4);
					
					$update_field = array();
					$update_field['group_id']=1;
					$update_field['registration_date']=date('d/m/Y H:i:s');
					$update_field['otp_code']=$otp;
					$update_field['otp_verified']='Yes';
					$update_field['login_password']=base64_encode($pass);
					$update_field['registered_with']='admin';
					$update_field['wallet']=$wallet;
					$update_field['area_name']=$areaname;
					$update_field['ref_key']=$app->utility->keygen(6);
					$update_field['name']=$name;
					$update_field['email']=$email;
					$update_field['mobilephone']=$phone;
					$update_field['billing_address_line1']=$address;
					$update_field['area_id']=$area_id;
					$update_field['billing_zip_code']=$zipcode;
					$update_field['billing_city']=$city;
					$update_field['billing_state']=$state;
					$update_field['billing_country']='India';
					$obj_model_user = $app->load_model("user");
					$obj_model_user->map_fields($update_field);
					$ins=$obj_model_user->execute("INSERT");
					
					
					$customer_id=$ins;
					// SMS code for user
						if($phone!="" && $wallet>0)
						{
							$phone=$phone;
							$name=$name;
							$sms_type='WELCOME_SMS';
							$default_string = array("{amount}","{name}");
							$new_string   = array($wallet,$name);
							$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
						}
						// Entry into wallet transaction
						if($wallet>0)
						{
							$obj_model_wallet_transaction=$app->load_model("wallet_transaction");
							$data_t=array();
							$data_t['user_id']=$ins;
							$data_t['name']=$name;
							$data_t['email']=$email;
							$data_t['phone']=$phone;
							$data_t['address']=$address;
							$data_t['zipcode']=$zipcode;
							$data_t['city']=$city;
							$data_t['amount']=$wallet;
							$data_t['type']='Plus';
							$data_t['payment_with']='Website';
							$data_t['transaction_date']=date('d-m-Y H:i:s A');
							$data_t['remark']='Welcome Reward';
							$data_t['transction_type']='Wallet';
							$data_t['ip_address']=$app->utility->get_client_ip();
							$obj_model_wallet_transaction->map_fields($data_t);
							$obj_model_wallet_transaction->execute("INSERT");
						}
					if($email!='')
					{
					$mail_title=$app->gs['project_title'];
					$contact_email=$app->gs['contact_email'];
					$mail_header=$app->utility->web_mail_header();
					$mail_footer=$app->utility->web_mail_footer();
					$subject = "Registration confirmation from ".$mail_title;
					 $obj_mailer = $app->load_module("mailer\sender");
					 $mail_body = $app->utility->ParseMailTemplate("register.html", array("title"=>$mail_title,"header"=>$mail_header,"footer"=>$mail_footer,"username"=>$name,"email"=>$email,"password"=>$pass,"server_root"=>SERVER_ROOT,"contact_email"=>$contact_email));
					 if($mail_body==NULL)
					 {
						$app->display_error(NULL, "Could not parse the mail template");
					 }
					 $obj_mailer->create();
					 $obj_mailer->subject($subject);
					 $obj_mailer->add_to($email);
					 $obj_mailer->htmlbody($mail_body);
					 $flag = $obj_mailer->send();
					}
					
					
		
		
		
		
			$msg="Record ".$update_title." Successfully.";
			$msgcode=0;
		 
	}
	else
	{
			$msg='Please Fill Require Data';
			$msgcode=1;
			$customer_id=0;
			
	}
}



		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg,"customer_id"=>$customer_id));
?>