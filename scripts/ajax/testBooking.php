<?php
	
	$name = $app->getPostVar("full_name");
	$phone = $app->getPostVar("mobile");
	$city = $app->getPostVar("city");
	$package_name = $app->getPostVar("package_name");
	$gender = $app->getPostVar("gender");
	$address = $app->getPostVar("address");
	$brief_details = $app->getPostVar("brief_details");
	$enquiry_type = $app->getPostVar("enquiry_type");
	$test_type = $app->getPostVar("test_type");
	$token = $app->getPostVar("cf-turnstile-response");
	$result=$app->utility->getCloudFareCaptchaVerify($token);
	if($result['status']==0){
		//Captcha not verified.
		echo "1"; exit;
	}
	if($name!='' && $phone!='')
	{
		/*------------------Start for mail function------------------*/
		$template_name='testBooking';
		$send_data_arary=['booking_id'=>"#",'name'=>$name,'phone'=>$phone,'city'=>$city];

		$subject='New Full Body Checkup Enquiry for '.$package_name;
		$mail_for='fullBodyCheckup';
		$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
		$app->utility->sendMial($data);
		/*------------------End for mail function------------------*/


		$googleAppsScriptURL = 'https://script.google.com/macros/s/AKfycbzkYMuzGBqp6QqDBz-zDdqNEFX5-lR1naapSGoFaFDIa-1ZyhYKO2g7M_ZonU0yzX8F/exec';
		$postData="inquirydate=".date('d-m-Y H:i:s')."&package=".$package_name."&name=".$name."&phone=".$phone."&city=".$city."";
		// Initialize cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $googleAppsScriptURL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$response = mdrc_curl_exec($ch);

		echo 0;
		exit;	
	}
	else
	{
		echo "1";
	}
?>