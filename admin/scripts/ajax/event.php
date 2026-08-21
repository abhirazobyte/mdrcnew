<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active event datatbale loading
if($get_actionType=="event_list")
{
	$table_name='event';

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
		".$table_name.".sort_order like '%".$searchValue."%' or 	
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
	$obj_event = $app->load_model($table_name);
	$obj_event->join_table("event_category", "left", array( "name"), array("category_id"=>"id"));	
	$result = $obj_event->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='event';
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$event_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['folder'],"");
			


			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'event\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
					
			$edit_btn='<a href="index.php?view=event_addedit&id='.$result[$i]['id'].'" class="btn btn-xs btn-primary btn-icon mg-r-5 event_addedit_onclick_r" ><i class="fas fa-edit"></i></a>';	
			
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon event_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';	
			
			$gallery_btn='<a href="index.php?view=event_gallery&event_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mg-r-5" ><i class="fas fa-images"></i></a>';	
			
			$option='<div class="btn-toolbar"><div>'.$gallery_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"category_id"=>$result[$i]['event_category_name'],
			"image"=>'<a href="'.$event_img['large_image'].'" class="image-popup"><img src="'.$event_img['large_image'].'" class="up_img"></a>',
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


//Function for event addedit
if($actionType=="eventAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	
	$citys=$app->getPostVar('work_item');
	$city_ids=implode(',',$citys);
	
	if($status!='' && $name!='')
	{
		$update_field = array();
		if(!empty($_FILES['event_image']['name']))
		{
			$upload_dir='event';
	
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("event");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				$folder=$result[0]['folder'];
				
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'thumb'.$result[0]["image"]);									
				}	
			}

			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['event_image']['name'],$_FILES['event_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','400','800','100');
			$update_field['image']=$banner_img11;
		}			
		
		if($id!='')
		{
			$slug=$app->utility->unique_slug('event','edit','slug',$app->getPostVar('name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('event','add','slug',$app->getPostVar('name'),'');
		}
		//Insert Update Record
		
		$update_field['slug'] = $slug;
		
		$update_field['status'] = $status;
		
		$obj_model_user = $app->load_model("event");
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

//Function for single event delete
if($actionType=="eventDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$obj_model_record = $app->load_model("event");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		
		
	
		$folder=$result[0]['folder'];
		
		
		
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='event';
			@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'mediumthumb'.$result[0]["image"]);
			@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'thumb'.$result[0]["image"]);	
										
		}	
		
		
		$obj_change_table = $app->load_model('event');
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


//Function for multiple event delete
if($actionType=="eventMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("event");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			$folder=$result[0]['folder'];
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='event';
							
				@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'thumb'.$result[0]["image"]);
													
			}	
			
			$obj_change_table = $app->load_model('event');
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