<?

class _test_booking_inquiry extends controller
{



	function init() {}

	function onload()
	{

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);

		$name = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('name'));
		$email = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("email"));
		$phone = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("phone"));
		$age = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("age"));
		$city = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("city"));
		$date = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("date"));
		$gender = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("gender"));
		$address = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("address"));
		$brief_details = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("brief_details"));
		$enquiry_type = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("enquiry_type"));
		$test_type = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("test_type"));


		if ($name != '' && $phone != '') {
			$fields_map = array();

			$img_url = '';
			if (!empty($_FILES['pre_file']['name'])) {
				
				# NEW UPDATE
				$upload_dir = 'test_booking_file';
				$targetDir = '../uploads/' . $upload_dir . '/';

				if (!file_exists($targetDir)) {
					mkdir($targetDir, 0777, true);
				}

				$fileName = $_FILES['pre_file']['name'];
				$tmpName  = $_FILES['pre_file']['tmp_name'];

				$newFileName = time() . '_' . preg_replace('/\s+/', '_', $fileName);
				$targetFilePath = $targetDir . $newFileName;

				if (move_uploaded_file($tmpName, $targetFilePath)) {

					$fields_map['file'] = $newFileName;
					$img_url = SERVER_ROOT . '/uploads/' . $upload_dir . '/' . $newFileName;
					$filePath = "/home/mdrcindia.com/html/uploads/" . $upload_dir . "/" . $newFileName;
					$mimeType = mime_content_type($filePath);
					$curlFile = new CURLFile($filePath, $mimeType, basename($filePath));
					$s3FilePath = '';
					if ($response1['status'] == 'Success') {
						$s3FilePath = $response1['s3FilePath'];
					}
				} else {
					echo "File upload failed.";
				}

				//Image Edit
				// $upload_dir = 'test_booking_file';
				// $file_image = $this->app->utility->resize_single_image_front($_FILES['pre_file']['name'], $_FILES['pre_file']['tmp_name'], '../../uploads/' . $upload_dir . '/', '1000');
				// $fields_map['file'] = $file_image;
				// $img_url = SERVER_ROOT . '/uploads/test_booking_file/' . $file_image;

				//$curl = curl_init();

				// $filePath = "/home/mdrcindia.com/html/uploads/test_booking_file/" . $file_image;
				// $mimeType = mime_content_type($filePath);
				// $curlFile = new CURLFile($filePath, $mimeType, basename($filePath));
				// $s3FilePath = '';
				// if ($response1['status'] == 'Success') {
				// 	$s3FilePath = $response1['s3FilePath'];
				// }
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
			$fields_map['user_id'] = NUll;

			if ($enquiry_type != '' && $test_type != '') {
				$fields_map['enquiry_type'] = $enquiry_type;
				$fields_map['test_type'] = $test_type;
			}

			$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
			$fields_map['added_date'] =  date('Y-m-d');

			$obj_model_prescription_booking = $this->app->load_model('test_booking_enquiry');
			$obj_model_prescription_booking->map_fields($fields_map);
			$booking_id = $obj_model_prescription_booking->execute("INSERT");


			/*------------------Start for mail function------------------*/
			$template_name = 'test_booking_admin';
			$send_data_arary = ['booking_id' => "#" . $booking_id, 'name' => $name, 'phone' => $phone, 'email' => $email, 'age' => $age, 'city' => $city, 'date' => $date, 'gender' => $gender, 'brief_details' => $brief_details];

			$subject = 'New Test Booking Enquiry from ' . $name . ' on Website';
			$mail_for = 'test_booking_inquiry';
			$data = ['template_name' => $template_name, 'send_data_arary' => $send_data_arary, 'subject' => $subject, 'mail_for' => $mail_for];
			$this->app->utility->sendMial($data);
			/*------------------End for mail function------------------*/



			/*----------------- LeadSquared disabled on staging ------------------------ */





			$url = "https://crm.mdrcindia.net/api/method/crm.integrations.website.webhooks.ingest_website_enquiry";

			$apiKey = "2236b2f73d1cb2b";
			$apiSecret = "a7a99e414903e5d";

			$payload = [
				"name" => $name,
				"phone" => $phone,
				"city" => $city,
				"test_type" => $test_type,
				"enquiry_type" => $enquiry_type,
				"source" => "test_booking_enquiry"
			];

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json",
			"Authorization: token {$apiKey}:{$apiSecret}"
			]);

			$response = mdrc_curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);


			if($booking_id){
			$bookingData = ['bookingID' => $this->app->utility->encrypt($booking_id), 'name' => $name, 'phone' => $phone, 'email' => $email, 'age' => $age, 'city' => $city, 'date' => $date, 'gender' => $gender, 'brief_details' => $brief_details];
			$result = ["booking" => $bookingData];
			$message = array("message" => 'Thank you for your inquiry. Our team will get back to you soon.', "msgCode" => "1", "result" => $result);
			}else{
			$message = array("message" => 'Failed..! Please Try Again.', "msgCode" => "0");

			}
		} else {
			$message = array("message" => "Date missing.", "msgCode" => "0");
		}


		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
