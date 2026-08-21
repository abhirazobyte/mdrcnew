<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$url='http://182.156.200.228/mdrcnew/api/BookingAPI/BookingAPINew';

//get action
$actionType=$app->getPostVar("actionType");

//Function
if($actionType=="BookingAPINew")
{
	$orderID=$app->getPostVar('getid');
	if($orderID!= NULL && $orderID>0)
	{
		//get test data
		$obj_model_order_cust_detail= $this->app->load_model("customer_order_detail");
		$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","customer_order_detail.order_master_id='".$orderID."'");
		foreach($rs_cust_detail as $key=>$value) {
			$testList[]=[
				"testID" => $value['itemid'],
				"testCode" => $value['itemcode'],
				"Rate" => $value['itemcode'],
				"integrationCode" => "",
				"dictionaryId" => "",
				"sampleId" => ""
			];
		}

		//get order master detail
		$obj_model_order_master = $this->app->load_model("customer_order_master");
		$obj_model_order_master->join_table("city","left", array("name"), array("city_id"=>"id"));
		$rs_order_master = $obj_model_order_master->execute("SELECT", false, "","customer_order_master.id='".$orderID."'");
		
		
		$paymentList=[];

		$paymentList[]=[
			"paymentType" => "CASH",
			"paymentAmount" => "0",
			"issueBank" => "",
			"chequeNo" => ""
  		];
		
		$testList[]=[
			"testID" => "7644",
			"testCode" => "7644",
			"Rate" => "150",
			"integrationCode" => "",
			"dictionaryId" => "",
			"sampleId" => ""
  		];

		$testList[]=[
			"testID" => "7647",
			"testCode" => "7647",
			"Rate" => "300",
			"integrationCode" => "",
			"dictionaryId" => "",
			"sampleId" => ""
  		];

		 		
		$billDetails=[
			"emergencyFlag" => "0",
			"totalAmount" => "450",
			"advance" => "0",
			"billDate" => "04-01-2023",
			"paymentType" => "CASH",
			"referralName" => "",
			"otherReferral" => "",
			"sampleId" => "",
			"orderNumber" => "MD131",
			"referralIdLH" => "",
			"organisationName" => "",
			"additionalAmount" => "0",
			"organizationIdLH" => "",
			"comments" => "",
			"testList" => $testList,
			"paymentList" => $paymentList
		];

		$data = [
			"Panel_ID" => "5050",
			"CentreID" => "170",
			"mobile" => "9979227789",
			"email" => "pratikgandhi711@gmail.com",
			"designation" => "Mrs",
			"fullName" => "Rital Gandhi",
			"age" => "35",
			"gender" => "Female",
			"area" => "Delhi NCR",
			"city" => "Gurgaon/Delhi NCR",
			"patientType" => "",
			"labPatientId" => "",
			"pincode" => "110002",
			"patientId" => "AGUR.0000143984",
			"dob" => "1988-12-17",
			"passportNo" => "",
			"panNumber" => "",
			"aadharNumber" => "",
			"insuranceNo" => "",
			"nationality" => "",
			"ethnicity" => "",
			"nationalIdentityNumber" => "",
			"workerCode" => "",
			"doctorCode" => "",
			"billDetails" => $billDetails
		];

		$post_data = json_encode($data);
		
		//print_r($post_data);
		//exit();
	
		// Prepare new cURL resource
		$crl = curl_init();

		$header = array();
		$header[] = 'Content-type: application/json';
		
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($crl, CURLOPT_URL, $url);
		curl_setopt($crl, CURLOPT_HTTPHEADER, $header);

		curl_setopt($crl, CURLOPT_POST, true);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

		$rest = curl_exec($crl);


		print_r($rest);
		exit();

		// if ($rest === false)
		// {
		// 	// throw new Exception('Curl error: ' . curl_error($crl));
		// 	//print_r('Curl error: ' . curl_error($crl));
		// 	$result_noti = 0;
		// }
		// else
		// {
		// 	$result_noti = 1;
		// }

    
		$msg='Sucess';
		$msgcode=0;
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;	
	}
}

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>