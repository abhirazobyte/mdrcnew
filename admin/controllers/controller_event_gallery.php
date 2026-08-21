<?php
class _event_gallery extends controller
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
		$folder=date('mY');
		if (!file_exists(ABS_PATH.'/uploads/event/'.$folder.'')) {
			mkdir(ABS_PATH.'/uploads/event/'.$folder.'', 0777, true);
		}
		$this->assign("folder",$folder);

		$event_id=$this->app->getGetVar('event_id');

		$obj_model_event= $this->app->load_model("event");
		$event= $obj_model_event->execute("SELECT", false,"","event.id='".$event_id."'");
		$this->assign("event",$event[0]);

		if(count($event)<=0)
		{
			$this->app->redirect("index.php?view=event_list");	
			exit;
		}
	}	
}	
?>