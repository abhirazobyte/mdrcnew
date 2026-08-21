<?
class _diseases extends controller {
	function init() {
	}

	function onload() {

		$city=$this->app->getGetVar("city");
		$searchKeword=$this->app->getGetVar("slug");
		$area=$this->app->getGetVar("area");

		$obj_model_area=$this->app->load_model('area');
		$rs_area=$obj_model_area->execute("SELECT",false,"","status='Active' and city_id='".$_SESSION['cityID']."'","sort_order ASC");
		$this->app->assign("rs_area", $rs_area);

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
		//$searchKeword=$explodeData[$total_datas-1];
		//$citySlug=$explodeData[$total_datas-2];		
		

			$obj_model_banner=$this->app->load_model('banner');
			$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and FIND_IN_SET ('diseases',banner.show_page) and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
			$this->app->assign("rs_banner", $rs_banner); 
			
		
			$obj_model_tble = $this->app->load_model("item_diseases");
			$rs_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active' and slug='".$searchKeword."'","sort_order ASC");
			if(count($rs_diseases)<=0)
			{
				$this->app->redirect(SERVER_ROOT."/404");
				exit;
			}

			if($this->app->getGetVar("slug")=='' && count($rs_diseases)>0)
			{
				$this->app->redirect(SERVER_ROOT."/diseases/".$_SESSION['citySlug']."/".$searchKeword);
			}

			$this->app->assign("rs_diseases",$rs_diseases);
			$this->app->assign("diseasesInfo",str_replace("{CITY}", $_SESSION['cityName'],$rs_diseases[0]));

			$obj_model_item_diseases_banner=$this->app->load_model('item_diseases_banner');
			$item_diseases_banner=$obj_model_item_diseases_banner->execute("SELECT",false,"","status='Active' and (FIND_IN_SET ('".$_SESSION['cityID']."',item_diseases_banner.city_ids) or city_ids='') and (FIND_IN_SET ('".$rs_cat[0]['id']."',item_diseases_banner.item_diseases_ids) or item_diseases_ids='')","sort_id ASC");
			$this->app->assign("item_diseases_banner", $item_diseases_banner);
			
			$default_string = array("{CITY}");
			$new_string   = array($_SESSION['cityName']);

			$meta_title = str_replace($default_string, $new_string,$rs_diseases[0]['meta_title']);
			$meta_keyword = str_replace($default_string, $new_string,$rs_diseases[0]['meta_keywords']);
			$meta_description = str_replace($default_string, $new_string,$rs_diseases[0]['meta_description']);
			$meta_schema = str_replace($default_string, $_SESSION['citySlug'],$rs_diseases[0]['meta_schema']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);
			$this->app->setSchema($meta_schema);

			$department_id='';
			$city_id=$_SESSION['cityID'];
			$city_name=$_SESSION['cityName'];
			$pageType='Diseases';
	
	
			$this->app->assign("department_id",$department_id);
			$this->app->assign("city_id",$city_id);
			$this->app->assign("city_name",$city_name);
			$this->app->assign("data_id",$rs_diseases[0]['id']);
			$this->app->assign("data_name",$rs_diseases[0]['name']);
			$this->app->assign("pageType",$pageType);

			$obj_model_tble = $this->app->load_model("item_diseases");
			$all_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active'","sort_order ASC");
			$this->app->assign("all_diseases",$all_diseases);

			$obj_model_faq = $this->app->load_model("faq");
			$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='item_diseases' and  faq_category_id='".$rs_diseases[0]['id']."' and status='Active'","faq.id desc");
			$this->app->assign("rs_faq_data",$rs_faq_data);
	}
}
?>