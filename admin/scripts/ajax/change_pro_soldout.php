<?php
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);	
$value=$app->getPostVar("value");

$id=$app->getPostVar("id");
$update_field = array();
	$obj_model_product = $app->load_model("product", $id);
	$update_field['in_stock']=$value;
	
	$obj_model_product->map_fields($update_field);
	$update_id = $obj_model_product->execute("UPDATE");
		if($update_id>0){
			echo $obj_JSON->encode(array("RESULT"=>"1","msg"=>"succesfully updated"));
		}else{
			echo $obj_JSON->encode(array("RESULT"=>"1","msg"=>"data not updated"));
		}
?>