<?

class _covid_19 extends controller{

	function init(){

	}

	function onload(){

		

	
	$obj_model_table= $this->app->load_model("doctor");
	$rs_doctor= $obj_model_table->execute("SELECT",false,"","status='Active' and display_about='Active'","sort_order ASC");
	$this->app->assign("rs_doctor",$rs_doctor);
	
	
	$obj_model_table= $this->app->load_model("doctor_category");
	$rs_types= $obj_model_table->execute("SELECT",false,"","status='Active'","sort_order ASC");
	$this->app->assign("rs_types",$rs_types);
	
	
	
	
	
	
	

	

	}

	

	

	

}

?>