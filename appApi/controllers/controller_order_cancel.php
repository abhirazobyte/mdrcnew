<?
class _order_cancel extends controller
{
	function init()
	{
	}
	
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$remark=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('remark'));
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);

		$orderID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('orderID'));
		$customer_id=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$customer_id=$this->app->utility->decrypt($customer_id);

		$paymentID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('paymentID'));
		$paymentID=$paymentID!=''?$this->app->utility->decrypt($paymentID):"";

		if($userID!='' && $orderID!='')
		{
			$order_master_id = str_replace('#','',$orderID);

			$update_field = array();
			$update_field['order_status'] = 'Canceled';
			$obj_model_customer_order_master = $this->app->load_model("customer_order_master");
			$obj_model_customer_order_master->map_fields($update_field);
			$rs=$obj_model_customer_order_master->execute("UPDATE",false,"","id='".$order_master_id."'");

			if($rs>0)
			{
				$update_field2 = array();
				$update_field2['order_master_id'] = $order_master_id;
				$update_field2['customer_id'] = $userID;
				$update_field2['o_status'] = 'Canceled';
				$update_field2['remark_customer'] = $remark;
				$update_field2['entry_date'] = date('d-m-Y');
				$update_field2['entry_date_time'] = date('d-m-Y H:i:s');
				$update_field2['entry_from'] = 'Admin';
				$update_field2['ip'] =$_SERVER['REMOTE_ADDR'];
				$obj_model_status_history = $this->app->load_model("customer_order_status_history");
				$obj_model_status_history->map_fields($update_field2);
				$obj_model_status_history->execute("INSERT",false,"","id='".$order_master_id."'");
				
			}

			$obj_model_order_cust_detail= $this->app->load_model("customer_order_detail");
			$obj_model_order_cust_detail->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","age","pincode","area_id","area"), array("customer_members_id"=>"id"));
			$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","customer_order_detail.order_master_id='".$order_master_id."'","","customer_members.id");

			$rs_detail_array=[];
			foreach ($rs_cust_detail as $key => $value)
			{
				$obj_model_order_detail= $this->app->load_model("customer_order_detail");
				$obj_model_order_detail->join_table("item_other_data", "inner", array("item_department_ids"), array("item_id"=>"id"));
				$rs_detail= $obj_model_order_detail->execute("SELECT", false, "","customer_order_detail.order_master_id='".$order_master_id."' and customer_order_detail.customer_members_id='".$value['customer_members_id']."'");

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

			$obj_customer= $this->app->load_model("customer");
			$rs_cust= $obj_customer->execute("SELECT", false, "","customer.id='".$userID."'");

			$cust_name=$rs_cust[0]['name'].' '.$rs_cust[0]['last_name'];
			$template_name='booking_cancel_admin';
			$send_data_arary=['name'=>$cust_name,'order_id'=>$order_master_id,'order_detail'=>$order_detail];
			$subject='Order (#'.$order_master_id.') has been Cancelled';
			$mail_for='Admin';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$this->app->utility->sendMial($data);

			$message=array("message"=>'Order Cancelled.',"msgCode"=>"1");
		}
		else
		{
			$message=array("message"=>'Try Again.',"msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>