<?
class _checkout_process extends controller{

	function init()
	{
	}

	function onload()
	{

		if ($_SESSION['MDRCCustID'] <= 0)
		{
			$this->app->utility->set_message("Please login to view order details.", "ERROR");
			$this->app->redirect("/");
			exit;
		}
		$paymentId=$this->app->getGetVar("paymentID");

		if(empty($paymentId))
		{
			$this->app->utility->set_message("Order not found.", "ERROR");
			$this->app->redirect("checkout");
			exit;
		}

		$obj_model_settings = $this->app->load_model("customer_order_payment_data");
		$paymentData= $obj_model_settings->execute("SELECT", false, "", "id='".$paymentId."'");
		
		if(count($paymentData)==0)
		{
			$this->app->utility->set_message("Order not found.", "ERROR");
			$this->app->redirect("checkout");
			exit;
		}

		$order_id=$paymentData[0]['order_master_id'];

		$obj_model_order = $this->app->load_model("customer_order_master");
		$obj_model_order->join_table("customer", "left", array(), array("customer_id"=>"id"));
		$rs_order= $obj_model_order->execute("SELECT", false, "", "customer_order_master.id='".$order_id."'");
		$this->app->assign("paymentData", $paymentData[0]);
		$this->app->assign("orderData", $rs_order[0]);
		//$this->app->assign("razorpayOrderId", $razor_order_id);
	}
}
?>