<?

define("VIR_DIR","scripts/LeadSquare/");
include("../../core/app.php");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
$app = & app::get_instance();
$app->initialize();
$gclId=[];
$date="2025-07-28";

	$url = 'https://api-in21.leadsquared.com/v2/LeadManagement.svc/Leads/Retrieve/BySearchParameter?accessKey=u$rc2f00ef6fe1d0fb266468766c80938f6&secretKey=25ebf5a0fce5340a762c92064065b41cdfb35e41';
	$postData = [
        "SearchParameters" => [
            "DefinitionType" => "1",
            "AdvancedSearchTextNew" => json_encode([
                "GrpConOp" => "And",
                "Conditions" => [
                    [
                        "Type" => "Lead",
                        "ConOp" => "and",
                        "RowCondition" => [
                            [
                                "SubConOp" => "And",
                                "LSO" => "mx_Date_of_Patient_Visit",
                                "LSO_Type" => "DateTime",
                                "Operator" => "between",
                                "RSO" => $date." TO ".$date,
                                "RSO_IsMailMerged" => false
                            ],
                            [ "RSO" => "" ],
                            [ "RSO" => "" ]
                        ]
                    ]
                ],
                "QueryTimeZone" => "India Standard Time"
            ])
        ],
        "Columns" => [
            "Include_CSV" => "*"
        ],
        "Sorting" => [
            "ColumnName" => "CreatedOn",
            "Direction" => "1"
        ],
        "Paging" => [
            "PageIndex" => 1,
            "PageSize" => 1000
        ]
    ];
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_POST, true);
    $response = mdrc_curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } 
    else 
    {
        if ($http_code == 200) {
            $results=json_decode($response, true);
           
            foreach($results['Leads'] as $lead)
            {
                $related_id=$lead['LeadPropertyList'][1]['Value'];

                $obj_model_check=$app->load_model("landing_lead");
		        $rs_check=$obj_model_check->execute("SELECT",false,"","lead_convert='No' and related_id='".$related_id."'");
               
                if(count($rs_check)>0 && !empty($rs_check[0]['mx_gclid']))
                {
                    $update_field=array();
                    $update_field['lead_convert'] ='Yes';
                    $update_field['lead_convert_at']=date('Y-m-d H:i:s');
                    $obj_model_user = $app->load_model("landing_lead");
                    $obj_model_user->map_fields($update_field);
                    $rs=$obj_model_user->execute("UPDATE",false,"","id='".$rs_check[0]['id']."'");
                    
                    $gclId[]=$rs_check[0]['mx_gclid'];
                }
            }
        } else {
            echo "HTTP Error Code: $http_code<br>";
            echo "Response: $response";
        }
    }
    curl_close($ch);
?>
<html>

<head>

   <script>
   (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M26TV87');
    </script>

</head>

<body>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M26TV87" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

</body>

<?php foreach ($gclId as $id){ ?>
<script>
    gtag('event', 'conversion', {
      'send_to': 'AW-10962550867/DEfFCNeYv_kYENOAreso',
      'gclid':'<?php echo $id; ?>'  
    });
</script>
<?php } ?>

</html>
