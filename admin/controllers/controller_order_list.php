<?php
class _order_list extends controller
{	
	function init()
	{
		if($this->app->getCurrentAction()=="")
		{
			$this->load_data();
		}
	}


	function onload()
	{
		$obj_model_city= $this->app->load_model("city");
		$rs_city = $obj_model_city->execute("SELECT",false,"","");
		$records_city = array();
		$records_city[''] = 'All';
		for($i=0;$i<count($rs_city);$i++)
		{
			$records_city[$rs_city[$i]['id']] = $rs_city[$i]['name'];
		}
		$this->assign("records_city",$records_city);

		$records_status = array();
		$records_status[''] = 'All';
		$records_status['Pending'] = 'Pending';
		$records_status['Confirmed'] = 'Confirmed';
		$records_status['Completed'] = 'Completed';
		$records_status['Cancelled'] = 'Cancelled';
		$this->assign("records_status",$records_status);

		$master_cond=" and customer_order_master.id!=0";
		$obj_model_order_counter = $this->app->load_model("customer_order_master");
		$rs_counter1 = $obj_model_order_counter->execute("SELECT", false, "SELECT count(*) as TotalCount, sum(case when ((order_status!='Trash') ".$master_cond.") then 1 else 0 end) AllCount,
		sum(case when (order_status = 'Pending' ".$master_cond.") then 1 else 0 end) PendingCount,
		sum(case when (order_status = 'Confirmed'  ".$master_cond.") then 1 else 0 end) ConfirmedCount,
		sum(case when (order_status = 'Completed'  ".$master_cond.") then 1 else 0 end) CompletedCount,
		sum(case when (order_status = 'Cancelled'  ".$master_cond.") then 1 else 0 end) CanceledCount FROM customer_order_master");
		$AllCount=$rs_counter1[0]['AllCount'];
		$PendingCount=$rs_counter1[0]['PendingCount'];
		$ConfirmedCount=$rs_counter1[0]['ConfirmedCount'];
		$CanceledCount=$rs_counter1[0]['CanceledCount'];
		$CompletedCount=$rs_counter1[0]['CompletedCount'];
		if($AllCount==NULL || $AllCount=='')
		{
			$AllCount=0;
		}
		if($PendingCount==NULL || $PendingCount=='')
		{
			$PendingCount=0;
		}
		if($ConfirmedCount==NULL || $ConfirmedCount=='')
		{
			$ConfirmedCount=0;
		}
		if($CanceledCount==NULL || $CanceledCount=='')
		{
			$CanceledCount=0;
		}
		if($CompletedCount==NULL || $CompletedCount=='')
		{
			$CompletedCount=0;
		}
		$this->app->assign("AllCount",$AllCount);
		$this->app->assign("PendingCount",$PendingCount);
		$this->app->assign("ConfirmedCount",$ConfirmedCount);
		$this->app->assign("CanceledCount",$CanceledCount);
		$this->app->assign("CompletedCount",$CompletedCount);
	}


	function load_data()
	{
	}


	function export_data()
	{
		
		$table_name='customer_order_master';

		$this->app->no_html=true;
		$obj_excel = $this->app->load_module("PHPExcel");
		$ExeclHeads=array("ID","Order Date","Order From","Customer","Email","Phone","City","Subtotal","Discount","Promo Wallet","Wallet","Total","Payment Type","Status");


		$current_status=$this->app->getGetVar("current_status");
		if($current_status!='')
		{
			$status_cond=" AND ".$table_name.".order_status='".$current_status."'";
		}
		else
		{
			$status_cond="";
		}

		$search_cond='';
		$search_cond.=$_SESSION['search_test']!=''?" AND customer_order_detail.order_item_name like '%".$_SESSION['search_test']."%'":"";
		$search_cond.=$_SESSION['search_order_status']!=''?" AND ".$table_name.".order_status='".$_SESSION['search_order_status']."'":"";
		$search_cond.=$_SESSION['search_city']!=''?" AND ".$table_name.".city_id='".$_SESSION['search_city']."'":"";
		$search_cond.=$_SESSION['search_cust_name']!=''?" AND customer.name like '%".$_SESSION['search_cust_name']."%'":"";
		$search_cond.=$_SESSION['search_cust_email']!=''?" AND customer.email like '%".$_SESSION['search_cust_email']."%'":"";
		$search_cond.=$_SESSION['search_cust_phone']!=''?" AND customer.phone like '%".$_SESSION['search_cust_phone']."%'":"";
		$search_cond.=$_SESSION['search_start_order_date']!=''?" AND STR_TO_DATE(`order_date`, '%d-%m-%Y') BETWEEN STR_TO_DATE('".$_SESSION['search_start_order_date']."', '%d-%m-%Y') AND STR_TO_DATE('".$_SESSION['search_end_order_date']."', '%d-%m-%Y')":"";


		$obj_model_item = $this->app->load_model("customer_order_master");
		$obj_model_item->join_table("customer", "left", array( "name","email","phone","last_name"), array("customer_id"=>"id"));
		$obj_model_item->join_table("city", "left", array("name"), array("city_id"=>"id"));
		$rs_item=$obj_model_item->execute("SELECT", false, "","".$table_name.".id!=0 ".$search_cond." ".$status_cond."");
		//echo $obj_model_item->sql;exit;
		
		foreach($rs_item as $item)
		{
			$user_array[]=array(
				"ID"=>$item['display_order_no'],
				"Order Date"=>$item['order_date'],
				"Order From"=>$item['order_from'],
				"Customer"=>$item['customer_name'],
				"Email"=>$item['customer_email'],
				"Phone"=>$item['customer_phone'],
				"City"=>$item['city_name'],
				"Subtotal"=>$item['subtotal'],
				"Discount"=>$item['discount'],
				"Promo Wallet"=>$item['promo_wallet_amount'],
				"Wallet"=>$item['wallet_amount'],
				"Total"=>$item['net_order_value'],
				"Payment Type"=>$item['payment_type'],
				"Status"=>$item['order_status'],
			);	

			$obj_model_order_detail= $this->app->load_model("customer_order_detail");
			$rs_detail= $obj_model_order_detail->execute("SELECT", false, "","customer_order_detail.order_master_id='".$item['id']."'");

			foreach($rs_detail as $single_item)
			{
				$user_array[]=array(
					"ID"=>'',
					"Order Date"=>'',
					"Order From"=>'',
					"Customer"=>'',
					"Email"=>'',
					"Phone"=>'',
					"City"=>$single_item['order_item_name'],
					"Subtotal"=>$single_item['mrp']>$single_item['price']?($single_item['mrp']-$single_item['price']):'0',
					"Discount"=>'0',
					"Promo Wallet"=>'0',
					"Wallet"=>'0',
					"Total"=>$single_item['total'],
					"Payment Type"=>NULL,
					"Status"=>NULL,
				);	
			}
		}
		$array_field=array(
			"block_name"=>array("options"=>"","prompt_title"=>"","prompt"=>""),
			"flat_type"=>array("options"=>"","prompt_title"=>"","prompt"=>""),
			"resident_type"=>array("options"=>"","prompt_title"=>"","prompt"=>"")
		);
		$data_array=$user_array;
		$fields=array("ID","Order Date","Order From","Customer","Email","Phone","City","Subtotal","Discount","Promo Wallet","Wallet","Total","Payment Type","Status");
		$filename="Iteam - ".date('d-m-Y');
		$this->app->utility->export_excel($ExeclHeads,$data_array,$fields,$filename,$array_field);			
	}

	function create_shipment()
	{

	}
}
?>