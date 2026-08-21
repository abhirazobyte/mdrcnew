<?php
include("../../core/app.php");
$app = &app::get_instance();
$app->initialize();

$obj_model_notification_settings=$app->load_model("generel_settings");
$setting = $obj_model_notification_settings->execute("SELECT");
if($setting[0]['cart_notification']==1)
{
    $startTime = date('Y-m-d H:i:s', strtotime('-2 hours'));
    $endTime = date('Y-m-d H:i:s', strtotime('-1 hour'));
    //$endTime = date('Y-m-d H:i:s');

    $logCheckStartTime = date('Y-m-d H:i:s', strtotime('-1 hours'));
    $logCheckEndTime = date('Y-m-d H:i:s');

    $obj_model_table=$app->load_model("customer_cart");
    $rs_item=$obj_model_table->execute("SELECT",false,"","STR_TO_DATE(entry_date_time, '%d-%m-%Y %H:%i:%s') BETWEEN '$startTime' AND '$endTime'");

    $user_ids = array_unique(array_column($rs_item, 'customer_id'));

    if(count($user_ids)>0)
    {
        $obj_model_cust = $app->load_model("customer_token");
        $rs_gcm = $obj_model_cust->execute("SELECT", false, "", "fcm_token!='' AND customer_id IN (" . implode(',', $user_ids) . ")", "");
        
        
        foreach($rs_gcm as $item)
        {
            $obj_model_table=$app->load_model("customer_cart_notification_logs");
            $rs_push_check=$obj_model_table->execute("SELECT",false,"","customer_id = '".$item['customer_id']."' AND STR_TO_DATE(entry_date_time, '%d-%m-%Y %H:%i:%s') BETWEEN '$logCheckStartTime' AND '$logCheckEndTime'");
        
            if(count($rs_push_check)==0)
            {
                $title=$setting[0]['cart_notification_title']??'Cart Reminder';
                $message=$setting[0]['cart_notification_desc']??'Cart Reminder Message';
                $data['customer_id']=$item['customer_id'];
                $data['title']=$title;
                $data['noti_desc']=$message;
                $data['entry_date_time']=date('d-m-Y H:i:s');
                $obj_table = $app->load_model("customer_cart_notification_logs");
                $obj_table->map_fields($data);
                $logId=$obj_table->execute("INSERT");
                $notificationData=array('title'=>$title,'image'=>'','message'=>$message,'type'=>'cart','body'=>$message,'click_action'=>'CartActivity');
                $app->utility->send_push_notifaction($notificationData,$item['fcm_token']);
            }	
        }
    }
}

 
$app->unload();
?>