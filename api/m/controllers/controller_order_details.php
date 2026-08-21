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
	//and customer_order_master.customer_id='".$_SESSION['MDRCCustID']."'
		$obj_order_master = $this->app->load_model("customer_order_master");
		$rs_data = $obj_order_master->execute("SELECT",false,"","customer_order_master.id='".$id."' ");
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

		$obj_model_order_detail_all= $this->app->load_model("customer_order_payment_data");
		$rs_payment= $obj_model_order_detail_all->execute("SELECT", false, "","customer_order_payment_data.order_master_id='".$id."' AND customer_order_payment_data.payment_status='Success'");
		$this->app->assign("rs_payment",$rs_payment);
		
		$this->assign("rs_order_detail_cust",$rs_detail);
	}
}
?>