<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active notification datatbale loading

if($get_actionType=="notification_list")

{

	$table_name='push_notification';



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

		title like '%".$searchValue."%' or


		".$table_name.".message like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0'");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$searchQuery);

	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);

	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='0'  ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	

	$folder='push_image';

	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			

			//Mobile

			$image=$result[$i]["image"];

			$notification_img=$app->utility->get_image_path($image,$folder,"");


		

			//$edit_btn='<button type="button" class="btn btn-xs btn-primary btn-icon notification_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	

			

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon notification_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';		
			
			$resend_btn='<button type="button" class="btn btn-xs btn-warning btn-icon notification_resend_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-undo-alt"></i></button>';				

			

			$option='<div class="btn-toolbar"><div>'.$resend_btn.' '.$delete_btn.'</div></div>';

			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';

		

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],
			
			
			"title"=>$result[$i]['title'],

			"image"=>'<a href="'.$notification_img['large_image'].'" class="image-popup"><img src="'.$notification_img['large_image'].'" class="up_img"></a>',


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



//Function for notificationResend 
if($actionType=="notificationResend")

{
	$getid=$app->getPostVar('getid');
	if($getid!='')
	{
		$obj_brand = $app->load_model('push_notification');
		$result = $obj_brand->execute("SELECT", false, "", "id!='".$getid."'");
		$title=$result[0]['title'];
		$message=$result[0]['message'];
		$image=$result[0]['image'];
		$product_id=$result[0]['product_id'];
	
		$update_field = array();
		$update_field['title'] = $title;
		$update_field['message'] = $message;
		$update_field['image'] = $image;
		$update_field['product_id'] = $product_id;
		$update_field['added_on'] = date('d-m-Y H:i:s');
		$obj_model_user = $app->load_model("push_notification");
		$obj_model_user->map_fields($update_field);
		$rs=$obj_model_user->execute("INSERT",false,"","");
		if($rs>0)
		{
			if($image!='')
			{
				$image1=SERVER_ROOT."/uploads/push_image/".$image;
				$default_img='Yes';
			}
			else
			{
				$image1='';
				$default_img='No';
			}
			//$data=array('title'=>$title,'image'=>$image1,'message'=>$message,'type'=>'');
				
			
			
			$data=array(
							"type"=>"notification",
							"message"=>$message,
							'name'=>$title,
							'imgUrl'=>$image1,
							'display_img'=>$default_img,
							'offer_buttonID'=>'',
							'offer_subcat'=>'No',
							'offer_ID'=>$rs,
							'offer_desc'=>$message,
							'offer_title'=>$title,
							'offer_product_button'=>'No',
							'offer_cat_button'=>'No',
							'offer_added_on'=>date('d-m-Y'),
							'shre_msg'=>"Marwadi Store - ".$title);
			
			
			
			$send_notice=$app->utility->add_push_notification_gcm($data,'WEB');
			
			
			
			
			
			
			
			
			
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


//Function for notification addedit

if($actionType=="notificationAddEdit")

{
	$title=$app->getPostVar('title');
	$message=$app->getPostVar('message');
	$id=$app->getPostVar('id');
	
	if($title!='')
	{

		$update_field = array();

		if(!empty($_FILES['notification_image']['name']))

		{

			$upload_dir='push_image';

			

			//Image Edit

			if($id!='')

			{

				$obj_model_record = $app->load_model("push_notification");

				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");

				

				if($result[0]["image"]!=NULL)

				{

					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

				}	

			}

			

			$notification_img11=$app->utility->resize_multi_image_2020($_FILES['notification_image']['name'],$_FILES['notification_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	

			

			$update_field['image']=$notification_img11;

		}			

		//Insert Update Record

		$update_field['title'] = $title;


		$update_field['added_on'] = date('d-m-Y H:i:s');

	

		$obj_model_user = $app->load_model("push_notification");

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
			
			//data
			if($push_image!='')
			{
				$image=SERVER_ROOT."/uploads/push_image/".$notification_img11;
				 $default_img="Yes";
			}
			else
			{
				$image='';
				 $default_img="No";
			}
			//$data=array('title'=>$title,'image'=>$image,'message'=>$message,'type'=>'');
			
			
			
			
			
			
			
			
			
						$data=array(
							"type"=>"notification",
							"message"=>$message,
							'name'=>$title,
							'imgUrl'=>$image,
							'display_img'=>$default_img,
							'offer_buttonID'=>'',
							'offer_subcat'=>'No',
							'offer_ID'=>$rs,
							'offer_desc'=>$message,
							'offer_title'=>$title,
							'offer_product_button'=>'No',
							'offer_cat_button'=>'No',
							'offer_added_on'=>date('d-m-Y'),
							'shre_msg'=>"Marwadi Store - ".$title);
			
			
			
			
			
			
			$app->utility->add_push_notification_gcm($data,'WEB');
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



//Function for single notification delete

if($actionType=="notificationDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		$obj_model_record = $app->load_model("push_notification");

		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");

	

		if($result[0]["image"]!=NULL)

		{

			$upload_dir='push_image';

			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

		}	

		
		

		$obj_change_table = $app->load_model('push_notification');

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





//Function for multiple notification delete

if($actionType=="notificationMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

			$obj_model_record = $app->load_model("push_notification");

			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");

			if($result[0]["image"]!=NULL)

			{
				$upload_dir='push_image';

				$upload_dir='push_image';

				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

			}	
	

			$obj_change_table = $app->load_model('push_notification');

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