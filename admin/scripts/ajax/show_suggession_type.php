<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$q=trim($app->getPostVar('queryString'));
$type=$app->getPostVar('type');
//echo $type;exit;
if($type=='Item')
{
	 $table_name='item';
}
if($type=='Category')
{
	 $table_name='item_category';
}
if($type=='Diseases')
{
	 $table_name='item_diseases';
}
if($type!='')
{
	$obj_model_item = $app->load_model("item");
	$rs_item = $obj_model_item->execute("SELECT", false, "SELECT name,id FROM ".$table_name." WHERE  name LIKE '$q%' or name LIKE '%$q%' or name LIKE '%$q' and status='Active' ORDER BY id DESC LIMIT 0,100");
	if(count($rs_item)>0)
	{
		for($i=0;$i<count($rs_item);$i++)
		{
			$id=$rs_item[$i]['id'];
			$name=$rs_item[$i]['name'];
			$result1[] = array("label"=>$name,"value"=>$id);
		}
	}
	else
	{
		$result1[] = array("value"=>"","label"=>"Not Found");
	}
}
else
{
	$result1[] = array("value"=>"","label"=>"Not Found");
}


echo $obj_json->encode($result1);
?>
