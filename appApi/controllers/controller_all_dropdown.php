<?
class _all_dropdown extends controller{
	function init(){
	}
	function onload()
	{
		
		$obj_model= $this->app->load_model("customer_prefix");
		$prefixData = $obj_model->execute("SELECT", false,"","status='Active'");
		foreach($prefixData as $item) {
			$prefix[] = ["ID"=>$item['name'],"name"=>$item['name']];
		}

		$relation[] = ["ID"=>'Self',"name"=>'Self'];
		$relation[] = ["ID"=>'Spouse',"name"=>'Spouse'];
		$relation[] = ["ID"=>'Child',"name"=>'Child'];
		$relation[] = ["ID"=>'Parent',"name"=>'Parent'];
		$relation[] = ["ID"=>'Grand Parent',"name"=>'Grand Parent'];
		$relation[] = ["ID"=>'Sibling',"name"=>'Sibling'];
		$relation[] = ["ID"=>'Friend',"name"=>'Friend'];
		$relation[] = ["ID"=>'Relative',"name"=>'Relative'];
		$relation[] = ["ID"=>'Neighbour',"name"=>'Neighbour'];
		$relation[] = ["ID"=>'Colleague',"name"=>'Colleague'];
		$relation[] = ["ID"=>'Other',"name"=>'Other'];


		$obj_model_city = $this->app->load_model("state");
		$city = $obj_model_city->execute("SELECT",false,"","state.status='Active'","state.name ASC");
		foreach($city as $item)
		{
			$stateList[]=["ID"=>$this->app->utility->encrypt($item['id']),"name"=>$item['name']];
		}

		$obj_model_city = $this->app->load_model("city");
		$city = $obj_model_city->execute("SELECT",false,"","city.status='Active'","city.name ASC");
		$folder='city';
		foreach($city as $item)
		{
			$image=$this->app->utility->get_image_path($item['image'],$folder,'large');
			$image=$image==SERVER_ROOT."/uploads/default.png"?"":$image;
			$cityList[]=["ID"=>$this->app->utility->encrypt($item['id']),"stateID"=>$this->app->utility->encrypt($item['state_id']),"name"=>$item['name'],"image"=>$image];
		}
		
		$result=["prefix"=>$prefix,"relation"=>$relation,"cityList"=>$cityList,"stateList"=>$stateList];
		$message=array("message"=>"success","msgCode"=>"1","result"=>$result);
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>