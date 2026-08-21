<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active banner datatbale loading

if($get_actionType=="banner_list")

{

	$table_name='banner';



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

		sort_id like '%".$searchValue."%' or 	

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

	

	$folder='main_banner_images';

	
	$obj_model_tble = $app->load_model("item_category");
	$rs_category = $obj_model_tble->execute("SELECT", false, "", "item_category.status='Active'", "item_category.sort_order ASC");
	$displayOptions = ['home' => 'Home Main Banner', 'home_radiology' => 'Home - Radiology section Banners', 'home_pathology' => 'Home - Pathology section Banners', 'radiology' => 'Radiology Department', 'pathology' => 'Pathology Department', 'premium' => 'Premium (FBC) Banner', 'diseases' => 'Health Risk Banner', 'category' => 'Health Categories Banner', 'radiology_item' => 'Items Banner- Radiology', 'pathology_item' => 'Items Banner- Pathology'];
	foreach($rs_category as $category) {
		$displayOptions[$category['slug']] = $category['name'];
	}
	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			

			//Mobile

			$image=$result[$i]["banner_image"];
			if($image=='') {
				$image=$result[$i]["mobile_image"];
			}

			$banner_img=$app->utility->get_image_path($image,$folder,"");






			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'banner\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';

					

			$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon banner_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	

			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon banner_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';

			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';

			

			
			$show_page = '';
			foreach(explode(',',$result[$i]['show_page']??'') as $page) {
				$show_page .= ($displayOptions[$page] ?? $page) . '<br>';
			}
			
		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],
			"show_page"=>$show_page,

			"image"=>'<a href="'.$banner_img['large_image'].'" class="image-popup"><img src="'.$banner_img['large_image'].'" class="up_img"></a>',

			"sort_id"=>$result[$i]['sort_id'],

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





//Function for banner addedit

if($actionType=="bannerAddEdit")

{

	$status=$app->getPostVar('status');

	$id=$app->getPostVar('id');
	
	$itemdepartments=$app->getPostVar('work_item');
	$city_ids=implode(',',$itemdepartments);

	$display=$app->getPostVar('display');
	$show_page=implode(',',$display??[]);

	if($status!='')

	{

		$update_field = array();

		if(!empty($_FILES['banner_image']['name']))
		{
			$upload_dir='main_banner_images';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("banner");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["banner_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["banner_image"]);
					//@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["banner_image"]);
					//@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["banner_image"]);									
				}	
			}

			$fileExt = strtolower(pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION));
			$banner_img11 = uniqid('img_', true) . '.' . $fileExt;
			$destination = '../../../uploads/'.$upload_dir.'/' . $banner_img11;

			move_uploaded_file($_FILES['banner_image']['tmp_name'], $destination);

			//$banner_img11=$app->utility->resize_multi_image_2020($_FILES['banner_image']['name'],$_FILES['banner_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['banner_image']=$banner_img11;
		}			
		
		
		if(!empty($_FILES['mobile_banner']['name']))
		{
			$upload_dir='main_banner_images';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("banner");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["mobile_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["mobile_image"]);
					//@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["mobile_image"]);
					//@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["mobile_image"]);									
				}	
			}

			$fileExt = strtolower(pathinfo($_FILES['mobile_banner']['name'], PATHINFO_EXTENSION));
			$mobile_image = uniqid('img_', true) . '.' . $fileExt;
			$destination = '../../../uploads/'.$upload_dir.'/' . $mobile_image;

			move_uploaded_file($_FILES['mobile_banner']['tmp_name'], $destination);

			//$mobile_image=$app->utility->resize_multi_image_2020($_FILES['mobile_banner']['name'],$_FILES['mobile_banner']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['mobile_image']=$mobile_image;
		}			

		


		//Insert Update Record

		$update_field['status'] = $status;
		$update_field['city_ids'] = $city_ids;
		$update_field['show_page'] = $show_page;
		

		$obj_model_user = $app->load_model("banner");

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



//Function for single banner delete

if($actionType=="bannerDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		$obj_model_record = $app->load_model("banner");

		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");

	

		if($result[0]["image"]!=NULL)

		{

			$upload_dir='banner';

			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

		}	

		
		

		$obj_change_table = $app->load_model('banner');

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

if($actionType=="bannerMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

			$obj_model_record = $app->load_model("banner");

			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");

			if($result[0]["image"]!=NULL)

			{

				$upload_dir='banner';

				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

			}	
	

			$obj_change_table = $app->load_model('banner');

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