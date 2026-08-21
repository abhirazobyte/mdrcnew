<?php
class _premium_health_checkup extends controller {

	function init() {
	}

	function onload() {
		
		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='premium' and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);

		$obj_model_page_info=$this->app->load_model('page_info');
		$page_info=$obj_model_page_info->execute("SELECT",false,"","id=20");
		$this->app->assign("page_info", $page_info[0]);
		
		$department_id='';
		$city_id=$_SESSION['cityID'];
		$city_name=$_SESSION['cityName'];
		$pageType='Popular Package';

		$this->app->assign("department_id",$department_id);
		$this->app->assign("city_id",$city_id);
		$this->app->assign("city_name",$city_name);
		$this->app->assign("data_id",'');
		$this->app->assign("data_name",'');
		$this->app->assign("pageType",$pageType);
	}
}
?>