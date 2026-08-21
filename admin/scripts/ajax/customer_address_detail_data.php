<?php 
	
	







	
	 if($app->getPostVar('id') != NULL){
		$obj_category = $app->load_model("customer");
		$rs_category = $obj_category->execute("SELECT", false, "", "id=".$app->getPostVar('id')."");
		
		if(count($rs_category)>0)
		{
			
			$obj_rs_address = $app->load_model("customer_address");
			 $obj_rs_address->join_table("state", "left", array("name"), array("state_id"=>"id"));

			$rs_address = $obj_rs_address->execute("SELECT", false, "", "customer_address.customer_id=".$app->getPostVar('id')."","customer_address.id DESC Limit 0,1");
			
			
			if(count($rs_address)>0)
			{
				
				$name=$rs_address[0]['first_name'].' '.$rs_address[0]['last_name'];
				$email=$rs_category[0]['email'];
				$id=$rs_address[0]['id'];
				$phone=$rs_address[0]['phone'];
				$wallet=$rs_category[0]['wallet'];
				
				$address=$rs_address[0]['line1'];
				
				
				
				$address1=$rs_address[0]['line2'];
				
				
				$pincode=$rs_address[0]['zipcode'];
				$city=$rs_address[0]['city'];
				$state=$rs_address[0]['state_name'];
				$address_type=$rs_address[0]['address_type'];
				
				$area='';
				$gst_no='';
				
				
			}
			else
			{
				
				$name=$rs_category[0]['name'].' '.$rs_category[0]['last_name'];
				$email=$rs_category[0]['email'];
				$id=0;
				$phone=$rs_category[0]['phone'];
				$wallet=$rs_category[0]['wallet'];
				
				$address='';
				$address1='';
				$pincode='';
				$city='';
				$state='';
				$address_type='Home';
				$area='';
				$gst_no='';
					
			}
			
			
			
			
			
			
			
			
			

			
			$jsonclass = $app->load_module("Services_JSON");
			$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
			echo $obj_JSON->encode(array("RESULT"=>"OK", "name"=>$name, "email"=>$email,"id"=>$id,"phone"=>$phone,"wallet"=>$wallet,"address"=>$address,"address1"=>$address1,"area"=>$area,"pincode"=>$pincode,"city"=>$city,"state"=>$state,"address_type"=>$address_type,"gst_no"=>$gst_no));
			
		}
		else
		{
			
			$jsonclass = $app->load_module("Services_JSON");
			$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
			echo $obj_JSON->encode(array("RESULT"=>"NO"));
			
		}
		
		
		
					 	
	 }
	
?>