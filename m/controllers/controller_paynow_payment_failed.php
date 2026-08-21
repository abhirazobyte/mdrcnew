<?
class _paynow_payment_failed extends controller{

	function init()
	{
	}
	
	function onload()
	{
		
		$orderID=$_SESSION['DirectOrderID'];

		if(!empty($orderID))
		{
			$obj_model_payment_data=$this->app->load_model("direct_payment_order");
			$result_pay=$obj_model_payment_data->execute("SELECT",false,"","id='".$orderID."'");
			if(count($result_pay)>0) {				
				//get all data to show on view
				$this->app->assign("tracking_id",$result_pay[0]['payment_id']);
				$this->app->assign("pay_amount",$result_pay[0]['amount']);
				$this->app->assign("pay_status",$result_pay[0]['order_pay_status']);
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