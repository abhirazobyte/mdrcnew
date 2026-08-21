<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active item datatbale loading
if($get_actionType=="item_list")
{
	$table_name='item';
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
		itemcode like '%".$searchValue."%' or
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
	$obj_item = $app->load_model($table_name);
	$obj_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
	$result = $obj_item->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$folder='item';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$item_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['folder'].'/',"");
			$item_department_ids=$result[$i]["item_other_data_item_department_ids"]!=''?$app->utility->getDepartmentData($result[$i]["item_other_data_item_department_ids"]):'';
			$typeID=$result[$i]["item_other_data_item_type_id"];
			if($typeID==1)
			{
				$packageTestHtml='<br/><span class="badge badge-success">Package</span>';
			}
			else
			{
				$packageTestHtml='<br/><span class="badge badge-info">Test</span>';
			}
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'item\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			$more_btn='';
			if($result[$i]["item_other_data_item_type_id"]==1)
			{
				$more_btn='<a href="index.php?view=item_data_list&data_id='.$result[$i]['id'].'&tab_type=All" class="btn btn-xs btn-info btn-icon mg-r-5" target="_blank" ><i class="fas fa-plus"></i></a>';
			}
			$edit_btn='<a href="index.php?view=item_addedit&id='.$result[$i]['id'].'" class="btn btn-xs btn-primary btn-icon mg-r-5 item_addedit_onclick_r" ><i class="fas fa-edit"></i></a>';
			$faq_btn='<a href="index.php?view=faq_list&faq_type=item&faq_type_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mg-r-5" ><i class="far fa-comment-dots"></i></a>';
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon item_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			$option='<div class="btn-toolbar"><div>'.$faq_btn.' '.$more_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'].$packageTestHtml,
			"item_department_ids"=>$item_department_ids,
			"designation"=>$result[$i]['designation'],
			"image"=>'<a href="'.$item_img['large_image'].'" class="image-popup"><img src="'.$item_img['large_image'].'" class="up_img"></a>',
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
//Function for item addedit
if($actionType=="itemAddEdit")
{
	$attr1=$app->getPostVar("attr1");
	$mrps=$app->getPostVar("mrps");
	$prices=$app->getPostVar('prices');
		$check='Yes';
		for($i=0;$i<count($prices);$i++)
		{
			if($attr1[$i]>0 || $prices[$i]>0)
			{
				$check='No';
			}
		}
		if($check=='Yes')
		{
					$msg="Please Select City & Price.";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
		}
		for($i=0;$i<count($prices);$i++)
		{
			if($attr1[$i]==0 && $prices[$i]>0)
			{
					$msg="Please Select City";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
			}
			if(($prices[$i]<=0 || $prices[$i]=='') && $attr1[$i]>0)
			{
					$msg="Please Add City Price";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
			}
				if($prices[$i]>$mrps[$i] && $mrps[$i]>0)
				{
					$msg="Some City Price is Larger Than MRP.";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				}
		}
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>''));
	exit;
}
//Function for single item delete
if($actionType=="itemDelete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_model_record = $app->load_model("item");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='item';
			@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.$folder.'/'.'thumb'.$result[0]["image"]);
		}
		$obj_change_table = $app->load_model('item');
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
//Function for multiple item delete
if($actionType=="itemMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("item");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='item';
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
			}
			$obj_change_table = $app->load_model('item');
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
if($actionType=="item_option_delete")
{
	$getid=$app->getPostVar('getid');
	if($getid!= NULL && $getid>0)
	{
		$obj_change_table = $app->load_model('item_price');
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
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>