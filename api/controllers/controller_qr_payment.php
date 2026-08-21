<?

class _qr_payment extends controller{

	function init(){

	}

	function onload()
	{
		
		$order=$this->app->getGetVar("order");
		if($order=='')
		{
			$this->app->redirect(SERVER_ROOT.'/404');
		}
	
		$obj_model_all = $this->app->load_model("payment_links");
		$payment = $obj_model_all->execute("SELECT",false,"","id='".$order."'","id desc");
		if(count($payment)<=0)
		{
			$this->app->redirect(SERVER_ROOT.'/404');
		}
		//success
		if($payment[0]['status']=='Success')
		{
			$this->app->redirect(SERVER_ROOT.'/qr-payment-success/'.$order.'');
		}
		$pay_amount=$payment[0]['amount'];
		$pay_name=$payment[0]['name'];
		$pay_phone=$payment[0]['mobile'];
		$pay_email=$payment[0]['email'];
		//create order					
		$update_data = [];
		$update_data["payment_link_id"] =$payment[0]['id'];
		$update_data["employee_id"] = $payment[0]['employee_id'];
		$update_data["transaction_id"] = '';
		$update_data["ip"] = $_SERVER['REMOTE_ADDR'];
		$update_data["created_date"] = date('d-m-Y H:i:s');
		$obj_model_direct_payment_order = $this->app->load_model("payment_link_transaction");
		$obj_model_direct_payment_order->map_fields($update_data);
		$diretPaymentOrderID=$obj_model_direct_payment_order->execute("INSERT");	


		include('../ccavenue/Crypto.php');

		define("CCA_MERCHANT_ID", "381290");
		define("CCA_ACCESS_CODE", "AVWU07ID80BT16UWTB");
		define("CCA_WORKING_KEY", "636CC2C22573FA93F70D751324881CB1");
		define("CCA_URL", "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction");

		$merchant_id=CCA_MERCHANT_ID;
		$working_key=CCA_WORKING_KEY;
		$access_code=CCA_ACCESS_CODE;

		$language='EN';
		$currency='INR';
		$redirect_url="https://www.mdrcindia.com/SalesApp/qr-payment-process";
		$cancel_url="https://www.mdrcindia.com/SalesApp/qr-payment-process";

		$billing_address='';
		$billing_city='';
		$billing_state='';
		$billing_zip='';
		$billing_country='';

		$paramList=[];
		$paramList["merchant_id"] = $merchant_id;
		$paramList["language"] = $language;
		$paramList["order_id"] = 'MDRC-PL'.$diretPaymentOrderID;
		$paramList["amount"] = (int)$pay_amount;
		$paramList["currency"] = $currency;
		$paramList["redirect_url"] = $redirect_url;
		$paramList["cancel_url"] = $cancel_url;
		$paramList["customer_id"] = $payment[0]['employee_id'];    
		$paramList["billing_name"] = $pay_name;
		$paramList["billing_address"] = $billing_address;
		$paramList["billing_city"] = $billing_city;
		$paramList["billing_state"] = $billing_state;
		$paramList["billing_zip"] = $billing_zip;
		$paramList["billing_country"] = $billing_country;
		$paramList["billing_tel"] = $pay_phone;
		$paramList["billing_email"] = $pay_email;

		foreach ($paramList as $key => $value)
		{
			$merchant_data.=$key.'='.$value.'&';
		}

		$encrypted_data=encrypt($merchant_data,$working_key); 

		$paymentGateway=[];
		$paymentGateway["encRequest"] = $encrypted_data;
		$paymentGateway["access_code"] = $access_code;

		$this->app->assign("payment",$payment[0]);
		$this->app->assign("paymentGateway",$paymentGateway);
	}
}
?>