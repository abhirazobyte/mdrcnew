<?
class _payment_failed extends controller{

	function init()
	{
	}
	
	function onload()
	{
		
		$orderID=$_SESSION['OrderID'];
		$orderPayID=$_SESSION['orderPayID'];

		if(!empty($orderPayID) && is_numeric($orderPayID))
		{
			$obj_model_payment_data=$this->app->load_model("customer_order_payment_data");
			$result_pay=$obj_model_payment_data->execute("SELECT",false,"","id='".$orderPayID."'");
			if(count($result_pay)>0) {				
				//get all data to show on view
				$this->app->assign("tracking_id",$result_pay[0]['transction_id']);
				$this->app->assign("pay_amount",$result_pay[0]['transaction_amount']);
				$this->app->assign("pay_status",$result_pay[0]['payment_status']);

				$obj_order_master = $this->app->load_model("customer_order_master");
				$rs_data = $obj_order_master->execute("SELECT",false,"","customer_order_master.id='".$orderID."'");
				$this->app->assign("rs_data",$rs_data);

				$obj_order_table= $this->app->load_model("customer_order_collection_address");
				$obj_order_table->join_table("city", "left", array("name"), array("city_id"=>"id"));
				$obj_order_table->join_table("state", "left", array("name"), array("state_id"=>"id"));
				$rs_collection_address = $obj_order_table->execute("SELECT",false,"","customer_order_collection_address.order_master_id='".$orderID."'");

				$this->app->assign("rs_collection_address",$rs_collection_address);
				$obj_order_tble= $this->app->load_model("customer_order_lab_address");
				$rs_lab_data = $obj_order_tble->execute("SELECT",false,"","customer_order_lab_address.order_master_id='".$orderID."'");
				$this->app->assign("rs_lab_data",$rs_lab_data);

				$obj_order_tble= $this->app->load_model("customer_order_detail");
				$obj_order_tble->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","line1","pincode","area_id","area"), array("customer_members_id"=>"id"));
				$rs_order_detail = $obj_order_tble->execute("SELECT",false,"","customer_order_detail.order_master_id='".$orderID."'");
				$this->app->assign("rs_order_detail",$rs_order_detail);
			}
			else {
				$this->app->redirect(SERVER_ROOT);
			}
		}
		else {
			$this->app->redirect(SERVER_ROOT);
		}
	}
}
?>