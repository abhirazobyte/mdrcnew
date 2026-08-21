<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active city datatbale loading
if($get_actionType=="state_list")
{
	$table_name='state';
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
		".$table_name.".name like '%".$searchValue."%' or
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
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."
	  where  ".$table_name.".status!='Trash' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'state\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon state_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon state_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"sort_order"=>$result[$i]['sort_order'],
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
//Function for state addedit
if($actionType=="stateAddEdit")
{
	$name=$app->getPostVar('name');
	$api_state_id=$app->getPostVar('api_state_id');
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	if($name!='' && $api_state_id!='')
	{
		if($id!='')
		{
			$cond=" and id!='".$id."'";
			$update_title='Updated';
		}
		else
		{
			$cond="";
			$update_title='Added';
		}
		$obj_model_check = $app->load_model("state");
		$rs_check=$obj_model_check->execute("SELECT",false,"","status!='Trash' and api_state_id='".$api_state_id."' and name='".$name."' ".$cond."");
		if(count($rs_check)>0)
		{
			$msg='Record Already Exist.';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}
		 //Insert Update Record
		$update_field = array();
		$update_field['api_state_id'] = $api_state_id;
		$update_field['name'] = $name;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y h:i A');
		$obj_model_user = $app->load_model("state");
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
//Function for single city delete
if($actionType=="stateDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_change_city = $app->load_model('city');
		$rs_city= $obj_change_city->execute("SELECT",false,"","state_id='".$getid."' and status!='Trash'");
		if(count($rs_city)==0)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('state');
			$obj_change_table->map_fields($update_field);
			$update_id = $obj_change_table->execute("UPDATE",false,"","id='".$getid."'");
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
			$msg='This State City Exist.';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}
	}
	else
	{
		$msg='Please Try Again.';
		$msgcode=1;
	}
}
//Function for multiple city delete
if($actionType=="stateMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('state');
			$obj_change_table->map_fields($update_field);
			$update_id = $obj_change_table->execute("UPDATE",false,"","id='".$temp_ids[$i]."'");
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