<?php

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
	
$visitor_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("visitor_id"));
$lab_password=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("lab_password"));

if($visitor_id!='' && $lab_password!='')
{
    if($visitor_id=='')
    {
        $RESULT='NOT OK';
        $MSG='Please Enter Valid Mobile Number.';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
        exit;
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => LIS_API_URL.'/BookingAPI/TestStatusAPI',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'WorkOrderID='.$visitor_id.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    
    $api_response=$response?json_decode($response,true):[];
    
    if($api_response[0]['Booking_Status']=='')
    {
        $RESULT='NOT OK';
        $MSG='Please enter valid details.';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
        exit;
    }

    if($api_response[0]['Booking_Status']!='')
    {
        $report_ready=false;
        for($i=0;$i<count($api_response);$i++)
        {
            if($api_response[$i]['Booking_Status']=='Report Ready')
            {
                $report_ready=true;
            }
        }
        
        if($report_ready)
        {
            $mobile=$api_response[0]['PMob']; 

            $RESULT='OK';
            $MSG='Please check report.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"URL"=>"https://lis6.mdrcindia.com/mdrcnew/Design/Lab/labreportnew.aspx?reportid=".$visitor_id."_".$lab_password));
            exit;
        }
        else
        {
            $RESULT='NOT OK';
            $MSG='Report is not ready.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
            exit;
        }
       

        /*
        $todaydate=date('d/m/Y');
        //$todaydate='19/01/2022';
        //$todaydate1='19/07/2022';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL =>  LIS_API_URL.'/PatientLabReport/LabReportLink?FromDate='.$todaydate.'&ToDate='.$todaydate1.'&MobileNo='.$mobile,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER =>array('Content-Length: 0')
        ));
        $response = curl_exec($curl);

        $api_response=$response?json_decode($response,true):[];

        if(empty($api_response['message'])) {
            $RESULT='NOT OK';
            $MSG='Try Again.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
            exit;
        }
        
        if($api_response['message']=='No Record Found') {
            $RESULT='NO_REPORT';
            $MSG=$api_response['message'];
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response));
            exit;
        }

        if($api_response['success']=='true') {
            $RESULT='OK';
            $MSG=$api_response['message'];
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"URL"=>"http://182.156.200.228/mdrcnew/Design/Lab/labreportnew.aspx?reportid=".$visitor_id."_".$lab_password));
            exit;
        }*/

       
    } else {
        $RESULT='NOT OK';
        $MSG='Report is not ready.';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
        exit;
    }

} else {
    $RESULT='NOT OK';
    $MSG='Error';
    echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
    exit;
}	
?>