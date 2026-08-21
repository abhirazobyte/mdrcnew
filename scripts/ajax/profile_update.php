<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

if($app->getPostVar('dataType')=='profile_update')
{
	$first_name=$app->getPostVar('first_name');
	$last_name=$app->getPostVar('last_name');
	$phone=$app->getPostVar('phone');
	$email=$app->getPostVar('email');
	$birth_date=$app->getPostVar('birth_date');
	$anniversary_date=$app->getPostVar('anniversary_date');

	if($first_name!='' && $last_name!='')
	{
		
		if($email!='')
		{
			$cond="and (email='".$email."')";
			$obj_model_customer= $app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id!='".$_SESSION['MDRCCustID']."' ".$cond."");
			if(count($rs_user)>0)
			{
				$msg='Mobile Number and Email already exists.';
				$msgcode=1;
				echo $obj_json->encode(array("RESULT"=>$msgcode,"MSG"=>$msg));
				exit;
			}
		}
		
		
		
			
		$update_field = array();
		if(!empty($_FILES['profile_image']['name']))
		{
			$upload_dir='customer';

			$obj_model_record = $app->load_model("customer");
			$result=$obj_model_record->execute("SELECT",false,"","id='".$_SESSION['MDRCCustID']."'");

			if($result[0]["image"]!=NULL)
			{
				@unlink('../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
				@unlink('../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
				@unlink('../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);
			}	
			
			$profile_image=$app->utility->resize_multi_image_2020($_FILES['profile_image']['name'],$_FILES['profile_image']['tmp_name'],'../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['image']=$profile_image;
			
			$_SESSION['MDRCCustImage']=$profile_image;
		}			
		$update_field['name'] = $first_name;
		$update_field['last_name'] = $last_name;
		$update_field['email'] = $email;
		//$update_field['phone'] = $phone;
		$obj_model_user = $app->load_model("customer");
		$obj_model_user->map_fields($update_field);
		$rs=$obj_model_user->execute("UPDATE",false,"","id='".$_SESSION['MDRCCustID']."'");
		if($rs>0)
		{
			$update_field1 = array();
			$update_field1['birth_date'] = $birth_date;
			$update_field1['anniversary_date'] = $anniversary_date;
			$obj_model_customer_info= $app->load_model("customer_info");
			$obj_model_customer_info->map_fields($update_field1);
			$obj_model_customer_info->execute("UPDATE",false,"","customer_id='".$_SESSION['MDRCCustID']."'");
			
			
			
			$_SESSION['MDRCCustFirstName']=$first_name;
			$_SESSION['MDRCCustLastName']=$last_name;
			$_SESSION['MDRCCustEmail']=$email;
			
			
			$img_name=$_SESSION['MDRCCustImage'];
			$profile_img=$app->utility->get_image_path($img_name,'customer','thumb');
			

			$msg="Profile Update Successfully.";
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
			$profile_img='';
		}
	}
	else
	{
		$msg='Please Fill Require Data';
		$msgcode=1;
		$profile_img='';
	}
	$_SESSION['flag_otp']='';
	echo $obj_json->encode(array("RESULT"=>$msgcode,"MSG"=>$msg,"profile_img"=>$profile_img));
	exit;
}
else if($app->getPostVar('dataType')=='verify_otp')
{	
	$cust_otp=$app->getPostVar('cust_otp');

	$obj_model_customer= $app->load_model("customer_info");
	$rs_user=$obj_model_customer->execute("SELECT",false,"","customer_id='".$_SESSION['MDRCCustID']."' and phone_otp='".$cust_otp."'");
	if(count($rs_user)>0)
	{
		$_SESSION['flag_otp']='Yes';
		$msg="Successfully.";
		$msgcode=0;
	}
	else
	{
		$_SESSION['flag_otp']='';
		$msg='Invalid OTP Please Try Again.';
		$msgcode=1;
	}

	echo $obj_json->encode(array("RESULT"=>$msgcode,"MSG"=>$msg));
	exit;
}


?>