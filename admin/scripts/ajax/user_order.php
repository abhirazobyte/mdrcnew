<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active user_order datatbale loading

if($get_actionType=="user_order_list")

{

	$table_name='order_master';



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

		".$table_name.".net_order_value like '%".$searchValue."%' or 	

		".$table_name.".order_status like '%".$searchValue."%'

		) 

		";

	}

	$user_id=$app->getGetVar("user_id");


	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".user_id='".$user_id."' and order_master.order_status!='Hide'");

	$totalRecords = $result[0]['allcount'];

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".user_id='".$user_id."' and order_master.order_status!='Hide' ".$searchQuery);

	$totalRecordwithFilter = $result[0]['allcount'];

	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("user", "left", array("billing_city","email","mobilephone","name"), array("user_id"=>"id"));					    					    $obj_brand->join_table("order_shipping_address", "left", array(), array("id"=>"order_master_id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".user_id='".$user_id."' and order_master.order_status!='Hide' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	
	$data = array();
	
	

	for($i=0;$i<count($result);$i++)
	{
			$old_date_timestamp = strtotime($result[$i]['order_date_time']);
			$new_date = date('d-m-Y H:i:s', $old_date_timestamp); 
			
			$zone_name=$app->utility->get_zone2021($result[$i]["order_shipping_address_shipping_area_name"]);
			
			
			if($result[$i]['express_charge']!=0.00)
			{
				$express='Express ('.$result[$i]['express_charge'].')';
			}
			else
			{
				$express='';
			}
			if($result[$i]['wallet_value']==0)
			{
				$type='COD';
			}
			else
			{
				$type='PREPAID';
			}
			$user_id=$app->getGetVar("user_id");
	
	
			if($result[$i]['confirmation_remark']=="Order From Android App")
			{
				$order_from='Android App';
			}
			else
			{
				$order_from='Website';
			}		
			
			$detail_btn='<a href="index.php?view=order_invoice&order_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Order Deatil"><i class="far fa-play-circle"></i></a>';
			
			$option='<div class="btn-toolbar"><div>'.$detail_btn.'</div></div>';

			$order_status=$app->utility->o_status_html2020($result[$i]['order_status']);

	
		//data

		$data[] = array
		(

			"id"=>$result[$i]['id'],

			"order_date_time"=>$new_date,
			
			"area_name"=>$result[$i]["order_shipping_address_shipping_area_name"]."<br/>".$zone_name,
			
			"express_charge"=>$express,
			
			"net_order_value"=>$result[$i]['net_order_value'],	
			
			"wallet_value"=>$type,	
			
			"confirmation_remark"=>$order_from,	
			
			"order_status"=>$order_status,	
			
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




		

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>