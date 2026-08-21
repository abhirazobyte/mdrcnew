<?php
class _user_cart_list extends controller
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
		$obj_model_city= $this->app->load_model("city");
		$rs_city = $obj_model_city->execute("SELECT",false,"","");
		$records_city = array();
		$records_city[''] = 'All';
		for($i=0;$i<count($rs_city);$i++)
		{
			$records_city[$rs_city[$i]['id']] = $rs_city[$i]['name'];
		}
		$this->assign("records_city",$records_city);
	}	
		
	function load_data()
	{
	}	
}	
?>