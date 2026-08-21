<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active direct_payment_order datatbale loading
if($get_actionType=="direct_payment_order_list")
{
	$table_name='direct_payment_order';

	$current_status=$app->getGetVar("current_status");
	if($current_status!='')
	{
		$status_cond=" AND ".$table_name.".order_pay_status='".$current_status."'";
	}
	else
	{
		$status_cond=" AND ".$table_name.".order_pay_status='Confirm'";
	}

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
		name like '%".$searchValue."%' or
		email like '%".$searchValue."%' or
		mobile like '%".$searchValue."%' or
		amount like '%".$searchValue."%' or
		".$table_name.".order_pay_status like '%".$searchValue."%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$status_cond."");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$status_cond." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='0' ".$status_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{

			$btn='<button type="button" class="btn btn-xs btn-warning btn-icon direct_payment_order_detail_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-eye"></i></button>';
	
			$option='<div class="btn-toolbar"><div>'.$btn.'</div></div>';

		if($result[$i]['order_pay_status']=='Confirm')
		{
			$order_pay_status='<span class="badge badge-success">'.$result[$i]['order_pay_status'].'</span>';
		}
		else
		{
			$order_pay_status='<span class="badge badge-danger">'.$result[$i]['order_pay_status'].'</span>';
		}

		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"mobile"=>$result[$i]['mobile'].'<br/>'.$result[$i]['email'],
			"amount"=>'<i class="fas fa-rupee-sign"></i>'.$result[$i]['amount'],
			"order_pay_status"=>$order_pay_status,
			"created_date"=>$result[$i]['created_date'],
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
?>