<?

class _my_wallet extends controller{

	function init(){

	}

	function onload(){

		

	$this->app->setTitle($this->app->meta['title']);
	$this->app->setKeywords($this->app->meta['keyword']);
	$this->app->setDescription($this->app->meta['description']);

	$obj_model_wallet_transction= $this->app->load_model("wallet_transction");
	$wallet= $obj_model_wallet_transction->execute("SELECT",false,"SELECT count(id) as total from wallet_transction where customer_id='".$_SESSION['MDRCCustID']."'");
	$this->app->assign("wallet",$wallet[0]['total']);
	
	}
}
?>