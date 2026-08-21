<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
if($_SESSION['MDRCCustID']>0){
    $RESULT='0';
    $MSG='';
} else {
    $RESULT='1';
    $MSG='';
}
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));	
?>