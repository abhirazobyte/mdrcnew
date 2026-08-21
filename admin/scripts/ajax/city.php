<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active city datatbale loading
if($get_actionType=="city_list")
{
	$table_name='city';
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
		".$table_name.".api_city_id like '%".$searchValue."%' or
		state.name like '%".$searchValue."%' or
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
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,state.name AS state, state.api_state_id from ".$table_name." LEFT JOIN state AS state ON(state.id=".$table_name.".state_id)  where  ".$table_name.".status!='Trash' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("state", "left", array("name","api_state_id"), array("state_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'city\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon city_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon city_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"state_name"=>$result[$i]['state_name'],
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
//Function for city addedit
if($actionType=="cityAddEdit")
{
	$name=$app->getPostVar('name');
	$api_city_id=$app->getPostVar('api_city_id');
	$state_id=$app->getPostVar('state_id');
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	if($name!='' && $api_city_id!='' && $state_id!='')
	{
		$upload_dir='city';
		if($id!='')
		  {
			  $obj_model_record = $app->load_model("city");
			  $result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
			  if($result[0]["image"]!=NULL && $_FILES['item_city_image']['error'] == 0)
			  {
				  @unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);
			  }

			  if($result[0]["certi_image"]!=NULL && $_FILES['item_city_certi_image']['error'] == 0)
			  {
				  @unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["certi_image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["certi_image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["certi_image"]);
			  }
		  }
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
		$api_state_id=$app->utility->get_API_id(['table'=>'state','get_column'=>'api_state_id','value'=>$state_id]);
		$obj_model_check = $app->load_model("city");
		$rs_check=$obj_model_check->execute("SELECT",false,"","status!='Trash' and api_state_id='".$api_state_id."' and state_id='".$state_id."' and api_city_id='".$api_city_id."' and name='".$name."' ".$cond."");
		if(count($rs_check)>0)
		{
			$msg='Record Already Exist.';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}
		 //Insert Update Record
		$update_field = array();
		if(!empty($_FILES['item_city_image']['name']))
		{
			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['item_city_image']['name'],$_FILES['item_city_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1000','600','200');
			$update_field['image']=$banner_img11;
		}
		if(!empty($_FILES['item_city_certi_image']['name']))
		{
			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['item_city_certi_image']['name'],$_FILES['item_city_certi_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1000','600','200');
			$update_field['certi_image']=$banner_img11;
		}
		$update_field['api_city_id'] = $api_city_id;
		$update_field['state_id'] = $state_id;
		$update_field['api_state_id'] = $api_state_id;
		$update_field['name'] = $name;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y h:i A');
		$obj_model_user = $app->load_model("city");
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
if($actionType=="cityDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_change_area = $app->load_model('area');
		$rs_city= $obj_change_area->execute("SELECT",false,"","city_id='".$getid."' and status!='Trash'");
		if(count($rs_city)==0)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('city');
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
			$msg='This City Area Exist.';
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
if($actionType=="cityMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('city');
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