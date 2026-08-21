<?
class _home extends controller
{
	function init() {

	}

	function onload() {
		$obj_model_banner=$this->app->load_model('banner');
		$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and show_page='home' and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
		$this->app->assign("rs_banner", $rs_banner);

		$obj_model_item_diseases=$this->app->load_model('item_diseases');
		$rs_item_diseases=$obj_model_item_diseases->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC");
		$this->app->assign("rs_item_diseases", $rs_item_diseases);

		$obj_model_item_home_category=$this->app->load_model('item_category');
		$rs_item_home_category=$obj_model_item_home_category->execute("SELECT",false,"","status='Active' and set_at_home='Yes'","sort_order ASC Limit 0,5");
		$this->app->assign("rs_item_home_category", $rs_item_home_category);

		$sort_cond="item.sort_order ASC";
		$city_cond=" and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and item_price.city_id='".$_SESSION['cityID']."'";
		$master_con=$city_cond;
		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
		$records = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.status='Active' and  item.set_at_home='Yes'   ".$master_con."","".$sort_cond." limit 0,10","");
		$this->app->assign("homeItems", $records);
	}	
}
?>