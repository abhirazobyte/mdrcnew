<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active wallet_daily_report datatbale loading
if($get_actionType=="wallet_daily_report_list")
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
		amount like '%".$searchValue."%' or
		added_by like '%".$searchValue."%' or 
		transaction_id like '%".$searchValue."%' or 
		email like '%".$searchValue."%' or 
		phone like '%".$searchValue."%' or 	
		".$table_name.".name like '%".$searchValue."%'
		) 
		";
	}
	
	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];
	$type=$_SESSION['search_type'];

	if($type=='Admin')
	{
			$con=" AND added_by='Admin'";
	}
	elseif($type=='User')
	{
		
		$con=" AND added_by='User'";
	}
	else
	{
		$con="";
	}
	$sdate=str_replace('-','/',$s_date);
	$edate=str_replace('-','/',$e_date);
				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y') AND ((remark LIKE '%Refer%') || (transaction_id!='' AND payment_status!='userCancelled')) ".$con."");
	$totalRecords = $result[0]['allcount'];

	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name." where STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y') AND ((remark LIKE '%Refer%') || (transaction_id!='' AND payment_status!='userCancelled')) ".$con." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_wallet_daily_report = $app->load_model($table_name);
	$result = $obj_wallet_daily_report->execute("SELECT", false, "", "STR_TO_DATE(transaction_date, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y') AND ((remark LIKE '%Refer%') || (transaction_id!='' AND payment_status!='userCancelled')) ".$con." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$user_amount=0;
	$admin_amount=0;
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"phone"=>$result[$i]['phone']."<br/>".$result[$i]['email'],
			"amount"=>$result[$i]['amount'],
			"transaction_id"=>$result[$i]['transaction_id'],
			"transaction_date"=>$result[$i]['transaction_date'],
			"remark"=>$result[$i]['remark'],
			"added_by"=>$result[$i]['added_by']		
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
	$search_type=$app->getPostVar("search_type");
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	$_SESSION['search_type']=$search_type;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>