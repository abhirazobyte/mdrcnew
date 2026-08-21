<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);

$getId=mysqli_real_escape_string($app->set_db_conn(),$app->getGetVar("getId"));
$getName=mysqli_real_escape_string($app->set_db_conn(),$app->getGetVar("getName"));



$_SESSION['getId']=$getId;
$_SESSION['getName']=$getName;
$_SESSION['getType']='category';


echo $obj_json->encode(array("RESULT"=>"1", "URL"=>"radiology/imaging-lab-tests-near/".$_SESSION['citySlug']));
exit;
?>