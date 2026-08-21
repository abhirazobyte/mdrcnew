<?



class _order_details extends controller{



	function init(){



	}



	function onload(){

	$this->app->setTitle($this->app->meta['title']);

	$this->app->setKeywords($this->app->meta['keyword']);

	$this->app->setDescription($this->app->meta['description']);
	
		$id=$this->app->getGetVar('id');
		if($id<=0 || $id=='')
		{
			$this->app->redirect(SERVER_ROOT.'/my-orders');	
		}
	
		$obj_order_master = $this->app->load_model("customer_order_master");
		$rs_data = $obj_order_master->execute("SELECT",false,"","customer_order_master.id='".$id."' and customer_order_master.customer_id='".$_SESSION['MDRCCustID']."'");
		//$rs_data = $obj_order_master->execute("SELECT",false,"","customer_order_master.id='".$id."'");
		$this->app->assign("rs_data",$rs_data);
		
		if(count($rs_data)<=0)
		{
			$this->app->redirect(SERVER_ROOT.'/my-orders');
			exit;	
		}
		
		
		
		$obj_order_table= $this->app->load_model("customer_order_collection_address");
		$obj_order_table->join_table("city", "left", array("name"), array("city_id"=>"id"));	
		$obj_order_table->join_table("state", "left", array("name"), array("state_id"=>"id"));	
		$rs_collection_address = $obj_order_table->execute("SELECT",false,"","customer_order_collection_address.order_master_id='".$id."'");
		$this->app->assign("rs_collection_address",$rs_collection_address);
		
		
		$obj_order_tble= $this->app->load_model("customer_order_lab_address");
		$rs_lab_data = $obj_order_tble->execute("SELECT",false,"","customer_order_lab_address.order_master_id='".$id."'");
		$this->app->assign("rs_lab_data",$rs_lab_data);
		
		
		$obj_order_tble= $this->app->load_model("customer_order_detail");
		$obj_order_tble->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","line1","pincode","area_id","area","age","dob"), array("customer_members_id"=>"id"));
		$rs_order_detail = $obj_order_tble->execute("SELECT",false,"","customer_order_detail.order_master_id='".$id."'","","customer_members.id");
		$this->app->assign("rs_order_detail",$rs_order_detail);
		
		$obj_model_order_detail_all= $this->app->load_model("customer_order_detail");
		$rs_detail= $obj_model_order_detail_all->execute("SELECT", false, "","customer_order_detail.order_master_id='".$id."'");
		
		$this->assign("rs_order_detail_cust",$rs_detail);

		$obj_model_payment_data=$this->app->load_model("customer_order_payment_data");
		$result_pay=$obj_model_payment_data->execute("SELECT",false,"","order_master_id='".$id."' and payment_status='Success'");
		$this->assign("result_pay",$result_pay);
	}

	function statusChange(){
	
		$order_master_id=$this->app->getPostVar('id');
		$order_status=$this->app->getPostVar('status');
		$remark_other=$this->app->getPostVar('remark_other');
		$customer_id=$this->app->getPostVar('customer_id');
		if(!empty($order_master_id))
		{
			$update_field = array();
			$update_field['order_status'] = $order_status;
			$obj_model_customer_order_master = $this->app->load_model("customer_order_master");
			$obj_model_customer_order_master->map_fields($update_field);
			$rs=$obj_model_customer_order_master->execute("UPDATE",false,"","id='".$order_master_id."'");

			if($rs>0)
			{
				$update_field2 = array();
				$update_field2['order_master_id'] = $order_master_id;
				$update_field2['customer_id'] = $customer_id;
				$update_field2['o_status'] = $order_status;
				$update_field2['remark_customer'] = $remark_other;
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


			$cust_name=$_SESSION['MDRCCustFirstName']." ".$_SESSION['MDRCCustLastName'];
			$template_name='booking_cancel_admin';
			$send_data_arary=['name'=>$cust_name,'order_id'=>$order_master_id,'order_detail'=>$order_detail];
			$subject='Order (#'.$order_master_id.') has been Cancelled';
			$mail_for='OrderCancelAdmin';
			$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
			$this->app->utility->sendMial($data);

		}
	}
}
?>