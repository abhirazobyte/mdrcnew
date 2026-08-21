<?

class _imaging_test_information extends controller{

	function init(){

	}

	function onload(){

		

			
		$department_id=1;

		$city_id=1;
		$city_name='Gurgaon';
		
		$_SESSION['cityID']=$city_id;
		$_SESSION['cityName']=$city_name;

		$obj_model_tble = $this->app->load_model("item_diseases");
		$rs_diseases = $obj_model_tble->execute("SELECT", false,"","status='Active' and FIND_IN_SET ('".$department_id."',item_diseases.item_department_ids)","sort_order ASC");
		$this->app->assign("rs_diseases",$rs_diseases);
		
		
		
		$obj_model_tble = $this->app->load_model("item_category");
		$rs_category = $obj_model_tble->execute("SELECT", false,"","status='Active' and FIND_IN_SET ('".$department_id."',item_category.item_department_ids)","sort_order ASC");
		$this->app->assign("rs_category",$rs_category);
		
		
		$obj_model_tble = $this->app->load_model("item_type");
		$rs_type = $obj_model_tble->execute("SELECT", false,"","status='Active'","sort_order ASC");
		$this->app->assign("rs_type",$rs_type);
		
		
		$this->app->assign("department_id",$department_id);
		$this->app->assign("city_id",$city_id);
		$this->app->assign("city_name",$city_name);
		
		
		
		
		

		
	

	}

	

	

	

}

?>