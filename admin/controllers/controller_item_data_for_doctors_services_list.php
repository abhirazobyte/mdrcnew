<?php
class _item_data_for_doctors_services_list extends controller
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
		$service_id=$this->app->getGetVar("service_id");
		
		
			
		$obj_model_dd= $this->app->load_model("for_doctors_services");
		$rs_data = $obj_model_dd->execute("SELECT",false,"","id='".$service_id."'");
		if(count($rs_data)<=0)
		{
			$this->app->redirect("index.php?view=for_doctors_services_list");	
			exit;
		}
		
		$this->app->assign("rs_data",$rs_data[0]);
				
		
		
	}	
		
	function load_data()
	{
	}	
}	
?>