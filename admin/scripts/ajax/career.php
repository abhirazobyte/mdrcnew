<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active banner datatbale loading

if($get_actionType=="career_list")

{

	$table_name='career';



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
		".$table_name.".phone like '%".$searchValue."%' or
		".$table_name.".email like '%".$searchValue."%' or
		".$table_name.".qualification like '%".$searchValue."%' or
		".$table_name.".skills like '%".$searchValue."%' or
		".$table_name.".message like '%".$searchValue."%' or
		".$table_name.".date like '%".$searchValue."%'
		)";
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

	

	$folder='files';

	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			

			//Mobile

			$image=$result[$i]["image"];

			$profile_img=$app->utility->get_image_path($image,$folder,"large");





			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon career_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div> '.$delete_btn.'</div></div>';
	
			
           $resume_file='<a target="_blank" href="../uploads/resume/'.$result[$i]["resume"].'"><span class="badge badge-warning">Resume</span></a>';
			


		//data

		$data[] = array

		(

			"id"=>$result[$i]['id'],

			"image"=>'<a href="'.$profile_img.'" class="image-popup"><img src="'.$profile_img.'" class="up_img"></a>',
			
			"name"=>$result[$i]['name'],
			
			"phone"=>$result[$i]['phone']."<br/>".$result[$i]['email'],
			
			"qualification"=>$result[$i]['qualification'],

			"skills"=>$result[$i]['skills']."<br/>".$resume_file,	
			
			"message"=>$result[$i]['message'],		
			
			"date"=>$result[$i]['date'],	

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




//Function for single banner delete

if($actionType=="careerDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		
		$obj_change_table = $app->load_model('career');

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





//Function for multiple banner delete

if($actionType=="careerMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

	
			$obj_change_table = $app->load_model('career');

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