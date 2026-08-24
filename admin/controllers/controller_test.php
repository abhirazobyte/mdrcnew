<?php
class _test extends controller
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
		echo mdrc_staging_disabled_message();
		exit;
	}

	function load_data()
	{
	}
}
?>
