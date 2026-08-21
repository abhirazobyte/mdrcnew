<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active filter_master datatbale loading
if($get_actionType=="filter_master_list")
{
	$table_name='filter_master';

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
	$obj_filter_master = $app->load_model($table_name);
	$result = $obj_filter_master->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='filter_master';
	
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			//Mobile
			$image=$result[$i]["image"];
			$filter_master_img=$app->utility->get_image_path($image,$folder,"");
			


			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'filter_master\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
					
			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon filter_master_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon filter_master_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				
			
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
		
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name'],
			"image"=>'<a href="'.$filter_master_img['large_image'].'" class="image-popup"><img src="'.$filter_master_img['large_image'].'" class="up_img"></a>',
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


//Function for filter_master addedit
if($actionType=="filter_masterAddEdit")
{
	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	
	$citys=$app->getPostVar('work_item');
	$city_ids=implode(',',$citys);
	
	
	
	
	
	$catalogue_id=$app->getPostVar('catalogue_id');
	$final_price_p=$app->getPostVar("final_price_p");
	$points_p=$app->getPostVar('points_p');
	$table_id=$app->getPostVar('table_id');
	
	if($status!='' && $name!='')
	{
		$update_field = array();
		if(!empty($_FILES['filter_master_image']['name']))
		{
			$upload_dir='filter_master';
	
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("filter_master");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["banner_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									
				}	
			}

			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['filter_master_image']['name'],$_FILES['filter_master_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','400','800','100');
			$update_field['image']=$banner_img11;
		}			
		
		
		
		//Insert Update Record
		
		$update_field['slug'] = $slug;
		
		$update_field['status'] = $status;
		$update_field["entry_date_time"] = date('d-m-Y H:i:s');
		
		$obj_model_user = $app->load_model("filter_master");
		$obj_model_user->map_fields($update_field);
		if($id!='')
		{
			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
			$filter_master_id=$id;
		}
		else
		{
			$rs=$obj_model_user->execute("INSERT",false,"","");
			
			$filter_master_id=$rs;
		}
		if($rs>0)
		{
			
			
			
			
			
			
			
			for($i=0;$i<count($final_price_p);$i++)
			{
				if($final_price_p[$i]!='')
				{
					$update_field = array();	
					$update_field["filter_master_id"]=$filter_master_id;							
					$update_field["master_name"] = $final_price_p[$i];
					$update_field["master_sort_order"] = $points_p[$i];
					$update_field["entry_date_time"] = date('d-m-Y H:i:s');
					$obj_catalogue_price_data= $app->load_model("filter_master_values");
					$obj_catalogue_price_data->map_fields($update_field);
					if($table_id[$i]==0)
					{
						$rs=$obj_catalogue_price_data->execute("INSERT",false,"");
					}
					else
					{	
						$rs=$obj_catalogue_price_data->execute("UPDATE",false,"","id='".$table_id[$i]."'");
					}
				}
			}
			
			
			
			
			
			
			
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

//Function for single filter_master delete
if($actionType=="filter_masterDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$obj_model_record = $app->load_model("filter_master");
		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");
	
		if($result[0]["image"]!=NULL)
		{
			$upload_dir='filter_master';
			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);									
		}	
		
		$obj_change_table = $app->load_model('filter_master');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE filter_master SET status='Trash' WHERE id='".$getid."'");
		
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


//Function for multiple filter_master delete
if($actionType=="filter_masterMultiDelete")
{
	$ids=$app->getPostVar('ids');
	$temp_ids=explode(',',$ids);
	if($ids != NULL && $ids!='')
	{
		for($i=0;$i<count($temp_ids);$i++)
		{
			$obj_model_record = $app->load_model("filter_master");
			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");
			if($result[0]["image"]!=NULL)
			{
				$upload_dir='filter_master';
				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);								
			}	
			
			$obj_change_table = $app->load_model('filter_master');
			$update_id = $obj_change_table->execute("DELETE",false,"UPDATE filter_master SET status='Trash' WHERE id='".$temp_ids[$i]."'","");
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


//Function for Product Price delete

if($actionType=="productpriceDelete")
{
	$getid=$app->getPostVar('getid');	
	if($getid!= NULL && $getid>0)
	{
		$obj_change_table = $app->load_model('filter_master_values');
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