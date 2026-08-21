<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");
//Function for active banner datatbale loading
if($get_actionType=="add_money_list")
{
	$table_name='wallet_transction';
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
		".$table_name.".amount like '%".$searchValue."%' or
		".$table_name.".amount_type like '%".$searchValue."%' or
		".$table_name.".transaction_id like '%".$searchValue."%' or
		".$table_name.".remark like '%".$searchValue."%' or
		".$table_name.".transaction_date like '%".$searchValue."%'
		)
		";
	}
	if($app->getGetVar("customer_id")!='')
	{
		$customer_cond="and customer_id='".$app->getGetVar("customer_id")."'";
	}
	else
	{
		$customer_cond='';
	}
	
	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];
	$type=$_SESSION['search_type'];

	if($type!='')
	{
		$con=" AND ".$table_name.".pay_with='".$type."'";
	}
	else
	{
		$con="";
	}
	
	if($s_date!='' && $e_date!='')
	{
		$search_end_date_cond=" AND STR_TO_DATE(wallet_transction.entry_date_time, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y')";
	}
	else
	{
		$search_end_date_cond = "";
	}

		## Total number of records without filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0  ".$customer_cond."");
	$totalRecords = $result[0]['allcount'];
	## Total number of records with filtering
	$obj_table = $app->load_model($table_name);
	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,customer.name AS customer from ".$table_name." LEFT JOIN customer AS customer ON(customer.id=".$table_name.".customer_id) where  ".$table_name.".id!='' ".$search_end_date_cond." ".$con." ".$customer_cond."  ".$searchQuery);
	$totalRecordwithFilter = $result[0]['allcount'];
	
	## Fetch records
	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("customer", "left", array("name","phone"), array("customer_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!='' ".$search_end_date_cond." ".$con." ".$customer_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");
	$data = array();
	
	for($i=0;$i<count($result);$i++)
	{
		//$old_date_timestamp = date_create($result[$i]['entry_date_time']);
		//$new_date = date_format($old_date_timestamp,'d-m-Y');
		
		
		$new_date = date('d-m-Y h:i A', strtotime($result[$i]['entry_date_time']));


		$a_type=$result[$i]['amount_type'];
		if($a_type=='+')
		{
			$class='green';
		}
		else
		{
			$class='red';
		}
		
		
		
		
		$final_amount=$result[$i]['amount']+$result[$i]['promo_amount'];
		
		$final_amount=number_format($final_amount,'2','.','');
		
		
		if($result[$i]['payment_status']=='Success')
			{
				$payment_status='<span class="badge badge-success">Success</span>';
				
			}
			else 
			
			{
				$payment_status='<span class="badge badge-danger">Failed</span>';
				
			}
			
			
			
			$customer_info='<a href="index.php?view=customer_detail&customer_id='.$result[$i]['customer_id'].'" target="_blank" class="detail_information">'.$result[$i]['customer_name']."<br/>".$result[$i]['customer_phone'].'</a>';
		
		
		
		
		
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"customer_name"=>$customer_info,
			"amount"=>'<span class="'.$class.'">'.$a_type.'<i class="fa fa-rupee-sign"></i> '.$final_amount.'</span>',
			"transaction_id"=>$result[$i]['transaction_id'],
			"remark"=>$result[$i]['remark'],
			"payment_status"=>$payment_status,
			
			
			"pay_with"=>$result[$i]['pay_with'],
			"entry_date_time"=>$new_date,
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
if($actionType=="add_moneyAddEdit")
{
	$customer_id=$app->getPostVar('customer_id');
	if($customer_id!='')
	{
		$customer_id=$app->getPostVar("customer_id");
		$remark=$app->getPostVar("remark");
		$amount_type=$app->getPostVar("amount_type");
		
		$amount=$app->getPostVar("amount");
		if($amount_type!='')
		{
			$obj_model_customer = $app->load_model("customer",$customer_id);
			$rs_customer=$obj_model_customer->execute("SELECT");
			if(count($rs_customer)==1)
			{
				$wallet=$rs_customer[0]['wallet'];
				if($amount_type=='-')
				{
					if($amount>$wallet)
					{
						$msg='Amount is larger than wallet balnce.';
						$msgcode=1;
						echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg,"custID"=>$customer_id));
						exit;
					}
					$new_wallet=$rs_customer[0]['wallet']-$amount;
					$type='Minus';
				}
				else
				{
					$new_wallet=$rs_customer[0]['wallet']+$amount;
					$type='Plus';
				}
				$update_field = array();
				$update_field['wallet']=$new_wallet;
				$obj_model_customer = $app->load_model("customer",$customer_id);
				$obj_model_customer->map_fields($update_field);
				$obj_model_customer->execute("UPDATE");
				
				$data_t=array();
				$data_t['customer_id']=$customer_id;
				$data_t['email']=$rs_customer[0]['email'];
				$data_t['amount_type']=$amount_type;
				$data_t['amount']=$amount;
				$data_t['transaction_id']=$transaction_id;
				$data_t['added_by']='Admin';
				$data_t['pay_with']='Admin';
				$data_t['payment_status']='Success';
				$data_t['last_bal']=$rs_customer[0]['wallet'];
				$data_t['transaction_date']=date('d-m-Y H:i:s');
				$data_t['wallet_type']='Wallet';
				$data_t['remark']=$remark;
				$data_t['last_bal']=$rs_customer[0]['wallet'];
				$data_t['ip']=$_SERVER['REMOTE_ADDR'];
				$data_t['entry_date_time']=date('d-m-Y H:i:s');
				$obj_model_wallet_transction=$app->load_model("wallet_transction");
				$obj_model_wallet_transction->map_fields($data_t);
				$ins=$obj_model_wallet_transction->execute("INSERT");
				if($ins)
				{
					$msg="Money added successfull.";
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
		else
		{
				$msg='Please Fill Require Data1';
				$msgcode=1;
		}
	}
	else
	{
		$msg='Please Fill Require Data2';
		$msgcode=1;
	}
	
	echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg,"custID"=>$customer_id,"new_wallet"=>$new_wallet));
	exit;
}
if($actionType=="SessionSet")
{
	$search_type=$app->getPostVar("search_type");
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	$_SESSION['search_type']=$search_type;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg,"custID"=>$customer_id));
?>