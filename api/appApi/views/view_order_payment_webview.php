<!-- <script>
window.setTimeout(function() {
// Move to a new location or you can do something else
window.location.href = "https://www.mdrcindia.com/appApi/index.php?view=order_payment_webview&payment_status=failed&msg1=Your Booking done&msg2=Your Booking doneww";
}, 5000);
</script> -->
<html>
<meta name="robots" content="noindex">
<body>
<?php
    include('../ccavenue/Crypto.php');

    $merchant_id=CCA_MERCHANT_ID;
    $working_key = CCA_WORKING_KEY;
    $access_code = CCA_ACCESS_CODE;

    $language='EN';
    $currency='INR';
    $redirect_url=SERVER_ROOT.'/appApi/index.php?view=order_payment_process';
    $cancel_url=SERVER_ROOT.'/appApi/index.php?view=order_payment_process';

    $billing_address='';
    $billing_city='';
    $billing_state='';
    $billing_zip='';
    $billing_country='';

    $paramList=[];
    $paramList["merchant_id"] = $merchant_id;
    $paramList["language"] = $language;
    $paramList["order_id"] = $this->orderData['id'];
    $paramList["amount"] = $this->orderData['transaction_amount'];
    $paramList["currency"] = $currency;
    $paramList["redirect_url"] = $redirect_url;
    $paramList["cancel_url"] = $cancel_url;
    $paramList["customer_id"] = $this->orderData['customer_id'];    
    $paramList["billing_name"] = $this->orderData['customer_name'].' '.$this->orderData['customer_last_name'];
    $paramList["billing_address"] = $billing_address;
    $paramList["billing_city"] = $billing_city;
    $paramList["billing_state"] = $billing_state;
    $paramList["billing_zip"] = $billing_zip;
    $paramList["billing_country"] = 'India';
    $paramList["billing_tel"] = $this->orderData['customer_phone'];
    $paramList["billing_email"] = $this->orderData['customer_email'];

    $paramList["merchant_param1"] = $this->orderData['customer_id'];
    $paramList["merchant_param2"] = $this->orderData['order_master_id'];
    $paramList["merchant_param3"] = $this->orderData['customer_phone'];

    foreach ($paramList as $key => $value)
    {
        $merchant_data.=$key.'='.$value.'&';
    }

    $encrypted_data=encrypt($merchant_data,$working_key); 
    $cca_url=CCA_URL;
?>
<form method="post" name="redirect" action="<?=$cca_url?>">
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>