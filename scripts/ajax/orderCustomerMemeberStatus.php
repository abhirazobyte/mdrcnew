<?php
if(!isset($_SESSION['track_orders']))
{
    $_SESSION['track_orders']=[];
}
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$track_orderID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("track-orderID"));
$track_orderCustomerMemeberID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("track-orderCustomerMemeberID"));

$orderID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("orderID"));
$orderCustomerMemeberID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("orderCustomerMemeberID"));

$orderID=$track_orderID==''?$orderID:$track_orderID;
$orderCustomerMemeberID=$track_orderCustomerMemeberID==''?$orderCustomerMemeberID:$track_orderCustomerMemeberID;

$track_password=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("tracking-password"));

if($orderID!='' && $orderCustomerMemeberID!='')
{
    $obj_model_order_cust_detail= $app->load_model("customer_order_detail");
    $obj_model_order_cust_detail->join_table("customer_members", "left", array(), array("customer_members_id"=>"id"));
    $obj_model_order_cust_detail->join_table("customer_order_master", "left", array("display_order_no"), array("order_master_id"=>"id"));
    $rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","order_master_id='".$orderID."' and customer_order_detail.customer_members_id='".$orderCustomerMemeberID."'");

    if(count($rs_cust_detail)<=0 || $_SESSION['MDRCCustID']<=0)
    {
        $RESULT='NOT OK';
        $MSG='Please try after sometime.';
        $no_detail_html='<div class="col-lg-12 text-center">
				<img class="carimg" src="images/empry-cart-main.png">
				<h5 class="mt-0">Still Searching</h5>
				<p class="fs-14">Please try after sometime.</p>
        </div>';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"HTML"=>$no_detail_html));
        exit;
    }

    $visitor_id=$rs_cust_detail[0]['lis_visitor_id'];

    //check in session where password is blank
    if(!in_array($visitor_id,$_SESSION['track_orders']) && $track_password==''){
        //will ask password
        echo $obj_json->encode(array("RESULT"=>'AskPassword',"MSG"=>'',"orderID"=>$orderID,"orderCustomerMemeberID"=>$orderCustomerMemeberID));
        exit;
    }
    //end check session

    $lab_password=$rs_cust_detail[0]['lis_visitor_pass'];
    //$visitor_id='MGUR154102';
    //$lab_password='B3F4B2';
    $orderNo=$rs_cust_detail[0]['customer_order_master_display_order_no'];
    $customerName=$rs_cust_detail[0]['customer_members_prefix'].' '.$rs_cust_detail[0]['customer_members_first_name'].' '.$rs_cust_detail[0]['customer_members_last_name'];
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
    $response = mdrc_curl_exec($curl);
    curl_close($curl);
    
    $api_response=$response?json_decode($response,true):[];
    
    if($api_response[0]['Booking_Status']=='')
    {
        $RESULT='NOT OK';
        $MSG='Please enter valid details.';
        $no_detail_html='<div class="col-lg-12 text-center">
				<img class="carimg" src="images/empry-cart-main.png">
				<h5 class="mt-0">Please enter valid details. </h5>
        </div>';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"HTML"=>$no_detail_html));
        exit;
    }

    $button_html='';
    if($api_response[0]['Booking_Status']!='')
    {
        $PMPassword_webob=$api_response[0]['Password_web'];
        if(!empty($track_password) && $track_password!=$PMPassword_webob)
        {
            $RESULT='NOT OK';
            $MSG='Please enter valid details.';
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"orderID"=>$orderID,"orderCustomerMemeberID"=>$orderCustomerMemeberID));
            exit;
        }

        if(!empty($track_password) && $track_password==$PMPassword_webob)
        {
            //add in session for next time
            array_push($_SESSION['track_orders'],$visitor_id);
        }

        $PName=$api_response[0]['PName'];
        $PMob=$api_response[0]['PMob'];
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

        if($report_ready)
        {
            $URL="http://182.156.200.228/mdrcnew/Design/Lab/labreportnew.aspx?reportid=".$visitor_id."_".$lab_password;
            $button_html.='<li><a href="'.$URL.'" class="btn-main bg-btn3 lnk w-100 mt10">Download Report<span class="circle"></span> </a></li>';
        } else { 
            $button_html.='<li><a href="javascript:void(0)" class="btn-main bg-btn5 lnk w-100 mt10">Report is not Ready<span class="circle"></span> </a></li>';
        }
        
        $table_html='<table class="table border"><tbody>';
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
        $table_html.='</tbody></table>';


        $mobile=$api_response[0]['PMob']; 

        $RESULT='OK';
        $MSG='Please check report.';
        $HTML='<h5 class="pt-3 pb-0">Order Number '.$orderNo.'</h5>';
        $HTML.='<div class="col-lg-12 col-md-12 col-12 mt20">
        <div class="rpb-item-infodv">
        <ul class="button_html">
        '.$button_html.'
        </ul>
        </div></div>';
        $HTML.='<div class="col-lg-12 col-md-12 col-12">
        <h4 class="">Test Information</h4>
        '.$table_html.'
        </div>';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"HTML"=>$HTML));
        exit;

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
            echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"API"=>$api_response,"URL"=>"http://182.156.200.228/mdrcnew/Design/Lab/labreportnew.aspx?reportid=".$visitor_id."_".$lab_password));
            exit;
        }*/

       
    } else {
        $RESULT='NOT OK';
        $MSG='Report is not ready.';
        $HTML='<div class="col-lg-12 text-center">
				<img class="carimg" src="images/empry-cart-main.png">
				<h5 class="mt-0">Report is not ready.</h5>
        </div>';
        echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"HTML"=>$HTML));
        exit;
    }

} else {
    $RESULT='NOT OK';
    $MSG='Error';
    $HTML='<div class="col-lg-12 text-center">
				<img class="carimg" src="images/empry-cart-main.png">
				<h5 class="mt-0">Error.</h5>
    </div>';
    echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG,"HTML"=>$HTML));
    exit;
}	
?>