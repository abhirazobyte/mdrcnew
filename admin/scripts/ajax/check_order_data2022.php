<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action

$customer_id=$app->getPostVar("customer_id");
$subtotal=$app->getPostVar("subtotal1");



$from_pincode=$app->getPostVar("from_pincode");
$from_address=$app->getPostVar("from_address");

//Function for single zone delete
if($customer_id==0)
{
	echo $obj_json->encode(array("RESULT"=>"1","MSG"=>"Please Select Customer"));
	exit;
	
	
}

//Function for single zone delete
if($subtotal<=0 || $subtotal=='')
{
	echo $obj_json->encode(array("RESULT"=>"1","MSG"=>"Please Add Product."));
	exit;
	
	
}

if($from_pincode=='' || $from_address=='')
{
	echo $obj_json->encode(array("RESULT"=>"1","MSG"=>"Please Add Address."));
	exit;
	
}

echo $obj_json->encode(array("RESULT"=>"0","MSG"=>""));
exit;
			

?>