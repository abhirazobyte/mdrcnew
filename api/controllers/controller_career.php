<?
class _career extends controller{

	function init(){
	}
	function onload(){

	

		$obj_model_job_opening = $this->app->load_model("job_opening");
		$rs_job= $obj_model_job_opening->execute("SELECT", false,"","status='Active'","sort_order ASC");
		$this->app->assign("rs_job",$rs_job);
	}
}
?>