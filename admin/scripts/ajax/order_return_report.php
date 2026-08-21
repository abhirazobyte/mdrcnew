<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

//get action
$get_actionType=$app->getGetVar("actionType");
$actionType=$app->getPostVar("actionType");

//Function for active order_return_report datatbale loading
if($get_actionType=="order_return_report_list")
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
		order_master.id like '%".$searchValue."%' or
		user.mobilephone like '%".$searchValue."%'
		) 
		";
	}
	$s_date=$_SESSION['search_start_date'];
	$e_date=$_SESSION['search_end_date'];
	
	if($_SESSION['search_start_date']!='' && $_SESSION['search_end_date']!='')
	{
		$search_end_date_cond=" AND STR_TO_DATE(`order_date`, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$s_date."', '%d-%m-%Y') AND STR_TO_DATE('".$e_date."', '%d-%m-%Y')";	
	}
	else
	{
		$search_end_date_cond="";
	}
	

				
	$obj_model_cancelled = $app->load_model("order_master");
	$obj_model_cancelled->join_table("user", "left", array( "name","email","billing_city","mobilephone"), array("user_id"=>"id"));
	$obj_model_cancelled->join_table("order_shipping_address", "left", array(), array("id"=>"order_master_id"));
	//$obj_model_cancelled->join_table("invoice", "left", array(), array("id"=>"order_master_id"));
	$rs_orders = $obj_model_cancelled->execute("SELECT", false, "", "order_status='Return' ".$search_end_date_cond."");

		
	$total_amount=0;
	$total_return_amount=0;
	for($i=0;$i<count($rs_orders);$i++)
	{
		$pay_value=$rs_orders[$i]['pay_value'];	
		$total_amount=$total_amount+$pay_value;
		
		$return_amount=$rs_orders[$i]['return_amount'];	
		$total_return_amount=$total_return_amount+$return_amount;
	
	}
	$TOTAL_ORDER=$app->utility->numerdisplayformate($total_amount);		
	$Return_ORDER=$app->utility->numerdisplayformate($total_return_amount);		
	
	$counter_report='<div data-label="" class="df-example demo-table"> 
        <div class="row">
          <div class="col-md-4">
            <p style="font-size: 15px;
    border: 1px solid #8392a5;
    padding: 18px;">Total Order : <strong id="total_amount" class="green">'.count($rs_orders).'</strong></p>
          </div>
          <div class="col-md-4">
            <p style="font-size: 15px;
    border: 1px solid #8392a5;
    padding: 18px;">Total Amount : <strong id="total_dr_amount" class="red"><i class="fa fa-rupee-sign"></i>'.$TOTAL_ORDER.'</strong></p>
          </div>
		  
		  <div class="col-md-4">
            <p style="font-size: 15px;
    border: 1px solid #8392a5;
    padding: 18px;">Return Amount : <strong id="total_dr_amount" class="red"><i class="fa fa-rupee-sign"></i>'.$Return_ORDER.'</strong></p>
          </div>
		 
		  
        </div>
      </div>';

			
			
	$totalRecords =count($rs_orders);
	

	## Total number of records with filtering
	$obj_model_cancelled = $app->load_model("order_master");
	$obj_model_cancelled->join_table("user", "left", array( "name","email","billing_city","mobilephone"), array("user_id"=>"id"));
	$obj_model_cancelled->join_table("order_shipping_address", "left", array(), array("id"=>"order_master_id"));
	//$obj_model_cancelled->join_table("invoice", "left", array(), array("id"=>"order_master_id"));
	$result = $obj_model_cancelled->execute("SELECT", false, "", "order_status='Return' ".$search_end_date_cond." ".$searchQuery."");
	$totalRecordwithFilter = count($result);
	

	## Fetch records
	$obj_model_cancelled = $app->load_model("order_master");
	$obj_model_cancelled->join_table("user", "left", array( "name","email","billing_city","mobilephone"), array("user_id"=>"id"));
	$obj_model_cancelled->join_table("order_shipping_address", "left", array(), array("id"=>"order_master_id"));
	//$obj_model_cancelled->join_table("invoice", "left", array(), array("id"=>"order_master_id"));
	$result = $obj_model_cancelled->execute("SELECT", false, "", "order_status='Return' ".$search_end_date_cond." ".$searchQuery." ","order_master.id DESC limit ".$row.",".$rowperpage."");
	
	
	 $row = 0;		
	 $serial = $row + 1;
	$data = array();
	for($i=0;$i<count($result);$i++)
	{
		$sr = $serial++;
		
		$old_date_timestamp = strtotime($result[$i]['order_date_time']);
		$new_date = date('d-m-Y H:i:s', $old_date_timestamp); 


			// Order From
	
			$order_status_info=$app->utility->o_status_html2020($result[$i]['order_status']);
			
			$detail_btn='<button type="button" style="margin-bottom: 3px;" class="btn btn-xs btn-warning btn-icon order_detail_onclick" data-id="'.$result[$i]['id'].'" data-toggle="tooltip" data-placement="top" title="Order Deatil"><i class="far fa-play-circle"></i></button>';
				
		//data
		$data[] = array
		(
			"id"=>$result[$i]['id'],
			"order_date_time"=>$new_date."<br/>".$order_from_info,
			"del_date"=>$result[$i]['del_date']."<br/>".$result[$i]['del_time'],
			"user_name"=>$result[$i]['user_name']."<br/>".$result[$i]['user_mobilephone'],
			"order_shipping_address_shipping_area_name"=>$result[$i]['order_shipping_address_shipping_area_name'],
			"net_order_value"=>$result[$i]['net_order_value'],
			"return_amount"=>$result[$i]['return_amount'],
			"order_status"=>$order_status_info,	
			"payment_type"=>$result[$i]['payment_type'],
			"btn"=>$detail_btn,	
		);
	}
	## Response
	$response = array(
		"draw" => $draw,
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data,
		"counter_report" =>$counter_report
	);
		
	echo json_encode($response);
	exit;
}


if($actionType=="SessionSet")
{
	$search_delivery_boy=$app->getPostVar("search_delivery_boy");
	$search_start_date=$app->getPostVar("search_start_date");
	$search_end_date=$app->getPostVar("search_end_date");
	
	$_SESSION['search_start_date']=$search_start_date;
	$_SESSION['search_end_date']=$search_end_date;
	$_SESSION['search_delivery_boy']=$search_delivery_boy;
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}
		
echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
?>