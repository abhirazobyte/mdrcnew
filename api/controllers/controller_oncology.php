<?

class _oncology extends controller{

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
		
		$obj_model_testimonial = $this->app->load_model("testimonial");
		$rs_testimonial = $obj_model_testimonial->execute("SELECT", false,"","status='Active'","sort_id ASC");
		


		$sort_cond="item.sort_order ASC";
		$city_cond="";
		if($city_id!='')
		{
			$city_cond=" and FIND_IN_SET ('".$city_id."',item.city_ids) and item_price.city_id='".$city_id."'";
		}
		$page_cond=" and FIND_IN_SET ('oncology',item_other_data.pagewise_test)";
		
		$master_con=$city_cond.$page_cond;

		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
		$items = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.status='Active' ".$master_con."","".$sort_cond." limit 0,20","");

		$this->app->assign("rs_testimonial",$rs_testimonial);
		$this->app->assign("items",$items);
		$this->app->assign("department_id",$department_id);
		$this->app->assign("city_id",$city_id);
		$this->app->assign("city_name",$city_name);
		
		
		
		
		

		
	

	}

	

	

	

}

?>