<?
class _order_payment_process extends controller
{
	function init()
	{
	}
	
	function onload()
	{
		
		//print_r($this->app->getPostVar('encResp')); exit; 
		//$encResponse='665cba1a3dfdcf73167535efe42e7bfc9e3877d70f5edb4177ae57a3bef53773e8cb3bc701c724411a44930a5f53469fe7e3b6db241397321af682213de31297dcbdbb0667202ab13c7416ae16211916c9aa1255b6cdb8411114c7fe26d9e3bab3001bc0c91225c9c506ca5a7e094e1a06e553d26ba0652deefe325e89b880206dc373c7e897ced327477bb0255f2e18a727564aef2a2942b29708e1896c8d0cf42f2d57fef5ce06fc26c9cc994cf3caab220cb50f11d2a865fd3369659a1e77a6271227c78dd0ca9a5ece9c0331a3b7419b3c106badb1b837f7b74a704b4f2b12668cc92943c9515b77695847461795046065adde80bdbbdd6e72f8292d7699374c7b542e496b8fc29e62177e99f8af63ef299af63c5880945a07df8a03ff353a7a29977ebe4e15a3659c43fef0a57ec6bad955f0cc92fce14c583727cce93076e001688dd56e28d10bf2eb9ac2412af0bb2340c3b15e85e73f7e51ce4e75b7574af8218d0bf3f27723bc92cf2e5251e9163606f9a7d150cf10e18c77d54fbd1800fe5cfb5b801d00ae253767df826f066a46cec527ae0835fc83825449dad9700c6bc6a20ebf38537549cfc1dc74c21531e689cb30f9befe766a4a4b1c93e99a7e9e274e33961aa24b2eb3f4637f74338a77109ca786f262de51f9c0a0a38c8cec2fbf15b0d676237e6b0825f3e8ddb62dac0078ac944aa758901184378cb51dddc7a25d361f6d6755e52598198d6105ee62c8be1cc75259115b81a60b38f35bd7ff66baa7bf6fee8b4531271f3214a2d4d52f14b77ced3a73e5c01d2fa7a110213cfc46d1bb3f890236e50da5be4a62556212483821fc62bc269fb2db0d68173f2e930e0c61387bc9d44f8178b8614023f50f10972b641cf6ad92a6f64acdf461d08959f1f07dff2e9eb0842094a4c66a677d228fde0fba8e9a7dd9abd4eae0be06b11ffb90e6443b125883ad772723567bf320d71ee3728ab66d79b5a18d5f473073b8483d37167fa61f5851766b23bc045c17619bce39b222d739aa18db5d4c998043b27768a251996f86a8bf34';
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
		$tracking_id=$responseMap['tracking_id'];
		$gateway_order_status=$responseMap['order_status'];
		$amount=$responseMap['amount'];

		$customer_id=$responseMap['merchant_param1'];
		$order_id=$responseMap['merchant_param2'];
		$customer_phone=$responseMap['merchant_param3'];

		if(!empty($order_payment_id) && is_numeric($order_payment_id))
		{
			$obj_model_payment_data=$this->app->load_model("customer_order_payment_data");
			$result_pay=$obj_model_payment_data->execute("SELECT",false,"","id='".$order_payment_id."'");
			if(count($result_pay)>0) {

				$order_payment_id=$result_pay[0]['id'];
				$order_id=$result_pay[0]['order_master_id'];
				$_SESSION['orderPayID']=$order_payment_id;
				$_SESSION['OrderID']=$order_id;

				//make customer cart empty
				if($gateway_order_status=='Success')
				{
					$obj_cart = $this->app->load_model("customer_cart");
					$obj_cart->execute("DELETE", false, "","customer_id='".$result_pay[0]['customer_id']."'");
				}

				//first check payment id status
				if($result_pay[0]['payment_status']=='Success')
				{
					//if payment already success, redirect to payment success
					$this->app->redirect('payment-success');
				}

				//update order payment data entry
				$payment_data=array();
				
				//if payment succss only
				if($gateway_order_status=='Success') { $payment_data['payment_status']='Success'; }
				
				$payment_data['transction_id']=$tracking_id;
				$payment_data['payment_gateway_response']=$rcvdString;
				$payment_data['payment_date']=date('d-m-Y H:i:s');
				$obj_model_payment_data=$this->app->load_model("customer_order_payment_data");
				$obj_model_payment_data->map_fields($payment_data);
				$obj_model_payment_data->execute("UPDATE",false,"","id='".$order_payment_id."'");

				//update order status to confirm
				if($gateway_order_status=='Success' && $order_id>0) 
				{ 
					$payment_order_data=array();
					$payment_order_data['order_status']='Confirmed';
					$obj_model_payment_order_data=$this->app->load_model("customer_order_master");
					$obj_model_payment_order_data->map_fields($payment_order_data);
					$obj_model_payment_order_data->execute("UPDATE",false,"","id='".$order_id."'");

					/*----------Customer Detail------------*/
					$obj_customer = $this->app->load_model("customer");
					$rs_customer=$obj_customer->execute("SELECT", false, "","id='".$result_pay[0]['customer_id']."'");


					/*------------------Strt SMS function------------------*/
					$full_name=$rs_customer[0]['name']." ".$rs_customer[0]['last_name'];
					$Order_ID='#'.$order_id;
					$phone=$rs_customer[0]['phone'];
					$sms_type='confirm_booking';
					$default_string = array("{name}","{order_ID}");
					$new_string   = array($full_name,$Order_ID);                                                               
					$this->app->utility->send_sms_new($phone,$sms_type,$default_string,$new_string);									
					/*------------------End SMS function------------------*/


					/*------------------Strt for mail function------------------*/
					$obj_model_order_cust_detail= $this->app->load_model("customer_order_detail");
					$obj_model_order_cust_detail->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","age","pincode","area_id","area"), array("customer_members_id"=>"id"));
					$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","customer_order_detail.order_master_id='".$order_id."'","","customer_members.id");

					$rs_detail_array=[];
					foreach ($rs_cust_detail as $key => $value)
					{
						$obj_model_order_detail= $this->app->load_model("customer_order_detail");
						$obj_model_order_detail->join_table("item_other_data", "inner", array("item_department_ids"), array("item_id"=>"id"));
						$rs_detail= $obj_model_order_detail->execute("SELECT", false, "","customer_order_detail.order_master_id='".$order_id."' and customer_order_detail.customer_members_id='".$value['customer_members_id']."'");

						$rs_detail_array[]=['cust_detail'=>$value,'order_detail'=>$rs_detail];
					}
					$order_detail='';

					
					for($i=0;$i<count($rs_detail_array);$i++)
					{
						$for_html='';
						if($i==0){ $for_html='For<br/>'; }	

						$items_html='';
						for($j=0; $j < count($rs_detail_array[$i]['order_detail']) ; $j++) 
						{            
							$items=$rs_detail_array[$i]['order_detail'][$j];
							$items_html.='<p><strong>-  '.$items['order_item_name'].'</strong></p>';
						}
						
						$customer_members=$rs_detail_array[$i]['cust_detail']['customer_members_prefix'].' '.$rs_detail_array[$i]['cust_detail']['customer_members_first_name'].' '.$rs_detail_array[$i]['cust_detail']['customer_members_last_name'];

						$order_detail.='<p class="o_mb">'.$for_html.'<strong>'.$customer_members.'</strong></p><br>'.$items_html.'<br><hr><br>';
				    }

					$orderID='#'.$order_id;
					$cust_name=$rs_customer[0]['name']." ".$rs_customer[0]['last_name'];
					$template_name='booking_place_admin';
					$send_data_arary=['name'=>$cust_name,'order_id'=>$orderID,'order_detail'=>$order_detail];
					$subject='New Booking from '.$rs_customer[0]['phone'].' on Website';
					$mail_for='Admin';
					$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
					$this->app->utility->sendMial($data);
					/*-----------------------------end for mail function-----------------------*/

					//redirect to success page
					$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=success&msg1=Payment Received.&msg2=Your booking(".$order_id.") is Confirmed.");
				}
				else {
					$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=failed&msg1=Payment Failed.&msg2=Try again after sometime.");
				}
			}
			else {
				$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=failed&msg1=Payment Failed.&msg2=Try again after sometime.");
			}
		}
		else {
			$this->app->redirect(SERVER_ROOT."/appApi/index.php?view=order_payment_response&payment_status=failed&msg1=Payment Failed.&msg2=Try again after sometime.");
		}
	}
}
?>