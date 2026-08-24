<?php

$apiKey = 'AIzaSyCMdIvv5Ajq0gtKqb7G3Yf-wHqsXZkq2rI';
				$directionsUrl = "https://maps.googleapis.com/maps/api/directions/json?origin=28.253391,77.0647211&destination=28.2542947,77.0659803&key=$apiKey";
        
				$response = file_get_contents($directionsUrl);
                
				$data = json_decode($response, true);
		
				// Extract distance in KM
				if (!empty($data['routes'][0]['legs'][0]['distance']['text'])) {
					$distance = $data['routes'][0]['legs'][0]['distance']['text'];
				}
echo "Distance: " . $distance;exit;
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 			echo "<h2>Payment Failed Response</h2>";
// 			echo "<pre>";
// 			print_r($_POST); // Show all PayU response fields
// 			echo "</pre>";
// 		} else {
// 			echo "No data received!";
// 		}
//         exit;

// PayU Credentials
$MERCHANT_KEY ="qMCGD8";
$SALT = "byHwqtYtwurlHbdWBDalT5eQMmyuSTDr";

// Live / Test URL
$txnid = 'TXN' . time(); // unique txn id
$amount = '10.00'; // amount
$productinfo = 'Test Product';
$firstname = 'Customer';
$email = 'customer@example.com';
$phone = '9999999999';
$surl = 'https://mdrcindia.com/success.php';
$furl = 'https://mdrcindia.com/failure.php';

// Generate hash
$hash_string = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $SALT;
$hash = strtolower(hash('sha512', $hash_string));

// PayU payment URL (sandbox)
$payu_url = 'https://secure.payu.in/_payment';

// Build full payment URL
$paymentParams = [
    'key' => $MERCHANT_KEY,
    'txnid' => $txnid,
    'amount' => $amount,
    'productinfo' => $productinfo,
    'firstname' => $firstname,
    'email' => $email,
    'phone' => $phone,
    'surl' => $surl,
    'furl' => $furl,
    'pg'   =>'QR',
    'bankcode'=>'UPIQR',
    's2s_client_ip'=>'122.162.6.246',
    's2s_device_info'=>'chrome',
    'txn_s2s_flow'=>4,
    'hash' => $hash
];

// $full_url = $payu_url . '?' . http_build_query($paymentParams);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $payu_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "accept: text/plain",
    "content-type: application/x-www-form-urlencoded"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($paymentParams));

$response = mdrc_curl_exec($ch);
echo $response;exit;
$base64=base64_decode('PGh0bWw+PGJvZHk+PGZvcm0gbmFtZT0icGF5bWVudF9wb3N0IiBpZD0icGF5bWVudF9wb3N0IiBhY3Rpb249Imh0dHBzOi8vYXBpLnBheXUuaW4vcHVibGljLyMvMTIwZTI1YjQ1MGY2NDNlMzEwMzc3YmQ4OWU5Y2ZlNWQvcXJMb2FkZXI\/bW9iaWxlQ2hlY2tvdXQ9MCIgbWV0aG9kPSJnZXQiPjwvZm9ybT48c2NyaXB0IHR5cGU9J3RleHQvamF2YXNjcmlwdCc+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICB3aW5kb3cub25sb2FkPWZ1bmN0aW9uKCl7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9jdW1lbnQuZm9ybXNbJ3BheW1lbnRfcG9zdCddLnN1Ym1pdCgpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICA8L3NjcmlwdD48L2JvZHk+PC9odG1sPg==');
echo $base64;exit;
   echo "<img src='data:image/png;base64," . $base64 . "' alt='UPI QR Code' />";
   exit;
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "Response:\n" . $response;
}

curl_close($ch);
