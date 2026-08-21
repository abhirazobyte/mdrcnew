<?php 
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
$city_id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("city_id"));



if($city_id>0)
{


	$obj_model_sel = $app->load_model("pincode");
	$rs_data=$obj_model_sel->execute("SELECT",false,"","city_id='".$city_id."'","","pincode.name");

	
	
	echo $obj_JSON->encode(array("RESULT"=>"0","DATA"=>$rs_data));	
	exit;
}
else
{
	
	echo $obj_JSON->encode(array("RESULT"=>"1","DATA"=>array(),"DATA1"=>array()));
	exit;
	
		
}
?>