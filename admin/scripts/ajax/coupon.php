<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for Admin Logins datatbale loading
if($get_actionType=="coupon_list")
{
	$table_name='coupon';

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
		coupon_code like '%".$searchValue."%' or
		type like '%".$searchValue."%' or 	
		admin_note like '%".$searchValue."%' or 	
		exp_date like '%".$searchValue."%' or 	
		status like '%".$searchValue."%'
		) 
		";
	}
	
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where status!='Trash' and c_type='Admin' and vendor_id='".$_SESSION['partner']."'");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where status!='Trash' and c_type='Admin' and vendor_id='".$_SESSION['partner']."' ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "status!='Trash' and c_type='Admin' and vendor_id='".$_SESSION['partner']."' ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
				$edit_btn='<a href="index.php?view=discountcode_addedit&id='.$result[$i]['id'].'" type="button" class="btn btn-xs btn-primary btn-icon mg-r-5"><i class="fas fa-edit"></i></a>';
				
				
				
			
	
	
				$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'coupon\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
				
			
			
			
			
					
					
			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon mg-r-5 coupon_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';				
			
			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.'</div></div>';
			
			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';
				
				
			$obj_model_check= $app->load_model("customer_order_master");
			$total_data = $obj_model_check->execute("SELECT",false,"","discount_coupon_id=".$result[$i]['id']." and order_status!='Canceled'");
							
		//data
		$data[] = array
		(
			"checkbox"=>$checkbox,
			"id"=>$result[$i]['id'],
			"coupon_code"=>$result[$i]['coupon_code'],
			"type"=>$result[$i]['type'],
			"admin_note"=>$result[$i]['admin_note'],
			"total_data"=>'<a title="View Orders" href="javascript:void(0)" class="coupon_order_detail" data-id="'.$result[$i]['id'].'" >'.count($total_data).'</a>',
			"exp_date"=>$result[$i]['exp_date'],
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
if($actionType=="couponDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		$obj_change_table = $app->load_model('coupon');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE coupon SET status='Trash' WHERE id='".$getid."'");
		
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
if($actionType=="couponMultiDelete")
{
	$ids=$app->getPostVar('ids');
	
	if($ids != NULL && $ids!='')
	{
		
		$obj_change_table = $app->load_model('coupon');
		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE coupon SET status='Trash' WHERE id IN (".$ids.")");
		
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