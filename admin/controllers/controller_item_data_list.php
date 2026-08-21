<?php
class _item_data_list extends controller
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
		$data_id=$this->app->getGetVar("data_id");
		
		
			
		$obj_model_dd= $this->app->load_model("item");
		$rs_data = $obj_model_dd->execute("SELECT",false,"","item.id='".$data_id."'");
		if(count($rs_data)<=0)
		{
			$this->app->redirect("index.php?view=item_list");	
			exit;
		}
		
		$this->app->assign("rs_data",$rs_data[0]);
				
		
		
	}	
		
	function load_data()
	{
	}	
}	
?>