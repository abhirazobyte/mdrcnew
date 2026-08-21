<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

	
	
	
	$payMethod=$app->getGetVar("payMethod");
			
	
	
	$_SESSION['payment_type']=$payMethod;
	


	$RESULT=0;
	
	$distance_error_msg='';


		


	
									

											
																			
                                       
echo $obj_json->encode(array("RESULT"=>$RESULT,"error_msg"=>$distance_error_msg,"orderSummeryHtml"=>""));	

?>