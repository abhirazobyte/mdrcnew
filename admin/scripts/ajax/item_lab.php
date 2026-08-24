<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active item_lab datatbale loading
if($get_actionType=="item_lab_list")
{
	$table_name='item_lab';

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
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash'");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_item_lab = $app->load_model($table_name);
	$result = $obj_item_lab->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='item_lab';
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$item_lab_img=$app->utility->get_image_path($image,$folder,"");
			


			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_lab\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
					
			if($result[$i]['rate_list_panel_id']!=''){
				$sync_btn='<button type="button" class="btn btn-xs btn-warning btn-icon sync_department_onclick" title="SYNC Department" data-rate_list_panel_id="'.$result[$i]['rate_list_panel_id'].'"><i class="fas fa-sync"></i></button>';
			} else {
				$sync_btn='';
			}
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon item_lab_addedit_onclick" title="Edit Item Lab" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_lab_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				
			$option='<div class="btn-toolbar"><div>'.$sync_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"image"=>'<a href="'.$item_lab_img['large_image'].'" class="image-popup"><img src="'.$item_lab_img['large_image'].'" class="up_img"></a>',
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


//Function for item_lab addedit
if($actionType=="item_labAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$lis_item_department_id=$app->getPostVar('lis_item_department_id');
	$lis_item_department_id_string = implode(',', $lis_item_department_id);

	$excluding_department_id=$app->getPostVar('excluding_department_id');
	$excluding_department_id_string = implode(',', $excluding_department_id);
	
	
	$upload_dir='item_lab';
	
	if($status!='' && $name!='')
	{
		
		  if($id!='')
		  {
			  $obj_model_record = $app->load_model("item_lab");
			  $result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				  
			  if($result[0]["image"]!=NULL && $_FILES['item_lab_image']['error'] == 0)
			  {	
				  @unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									
				  
			  }
	  
		  }
		
		
		$update_field = array();
		if(!empty($_FILES['item_lab_image']['name']))
		{
			
			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['item_lab_image']['name'],$_FILES['item_lab_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1000','600','200');
			$update_field['image']=$banner_img11;
			
			
		}
		
		if($id!='')
		{
			$slug=$app->utility->unique_slug('item_lab','edit','slug',$app->getPostVar('name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('item_lab','add','slug',$app->getPostVar('name'),'');
		}
		//Insert Update Record
		
		$update_field['slug'] = $slug;
		
		
		
		
		$update_field['status'] = $status;
		$update_field['department_names'] = $lis_item_department_id_string;
		$update_field['excluding_department_names'] = $excluding_department_id_string;
		$update_field['entry_date_time'] = date('d-m-Y H:i:s');
		
		
		$obj_model_user = $app->load_model("item_lab");
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

//Function for single item_lab delete
if($actionType=="item_labDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$obj_model_record = $app->load_model("item_lab");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
	
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='item_lab';
			@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);									
		}	
		
		$obj_change_table = $app->load_model('item_lab');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_lab SET status='Trash' WHERE id='".$getid."'");
		
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


//Function for multiple item_lab delete
if($actionType=="item_labMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item_lab");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='item_lab';
				
				
				@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);									
			}	
			
			$obj_change_table = $app->load_model('item_lab');
			$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_lab SET status='Trash' WHERE id=".$temp_ids[$i]."");
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



// -------------------- SYNC RECORD & MAP --------------------
if($actionType=="sync_department")
{
	$msg=mdrc_staging_disabled_message();
	$msgcode=1;
}

		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>