
<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$q=$app->getPostVar('queryString');







$order_clause="name asc ";

	




$obj_model_survey = $app->load_model("product");
$obj_model_survey->join_table("product_price", "left", array(), array("id"=>"product_id"));
$rs_survey = $obj_model_survey->execute("SELECT", false, "","(product.name LIKE '%$q%' or product.name LIKE '%$q%' or product.name LIKE '%$q' or product.sku LIKE '%$q%' or product.sku LIKE '%$q%' or product.sku LIKE '%$q') and (product.status='Active')","product.name asc limit 0,10");



//echo $obj_model_survey->sql; exit;

//$result1='';
$result1=array();

if(count($rs_survey)>0)
{
	for($i=0;$i<count($rs_survey);$i++)
	{
		$id=$rs_survey[$i]['product_price_id'];
		
		
		
		$attribute_1=$rs_survey[$i]['product_price_attribute_1'];
		$attribute_2=$rs_survey[$i]['product_price_attribute_2'];
		$attribute_3=$rs_survey[$i]['product_price_attribute_3'];
		
		$opt='';	
		if($attribute_1!='' || $attribute_2!='' || $attribute_3!='')
		{
			$str='';
			if($attribute_1!='')
			{
				$str.=$attribute_1;
				
			}
			if($attribute_2!='')
			{
				$str.=' - '.$attribute_2;
				
			}
			if($attribute_3!='')
			{
				$str.=' - '.$attribute_3;
				
			}
			
			$opt=' ('.$str.')';
			
		}
		
		
		
		
		
		
		
		
		$sugg_name=$rs_survey[$i]['name'].$opt;
		
		$name=$rs_survey[$i]['name'].$opt;
		
		$image=$rs_survey[$i]['image'];
		$folder=$rs_survey[$i]['folder'];
		
		if($image!="" && file_exists(ABS_PATH.$app->get_user_config('product').$folder.'/thumb'.$image))
		{
			$product_image= SERVER_ROOT.$app->get_user_config("product").$folder.'/thumb'.$image;
		}
		else
		{
			$product_image=SERVER_ROOT.'/uploads/default_product.png';
		}
		
		
		
		
		$result1[] = array("label"=>$sugg_name,"value"=>$id,"name"=>$name,"img"=>$product_image);
	

	}
	
}
else
{
		$result1[] = array("label"=>'Not Found',"value"=>'',"name"=>'',"img"=>$product_image);
}



	
echo $obj_json->encode($result1);	

?>