<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for Admin Logins datatbale loading

if($get_actionType=="product_images_list")

{

	$table_name='product_images';
	$product_id=$app->getGetVar("product_id");


		$status_cond=" AND product_images.product_id='".$product_id."'";
	
	
	
	
	
	




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
		
		".$table_name.".sort_order like '%".$searchValue."%' or 

		
		
		".$table_name.".status like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where  ".$table_name.".status!='Trash' ".$status_cond." ".$category_cond." ".$brand_cond." ".$searchQuery);	



	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("product", "left", array("folder"), array("product_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0 ".$status_cond." ".$brand_cond." ".$category_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	

	

	$folder='product';

	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			//Mobile

			$image=$result[$i]["image"];

			$banner_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['product_folder'].'/',"");

		
		


		
		


			

			$edit_btn='<a href="javascript:void(0)" type="button" class="btn btn-xs btn-primary btn-icon mg-r-5 product_images_addedit_onclick"  data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></a>';	

						

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon product_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';

			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';







			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'product_images\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			
		

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],

		
		

			"image"=>'<a href="'.$banner_img['medium_image'].'" class="image-popup table-product-image-list"><img src="'.$banner_img['thumb_image'].'" class="up_img"></a>',
			
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



if($actionType=="product_imagesAddEdit")
{
	
	
	$status=$app->getPostVar('status');
	$id=$app->getPostVar('id');
	
	$folder_name=$app->getPostVar('folder_name');
	
	
	
	if($status!='' && $id!='')
	{
		$update_field = array();
		if(!empty($_FILES['brand_image']['name']))
		{
			$upload_dir='product/'.$folder_name.'/';
	
			
			
			$banner_img11=$app->utility->resize_multi_image_2020($_FILES['brand_image']['name'],$_FILES['brand_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1000','480','250');
			$update_field['image']=$banner_img11;
		}			
		
		
		
		//Insert Update Record
		
		
		
		
		$update_field['status'] = $status;
		
		$obj_model_user = $app->load_model("product_images");
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






//Function for single Admin Logins delete

if($actionType=="productDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		$obj_change_table = $app->load_model('product_images');

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

{

	$getid=$app->getPostVar('getid');

	$value=$app->getPostVar('value');

	

	if($getid!= NULL && $getid>0 && $value!='')

	{

		$obj_change_table = $app->load_model('product_images');

		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE product SET status='".$value."' WHERE id='".$getid."'");

		

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





//Function for multiple Admin Logins delete

if($actionType=="productMultiDelete")

{

	$ids=$app->getPostVar('ids');

	

	if($ids != NULL && $ids!='')

	{

		

		$obj_change_table = $app->load_model('product_images');

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





		




if($actionType=="SessionSet")
{
	$search_category=$app->getPostVar("search_category");
	$search_brand=$app->getPostVar("search_brand");
	
	$_SESSION['search_category']=$search_category;
	$_SESSION['search_brand']=$search_brand;

	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}



		

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>