<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active item_certificate datatbale loading
if($get_actionType=="item_certificate_list")
{
	$table_name='item_certificate';
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
	$obj_item_certificate = $app->load_model($table_name);
	$result = $obj_item_certificate->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='item_certificate';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$image=$result[$i]["image"];
			$item_certificate_img=$app->utility->get_image_path($image,$folder,"");
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_certificate\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon item_certificate_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_certificate_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
			if($result[$i]['set_at_home']=='Yes')
			{
				$set_at_home='<span class="badge badge-success">Yes</span>';
			}
			else
			{
				$set_at_home='<span class="badge badge-danger">No</span>';
			}
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"image"=>'<a href="'.$item_certificate_img['large_image'].'" class="image-popup"><img src="'.$item_certificate_img['large_image'].'" class="up_img"></a>',
			"sort_order"=>$result[$i]['sort_order'],
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
//Function for item_certificate addedit
if($actionType=="item_certificateAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$itemdepartments=$app->getPostVar('work_item');
	$item_department_ids=implode(',',$itemdepartments);
	$upload_dir='item_certificate';
	if($status!='' && $name!='')
	{
		  if($id!='')
		  {
			  $obj_model_record = $app->load_model("item_certificate");
			  $result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
		  }
if($id!='')
		{
			$slug=$app->utility->unique_slug('item_certificate','edit','slug',$app->getPostVar('name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('item_certificate','add','slug',$app->getPostVar('name'),'');
		}
		$update_field = array();
		if(!empty($_FILES['file1']['name']))
		{
								$file_name1 = basename($_FILES['file1']['name']);
								$file_info1 = $app->utility->get_file_info($file_name1);
								if(strtolower($file_info1->extension)=='svg' || strtolower($file_info1->extension)=='png' || strtolower($file_info1->extension)=='jpeg' || strtolower($file_info1->extension)=='jpg' )
								{
									/*if($_FILES['file1']['size']>1000000)
									{
										echo $obj_json->encode(array("RESULT"=>"1", "MSG"=>"Please upload a file smaller than 1MB."));
										exit;
									}
									*/
								$file_names=explode('.',$file_name1);
								$pre_name=$app->utility->seo_url($file_names[0]);
								$new_name1=$pre_name.'.'.$file_info1->extension;
									if($app->utility->upload_file($_FILES['file1']))
									{
										  if($app->utility->store_uploaded_file($app->get_user_config("item_certificate"), $new_name1))
											{
												$update_field['image']= $new_name1;
											}
									}
								}
								else
								{
									echo $obj_json->encode(array("RESULT"=>"1","url"=>"","msg"=>"Please Upload svg or jpg or jpeg or png  file ."));
									exit;
								}
		}
		//Insert Update Record
		$update_field['slug'] = $slug;
		$update_field['item_department_ids'] = $item_department_ids;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y H:i:s');
		$obj_model_user = $app->load_model("item_certificate");
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
//Function for single item_certificate delete
if($actionType=="item_certificateDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("item_certificate");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='item_certificate';
			@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
		}
		$obj_change_table = $app->load_model('item_certificate');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_certificate SET status='Trash' WHERE id='".$getid."'");
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
//Function for multiple item_certificate delete
if($actionType=="item_certificateMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item_certificate");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='item_certificate';
				@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			$obj_change_table = $app->load_model('item_certificate');
			$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_certificate SET status='Trash' WHERE id=".$temp_ids[$i]."");
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