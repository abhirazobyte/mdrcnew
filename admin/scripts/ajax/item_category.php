<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active item_category datatbale loading
if($get_actionType=="item_category_list")
{
	$table_name='item_category';
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
	$obj_item_category = $app->load_model($table_name);
	$result = $obj_item_category->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='item_category';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$image=$result[$i]["image"];
			$item_category_img=$app->utility->get_image_path($image,$folder,"");
			$item_department_ids=$app->utility->getDepartmentData($result[$i]["item_department_ids"]);
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_category\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$faq_btn='<a href="index.php?view=faq_list&faq_type=item_category&faq_type_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mg-r-5" ><i class="far fa-comment-dots"></i></a>';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon item_category_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_category_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$faq_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';
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
			"item_department_ids"=>$item_department_ids,
			"image"=>'<a href="'.$item_category_img['large_image'].'" class="image-popup"><img src="'.$item_category_img['large_image'].'" class="up_img"></a>',
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
//Function for item_category addedit
if($actionType=="item_categoryAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$decsription=$app->getPostVar('decsription');
	$itemdepartments=$app->getPostVar('work_item');
	$item_department_ids=implode(',',$itemdepartments);
	$upload_dir='item_category';
	if($status!='' && $name!='')
	{
		if($id!='')
		{
			$obj_model_record = $app->load_model("item_category");
			$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
			if($result[0]["image"]!=NULL && $_FILES['item_category_image']['error'] == 0)
			{
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			if($result[0]["banner_image"]!=NULL && $_FILES['item_category_banner']['error'] == 0)
			{
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["banner_image"]);
			}
		}
		$update_field = array();
		if(!empty($_FILES['item_category_image']['name']))
		{
			$fileExt = strtolower(pathinfo($_FILES['item_category_image']['name'], PATHINFO_EXTENSION));
			$banner_img11 = uniqid('img_', true) . '.' . $fileExt;
			$destination = '../../../uploads/'.$upload_dir.'/' . $banner_img11;

			move_uploaded_file($_FILES['item_category_image']['tmp_name'], $destination);
			//$banner_img11=$app->utility->resize_single_image($_FILES['item_category_image']['name'],$_FILES['item_category_image']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000');
			$update_field['image']=$banner_img11;
		}
		if(!empty($_FILES['most_book_icon_form']['name']))
		{
			$fileExt = strtolower(pathinfo($_FILES['most_book_icon_form']['name'], PATHINFO_EXTENSION));
			$banner_img15 = uniqid('img_', true) . '.' . $fileExt;
			$destination = '../../../uploads/'.$upload_dir.'/' . $banner_img15;
			move_uploaded_file($_FILES['most_book_icon_form']['tmp_name'], $destination);
			$update_field['most_book_icon']=$banner_img15;
		}
		if(!empty($_FILES['item_category_banner']['name']))
		{
			$fileExt = strtolower(pathinfo($_FILES['item_category_banner']['name'], PATHINFO_EXTENSION));
			$banner_img12 = uniqid('img_', true) . '.' . $fileExt;
			$destination = '../../../uploads/'.$upload_dir.'/' . $banner_img12;

			move_uploaded_file($_FILES['item_category_banner']['tmp_name'], $destination);

			//$banner_img12=$app->utility->resize_single_image($_FILES['item_category_banner']['name'],$_FILES['item_category_banner']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000');
			$update_field['banner_image']=$banner_img12;
		}
		if($id!='')
		{
			$slug=$app->utility->unique_slug('item_category','edit','slug',$app->getPostVar('name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('item_category','add','slug',$app->getPostVar('name'),'');
		}
		//Insert Update Record
		$update_field['slug'] = $slug;
		$update_field['decsription'] = $decsription;
		$update_field['item_department_ids'] = $item_department_ids;
		$update_field['status'] = $status;
		$update_field['entry_date_time'] = date('d-m-Y H:i:s');
		$obj_model_user = $app->load_model("item_category");
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
//Function for single item_category delete
if($actionType=="item_categoryDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("item_category");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='item_category';
			@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
		}
		$obj_change_table = $app->load_model('item_category');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_category SET status='Trash' WHERE id='".$getid."'");
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
//Function for multiple item_category delete
if($actionType=="item_categoryMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item_category");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='item_category';
				@unlink('../../../uploads/'.$upload_dir.'/thumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			$obj_change_table = $app->load_model('item_category');
			$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE item_category SET status='Trash' WHERE id=".$temp_ids[$i]."");
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