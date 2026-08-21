<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active customer datatbale loading
if($get_actionType=="customer_list")
{
	$table_name='customer';

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
		".$table_name.".last_name like '%".$searchValue."%' or
		".$table_name.".gender like '%".$searchValue."%' or
		".$table_name.".email like '%".$searchValue."%' or
		".$table_name.".phone like '%".$searchValue."%' or
		".$table_name.".referral_from like '%".$searchValue."%' or
		".$table_name.".ref_key like '%".$searchValue."%' or
		".$table_name.".wallet like '%".$searchValue."%' or
		".$table_name.".status like '%".$searchValue."%'
		) 
		";
	}


	if($_SESSION['search_start_date']!='' && $_SESSION['search_end_date']!='')
	{
		$search_end_date_cond=" AND STR_TO_DATE(customer.entry_date_time, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$_SESSION['search_start_date']."', '%d-%m-%Y') AND STR_TO_DATE('".$_SESSION['search_end_date']."', '%d-%m-%Y')";
	}
	else
	{
		$search_end_date_cond = "";
	}
	
	
	if($_SESSION['search_status']=='Active')
	{
		$status_cond="and ".$table_name.".status='Active'";
	}
	else if($_SESSION['search_status']=='Inactive')
	{
		$status_cond="and ".$table_name.".status='Inactive'";
	}
	else
	{
		$status_cond="";
	}
			
	## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' ".$status_cond." ".$date_cond."");
	$totalRecords = $result[0]['allcount'];
	
	
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.".status!='Trash' ".$status_cond." ".$search_end_date_cond." ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("customer_info", "left", array(), array("id"=>"customer_id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash' ".$status_cond." ".$search_end_date_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	
	$folder='customer';
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		
			$image=$result[$i]["image"];
			$customer_img=$app->utility->get_image_path($image,$folder,"");

			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'customer\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
		
			$edit_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-primary btn-icon customer_addedit_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-edit"></i></button>';	
			
			$delete_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-danger btn-icon customer_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';	
						
			//$wallet_btn='<a style="margin-bottom: 3px;" href="index.php?view=add_money_list&customer_id='.$result[$i]['id'].'" class="btn btn-xs btn-warning btn-icon mr-1"><i class="fas fa-wallet"></i></a>';	
			
			//$detail_btn='<a target="_blank" href="index.php?view=customer_detail&customer_id='.$result[$i]['id'].'"  class="btn btn-xs btn-secondary btn-icon mr-1"><i class="fas fa-play"></i></a>';	
	
			$option='<div class="btn-toolbar"><div>'.$detail_btn.' '.$wallet_btn.'  '.$edit_btn.' '.$delete_btn.' </div></div>';
			
	
			if($result[$i]['otp_verified']=='No')
			{
				$otp_verified='<span class="badge badge-danger">No</span>';
			}
			else if($result[$i]['otp_verified']=='Yes')
			{
				$otp_verified='<span class="badge badge-warning">Yes</span>';
			}

			$wallet=$result[$i]['wallet'];
			$wallet=number_format($wallet,'2','.','');

			$promoWallet=$result[$i]['promoWallet'];
			$promoWallet=number_format($promoWallet,'2','.','');

		

			$entry_date_time = date('d-m-Y h:i A', strtotime($result[$i]['entry_date_time']));
			
			if($result[$i]['referral_from']!='')
			{
				$refer_cust=$app->utility->CustomrReferral_from($result[$i]['referral_from']);
				$Referral_name=$refer_cust['name'];
				$Referral_key=$refer_cust['ref_key'];
				$Referral_data="<br/><strong>".$Referral_name."</strong><br/>".$Referral_key;
			}
			else
			{
				$Referral_data="";
			}
			
			$otp=$result[$i]['customer_info_phone_otp'];
			
			
			
			$Referral_data.='<br/><b>'.$result[$i]['register_from'].'</b>';
			
			
			
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
		
			"name"=>$result[$i]['name']." ".$result[$i]['last_name'],
			"phone"=>$result[$i]['phone']."<br/>".$result[$i]['email'],
			"wallet"=>'<i class="fa fa-rupee-sign"></i> '.$wallet,
			"promoWallet"=>'<i class="fa fa-rupee-sign"></i> '.$promoWallet,
			"register_from"=>$entry_date_time.$Referral_data,
			"otp_verified"=>$otp_verified."<br/>".$otp,
			"status"=>$status,
			"btn"=>$option
		);
	}
	
	$obj_brand = $app->load_model($table_name);
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".status!='Trash'  ".$search_end_date_cond." ".$searchQuery);
	
	$All_Customer=count($result);
	$Active_Customer=0;
	$Inactive_Customer=0;
	
	for($k=0;$k<count($result);$k++)
	{
		if($result[$k]['status']=='Active')
		{
			$Active_Customer=$Active_Customer+1;
		}
		else if($result[$k]['status']=='Inactive')
		{
			$Inactive_Customer=$Inactive_Customer+1;
		}
	}	
	
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data,
		"All_Customer" => $All_Customer,
		"Active_Customer" => $Active_Customer,
		"Inactive_Customer" => $Inactive_Customer
	);
		
	echo json_encode($response);
	exit;
}


//Function for customer addedit
if($actionType=="customerAddEdit")
{

	$name=$app->getPostVar('name');
	$phone=$app->getPostVar('phone');
	$email=$app->getPostVar('email');
	$otp_verified=$app->getPostVar('otp_verified');
	$id=$app->getPostVar('id');
	$whatsapp_no=$app->getPostVar('whatsapp_no');
	$birth_date=$app->getPostVar('birth_date');
	$anniversary_date=$app->getPostVar('anniversary_date');
	
	
	if($phone!='' && $name!='')
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
		
		if($phone!='' && $email!='')
		{
			$cond_phone="and (phone='".$phone."' or email='".$email."')";
		}
		else
		{
			$cond_phone="and phone='".$phone."'";
		}
		
		$obj_model_customer1= $app->load_model("customer");
		$rs_customer_check=$obj_model_customer1->execute("SELECT",false,"","id!='0' ".$cond." ".$cond_phone."");
		if(count($rs_customer_check)>0)
		{
			$msg='It seems that Email and Phone is already registered with some account! ';
			$msgcode=1;
			echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
			exit;
		}

		//Insert Update Record
		$update_field = array();
		
		if(!empty($_FILES['customer_image']['name']))
		{
			$upload_dir='customer';
			//Image Edit
			if($id!='')
			{
				$obj_model_record = $app->load_model("customer");
				$result=$obj_model_record->execute("SELECT",false,"","id='".$id."'");
				
				if($result[0]["image"]!=NULL)
				{
					@unlink('../../../uploads/'.$upload_dir.'/'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'mediumthumb'.$result[0]["image"]);
					@unlink('../../../uploads/'.$upload_dir.'/'.'thumb'.$result[0]["image"]);									
				}	
			}

			$customer_image=$app->utility->resize_multi_image_2020($_FILES['customer_image']['name'],$_FILES['customer_image']['tmp_name'],'../../../uploads/'.$upload_dir.'/','1920','750','350');	
			$update_field['image']=$customer_image;
		}			
		
		$update_field['name']=$name;
		$update_field['phone']=$phone;
		$update_field['email']=$email;
		if($id=='')
		{
			$update_field['entry_date_time']=date('d-m-Y H:i:s');
			$update_field['register_date']=date('d-m-Y H:i:s');
			$update_field['register_from'] ='Admin';
			$update_field['ip'] = $_SERVER['REMOTE_ADDR'];
		}
		
		if($id!='' && $otp_verified=='Yes')
		{
			$update_field['otp_verified']='Yes';
		}
		else if($id=='')
		{
			$update_field['otp_verified']='Yes';
		}
		
		$obj_model_customer = $app->load_model("customer");
		$obj_model_customer->map_fields($update_field);
		if($id!='')
		{
			$obj_model_customer->execute("UPDATE",false,"","id='".$id."'");
		}
		else
		{
			$rs=$obj_model_customer->execute("INSERT",false,"","");
		}
		if($id!='')
		{
			$CustID=$id;
		}
		else
		{
			$CustID=$rs;
		}
		
		//Insert Update Record
		$update_field_info = array();
		$update_field_info['customer_id']=$CustID;
		$update_field_info['whatsapp_no']=$whatsapp_no;
		$update_field_info['birth_date']=$birth_date;
		$update_field_info['anniversary_date']=$anniversary_date;
		if($id=='')
		{
			$update_field_info['entry_date_time']=date('d-m-Y H:i:s');
		}
		$obj_model_customer_info= $app->load_model("customer_info");
		$obj_model_customer_info->map_fields($update_field_info);
		
		if($id!='')
		{
			$rs_data=$obj_model_customer_info->execute("UPDATE",false,"","customer_id='".$id."'");
		}
		else
		{
			$rs_data=$obj_model_customer_info->execute("INSERT",false,"","");
		}
		

		if($rs_data)
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




//Function for single customer delete
if($actionType=="customerDelete")
{
	$getid=$app->getPostVar('getid');
	
	if($getid!= NULL && $getid>0)
	{
		
		$update_field = array();
		$update_field['status']= 'Trash';
		$obj_change_table = $app->load_model('customer');
		$obj_change_table->map_fields($update_field);
		$update_id = $obj_change_table->execute("UPDATE",false,"","id='".$getid."'");
		
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
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}

if($actionType=="SearchStatusData")
{	
	$status=$app->getPostVar("status");
	$_SESSION['search_status']=$status;
	echo $obj_json->encode(array("RESULT"=>"0","url"=>"","msg"=>"Success"));
	exit;
}

		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>