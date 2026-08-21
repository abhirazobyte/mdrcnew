<?
class _order_payment_webview extends controller
{
	function init()
	{
	}
	
	function onload()
	{
		$orderID=$this->app->getGetVar('orderID');
		$paymentID=$this->app->getGetVar('paymentID');

		if($orderID=='' || $paymentID=='') {
			$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=failed&msg1=Failed&msg2=");
		}
	
		$obj_model = $this->app->load_model("customer_order_payment_data");
		$obj_model->join_table("customer", "left", array(), array("customer_id"=>"id"));
		$orderData = $obj_model->execute("SELECT", false, "", "customer_order_payment_data.id='".$paymentID."' and customer_order_payment_data.order_master_id='".$orderID."'");

		if(count($orderData)>0){
			$this->app->assign("orderData",$orderData[0]);
		} else {
			$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=failed&msg1=Failed&msg2=");
		}
	}
}
?>