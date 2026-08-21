<?php
class _faq_list extends controller
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
		$faq_type=$this->app->getGetVar('faq_type');
		$faq_type_id=$this->app->getGetVar('faq_type_id');
		// echo $faq_type;
		// exit;
		if($faq_type!='')
		{
			$this->assign("faqType",$faq_type);
			$this->assign("faqTypeId",$faq_type_id);
		}
		
	}	
		
	function load_data()
	{
	}	
}	
?>