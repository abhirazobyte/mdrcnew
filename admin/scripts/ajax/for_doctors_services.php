<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active for_doctors_services datatbale loading
if($get_actionType=="for_doctors_services_list")
{
	$for_doctors_id=$app->getGetVar("for_doctors_id");

	$table_name='for_doctors_services';
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
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' and for_doctors_id='".$for_doctors_id."'");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash'  and for_doctors_id='".$for_doctors_id."' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash' and for_doctors_id='".$for_doctors_id."' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='for_doctors_services';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$image=$result[$i]["image"];
			$for_doctors_services_img=$app->utility->get_image_path($image,$folder,"");

			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'for_doctors_services\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

			//$inq_btn='<a href="index.php?view=for_doctors_services_inq_list&for_doctors_services_id='.$result[$i]['id'].'" class="mr-1 btn btn-xs btn-warning btn-icon"><i class="fas fa-user"></i></a>';

			$service_btn='<a type="button" class="btn btn-xs btn-warning btn-icon mr-1" href="index.php?view=item_data_for_doctors_services_list&service_id='.$result[$i]['id'].'"><i class="fas fa-plus"></i></a>';

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon for_doctors_services_addedit_onclick" data-for_doctors_id="'.$result[$i]['for_doctors_id'].'" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon for_doctors_services_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.' '.$service_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		
(			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"image"=>'<a href="'.$for_doctors_services_img['medium_image'].'" class="image-popup"><img src="'.$for_doctors_services_img['thumb_image'].'" class="up_img"></a>',
			"title"=>$result[$i]['title'],
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
//Function for for_doctors_services addedit
if($actionType=="for_doctors_servicesAddEdit")
{
	$status=$app->getPostVar('status');
	$decsription=$app->getPostVar('decsription');
	
	$title=$app->getPostVar('title');
	$id=$app->getPostVar('id');
	$for_doctors_id=$app->getPostVar('for_doctors_id');
	if($status!='' && $title!='' && $for_doctors_id!='')
	{
		$update_field = array();
		if($id!='')
		{
			$slug=$app->utility->unique_slug('for_doctors_services','edit','slug',$app->getPostVar('title'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('for_doctors_services','add','slug',$app->getPostVar('title'),'');
		}
		$update_field['slug'] = $slug;
		if(!empty($_FILES['image1']['name']))
		{
			$upload_dir='for_doctors_services';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("for_doctors_services");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									
				}	
			}

			$image1=$app->utility->resize_multi_image_2020($_FILES['image1']['name'],$_FILES['image1']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1080','500','250');	
			$update_field['image']=$image1;
		}			
		
		$update_field['for_doctors_id'] = $for_doctors_id;

		$update_field['status'] = $status;
		$update_field['decsription'] = $decsription;
		$obj_model_user = $app->load_model("for_doctors_services");
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
			$msg='Please Fill Require Datas';
			$msgcode=1;
	}
}
//Function for single for_doctors_services delete
if($actionType=="for_doctors_servicesDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{	
		$update_field = array();
		$update_field['status'] ='Trash';
		$obj_model_record = $app->load_model("for_doctors_services");
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
//Function for multiple for_doctors_services delete
if($actionType=="for_doctors_servicesMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$update_field = array();
			$update_field['status'] ='Trash';
			$obj_model_record = $app->load_model("for_doctors_services");
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