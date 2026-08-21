<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active welcome_reward_report datatbale loading
if($get_actionType=="welcome_reward_report_list")
{
	$table_name='wallet_transaction';

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
		phone like '%".$searchValue."%' or 	
		transaction_id like '%".$searchValue."%' or 	
		".$table_name.".email like '%".$searchValue."%'
		) 
		";
	}

	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];
	
	$sdate=str_replace('-','/',$s_date);
	$edate=str_replace('-','/',$e_date);
				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y')  AND remark='Welcome Reward'  AND amount!='0'");
	$totalRecords = $result[0]['allcount'];

	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name." where STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y')  AND remark='Welcome Reward'  AND amount!='0' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_welcome_reward_report = $app->load_model($table_name);
	$result = $obj_welcome_reward_report->execute("SELECT", false, "", "STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y')  AND remark='Welcome Reward'  AND amount!='0' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	

	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"email"=>$result[$i]['email'],
			"phone"=>$result[$i]['phone'],
			"amount"=>$result[$i]['amount'],
			"transaction_date"=>$result[$i]['transaction_date'],
			"remark"=>$result[$i]['remark']	
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


if($actionType=="SessionSet")
{
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>