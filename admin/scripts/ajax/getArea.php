<?php 
$city_id=$app->getPostVar('id');

if($city_id!='')
{
	$obj_city = $app->load_model("area");
	$rs_city = $obj_city->execute("SELECT", false, "", "city_id='".$city_id."' and status='Active'");

	$option='<option>Select Area</option>';
	for ($i=0; $i<count($rs_city); $i++)
	{ 
		$option.='<option value="'.$rs_city[$i]["id"].'">'.$rs_city[$i]["name"].'</option>';
	}
	echo $option;
	exit;	
}


?>