<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");

$user_id=$app->getGetVar("user_id");
$obj_model_user=$app->load_model("user");
$rs_user=$obj_model_user->execute("SELECT",false,"","id='".$user_id."'");

$condion="and user.referral_from='".$rs_user[0]['ref_key']."'";


//Function for active refferal_user datatbale loading
if($get_actionType=="refferal_user_list")

{
	$table_name='user';

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
		user.id like '%".$searchValue."%' or
		user.name like '%".$searchValue."%' or
		user.email like '%".$searchValue."%' or
		user.mobilephone like '%".$searchValue."%'
		) 
		";
	}
	
				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$condion."");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".id!='0' ".$condion." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='0' ".$condion." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;
			
			$detail_btn='<button type="button" class="btn btn-xs btn-warning btn-icon user_detail_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-play"></i></button>';	
			

			$option='<div class="btn-toolbar"><div>'.$detail_btn.' </div></div>';
			
			$orders=$app->utility->customer_total_order($result[$i]['id']);
			
			$reffers=$app->utility->total_user_refer($result[$i]['ref_key']);
			
			
			$referral_from=$app->utility->total_user_referral_from($result[$i]['referral_from']);
			
			$area_name=$app->utility->user_area($result[$i]['area_id']);
			
			$otp_verified=$app->utility->user_status($result[$i]['otp_verified']);
			

			$is_active=$app->utility->user_status($result[$i]['is_active']);

		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"name"=>$result[$i]['name']." ".$result[$i]['last_name']."<br/>".$result[$i]['mobilephone']."<br/>".$result[$i]['email'],
			"is_active"=>$is_active,
			"area_id"=>$area_name,
			"wallet"=>'<i class="fa fa-rupee-sign"></i> '.$result[$i]['wallet'],
			"orders"=>$orders,
			"reffers"=>$reffers,
			"referral_from"=>$referral_from['name']." ".$referral_from['last_name'],
			"otp_code"=>$result[$i]['otp_code']."<br/>".$otp_verified,
			"registration_date"=>$result[$i]['registration_date'],
			"btn"=>$option
		);
	}
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data,
	);
		
	echo json_encode($response);
	exit;
}





if($get_actionType=="refferal_benefits")

{
	$table_name='wallet_transaction';

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
		wallet_transaction.id like '%".$searchValue."%' or
		wallet_transaction.order_id like '%".$searchValue."%'
		) 
		";
	}
	

				
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".user_id='".$user_id."' and   payment_status!='failed'");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".user_id='".$user_id."' and   payment_status!='failed' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".user_id='".$user_id."' and   payment_status!='failed' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;
		
		if($result[$i]['type']=='Plus')
		{
			$amount='<i class="fa fa-rupee-sign"></i>  + '.$result[$i]['amount'];
		}
		else
		{
			$amount='<i class="fa fa-rupee-sign"></i>  - '.$result[$i]['amount'];
		}
		
		
		if($result[$i]['order_id']!=0)
		{
			$orderID='SL'.$result[$i]['order_id'];
		}
		else
		{
			$orderID='-';
		}
		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"order_id"=>$orderID,
			"amount"=>$amount,
			"payment_with"=>$result[$i]['payment_with'],
			"remark"=>$result[$i]['remark'],
			"transaction_date"=>$result[$i]['transaction_date']
		);
	}
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data,
	);
		
	echo json_encode($response);
	exit;
}






//Function for refferal_user addedit

if($actionType=="refferal_userAddEdit")

{

	$status=$app->getPostVar('status');

	$id=$app->getPostVar('id');


	if($status!='')

	{

		$update_field = array();

		if(!empty($_FILES['refferal_user_image']['name']))
		{
			$upload_dir='main_refferal_user_images';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("refferal_user");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["refferal_user_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["refferal_user_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["refferal_user_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["refferal_user_image"]);									
				}	
			}

			$refferal_user_img11=$app->utility->resize_multi_image_2020($_FILES['refferal_user_image']['name'],$_FILES['refferal_user_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['refferal_user_image']=$refferal_user_img11;
		}			
		
		
		if(!empty($_FILES['mobile_refferal_user']['name']))
		{
			$upload_dir='main_refferal_user_images';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("refferal_user");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["mobile_image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["mobile_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["mobile_image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["mobile_image"]);									
				}	
			}

			$mobile_image=$app->utility->resize_multi_image_2020($_FILES['mobile_refferal_user']['name'],$_FILES['mobile_refferal_user']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['mobile_image']=$mobile_image;
		}			

		


		//Insert Update Record

		$update_field['status'] = $status;

	

		$obj_model_user = $app->load_model("refferal_user");

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



//Function for single refferal_user delete

if($actionType=="refferal_userDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		

		$obj_model_record = $app->load_model("refferal_user");

		$result=$obj_model_record->execute("SELECT",false,"","id='".$getid."'");

	

		if($result[0]["image"]!=NULL)

		{

			$upload_dir='refferal_user';

			@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

			@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

		}	

		
		

		$obj_change_table = $app->load_model('refferal_user');

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





//Function for multiple refferal_user delete

if($actionType=="refferal_userMultiDelete")

{

	$ids=$app->getPostVar('ids');

	$temp_ids=explode(',',$ids);

	if($ids != NULL && $ids!='')

	{

		for($i=0;$i<count($temp_ids);$i++)

		{

			$obj_model_record = $app->load_model("refferal_user");

			$result=$obj_model_record->execute("SELECT",false,"","id=".$temp_ids[$i]."");

			if($result[0]["image"]!=NULL)

			{

				$upload_dir='refferal_user';

				@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);

				@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									

			}	
	

			$obj_change_table = $app->load_model('refferal_user');

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