<?php

$fullName = $app->getPostVar("fullName");
$promoCode = $app->getPostVar("promo_code");
$mobile = $app->getPostVar("mobile");
$city = $app->getPostVar("city");
$page_url = $app->getPostVar("url");
$utmB = $app->getPostVar("utms");
$source = $app->getPostVar("source");
$mx_gclidB = $app->getPostVar("mx_gclids");
$mx_fbclidB = $app->getPostVar("mx_fbclids");
$mx_Ad_Name = $app->getPostVar("mx_Ad_Name");
$mx_Ad_Set = $app->getPostVar("mx_Ad_Set");
$mx_Campaign_Name = $app->getPostVar("mx_Campaign_Name");

if ($fullName!='' && $mobile!='' && $city!='') { 

	function cleanInput($value) {
		return ($value === 'null' || is_null($value)) ? '' : $value;
	}

	$data=array();
	$data['name']=$fullName;
	$data['mobile']=$mobile;
	$data['city']=$city;
	$data['url']=$page_url;
	$data['utm'] = cleanInput($utmB);
	$data['source'] = cleanInput($source);
	$data['mx_gclid'] = cleanInput($mx_gclidB);
	$data['mx_fbclid'] = cleanInput($mx_fbclidB);
	$data['mx_ad_name'] = cleanInput($mx_Ad_Name);
	$data['mx_ad_set'] = cleanInput($mx_Ad_Set);
	$data['mx_campaign_name'] = cleanInput($mx_Campaign_Name);
	$data['lead_convert'] = 'No';
	$data['lead_convert_at'] = NULL;
	$data['lead_id']='';
	$data['related_id']=''; 
	$data['promo_code']=$promoCode;

	$obj_model_landing_lead = $app->load_model("landing_lead");
	$obj_model_landing_lead->map_fields($data);
	$lastId = $obj_model_landing_lead->execute("INSERT",false,"","");


	$API_URL = 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture';
	$ACCESS_KEY = 'u$rc2f00ef6fe1d0fb266468766c80938f6';
	$SECRET_KEY = '25ebf5a0fce5340a762c92064065b41cdfb35e41';
	$COMPANY_ID = '82a19544-ef4f-4cef-a09c-d68b939742f9';

	$uuid= sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        (mt_rand(0, 0x0fff) & 0x0fff) | 0x4000, // 4xxx (UUID version 4)
        (mt_rand(0, 0x3fff) & 0x3fff) | 0x8000, // yxxx (UUID variant 1)
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );

	$url = $API_URL.'?accessKey='.$ACCESS_KEY.'&secretKey='.$SECRET_KEY;

	// $payload = [
	// 	["Attribute" => "FirstName", "Value" => $fullName],
	// 	["Attribute" => "LastName", "Value" => "Google form"],
	// 	["Attribute" => "EmailAddress", "Value" => "wim.googleform@example.com"],
	// 	["Attribute" => "mx_City", "Value" => $city],
	// 	["Attribute" => "Phone", "Value" => $mobile],
	// 	["Attribute" => "ProspectID", "Value" => $uuid],
	// 	["Attribute" => "SearchBy", "Value" => "Phone"],
	// 	["Attribute" => "RelatedCompanyId", "Value" => $companyId]
	// ];

	$payload = [
		["Attribute" => "FirstName", "Value" => $fullName],
		["Attribute" => "mx_City", "Value" => $city],
		["Attribute" => "Phone", "Value" => $mobile],
		["Attribute" => "ProspectID", "Value" => $uuid],
		["Attribute" => "RelatedCompanyId", "Value" => $companyId],
		["Attribute" => "mx_URL_Landing_page", "Value" => $page_url],
		["Attribute" => "mx_UTM_SOURCE", "Value" => $utmB],
		["Attribute" => "SourceCampaign", "Value" => $source],
		["Attribute" => "mx_gclid", "Value" => $mx_gclidB],
		["Attribute" => "mx_fbclid", "Value" => $mx_fbclidB],
		["Attribute" => "mx_Ad_Name", "Value" => $mx_Ad_Name],
		["Attribute" => "mx_Ad_Set", "Value" => $mx_Ad_Set],
		["Attribute" => "mx_Campaign_Name", "Value" => $mx_Campaign_Name],
		["Attribute" => "mx_Coupon_code", "Value" => $promoCode],
	];

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
	$response = curl_exec($ch);
	curl_close($ch);
	
	
	$curlData = json_decode($response,true);
	$dataB=array();
	$dataB['lead_id']=$curlData['Message']['Id'];
	$dataB['related_id']=$curlData['Message']['RelatedId'];
	$obj_model_landing_leadB = $app->load_model("landing_lead");
	$obj_model_landing_leadB->map_fields($dataB);
	$obj_model_landing_leadB->execute("UPDATE",false,"","id='".$lastId."'");
	echo "0";
	exit;
} else {
	echo "1";
}