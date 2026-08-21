<?php
	mysqli_set_charset('utf8');
	$json_class = $app->load_module("JSON");
	$obj_json = new $json_class(JSON_LOOSE_TYPE);
	$actionType = $app->getPostVar('actionType');
	if($actionType=='list')
	{
		$limit = 12;
		$actionfunction = $app->getPostVar('actionfunction');
		$page_no=$app->getPostVar("page");
		$type_ids=$app->getPostVar("type_ids");
		$dieses_ids=$app->getPostVar("dieses_ids");
		$total_data=$app->getPostVar("total_data");
		$search_data=$app->getPostVar("search_data");
		$category_ids=$app->getPostVar("category_ids");
		$sort_by=$app->getPostVar("sort_by");
		$city_id=$app->getPostVar("city_id");
		$department_id=$app->getPostVar("department_id");
		$pageType=$app->getPostVar("pageType");
		$site=$app->getPostVar("site");
		
		$data=array("page"=>$page_no,"limit"=>$limit,"type_ids"=>$type_ids,"dieses_ids"=>$dieses_ids,"total_data"=>$total_data,"search_data"=>$search_data,"category_ids"=>$category_ids,"sort_by"=>$sort_by,"city_id"=>$city_id,"department_id"=>$department_id,"pageType"=>$pageType,"site"=>$site);
		echo $app->utility->load_packages($data);
	}
?>