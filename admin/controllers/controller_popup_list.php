<?php
class _popup_list extends controller
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