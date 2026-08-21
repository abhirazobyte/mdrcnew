<?
class _city_list extends controller{
	function init(){
	}
	function onload()
	{
		$obj_model_city = $this->app->load_model("city");
		$city = $obj_model_city->execute("SELECT",false,"","city.status='Active'","city.name ASC");
		$folder='city';
		
		foreach($city as $item)
		{
			$image=$this->app->utility->get_image_path($item['image'],$folder,'large');
			$image=$image==SERVER_ROOT."/uploads/default.png"?"":$image;
			$cityList[]=["id"=>$this->app->utility->encrypt($item['id']),"name"=>$item['name'],"image"=>$image];
		}
		
		$result=["cityList"=>$cityList];
		$message=array("message"=>"success","msgCode"=>"1","result"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>