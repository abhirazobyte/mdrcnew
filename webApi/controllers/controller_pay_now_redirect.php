<?
class _pay_now_redirect extends controller{
	function init()
	{
		###
	}
	function onload()
	{
		$id=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getGetVar('id'));

		$obj_model_direct_payment_order = $this->app->load_model("direct_payment_order");
		$diretPaymentOrder=$obj_model_direct_payment_order->execute("SELECT", false, "", "id='".$id."'");

		if(count($diretPaymentOrder) > 0)
		{
			$this->assign("data", $diretPaymentOrder[0]);
		}
		else
		{
			$this->app->redirect('https://www.mdrcindia.com/paynow-payment-failed');
		}
	}
}
?>