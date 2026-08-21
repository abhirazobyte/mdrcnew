<?
class _diseases_list extends controller{
	function init(){
	}
	function onload()
	{
		$cityID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('cityID'));
		$cityID = $this->app->utility->decrypt($cityID);

		$obj_model_city=$this->app->load_model('city');
		$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$cityID."'");

		$obj_model_city = $this->app->load_model("item_diseases");
		$diseases = $obj_model_city->execute("SELECT",false,"","item_diseases.status='Active'","item_diseases.sort_order ASC");
		$folder='item_diseases';
		
		foreach($diseases as $item)
		{
			$image=$this->app->utility->get_image_path($item['image'],$folder,'large');
			$image=$image==SERVER_ROOT."/uploads/default.png"?"":$image;
			$diseasesList[]=[
				"id"=>$item['id'],
				"name"=>$item['name'],
				"image"=>$image,
				"slug"=>$item['slug'],
				"meta_title"=>$item['meta_title'],
				"meta_keywords"=>$item['meta_keywords'],
				"meta_description"=>$item['meta_description']
				];
		}
		
		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='health_risk' and status!='Trash'");
		
		$default_string = array("{CITY}");
		$new_string   = array($rs_city[0]['name']);

		$meta_title = str_replace($default_string, $new_string,$meta_data[0]['meta_title']);
		$meta_keyword = str_replace($default_string, $new_string,$meta_data[0]['meta_keywords']);
		$meta_description = str_replace($default_string, $new_string,$meta_data[0]['meta_description']);
		$meta_schema = str_replace($default_string, $_SESSION['citySlug'],$meta_data[0]['meta_schema']);

		$result=[
			"meta_title" => $meta_title,
			"meta_keyword" => $meta_keyword,
			"meta_description" => $meta_description,
			"meta_schema" =>$meta_schema,
			"diseasesList"=>$diseasesList
		];
		$message=array("message"=>"success","msgCode"=>"1","data"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>