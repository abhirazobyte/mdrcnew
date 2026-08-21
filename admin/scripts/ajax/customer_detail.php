<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");


//Function for active vendor datatbale loading
if($get_actionType=="table_rechaegr_number")
{
	$table_name='order_master';

	$customer_id=$app->getGetVar("customer_id");
	
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
	
	## Search 
	$searchQuery = " ";
	if($searchValue != '')
	{
		$searchQuery = " and (	
		".$table_name.".id like '%".$searchValue."%' or 
		".$table_name.".master_no like '%".$searchValue."%' or 
		order_detail.category_name like '%".$searchValue."%' or 
		order_detail.operator_name like '%".$searchValue."%'
		) 
		";
	}
	
	
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false,"","`order_status`='Complete' and customer_id='".$customer_id."' GROUP BY master_no");
	$totalRecords = count($result);
	
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("order_detail", "left", array("order_master_id","operator_name","category_name","operator_image"), array("id"=>"order_master_id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".customer_id='".$customer_id."' and ".$table_name.".order_status='Complete' ".$searchQuery."","","".$table_name.".master_no");
	$totalRecordwithFilter = count($result);

	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("order_detail", "left", array("order_master_id","operator_name","category_name","operator_image"), array("id"=>"order_master_id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".customer_id='".$customer_id."' and ".$table_name.".order_status='Complete' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage."","".$table_name.".master_no");
	$serial = $row + 1;
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;
		$data[] = array
		(
			"id"=>$sr,
			"order_detail_category_name"=>$result[$i]['order_detail_category_name'],
			"order_detail_operator_name"=>$result[$i]['order_detail_operator_name'],
			"master_no"=>$result[$i]['master_no'],
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


?>