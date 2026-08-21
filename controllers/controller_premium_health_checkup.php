<?php
class _premium_health_checkup extends controller {

	function init() {
	}

	function onload() {

		$obj_model_faq = $this->app->load_model("faq");
		$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='faq_page' and faq_category_id=4 and status='Active'","faq.sort_id asc");
		$this->app->assign("rs_faq_data",$rs_faq_data);

		$city=$this->app->getGetVar("city");
		if($city!=''){
			$citySlugs = array_column($_SESSION['allCity'], 'slug');
			
			if(!in_array($city,$citySlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}

		if($city=='')
		{
			$this->app->redirect(SERVER_ROOT."/premium-health-checkup/".$_SESSION['citySlug']);
		}
		
		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and banner_image!='' and FIND_IN_SET ('premium',banner.show_page) and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);

		$obj_model_page_info=$this->app->load_model('page_info');
		$page_info=$obj_model_page_info->execute("SELECT",false,"","id=20");
		$this->app->assign("page_info", $page_info[0]);

		$obj_model_page_description=$this->app->load_model('page_description');
		$page_description=$obj_model_page_description->execute("SELECT",false,"","page_info_id=20 and city_id='".$_SESSION['cityID']."'");
		$this->app->assign("page_description", $page_description[0]);
		
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