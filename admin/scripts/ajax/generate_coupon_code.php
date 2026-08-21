<?php

		

		

	$json_class = $app->load_module("JSON");

	$obj_json = new $json_class(JSON_LOOSE_TYPE);

	

	

	

		
			$key=$app->utility->generate_coupon_code(6);
			
			$code='SW'.$key;

			
	

	

	echo $obj_json->encode(array("RESULT"=>"0","CODE"=>$code));

		

?>