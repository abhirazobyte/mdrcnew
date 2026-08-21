<?
class _home extends controller
{

	function init()
	{
	}

	function onload()
	{

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='home' and status!='Trash'");
		$this->app->assign("meta_data", $meta_data[0]);

		$city=$this->app->getGetVar("city");

		if($city!=''){
			
			$citySlugs = array_column($_SESSION['allCity'], 'slug');
			
			if(!in_array($city,$citySlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}

		$actual_link=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
		if (strpos($actual_link, 'labs') !== false && $city=='')
		{
			$this->app->redirect(SERVER_ROOT."/labs/".$_SESSION['citySlug']);
		}

		//set title
		$description='';
		if(strpos($actual_link, 'labs')!== false)
		{
			$new_string=$_SESSION['cityName'];
			//echo $new_string;exit;
			$obj_model_meta = $this->app->load_model('page_info');
			$meta = $obj_model_meta->execute("SELECT", false, "","page_name='home-labs' and status!='Trash'");
			$meta_title = str_replace('{CITY}', $new_string,$meta[0]['page_title']);
			$meta_keyword = str_replace('{CITY}', $new_string,$meta[0]['meta_keywords']);
			$meta_description = str_replace('{CITY}', $new_string,$meta[0]['meta_description']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);
			$description=$meta[0]['description'];
			
		}
		//set title end
		$this->app->assign("description",$description);


		$obj_model_banner = $this->app->load_model('banner');
		$rs_banner = $obj_model_banner->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('home',banner.show_page) and banner_image!='' and (FIND_IN_SET ('" . $_SESSION['cityID'] . "',banner.city_ids) or city_ids='')", "sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);


		$obj_model_item_diseases = $this->app->load_model('item_diseases');
		$rs_item_diseases = $obj_model_item_diseases->execute("SELECT", false, "", "status='Active' and set_at_home='Yes'", "sort_order ASC");
		$this->app->assign("rs_item_diseases", $rs_item_diseases);


		$obj_model_item_home_category = $this->app->load_model('item_category');
		$rs_item_home_category = $obj_model_item_home_category->execute("SELECT", false, "", "status='Active' and set_at_home='Yes'", "sort_order ASC Limit 0,5");
		$this->app->assign("rs_item_home_category", $rs_item_home_category);

		$obj_model_item_home_category11 = $this->app->load_model('item_category');
		$rs_item_banner_category = $obj_model_item_home_category11->execute("SELECT", false, "", "status='Active' and show_in_banner='Yes' and FIND_IN_SET (1,item_category.item_department_ids)", "sort_order ASC");
		$this->app->assign("rs_item_banner_category", $rs_item_banner_category);

		$obj_model_for_doctors = $this->app->load_model('for_doctors');
		$rs_for_doctors = $obj_model_for_doctors->execute("SELECT", false, "", "status='Active' and set_at_home='Yes'", "sort_order ASC");

		$rs_services_array = [];
		for ($i = 0; $i < count($rs_for_doctors); $i++) {
			$obj_model_services = $this->app->load_model('for_doctors_services');
			$rs_services = $obj_model_services->execute("SELECT", false, "", "status='Active' and for_doctors_id='" . $rs_for_doctors[$i]['id'] . "'", "sort_order ASC Limit 0,6");
			if (count($rs_services) > 0) {
				$services_data = ['deatail' => $rs_for_doctors[$i], "services" => $rs_services];
				$rs_services_array[] = $services_data;
			}
		}

		$this->app->assign("rs_services", $rs_services_array);

		//blog
		$obj_model_blog = $this->app->load_model('blog');
		$obj_model_blog->join_table("blog_category", "left", array("name", "slug"), array("category_id" => "id"));
		$rs_blog = $obj_model_blog->execute("SELECT", false, "", "blog.status='Active' and set_at_home='Yes'", "blog.id");
		$this->app->assign("rs_blog", $rs_blog);

		$department_id=1;
		
		$obj_model_tble = $this->app->load_model("item_category");
		$rs_category = $obj_model_tble->execute("SELECT", false,"","status='Active' and set_at_home='Yes' and FIND_IN_SET ('".$department_id."',item_category.item_department_ids)","sort_order ASC");
		$this->app->assign("rs_category",$rs_category);

		$obj_model_faq = $this->app->load_model("faq");
		$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='faq_page' and  faq_category_id=3 and status='Active'","faq.id desc");
		$this->app->assign("rs_faq_data",$rs_faq_data);

		$obj_model_gallery = $this->app->load_model("gallery");
		$rs_gallery_data = $obj_model_gallery->execute("SELECT",false,"","set_at_home='Active' and status='Active'","gallery.id desc");
		$this->app->assign("rs_gallery_data",$rs_gallery_data);


	}
}
?>