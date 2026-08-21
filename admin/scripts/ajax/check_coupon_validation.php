<?php 


			$code=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("coupon_code"));
			$msg=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("msg"));
			$admin_note=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("admin_note"));
				
				$types=$app->getPostVar('types');
				$amount=$app->getPostVar('amount');
				$max_amount=$app->getPostVar('max_amount');
				
				$exclude_shiping_type=$app->getPostVar('exclude_shiping_type');
				$exclude_shipping_rate_value=$app->getPostVar('exclude_shipping_rate_value');
								
				
				$buy_quantity=$app->getPostVar('buy_quantity');
				$products_buy_ids_data=implode(',',$app->getPostVar('products_buy_ids_data'));
				
				$get_quantity=$app->getPostVar('get_quantity');
				$products_get_ids_data=implode(',',$app->getPostVar('products_get_ids_data'));
				
				$get_discount_value=$app->getPostVar('get_discount_value');
								
				$applies_type=$app->getPostVar('applies_type');
				$works=implode(',',$app->getPostVar('work_item'));
				$products_ids_data=implode(',',$app->getPostVar('products_ids_data'));
				
				$requirement_types=$app->getPostVar('requirement_types');
				$order_amount=$app->getPostVar('order_amount');
				
				$customer_types=$app->getPostVar('customer_types');
				$customer_ids_data=implode(',',$app->getPostVar('customer_ids_data'));
				
				
				$use_limit_type=$app->getPostVar('use_limit_type');
				$use_limit_value=$app->getPostVar('use_limit_value');
				$once_per_customer_type=$app->getPostVar('once_per_customer_type');
								
				
				$start_date=$app->getPostVar('start_date');
				$exp_date=$app->getPostVar('exp_date');

				$id=$app->getPostVar('id');

	
	
	 if($types!= ''){
		
		
				if($types=='Percentage' || $types=='Fixed_Amount')
				{
					if($applies_type=='Specific_Category')
					{
						if($works=='')
						{
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Category."));
							exit;
						}
							
					}
					
					if($applies_type=='Specific_Products')
					{
						if($products_ids_data=='')
						{
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Product."));
							exit;
						}
							
					}
					
					
					if($customer_types=='Specific_Customers')
					{
						if($customer_ids_data=='')
						{
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Customer."));
							exit;
						}
							
					}
					
										
				}
				
				else if($types=='Free_Shipping')
				{
					
					if($customer_types=='Specific_Customers')
					{
						if($customer_ids_data=='')
						{
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Customer."));
							exit;
						}
							
					}
					
				}
				
				else if($types=='Buy_X_Y')
				{
					
					if($products_buy_ids_data=='')
					{
						
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Buy Product."));
							exit;
						
							
					}
					
					if($products_get_ids_data=='')
					{
						
						
							$jsonclass = $app->load_module("Services_JSON");
							$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
							echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Get Product."));
							exit;
						
							
					}
					
				}
				else
				{
					$jsonclass = $app->load_module("Services_JSON");
					$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
					echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Types"));
					exit;
					
				}
		
		
		
					$jsonclass = $app->load_module("Services_JSON");
					$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
					echo $obj_JSON->encode(array("RESULT"=>"0","MSG"=>""));
					exit;
		
					 	
	 }
	 else
	 {
		 	$jsonclass = $app->load_module("Services_JSON");
			$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);
			echo $obj_JSON->encode(array("RESULT"=>"1","MSG"=>"Please Select Types"));
			exit;
		 
	 }
	
?>