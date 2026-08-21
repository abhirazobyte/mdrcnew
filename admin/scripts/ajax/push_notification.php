<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active push_notification datatbale loading
if($get_actionType=="push_notification_list")
{
	$table_name='push_notification';
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
		".$table_name.".message like '%".$searchValue."%'
		)
		";
	}
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!=''");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=''  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='push_notification';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
			//Mobile
			$image=$result[$i]["image"];
			$push_notification_img=$app->utility->get_image_path($image,$folder,"large");
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'push_notification\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon push_notification_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';
			$resend_btn='<button type="button" class="btn btn-xs btn-warning btn-icon push_notification_resend_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-redo-alt"></i></button>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon push_notification_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.' '.$resend_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"title"=>$result[$i]['title'],
			"image"=>'<a href="'.$push_notification_img.'" class="image-popup"><img src="'.$push_notification_img.'" class="up_img"></a>',
			"message"=>$result[$i]['message'],
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
//Function for push_notification addedit
if($actionType=="push_notificationAddEdit")
{
	$title=$app->getPostVar('title');
	$message=$app->getPostVar('message');
	$id=$app->getPostVar('id');
	$itemdepartments=$app->getPostVar('work_item');
	$city_ids=implode(',',$itemdepartments);
	if($title!='')
	{
		$update_field = array();
		if(!empty($_FILES['push_notification_image']['name']))
		{
			$upload_dir='push_notification';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("push_notification");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["push_notification_image"]);
				}
			}
			$push_notification_img11=$app->utility->resize_single_image($_FILES['push_notification_image']['name'],$_FILES['push_notification_image']['tmp_name'],'../../uploads/'.$upload_dir.'/','1000');
			$update_field['image']=$push_notification_img11;
		}
		//Insert Update Record
		$update_field['title'] = $title;
		$update_field['message'] = $message;
		$update_field['city_ids'] = $city_ids;
		$obj_model_user = $app->load_model("push_notification");
		$obj_model_user->map_fields($update_field);
		if($id!='')
		{
			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		}
		else
		{
			$rs=$obj_model_user->execute("INSERT",false,"","");

			//send push
			$image1=!empty($_FILES['push_notification_image']['name'])?SERVER_ROOT."/uploads/push_notification/".$push_notification_img11:'';
			$data=array('title'=>$title,'image'=>$image1,'message'=>$message,'type'=>'','body'=>$message,'click_action'=>'NotificationActivity');
			$send_notice=$app->utility->add_push_notification_gcm($data,'WEB');
			
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
//===========resend_notification=====================================//
if($actionType=="resend_notification")
{
	$id=$app->getPostVar('id');
	if($id!='')
	{
		$obj_model_record = $app->load_model("push_notification");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
		//Insert Update Record
		if(count($result)>0)
		{
			$update_field = array();
			$update_field['title'] = $result[0]["title"];
			$update_field['message'] =$result[0]["message"];
			$update_field['image']=$result[0]["image"];
			$obj_model_user = $app->load_model("push_notification");
			$obj_model_user->map_fields($update_field);
			$obj_model_user->execute("INSERT",false,"","");

			$image1=$result[0]["image"]!=''?SERVER_ROOT."/uploads/push_notification/".$result[0]["image"]:'';
			$data=array('title'=>$result[0]["title"],'image'=>$image1,'message'=>$result[0]["message"],'type'=>'','body'=>$result[0]["message"],'click_action'=>'NotificationActivity');
			$app->utility->add_push_notification_gcm($data,'WEB');
			
			$msg="Notification Send Successfully.";
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
//Function for single push_notification delete
if($actionType=="push_notificationDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("push_notification");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='push_notification';
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
		}
		$obj_change_table = $app->load_model('push_notification');
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
//Function for multiple push_notification delete
if($actionType=="push_notificationMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("push_notification");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='push_notification';
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			$obj_change_table = $app->load_model('push_notification');
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