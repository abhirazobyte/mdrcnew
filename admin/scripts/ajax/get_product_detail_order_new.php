<?php 
	$jsonclass = $app->load_module("Services_JSON");
	$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
	
	 if($app->getPostVar('product_id') != NULL){
		$obj_product = $app->load_model("product");
		$rs_product = $obj_product->execute("SELECT", false, "", "id=".$app->getPostVar('product_id')."");
		
		$product_id=$rs_product[0]["id"];
		$product_name=$rs_product[0]["product_name"];
		$product_unit=$rs_product[0]["product_unit"];
		
		
		
		$product_image= $rs_product[0]["product_image"];
						
						if($product_image!="" && file_exists(ABS_PATH.$app->get_user_config("product_image1").$product_image))
						{
							 $product_image1=SERVER_ROOT.$app->get_user_config("product_image1").'thumb'.$product_image;	
						}
						else
						{
							$product_image1=SERVER_ROOT.'/uploads/thumbdefault.jpg';
						}
		
		
		
		
		
		if($product_unit=="in_gm" || $product_unit=="in_ltr")
		{
		
			$obj_product_price = $app->load_model("product_price");
		//$rs_product_price = $obj_product_price->execute("SELECT", false, "", "product_id=".$app->getPostVar('product_id')." and weight='1000'");
		
			$rs_product_price = $obj_product_price->execute("SELECT", false, "", "product_id=".$app->getPostVar('product_id')." and weight='1000'");
		
			
			if(count($rs_product_price)>0)
			{
		
			$product_unit_cost=$rs_product_price[0]["price"];
			$product_unit_weight=(int)$rs_product_price[0]["weight"];
			$product_cost=$rs_product_price[0]["price"];
				$product_mrp=$rs_product_price[0]["mrp"];
			
			}
			else
			{
				
				$rs_product_price = $obj_product_price->execute("SELECT", false, "", "product_id=".$app->getPostVar('product_id')."","weight ASC");
				
			$product_unit_cost=$rs_product_price[0]["price"];
			$product_unit_weight=(int)$rs_product_price[0]["weight"];
			$product_cost=$rs_product_price[0]["price"];
				
				$product_mrp=$rs_product_price[0]["mrp"];
			}
	
		
		}
		else
		{
			$obj_product_price = $app->load_model("product_price");
			$rs_product_price = $obj_product_price->execute("SELECT", false, "", "product_id=".$app->getPostVar('product_id')."","weight ASC");
			
			$product_unit_cost=$rs_product_price[0]["price"];
			$product_unit_weight=(int)$rs_product_price[0]["weight"];
			$product_cost=$rs_product_price[0]["price"];
			$product_mrp=$rs_product_price[0]["mrp"];
		}
		

		if($product_unit=='in_gm')
		{
			$unit="Gm";
		}
		else if($product_unit=='in_ltr')
		{
			$unit="Ltr";
		}
		else if($product_unit=='in_pkt')
		{
			$unit="Pkt";
		}
		else
		{
			$unit="Pcs";
		}

		
		
		echo $obj_JSON->encode(array("RESULT"=>"OK","IMAGE"=>$product_image1, "product_id"=>$product_id, "product_name"=>$product_name,"product_unit_cost"=>$product_unit_cost,"product_unit_weight"=>$product_unit_weight,"product_cost"=>$product_cost,"product_unit"=>$product_unit,"unit_type"=>$unit,"product_mrp"=>$product_mrp));			 	
	 }
	
	
?>