<?
class _category extends controller {
	function init() {
	}

	function onload() {

		$city=$this->app->getGetVar("city");
		$searchKeword=$this->app->getGetVar("slug");
		$area=$this->app->getGetVar("area");
		

		$obj_model_area=$this->app->load_model('area');
		$rs_area=$obj_model_area->execute("SELECT",false,"","status='Active' and city_id='".$_SESSION['cityID']."'","sort_order ASC");
		$this->app->assign("rs_area", $rs_area);

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

		if($this->app->getGetVar("city")!='' && $this->app->getGetVar("slug")==''){
			$searchKeword=$city;
		}

		if($city!='' && $this->app->getGetVar("slug")!=''){
			
			$citySlugs = array_column($_SESSION['allCity'], 'slug');
			
			if(!in_array($city,$citySlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}
		$this->app->assign("slug", $searchKeword);

		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and (FIND_IN_SET ('category',banner.show_page) or FIND_IN_SET('".$searchKeword."', banner.show_page)) and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);
		
					
			$obj_model_tble = $this->app->load_model("item_category");
			$rs_cat = $obj_model_tble->execute("SELECT", false,"","status='Active' and slug='".$searchKeword."'","sort_order ASC");
			if(count($rs_cat)<=0)
			{
				$this->app->redirect(SERVER_ROOT."/404");
				exit;
			}
			if($this->app->getGetVar("slug")=='' && count($rs_cat)>0)
			{
				$this->app->redirect(SERVER_ROOT."/category/".$_SESSION['citySlug']."/".$searchKeword);
			}
			$this->app->assign("rs_cat",$rs_cat);

			$obj_model_item_category_banner=$this->app->load_model('item_category_banner');
			$item_category_banner=$obj_model_item_category_banner->execute("SELECT",false,"","status='Active' and (FIND_IN_SET ('".$_SESSION['cityID']."',item_category_banner.city_ids) or city_ids='') and (FIND_IN_SET ('".$rs_cat[0]['id']."',item_category_banner.item_category_ids) or item_category_ids='')","sort_id ASC");
			$this->app->assign("item_category_banner", $item_category_banner);

			$default_string = array("{CITY}");
			$new_string   = array($_SESSION['cityName']);

			$meta_title = str_replace($default_string, $new_string,$rs_cat[0]['meta_title']);
			$meta_keyword = str_replace($default_string, $new_string,$rs_cat[0]['meta_keywords']);
			$meta_description = str_replace($default_string, $new_string,$rs_cat[0]['meta_description']);
			$meta_schema = str_replace($default_string, $_SESSION['citySlug'],$rs_cat[0]['meta_schema']); // change by rutvik 13-11-25 
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);
			$this->app->setSchema($meta_schema);

			$department_id='';
			$city_id=$_SESSION['cityID'];
			$city_name=$_SESSION['cityName'];
			$pageType='Category';
	
	
			$this->app->assign("department_id",$department_id);
			$this->app->assign("city_id",$city_id);
			$this->app->assign("city_name",$city_name);
			$this->app->assign("data_id",$rs_cat[0]['id']);
			$this->app->assign("data_name",$rs_cat[0]['name']);
			$this->app->assign("pageType",$pageType);


			$obj_model_tble = $this->app->load_model("item_category");
			$rs_category = $obj_model_tble->execute("SELECT", false,"","status='Active'","sort_order ASC");
			$this->app->assign("rs_category",$rs_category);

		

			$obj_model_faq = $this->app->load_model("faq");
			$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='item_category' and status='Active' and faq_category_id='".$rs_cat[0]['id']."'","faq.id desc");
			$this->app->assign("rs_faq_data",$rs_faq_data);

		

		

		



		

	



	}



	



	



	



}



?>