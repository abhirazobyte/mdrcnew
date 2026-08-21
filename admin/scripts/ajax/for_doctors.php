<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active for_doctors datatbale loading
if($get_actionType=="for_doctors_list")
{
	$table_name='for_doctors';
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
		".$table_name.".title like '%".$searchValue."%' or
		".$table_name.".status like '%".$searchValue."%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash'");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	//$folder='for_doctors';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			// $image=$result[$i]["iamge"];
			// $for_doctors_img=$app->utility->get_image_path($image,$folder,"");

			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'for_doctors\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

			$inq_btn='<a href="index.php?view=for_doctors_services_list&for_doctors_id='.$result[$i]['id'].'" class="mr-1 btn btn-xs btn-warning btn-icon"><i class="fas fa-plus"></i></a>';

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon for_doctors_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon for_doctors_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.' '.$inq_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data

			if($result[$i]['set_at_home']=='Yes')
			{
				$set_at_home='<span class="badge badge-warning">Yes</span>';
			}
			else
			{
				$set_at_home='<span class="badge badge-danger">No</span>';
			}

		$data[] = array(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"title"=>$result[$i]['title'],
			"set_at_home"=>$set_at_home,
			"status"=>$status,
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
//Function for for_doctors addedit
if($actionType=="for_doctorsAddEdit")
{
	$status=$app->getPostVar('status');
	$title=$app->getPostVar('title');
	$id=$app->getPostVar('id');
	if($status!='' && $title!='')
	{
		$update_field = array();
		if($id!='')
		{
			$slug=$app->utility->unique_slug('for_doctors','edit','slug',$app->getPostVar('title'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('for_doctors','add','slug',$app->getPostVar('title'),'');
		}
		$update_field['slug'] = $slug;

		$update_field['status'] = $status;
		$obj_model_user = $app->load_model("for_doctors");
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
//Function for single for_doctors delete
if($actionType=="for_doctorsDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{	
		$update_field = array();
		$update_field['status'] ='Trash';
		$obj_model_record = $app->load_model("for_doctors");
		$obj_model_record->map_fields($update_field);
		$rs=$obj_model_record->execute("UPDATE",false,"","id='".$getid."'");
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
//Function for multiple for_doctors delete
if($actionType=="for_doctorsMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$update_field = array();
			$update_field['status'] ='Trash';
			$obj_model_record = $app->load_model("for_doctors");
			$obj_model_record->map_fields($update_field);
			$rs=$obj_model_record->execute("UPDATE",false,"","id='".$temp_ids[$i]."'");
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