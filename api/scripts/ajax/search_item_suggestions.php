
<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$q=$app->getPostVar('queryString');







$order_clause="name asc ";

	



$obj_model_survey = $app->load_model("item");
$obj_model_survey->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
//$obj_model_survey->join_table("product_price", "left", array(), array("id"=>"product_id"));
$rs_survey = $obj_model_survey->execute("SELECT", false, "","(item.name LIKE '%$q%' or item.name LIKE '%$q%' or item.name LIKE '%$q' or item.tags LIKE '%$q%')  and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and (item.status='Active')","item.name asc limit 0,10");



//echo $obj_model_survey->sql; exit;

//$result1='';
$result1=array();

if(count($rs_survey)>0)
{
	for($i=0;$i<count($rs_survey);$i++)
	{
		$id=$rs_survey[$i]['name'];
		$name=$rs_survey[$i]['name'];
		
		$item_type_id=$rs_survey[$i]['item_other_data_item_type_id'];
		
		$slug=$rs_survey[$i]['slug'];
		
		if($item_type_id==1)
		{
			$itemLabel='Package';
			
		}
		else
		{
			$itemLabel='Test';
		}
		
		
		
		
		
		
		
		
		$result1[] = array("label"=>$name,"value"=>$id,"name"=>$name,"slug"=>$slug,"citySlug"=>$_SESSION['citySlug'],"itemLabel"=>$itemLabel);
	

	}
	
}
else
{
		$result1[] = array("label"=>'Not Found',"value"=>'',"name"=>'',"slug"=>"","itemLabel"=>$itemLabel);
}



	
echo $obj_json->encode($result1);	

?>