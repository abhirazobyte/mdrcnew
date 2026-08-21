<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active product_sale_report datatbale loading
if($get_actionType=="product_sale_report_list")
{
	$table_name='order_detail';

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
		p.product_name like '%".$searchValue."%'
		
		) 
		";
	}

	$s_date=date('Y-m-d',strtotime($_SESSION['search_start_date']));
	$e_date=date('Y-m-d',strtotime($_SESSION['search_end_date']));
			
	$sdate=str_replace('-','',$s_date);
	$edate=str_replace('-','',$e_date);
	

	## Total number of records without filtering
	$obj_table = $app->load_model('order_detail');
	$result = $obj_table->execute("SELECT", false, "SELECT SUM(o.product_weight * o.quantity) as all_total, SUM(o.product_weight) as pro_weight, SUM(o.line_total) as pro_amount, SUM(o.quantity) as tot_quantity,o.return_product as o_return_product, p.product_name as p_product_name, p.product_unit as p_product_unit, om.order_date_time as om_order_date_time FROM order_detail as o LEFT JOIN product as p ON p.id=o.product_id LEFT JOIN order_master as om ON om.id=o.order_master_id WHERE DATE(om.delivery_time) BETWEEN '".$sdate."' AND '".$edate."' AND (om.order_status='Delivered' or om.order_status='Return') AND o.line_total>0 AND o.return_product='' GROUP BY o.product_id");
	$totalRecords =count($result);

	## Total number of records with filtering
	$obj_table = $app->load_model('order_detail');
	$result = $obj_table->execute("SELECT", false, "SELECT SUM(o.product_weight * o.quantity) as all_total, SUM(o.product_weight) as pro_weight, SUM(o.line_total) as pro_amount, SUM(o.quantity) as tot_quantity,o.return_product as o_return_product, p.product_name as p_product_name, p.product_unit as p_product_unit, om.order_date_time as om_order_date_time FROM order_detail as o LEFT JOIN product as p ON p.id=o.product_id LEFT JOIN order_master as om ON om.id=o.order_master_id WHERE DATE(om.delivery_time) BETWEEN '".$sdate."' AND '".$edate."' AND (om.order_status='Delivered' or om.order_status='Return') AND o.line_total>0 AND o.return_product=''  GROUP BY o.product_id ".$searchQuery."");
	$totalRecordwithFilter = count($result);

	## Fetch records
	$obj_brand = $app->load_model('order_detail');
	$result=$obj_brand->execute("SELECT",false,"SELECT SUM(o.product_weight * o.quantity) as all_total, SUM(o.product_weight) as pro_weight, SUM(o.line_total) as pro_amount, SUM(o.quantity) as tot_quantity, o.return_product as o_return_product, p.product_name as p_product_name, p.product_unit as p_product_unit, om.order_date_time as om_order_date_time, om.id as om_id FROM order_detail as o LEFT JOIN product as p ON p.id=o.product_id LEFT JOIN order_master as om ON om.id=o.order_master_id WHERE DATE(om.delivery_time) BETWEEN '".$sdate."' AND '".$edate."' AND (om.order_status='Delivered' or om.order_status='Return') AND o.line_total>0 AND o.return_product='' ".$searchQuery." GROUP BY o.product_id  limit ".$row.",".$rowperpage."");
	
	 $row = 0;		
	 $serial = $row + 1;
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;

		if($result[$i]['p_product_unit']=='in_gm')
				{
					
					if($result[$i]['all_total']>=1000)
					{
						$weight=($result[$i]['all_total']/1000).' kg';
					}
					else
					{
						$weight=$result[$i]['all_total'].' gm';
					}
					
				}
				else if($result[$i]['p_product_unit']=='in_ltr')
				{
					
					if($result[$i]['all_total']>=1000)
					{
						$weight=($result[$i]['all_total']/1000).' ltr';
					}
					else
					{
						$weight=$result[$i]['all_total'].' ml';
					}
					
					
				}
				else
				{
					
					$weight=(int)$result[$i]['all_total'].' pcs';
					
				}
		//data
		$data[] = array
		(
			"id"=>$sr,
			"p_product_name"=>$result[$i]['p_product_name'],
			"product_weight"=>$weight,
			"pro_amount"=>"<i class='fa fa-rupee-sign'></i>".$result[$i]['pro_amount']		
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
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>