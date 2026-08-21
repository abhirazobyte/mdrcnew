<?
class _home_sample_collection extends controller {
	function init() {
	}

	function onload()
	{

		$city = $this->app->getGetVar("city");
		if ($city!='') {
			$citySlugs = array_column($_SESSION['allCity'], 'slug');

			if (!in_array($city, $citySlugs)) {
				$this->app->redirect(SERVER_ROOT . "/404");
			}
		}

		if ($city == '') {
			$this->app->redirect(SERVER_ROOT . "/home-sample-collection/" . $_SESSION['citySlug']);
		}

		$obj_model_table= $this->app->load_model("doctor_category");
		$rs_types= $obj_model_table->execute("SELECT",false,"","status='Active'","sort_order ASC");
		$this->app->assign("rs_types",$rs_types);

		$obj_model_faq = $this->app->load_model("faq");
		$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='faq_page' and  faq_category_id=3 and status='Active'","faq.id desc");
		$this->app->assign("rs_faq_data",$rs_faq_data);

	}
}
?>