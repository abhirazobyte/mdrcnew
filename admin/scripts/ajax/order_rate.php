<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active order_rate datatbale loading

if($get_actionType=="order_rate_list")

{

	$table_name='order_rate';



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
	
	
	if($_SESSION['search_city']!='' && $_SESSION['search_city']!='0')
	{
		$search_city_cond="AND city.id='".$_SESSION['search_city']."'";
	}
	else
	{
		$search_city_cond="";
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
	

		".$table_name.".order_id like '%".$searchValue."%' or

		".$table_name.".msg like '%".$searchValue."%' or 	

		".$table_name.".added_on like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!=''");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);
	
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='' ".$searchQuery);

	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("user", "left", array(), array("user_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='' ".$search_city_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	


	$data = array();

	for($i=0;$i<count($result);$i++)

	{

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon order_rate_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			
			$retting_number=$app->utility->get_retting_number($result[$i]['exp']);
					
				
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';



		//data

		$data[] = array

		(


			"id"=>$result[$i]['id'],
			
			"order_id"=>$result[$i]['order_id'],

			"user_id"=>$result[$i]['user_name']."<br/>".$result[$i]['user_mobilephone']."<br/>".$result[$i]['user_email'],

			"rate1"=>'<span class="badge badge-warning">'.$retting_number.' <i class="fas fa-star"></i></span><br/><span class="badge badge-info">'.$result[$i]['exp'].'</span>',
			
			"msg"=>$result[$i]['msg'],

			"added_on"=>$result[$i]['added_on'],	

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






//Function for single order_rate delete

if($actionType=="order_rateDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

			
		

		$obj_change_table = $app->load_model('order_rate');

		$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");

		

		if($update_id>0)

		{

			$msg='Sucess';

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








		

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>