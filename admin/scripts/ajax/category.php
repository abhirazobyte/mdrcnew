<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active category datatbale loading

if($get_actionType=="category_list")

{

	$table_name='category';



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

		category_name like '%".$searchValue."%' or


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

		

			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'category\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

					

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon category_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	


			$offer_btn='<button type="button" class="btn btn-xs btn-warning btn-icon category_offer_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-percent"></i></button>';	

			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon category_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$offer_btn.' '.$edit_btn.' '.$delete_btn.'</div></div>';

				$cat_path=$app->utility->getCatPath($result[$i]['id']);
			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';


			$sort_order='<div class="input-group"><input type="text" class="populated1 form-control" value="'.$result[$i]['sort_order'].'" id="quantities_'.$result[$i]['id'].'" name="quantities[]"><div class="input-group-append"><button type="button" class="btn btn-xs btn-info" id="button-addon2" onclick="update_sort_order('.$result[$i]['id'].',\'category\')">Update</button></div></div>';
		

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],

			"category_name"=>$result[$i]['category_name'],

			"path"=>$cat_path,	
			
			"sort_order"=>$sort_order,			

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





//Function for category addedit

if($actionType=="categoryAddEdit")

{



	$category_name=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('category_name'));


	$status=$app->getPostVar('status');

	$id=$app->getPostVar('id');

	

	if($category_name!='')

	{

		if($id!='')

		{

			$cond=" and id!='".$id."'";

			$update_title='Updated';

		}

		else

		{

			$cond="";

			$update_title='Added';

		}

		$obj_model_check = $app->load_model("category");

		$rs_check=$obj_model_check->execute("SELECT",false,"","status!='Trash' and category_name='".$category_name."' ".$cond."");

		if(count($rs_check)>0)

		{

			$msg='Record Already Exist.';

			$msgcode=1;

			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

			exit;

		}

		 //Insert Update Record
		$update_field = array();		
		if(!empty($_FILES['category_image']['name']))
		{
		
		$upload_dir='category_image';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("category");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");	
				if($result[0]["category_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["category_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["category_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["category_image"]);									
				}	
			}
			$category_image=$app->utility->resize_multi_image_2020($_FILES['category_image']['name'],$_FILES['category_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['category_image']=$category_image;
		}
		
		if(!empty($_FILES['icon']['name']))
		{
		
		$upload_dir='category_icon';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("category");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");	
				if($result[0]["icon"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["icon"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["icon"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["icon"]);									
				}	
			}
			$icon=$app->utility->resize_multi_image_2020($_FILES['icon']['name'],$_FILES['icon']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['icon']=$icon;
		}
		
		if(!empty($_FILES['category_offer']['name']))
		{
		
		$upload_dir='category_image';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("category");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");	
				if($result[0]["category_offer"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["category_offer"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["category_offer"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["category_offer"]);									
				}	
			}
			$category_offer=$app->utility->resize_multi_image_2020($_FILES['category_offer']['name'],$_FILES['category_offer']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['category_offer']=$category_offer;
		}			
		
		if($id!='')
		{
			$slug=$app->utility->unique_slug('category','edit','category_slug',$app->getPostVar('category_name'),$id);
		}
		else
		{
			$slug=$app->utility->unique_slug('category','add','category_slug',$app->getPostVar('category_name'));
		}
		
		$update_field['category_slug'] = $slug;
		$update_field['status'] = $status;
		$obj_model_user = $app->load_model("category");
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



//Function for category addedit

if($actionType=="categoryOfferAddEdit")
{
	$offer_title=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar('offer_title'));
	$offer_short_description=$app->getPostVar('offer_short_description');
	$id=$app->getPostVar('id');
 
	if($id!='' && $offer_title!='')
	{
		$update_title='Added';


		$update_field = array();		
		if(!empty($_FILES['offer_image_website']['name']))
		{
			$upload_dir='category_image';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("category");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");	
				if($result[0]["offer_image_website"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["offer_image_website"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["offer_image_website"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["offer_image_website"]);									
				}	
			}
			$offer_image_website=$app->utility->resize_multi_image_2020($_FILES['offer_image_website']['name'],$_FILES['offer_image_website']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['offer_image_website']=$offer_image_website;
		}

		if(!empty($_FILES['offer_image_app']['name']))
		{
			$upload_dir='category_icon';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("category");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");	
				if($result[0]["offer_image_app"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["offer_image_app"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["offer_image_app"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["offer_image_app"]);									
				}	
			}
			$offer_image_app=$app->utility->resize_multi_image_2020($_FILES['offer_image_app']['name'],$_FILES['offer_image_app']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['offer_image_app']=$offer_image_app;
		}
		
		$update_field['offer_title']=$offer_title;
		$update_field['offer_short_description']=$offer_short_description;
		$obj_model_user = $app->load_model("category");
		$obj_model_user->map_fields($update_field);
		$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
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


//Function for single category delete

if($actionType=="categoryDelete")

{

	$getid=$app->getPostVar('getid');
	
	

	if($getid!= NULL && $getid>0)

	{
		
		$obj_change_table = $app->load_model('category');
		$count_rs= $obj_change_table->execute("SELECT",false,"","parentcategory_id='".$getid."'");
		 if(count($count_rs)>0)
		 {
		 		$msg='Already Exist Subcategory.';
				$msgcode=1;	
				echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		 }
		
		

		$obj_change_table = $app->load_model('category');
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





if($actionType=="sort_row")

{

	$id=$app->getPostVar('id');
	
	$new_sort_order=$app->getPostVar('new_sort_order');
	
	

	if($id!= NULL && $id>0 && $new_sort_order>=0)

	{
		
		
		
		
		
		
		

		$obj_change_table = $app->load_model('category');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE category SET sort_order='".$new_sort_order."' WHERE id='".$id."'");

		

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



//Function for multiple category delete

if($actionType=="categoryMultiDelete")

{

	$ids=$app->getPostVar('ids');

	

	if($ids != NULL && $ids!='')

	{	
	

		for($i=0;$i<count($ids);$i++)
		{
			
			
			$obj_change_table = $app->load_model('category');
			$count_rs= $obj_change_table->execute("SELECT",false,"","parentcategory_id='".$ids[$i]."'");
			 if(count($count_rs)>0)
			 {
					$msg='Already Exist Subcategory.';
					$msgcode=1;	
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
					
			 }

			$update_field = array();

			$update_field['status']= 'Trash';

			$obj_change_table = $app->load_model('category');

			$obj_change_table->map_fields($update_field);

			$update_id = $obj_change_table->execute("UPDATE",false,"","id='".$ids[$i]."'");

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