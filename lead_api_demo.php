<?php

// $ch = curl_init();

// $data=[
//     ["Attribute"=>"FirstName","Value"=>"Virag"],
//     ["Attribute"=>"LastName","Value"=>"Gandhi"],
//     ["Attribute"=>"EmailAddress","Value"=>"29virag@gmail.com"],
//     ["Attribute"=>"Phone","Value"=>"9510069163"],
//     ["Attribute"=>"mx_City","Value"=>"Delhi"],
//     ["Attribute"=>"Source","Value"=>"Website"],
//     ["Attribute"=>"Notes","Value"=>"MRI Scan"],
// ];
// curl_setopt($ch,CURLOPT_HTTPHEADER, 
//     array(
//         'Content-Type: application/json',
//     )
// );
// curl_setopt($ch, CURLOPT_URL,'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$rc2f00ef6fe1d0fb266468766c80938f6&secretKey=25ebf5a0fce5340a762c92064065b41cdfb35e41');
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));

// // Receive server response ...
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// $response = curl_exec($ch);

// if ($response === false) {
//     echo " (Error Code: " . curl_errno($ch) . ")";
//   } else {
//     $response=json_decode($response,true);
    


$url = "https://crm.mdrcindia.net/api/method/crm.integrations.website.webhooks.ingest_website_enquiry";

$apiKey = "2236b2f73d1cb2b";
$apiSecret = "a7a99e414903e5d";

$payload = [
  "name" => "John Doe",
  "email" => "john@example.com",
  "phone" => "9876543210",
  "message" => "Test enquiry from website"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: token {$apiKey}:{$apiSecret}"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch); exit;
} else {
    echo "HTTP Code: " . $httpCode . "<br>";
    echo "Response: " . $response; exit;
}

curl_close($ch);


echo 1111; exit;
$curl = curl_init();

$filePath = "/home/mdrcindia.com/html/uploads/prescription/abc1-1.jpg";
$mimeType = mime_content_type($filePath);

$curlFile = new CURLFile($filePath, $mimeType, basename($filePath));

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://files-in21.leadsquared.com/File/Upload',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('FileType' => '1','FileStorageType' => '0','EnableResize' => 'false','Id' => '7737ad19-47cf-4595-8185-d94c9f7920b9','SchemaName' => 'mx_Upload_Prescription','EntitySchemaName' => 'mx_CustomObject_111','Entity' => '0','StorageVersion' => '0','AccessKey' => 'u$rc2f00ef6fe1d0fb266468766c80938f6','SecretKey' => '25ebf5a0fce5340a762c92064065b41cdfb35e41','uploadFiles'=> $curlFile),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: multipart/form-data'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

exit;

    $ch = curl_init();
    $data=[
        //"uploadFiles"=>"/home/mdrcindia.com/html/images/logo.svg",
       "uploadFiles"=>"https://www.mdrcindia.com/images/logo.svg",
        "FileType"=>7,
        "FileStorageType"=>0,
        "EnableResize"=>false,
        "Id"=>"7737ad19-47cf-4595-8185-d94c9f7920b9",
        "SchemaName"=>"mx_CustomObject_111",
        "EntitySchemaName"=>"mx_Upload_Prescription",
        "Entity"=>0,
        "StorageVersion"=>0,
        "AccessKey"=>'u$rc2f00ef6fe1d0fb266468766c80938f6',
        "SecretKey"=>"25ebf5a0fce5340a762c92064065b41cdfb35e41"
    ];
    curl_setopt($ch,CURLOPT_HTTPHEADER, 
        array(
            'Content-Type: multipart/form-data',
        )
    );
    curl_setopt($ch, CURLOPT_URL,'https://files-in21.leadsquared.com/File/Upload?accessKey=u$rc2f00ef6fe1d0fb266468766c80938f6&secretKey=25ebf5a0fce5340a762c92064065b41cdfb35e41');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   

    $response1 = curl_exec($ch);
    print_r(json_decode($response1,true)); exit;
    if ($response1 === false) {
     
      echo " (Error Code: " . curl_errno($ch) . ")";
    } else {
    print_r(json_decode($response1,true)); exit;
    }
//   }

//   curl_close($ch);


// echo $response;exit;
