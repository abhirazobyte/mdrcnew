<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

if($get_actionType=="item_diseases_banner_list")
{
	$table_name='item_diseases_banner';
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
		sort_id like '%".$searchValue."%' or
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
	$folder='item_diseases_banner';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$item_diseases_banner_img=$result[$i]["banner_image"];
			$item_diseases_banner_img=$app->utility->get_image_path($item_diseases_banner_img,$folder,"large");
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item_diseases_banner\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon item_diseases_banner_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_diseases_banner_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"image"=>'<a href="'.$item_diseases_banner_img.'" class="image-popup"><img src="'.$item_diseases_banner_img.'" class="up_img"></a>',
			"sort_id"=>$result[$i]['sort_id'],
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

//Function for item_diseases_banner addedit
if($actionType=="item_diseases_bannerAddEdit")
{
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	$itemdepartments=$app->getPostVar('work_item');
	$city_ids=implode(',',$itemdepartments);
	$item_diseases_ids=implode(',',$app->getPostVar('item_diseases'));
	
	if($status!='')
	{
		$upload_dir='item_diseases_banner';
		$obj_model_record = $app->load_model("item_diseases_banner");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");

		$update_field = array();
		if(!empty($_FILES['banner_image']['name']))
		{
			//Image Edit
			if($id!='')
			{
				if($result[0]["banner_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["banner_image"]);
				}
			}
			$item_diseases_banner_img11=$app->utility->resize_single_image($_FILES['banner_image']['name'],$_FILES['banner_image']['tmp_name'],'../../uploads/'.$upload_dir.'/','1920');
			$update_field['banner_image']=$item_diseases_banner_img11;
		}
		if(!empty($_FILES['mobile_banner']['name']))
		{
			if($id!='')
			{
				if($result[0]["mobile_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["mobile_image"]);
				}
			}
			$mobile_image=$app->utility->resize_single_image($_FILES['mobile_banner']['name'],$_FILES['mobile_banner']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000');
			$update_field['mobile_image']=$mobile_image;
		}
		//Insert Update Record
		$update_field['status'] = $status;
		$update_field['city_ids'] = $city_ids;
		$update_field['item_diseases_ids'] = $item_diseases_ids;
		$obj_model_user = $app->load_model("item_diseases_banner");
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

//Function for single item_diseases_banner delete
if($actionType=="item_diseases_bannerDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("item_diseases_banner");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["banner_image"]!=NULL)
		{
			$upload_dir='item_diseases_banner';
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["banner_image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["mobile_image"]);
		}
		$obj_change_table = $app->load_model('item_diseases_banner');
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

//Function for multiple item_diseases_banner delete
if($actionType=="item_diseases_bannerMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item_diseases_banner");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["banner_image"]!=NULL)
			{
				$upload_dir='item_diseases_banner';
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["banner_image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["mobile_image"]);
			}
			$obj_change_table = $app->load_model('item_diseases_banner');
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