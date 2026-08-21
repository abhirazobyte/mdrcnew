<?php 
	$jsonclass = $app->load_module("Services_JSON");
	$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
	
	
	
	
	 if($app->getPostVar('product_id') != NULL){
		 
		 
		 
		 
		 
		 
		 
		 
		 
			$obj_product = $app->load_model("product");
			$obj_product->join_table("product_price", "left", array(), array("id"=>"product_id"));
			$obj_product->join_table("product_info", "left", array(), array("id"=>"product_id"));
			$rs_product = $obj_product->execute("SELECT", false, "", "product_price.id=".$app->getPostVar('product_id')."");
			
		
		
		
		
		
		
		
		
		
		$product_id=$rs_product[0]["id"];
		$product_name=$rs_product[0]["name"];
		
		
		
		$product_price_id=$rs_product[0]['product_price_id'];
		
		
		
		
		$product_info_1=$rs_product[0]['product_info_attribute_title1'];
		$product_info_2=$rs_product[0]['product_info_attribute_title2'];
		$product_info_3=$rs_product[0]['product_info_attribute_title3'];
		
		$product_attribute_1=$rs_product[0]['product_price_attribute_1'];
		$product_attribute_2=$rs_product[0]['product_price_attribute_2'];
		$product_attribute_3=$rs_product[0]['product_price_attribute_3'];
		
		
		
		$opt='';	
		if($product_attribute_1!='' || $product_attribute_2!='' || $product_attribute_3!='')
		{
			$str='';
			if($product_attribute_1!='')
			{
				$str.=$product_attribute_1;
				
			}
			if($product_attribute_2!='')
			{
				$str.=' - '.$product_attribute_2;
				
			}
			if($product_attribute_3!='')
			{
				$str.=' - '.$product_attribute_3;
				
			}
			
			$opt='('.$str.')';
			
		}
				
		
		$product_unit_cost=0;
		$product_unit_weight=0;
		$product_cost=0;
		$rs_product_price=0;
		
		
		$type=$rs_product[0]["product_price_price"];
		
		
		
		$product_discount=$rs_product[0]["discount"];
		
		$start_date=$rs_product[0]["start_date"];
		$expire_date=$rs_product[0]["expire_date"];
		
		$new_price=$rs_product[0]["product_price_price"];
		$new_mrp=$rs_product[0]["product_price_mrp"];
		
		
		$product_weight=$rs_product[0]["product_price_price"];
		$sku_code=$rs_product[0]["sku"];
		$folder=$rs_product[0]["folder"];
		
		$product_unit_cost=$new_price;
		
		
					$productimage=$rs_product[0]['image'];

		  			if($productimage!="" && file_exists(ABS_PATH."/uploads/product/".$folder."/thumb".$productimage))							      				{

						 $product_image = SERVER_ROOT."/uploads/product/".$folder."/thumb".$productimage;
					}



					else



					{

						$product_image=SERVER_ROOT."/uploads/default.jpg";

					}
					
					
					$acceptance='<span class="label label-success">Yes</span>';

		
		
		echo $obj_JSON->encode(array("RESULT"=>"OK", "product_id"=>$product_id, "product_name"=>$product_name,"product_unit_cost"=>$product_unit_cost,"product_unit_weight"=>$rs_product_price,"product_cost"=>$product_cost,"product_new_price"=>$new_price,"new_mrp"=>$new_mrp,"p_type"=>$type,"product_image"=>$product_image,"sku_code"=>$sku_code,"product_price_id"=>$product_price_id,"product_weight"=>$product_weight,
		"d_price"=>$d_price,"r_price"=>$r_price,"w_qty"=>$w_qty,
		"product_info_1"=>$product_info_1,
		"product_info_2"=>$product_info_2,
		"product_info_3"=>$product_info_3,
		
		"product_attribute_1"=>$product_attribute_1,
		"product_attribute_2"=>$product_attribute_2,
		"product_attribute_3"=>$product_attribute_3,
		"others_opt"=>$opt
		
		
		));	
		
		
			//echo $obj_JSON->encode(array("RESULT"=>"OK", "product_id"=>$product_id, "product_name"=>$product_name,"product_unit_cost"=>$product_unit_cost,"product_unit_weight"=>$product_unit_weight,"product_cost"=>$product_cost));				 	
	 }
	
	
?>