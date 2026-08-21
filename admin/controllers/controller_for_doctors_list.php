<?php
class _for_doctors_list extends controller
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