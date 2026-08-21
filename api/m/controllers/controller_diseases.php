<?
class _diseases extends controller {
	function init() {
	}

	function onload() {
		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='diseases' and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner); 
		
		
			$REQUEST_URI=$_SERVER['REQUEST_URI'];
			$REQUEST_URI=str_replace(".html","",$REQUEST_URI);
			$explodeData=explode('/',$REQUEST_URI);
			
			$total_datas=count($explodeData);					
			$searchKeword=$explodeData[$total_datas-1];
			$citySlug=$explodeData[$total_datas-2];		
			
			$checkCity=$this->app->utility->checkCityData($citySlug);
			if($checkCity=='')
			{
				$this->app->redirect(SERVER_ROOT);
				exit;
			}
			
			$obj_model_tble = $this->app->load_model("item_diseases");
			$rs_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active' and slug='".$searchKeword."'","sort_order ASC");
			if(count($rs_diseases)<=0)
			{
				$this->app->redirect(SERVER_ROOT);
				exit;
			}

			$this->app->assign("rs_diseases",$rs_diseases);

			$obj_model_item_diseases_banner=$this->app->load_model('item_diseases_banner');
			$item_diseases_banner=$obj_model_item_diseases_banner->execute("SELECT",false,"","status='Active' and (FIND_IN_SET ('".$_SESSION['cityID']."',item_diseases_banner.city_ids) or city_ids='') and (FIND_IN_SET ('".$rs_cat[0]['id']."',item_diseases_banner.item_diseases_ids) or item_diseases_ids='')","sort_id ASC");
			$this->app->assign("item_diseases_banner", $item_diseases_banner);
			
			$default_string = array("{CITY}");
			$new_string   = array($_SESSION['cityName']);

			$meta_title = str_replace($default_string, $new_string,$rs_diseases[0]['meta_title']);
			$meta_keyword = str_replace($default_string, $new_string,$rs_diseases[0]['meta_keywords']);
			$meta_description = str_replace($default_string, $new_string,$rs_diseases[0]['meta_description']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);


	

		

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
			$rs_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active'","sort_order ASC");
			$this->app->assign("rs_diseases",$rs_diseases);

		

		

		

		

		



		

	



	}



	



	



	



}



?>