<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for Admin Logins datatbale loading

if($get_actionType=="product_list")

{

	$table_name='product_review';
	$current_status=$app->getGetVar("current_status");

	if($current_status!='')
	{
		$status_cond=" AND product_review.status='".$current_status."'";
	}
	else
	{
		$status_cond="";
	}
	
	
	
	
	
	
	
	
	
	
	



	



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
		".$table_name.".product_star like '%".$searchValue."%' or 
		".$table_name.".product_desc like '%".$searchValue."%' or 

		
		
		product_review.added_on like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 ");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,product.*,customer.* from ".$table_name." 
	
	LEFT JOIN product AS product ON(".$table_name.".product_id=product.id) 
	
	LEFT JOIN customer AS customer ON(".$table_name.".cust_id=customer.id) 
	where  ".$table_name.".status!='Trash' ".$trend_cond." ".$trend_cond2." ".$status_cond." ".$category_cond." ".$brand_cond." ".$searchQuery);	



	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("product", "left", array(), array("product_id"=>"id"));
	$obj_brand->join_table("customer", "left", array("name","last_name","phone"), array("cust_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0  ".$trend_cond." ".$trend_cond2." ".$status_cond." ".$brand_cond." ".$category_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	

	

	$folder='product';


		$obj_model_generel_settings= $app->load_model("generel_settings");
		$rs_gs = $obj_model_generel_settings->execute("SELECT", false,"","");
	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			//Mobile

			$image=$result[$i]["product_image"];

			$banner_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['product_folder'].'/',"");

			
			




			
			

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon banner_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	


			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon product_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			
			
			
			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.'  '.$delete_btn.'</div></div>';

			
			
			
			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';





			
		
		
			
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'product_review\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			
			
			
			

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],

			"image"=>'<a href="'.$banner_img['medium_image'].'" class="image-popup table-product-image-list"><img src="'.$banner_img['thumb_image'].'" class="up_img"></a>',
			

			"cust_id"=>$result[$i]['customer_name']." ".$result[$i]['customer_last_name']."<br/>".$result[$i]['customer_phone'],

			
			
			"product_id"=>$result[$i]['product_name'],
			
			"product_star"=>(int)$result[$i]['product_star']."<i class=\"fa fa-star\"></i><br/>".$result[$i]['product_desc'],
			
			"added_on"=>$result[$i]['added_on'],

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







//Function for single Admin Logins delete

if($actionType=="productDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		$obj_change_table = $app->load_model('product_review');

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







//Function for single Admin Logins delete

if($actionType=="product_status_update")

{}





//Function for multiple Admin Logins delete

if($actionType=="productMultiDelete")

{

	$ids=$app->getPostVar('ids');

	

	if($ids != NULL && $ids!='')

	{

		

		$obj_change_table = $app->load_model('product_review');

		$update_id = $obj_change_table->execute("DELETE",false,"","id IN (".$ids.")");

		

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



if($actionType=="product_review_addedit")

{

	$getid=$app->getPostVar('id');

	

	if($getid!= NULL && $getid>0)

	{


		$product_desc=$app->getPostVar('product_desc');
		$product_star=$app->getPostVar('product_star');

			
		$obj_change_table = $app->load_model('product_review');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE product_review SET product_star='".$product_star."',product_desc='".$product_desc."' WHERE id='".$getid."'");

		

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