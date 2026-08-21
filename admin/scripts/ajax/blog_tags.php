<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);



$obj_change_table = $app->load_model('blog_tag');
$rs_data= $obj_change_table->execute("SELECT",false,"","status='Active'");
$data=array();
for($i=0;$i<count($rs_data);$i++)
{
	$data[]=$rs_data[$i]['name'];
	
	
}



echo $obj_json->encode($data);

?>