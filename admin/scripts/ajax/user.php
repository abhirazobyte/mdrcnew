<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active user datatbale loading
if($get_actionType=="user_list")
{
	$table_name='user';

	## Read value
	$draw = $app->getPostVar('draw');
	$row = $app->getPostVar('start');
	$rowperpage = $app->getPostVar('length'); // Rows display per page
	$orderArray = $app->getPostVar('order');
	$columnIndex = $orderArray[0]['column']; // Column index
	
	$columnArray = $app->getPostVar('columns');
	$columnName = $columnArray[$columnIndex]['data']; // Column name
	
	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')
	{
		$columnName='id';
	}
	
	$columnSortOrder = $orderArray[0]['dir']; // asc or desc
	
	$searchArray=$app->getPostVar('search');
	$searchValue = $searchArray['value']; // Search value
	
	## Search 
	$searchQuery = " ";
	if($searchValue != '')
	{
		$searchQuery = " and (	
		".$table_name.".id like '%".$searchValue."%' or 
		registered_with like '%".$searchValue."%' or
		name like '%".$searchValue."%' or
		last_name like '%".$searchValue."%' or
		email like '%".$searchValue."%' or
		wallet like '%".$searchValue."%' or
		mobilephone like '%".$searchValue."%' or
		whatsapp_no like '%".$searchValue."%' or
		area_name like '%".$searchValue."%' or
		otp_verified like '%".$searchValue."%' or
		is_active like '%".$searchValue."%' or 	
		".$table_name.".blocked like '%".$searchValue."%'
		) 
		";
	}
	
	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];
	$type=$_SESSION['search_type'];
	
	if($type=='App')
	{
			$con=" AND registered_with='android_app'";
	}
	elseif($type=='Website')
	{
		
		$con=" AND registered_with='website'";
	}
	else
	{
		$con="";
	}
	
	$sdate=str_replace('-','/',$s_date);
	$edate=str_replace('-','/',$e_date);
	
	if($sdate!='' && $edate!='')
	{
		$date_cond="and STR_TO_DATE(registration_date, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$sdate."', '%d/%m/%Y') AND STR_TO_DATE('".$edate."', '%d/%m/%Y') ";
	}
	else
	{
		$date_cond="";
	}
				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$date_cond." ".$con." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='0' ".$date_cond." ".$con." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
					
			$edit_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-primary btn-icon user_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			
			$delete_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-danger btn-icon user_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';	
						
			$wallet_btn='<a style="margin-bottom: 3px;" href="index.php?view=add_money_list&user_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mr-1"><i class="fas fa-wallet"></i></a>';	
			
			$order_btn='<a style="margin-bottom: 3px;" href="index.php?view=user_order_list&user_id='.$result[$i]['id'].'" class="btn btn-xs btn-info btn-icon mr-1"><i class="fas fa-shopping-basket"></i></a>';	
			
			$sms_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-dark btn-icon user_sms_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-envelope"></i></button>';
			
			$detail_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-light btn-icon user_detail_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-play"></i></button>';	
	
			
			$option='<div class="btn-toolbar"><div>'.$detail_btn.' '.$wallet_btn.' '.$order_btn.' '.$edit_btn.' '.$delete_btn.' '.$sms_btn.'</div></div>';
			
			$orders=$app->utility->customer_total_order($result[$i]['id']);
			
			$reffers=$app->utility->total_user_refer($result[$i]['ref_key']);
			
			$area_name=$app->utility->user_area($result[$i]['area_id']);
			
			$otp_verified=$app->utility->user_status($result[$i]['otp_verified']);
			
			
			$registered_with=$app->utility->user_registered_with($result[$i]['registered_with']);
			
			
			/*if($result[$i]['group_id']!='')
			{
				$groups=$app->utility->user_group($result[$i]['group_id']);
			}
			else
			{
				$groups='';
			}
			*/
			$is_active=$app->utility->user_status($result[$i]['is_active']);

			
		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name']." ".$result[$i]['last_name']."<br/>".$result[$i]['mobilephone']."<br/>".$result[$i]['email'],
			"is_active"=>$is_active,
			"area_id"=>$area_name,
			"wallet"=>'<i class="fa fa-rupee-sign"></i> '.$result[$i]['wallet'],
			"orders"=>$orders,
			"reffers"=>$reffers,
			"otp_code"=>$result[$i]['otp_code']."<br/>".$otp_verified,
			"registration_date"=>$result[$i]['registration_date']."<br/>".$registered_with,
			"btn"=>$option
		);
	}
	
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);
		
	echo json_encode($response);
	exit;
}


//Function for user addedit
if($actionType=="userAddEdit")
{

	$name=$app->getPostVar('name');
	$mobilephone=$app->getPostVar('mobilephone');
	$email=$app->getPostVar('email');
	$group_ids=$app->getPostVar('group_ids');
	$group_ids=implode(',',$group_ids);
	$id=$app->getPostVar('id');
	$otp_verified=$app->getPostVar('otp_verified1');

	if($mobilephone!='' && $name!='')
	{
		if($id!='')
		{
			$cond=" and id!='".$id."'";
			$update_title='Updated';
		}
		else
		{
			$cond="";
			$update_title='Added';
		}
		
		if($mobilephone!='' && $email!='')
		{
			$cond_phone="and (mobilephone='".$mobilephone."' or email='".$email."')";
		}
		else
		{
			$cond_phone="and mobilephone='".$mobilephone."'";
		}
		
		$obj_model_user1= $app->load_model("user");
		$rs_user_check=$obj_model_user1->execute("SELECT",false,"","id!='0' ".$cond." ".$cond_phone."");
		if(count($rs_user_check)>0)
		{
			$msg='It seems that Email and Phone is already registered with some account! ';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}

		//Insert Update Record
		$update_field = array();
		$update_field['name']=$name;
		$update_field['mobilephone']=$mobilephone;
		$update_field['group_id']=$group_ids;
		$update_field['registration_date']=date('d-m-Y H:i:s A');
		
		if($id!='' && $otp_verified=='Yes')
		{
			$update_field['otp_verified']='Yes';
		}
		else if($id=='')
		{
			$update_field['otp_verified']='Yes';
			$otp_verified='Yes';
		}
		
		
		$obj_model_user = $app->load_model("user");
		$obj_model_user->map_fields($update_field);
		if($id!='')
		{
			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		}
		else
		{
			$rs=$obj_model_user->execute("INSERT",false,"","");
			$id=$rs;
			if($email!="")
			{
				 $subject = "Registeration confirmation from ".PROJECT_TILLE;
				 $to=$email;
				 $pass='';
				
				 $obj_mailer = $app->load_module("mailer\sender");
				 $mail_body = $app->utility->ParseMailTemplate("register.html", array("username"=>$name,"email"=>$email,"password"=>$pass,"server_root"=>SERVER_ROOT));
				
				 if($mail_body==NULL)
				 {
					$app->display_error(NULL, "Could not parse the mail template");
				 }
				 $obj_mailer->create();
				 $obj_mailer->subject("Thank You for Registering - ".PROJECT_TILLE);
				 $obj_mailer->add_to($email);
				 $obj_mailer->htmlbody($mail_body);				
				 $flag = $obj_mailer->send();
			}
		}
		if($rs>0)
		{		
			if($otp_verified=='Yes')
			{
				$obj_model_user = $app->load_model("user");
				$rs_user=$obj_model_user->execute("SELECT",false,"","id='".$id."'");
				//first time otp verifi
				if($rs_user[0]['referral_from']!="")
				{
					//Refer Benifits
					$obj_model_table =$app->load_model("user");
					$rs_user_refer= $obj_model_table->execute("SELECT",false,"","ref_key='".$rs_user[0]['referral_from']."'","");
					if(count($rs_user_refer)>0)
					{
						$obj_model_referral_discount=$app->load_model("referral_discount");
						$rs_ref_discount=$obj_model_referral_discount->execute("SELECT",false,"","");
						
						$wallet=$rs_ref_discount[0]['discount'];
						$by_name=$rs_user_refer[0]['name'];
						$to=$rs_user_refer[0]['email'];
						$email=$rs_user[0]['email'];
						$friend_cachback=$rs_ref_discount[0]['discount1'];
						$username=$rs_user[0]['name'];
						if($to!='')
						{
							$obj_mailer = $app->load_module("mailer\sender");
							$mail_body = $app->utility->ParseMailTemplate("refer_by_mail.html", array("by_name"=>$by_name,"email"=>$email,"refer_by_discount"=>$friend_cachback,"username"=>$username,"server_root"=>SERVER_ROOT));
							if($mail_body==NULL)
							{
								$app->display_error(NULL, "Could not parse the mail template");
							}
							$obj_mailer->create();
							$obj_mailer->subject("Your friend has joined ".PROJECT_TILLE);
							$obj_mailer->add_to($to);
							$obj_mailer->htmlbody($mail_body);
							$flag = $obj_mailer->send();
						}
					}
				}
				else
				{
					$obj_model_registration_wallet=$app->load_model("registration_wallet");
					$rs_registration_wallet=$obj_model_registration_wallet->execute("SELECT",false,"","");
					$wallet=$rs_registration_wallet[0]['amount'];
				}
				
				$new_wallet=$rs_user[0]['wallet']+$wallet;
				$obj_model_user_update = $app->load_model("user");
				$obj_model_user_update->execute("UPDATE",false,"UPDATE user SET wallet='".$new_wallet."',otp_verified='Yes' WHERE id='".$rs_user[0]['id']."'","");
				$phone=$rs_user[0]['mobilephone'];	
				if($wallet>0)
				{
					$sms_type='WELCOME_SMS';
					$default_string = array("{amount}","{name}");
					$new_string   = array($wallet,$rs_user[0]['name']);
					$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);	
					
					$data_t=array();
					$data_t['user_id']=$rs_user[0]['id'];
					$data_t['name']=$rs_user[0]['name'];
					$data_t['email']=$rs_user[0]['email'];
					$data_t['phone']=$rs_user[0]['mobilephone'];
					$data_t['address']=$rs_user[0]['billing_address_line1'];
					$data_t['zipcode']=$rs_user[0]['billing_zip_code'];
					$data_t['city']=$rs_user[0]['billing_city'];
					$data_t['referral_from']=$rs_user[0]['referral_from'];
					$data_t['amount']=$wallet;
					$data_t['last_bal']=$rs_user[0]['wallet'];
					$data_t["payment_status"] = "Success";
					$data_t['type']='Plus';
					$data_t['payment_with']='Website';
					$data_t['transaction_date']=date('d-m-Y H:i:s A');
					$data_t['transction_type']='Wallet';
					$data_t['remark']='Welcome Reward';
					$data_t['ip_address']=$_SERVER['REMOTE_ADDR'];
					$obj_model_wallet_transaction=$app->load_model("wallet_transaction");
					$obj_model_wallet_transaction->map_fields($data_t);
					$obj_model_wallet_transaction->execute("INSERT");
				}
			}
			
			$msg="Record ".$update_title." Successfully.";
			$msgcode=0;
		 }
		 else
		 {
			$msg='Please Try Again.';
			$msgcode=1;
		 }
	}
	else
	{
			$msg='Please Fill Require Data';
			$msgcode=1;
	}
}



//Function for user addedit
if($actionType=="userSMSAddEdit")
{
	$type_data=$app->getPostVar('type_data');			
	$email=$app->getPostVar('email');
	$phone=$app->getPostVar('phone');
	$message=$app->getPostVar('message');
	$sms_message=$app->getPostVar('sms_message');	
	$user_id=$app->getPostVar('user_id');			

	if($user_id!="" && $type_data!='')
	{
		if($type_data=='SMS' || $type_data=='Both')
		{
			if($phone!="")
			{
				$sms_type='USER_SEND_SMS';
				$default_string = array("{message}");
				$new_string   = array($sms_message);
				$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);
			}
			
		}
		if($type_data=='Email' || $type_data=='Both')
		{
			$mail_title=$app->gs['project_title'];
			$contact_email=$app->gs['contact_email'];
			$mail_header=$app->utility->web_mail_header();
			$mail_footer=$app->utility->web_mail_footer();
			$obj_mailer = $app->load_module("mailer\sender");
			$mail_body = $app->utility->ParseMailTemplate("send_mail.html", array("title"=>$mail_title,"header"=>$mail_header,"footer"=>$mail_footer,"NAME"=>$rs_user[0]['name'],"EMAIL"=>$email,"MESSAGE"=>$message));
			if($mail_body==NULL)
			{
				$app->display_error(NULL, "Could not parse the mail template");
			}
			$obj_mailer->create();
			$obj_mailer->subject("Message From ".$mail_title);
			$obj_mailer->add_to($email);
			$obj_mailer->htmlbody($mail_body);						
			$flag = $obj_mailer->send();
		}
		$msg=$type_data." Send Successfully.";
		$msgcode=0;
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}
}


//Function for single user delete
if($actionType=="userDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$obj_change_table = $app->load_model('user');
		$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");
		
		if($update_id>0)
		{
			$msg='Sucess';
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;	
	}
}


//Function for multiple user delete
if($actionType=="userMultiDelete")
{
	$ids=$app->getPostVar('ids');
	
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($ids);$i++)
		{
			$obj_change_table = $app->load_model('user');
			$update_id = $obj_change_table->execute("DELETE",false,"","id='".$ids[$i]."'");
		}
		
		if($update_id>0)
		{
			$msg='Sucess';
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}		
}


if($actionType=="SessionSet")
{
	$search_type=$app->getPostVar("search_type");
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	$_SESSION['search_type']=$search_type;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}


//Function for GetCityDetail
if($actionType=="GetCityDetail")
{
	$getid=$app->getPostVar('getid');
	
		
	$obj_change_table = $app->load_model('city');
	$rs = $obj_change_table->execute("select",false,"","id='".$getid."'");
	
	$state_name=$rs[0]['state_name'];	
	$city_name=$rs[0]['name'];	

	echo $obj_json->encode(array("state_name"=>$state_name,"city_name"=>$city_name));
	exit;

}
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>