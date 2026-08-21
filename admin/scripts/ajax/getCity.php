<?php 
$state_id=$app->getPostVar('id');

if($state_id!='')
{
	$obj_city = $app->load_model("city");
	$rs_city = $obj_city->execute("SELECT", false, "", "state_id='".$state_id."' and status='Active'");

	$option='<option>Select City</option>';
	for ($i=0; $i<count($rs_city); $i++)
	{ 
		$option.='<option value="'.$rs_city[$i]["id"].'">'.$rs_city[$i]["name"].'</option>';
	}
	echo $option;
	exit;	
}


?>