<?php
class _for_doctors_services_list extends controller
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
		$for_doctors_id=$this->app->getGetVar("for_doctors_id");


		$obj_model_for_doctors_services = $this->app->load_model("for_doctors");
		$rs_job_opening = $obj_model_for_doctors_services->execute("SELECT", false, "","id=".$for_doctors_id."");

		if(count($rs_job_opening)>0)
		{
			$this->assign("job_opening_title",$rs_job_opening[0]['title']);
		}
		else
		{
			$this->app->redirect("index.php?view=for_doctors_list");	
		}

	}	
		
	function load_data()
	{
	}	
}	
?>