<?
class _pay extends controller
{
	function init()
	{
	}
	function onload()
	{
		
		$this->app->setTitle('Pay - '.$this->app->meta['title']);
		$this->app->setKeywords($this->app->meta['keyword']);
		$this->app->setDescription($this->app->meta['description']);
		
		// $_SESSION['orderPayID']='40';
		// $_SESSION['OrderID']='73';
		// $_SESSION['Transaction_Amount']='4000';
		// $_SESSION['MDRCCustID']='2';
		// $_SESSION['MDRCCustID']='Virag Gandhi';
		// $_SESSION['MDRCCustPhone']='9510069163';
		// $_SESSION['MDRCCustEmail']='29virag@gmail.com';

		if($_SESSION['orderPayID']>0)
		{
			$obj_order_payment= $this->app->load_model("customer_order_payment_data");
			$rs_payment=$obj_order_payment->execute("SELECT",false,"","id='".$_SESSION['orderPayID']."'");
			$this->app->assign("rs_payment",$rs_payment[0]);

			$obj_model_customer =$this->app->load_model("customer");
			$rs_customer= $obj_model_customer->execute("SELECT",false,"","id='".$rs_payment[0]['customer_id']."'","id DESC");
			$this->app->assign("rs_customer",$rs_customer[0]);

			$_SESSION['MarwadiCust_wallet']=$rs_customer[0]['wallet'];
			$_SESSION['MarwadiCust_promoWallet']=$rs_customer[0]['promoWallet'];
		}
		else
		{
			$this->app->redirect(SERVER_ROOT);
			exit;
		}
	}
}
?>