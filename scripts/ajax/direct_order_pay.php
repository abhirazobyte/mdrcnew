<?php

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$pay_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pay_name"));
$pay_email=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pay_email"));
$pay_phone=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pay_phone"));
$pay_amount=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pay_amount"));
$pay_message=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("pay_message"));

if($pay_amount=='' || !is_numeric($pay_amount) || $pay_email=='' || $pay_phone=='')
{
    $RESULT='NOT OK';
    $MSG='Please Enter Correct Data.';
    echo $obj_json->encode(["RESULT"=>$RESULT,"MSG"=>$MSG]);
    exit;
}

//create order					
$update_direct_payment_order = [];
$update_direct_payment_order["name"] = $pay_name;
$update_direct_payment_order["email"] = $pay_email;
$update_direct_payment_order["mobile"] = $pay_phone;
$update_direct_payment_order["amount"] = $pay_amount;
$update_direct_payment_order["message"] = $pay_message;
$update_direct_payment_order["ip"] = $_SERVER['REMOTE_ADDR'];
$update_direct_payment_order["created_date"] = date('d-m-Y H:i:s');
$obj_model_direct_payment_order = $app->load_model("direct_payment_order");
$obj_model_direct_payment_order->map_fields($update_direct_payment_order);
$diretPaymentOrderID=$obj_model_direct_payment_order->execute("INSERT");			

/* if($diretPaymentOrderID!='')
{
    include('../../ccavenue/Crypto.php');

    $merchant_id=CCA_MERCHANT_ID;
    $working_key = CCA_WORKING_KEY;
    $access_code = CCA_ACCESS_CODE;

    $language='EN';
    $currency='INR';
    $redirect_url="https://www.mdrcindia.com/index.php?view=paynow_payment_process";
    $cancel_url="https://www.mdrcindia.com/index.php?view=paynow_payment_process";

    $billing_address='';
    $billing_city='';
    $billing_state='';
    $billing_zip='';
    $billing_country='';

    $paramList=[];
    $paramList["merchant_id"] = $merchant_id;
    $paramList["language"] = $language;
    $paramList["order_id"] = 'D'.$diretPaymentOrderID;
    $paramList["amount"] = (int)$pay_amount;
    $paramList["currency"] = $currency;
    $paramList["redirect_url"] = $redirect_url;
    $paramList["cancel_url"] = $cancel_url;
    $paramList["customer_id"] = $diretPaymentOrderID;    
    $paramList["billing_name"] = $pay_name;
    $paramList["billing_address"] = $billing_address;
    $paramList["billing_city"] = $billing_city;
    $paramList["billing_state"] = $billing_state;
    $paramList["billing_zip"] = $billing_zip;
    $paramList["billing_country"] = $billing_country;
    $paramList["billing_tel"] = $pay_phone;
    $paramList["billing_email"] = $pay_email;

    foreach ($paramList as $key => $value)
    {
        $merchant_data.=$key.'='.$value.'&';
    }

    $encrypted_data=encrypt($merchant_data,$working_key); 

    $paymentGateway=[];
    $paymentGateway["encRequest"] = $encrypted_data;
    $paymentGateway["access_code"] = $access_code;
    
    $RESULT='OK';
    $MSG='Please Enter Correct Data.';
    echo $obj_json->encode(["RESULT"=>$RESULT,"MSG"=>$MSG,"paymentGateway"=>$paymentGateway]);
    exit;
}
else
{
    $RESULT='NOT OK';
    $MSG='Please Enter Correct Data.';
    echo $obj_json->encode(["RESULT"=>$RESULT,"MSG"=>$MSG]);
    exit;
} */

if($diretPaymentOrderID!='')
{
    include('../../razorpay-php/Razorpay.php');

    $pay_value=(int)$pay_amount;
    $amount = number_format($pay_value, '2', '.', '');
    $orderData = [
        'receipt'         => 'D'.$diretPaymentOrderID,
        'amount'          => $amount * 100,
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ];
    $url = "https://api.razorpay.com/v1/orders";
    $razor_order_id = $app->utility->razorpay_create_order($orderData, $url);

    $payment_data['razor_order_id']=$razor_order_id;
    $obj_model_payment_data=$app->load_model("direct_payment_order");
    $obj_model_payment_data->map_fields($payment_data);
    $obj_model_payment_data->execute("UPDATE",false,"","id='".$diretPaymentOrderID."'");

    $keyId = RAZOR_PAY_KEY;
    $keySecret = RAZOR_PAY_SECRET;

    $json = [
        "key"               => $keyId,
        "amount"            => $amount,
        "name"              => "Modern Diagnostic & Research Centre",
        "description"       => "Online Shopping Site",
        "image"             => "https://www.mdrcindia.com/images/logo.webp",
        "prefill"           => [
            "name"              => $pay_name,
            "email"             => $pay_email,
            "contact"           => $pay_phone,
        ],
        "notes"             => [
            "address"           => '',
        ],
        "theme"             => [
            "color"             => "#F37254"
        ],
        "order_id"          => $razor_order_id,
    ];
   
    $paymentGateway=[];
    $paymentGateway["json"] = $json;
    $paymentGateway["razor_order_id"] = $razor_order_id;
    
    $RESULT='OK';
    $MSG='Please Enter Correct Data.';
    echo $obj_json->encode(["RESULT"=>$RESULT,"MSG"=>$MSG,"paymentGateway"=>$paymentGateway]);
    exit;
}
else
{
    $RESULT='NOT OK';
    $MSG='Please Enter Correct Data.';
    echo $obj_json->encode(["RESULT"=>$RESULT,"MSG"=>$MSG]);
    exit;
}
?>