<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for   datatbale loading
if($get_actionType=="user_cart")
{
	$table_name='customer_cart';

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
		$searchQuery .= " and (STR_TO_DATE(customer_cart.entry_date_time, '%d-%m-%Y') BETWEEN '".$search_start_date."' AND '".$search_end_date."')";
	}

	$search_city_id=$app->getPostVar('search_city_id');
	if($search_city_id != '')
	{
		$searchQuery .= " and customer_cart.city_id = '".$search_city_id."'";
	}

	if($searchValue != '')
	{
		$searchQuery = " and (
			".$table_name.".id like '%".$searchValue."%' or
			".$table_name.".cart_item_name like '%".$searchValue."%' or
			".$table_name.".cart_line_total like '%".$searchValue."%' or
			".$table_name.".entry_date_time like '%".$searchValue."%' or
			".$table_name.".entry_from like '%".$searchValue."%'
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
	$obj_brand->join_table("city", "left", array(), array("city_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "customer_cart.id!=0 ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		if($result[$i]['entry_from'] == 'Web') {
			$entryFrom = '<span class="badge badge-primary">Web</span>';
		} else {
			$entryFrom = '<span class="badge badge-success">'.$result[$i]['entry_from'].'</span>';
		}

		if($result[$i]['customer_id']!=0) {
			$customer_name = $result[$i]['customer_name']." ".$result[$i]['customer_last_name']."<br/>".$result[$i]['customer_phone']."<br/>".$result[$i]['customer_email'];
		} else {
			$customer_name = 'Unknown';
		}

		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"customer_name"=> $customer_name,
			"cart_item_name"=>$result[$i]['cart_item_name'],
			"cart_line_total"=>$result[$i]['cart_line_total']."<br/>".$result[$i]['city_name'],
			"entry_date_time"=>$entryFrom.'<br/>'.$result[$i]['entry_date_time'],
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