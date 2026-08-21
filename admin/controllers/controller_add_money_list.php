<?php
class _add_money_list extends controller
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
	}	
		
	function load_data()
	{
		
		$obj_model_wallet = $this->app->load_model("wallet_transction");
		$rs_wallet = $obj_model_wallet->execute("SELECT", false, "SELECT SUM(amount) as allcount,wallet_transction.* from wallet_transction where amount_type='+' and payment_status='Success'");
		$this->app->assign("Total_Credit",$rs_wallet[0]['allcount']);
	
		/*$obj_model_wallet=$this->app->load_model("customer");
		$rs_wallet=$obj_model_wallet->execute("SELECT",false,"SELECT SUM(wallet) as TOTAL_WALLET,count(id) as Total_data from customer WHERE wallet>0 and status!='Trash'","");
		$this->app->assign("wallet_total",$rs_wallet[0]['TOTAL_WALLET']);*/
		
		
		$obj_table = $this->app->load_model("wallet_transction");
		$result = $obj_table->execute("SELECT", false, "SELECT SUM(amount) as allcount,wallet_transction.* from wallet_transction where amount_type='-'");
		$this->app->assign("Total_Debit",$result[0]['allcount']);
	}

	
}	
?>