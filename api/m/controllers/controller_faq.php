<?
class _faq extends controller {
	function init() {
	}

	function onload() { 
		//https://www.mdrcindia.com/faq/frequently-asked-questions-pathology
		//https://www.mdrcindia.com/faq/frequently-asked-questions-imaging

		$slug=$this->app->getGetVar("slug");
		if($slug=='frequently-asked-questions-imaging') {
			$catID=1;
			$this->app->assign("heading",'Frequently asked questions imaging');
		} else if($slug=='frequently-asked-questions-pathology') {
			$catID=2;
			$this->app->assign("heading",'Frequently asked questions pathology');
		}
		else {
			$this->app->redirect(SERVER_ROOT);	
			exit;
		}
		$this->app->setTitle($this->app->meta['title']);
		$this->app->setKeywords($this->app->meta['keyword']);
		$this->app->setDescription($this->app->meta['description']);

		$obj_model_faq= $this->app->load_model("faq");
		$faq = $obj_model_faq->execute("SELECT",false,"","faq_category_id='".$catID."' and status='Active'","sort_id ASC","");
		$this->app->assign("faq",$faq);
	}
}
?>