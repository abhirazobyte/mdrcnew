<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active refferal_report datatbale loading
if($get_actionType=="refferal_report_list")
{
	$table_name='user';

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
		order_master.id like '%".$searchValue."%' or
		user.mobilephone like '%".$searchValue."%'
		) 
		";
	}
	
	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];

	$sdate=str_replace('-','/',$s_date);
	$edate=str_replace('-','/',$e_date);
	
	if($sdate!='' && $edate!='')
	{
		$date_cond="and STR_TO_DATE(registration_date, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$sdate."', '%d/%m/%Y') AND STR_TO_DATE('".$edate."', '%d/%m/%Y') ";
	}
	else
	{
		$date_cond="";
	}
				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$date_cond." ".$con." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='0' ".$date_cond." ".$con." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;
			
			$detail_btn='<button type="button" class="btn btn-xs btn-warning btn-icon user_detail_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-play"></i></button>';	
			
			$order_btn='<a href="index.php?view=refferal_user&id='.$result[$i]['id'].'" class="mr-1 btn btn-xs btn-primary btn-icon" ><i class="fas fa-list"></i></a>';	
			
		
			$option='<div class="btn-toolbar"><div>'.$detail_btn.' '.$order_btn.'</div></div>';
			
			$orders=$app->utility->customer_total_order($result[$i]['id']);
			
			$reffers=$app->utility->total_user_refer($result[$i]['ref_key']);
			
			
			$referral_from=$app->utility->total_user_referral_from($result[$i]['referral_from']);
			
			$area_name=$app->utility->user_area($result[$i]['area_id']);
			
			$otp_verified=$app->utility->user_status($result[$i]['otp_verified']);
			

			$is_active=$app->utility->user_status($result[$i]['is_active']);

		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name']." ".$result[$i]['last_name']."<br/>".$result[$i]['mobilephone']."<br/>".$result[$i]['email'],
			"is_active"=>$is_active,
			"area_id"=>$area_name,
			"wallet"=>'<i class="fa fa-rupee-sign"></i> '.$result[$i]['wallet'],
			"orders"=>$orders,
			"reffers"=>$reffers,
			"referral_from"=>$referral_from['name']." ".$referral_from['last_name'],
			"otp_code"=>$result[$i]['otp_code']."<br/>".$otp_verified,
			"registration_date"=>$result[$i]['registration_date'],
			"btn"=>$option
		);
	}
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data,
	);
		
	echo json_encode($response);
	exit;
}


if($actionType=="SessionSet")
{
	$search_delivery_boy=$app->getPostVar("search_delivery_boy");
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	$_SESSION['search_delivery_boy']=$search_delivery_boy;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>