<?php
    include('ccavenue/Crypto.php');

    $merchant_id=CCA_MERCHANT_ID;
    $working_key = CCA_WORKING_KEY;
    $access_code = CCA_ACCESS_CODE;

    $language='EN';
    $currency='INR';
    $redirect_url=CCA_RETURN_URL;
    $cancel_url=CCA_CANCEL_URL;

    $billing_address='';
    $billing_city='';
    $billing_state='';
    $billing_zip='';
    $billing_country='';

    $paramList=[];
    $paramList["merchant_id"] = $merchant_id;
    $paramList["language"] = $language;
    $paramList["order_id"] = $_SESSION['orderPayID'];
    $paramList["amount"] = $_SESSION['Transaction_Amount'];
    $paramList["currency"] = $currency;
    $paramList["redirect_url"] = $redirect_url;
    $paramList["cancel_url"] = $cancel_url;
    $paramList["customer_id"] = $_SESSION['MDRCCustID'];    
    $paramList["billing_name"] = $_SESSION['MDRCCustFirstName'].' '.$_SESSION['MDRCCustLastName'];
    $paramList["billing_address"] = $billing_address;
    $paramList["billing_city"] = $billing_city;
    $paramList["billing_state"] = $billing_state;
    $paramList["billing_zip"] = $billing_zip;
    $paramList["billing_country"] = $billing_country;
    $paramList["billing_tel"] = $_SESSION['MDRCCustPhone'];
    $paramList["billing_email"] = $_SESSION['MDRCCustEmail'];

    $paramList["merchant_param1"] = $_SESSION['MDRCCustID'];
    $paramList["merchant_param2"] = $_SESSION['orderID'];
    $paramList["merchant_param3"] = $_SESSION['MDRCCustPhone'];

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