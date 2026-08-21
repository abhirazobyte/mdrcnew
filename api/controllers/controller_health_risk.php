<?
class _health_risk extends controller {
	function init() {
	}

	function onload() {
		$city=$this->app->getGetVar("city");
		if($city!=''){
			$citySlugs = array_column($_SESSION['allCity'], 'slug');
			
			if(!in_array($city,$citySlugs)){
				$this->app->redirect(SERVER_ROOT."/404");
			}
		}

		if($city=='')
		{
			$this->app->redirect(SERVER_ROOT."/health-risk/".$_SESSION['citySlug']);
		}


		$obj_model_table= $this->app->load_model("doctor_category");
		$rs_types= $obj_model_table->execute("SELECT",false,"","status='Active'","sort_order ASC");
		$this->app->assign("rs_types",$rs_types);
	}
}
?>