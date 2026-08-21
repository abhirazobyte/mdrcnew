<?
class _collection_appointment_inq extends controller{
	function init(){
	}
	function onload()
	{
		$name = $this->app->getPostVar("name");
		$email = $this->app->getPostVar("email");
		$phone = $this->app->getPostVar("phone");
		$age = $this->app->getPostVar("age");
		$city = $this->app->getPostVar("city");
		$date = $this->app->getPostVar("date");
		$gender = $this->app->getPostVar("gender");
		$address = $this->app->getPostVar("address");
		$brief_details = $this->app->getPostVar("brief_details");
		$reference = $this->app->getPostVar("reference");

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

			$obj_model_collection_appointment=$this->app->load_model('collection_appointment');
			$obj_model_collection_appointment->map_fields($fields_map);
			$appointment_id=$obj_model_collection_appointment->execute("INSERT");


			$url = "https://crm.mdrcindia.net/api/method/crm.integrations.website.webhooks.ingest_website_enquiry";

			$apiKey = "2236b2f73d1cb2b";
			$apiSecret = "a7a99e414903e5d";

			$payload = [
				"name" => $name,
				"email" => $email,
				"phone" => $phone,
				"age" => $age,
				"city" => $city,
				"date" => $date,
				"gender" => $gender,
				"address" => $address,
				"brief_details" => $brief_details,
				"reference" => $reference,
				"user_id" => $_SESSION['MDRCCustID'],
				"ip" => $_SERVER['REMOTE_ADDR'],
				"added_date" => date('Y-m-d'),
				"source" => "collection_appointment"
			];

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Content-Type: application/json",
			"Authorization: token {$apiKey}:{$apiSecret}"
			]);

			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);


			if($appointment_id>0)
			{
				/*------------------Start for mail function------------------*/
				$template_name='collection_appointment_admin';
				$send_data_arary=['appointment_id'=>"#".$appointment_id,'name'=>$name,'phone'=>$phone,'email'=>$email,'age'=>$age,'city'=>$city,'date'=>$date,'gender'=>$gender,'brief_details'=>$brief_details,'reference'=>$reference];
				$subject='New Collection Appointment from '.$name.' on Website';
				$mail_for='home_sample_collection';
				$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
				$this->app->utility->sendMial($data);
				/*------------------End for mail function------------------*/
				
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
	}
}
?>