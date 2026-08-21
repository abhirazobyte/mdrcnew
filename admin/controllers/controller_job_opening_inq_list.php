<?php
class _job_opening_inq_list extends controller
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
		$job_opening_id=$this->app->getGetVar("job_opening_id");


		$obj_model_job_opening = $this->app->load_model("job_opening");
		$rs_job_opening = $obj_model_job_opening->execute("SELECT", false, "","id=".$job_opening_id."");

		if(count($rs_job_opening)>0)
		{
			$this->assign("job_opening_title",$rs_job_opening[0]['title']);
		}
		else
		{
			$this->app->redirect("index.php?view=job_opening_list");	
		}
	}	
		
	function load_data()
	{
	}	
	
}	
?>