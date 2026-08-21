<?
class _category_list extends controller{
	function init(){
	}
	function onload()
	{
		$obj_model_city = $this->app->load_model("item_category");
		$city = $obj_model_city->execute("SELECT",false,"","item_category.status='Active'","item_category.sort_order ASC");
		$folder='item_category';
		
		foreach($city as $item)
		{
			$image=$this->app->utility->get_image_path($item['image'],$folder,'large');
			$image=$image==SERVER_ROOT."/uploads/default.png"?"":$image;
			$categoryList[]=[
				"id"=>$item['id'],
				"name"=>$item['name'],
				"image"=>$image,
				"slug"=>$item['slug'],
				"meta_title"=>$item['meta_title'],
				"meta_keywords"=>$item['meta_keywords'],
				"meta_description"=>$item['meta_description']
				];
		}
		
		$result=["categoryList"=>$categoryList];
		$message=array("message"=>"success","msgCode"=>"1","data"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>