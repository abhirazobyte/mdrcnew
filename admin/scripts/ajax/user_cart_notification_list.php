<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for   datatbale loading
if($get_actionType=="user_cart_notification")
{
	$table_name='customer_cart_notification_logs';

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
	$columnSortOrder = $orderArray[0]['dir']; // asc or desc
	$searchArray=$app->getPostVar('search');
	$searchValue = $searchArray['value']; // Search value
	
	$searchQuery = " ";

	$search_start_date=$app->getPostVar('search_start_date');
	$search_end_date=$app->getPostVar('search_end_date');
	if($search_start_date != '' && $search_end_date != '')
	{
		$search_start_date = date("Y-m-d", strtotime($search_start_date)); 
		$search_end_date = date("Y-m-d", strtotime($search_end_date));

		$searchQuery .= " and (STR_TO_DATE(customer_cart_notification_logs.entry_date_time, '%d-%m-%Y') BETWEEN '".$search_start_date."' AND '".$search_end_date."')";
	}

	if($searchValue != '')
	{
		$searchQuery = " and (
			".$table_name.".id like '%".$searchValue."%' or
			".$table_name.".title like '%".$searchValue."%' or
			".$table_name.".noti_desc like '%".$searchValue."%'
		) ";
	}
	
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("customer", "left", array(), array("customer_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "customer_cart_notification_logs.id!=0 ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		if($result[$i]['customer_id']!=0) {
			$customer_name = $result[$i]['customer_name']." ".$result[$i]['customer_last_name']."<br/>".$result[$i]['customer_phone']."<br/>".$result[$i]['customer_email'];
		} else {
			$customer_name = 'Guest User';
		}

		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"customer_name"=> $customer_name,
			"title"=>$result[$i]['title'],
			"noti_desc"=>$result[$i]['noti_desc'],
			"entry_date_time"=>$result[$i]['entry_date_time'],
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
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>