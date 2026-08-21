<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active zone datatbale loading
if($get_actionType=="order_list")
{
	$table_name='customer_order_master';

	$current_status=$app->getGetVar("current_status");
	if($current_status!='')
	{
		$status_cond=" AND ".$table_name.".order_status='".$current_status."'";
	}
	else
	{
		$status_cond="";
	}

	

	$search_cond='';
	$search_cond.=$_SESSION['search_test']!=''?" AND customer_order_detail.order_item_name like '%".$_SESSION['search_test']."%'":"";
	$search_cond.=$_SESSION['search_order_status']!=''?" AND ".$table_name.".order_status='".$_SESSION['search_order_status']."'":"";
	$search_cond.=$_SESSION['search_city']!=''?" AND ".$table_name.".city_id='".$_SESSION['search_city']."'":"";
	$search_cond.=$_SESSION['search_cust_name']!=''?" AND customer.name like '%".$_SESSION['search_cust_name']."%'":"";
	$search_cond.=$_SESSION['search_cust_email']!=''?" AND customer.email like '%".$_SESSION['search_cust_email']."%'":"";
	$search_cond.=$_SESSION['search_cust_phone']!=''?" AND customer.phone like '%".$_SESSION['search_cust_phone']."%'":"";
	$search_cond.=$_SESSION['search_start_order_date']!=''?" AND STR_TO_DATE(`order_date`, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$_SESSION['search_start_order_date']."', '%d-%m-%Y') AND STR_TO_DATE('".$_SESSION['search_end_order_date']."', '%d-%m-%Y')":"";
	
	## Read value
	$draw = $app->getPostVar('draw');
	$row = $app->getPostVar('start');
	$rowperpage = $app->getPostVar('length'); // Rows display per page
	$orderArray = $app->getPostVar('order');
	$columnIndex = $orderArray[0]['column']; // Column index
	$columnArray = $app->getPostVar('columns');
	$columnName = $columnArray[$columnIndex]['data']; // Column name
	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')
	{
		$columnName='id';
	}
	$columnSortorder = $orderArray[0]['dir']; // asc or desc
	$searchArray=$app->getPostVar('search');
	$searchValue = $searchArray['value']; // Search value
	## Search
	$searchQuery = " ";
	if($searchValue != '')
	{
		$searchQuery = " and (
		".$table_name.".id like '".$searchValue."%' or
		".$table_name.".display_order_no like '".$searchValue."%' or
		customer.name like '%".$searchValue."%' or
		customer.last_name like '%".$searchValue."%' or
		customer.phone like '%".$searchValue."%' or
		city.name like '%".$searchValue."%' or
		".$table_name.".net_order_value like '%".$searchValue."%' or
		".$table_name.".order_status like '%".$searchValue."%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.". id!=0 ".$status_cond."");
	$totalRecords = $result[0]['allcount'];

	## Total number of records with filtering
	$join_cond=$_SESSION['search_test']!=''?" LEFT JOIN customer_order_detail as customer_order_detail on (customer_order_master.id=customer_order_detail.order_master_id)":"";
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,city.name AS city_name ,customer.name AS customer_name,customer.last_name AS customer_last_name,customer.phone AS customer_phone
	from ".$table_name."
	LEFT JOIN customer AS customer ON(customer.id=".$table_name.".customer_id)
	LEFT JOIN city AS city ON(city.id=".$table_name.".city_id) 
	".$join_cond." 
	where  ".$table_name.".id!=0 ".$search_cond." ".$status_cond."  ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];

	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("customer", "left", array( "name","phone","last_name"), array("customer_id"=>"id"));
	$obj_brand->join_table("city","left", array("name"), array("city_id"=>"id"));
	if($_SESSION['search_test']!='')
	{
		$obj_brand->join_table("customer_order_detail","left", array("order_item_name"), array("id"=>"order_master_id"));
	}
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0 ".$search_cond." ".$status_cond." ".$searchQuery.""," ".$columnName." ".$columnSortorder." limit ".$row.",".$rowperpage." ");
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$item=$result[$i];
		$order_from=$item['order_from'];
		$displayID=$item['display_order_no'];
		$customer_name=$item['customer_name'].' '.$item['customer_last_name'].'<br/>'.$item['customer_phone'];
		$order_total=$item['net_order_value'];
		$payment_type=$item['payment_type'];
		$payment_status=$item['payment_status'];
		$book_date=$item['order_date'];
		$status=$item['order_status'];
		$o_day=date("l", strtotime($book_date));
		$o_date=date("d M Y", strtotime($book_date));
		$delivery_date=$item['delivery_date'];
		$delivery_time=$item['delivery_time'];
		$order_admin_html='<b>'.$order_from.'</b>';
		$order_date=$item['order_date']."<br/>".$order_type.$order_admin_html;
		$delivery_boy_name='';
		$schedule_text="".$delivery_date."<br/>".$delivery_time."".$delivery_boy_name;
		$total='<i class="fas fa-rupee-sign"></i>'.$order_total;
		$status=$app->utility->o_status_html2020($result[$i]['order_status']);
		$edit_btn='';

		$detail_btn='<a href="index.php?view=order_detail&id='.$result[$i]['id'].'" class="btn btn-xs btn-info btn-icon mg-r-5"><i class="fas fa-play"></i></a>';

		if($item['lis_api_call']=='No' && (($item['payment_type']=='ONLINE' && $item['order_status']!='Cancelled') || ($item['payment_type']=='COD' && $item['order_status']!='Cancelled')))
		{
			$api_btn='<button type="button" class="btn btn-xs btn-warning btn-icon order_api_onclick order_api_onclick_'.$result[$i]['id'].'" data-id="'.$result[$i]['id'].'"><i class="fas fa-info"></i></button>';	
		}
		else
		{
			$api_btn='';
		}
		
		$option='<div class="btn-toolbar"><div>'.$detail_btn.' '.$api_btn.'</div></div>';

		//data
		$data[] = array
		(
			"id"=>'<a href="javascript:void(0)"  >'.$displayID.'</a>',
			"order_date"=>$order_date,
			"customer_name"=>$customer_name,
			"city_name"=>$result[$i]['city_name'],
			"total"=>$total."<br>".$payment_type,
			"status"=>$status,
			"btn"=>$option
		);
	}
	## Response
	$response = array(
	"draw" => $draw,
	"iTotalRecords" => $totalRecords,
	"iTotalDisplayRecords" => $totalRecordwithFilter,
	"aaData" => $data
	);
	echo json_encode($response);
	exit;
}


//Function for single orderStatusChange delete
if($actionType=="orderStatusChange")
{
	$order_master_id=$app->getPostVar('order_master_id');
	$order_status=$app->getPostVar('order_status');
	$customer_id=$app->getPostVar('customer_id');
	$sms_send=$app->getPostVar('sms_send');
	$remark=$app->getPostVar('remark');
	$remark_other=$app->getPostVar('remark_other');
	if($order_master_id!= NULL && $order_master_id>0 && $order_status!='')
	{
		
		$update_field = array();
		$update_field['order_status'] = $order_status;
		$obj_model_customer_order_master = $app->load_model("customer_order_master");
		$obj_model_customer_order_master->map_fields($update_field);
		$rs=$obj_model_customer_order_master->execute("UPDATE",false,"","id='".$order_master_id."'");
		
		if($rs>0)
		{
			$update_field2 = array();
			$update_field2['order_master_id'] = $order_master_id;
			$update_field2['customer_id'] = $customer_id;
			$update_field2['o_status'] = $order_status;
			$update_field2['remark'] = $remark;
			$update_field2['remark_other'] = $remark_other;
			$update_field2['entry_date'] = date('d-m-Y');
			$update_field2['entry_date_time'] = date('d-m-Y H:i:s');
			$update_field2['entry_from'] = 'Admin';
			$update_field2['ip'] =$_SERVER['REMOTE_ADDR'];
			$obj_model_status_history = $app->load_model("customer_order_status_history");
			$obj_model_status_history->map_fields($update_field2);
			$obj_model_status_history->execute("INSERT",false,"","id='".$order_master_id."'");

			if($sms_send=='Yes' && ($order_status=='Confirmed' || $order_status=='Canceled'))
			{
				$obj_model_customer= $app->load_model("customer");
				$rs_customer = $obj_model_customer->execute("SELECT", false, "","id='".$customer_id."'");
				$full_name=$rs_customer[0]['name']." ".$rs_customer[0]['last_name'];
				$Order_ID='#'.$order_master_id;
				$phone=$rs_customer[0]['phone'];
				if($order_status=='Confirmed')
				{
					$sms_type='confirm_booking';
				}
				else if($order_status=='Canceled')
				{
					$sms_type='order_cancel';
				}

				$default_string = array("{name}","{order_ID}");
				$new_string   = array($full_name,$Order_ID);                                                               
				$app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);									
			}

			$msg='Success';
			$msgcode=0;
		}
		else
		{
			$msg='Please Try Again.';
			$msgcode=1;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;	
	}
}

//Function for single orderStatusChange delete
if($actionType=="smsTextGet")
{
	$status=$app->getPostVar('status');
	$customer_id=$app->getPostVar('customer_id');
	$order_master_id=$app->getPostVar('order_master_id');
	
	if($status=='Confirmed' || $status=='Canceled' && ($order_master_id!='' && $customer_id!=''))
	{
		if($status=='Confirmed')
		{
			$sms_type='confirm_booking';
		}
		else if($status=='Canceled')
		{
			$sms_type='order_cancel';
		}

		$obj_model_customer= $app->load_model("customer");
		$rs_customer = $obj_model_customer->execute("SELECT", false, "","id='".$customer_id."'");
		$full_name=$rs_customer[0]['name']." ".$rs_customer[0]['last_name'];
		$Order_ID='#'.$order_master_id;

		$obj_model_tabel = $app->load_model("sms_data");
		$rs_data = $obj_model_tabel->execute("SELECT", false, "", "name='".$sms_type."' and status='Active'");
		if(count($rs_data)>0)
		{
			$default_string = array("{name}","{order_ID}");
			$new_string   = array($full_name,$Order_ID);
			$sms_text=$rs_data[0]['sms_text'];
			$message_text=str_replace($default_string, $new_string, $sms_text);
			$msg=$message_text;
			$msgcode=0;
		}

	}
}

if($actionType=="updateLisVisitorinfo")
{
	$lis_visitor_id=$app->getPostVar('lis_visitor_id');
	$lis_visitor_pass=$app->getPostVar('lis_visitor_pass');
	$lis_order_detail_id=$app->getPostVar('lis_order_detail_id');
	if($lis_order_detail_id!='' && $lis_visitor_id!='')
	{
		$obj_model_lis_order= $app->load_model("customer_order_detail");
		$lis_order = $obj_model_lis_order->execute("SELECT", false, "","id='".$lis_order_detail_id."'");
		if(count($lis_order)>0) {
			$update_field2 = array();
			$update_field2['lis_visitor_id'] = $lis_visitor_id;
			$update_field2['lis_visitor_pass'] = $lis_visitor_pass;
			$obj_model_status_history = $app->load_model("customer_order_detail");
			$obj_model_status_history->map_fields($update_field2);
			$obj_model_status_history->execute("UPDATE",false,"","order_master_id='".$lis_order[0]['order_master_id']."' and customer_id='".$lis_order[0]['customer_id']."' and customer_members_id='".$lis_order[0]['customer_members_id']."'");

			$update_field2 = array();
			$update_field2['lis_api_call'] = 'Yes';
			$obj_model_status_history = $app->load_model("customer_order_master");
			$obj_model_status_history->map_fields($update_field2);
			$obj_model_status_history->execute("UPDATE",false,"","id='".$lis_order[0]['order_master_id']."'");
			
			$msg='Details updated.';
			$msgcode=0;	
		} else {
			$msg='Please Try Again.';
			$msgcode=1;	
		}
	} else {
		$msg='Please Try Again.';
		$msgcode=1;	
	}
}

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>
