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
    $redirect_url="https://www.mdrcindia.com/webApi/index.php?view=pay_now_process";
    $cancel_url="https://www.mdrcindia.com/paynow-payment-failed";

    $billing_address='';
    $billing_city='';
    $billing_state='';
    $billing_zip='';
    $billing_country='';
    $pay_amount=$this->data['amount'];
    $pay_name=$this->data['name'];
    $pay_phone=$this->data['mobile'];
    $pay_email=$this->data['email'];
    $id = $this->data['id'];

    $paramList=[];
    $paramList["merchant_id"] = $merchant_id;
    $paramList["language"] = $language;
    $paramList["order_id"] = 'D'.$id;
    $paramList["amount"] = (int)$pay_amount;
    $paramList["currency"] = $currency;
    $paramList["redirect_url"] = $redirect_url;
    $paramList["cancel_url"] = $cancel_url;
    $paramList["customer_id"] = $id;
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