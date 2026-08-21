<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$payMethod=$app->getGetVar("payMethod");
$_SESSION['payment_type']=$payMethod;
$show_coupon='Yes';
$show_wallet='Yes';
$show_min_price='No';
if($_SESSION['payment_type']=='ONLINE' && $_SESSION['min_price_amount']>0)
{
    $show_coupon='No';
    $show_wallet='No';
    $show_min_price='Yes';
}
$RESULT=0;
$distance_error_msg='';
                                      
echo $obj_json->encode(array("RESULT"=>$RESULT,"error_msg"=>$distance_error_msg,"orderSummeryHtml"=>"","show_coupon"=>$show_coupon,"show_wallet"=>$show_wallet,"show_min_price"=>$show_min_price));	

?>