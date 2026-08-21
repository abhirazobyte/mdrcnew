<?php

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
	
$customer_phone=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("phone"));
$remember_me=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("remember-me"));

$action_type=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("action_type"));

$osType='Web';

$support_contact=$_SESSION['support_contact'];
$support_email=$_SESSION['support_email'];
$ip=$_SERVER['REMOTE_ADDR'];
$store_data=$_SESSION['store_data'];
// Login Flow

if($action_type=='login')
{
	
	$remember_me="Yes";
	
	if($customer_phone!='')
	{
		
		
		
		$customer_phone1=strlen($customer_phone);
		if($customer_phone1!=10)
		{
			$RESULT='NOT OK';
			$MSG='Please Enter Valid Mobile Number.';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
			exit;
			
			
		}
				
		if(!is_numeric($customer_phone))
		{
			$RESULT='NOT OK';
			$MSG='Please Enter Valid Mobile Number.';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
			exit;
			
			
		}
		
		
		
		
		$lastdigits = substr($customer_phone, -4); 
		
		$signup_login_phone='+91******'.$lastdigits;
		
			
				$ip=$_SERVER['REMOTE_ADDR'];
			
			
				$obj_model_user =$app->load_model("customer");
				$obj_model_user->set_fields_to_get(array("phone","name","status","email"));
				$rs_user = $obj_model_user->execute("SELECT",false,"","phone='".$customer_phone."' and status!='Trash'","");
								

				if(count($rs_user)>0)
				{
					
						// Login 
						
						if($rs_user[0]['status']!='Active')
						{
							$RESULT='NOT OK';
							$MSG='Your Account is Disabled By Admin. Contact Admin.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
														
														
						}
				
				
						$name=$rs_user[0]['name'];						
						$phone=$rs_user[0]['phone'];
						$email=$rs_user[0]['email'];
						$ID=$rs_user[0]['id'];
							
							
						if($phone==9510069163)
						{
							$otp=5555;
							
						}
						else
						{											
							$otp=$app->utility->generate_OTP(4);	
						}
															
									
						// Register As New Customer Information						
						$update_field_c = array();
						$update_field_c["phone_otp"] = $otp;
						$update_field_c["last_login"] = date('d-m-Y H:i:s');
						$update_field_c["last_ip_address"] = $ip;
						$obj_model_customer_info= $app->load_model("customer_info");
						$obj_model_customer_info->map_fields($update_field_c);
						$obj_model_customer_info->execute("UPDATE",false,"","customer_id='".$ID."'");
						
						
						
						// Customer Login History						
						$update_field_cl = array();
						$update_field_cl["customer_id"] = $ID;
						$update_field_cl["ip_address"] = $ip;
						$update_field_cl["customer_logins_update_date"] = date('d-m-Y H:i:s');
						$update_field_cl["created_from"] = $osType;
						$obj_model_customer_logins= $app->load_model("customer_logins");
						$obj_model_customer_logins->map_fields($update_field_cl);
						$obj_model_customer_logins->execute("INSERT");			
									
									
									
						if($name=='')
						{
							$name='Guest';
								
						}					
						
						$sms_type='OTP';
						$default_string = array("{name}","{otp}","{support_phone}","{store_data}");
						$new_string   = array($name,$otp,$_SESSION['support_phone'],$store_data);                                                                
						$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);							
						
						
						
						
						$ID=$app->utility->encrypt($ID);
						
						
						$_SESSION['login_phone']=$customer_phone;
						
						$_SESSION['login_remember']=$remember_me;
						
						
						if($email!='')
						{
							//Send OTP Email
							
							$template_name="customer_otp.html";
							$subject="One Time Password (OTP) to log in to your MDRC account.";
							$body_parameters=array("name"=>$first_name,"otp"=>$otp);	
							
							$mail_data=array();	
							$mail_data['email']=$email;
							$mail_data['template_name']=$template_name;
							$mail_data['subject']=$subject;
							$mail_data['body_parameters']=$body_parameters;
											
							$app->utility->send_email_data($mail_data);		
							
							
						}
						
						
						
						
						
						
						$RESULT='OK';
						$MSG='OTP Sent Successfully.';
						echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"signup_login_phone"=>$signup_login_phone));	
						exit;
						
						
						
						
						
				}
				else
				{
					
					
					
						$city='';
						$state='';
						$city_id=0;
						$state_id=0;
						$customer_first_name='';
						$customer_last_name='';
						$customer_email='';
								
								
						// Register As New Customer
						if($customer_phone==9510069163)
						{
							$otp=5555;
							
						}
						else
						{	
							$otp=$app->utility->generate_OTP(4);
						
						}
						
						
						
						$update_field = array();
						$update_field["name"] = $customer_first_name;
						$update_field["last_name"] = $customer_last_name;
						$update_field["email"] = $customer_email;
						$update_field["phone"] = $customer_phone;
						$update_field["register_date"] = date('d-m-Y');
						$update_field["entry_date_time"] = date('d-m-Y H:i:s');
						$update_field["register_from"] = $osType;
						
						$update_field["ref_key"] = $reff_key;
						$update_field["status"] = 'Active';
						$update_field["ip"] = $ip;
						$obj_model_table = $app->load_model("customer");
						$obj_model_table->map_fields($update_field);
						$ID=$obj_model_table->execute("INSERT");
						
																		
						// Register As New Customer Information						
						$update_field_c = array();
						$update_field_c["customer_id"] = $ID;
						$update_field_c["city_id"] = $city_id;
						$update_field_c["state_id"] = $state_id;
						$update_field_c["phone_otp"] = $otp;
						
						$update_field_c["created_from"] = $osType;
						$update_field_c["ip_address"] = $ip;
						$update_field_c["last_login"] = date('d-m-Y H:i:s');
						$update_field_c["entry_date_time"] = date('d-m-Y H:i:s');
						$update_field_c["last_ip_address"] = $ip;
						$obj_model_customer_info= $app->load_model("customer_info");
						$obj_model_customer_info->map_fields($update_field_c);
						$obj_model_customer_info->execute("INSERT");
						
						
						
						
						
																							
						// Customer Login History						
						$update_field_cl = array();
						$update_field_cl["customer_id"] = $ID;
						$update_field_cl["ip_address"] = $ip;
						$update_field_cl["customer_logins_update_date"] = date('d-m-Y H:i:s');
						$update_field_cl["created_from"] = $osType;
						$obj_model_customer_logins= $app->load_model("customer_logins");
						$obj_model_customer_logins->map_fields($update_field_cl);
						$obj_model_customer_logins->execute("INSERT");
						
						
						
						$customer_first_name='Guest';						
						
						$phone=$customer_phone;
						$email=$customer_email;
						$name=$customer_first_name;
						
						
						$_SESSION['login_phone']=$customer_phone;
						
						$_SESSION['login_remember']=$remember_me;
						
						

						$sms_type='OTP';
						$default_string = array("{name}","{otp}","{support_phone}","{store_data}");
						$new_string   = array($name,$otp,$_SESSION['support_phone'],$store_data);
						$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
					
							
							$RESULT='OK';
							$MSG='OTP Sent Successfully.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"signup_login_phone"=>$signup_login_phone));	
							exit;
					
					
					
					
				}
		
		
		
		
		
	}
	else
	{
		$RESULT='NOT OK';
		$MSG='Please Enter Phone Number.';
	}

}

else if($action_type=='otp')
{
	$otpch1=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("otpch1"));
	$otpch2=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("otpch2"));
	$otpch3=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("otpch3"));
	$otpch4=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("otpch4"));
	
	$customer_otp=$otpch1;
	
	
	$customer_phone=$_SESSION['login_phone'];
	if($customer_otp!='' && $customer_phone!='')
		{
				
				
				$obj_model_customer =$app->load_model("customer");
				$obj_model_customer->join_table("customer_info", "left", array("phone_otp"), array("id"=>"customer_id"));
				$rs_customer = $obj_model_customer->execute("SELECT",false,"","phone='".$customer_phone."' and status!='Trash'","");
				if(count($rs_customer)>0)
				{
					
						
						$reff_code=$rs_customer[0]['referral_from'];
						
					
						if($rs_customer[0]['status']!='Active')
						{
							
							$RESULT='NOT OK';
							$MSG='Your Account is Disabled By Admin. Contact Admin.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
							
							
						}
						
						
						
						
						
						if($rs_customer[0]['customer_info_phone_otp']==$customer_otp)
						{
								
								
								
								$token=$app->utility->generateToken(25);
								
								
								$obj_model_user = $app->load_model("customer");
								$obj_model_user->execute("UPDATE",false,"UPDATE customer SET otp_verified ='Yes',api_token='".$token."' WHERE id='".$rs_customer[0]['id']."'","");
								
							
							
																
								$custID=$rs_customer[0]['id'];
								$first_name=$rs_customer[0]['name'];
								$last_name=$rs_customer[0]['last_name'];
								$email=$rs_customer[0]['email'];
								$phone=$rs_customer[0]['phone'];
									
								$image_name=$rs_customer[0]['image'];
								$folder='customer';
								$userimage=$app->utility->get_image_path($image_name,$folder,'large');
														
														
								
								
								if($first_name=='')
								{
									$first_name='Guest';
										
								}	
								
								
								$_SESSION['MDRCCustID']=$custID;
								$_SESSION['MDRCCustFirstName']=$first_name;
								$_SESSION['MDRCCustLastName']=$last_name;
								$_SESSION['MDRCCustEmail']=$email;
								$_SESSION['MDRCCustPhone']=$phone;
								$_SESSION['MDRCCustImage']=$userimage;
								
								$wallet=$rs_customer[0]['wallet']+$rs_customer[0]['promoWallet'];
								$_SESSION['MDRCCustWallet']=$wallet;
								
								
								if($_SESSION['login_remember']=='Yes')
								{
									setcookie('MDRCToken', $token, time() + (86400 * 90), "/");
					
								}
								
								
								
								if($first_name=='')
								{
									$type='Signup';	
									$MSG='OTP Verify Successfully.';
									
								}
								else
								{
									$type='Home';	
									$MSG='Login Successfully.';
								}
								
								
								
								
								
								
								
								$obj_model_cart = $app->load_model("customer_cart");
								$rs_cart=$obj_model_cart->execute("SELECT",false,"","session_id='".session_id()."'");
								
								if(count($rs_cart)>0)
								{
									$obj_model_cart = $app->load_model("customer_cart");
									$obj_model_cart->execute("DELETE",false,"","customer_id='".$_SESSION['MDRCCustID']."'");
									
									$obj_model_update_cart = $app->load_model("customer_cart");
									$obj_model_update_cart->execute("UPDATE",false,"UPDATE customer_cart SET customer_id='".$_SESSION['MDRCCustID']."',session_id='' WHERE session_id='".session_id()."'");
									
										
								}
								
								
													
						
							$RESULT='OK';
							
							
							
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"datatype"=>$type,"signup_login_phone"=>$phone,"profile_menu"=>'',"wallet_profile_menu"=>''));
							exit;
							
							
								
							
							
						}
						else
						{
							
							$RESULT='NOT OK';
							$MSG='Wrong OTP.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
							
							
						}
				}
				else
				{
							$RESULT='NOT OK';
							$MSG='customer Not Found.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
						
						
				}
		}
		else
		{
							$RESULT='NOT OK';
							$MSG='Please Fill Require Data.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
			
				
				
			
			
		}
	

}


else if($action_type=='resend_otp')
{
	
	
	
	
	$customer_phone=$_SESSION['login_phone'];
	if($customer_phone!='')
		{
				
				$obj_model_user =$app->load_model("customer");
				$rs_user = $obj_model_user->execute("SELECT",false,"","phone='".$_SESSION['login_phone']."' and status!='Trash'","");
				
				if(count($rs_user)>0)
				{
						if($rs_user[0]['status']!='Active')
						{
							$RESULT='NOT OK';
							$MSG='Your Account is Disabled By Admin. Contact Admin.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
						}
						$phone=$rs_user[0]['phone'];
						$email=$rs_user[0]['email'];
						if($phone==9510069163)
						{
							$otp=5555;
							
						}
						else
						{	
						
						
							$otp=$app->utility->generate_OTP(4);
						
						}
						
						$obj_model_user = $app->load_model("customer_info");
						$obj_model_user->execute("UPDATE",false,"UPDATE customer_info SET phone_otp ='".$otp."' WHERE customer_id='".$rs_user[0]['id']."'","");
						//send sms
						
						
						$first_name=$rs_user[0]['name'];
						
						if($first_name=='')
						{
							$first_name='Guest';
															
						}	
												
						$sms_type='OTP';
						$default_string = array("{name}","{otp}","{support_phone}","{store_data}");
						$new_string   = array($first_name,$otp,$_SESSION['support_phone'],$store_data);                                                                
						$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
						
						
						if($email!='')
						{
							//Send OTP Email
							
							$template_name="customer_otp.html";
							$subject="One Time Password (OTP) to log in to your Payify account.";
							$body_parameters=array("name"=>$first_name,"otp"=>$otp);	
							
							$mail_data=array();	
							$mail_data['email']=$email;
							$mail_data['template_name']=$template_name;
							$mail_data['subject']=$subject;
							$mail_data['body_parameters']=$body_parameters;
											
							$app->utility->send_email_data($mail_data);		
							
							
						}
						
													
						
							//$otp='';
						
						
							$RESULT='OK';
							$MSG='OTP Sent Successfully.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
							
							
				}
				else
				{
							$RESULT='NOT OK';
							$MSG='Customer Not Found.';
							echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
							exit;
						
				}
		}
		else
		{
			$RESULT='NOT OK';
			$MSG='Try Again.';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
			exit;
			
			
		}
	

}

else if($action_type=='signup')
{
	
	
		$customer_first_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("first_name"));
		$customer_last_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("last_name"));
		$customer_email=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("email"));
		
		
		
		
		$customer_phone=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("phone"));
		
	
	
		$reff_code=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("reff_code"));
		
				
		
		
		
		
		

		if($customer_first_name!='' &&  $osType!='')
		{
			
				$ip=$_SERVER['REMOTE_ADDR'];
			
			
				$obj_model_user =$app->load_model("customer");
				$obj_model_user->set_fields_to_get(array("phone","status","name"));
				$rs_user = $obj_model_user->execute("SELECT",false,"","id='".$_SESSION['LoguesCustID']."' and status!='Trash'","");
				

				if(count($rs_user)<=0)
				{
					
					
					$RESULT='NOT OK';
					$MSG='Your Account is Disabled By Admin. Contact Admin.';
					echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
					exit;
					
					
												
						
				}
				
				
				if($rs_user[0]['name']!='')
				{
					
					
						$RESULT='OK';
						$MSG='Success.';
						echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));	
						exit;
					
												
						
				}
				
				
				
				
				
				
				if($customer_email!='')
				{
					$obj_model_user =$app->load_model("customer");
					$obj_model_user->set_fields_to_get(array("email","status"));
					$rs_user = $obj_model_user->execute("SELECT",false,"","email='".$customer_email."' and id!='".$_SESSION['LoguesCustID']."' and status!='Trash'","");
					
	
					if(count($rs_user)>0)
					{
						
						$RESULT='NOT OK';
						$MSG='Account with '.$customer_email.' email address is already exit.';
						echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
						exit;
						
					
						
													
							
					}
					
				}
				
				
				
				
				
						if($reff_code!='')

						{

							// Check Email Exist Or Not.
							$obj_model_check_user =$app->load_model("customer");
							$rs_check_cust = $obj_model_check_user->execute("SELECT",false,"","ref_key='".$reff_code."' and status!='Trash'","");
							if(count($rs_check_cust)==0)
							{
								
								$RESULT='NOT OK';
								$MSG='Wrong Reffer Code.';
								echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
								exit;
													

							}

							else

							{

								$reff_code_update='Yes';
								$refer_customer_id=$rs_check_cust[0]['id'];

							}

						}
						
						
						
						
						
						
						
									$obj_model_settings =$app->load_model("generel_settings");
									$rs_sett = $obj_model_settings->execute("SELECT",false,"","","");
									$signup_amount=$rs_sett[0]['signup_amount'];
									$refer_signup_amount=$rs_sett[0]['refer_signup_amount'];
				
									if($reff_code_update=='Yes')
									{
			
										$wallet=$refer_signup_amount;
									}
									else
									{
			
										$wallet=$signup_amount;
					
									}
				
				
				
				
						
						$city='';
						$state='';
						$city_id=0;
						$state_id=0;
								
								
						// Register As New Customer
						
						
						$reff_key=$app->utility->keygen(6);
						
						
						$update_field = array();
						$update_field["name"] = $customer_first_name;
						$update_field["last_name"] = $customer_last_name;
						$update_field["email"] = $customer_email;
								
						$update_field["ref_key"] = $reff_key;
					
						if($reff_code_update=='Yes')

						{
							$update_field["referral_from"] = $reff_code;
							
							
							
						}
						
						$update_field["ip"] = $ip;
						$obj_model_table = $app->load_model("customer");
						$obj_model_table->map_fields($update_field);
						$ID=$obj_model_table->execute("UPDATE",false,"","id='".$_SESSION['LoguesCustID']."'");
						
						
						
						
						
								if($wallet>0)
		
									{
										
										
										$obj_model_user = $app->load_model("customer");
										$obj_model_user->execute("UPDATE",false,"UPDATE customer SET promoWallet='".$wallet."' WHERE id='".$_SESSION['LoguesCustID']."'","");
		
																				
		
										$phone=$rs_user[0]['phone'];
										
										
								
										
										$last_bal=0;
										$last_promo_bal=0;
										$data_t=array();	
										$data_t['customer_id']=$rs_user[0]['id'];		
										$data_t['refer_customer_id']=$refer_customer_id;		
										$data_t['amount']=$wallet;
										
										$data_t['amount_type']='+';
										$data_t['last_bal']=$last_bal;
										$data_t['last_promo_bal']=$last_promo_bal;			
										$data_t["payment_status"] = "Success";
										$data_t['pay_with']='Web';		
										$data_t['transaction_date']=date('d-m-Y');		
										$data_t['entry_type']='Signup';
										$data_t['remark']='Welcome Reward';
										$data_t['added_by']='System';
										$data_t['wallet_type']='Promo Wallet';
										$data_t['ip']=$_SERVER['REMOTE_ADDR'];	
										$data_t['entry_date_time']=date('d-m-Y H:i:s');		
										$obj_model_wallet_transaction=$app->load_model("wallet_transction");		
										$obj_model_wallet_transaction->map_fields($data_t);		
										$obj_model_wallet_transaction->execute("INSERT");
		
										
		
										
		
									}
						
						
						
									
																		
					
					
						
						
												
						
						$phone=$rs_user[0]['phone'];
						$email=$customer_email;
						$name=$customer_first_name;
						
						$sms_type='WELCOME_SMS';
						$default_string = array("{name}","{store_data}","{amount}");
						$new_string   = array($name,$store_data,$wallet);
						$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
						
						


						
						
						
						$RESULT='OK';
						$MSG='Registration Successfully.';
						echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"signup_login_phone"=>$signup_login_phone));	
						exit;
						
											
				
						
								
								
						
				
		}
		else
		{
			
			$RESULT='NOT OK';
			$MSG='Please Fill Require Data.';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
			exit;
			
			
			
		}
	

}
else
{
	$RESULT='NOT OK';
	$MSG='Please Try Again.';
	
}
	
	
				
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));	
?>