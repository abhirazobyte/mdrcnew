<?php 


 if($app->getPostVar('id') != NULL){
		$obj_category = $app->load_model("customer");
		$rs_category = $obj_category->execute("SELECT", false, "", "id=".$app->getPostVar('id')."");
		
		if(count($rs_category)>0)
		{
			$name=$rs_category[0]['name'].' '.$rs_category[0]['last_name'];
			$email=$rs_category[0]['email'];
			$id=$rs_category[0]['id'];
			$phone=$rs_category[0]['phone'];
			$wallet=$rs_category[0]['wallet'];

			
			$jsonclass = $app->load_module("Services_JSON");
			$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
			echo $obj_JSON->encode(array("RESULT"=>"OK", "name"=>$name,"first_name"=>$rs_category[0]['name'],"last_name"=>$rs_category[0]['last_name'], "email"=>$email,"id"=>$id,"phone"=>$phone,"wallet"=>$wallet));
			
		}
		else
		{
			
			$jsonclass = $app->load_module("Services_JSON");
			$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
			echo $obj_JSON->encode(array("RESULT"=>"NO"));
			
		}
		
		
		
					 	
	 }


















	
?>