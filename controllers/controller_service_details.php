<?

class _service_details extends controller{


	function init()
	{
	}

	function onload()
	{
		$slug=$this->app->getGetVar("slug");
		$parent=$this->app->getGetVar("parent");
		if($slug!='')
		{
			$obj_model_for_doctors = $this->app->load_model("for_doctors_services");
			$records = $obj_model_for_doctors->execute("SELECT",false,"","id!=0 and status='Active' and slug='".$slug."'");
			$this->app->assign("records_doctors",$records[0]);
			$this->app->assign("parent_slug",$parent);

			$this->app->setTitle($records[0]['meta_title']);
			$this->app->setKeywords($records[0]['meta_keywords']);
			$this->app->setDescription($records[0]['meta_description']);

			$obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
			$records_services = $obj_model_for_doctors_services->execute("SELECT",false,"","id!='".$records[0]['id']."' and status='Active' and for_doctors_id='".$records[0]['for_doctors_id']."'","sort_order ASC");
			$this->app->assign("records_services",$records_services);

			if(count($records)<=0)
			{
				$this->app->redirect(SERVER_ROOT);
			}

			//check item for this service
			$sort_cond="item.sort_order ASC";
			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
			$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_for_doctors_services_data", "left", array(), array("id"=>"item_id"));
			$items = $obj_model_all->execute("SELECT",false,"","item_for_doctors_services_data.for_doctors_services_id='".$records[0]['id']."' and item.status='Active'","".$sort_cond." limit 0,12","item.id");
			$this->app->assign("items",$items);
		}
		else
		{
			$this->app->redirect(SERVER_ROOT);
		}
	}
}
?>