<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$q=$app->getPostVar('queryString');

	
$obj_model_product = $app->load_model("customer");
$order_clause="id DESC";
$rs_product = $obj_model_product->execute("SELECT", false, "SELECT phone,name,last_name,id,wallet FROM customer WHERE (phone LIKE '$q%' or phone LIKE '%$q%' or phone LIKE '%$q' or name LIKE '$q%' or name LIKE '%$q%' or name LIKE '%$q' or last_name LIKE '$q%' or last_name LIKE '%$q%' or last_name LIKE '%$q')  ORDER BY ".$order_clause." LIMIT 0,10");

if(count($rs_product)>0)
{
for($i=0;$i<count($rs_product);$i++)
	{
		
	$phone=$rs_product[$i]['phone'];
	$user_id=$rs_product[$i]['id'];
	$wallet=$rs_product[$i]['wallet'];
	$name=$rs_product[$i]['name'].' '.$rs_product[$i]['last_name'];
	//$result1.='<a href="javascript:void(0);" onclick="addproduct_to_table('.$rs_product[$i]['id'].')" class="product_name"><span  class="searchheading">'.$part_no.' </span></a>';
	
	 $result1[] = array("label"=>$phone.' ('.$name.')',"value"=>$user_id,"wallet"=>$wallet);
	
	}
}
else
{
		$result1[] = array("value"=>"","label"=>"Not Found");
		
		//$result1.='<a href="javascript:void(0);" class="product_name"><span  class="searchheading">No match found</span></a>';
}
	
echo $obj_json->encode($result1);		

?>