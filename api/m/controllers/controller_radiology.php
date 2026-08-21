<?



class _radiology extends controller{



	function init(){



	}



	function onload(){



		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='radiology' and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);



		//$this->app->setTitle($this->app->meta['title']);

		//$this->app->setKeywords($this->app->meta['keyword']);

		//$this->app->setDescription($this->app->meta['description']);



		

		$department_id=1;



		

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

		

		
		$pageType='Radiology';

		$this->app->assign("department_id",$department_id);

		$this->app->assign("city_id",$_SESSION['cityID']);

		$this->app->assign("city_name",$_SESSION['cityName']);
		$this->app->assign("pageType",$pageType);

		
		
		

		

		

		



		

	



	}



	



	



	



}



?>