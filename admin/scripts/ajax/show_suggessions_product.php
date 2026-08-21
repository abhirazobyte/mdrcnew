<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$q=$app->getPostVar('queryString');

	
$obj_model_product = $app->load_model("product");
/*$order_clause="case 
when  product_name like '$q%' then 1
when  product_name like '%$q%' then 2
when  product_name like '%$q' then 3

 END
 ";*/
$order_clause="id DESC";
$rs_product = $obj_model_product->execute("SELECT", false, "SELECT product_name,product_model,id FROM product WHERE (product_name LIKE '$q%' or product_name LIKE '%$q%' or product_name LIKE '%$q' or product_model LIKE '$q%' or product_model LIKE '%$q%' or product_model LIKE '%$q')  ORDER BY ".$order_clause." LIMIT 0,10");

if(count($rs_product)>0)
{
for($i=0;$i<count($rs_product);$i++)
	{
		
	$product_name=$rs_product[$i]['product_name'];
	$product_model=$rs_product[$i]['product_model'];
	$product_id=$rs_product[$i]['id'];
	
	//$result1.='<a href="javascript:void(0);" onclick="addproduct_to_table('.$rs_product[$i]['id'].')" class="product_name"><span  class="searchheading">'.$part_no.' </span></a>';

	 $result1[] = array("label"=>$product_name.' ('.$product_model.')',"value"=>$product_id);
	
	}
}
else
{
		$result1[] = array("value"=>"","label"=>"Not Found");
		
		//$result1.='<a href="javascript:void(0);" class="product_name"><span  class="searchheading">No match found</span></a>';
}
	
echo $obj_json->encode($result1);		

?>