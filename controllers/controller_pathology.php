<?



class _pathology extends controller{



	function init(){



	}



	function onload()
	{
		/* $obj_model_area=$this->app->load_model('area');
		$rs_area=$obj_model_area->execute("SELECT",false,"","");

		for($i=0; $i<count($rs_area); $i++)
		{
			$slug=$this->app->utility->unique_slug("area","add","slug",$rs_area[$i]['name'],"");

			$update_field = array();
			$update_field['slug'] = $slug;

			$obj_model_area=$this->app->load_model('area');
			$obj_model_area->map_fields($update_field);
			$obj_model_area->execute("UPDATE",false,"","id='".$rs_area[$i]['id']."'");
		} */
		


		$city=$this->app->getGetVar("city");
		$desc=$this->app->getGetVar("desc");
		$area=$this->app->getGetVar("area");

		$obj_model_area=$this->app->load_model('area');
		$rs_area=$obj_model_area->execute("SELECT",false,"","status='Active' and city_id='".$_SESSION['cityID']."'","sort_order ASC");
		$this->app->assign("rs_area", $rs_area);

		$obj_model_page_info=$this->app->load_model('page_info');
		$page_info=$obj_model_page_info->execute("SELECT",false,"","id=4");
		$this->app->assign("page_info", $page_info[0]);

		$obj_model_page_description=$this->app->load_model('page_description');
		$page_description=$obj_model_page_description->execute("SELECT",false,"","page_info_id=4 and city_id='".$_SESSION['cityID']."'");
		$this->app->assign("page_description", $page_description[0]);

		$areaName='';
		foreach($rs_area as $areaList){
			if($areaList['slug']==$area){
				$areaName=$areaList['name'];
			}
		}
		$this->app->assign("areaName", $areaName);

		if($area!=''){
			$areaSlugs = array_column($rs_area, 'slug');
			
			if(!in_array($area,$areaSlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}
		
		if($city!=''){
			$citySlugs = array_column($_SESSION['allCity'], 'slug');
			
			if(!in_array($city,$citySlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}

		if($city=='' && $desc=='lab-blood-test-near')
		{
			$this->app->redirect(SERVER_ROOT."/pathology/lab-blood-test-near/".$_SESSION['citySlug']);
		}

		if($desc!='lab-blood-test-near')
		{
			$this->app->redirect(SERVER_ROOT."/404");
		}

		if($area!='')
		{
			$obj_model_meta = $this->app->load_model('page_info');
			$meta = $obj_model_meta->execute("SELECT", false, "","page_name='pathology' and status!='Trash'");
			$cityString=$area.', '.$city;
			$meta_title = str_replace('{CITY}', $cityString,$meta[0]['page_title']);
			$meta_keyword = str_replace('{CITY}', $cityString,$meta[0]['meta_keywords']);
			$meta_description = str_replace('{CITY}', $cityString,$meta[0]['meta_description']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);
		}

		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and banner_image!='' and FIND_IN_SET ('pathology',banner.show_page) and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);

		$department_id=2;

		$obj_model_item_department = $this->app->load_model("item_department");

		$rs_department= $obj_model_item_department->execute("SELECT", false,"","status='Active' and id='".$department_id."'");

		$this->app->assign("rs_department",$rs_department[0]);



		$obj_model_tble = $this->app->load_model("item_diseases");

		$rs_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active' and FIND_IN_SET ('".$department_id."',item_diseases.item_department_ids)","sort_order ASC");

		$this->app->assign("rs_diseases",$rs_diseases);

		

		

		

		$obj_model_tble = $this->app->load_model("item_category");

		$rs_category = $obj_model_tble->execute("SELECT", false,"","status='Active' and FIND_IN_SET ('".$department_id."',item_category.item_department_ids)","sort_order ASC");

		$this->app->assign("rs_category",$rs_category);

		

		

		$obj_model_tble = $this->app->load_model("item_type");

		$rs_type = $obj_model_tble->execute("SELECT", false,"","status='Active'","sort_order ASC");

		$this->app->assign("rs_type",$rs_type);

		

		
		$pageType='Pathology';
		$this->app->assign("department_id",$department_id);

		$this->app->assign("city_id",$_SESSION['cityID']);

		$this->app->assign("city_name",$_SESSION['cityName']);
		$this->app->assign("pageType",$pageType);


		$obj_model_faq = $this->app->load_model("faq");
		$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='item_department' and faq_category_id=2 and status='Active'","faq.id desc");
		$this->app->assign("rs_faq_data",$rs_faq_data);

		

	}
}



?>