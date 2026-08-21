<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active page_desc datatbale loading
if($get_actionType=="page_desc_list")
{
	$table_name='page_description';
	## Read value
	$draw = $app->getPostVar('draw');
	$row = $app->getPostVar('start');
	$rowperpage = $app->getPostVar('length'); // Rows display per page
	$orderArray = $app->getPostVar('order');
	$columnIndex = $orderArray[0]['column']; // Column index
	$columnArray = $app->getPostVar('columns');
	$page_info_id = $app->getPostVar('pageInfoId');
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
		".$table_name.".id like '%".$searchValue."%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' and page_info_id='".$page_info_id."'");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' and page_info_id='".$page_info_id."' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("city", "left", array(), array("city_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash' and page_info_id='".$page_info_id."' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon page_desc_addedit_onclick" data-page_info_id="'.$result[$i]['page_info_id'].'" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
		$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon page_desc_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
		$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
		$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		$desc = $result[$i]['description'];
		$description = strlen($desc) > 70 ? substr($desc, 0, 70) . '...' : $desc;

		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"city_name"=>$result[$i]['city_name'],
			"description"=>$description,
			"created_at"=>date('d-m-Y h:i A',strtotime($result[$i]['created_at'])),
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
//Function for page_desc addedit
if($actionType=="page_descAddEdit")
{
	$city_id=$app->getPostVar('city_id');
	$page_info_id=$app->getPostVar('page_info_id');
	$description=$app->getPostVar('description');
	$id=$app->getPostVar('id');

	$obj_brandB = $app->load_model("page_description");
	if($id!=''){
		$resultCheck = $obj_brandB->execute("SELECT", false, "", "status!='Trash' and page_info_id='".$page_info_id."' and id!='".$id."' and city_id='".$city_id."'");
	} else {
		$resultCheck = $obj_brandB->execute("SELECT", false, "", "status!='Trash' and page_info_id='".$page_info_id."' and city_id='".$city_id."'");
	}

	if(count($resultCheck)>0){
		$msg='A description for this page and city has already been added.';
		$msgcode=1;
		echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
		exit;
	}

	if($city_id!='' && $description!='')
	{
		$update_field = array();
		$update_field['description'] = $description;
		$obj_model_user = $app->load_model("page_description");
		$obj_model_user->map_fields($update_field);
		if($id!='')
		{
			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		}
		else
		{
			$rs=$obj_model_user->execute("INSERT",false,"","");
		}
		if($rs>0)
		{
			$msg="Record ".$update_title." Successfully.";
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
		$msg='Please Fill Require Data';
		$msgcode=1;
	}
}
//Function for single page_desc delete
if($actionType=="page_descDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_change_table = $app->load_model('page_description');
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
//Function for multiple page_desc delete
if($actionType=="page_descMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_change_table = $app->load_model('page_description');
			$update_id = $obj_change_table->execute("DELETE",false,"","id=".$temp_ids[$i]."");
		}
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