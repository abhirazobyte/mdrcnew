<?php
	
	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$age = $app->getPostVar("age");
	$city = $app->getPostVar("city");
	$date = $app->getPostVar("date");
	$gender = $app->getPostVar("gender");
	$address = $app->getPostVar("address");
	$brief_details = $app->getPostVar("brief_details");

	$enquiry_type = $app->getPostVar("enquiry_type");
	$test_type = $app->getPostVar("test_type");

	$token = $app->getPostVar("cf-turnstile-response");

	$result=$app->utility->getCloudFareCaptchaVerify($token);
	if($result['status']==0){
		//Captcha not verified.
		// echo "1"; exit;
	}
	

	if($name!='' && $phone!='')
	{
		$fields_map = array();

		$img_url='';
		if(!empty($_FILES['pre_file']['name']))
		{
			$upload_dir='test_booking_file';
			//Image Edit
			$file_image=$app->utility->resize_single_image_front($_FILES['pre_file']['name'],$_FILES['pre_file']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000');	
			$fields_map['file']=$file_image;
			$img_url=SERVER_ROOT.'/uploads/test_booking_file/'.$file_image;

			//$curl = curl_init();

			$filePath = "/home/mdrcindia.com/html/uploads/test_booking_file/".$file_image;
			$mimeType = mime_content_type($filePath);
			$curlFile = new CURLFile($filePath, $mimeType, basename($filePath));
	
			// curl_setopt_array($curl, array(
			// 	CURLOPT_URL => 'https://files-in21.leadsquared.com/File/Upload',
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_ENCODING => '',
			// 	CURLOPT_MAXREDIRS => 10,
			// 	CURLOPT_TIMEOUT => 0,
			// 	CURLOPT_FOLLOWLOCATION => true,
			// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	CURLOPT_CUSTOMREQUEST => 'POST',
			// 	CURLOPT_POSTFIELDS => 
			// 	array(
			// 		'FileType' => '1',
			// 		'FileStorageType' => '0',
			// 		'EnableResize' => 'false',
			// 		'SchemaName' => 'mx_Upload_Prescription',
			// 		'EntitySchemaName' => 'mx_CustomObject_111',
			// 		'Entity' => '0',
			// 		'StorageVersion' => '0',
			// 		'AccessKey' =>$accessKey,
			// 		'SecretKey' =>$secretKey,
			// 		'uploadFiles'=> $curlFile
			// 	),
			// 	CURLOPT_HTTPHEADER => array(
			// 		'Content-Type: multipart/form-data'
			// 	),
			// ));
	
			// $response1 = curl_exec($curl);
			// $response1=json_decode($response1,true);
			// curl_close($ch);
			$s3FilePath='';
			if($response1['status']=='Success'){
				$s3FilePath=$response1['s3FilePath'];
			}
		}			

		$fields_map['name'] = $name;
		$fields_map['email'] = $email;
		$fields_map['phone'] = $phone;
		$fields_map['age'] = $age;
		$fields_map['city'] = $city;
		$fields_map['date'] = $date;
		$fields_map['gender'] = $gender;
		$fields_map['address'] = $address;
		$fields_map['brief_details'] = $brief_details;
		$fields_map['user_id'] = $_SESSION['MDRCCustID'];

		if($enquiry_type!='' && $test_type!=''){
			$fields_map['enquiry_type'] = $enquiry_type;
			$fields_map['test_type'] = $test_type;
		}
		
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['added_date'] =  date('Y-m-d');

		$obj_model_prescription_booking=$app->load_model('test_booking_enquiry');
		$obj_model_prescription_booking->map_fields($fields_map);
		$booking_id=$obj_model_prescription_booking->execute("INSERT");

		/*------------------Start for mail function------------------*/
		$template_name='test_booking_admin';
		$send_data_arary=['booking_id'=>"#".$booking_id,'name'=>$name,'phone'=>$phone,'email'=>$email,'age'=>$age,'city'=>$city,'date'=>$date,'gender'=>$gender,'brief_details'=>$brief_details];

		$subject='New Test Booking Enquiry from '.$name.' on Website';
		$mail_for='Admin';
		$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
		$app->utility->sendMial($data);
		/*------------------End for mail function------------------*/

		/*----------------- create CRM Lead------------------------ */

		$ch = curl_init();
		$accessKey=CRM_ACCESS_ID;
		$secretKey=CRM_SECRET_KEY;

		if($test_type=='Blood Test')
		{
			$department='Pathology';
		}
		else
		{
			$department='Radiology';
		}

		$data=[
			["Attribute"=>"FirstName","Value"=>$name],
			["Attribute"=>"mx_Department","Value"=>$department],
			["Attribute"=>"Phone","Value"=>$phone],
			["Attribute"=>"mx_City","Value"=>$city],
			["Attribute"=>"Source","Value"=>"Website"],
			["Attribute"=>"Notes","Value"=>$test_type],
		];
		if(!empty($s3FilePath)){
			array_push($data,["Attribute"=>"mx_CustomObject_111","Value"=>$curlFile]);
		}
		curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL,'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey='.$accessKey.'&secretKey='.$secretKey);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$response=json_decode($response,true);
		//print_r($response);exit;
		curl_close($ch);

		// if(!empty($_FILES['pre_file']['name']))
		// {
		// 	$curl = curl_init();

		// 	$filePath = "/home/mdrcindia.com/html/uploads/test_booking_file/".$file_image;
		// 	$mimeType = mime_content_type($filePath);
		// 	$curlFile = new CURLFile($filePath, $mimeType, basename($filePath));
	
		// 	curl_setopt_array($curl, array(
		// 		CURLOPT_URL => 'https://files-in21.leadsquared.com/File/Upload',
		// 		CURLOPT_RETURNTRANSFER => true,
		// 		CURLOPT_ENCODING => '',
		// 		CURLOPT_MAXREDIRS => 10,
		// 		CURLOPT_TIMEOUT => 0,
		// 		CURLOPT_FOLLOWLOCATION => true,
		// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// 		CURLOPT_CUSTOMREQUEST => 'POST',
		// 		CURLOPT_POSTFIELDS => 
		// 		array(
		// 			'FileType' => '1',
		// 			'FileStorageType' => '0',
		// 			'EnableResize' => 'false',
		// 			'Id' => $response['Message']['id'],
		// 			'SchemaName' => 'mx_Upload_Prescription',
		// 			'EntitySchemaName' => 'mx_CustomObject_111',
		// 			'Entity' => '0','StorageVersion' => '0',
		// 			'AccessKey' =>$accessKey,
		// 			'SecretKey' =>$secretKey,
		// 			'uploadFiles'=> $curlFile
		// 		),
		// 		CURLOPT_HTTPHEADER => array(
		// 			'Content-Type: multipart/form-data'
		// 		),
		// 	));
	
		// 	$response = curl_exec($curl);
		// 	curl_close($ch);
		// };
		echo "0";
		exit;	
	}
	else
	{
		echo "1";
	}
?>