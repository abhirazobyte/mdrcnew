<?php

mysqli_set_charset($app->set_db_conn(),'utf-8');

//include('db.php');

$limit = 10;

$actionfunction = $app->getPostVar('actionfunction');



$page_no=$app->getPostVar("page");



$serach_keyword=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("serach_keyword"));



$total_products=$app->getPostVar("total_products");



$cust_id=$_SESSION['MDRCCustID']; 





$data=array("page"=>$page_no); 


$site = $app->getPostVar("site")!=''?$app->getPostVar("site"):"site";
echo $app->utility->load_my_orders($data,$limit,$serach_keyword,$total_products,$cust_id,$site);
?>