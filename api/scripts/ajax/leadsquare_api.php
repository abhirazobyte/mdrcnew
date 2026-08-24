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
	$obj_model_landing_lead->execute("INSERT",false,"","");

	echo "0";
	exit;
} else {
	echo "1";
}
