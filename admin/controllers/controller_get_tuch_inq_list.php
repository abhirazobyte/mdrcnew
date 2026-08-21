<?php
class _get_tuch_inq_list extends controller
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
		
	}	
		
	function load_data()
	{
	}	
	
}	
?>