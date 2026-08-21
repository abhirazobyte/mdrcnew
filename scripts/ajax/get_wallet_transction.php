<?php
mysqli_set_charset($app->set_db_conn(),'utf-8');
//include('db.php');
$limit = 10;
$actionfunction = $app->getPostVar('actionfunction');

$page_no=$app->getPostVar("page");

$serach_keyword=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("serach_keyword"));

$total_products=$app->getPostVar("total_products");

$cust_id=$_SESSION['MDRCCustID']; 

$site=$app->getPostVar("site");
$data=array("page"=>$page_no,"site"=>$site); 

echo $app->utility->load_wallet_transction($data,$limit,$serach_keyword,$total_products,$cust_id);







?>