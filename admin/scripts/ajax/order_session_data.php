<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$order_from_date=$app->getPostVar("order_from_date");
$order_to_date=$app->getPostVar("order_to_date");
$order_delivery_date=$app->getPostVar("order_delivery_date");
$search_delivery_boy=$app->getPostVar("search_delivery_boy");
$search_type=$app->getPostVar("search_type");

$_SESSION['search_start_date']=$order_from_date;
$_SESSION['search_end_date']=$order_to_date;
$_SESSION['search_del_date']=$order_delivery_date;

$_SESSION['search_type']=$search_type;
$_SESSION['search_delivery_boy']=$search_delivery_boy;

echo $obj_json->encode(array("RESULT"=>"0","url"=>"","msg"=>"Success"));
?>