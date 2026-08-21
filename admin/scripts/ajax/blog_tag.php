<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active blog_tag datatbale loading

if($get_actionType=="blog_tag_list")

{

	$table_name='blog_tag';



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

	$obj_blog_tag = $app->load_model($table_name);

	$result = $obj_blog_tag->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	

	$folder='blog_tag';

	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			//Mobile

			$image=$result[$i]["image"];

			$blog_tag_img=$app->utility->get_image_path($image,$folder,"");

			





			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'blog_tag\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

					

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon blog_tag_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	

			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon blog_tag_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';

			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';

		if($result[$i]['set_at_home']=='Yes')
		{
			$set_at_home='<span class="badge badge-warning">Yes</span>';
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

			"image"=>'<a href="'.$blog_tag_img['large_image'].'" class="image-popup"><img src="'.$blog_tag_img['large_image'].'" class="up_img"></a>',

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





//Function for blog_tag addedit

if($actionType=="blog_tagAddEdit")

{

	$name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('name'));

	$status=$app->getPostVar('status');

	$id=$app->getPostVar('id');

	$set_at_home=$app->getPostVar('set_at_home');	
	
	$citys=$app->getPostVar('work_item');

	$city_ids=implode(',',$citys);

	

	if($status!='' && $name!='')

	{	

		if($id!='')

		{

			$slug=$app->utility->unique_slug('blog_tag','edit','slug',$app->getPostVar('name'),$id);

		}

		else

		{

			$slug=$app->utility->unique_slug('blog_tag','add','slug',$app->getPostVar('name'),'');

		}

		//Insert Update Record

		

		
		

		$update_field = array();

		
		$update_field['slug'] = $slug;
		
		$update_field['set_at_home'] = $set_at_home;
		$update_field['status'] = $status;


		$obj_model_user = $app->load_model("blog_tag");

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



//Function for single blog_tag delete

if($actionType=="blog_tagDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		

		

		

		$obj_change_table = $app->load_model('blog_tag');

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





//Function for multiple blog_tag delete

if($actionType=="blog_tagMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

				

			

			$obj_change_table = $app->load_model('blog_tag');

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