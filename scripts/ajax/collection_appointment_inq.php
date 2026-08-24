<?php
	$block_lsq_integration = 1;

	$name = $app->getPostVar("name");
	$email = $app->getPostVar("email");
	$phone = $app->getPostVar("phone");
	$age = $app->getPostVar("age");
	$city = $app->getPostVar("city");
	$date = $app->getPostVar("date");
	$gender = $app->getPostVar("gender");
	if (trim((string) $gender) === '') {
		$gender = $app->getPostVar("example");
	}
	$address = $app->getPostVar("address");
	$brief_details = $app->getPostVar("brief_details");
	$reference = $app->getPostVar("reference");
	$token = $app->getPostVar("cf-turnstile-response");

	$enquiry_type_label = 'Collection appointment';
	$test_type_label = 'Home sample collection';

	if($name!='' && $email!='' && $phone!='')
	{
       	$fields_map = array();
		$fields_map['name'] = $name;
		$fields_map['email'] = $email;
		$fields_map['phone'] = $phone;
		$fields_map['age'] = $age;
		$fields_map['city'] = $city;
		$fields_map['date'] = $date;
		$fields_map['gender'] = $gender;
		$fields_map['address'] = $address;
		$fields_map['brief_details'] = $brief_details;
		$fields_map['reference'] = $reference;
		$fields_map['user_id'] = $_SESSION['MDRCCustID'];
		$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields_map['added_date'] =  date('Y-m-d');

		$obj_model_collection_appointment=$app->load_model('collection_appointment');
		$obj_model_collection_appointment->map_fields($fields_map);
		$appointment_id=$obj_model_collection_appointment->execute("INSERT");

		if($appointment_id>0)
		{
			/*------------------Start for mail function------------------*/
			$template_name='collection_appointment_admin';
			$send_data_arary=['appointment_id'=>"#".$appointment_id,'name'=>$name,'phone'=>$phone,'email'=>$email,'age'=>$age,'city'=>$city,'date'=>$date,'gender'=>$gender,'brief_details'=>$brief_details,'reference'=>$reference];
			$subject='New Collection Appointment from '.$name.' on Website';
			$mail_for='Admin';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$app->utility->sendMial($data);
			/*------------------End for mail function------------------*/

		/*----------------- LeadSquared disabled on staging ------------------------ */



		/*----------------- Frappe (same webhook as test booking)----------- */
		$frappeUrl = FRAPPE_WEBSITE_ENQUIRY_URL;

		$postFields = array(
			// Legacy: pass shared secret in multipart (or QS)—disabled; Frappe uses only `Authorization: token api_key:api_secret`
			// 'auth_token' => '...',
			'source' => FRAPPE_ENQUIRY_SOURCE_COLLECTION,
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'age' => $age,
			'city' => $city,
			'date' => $date,
			'gender' => $gender,
			'address' => $address,
			'brief_details' => $brief_details,
			'enquiry_type' => $enquiry_type_label,
			'test_type' => $test_type_label,
			'booking_id' => (string) $appointment_id,
			'user_id' => isset($_SESSION['MDRCCustID']) ? (string) $_SESSION['MDRCCustID'] : '',
			'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
			'cf-turnstile-response' => (string) $token,
			'reference' => (string) $reference,
		);

		error_log('Frappe website webhook (collection): start appointment_id=' . (string) (int) $appointment_id);

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

		$frappeBody = mdrc_curl_exec($chFrappe);
		$frappeHttp = (int) curl_getinfo($chFrappe, CURLINFO_HTTP_CODE);
		$frappeErr = curl_error($chFrappe);
		curl_close($chFrappe);

		if ($frappeErr || $frappeHttp !== 200) {
			error_log('Frappe website webhook (collection): HTTP ' . $frappeHttp . ' curl_err=' . $frappeErr . ' body=' . substr((string) $frappeBody, 0, 800));
		} else {
			$fj = json_decode($frappeBody, true);
			if (!is_array($fj) || ($fj['message'] ?? '') !== 'ok') {
				error_log('Frappe website webhook (collection) unexpected JSON: ' . substr((string) $frappeBody, 0, 800));
			} else {
				error_log('Frappe website webhook (collection): success message=ok appointment_id=' . (string) (int) $appointment_id);
			}
		}

			echo "0";
			exit;
		}
		else
		{
			echo "1";
			exit;
		}
	}
	else
	{
		echo "1";
	}
?>
