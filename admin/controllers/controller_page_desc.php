<?php
class _page_desc extends controller
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
		$page_info_id = $this->app->getGetVar('page_info_id');
		$this->app->assign("pageInfoId",$page_info_id);

		$obj_brand = $this->app->load_model("page_info");
		$result = $obj_brand->execute("SELECT", false, "", "id='".$page_info_id."'");
		$page_name = ucwords(str_replace('_', ' ', $result[0]['page_name']));
		$this->app->assign("page_name",$page_name);
	}
		
	function load_data()
	{
	}	
}	
?>