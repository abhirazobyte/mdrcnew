<?

class _my_family_friends extends controller{

	function init(){

	}

	function onload(){

		

	$this->app->setTitle($this->app->meta['title']);
	$this->app->setKeywords($this->app->meta['keyword']);
	$this->app->setDescription($this->app->meta['description']);
	
	
			$obj_customer_address=$this->app->load_model('customer_members');
			$obj_customer_address->join_table("city", "left", array(), array("city_id"=>"id"));
			$rs_members=$obj_customer_address->execute("SELECT",false,"","customer_id=".$_SESSION['MDRCCustID']."","customer_members.id DESC");
			$this->app->assign("rs_members", $rs_members);

	

	}

	

	

	

}

?>