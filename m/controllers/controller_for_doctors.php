<?
class _for_doctors extends controller{

	function init()
	{
	}

	function onload()
	{
		$slug=$this->app->getGetVar("slug");
	
		if($slug!='')
		{
			$this->app->assign("category",$slug);

			$obj_model_for_doctors = $this->app->load_model("for_doctors");
			$records = $obj_model_for_doctors->execute("SELECT",false,"","id!=0 and status='Active' and slug='".$slug."'");
			$this->app->assign("records_doctors",$records[0]);

			$obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
			$records_services = $obj_model_for_doctors_services->execute("SELECT",false,"","id!=0 and status='Active' and for_doctors_id='".$records[0]['id']."'","sort_order ASC");
			$this->app->assign("records_services",$records_services);

			$default_string = array("{CITY}");
			$new_string   = array($_SESSION['cityName']);

			$meta_title = str_replace($default_string, $new_string,$records[0]['meta_title']);
			$meta_keyword = str_replace($default_string, $new_string,$records[0]['meta_keywords']);
			$meta_description = str_replace($default_string, $new_string,$records[0]['meta_description']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);

			if(count($records)<=0)
			{
				$this->app->redirect("404");
			}
		}
		else
		{
			$this->app->redirect("404");
		}
	}
}
?>