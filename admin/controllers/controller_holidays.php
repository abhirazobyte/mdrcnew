<?php
class _holidays extends controller
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
		$deletaDates=[];
		$obj_model_holidays = $this->app->load_model("holidays");
		$holidays= $obj_model_holidays->execute("SELECT", false, "","status='Active'");
		foreach($holidays as $day)
		{
			$dateTimestamp = strtotime($day['name']);
			$todayTimestamp = strtotime(date("d/m/y"));
			if($todayTimestamp>$dateTimestamp)
			{
				array_push($deletaDates,$day['id']);
			} 
		}
		
		if(count($deletaDates)>0){
			$update_field = [];
			$update_field['status'] = "Inactive";
			$obj_model_holidays = $this->app->load_model("holidays");
			$obj_model_holidays->map_fields($update_field);
			$obj_model_holidays->execute("UPDATE", false, "","id in (".implode(',',$deletaDates).")");
		}
		
	}	
		
	function load_data()
	{
	}	
}	
?>