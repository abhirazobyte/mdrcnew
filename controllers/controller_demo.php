<?
class _demo extends controller {
	function init(){
	}

	function onload(){
		echo 'done'; exit;
		$obj_model_item=$this->app->load_model("item_price");
		$obj_model_item->execute("DELETE",false,"","city_id!=1");

		$obj_model_user = $this->app->load_model("item_price_previous");
		$item_price_previous=$obj_model_user->execute("SELECT",false,"","city_id!=1");

		foreach($item_price_previous as $price_p)
		{	unset($price_p['id']);
			$obj_model_item=$this->app->load_model("item_price");
			$obj_model_item->map_fields($price_p);
			$obj_model_item->execute("INSERT",false,"","");
		}
	
		$obj_model_user=$this->app->load_model("item");
		$items=$obj_model_user->execute("SELECT",false,"","");

		foreach($items as $item)
		{
			$obj_model_item=$this->app->load_model("item_price");
			$item_price=$obj_model_user->execute("SELECT",false,"","item_id='".$item['id']."'");

			if(count($item_price)>0)
			{
				$cityIds=array_column($item_price,'city_id');
				$stateIds=array_column($item_price,'state_id');
				$api_cityIds=array_column($item_price,'api_city_id');
				$api_stateIds=array_column($item_price,'api_state_id');

				$update_field = array();
				$update_field['city_ids']=implode(',',array_unique(array_filter($cityIds)));
				$update_field['state_ids']=implode(',',array_unique(array_filter($stateIds)));
				$update_field['api_city_ids']=implode(',',array_unique(array_filter($api_cityIds)));
				$update_field['api_state_ids']=implode(',',array_unique(array_filter($api_stateIds)));

				$obj_model_item=$this->app->load_model("item");
				$obj_model_item->map_fields($update_field);
				$obj_model_item->execute("UPDATE",false,"","id='".$item['id']."'");
			}
		}
		echo 'done'; exit;
	}
}
?>