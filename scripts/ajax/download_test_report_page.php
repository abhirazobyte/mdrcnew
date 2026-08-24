<?php

$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
	
$visitor_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("visitor_id_page"));
$lab_password=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("lab_password_page"));

if($visitor_id!='' && $lab_password!='')
{
    if($visitor_id=='')
    {
        $RESULT='NOT OK';
        $MSG='Please Enter Valid Mobile Number.';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
        exit;
    }

    echo $obj_json->encode(array("RESULT"=>"NOT OK","MSG"=>mdrc_staging_disabled_message()));
    exit;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => '',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'WorkOrderID='.$visitor_id.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    $response = mdrc_curl_exec($curl);
    
    curl_close($curl);
    
    $api_response=$response?json_decode($response,true):[];
    if($api_response[0]['Booking_Status']=='')
    {
        $RESULT='NOT OK';
        $MSG='Please enter valid details.';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
        exit;
    }

    $button_html='';
    if($api_response[0]['Booking_Status']!='')
    {
        $PMPassword_webob=$api_response[0]['Password_web'];
        if($lab_password!=$PMPassword_webob)
        {
            $RESULT='NOT OK';
            $MSG='Please enter valid details.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
            exit;
        }

        $PName=$api_response[0]['PName'];
        $PMob=$api_response[0]['PMob'];
        $PMPassword_webob=$api_response[0]['Password_web'];
        $EntryDate=$api_response[0]['EntryDate'];
        $button_html.='<li><strong>Patient</strong> <div class="nx-rt">'.$PName.'</div></li>';
        $button_html.='<li><strong>Mobile</strong> <div class="nx-rt">'.$PMob.'</div></li>';
        $button_html.='<li><strong>Booking Date</strong> <div class="nx-rt">'.$EntryDate.'</div></li>';

        $report_ready=false;
        for($i=0;$i<count($api_response);$i++)
        {
            if($api_response[$i]['Booking_Status']=='Report Ready' || $api_response[$i]['Booking_Status']=='Dispatched' || $api_response[$i]['Booking_Status']=='Printed')
            {
                $report_ready=true;
            }
        }

        
        $table_html='<div class="mt-2 mb-2">';
        if($report_ready)
        {
            //$URL="";
            $URL="?page=new&reportid=".$visitor_id."_".$lab_password;
            $table_html.='<a href="'.$URL.'" class="btn w-100 btn-solid lnk btn-main bg-btn" target="_blank">Download Report <span class="circle"></span></a>';
        } else { 
            $table_html.='<a href="javascript:void(0)" class="btn w-100 btn-solid lnk btn-main bg-btn">Report is not Ready<span class="circle"></span></a>';
        }
        $table_html.='</div>
        <div class="cart-extra-sevc div-for-data">
            <h4 class="mb30">Test Information</h4>
            <div class="">
                <table class="table border"><tbody>';
        $table_html.='<tr>
        <th><strong>Item / Package</strong></th>
        <td><span class=""><b>Status</b></span></td>
        </tr>';

        for($i=0;$i<count($api_response);$i++)
        {
            $class="primary";

            if($api_response[$i]['Booking_Status']=='Report Ready' || $api_response[$i]['Booking_Status']=='Dispatched' || $api_response[$i]['Booking_Status']=='Printed')
            {
                $status_name='Report Ready';
                $class='success';
            }
            else if($api_response[$i]['Booking_Status']=='Sample Receive At Lab' || $api_response[$i]['Booking_Status']=='Rejected Test' || $api_response[$i]['Booking_Status']=='Sample Collected' || $api_response[$i]['Booking_Status']=='Tested' | $api_response[$i]['Booking_Status']=='Hold')
            {
                $status_name='Received in lab';
            }
            else
            {
                $status_name=$api_response[$i]['Booking_Status'];
            }
            $table_html.='<tr>
                <th><strong>'.$api_response[$i]['ItemName'].'</strong></th>
                <td><span class="text-'.$class.'">'.$status_name.'</span></td>
            </tr>';
        }
        if(count($api_response)<=0)
        {
            $table_html.='<tr>
            <th><strong>No report found.</strong></th>
            <td><span class="text-primary"></span></td>
            </tr>';
        }
        $table_html.='</tbody></table></div>
				</div>';

        if($report_ready)
        {
            $mobile=$api_response[0]['PMob']; 

            $RESULT='OK';
            $MSG='Please check report.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"URL"=>"?page=new&reportid=".$visitor_id."_".$lab_password,"button_html"=>$button_html,"table_html"=>$table_html));
            exit;
        }
        else
        {
            $RESULT='NOT OK';
            $MSG='Report is not ready.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"button_html"=>$button_html,"table_html"=>$table_html));
            exit;
        }
       

        /*
        $todaydate=date('d/m/Y');
        //$todaydate='19/01/2022';
        //$todaydate1='19/07/2022';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL =>  '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER =>array('Content-Length: 0')
        ));
        $response = mdrc_curl_exec($curl);

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
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"URL"=>""));
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