<?

class _my_profile extends controller{

	function init(){

	}

	function onload(){

		

	$this->app->setTitle($this->app->meta['title']);
	$this->app->setKeywords($this->app->meta['keyword']);
	$this->app->setDescription($this->app->meta['description']);
	
	
			$obj_customer_address=$this->app->load_model('customer');
			$rs_customer=$obj_customer_address->execute("SELECT",false,"","id=".$_SESSION['MDRCCustID']."","id DESC");
			$this->app->assign("rs_customer", $rs_customer[0]);

	

	}

	

	

	

}

?>