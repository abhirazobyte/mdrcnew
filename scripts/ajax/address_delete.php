<?php
$getid=$app->getPostVar('id');
if($getid!= NULL && $getid>0)
{
	$obj_change_table = $app->load_model('customer_address');
	$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");

	echo 0;
	exit();
}
else
{
	echo 1;
	exit();
}
?>