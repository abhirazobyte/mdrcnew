<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active video_gallery datatbale loading

if($get_actionType=="video_gallery_list")

{

	$table_name='video_gallery_category';


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

	



	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			


			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'video_gallery_category\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

					

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon video_gallery_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	


			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon video_gallery_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$images_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';

			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';

		

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],

			"name"=>$result[$i]['name'],

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





//Function for video_gallery addedit

if($actionType=="video_galleryAddEdit")

{

	$status=$app->getPostVar('status');

	$name=$app->getPostVar('name');

	$id=$app->getPostVar('id');


	if($status!='')

	{

		$update_field = array();


		//Insert Update Record

		$update_field['status'] = $status;

		$update_field['name'] = $name;
		

		$obj_model_user = $app->load_model("video_gallery_category");

		$obj_model_user->map_fields($update_field);

		if($id!='')

		{

			$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");

			$cat_id=$id;

		}

		else

		{

			$rs=$obj_model_user->execute("INSERT",false,"","");
			$cat_id=$rs;

		}



		if($rs>0)
		{


			$ids=$app->getPostVar('ids');
			$links=$app->getPostVar('links');
			$status=$app->getPostVar('status');
			$sort_orders=$app->getPostVar('sort_orders');

			for($i=0;$i<count($ids);$i++)
			{
				if($status[$i]!='' && $links[$i]!='')
				{
					$update_field = array();
					$update_field["category_id"]=$cat_id;
					$update_field["video_link"] = $links[$i];
					$update_field["status"] = $status[$i];
					$update_field["sort_order"] = $sort_orders[$i];

					$obj_model_user = $app->load_model("video_gallery");
					$obj_model_user->map_fields($update_field);
					if($ids[$i]==0)
					{
						$rs=$obj_model_user->execute("INSERT",false,"");
						$insert=0;
						$update_title='Insert';
					}
					else
					{
						$rs=$obj_model_user->execute("UPDATE",false,"","id='".$ids[$i]."'");
						$insert=0;
						$update_title='Update';
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



//Function for single video_gallery delete

if($actionType=="video_galleryDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		$obj_change_table = $app->load_model('video_gallery_category');

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





//Function for multiple video_gallery delete

if($actionType=="video_galleryMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

		
			$obj_change_table = $app->load_model('video_gallery_category');

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



//Function for single video_gallery delete

if($actionType=="videogalleryDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		$obj_change_table = $app->load_model('video_gallery');

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