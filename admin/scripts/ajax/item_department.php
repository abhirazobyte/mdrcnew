<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active item_department datatbale loading
if($get_actionType=="item_department_list")
{
	$table_name='item_department';
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
	$obj_item_department = $app->load_model($table_name);
	$result = $obj_item_department->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='item_department';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$image=$result[$i]["image"];
			$item_department_img=$app->utility->get_image_path($image,$folder,"");
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_department\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$faq_btn='<a href="index.php?view=faq_list&faq_type=item_department&faq_type_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mg-r-5" ><i class="far fa-comment-dots"></i></a>';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon item_department_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_department_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
				$delete_btn='';
			$option='<div class="btn-toolbar"><div>'.$faq_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"image"=>'<a href="'.$item_department_img['large_image'].'" class="image-popup"><img src="'.$item_department_img['large_image'].'" class="up_img"></a>',
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
//Function for item_department addedit
if($actionType=="item_departmentAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$description=$app->getPostVar('description');
	$citys=$app->getPostVar('work_item');
	$city_ids=implode(',',$citys);
	$upload_dir='item_department';
	if($status!='' && $name!='')
	{
		  if($id!='')
		  {
			  $obj_model_record = $app->load_model("item_department");
			  $result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
			  if($result[0]["image"]!=NULL && $_FILES['item_department_image']['error'] == 0)
			  {
				  @unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
				  @unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);
			  }
		  }
		$update_field = array();
		if(!empty($_FILES['item_department_image']['name']))
		{
			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['item_department_image']['name'],$_FILES['item_department_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1000','600','200');
			$update_field['image']=$banner_img11;
		}
		if($id!='')
		{
			$slug=$app->utility->unique_slug('item_department','edit','slug',$app->getPostVar('name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('item_department','add','slug',$app->getPostVar('name'),'');
		}
		//Insert Update Record
		$update_field['slug'] = $slug;
		$update_field['description'] = $description;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y H:i:s');
		$obj_model_user = $app->load_model("item_department");
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
//Function for single item_department delete
if($actionType=="item_departmentDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("item_department");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='item_department';
			@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
		}
		$obj_change_table = $app->load_model('item_department');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_department SET status='Trash' WHERE id='".$getid."'");
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
//Function for multiple item_department delete
if($actionType=="item_departmentMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item_department");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='item_department';
				@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			$obj_change_table = $app->load_model('item_department');
			$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_department SET status='Trash' WHERE id=".$temp_ids[$i]."");
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