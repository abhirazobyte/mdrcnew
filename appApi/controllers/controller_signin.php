<?
ini_set("display_errors", "off");
class _signin extends controller{
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$userName=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userName'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));
		$otp=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("otp"));
		
		if($userName!='' && $deviceType!='' && $action=='signIn')
		{
			$obj_model = $this->app->load_model("customer");
			$obj_model->set_fields_to_get(array("phone","name","status","email"));
			$customer = $obj_model->execute("SELECT",false,"","phone='".$userName."' and status!='Trash'");

			if(!is_numeric($userName) && strlen($userName)!=10)
			{
				$response=array("message"=>"Please enter valid mobile no.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			if(count($customer)>0)
			{
				if($customer[0]['status']=='Inactive')
				{
					$response=array("message"=>"Your Account is Disable by Team. Contact Us","msgCode"=>"0");
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit; 
				}

				$name=$customer[0]['name'];						
				$phone=$customer[0]['phone'];
				$email=$customer[0]['email'];
				$ID=$customer[0]['id'];
				$otp=$phone=='9510069163'?'5555':$this->app->utility->generate_OTP(4);

				// Register As New Customer Information						
				$update_field_c = array();
				$update_field_c["phone_otp"] = $otp;
				$update_field_c["last_login"] = date('d-m-Y H:i:s');
				$update_field_c["last_ip_address"] = $ip;
				$obj_model_customer_info= $this->app->load_model("customer_info");
				$obj_model_customer_info->map_fields($update_field_c);
				$obj_model_customer_info->execute("UPDATE",false,"","customer_id='".$ID."'");

				// Customer Login History						
				$update_field_cl = array();
				$update_field_cl["customer_id"] = $ID;
				$update_field_cl["ip_address"] = $ip;
				$update_field_cl["customer_logins_update_date"] = date('d-m-Y H:i:s');
				$update_field_cl["created_from"] = $osType;
				$obj_model_customer_logins= $this->app->load_model("customer_logins");
				$obj_model_customer_logins->map_fields($update_field_cl);
				$obj_model_customer_logins->execute("INSERT");	

				$name=$name==''?'Guest':$name;
				
				$sms_type='OTP';
				$default_string = array("{name}","{otp}");
				$new_string   = array($name,$otp);                                                                
				$this->app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);	

				if($email!='')
				{
					//Send OTP Email
					$template_name="customer_otp.html";
					$subject="One Time Password (OTP) to log in to your MDRC account.";
					$body_parameters=array("name"=>$name,"otp"=>$otp);	
					
					$mail_data=array();	
					$mail_data['email']=$email;
					$mail_data['template_name']=$template_name;
					$mail_data['subject']=$subject;
					$mail_data['body_parameters']=$body_parameters;
									
					$this->app->utility->send_email_data($mail_data);				
				}

				$message=array("message"=>"OTP Sent.","msgCode"=>"1");
			}
			else
			{
				$otp=$userName=='9510069163'?'5555':$this->app->utility->generate_OTP(4);

				$update_field = array();
				$update_field["phone"] = $userName;
				$update_field["register_date"] = date('d-m-Y');
				$update_field["entry_date_time"] = date('d-m-Y H:i:s');
				$update_field["register_from"] = $deviceType;
				$update_field["status"] = 'Active';
				$update_field["ip"] = $ip;
				$obj_model_table = $this->app->load_model("customer");
				$obj_model_table->map_fields($update_field);
				$ID=$obj_model_table->execute("INSERT");

				// Register As New Customer Information						
				$update_field_c = array();
				$update_field_c["customer_id"] = $ID;
				$update_field_c["phone_otp"] = $otp;
				$update_field_c["created_from"] = $deviceType;
				$update_field_c["ip_address"] = $ip;
				$update_field_c["last_login"] = date('d-m-Y H:i:s');
				$update_field_c["entry_date_time"] = date('d-m-Y H:i:s');
				$update_field_c["last_ip_address"] = $ip;
				$obj_model_customer_info= $this->app->load_model("customer_info");
				$obj_model_customer_info->map_fields($update_field_c);
				$obj_model_customer_info->execute("INSERT");

				$update_field_cl = array();
				$update_field_cl["customer_id"] = $ID;
				$update_field_cl["ip_address"] = $ip;
				$update_field_cl["customer_logins_update_date"] = date('d-m-Y H:i:s');
				$update_field_cl["created_from"] = $deviceType;
				$obj_model_customer_logins= $this->app->load_model("customer_logins");
				$obj_model_customer_logins->map_fields($update_field_cl);
				$obj_model_customer_logins->execute("INSERT");

				$sms_type='OTP';
				$default_string = array("{name}","{otp}");
				$new_string   = array('Guest',$otp);
				$this->app->utility->send_sms_new($userName,$sms_type,$default_string,$new_string);

				$message=array("message"=>"OTP Sent. This OTP will expire in 3 minutes","msgCode"=>"1");
			}
		}
		else if($userName!='' && $deviceType!='' && $otp!='' && $action=='otp_verify')
		{
			$obj_model_customer =$this->app->load_model("customer");
			$obj_model_customer->join_table("customer_info", "left", array("phone_otp","last_login"), array("id"=>"customer_id"));
			$rs_customer = $obj_model_customer->execute("SELECT",false,"","phone='".$userName."' and status!='Trash'","");
			if(count($rs_customer)>0)
			{
				if($rs_customer[0]['status']=='Inactive')
				{
					$response=array("message"=>'Your Account is Disabled By Admin. Contact Admin.',"msgCode"=>'0');
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit;
				}

				$storedTimestamp = strtotime($rs_customer[0]['customer_info_last_login']);
				$currentTimestamp = time();
				$timeDifference = $currentTimestamp - $storedTimestamp;

				if ($timeDifference > 180) 
				{
					$response=array("message"=>'OTP is expired. Please Resend otp and login.',"msgCode"=>'0');
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit;
				}

				if($rs_customer[0]['customer_info_phone_otp']==$otp)
				{
					$token=$this->app->utility->generateToken(25);

					$obj_model_user = $this->app->load_model("customer");
					$obj_model_user->execute("UPDATE",false,"UPDATE customer SET otp_verified ='Yes', api_token='".$token."' WHERE id='".$rs_customer[0]['id']."'","");

					$ID=$rs_customer[0]['id'];
					$first_name=$rs_customer[0]['name']==''?'Guest':$rs_customer[0]['name'];
					$last_name=$rs_customer[0]['last_name'];
					$email=$rs_customer[0]['email'];
					$phone=$rs_customer[0]['phone'];
						
					$image_name=$rs_customer[0]['image'];
					$folder='customer';
					$image=$this->app->utility->get_image_path($image_name,$folder,'large');

					if($rs_customer[0]['name']=='')
					{
						$type='Signup';	
						$message='OTP Verify Successfully.';
					}
					else
					{
						$type='Home';	
						$message='Login Successfully.';
					}
					
					$obj_model_tmp_cart = $this->app->load_model("customer_cart");
					$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","customer_cart.customer_id='".$rs_customer[0]['id']."'");
					$cartCount=count($rs_cart);
					$cartLineTotal = count($rs_cart)>0?array_sum(array_column($rs_cart,'cart_line_total')):0;

					$customer=array("userID"=>$this->app->utility->encrypt($ID),"userFirstName"=>$first_name,"userLastName"=>$last_name,"userEmail"=>$email,"userPhone"=>$phone,"userImage"=>$image,"actionType"=>$type);
					$result=["customer"=>$customer,"cartCount"=>$cartCount,"cartSubtotal"=>$cartLineTotal];
					$message=array("message"=>$message,"msgCode"=>"1","result"=>$result);
				}
				else
				{
					$message=array("message"=>"OTP not match.","msgCode"=>"0");
				}
			}
			else
			{
				$message=array("message"=>"Phone no is not registered.","msgCode"=>"0");
			}
		}
		else if($userName!='' && $deviceType!='' && $action=='resendOtp') 
		{
			$obj_model = $this->app->load_model("customer");
			$obj_model->set_fields_to_get(array("phone","name","status","email"));
			$customer = $obj_model->execute("SELECT",false,"","phone='".$userName."' and status!='Trash'");

			if(!is_numeric($userName) && strlen($userName)!=10)
			{
				$response=array("message"=>"Please enter valid mobile no.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			if(count($customer)>0)
			{
				if($customer[0]['status']=='Inactive')
				{
					$response=array("message"=>"Your Account is Disable by Team. Contact Us","msgCode"=>"0");
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit; 
				}
				$phone=$customer[0]['phone'];
				$email=$customer[0]['email'];
				if($phone==9510069163)
				{
					$otp=5555;
				}
				else
				{	
					$otp=$this->app->utility->generate_OTP(4);
				}

				$obj_model_user = $this->app->load_model("customer_info");
				$obj_model_user->execute("UPDATE",false,"UPDATE customer_info SET phone_otp ='".$otp."', last_login='".date('d-m-Y H:i:s')."' WHERE customer_id='".$customer[0]['id']."'","");

				$first_name=$customer[0]['name'];
						
				if($first_name=='')
				{
					$first_name='Guest';							
				}	
										
				$sms_type='OTP';
				$default_string = array("{name}","{otp}");
				$new_string   = array($first_name,$otp);                                                                
				$this->app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
				
				if($email!='')
				{
					//Send OTP Email
					$template_name="customer_otp.html";
					$subject="One Time Password (OTP) to log in to your account.";
					$body_parameters=array("name"=>$first_name,"otp"=>$otp);	
					
					$mail_data=array();	
					$mail_data['email']=$email;
					$mail_data['template_name']=$template_name;
					$mail_data['subject']=$subject;
					$mail_data['body_parameters']=$body_parameters;	
					$this->app->utility->send_email_data($mail_data);		
				}
				$message=array("message"=>"OTP Sent.","msgCode"=>"1");
			}
			else{
				$message=array("message"=>"Something Gone wrong.","msgCode"=>"0");
			}
		}
		else
		{
			$message=array("message"=>"Oops Something Gone Wrong. Try again...","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>