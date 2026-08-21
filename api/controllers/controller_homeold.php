<?
class _home extends controller{

	function init()
	{
	}

	function onload()
	{
		if("https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]=='https://www.mdrcindia.com/index.php/about-us' || "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]=='https://www.mdrcindia.com/index.php/about-us/')
		{
			$this->app->redirect(SERVER_ROOT."/404");
		}
	
		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='home' and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);
		
		
		$obj_model_item_diseases=$this->app->load_model('item_diseases');
		$rs_item_diseases=$obj_model_item_diseases->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC");
		$this->app->assign("rs_item_diseases", $rs_item_diseases);
		
		
		$obj_model_item_home_category=$this->app->load_model('item_category');
		$rs_item_home_category=$obj_model_item_home_category->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC Limit 0,5");
		$this->app->assign("rs_item_home_category", $rs_item_home_category);
		
		$obj_model_item_home_category11=$this->app->load_model('item_category');
		$rs_item_banner_category=$obj_model_item_home_category11->execute("SELECT",false,"","status='Active' and show_in_banner='Yes' and FIND_IN_SET (1,item_category.item_department_ids)","sort_order ASC");
		$this->app->assign("rs_item_banner_category", $rs_item_banner_category);

		$obj_model_for_doctors=$this->app->load_model('for_doctors');
		$rs_for_doctors=$obj_model_for_doctors->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC");

		$rs_services_array=[];
		for ($i=0; $i < count($rs_for_doctors); $i++)
		{ 
			$obj_model_services=$this->app->load_model('for_doctors_services');
			$rs_services=$obj_model_services->execute("SELECT",false,"","status='Active' and for_doctors_id='".$rs_for_doctors[$i]['id']."'","sort_order ASC Limit 0,6");
			if(count($rs_services)>0)
			{
				$services_data=['deatail'=>$rs_for_doctors[$i],"services"=>$rs_services];
				$rs_services_array[]=$services_data;
			}
		}

		$this->app->assign("rs_services", $rs_services_array);

		//blog
		$obj_model_blog=$this->app->load_model('blog');
		$obj_model_blog->join_table("blog_category", "left", array("name","slug"), array("category_id"=>"id"));
		$rs_blog = $obj_model_blog->execute("SELECT",false,"","blog.status='Active' and set_at_home='Yes'","blog.id");
		$this->app->assign("rs_blog", $rs_blog);


	}
}
?>