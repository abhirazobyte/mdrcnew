<?
class _order_detail extends controller
{
	function init()
	{
	}
	function onload()
	{
		$orderID=$this->app->getGetVar('id');
		$this->app->assign("orderID", $orderID);

		if($orderID=='')
		{
			$this->app->redirect("index.php?view=order_list");
			exit;
		}

		$order_status_array=[];
		$order_status_array['Pending']='Pending';
		$order_status_array['Confirmed']='Confirmed';
		$order_status_array['Completed']='Completed';
		$order_status_array['Canceled']='Canceled';
		$this->assign("order_status_array",$order_status_array);
		
		$obj_model_order_master = $this->app->load_model("customer_order_master");
		$obj_model_order_master->join_table("city","left", array("name"), array("city_id"=>"id"));
		$obj_model_order_master->join_table("coupon","left", array("coupon_code"), array("discount_coupon_id"=>"id"));
		$rs_order_master = $obj_model_order_master->execute("SELECT", false, "","customer_order_master.id='".$orderID."'");
		$this->assign("rs_order",$rs_order_master[0]);

		if($rs_order_master[0]['home_address_id']>0)
		{
			$obj_model_home_collection = $this->app->load_model("customer_order_collection_address");
			$obj_model_home_collection->join_table("city","left", array("name"), array("city_id"=>"id"));
			$obj_model_home_collection->join_table("state","left", array("name"), array("state_id"=>"id"));
			$rs_home_collection = $obj_model_home_collection->execute("SELECT", false, "","order_master_id='".$orderID."'");
		}
		else
		{
			$rs_home_collection=[];
		}
		$this->assign("rs_home_collection_address",$rs_home_collection[0]);


		if($rs_order_master[0]['lab_id']>0)
		{
			$obj_model_home_collection = $this->app->load_model("customer_order_lab_address");
			$obj_model_home_collection->join_table("item_lab","left", array(), array("lab_id"=>"id"));
			$rs_selected_lab = $obj_model_home_collection->execute("SELECT", false, "","order_master_id='".$orderID."'");
		}
		else
		{
			$rs_selected_lab=[];
		}
		$this->assign("rs_selected_lab",$rs_selected_lab[0]);
		
		$obj_model_status_history= $this->app->load_model("customer_order_status_history");
		$rs_status = $obj_model_status_history->execute("SELECT", false, "","order_master_id='".$orderID."'","id DESC");
		$this->assign("rs_status",$rs_status);


		$obj_model_payment_data= $this->app->load_model("customer_order_payment_data");
		$rs_payment_data = $obj_model_payment_data->execute("SELECT", false, "","order_master_id='".$orderID."'","id DESC");
		$this->assign("rs_payment_data",$rs_payment_data);


		$obj_model_item_department= $this->app->load_model("item_department");
		$item_department = $obj_model_item_department->execute("SELECT", false, "","");
		$item_department=array_column($item_department, 'name','id');
		$this->assign("item_department",$item_department);

		
		$obj_model_order_cust_detail= $this->app->load_model("customer_order_detail");
		$obj_model_order_cust_detail->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","age","pincode","area_id","area","dob"), array("customer_members_id"=>"id"));
		$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","customer_order_detail.order_master_id='".$orderID."'","","customer_members.id");


		$rs_detail_array=[];
		foreach ($rs_cust_detail as $key => $value)
		{
			$obj_model_order_detail= $this->app->load_model("customer_order_detail");
			$obj_model_order_detail->join_table("item_other_data", "inner", array("item_department_ids"), array("item_id"=>"item_id"));
			$rs_detail= $obj_model_order_detail->execute("SELECT", false, "","customer_order_detail.order_master_id='".$orderID."' and customer_order_detail.customer_members_id='".$value['customer_members_id']."'");

			$rs_detail_array[]=['cust_detail'=>$value,'order_detail'=>$rs_detail];
		}
		$this->assign("rs_detail_array",$rs_detail_array);

		$obj_model_order_detail_all= $this->app->load_model("customer_order_payment_data");
		$rs_payment= $obj_model_order_detail_all->execute("SELECT", false, "","customer_order_payment_data.order_master_id='".$orderID."' AND customer_order_payment_data.payment_status='Success'");
		$this->app->assign("rs_payment",$rs_payment);

	}
		
	
}
?>