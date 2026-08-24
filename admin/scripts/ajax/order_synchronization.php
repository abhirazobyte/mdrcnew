<?php

/*  
  $_POST['product_prices']=["8000","2500","2500","2500"];
  $_POST['discount_amount']=100;
  function discount($product_prices, $discount_amount) {
	
  
	$discounted_prices = [];
	foreach($product_prices as $price) {
		$discounted_price = round($price - ($price * $discount_amount / array_sum($product_prices)));
		$discounted_prices[]=$discounted_price;
	}
	return $discounted_prices;
  }
  
  if (isset($_POST['product_prices']) && isset($_POST['discount_amount'])) {
	$product_prices = $_POST['product_prices'];
	$discount_amount = $_POST['discount_amount'];
	$discounted_prices = discount($product_prices, $discount_amount);
	echo json_encode($discounted_prices);
  }
exit; */

// $orderResponse='{"age":"30","code":"200","gender":"Male","Message":"Success","patientId":"","billId":"MD136","url":"http://182.156.200.228/mdrcnew/Design/Lab/labreportnew.aspx?IsPrev=1&ReportID=1568041_52Z4P6&Phead=0","reportDetails":[{"testAmount":"2800.000000","testCode":"1262","testCategory":"","departmentName":"CT SCAN ","sampleId":"20429739","dictionaryId":0,"testID":0,"CentreReportId":4421387,"integrationCode":"","ledgertransactionno":"MS4445043","Password_web":"52Z4P6","testName":"NCCT HEAD"}]}';

// $orderResponse=json_decode($orderResponse,true);
// print_r($orderResponse); 
// print_r($orderResponse['reportDetails'][0]['ledgertransactionno']);exit;

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$url='https://lis6.mdrcindia.com/mdrcnew/api/BookingAPI/BookingAPINew';

//get action
$actionType=$app->getPostVar("actionType");

//Function
if($actionType=="BookingAPINew")
{
	$orderID=$app->getPostVar('getid');
	if($orderID!= NULL && $orderID>0)
	{
		$Panel_ID='';
		$CentreID='';

		//get order master
		$obj_model_order_master = $app->load_model("customer_order_master");
		$rs_order_master = $obj_model_order_master->execute("SELECT", false, "","customer_order_master.id='".$orderID."'");
		$billDate=$rs_order_master[0]['order_date'];
		$payment_type=$rs_order_master[0]['payment_type'];
		
		//get primary customer
		$obj_model_customer = $app->load_model("customer");
		$rs_customer = $obj_model_customer->execute("SELECT", false, "","id='".$rs_order_master[0]['customer_id']."'");

		//get order master detail group by customer
		$obj_model_order_cust_detail= $app->load_model("customer_order_detail");
		$obj_model_order_cust_detail->join_table("customer_members", "left", array(), array("customer_members_id"=>"id"));
		$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","order_master_id='".$orderID."'","","customer_order_detail.customer_members_id");

		if(count($rs_cust_detail)>0)
		{
			for($i=0;$i<count($rs_cust_detail);$i++)
			{
				//get city name
				$obj_model_city = $app->load_model("city");
				$rs_city = $obj_model_city->execute("SELECT", false, "","id='".$rs_cust_detail[$i]['customer_members_city_id']."'");


				if($rs_order_master[0]['lab_id']>0)
				{
					$obj_model_home_collection = $app->load_model("item_lab");
					$rs_selected_lab = $obj_model_home_collection->execute("SELECT", false, "","id='".$rs_order_master[0]['lab_id']."'");
					$Panel_ID=$rs_selected_lab[0]['panel_id'];
					$CentreID=$rs_selected_lab[0]['center_id'];
				}
				else
				{
					$obj_model_home_collection = $app->load_model("item_lab");
					$rs_selected_lab = $obj_model_home_collection->execute("SELECT", false, "","city_id='".$rs_cust_detail[$i]['customer_members_city_id']."' and lab_type='Main Lab'");
					$Panel_ID=$rs_selected_lab[0]['panel_id'];
					$CentreID=$rs_selected_lab[0]['center_id'];
				}
				
				$Address=$rs_cust_detail[$i]['customer_members_line1'];
				$city=$rs_city[0]['name'];
				$customer_members_id=$rs_cust_detail[$i]['customer_members_id'];
				$mobile=$rs_cust_detail[$i]['customer_members_phone1'];
				$email=$rs_customer[0]['email'];
				$designation=$rs_cust_detail[$i]['customer_members_prefix'];
				$fullName=$rs_cust_detail[$i]['customer_members_first_name'].' '.$rs_cust_detail[$i]['customer_members_last_name'];
				$gender=$rs_cust_detail[$i]['customer_members_gender'];
				$dob=$rs_cust_detail[$i]['customer_members_dob'];
				$age=$rs_cust_detail[$i]['customer_members_age'];
				$pincode=$rs_cust_detail[$i]['customer_members_pincode'];
				$area=$rs_cust_detail[$i]['customer_members_area'];
				$paymentAmount=0;

				//get order master detail of specific customer
				$obj_model_order_cust_detail_all= $app->load_model("customer_order_detail");
				$rs_cust_detail_all= $obj_model_order_cust_detail_all->execute("SELECT",false,"","customer_members_id='".$customer_members_id."' and order_master_id='".$orderID."'");
				unset($testList);
				$testList[]=array();
				
				$total_order_discount_amount=$rs_order_master[0]['discount'];
				if($total_order_discount_amount>0) {
					$discounted_prices = [];
					$product_prices=array_column($rs_cust_detail_all, 'total');
					foreach($product_prices as $price) {
						$discounted_price = round($price - ($price * $total_order_discount_amount / array_sum($product_prices)));
						$discounted_prices[]=$discounted_price;
					}
				}

				$tempI=0;
				foreach($rs_cust_detail_all as $key=>$value) {
					$DiscountAmt=$value['mrp']>$value['total']?($value['mrp']-$value['total']):0;
					if($total_order_discount_amount>0)
					{
						$DiscountAmt=$value['total']-$discounted_prices[$tempI];
					}
					$tempI++;
					$mrp=$value['mrp']>=$value['total']?$value['mrp']:$value['total'];
					$testList[]=[
						"testID" => $value['itemid'],
						"testCode" => $value['itemcode'],
						"Rate" => (int)$mrp,
						"integrationCode" => "",
						"dictionaryId" => "",
						"sampleId" => "",
						"DiscountAmt"=>$DiscountAmt
					];
					$paymentAmount+=$value['mrp'];
				}

				$orderNumber=$rs_order_master[0]['display_order_no'].'-'.$customer_members_id;
				
				unset($paymentList);
				$paymentList[]=array();
				$paymentList[]=[
					"paymentType" => $payment_type=='COD' ? 'COD' : 'Debit Card' ,
					"paymentAmount" => $payment_type=='COD' ? 0 : $paymentAmount-$total_order_discount_amount,
					"issueBank" => "",
					"chequeNo" => ""
				];
				
				unset($billDetails);
				$billDetails=array();
				$billDetails=[
					"emergencyFlag" => "0",
					"totalAmount" => $paymentAmount-$total_order_discount_amount,
					"advance" => "0",
					"billDate" => $billDate,
					"paymentType" => "CASH",
					"referralName" => "",
					"otherReferral" => "",
					"sampleId" => "",
					"orderNumber" => $orderNumber,
					"referralIdLH" => "",
					"organisationName" => "",
					"additionalAmount" => "0",
					"organizationIdLH" => "",
					"comments" => "",
					"testList" => $testList,
					"paymentList" => $paymentList
				];
				
				unset($data);
				$data=array();
				$data = [
					"Panel_ID" => $Panel_ID,
					"CentreID" => $CentreID,
					"mobile" => $mobile,
					"email" => $email,
					"designation" => $designation,
					"fullName" => $fullName,
					"age" => $age,
					"gender" => $gender,
					"area" => $area,
					"city" => $city,
					"Address" => $Address,
					"patientType" => "",
					"labPatientId" => "",
					"pincode" => $pincode,
					"patientId" => "",
					"dob" => $dob,
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
				
				//save json data that we pass in lis
				unset($data_other);
				$data_other=[];
				$data_other["call_for"] = 'Order';
				$data_other["send_json"] = $post_data;
				$data_other["send_on_time"] = date("d-m-Y H:i:s");
				$obj_order_lis_api_call = $app->load_model("lis_api_call");
				$obj_order_lis_api_call->map_fields($data_other);
				$lis_api_call_id=$obj_order_lis_api_call->execute("INSERT");
				
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
				$rest = mdrc_curl_exec($crl);
				$orderResponse=json_decode($rest,true);

				if(!empty($rest) && !empty($orderResponse))
				{
					unset($data_other);
					$data_other=[];
					$data_other["call_for"] = 'Order';
					$data_other["response_json"] = $rest;
					$data_other["response_on_time"] = date("d-m-Y H:i:s");
					$obj_order_lis_api_call = $app->load_model("lis_api_call");
					$obj_order_lis_api_call->map_fields($data_other);
					$obj_order_lis_api_call->execute("UPDATE",false,"","id='".$lis_api_call_id."'");

					 
					$lis_visitor_id=$orderResponse['reportDetails'][0]['ledgertransactionno'];
					$lis_visitor_pass=$orderResponse['reportDetails'][0]['Password_web'];

					unset($data_other);
					$data_other=[];
					$data_other["lis_visitor_id"] = $lis_visitor_id;
					$data_other["lis_visitor_pass"] = $lis_visitor_pass;
					$obj_order_lis_api_call = $app->load_model("customer_order_detail");
					$obj_order_lis_api_call->map_fields($data_other);
					$obj_order_lis_api_call->execute("UPDATE",false,"","order_master_id='".$orderID."' and customer_id='".$rs_order_master[0]['customer_id']."' and customer_members_id='".$customer_members_id."'");
				}
			}

			//update master table
			unset($data_other);
			$data_other=[];
			$data_other["lis_api_call"] = 'Yes';
			$obj_order_lis_api_call = $app->load_model("customer_order_master");
			$obj_order_lis_api_call->map_fields($data_other);
			$obj_order_lis_api_call->execute("UPDATE",false,"","id='".$orderID."'");

			$msg='Sucess';
			$msgcode=0;	
		}
		else {
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

echo $obj_json->encode(array("RESULT"=>$msgcode,"msg"=>$msg));
?> 