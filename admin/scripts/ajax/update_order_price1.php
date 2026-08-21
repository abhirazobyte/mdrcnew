<?php 
	$jsonclass = $app->load_module("Services_JSON");
	$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
	$all_postvars=$app->getPostVars();
	
	 $product_id=$app->getPostVar("product_id");
	 $weight=$app->getPostVar("weight");
	 $qty=$app->getPostVar("qty");
	 
	  $new_price=$app->getPostVar("new_price");
	 
	 $obj_product = $app->load_model("product");
	 $rs_product= $obj_product->execute("SELECT", false, "", "id=".$product_id."");
	 
	 $product_unit=$rs_product[0]["product_unit"];
	
	
	
	//to get price of 1 
	$obj_model_product_price = $app->load_model("product_price");
	$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=".$product_id."","price ASC");
	
	$unit_price=$rs_price[0]['price'];
	$unit_weight=$rs_price[0]['weight'];
	
	if($product_unit=='in_gm')
	{
		
			$rs_price1 = $obj_model_product_price->execute("SELECT", false, "", "product_id=".$product_id." and weight=".$weight."" );
		
		
		
			
		//if(count($rs_price1)>0)
		//{	
		//$price=round($new_price)* $qty;
		//}
		//else
		//{
			
			
		//$gm_price=$new_price/$unit_weight;
		
		
		//echo $gm_price; exit;
		//$price=$gm_price*$weight;
		//$price=$price*$qty;
		//$price=round($price,2);
		
		
		$price= ($weight*$new_price)/1000;
		$price=$price*$qty;
		
		$price=round($price,2);
		
		
		
		//}
	}
	
	else
	{
		
		
		$price= ($weight*$new_price)/1;
		$price=$price*$qty;
		
		$price=round($price,2);
		
		
		
		//$kg_price=$new_price/$unit_weight;;
		//$price=$kg_price*$qty*$weight;
	}
	
	 
	 
	
	 
		
echo $obj_JSON->encode(array("RESULT"=>"OK", "PRICE"=>$price,"PRODUCT_UNIT"=>$product_unit,"KG_PC_PRICE"=>$kg_price));			 	
	
	
	
?>