<?
class _tdm extends controller {
	function init() {
	}

	function onload() 
	{
		$sort_cond="item.sort_order ASC";
		$city_cond=" and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and item_price.city_id='".$_SESSION['cityID']."'";
		$page_cond=" and FIND_IN_SET ('therapeutic-drug-monitoring',item_other_data.pagewise_test)";
		$master_con=$city_cond.$page_cond;
		
		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
		$homeItems = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.status='Active' ".$master_con."","".$sort_cond." limit 0,20","");
		$this->app->assign("homeItems", $homeItems);
	}
}
?>