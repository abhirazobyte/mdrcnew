<?php
mysqli_set_charset($app->set_db_conn(),'utf-8');
$limit = 6;
$actionfunction = $app->getPostVar('actionfunction');
$page_no=$app->getPostVar("page");
$cat=$app->getPostVar("cat");
$tag=$app->getPostVar("tagv");
$serach_keyword=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("serach_keyword"));
$sort_by=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("sort_by"));
$total_blogs=$app->getPostVar("total_blogs");
$data=array("page"=>$page_no);
echo $app->utility->load_blogs($data,$limit,$cat,$tag,$serach_keyword,$total_blogs,$sort_by);
?>