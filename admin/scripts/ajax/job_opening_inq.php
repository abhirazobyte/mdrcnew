<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for Admin Logins datatbale loading

if($get_actionType=="job_opening_inq_list")

{

	$table_name='job_opening_inq';

	$job_opening_id=$app->getGetVar("job_opening_id");

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
		email like '%".$searchValue."%' or
		name like '%".$searchValue."%' or
		phone like '%".$searchValue."%' or
		notice_period like '%".$searchValue."%' or
		designation like '%".$searchValue."%' or
		current_organization like '%".$searchValue."%' or
		experience like '%".$searchValue."%' or
		address like '%".$searchValue."%' or
		added_date like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 and job_opening_id='".$job_opening_id."'");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 and job_opening_id='".$job_opening_id."' ".$searchQuery);

	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);

	$result = $obj_brand->execute("SELECT", false, "", "id!=0 and job_opening_id='".$job_opening_id."' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon job_opening_inq_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$delete_btn.'</div></div>';

			


		$cv_file='<a href="'.SERVER_ROOT.'/uploads/job_opening_cv/'.$result[$i]['cv_file'].'" target="_blank"><span class="badge badge-warning">CV</span></a>';

		//data

		$data[] = array

		(


			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name']."<br>".$result[$i]['phone']." <br>".$result[$i]['email'],
			"designation"=>"Designation: <b>".$result[$i]['designation']." </b><br>Experience:  <b>".$result[$i]['experience']." </b> <br>".$cv_file,
			"current_organization"=>$result[$i]['current_organization'],
			"experience"=>$result[$i]['experience'],
			"address"=>$result[$i]['address'],
			"added_date"=>$result[$i]['added_date'],
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







//Function for single Admin Logins delete

if($actionType=="job_opening_inqDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		$obj_change_table = $app->load_model('job_opening_inq');

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