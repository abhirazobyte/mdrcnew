<?php
	$reset=$app->getPostVar('reset');
	if($reset!='clear')
	{
		$_SESSION['search_city']=$app->getPostVar('city_id');
		$_SESSION['search_start_order_date']=$app->getPostVar('start_date');
		$_SESSION['search_end_order_date']=$app->getPostVar('end_date');
		$_SESSION['search_test']=$app->getPostVar('test_name');

		$_SESSION['search_order_status']=$app->getPostVar('order_status');
		$_SESSION['search_cust_phone']=$app->getPostVar('customer_phone');
		$_SESSION['search_cust_name']=$app->getPostVar('customer_name');
		$_SESSION['search_cust_email']=$app->getPostVar('customer_email');
	}else {
		$_SESSION['search_city']='';
		$_SESSION['search_start_order_date']='';
		$_SESSION['search_end_order_date']='';
		$_SESSION['search_test']='';

		$_SESSION['search_order_status']='';
		$_SESSION['search_cust_phone']='';
		$_SESSION['search_cust_name']='';
		$_SESSION['search_cust_email']='';
	}
	echo 0;
?>
