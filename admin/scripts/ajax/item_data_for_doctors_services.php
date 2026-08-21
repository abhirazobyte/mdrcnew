<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active item datatbale loading
if($get_actionType=="item_list")
{
	
	
	
	
	$service_id=$app->getGetVar("service_id");
	$tab_type=$app->getGetVar("tab_type");
	
	
	
	$obj_item = $app->load_model("item_for_doctors_services_data");
	$seleted_data = $obj_item->execute("SELECT", false, "", "for_doctors_services_id='".$service_id."'");
	
	if(count($seleted_data)>0)
	{
		
		$dataID=array();
		for($i=0;$i<count($seleted_data);$i++)
		{
			$dataID[]=$seleted_data[$i]['item_id'];
			
		}
		
		$selected_ids=implode(',',$dataID);
		
	}
	else
	{
		$selected_ids=0;	
	}
	
	if($tab_type=='All')
	{
		$other_cond=" and item.id NOT IN (".$selected_ids.")";
		
	}
	else
	{
		$other_cond=" and item.id IN (".$selected_ids.")";
		
	}
	
	
	
	$table_name='item';

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
		sort_order like '%".$searchValue."%' or 	
		".$table_name.".status like '%".$searchValue."%'
		) 
		";
	}
	
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' ".$other_cond."");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash'  ".$other_cond." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_item = $app->load_model($table_name);
	//$obj_brand->join_table("customer", "left", array( "name","phone","last_name"), array("customer_id"=>"id"));	
	$result = $obj_item->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$other_cond."  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='item';
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$item_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['folder'].'/',"");
				
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"image"=>'<a href="'.$item_img['large_image'].'" class="image-popup"><img src="'.$item_img['large_image'].'" class="up_img"></a>'
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



//Function for multiple item delete
if($actionType=="itemMultiDelete")
{
	$service_id=$app->getPostVar('service_id');
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_change_table = $app->load_model('item_for_doctors_services_data');
			$update_id = $obj_change_table->execute("DELETE",false,"","item_id=".$temp_ids[$i]." and for_doctors_services_id='".$service_id."'");
		}
		$msg='Sucess';
		$msgcode=0;
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}		
}


if($actionType=="itemMultiAdd")
{
	$service_id=$app->getPostVar('service_id');
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$data = array();
			$data['item_id'] = $temp_ids[$i];
			$data['for_doctors_services_id'] = $service_id;
			$data['entry_date_time'] = date('d-m-Y H:i:s');
			
			$obj_model_item = $app->load_model("item_for_doctors_services_data");
			$obj_model_item->map_fields($data);
			$update_id=$obj_model_item->execute("INSERT",false,"","");
		}
		$msg='Sucess';
		$msgcode=0;
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}		
}

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>