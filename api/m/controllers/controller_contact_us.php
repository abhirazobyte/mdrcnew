<?

class _contact_us extends controller{

	function init(){

	}

	function onload(){

		

		
		
		$obj_model_table= $this->app->load_model("branch");
		$rs_branch= $obj_model_table->execute("SELECT",false,"","status='Active'","sort_order ASC");
		$this->app->assign("rs_branch",$rs_branch);

	

	}

	

	

	

}

?>