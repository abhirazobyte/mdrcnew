<?
class _order_payment_retry extends controller
{
	function init()
	{
	}
	
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);

		$orderID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('orderID'));
		$orderID=$orderID!=''?$this->app->utility->decrypt($orderID):"";

		$paymentID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('paymentID'));
		$paymentID=$paymentID!=''?$this->app->utility->decrypt($paymentID):"";

		if($userID!='' && $orderID!='' && $paymentID!='')
		{
			$result=[
				"orderID"=>"MQ==",
				"paymentID"=>"MQ==",
				"failMsg1"=>"Your Payment Failed.",
				"failMsg2"=>"COD order is placed. You can retry payment or cancel order.",
				"retryPayButton"=>"Yes",
				"cancelButton"=>"Yes",
				"webViewUrl"=>"https://www.mdrcindia.com/appApi/index.php?view=order_payment_webview"
			];
			$message=array("message"=>'Redirect To Payment',"msgCode"=>"3","result"=>$result);
		}
		else
		{
			$message=array("message"=>'Try Again',"msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>