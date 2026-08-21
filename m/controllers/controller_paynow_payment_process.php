<?
class _paynow_payment_process extends controller{

	function init()
	{
	}
	
	function onload()
	{
		
		//print_r($this->app->getPostVar('encResp')); exit; 
		//$encResponse='6eb24b7a9c431a38646c27723997a72ae9ee1a675b82010772f7e00cc17a2bcd2455a47114d50ec03b30276ebfb7f581fd5a957e91b01a0bda8d993ab10588739975c8eaaf890cb7aad92383cb095ee12661103a56d9e3290a31beb6cee1d519ee5edf6aac3ab5046b3d7da811ee44a5916cb372c8d84d225467462eac60955e0114d7518bb6730a7803d402a9f956dd69c0aa3b5e59898c13266dfaf346490e1ef01faefac9274c99b617ae3ea08fa32e5cd3e896ddd544d5f953e8b6c7d791abe007dd0405238e615c8905d7f88cb2ae91ab8967ab6553d4a51964aa3088558675622e0ce6c8c5eac4eb5eaf5c7f20c4595e64f4ce9ca6e2ccd85828c7bfe98b3008959bd44b96634e69073c17f379127dff6db796e314931b94fafd5fd52717d49843d57b14cd7f41355ecd259eefb4bf7c16bdb41781847d9c851ad83158694b38567ec5084ce321ad9098f738b9a8719ebd545aa53ae3dde241b3efc687b914928b0ab2e0c7c1dc9f8dfcc19b9da6df01fc8099bf6615809b43f49bf9e1621562af4c8b66effe1676d51fded5256a90f3ea60e16e94e6f558f2585b201c0785ebe61342354816bbaada106d66a0790061e4901288e788ccd701d0cb26ff4b9eb5ee94b55ca3739e646fdbffee47654c941a4558d4e78eda73cea0dd2c1a358e53518d08b1ff989083069797a13286d173a13b9b50a055db4c04b58d2dc27eafae40b4e5f17b67c9faf655cd402d8a11e646d9219287e3ebe9450d0600ab2330b9866374225568b35f2d6141f240c2d26f4ad8e83bab6bf4b64b6b522f11b90a7c3400604cf1cb484f901bd3099aa9c7eacf45653633311142450f60b3b4d7454ee244abeb809185b1f47bc2a0cd22e6bc7ed8953ef6fc460bcc2aa23730b21a6c99cae6d85537d378d4f4e41bedb3d76e6e9b35507df7c8924f84fe71f47d4e87f6a582646f9bd1629f31e0d13ece30b84f643dd0cc688b25b30c932f98574cea5b7bec991f76ce2b4d632e08929054eca4bf1ed8480406b911cb2c40cd';
		$encResponse=$this->app->getPostVar('encResp');

		include('ccavenue/Crypto.php');
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
					$this->app->redirect('paynow-payment-success');
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
					$this->app->redirect('paynow-payment-success');
				}
				else {
					$this->app->redirect('paynow-payment-failed');
				}
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