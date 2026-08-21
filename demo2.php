<?php



// PayU Credentials
$MERCHANT_KEY ="qMCGD8";
$SALT = "byHwqtYtwurlHbdWBDalT5eQMmyuSTDr";

// Live / Test URL
$txnid = 'TXN' . time(); // unique txn id
$amount = '10.00'; // amount
$command = 'generate_insta_account';
$surl = 'https://mdrcindia.com/success.php';
$furl = 'https://mdrcindia.com/failure.php';

// Generate hash
// $hash_string = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $SALT;
// $hash = strtolower(hash('sha512', $hash_string));

// PayU payment URL (sandbox)
$payu_url = 'https://secure.payu.in/merchant/postservice.php';

// Build full payment URL
$var1_array = [
    "name"                    => "Test Live test",
    "merchantVpa"             => "qr.6879729.prod12@indus",
    "qrType"                  => "upi",
    "city"                    => "South West",
    "pinCode"                 => "122002",
    "address"                 => "sector 46",
    "udf5"                    => "BFL113",
    "instaProduct"            => "qr",
    "submerchantRegistration" => "1",
    "mebussname"              => "Sltest1",
    "outputType"              => "string",
    "awlmcc"                  => "7999",
    "legalStrName"            => "Testaly",
    "panNo"                   => "BPEPK5437G",
    "strCntMobile"            => "9833270176"
];

$var1_json = json_encode($var1_array, JSON_UNESCAPED_SLASHES);

// compute hash as sha512(key|command|var1|salt)
$hash_string = $MERCHANT_KEY . '|' . $command . '|' . $var1_json . '|' . $SALT;
$hash = hash('sha512', $hash_string);

// prepare POST fields
$postFields = [
    'key'     => $MERCHANT_KEY,
    'command' => $command,
    'var1'    => $var1_json,
    'hash'    => $hash
];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://secure.payu.in/merchant/postservice.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => http_build_query($postFields),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

   
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "Response:\n" . $response;
}
exit;
curl_close($ch);
