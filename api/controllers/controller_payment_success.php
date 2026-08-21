<?
class _payment_success extends controller{

	function init()
	{
	}

	function onload()
	{
		
		$this->app->setTitle($this->app->meta['title']);
		$this->app->setKeywords($this->app->meta['keyword']);
		$this->app->setDescription($this->app->meta['description']);

		if($_SESSION['OrderID']=='')
		{
			$this->app->redirect(SERVER_ROOT);
			exit;
		}
		$orderID=$_SESSION['OrderID'];
		$orderPayID=$_SESSION['orderPayID'];

		$obj_order_master = $this->app->load_model("customer_order_master");
		$rs_data = $obj_order_master->execute("SELECT",false,"","customer_order_master.id='".$orderID."'");
		if(count($rs_data)>0) {

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

			//get payment data if order is online
			if($orderPayID>0) {
				$obj_model_payment_data=$this->app->load_model("customer_order_payment_data");
				$result_pay=$obj_model_payment_data->execute("SELECT",false,"","id='".$orderPayID."'");
				
				$this->app->assign("tracking_id",$result_pay[0]['transction_id']);
				$this->app->assign("pay_amount",$result_pay[0]['transaction_amount']);
				$this->app->assign("pay_status",$result_pay[0]['payment_status']);
			}
			else {
				$this->app->assign("tracking_id",'');
				$this->app->assign("pay_amount",'');
				$this->app->assign("pay_status",'');
			}
		}
		else {
			$this->app->redirect(SERVER_ROOT);
		}
	}
}
?>