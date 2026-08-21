<?
class _order_payment_process extends controller
{
	function init()
	{
	}
	
	function onload()
	{

		$status=$this->app->getPostVar("razorpay_status");
		$payment_signature=$this->app->getPostVar("payment_signature");
		$razor_order_id=$this->app->getPostVar("razor_order_id");
		$payment_trans_id=$this->app->getPostVar("payment_trans_id");
		$order_payment_id=$this->app->getPostVar("order_payment_id");

		$encResponse=$this->app->getPostVar('encResp');
		if(!empty($payment_signature) && !empty($status) && !empty($razor_order_id) && !empty($payment_trans_id) && !empty($order_payment_id))
		{
			$order_payment_id=$order_payment_id;
			$tracking_id=$payment_trans_id;
			$gateway_order_status=$status=='success' ? 'Success' : 'Fail';
			$rcvdString="";
		}
		else 
		{
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
		}

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