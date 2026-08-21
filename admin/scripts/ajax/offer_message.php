<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active offer_message datatbale loading
if($get_actionType=="offer_message_list")
{
	$table_name='offer_message';

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
		popup_type like '%".$searchValue."%' or
		page_types like '%".$searchValue."%' or
		message_text like '%".$searchValue."%' or 
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
	$obj_offer_message = $app->load_model($table_name);
	$result = $obj_offer_message->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='popup';
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$offer_message_img=$app->utility->get_image_path($image,$folder,"");


			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'offer_message\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
					
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon offer_message_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon offer_message_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				
			
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		//data
		
		
		if($result[$i]['page_types']=='')
		{
			
			$page_types='All pages';
		}
		else
		{
			$page_types=$result[$i]['page_types'];
		}
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"image"=>'<a href="'.$offer_message_img['large_image'].'" class="image-popup"><img src="'.$offer_message_img['large_image'].'" class="up_img"></a>',
			
			"page_types"=>$page_types,
			"type"=>$result[$i]['popup_type'],
			"message"=>$result[$i]['message_text'],		
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


//Function for offer_message addedit
if($actionType=="offer_messageAddEdit")
{
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	
	if($status!='')
	{
		$update_field = array();
		if(!empty($_FILES['image']['name']))
		{
			$upload_dir='popup';
			
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("offer_message");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);									
				}	
			}
			
			$banner_img=$app->utility->resize_multi_image_2020($_FILES['image']['name'],$_FILES['image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');
			
			$update_field['image']=$banner_img;
		}			

		//Insert Update Record
		$update_field['status'] = $status;
		$update_field['added_on'] = date('d-m-Y H:i:s');
	
		$obj_model_user = $app->load_model("offer_message");
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

//Function for single offer_message delete
if($actionType=="offer_messageDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$obj_model_record = $app->load_model("offer_message");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
	
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='popup';
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);									
		}	
		
		$obj_change_table = $app->load_model('offer_message');
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


//Function for multiple offer_message delete
if($actionType=="offer_messageMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("offer_message");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='popup';
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);													                                									 				@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
				@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);							
			}	
			
			$obj_change_table = $app->load_model('offer_message');
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