<?php

	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$company = $app->getPostVar("company");
	$message = $app->getPostVar("message");
	$token = $app->getPostVar("cf-turnstile-response");

	if($name!='' && $phone!='' && $email!='')
	{
		/* $fields_map = array();
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
		$booking_id=$obj_model_prescription_booking->execute("INSERT"); */

		/*------------------Start for mail function------------------*/
		$template_name='corporate_tieup_admin';
		$send_data_arary=['name'=>$name,'phone'=>$phone,'email'=>$email,'company'=>$company,'message'=>$message];

		$subject='New Corporate Tieup Enquiry from '.$name;
		$mail_for='corporate_tieup';
		$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
		$app->utility->sendMial($data);
		/*------------------End for mail function------------------*/

		/*----------------- Frappe (same webhook as other website forms)----------- */
		$frappeUrl = FRAPPE_WEBSITE_ENQUIRY_URL;

		$postFields = array(
			// Legacy: pass shared secret in multipart (or QS)—disabled; Frappe uses only `Authorization: token api_key:api_secret`
			// 'auth_token' => '...',
			'source' => FRAPPE_ENQUIRY_SOURCE_CORPORATE,
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'company' => $company,
			'message' => $message,
			'enquiry_type' => 'Corporate tie-up',
			'test_type' => '',
			'booking_id' => '0',
			'user_id' => isset($_SESSION['MDRCCustID']) ? (string) $_SESSION['MDRCCustID'] : '',
			'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
			'cf-turnstile-response' => (string) $token,
			'brief_details' => $message,
		);

		error_log('Frappe website webhook (corporate): start');

		$frappeHeaders = array();
		$frappeApiKey = trim((string) FRAPPE_WEBSITE_INTEGRATION_API_KEY);
		$frappeApiSecret = trim((string) FRAPPE_WEBSITE_INTEGRATION_API_SECRET);
		if ($frappeApiKey !== '' && $frappeApiSecret !== '') {
			$frappeHeaders[] = 'Authorization: token ' . $frappeApiKey . ':' . $frappeApiSecret;
		}

		$chFrappe = curl_init();
		$frappeCurlOpts = array(
			CURLOPT_URL => $frappeUrl,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postFields,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 25,
			CURLOPT_CONNECTTIMEOUT => 10,
		);
		if (count($frappeHeaders) > 0) {
			$frappeCurlOpts[CURLOPT_HTTPHEADER] = $frappeHeaders;
		}
		curl_setopt_array($chFrappe, $frappeCurlOpts);

		$frappeBody = curl_exec($chFrappe);
		$frappeHttp = (int) curl_getinfo($chFrappe, CURLINFO_HTTP_CODE);
		$frappeErr = curl_error($chFrappe);
		curl_close($chFrappe);

		if ($frappeErr || $frappeHttp !== 200) {
			error_log('Frappe website webhook (corporate): HTTP ' . $frappeHttp . ' curl_err=' . $frappeErr . ' body=' . substr((string) $frappeBody, 0, 800));
		} else {
			$fj = json_decode($frappeBody, true);
			if (!is_array($fj) || ($fj['message'] ?? '') !== 'ok') {
				error_log('Frappe website webhook (corporate) unexpected JSON: ' . substr((string) $frappeBody, 0, 800));
			} else {
				error_log('Frappe website webhook (corporate): success message=ok');
			}
		}

		echo "0";
		exit;
	}
	else
	{
		echo "1";
	}
?>
