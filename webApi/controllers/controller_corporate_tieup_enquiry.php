<?
class _corporate_tieup_enquiry extends controller {
	function init(){
	}
	function onload()
	{
		$name = $this->app->getPostVar("name");
		$email = $this->app->getPostVar("email");
		$phone = $this->app->getPostVar("mobile");
		$company = $this->app->getPostVar("company");
		$message = $this->app->getPostVar("message");

		if($name!='' && $phone!='' && $email!='')
		{
			/*------------------Start for mail function------------------*/
			$template_name='corporate_tieup_admin';
			$send_data_arary=['name'=>$name,'phone'=>$phone,'email'=>$email,'company'=>$company,'message'=>$message];

			$subject='New Corporate Tieup Enquiry from '.$name;
			$mail_for='corporate_tieup';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$this->app->utility->sendMial($data);
			/*------------------End for mail function------------------*/



			$url = "https://crm.mdrcindia.net/api/method/crm.integrations.website.webhooks.ingest_website_enquiry";

			$apiKey = "2236b2f73d1cb2b";
			$apiSecret = "a7a99e414903e5d";

			$payload = [
				"name" => $name,
				"email" => $email,
				"phone" => $phone,
				"company" => $company,
				"message" => $message,
				"source" => "corporate_tieup_enquiry"
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



			echo "0";
			exit;
		}
		else
		{
			echo "1";
		}
	}
}
?>