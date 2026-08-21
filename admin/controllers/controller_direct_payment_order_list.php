<?php
class _direct_payment_order_list extends controller
{
	function init()
	{
		if($this->app->getCurrentAction()=="")
		{
			$this->load_data();
		}
	}

	function onload()
	{
		$master_cond=" and id!=0";
		$obj_model_order_counter = $this->app->load_model("direct_payment_order");
		$rs_counter1 = $obj_model_order_counter->execute("SELECT", false, "SELECT sum(case when (order_pay_status = 'Confirm' ".$master_cond.") then 1 else 0 end) ConfirmCount, sum(case when (order_pay_status = 'Cancel'  ".$master_cond.") then 1 else 0 end) CancelCount FROM direct_payment_order");

		$ConfirmCount=$rs_counter1[0]['ConfirmCount'];
		$CancelCount=$rs_counter1[0]['CancelCount'];

		if($ConfirmCount==NULL || $ConfirmCount=='')
		{
			$ConfirmCount=0;
		}
		if($CancelCount==NULL || $CancelCount=='')
		{
			$CancelCount=0;
		}

		$this->app->assign("ConfirmCount",$ConfirmCount);
		$this->app->assign("CancelCount",$CancelCount);
	}	
		
	function load_data()
	{
	}	
}	
?>