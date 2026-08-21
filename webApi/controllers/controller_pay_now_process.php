<?
class _pay_now_process extends controller{

	function init()
	{
	}
	
	function onload()
	{
		$encResponse=$this->app->getPostVar('encResp');

		include('../ccavenue/Crypto.php');
		$workingKey=CCA_WORKING_KEY;       //Working Key should be provided here.
		$rcvdString=decrypt($encResponse,$workingKey);    //Crypto Decryption used as per the specified working key.
		
		$decryptValues=explode('&', $rcvdString);
		$dataSize = sizeof ($decryptValues);

		for($i = 0; $i < $dataSize; $i ++) {
			$information = explode ( '=', $decryptValues [$i] );
			$responseMap [$information [0]] = $information [1];
		}

		$order_payment_id=$responseMap['order_id'];
		$order_payment_id=substr($order_payment_id, 1);
		$tracking_id=$responseMap['tracking_id'];
		$gateway_order_status=$responseMap['order_status'];
		
		if(!empty($order_payment_id) && is_numeric($order_payment_id))
		{

			$obj_model_payment_data=$this->app->load_model("direct_payment_order");
			$result_pay=$obj_model_payment_data->execute("SELECT",false,"","id='".$order_payment_id."'");
			if(count($result_pay)>0) {
			
				$order_id=$result_pay[0]['id'];
				$_SESSION['DirectOrderID']=$order_id;

				//first check payment id status
				if($result_pay[0]['order_pay_status']=='Confirm')
				{
					/*------------------Mail Data Array------------------*/
					$send_data_arary=['name'=>$result_pay[0]['name'],'email'=>$result_pay[0]['email'],'mobile'=>$result_pay[0]['mobile'],'amount'=>$result_pay[0]['amount'],'message'=>$result_pay[0]['message'],'order_pay_status'=>$result_pay[0]['order_pay_status'],'payment_id'=>$tracking_id,'date'=>$result_pay[0]['transction_date_time']];
					/*------------------Mail Data Array------------------*/

					/*------------------User Start for mail function------------------*/
					$template_name='direct_payment_order_user';
					$subject='Thank you for Payment-Format for Payment done';
					$mail_for='User';
					$to_mail=$result_pay[0]['email'];
					$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for,'to_mail'=>$to_mail];
					$this->app->utility->sendMial($data);
					/*------------------User End for mail function------------------*/


					/*------------------Admin Start for mail function------------------*/
					$template_name='direct_payment_order_admin';
					$subject='Online payment From '.$result_pay[0]['name'].' on Website';
					$mail_for='Admin';
					$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
					$this->app->utility->sendMial($data);
					/*------------------Admin End for mail function------------------*/

					//if payment already success, redirect to payment success
					$this->app->redirect('https://www.mdrcindia.com/paynow-payment-success/'.$order_payment_id);
				}

				//update order payment data entry
				$payment_data=[];
				
				//if payment succss only
				if($gateway_order_status=='Success') { $payment_data['order_pay_status']='Confirm'; }
				
				$payment_data['payment_id']=$tracking_id;
				$payment_data['payment_gateway_response']=$rcvdString;
				$payment_data['transction_date_time']=date('d-m-Y H:i:s');
				$obj_model_payment_data=$this->app->load_model("direct_payment_order");
				$obj_model_payment_data->map_fields($payment_data);
				$obj_model_payment_data->execute("UPDATE",false,"","id='".$order_id."'");

				//update order status to confirm
				if($gateway_order_status=='Success' && $order_id>0) 
				{ 
					$obj_model_payment_data2=$this->app->load_model("direct_payment_order");
					$result_pay=$obj_model_payment_data2->execute("SELECT",false,"","id='".$order_id."'");

					/*------------------Mail Data Array------------------*/
					$send_data_arary=['name'=>$result_pay[0]['name'],'email'=>$result_pay[0]['email'],'mobile'=>$result_pay[0]['mobile'],'amount'=>$result_pay[0]['amount'],'message'=>$result_pay[0]['message'],'order_pay_status'=>$result_pay[0]['order_pay_status'],'payment_id'=>$result_pay[0]['payment_id'],'date'=>$result_pay[0]['transction_date_time']];
					/*------------------Mail Data Array------------------*/

					/*------------------User Start for mail function------------------*/
					$template_name='direct_payment_order_user';
					$subject='Thank you for Payment-Format for Payment done';
					$mail_for='User';
					$to_mail=$result_pay[0]['email'];
					$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for,'to_mail'=>$to_mail];
					$this->app->utility->sendMial($data);
					/*------------------User End for mail function------------------*/


					/*------------------Admin Start for mail function------------------*/
					$template_name='direct_payment_order_admin';
					$subject='Online payment From '.$result_pay[0]['name'].' on Website';
					$mail_for='Admin';
					$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
					$this->app->utility->sendMial($data);
					/*------------------Admin End for mail function------------------*/

					//redirect to success page
					$this->app->redirect('https://www.mdrcindia.com/paynow-payment-success/'.$order_payment_id);
				}
				else {
					$this->app->redirect('https://www.mdrcindia.com/paynow-payment-failed/'.$order_payment_id);
				}
			}
			else {
				$this->app->redirect('https://www.mdrcindia.com/paynow-payment-failed/'.$order_payment_id);
			}
		}
		else {
			$this->app->redirect('https://www.mdrcindia.com/paynow-payment-failed/'.$order_payment_id);
		}
	}
}
?>