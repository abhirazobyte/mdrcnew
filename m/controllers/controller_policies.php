<?
class _policies extends controller {
	function init() {
	}

	function onload() {
		$obj_model_table= $this->app->load_model("ipo_pdfs");
		$rs_pdf= $obj_model_table->execute("SELECT",false,"","status='Active' and page_type='Policies'","sort_order ASC");
		$this->app->assign("rs_pdf",$rs_pdf);
	}
}
?>