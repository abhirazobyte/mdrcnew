<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active pincode datatbale loading
if($get_actionType=="pincode_list")
{
	$table_name='pincode';
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
		state.name like '%".$searchValue."%' or
		city.name like '%".$searchValue."%' or
		area.name like '%".$searchValue."%' or
		pincode.name like '%".$searchValue."%' or
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
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,state.name AS state, city.name AS city, area.name AS area from ".$table_name." LEFT JOIN state AS state ON(state.id=".$table_name.".state_id) LEFT JOIN city AS city ON(city.id=".$table_name.".city_id) LEFT JOIN area AS area ON(area.id=".$table_name.".area_id)  where  ".$table_name.".status!='Trash' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];

	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("state", "left", array("name"), array("state_id"=>"id"));
	$obj_brand->join_table("city", "left", array("name"), array("city_id"=>"id"));
	$obj_brand->join_table("area", "left", array("name"), array("area_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'pincode\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon pincode_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon pincode_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
			
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"state_name"=>$result[$i]['state_name'],
			"city_name"=>$result[$i]['city_name'],
			"area_name"=>$result[$i]['area_name'],
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
//Function for pincode addedit
if($actionType=="pincodeAddEdit")
{
	$name=$app->getPostVar('name');
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$city_id=$app->getPostVar('city_id');
	$state_id=$app->getPostVar('state_id');
	$area_id=$app->getPostVar('area_id');

	if($name!='' && $state_id!='' && $city_id!='' && $area_id!='')
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

		$condition="status!='Trash' and name='".$name."' and area_id='".$area_id."' and state_id='".$state_id."' and city_id='".$city_id."' ".$cond."";

		$obj_model_check = $app->load_model("pincode");
		$rs_check=$obj_model_check->execute("SELECT",false,"","".$condition."");
		if(count($rs_check)>0)
		{
			$msg='Record Already Exist.';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}

		$api_state_id=$app->utility->get_API_id(['table'=>'state','get_column'=>'api_state_id','value'=>$state_id]);
		$api_city_id=$app->utility->get_API_id(['table'=>'city','get_column'=>'api_city_id','value'=>$city_id]);
		$api_area_id=$app->utility->get_API_id(['table'=>'area','get_column'=>'api_area_id','value'=>$area_id]);

		 //Insert Update Record
		$update_field = array();
		$update_field['api_city_id'] = $api_city_id;
		$update_field['api_state_id'] = $api_state_id;
		$update_field['api_area_id'] = $api_area_id;
		$update_field['area_id'] = $area_id;
		$update_field['city_id'] = $city_id;
		$update_field['state_id'] = $state_id;
		$update_field['name'] = $name;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y h:i A');
		
		$obj_model_user = $app->load_model("pincode");
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
//Function for single pincode delete
if($actionType=="pincodeDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$update_field = array();
		$update_field['status']= 'Trash';
		$obj_change_table = $app->load_model('pincode');
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
		$msg='Please Try Again.';
		$msgcode=1;
	}
}
//Function for multiple pincode delete
if($actionType=="pincodeMultiDelete")
{
	$ids=$app->getPostVar('ids');
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($ids);$i++)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('pincode');
			$obj_change_table->map_fields($update_field);
			$update_id = $obj_change_table->execute("UPDATE",false,"","id='".$ids[$i]."'");
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