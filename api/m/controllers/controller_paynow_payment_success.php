<?
class _paynow_payment_success extends controller{

	function init()
	{
	}

	function onload()
	{
		
		$this->app->setTitle($this->app->meta['title']);
		$this->app->setKeywords($this->app->meta['keyword']);
		$this->app->setDescription($this->app->meta['description']);

		if($_SESSION['DirectOrderID']=='')
		{
			$this->app->redirect(SERVER_ROOT);
			exit;
		}
		$orderID=$_SESSION['DirectOrderID'];

		$obj_order_master = $this->app->load_model("direct_payment_order");
		$rs_data = $obj_order_master->execute("SELECT",false,"","id='".$orderID."' and order_pay_status='Confirm'");
		if(count($rs_data)>0) {
			$this->app->assign("tracking_id",$rs_data[0]['payment_id']);
			$this->app->assign("pay_amount",$rs_data[0]['amount']);
			$this->app->assign("pay_status",$rs_data[0]['order_pay_status']);
		}
		else {
			$this->app->redirect(SERVER_ROOT);
		}
	}
}
?>