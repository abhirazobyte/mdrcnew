
<?php 
	



if($app->getPostVar('city') != NULL)
{
	$obj_area = $app->load_model("city");
	$rs_area = $obj_area->execute("SELECT", false, "", "name='".$app->getPostVar('city')."'"); 
	
	$city_id=$rs_area[0]['id'];
	$state_name=$rs_area[0]['state_name'];
		
	$obj_category = $app->load_model("area");
	$rs_category = $obj_category->execute("SELECT", false, "", "city_id=".$city_id." and status='Active'");
	$jsonclass = $app->load_module("Services_JSON");
	$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
	echo $obj_JSON->encode(array("RESULT"=>"OK", "DATA"=>$rs_category,"state_name"=>$state_name));			 	
}




?>