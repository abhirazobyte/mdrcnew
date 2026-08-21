<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active sms_history datatbale loading
if($get_actionType=="sms_history_list")
{
	$table_name='sms_history';

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
		phones like '%".$searchValue."%' or
		sms_text like '%".$searchValue."%' or
		
		
		".$table_name.".sms_msg_id like '%".$searchValue."%'
		) 
		";
	}
	
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!=0 ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'sms_history\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
					
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon sms_history_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon sms_history_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				
			
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
			
			
			
			
		
		//data
		$data[] = array
		(
			
			
			"id"=>$result[$i]['id'],
			"phones"=>$result[$i]['phones'],
			"sms_text"=>$result[$i]['sms_text'],
			
			
			"sms_msg_id"=>$result[$i]['sms_msg_id'],		
			
			
			"sms_count"=>$result[$i]['sms_count'],		
			
			
			"entry_date_time"=>$result[$i]['entry_date_time']
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


//Function for sms_history addedit
if($actionType=="sms_historyAddEdit")
{

	$template_name=$app->getPostVar('template_name');
	
	$sms_text=$app->getPostVar('sms_text');
	$default_sms_text=$app->getPostVar('default_sms_text');


	
	
	
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	
	if($template_name!='')
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
		$obj_model_check = $app->load_model("sms_history");
		$rs_check=$obj_model_check->execute("SELECT",false,"","status!='Trash' and template_name='".$template_name."' ".$cond."");
		if(count($rs_check)>0)
		{
			$msg='Template Name Already Exist.';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}
		 //Insert Update Record
		$update_field = array();
		$update_field['template_name']=$template_name;
		
		
		$update_field['default_sms_text']=$default_sms_text;
		$update_field['sms_text']=$sms_text;
		
		
		$update_field['status'] = $status;
		
		
		$obj_model_user = $app->load_model("sms_history");
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

//Function for single sms_history delete
if($actionType=="sms_historyDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		$update_field = array();
		$update_field['status']= 'Trash';
		$obj_change_table = $app->load_model('sms_history');
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


//Function for multiple sms_history delete
if($actionType=="sms_historyMultiDelete")
{
	$ids=$app->getPostVar('ids');
	
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($ids);$i++)
		{
			$update_field = array();
			$update_field['status']= 'Trash';
			$obj_change_table = $app->load_model('sms_history');
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