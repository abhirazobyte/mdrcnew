<?

class _our_doctors extends controller{

	function init(){

	}

	function onload(){

		

	
	
	$obj_model_table= $this->app->load_model("doctor");
	$obj_model_table->join_table("doctor_category", "left", array("name"), array("category_id"=>"id"));
	$rs_doctor= $obj_model_table->execute("SELECT",false,"","doctor.status='Active'","doctor.sort_order ASC");
	$this->app->assign("rs_doctor",$rs_doctor);

	

	}

	

	

	

}

?>