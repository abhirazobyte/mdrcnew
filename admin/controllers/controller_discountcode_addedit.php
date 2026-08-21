<?

	class _discountcode_addedit extends controller{

		

		function init(){

			//$this->app->enable_cache("home.html");

		}

		

		function onload(){

			
			
			
			 $obj_model_work = $this->app->load_model("city");
			 $rs_work = $obj_model_work->execute("SELECT",false,"","status='Active'");
			 $this->assign("work", $rs_work);

			 $obj_model_item = $this->app->load_model("item");
			 $rs_item = $obj_model_item->execute("SELECT",false,"","status='Active'");
			 $this->assign("item", $rs_item);

			$this->assign("id", $this->app->getGetVar('id'));

			if($this->app->getGetVar('id')!=""){

				$obj_model_coupon = $this->app->load_model("coupon");

				$rs = $obj_model_coupon->execute("SELECT", false, "","id!=0");

				$records = array();

				for($i=1;$i<=count($rs);$i++){

					$records[$i] = $i;

				}

				$this->assign("rs",$records);

				

				$this->assign("to_do", "Edit");

				$this->load_data();

			}else{

				$obj_model_coupon = $this->app->load_model("coupon");

				$rs = $obj_model_coupon->execute("SELECT", false, "");

				$records = array();

				for($i=1;$i<=count($rs)+1;$i++){

					$records[$i] = $i;

				}

				$this->assign("rs",$records);

			

				$this->assign("to_do", "Add");

			}
			
			$this->assign("manage_for", "Coupon Code");

		}

		

		function load_data(){

			

			$obj_model_coupon = $this->app->load_model("coupon", $this->app->getGetVar('id'));
			$rsUser = $obj_model_coupon->execute("SELECT");

			if(count($rsUser)>0){

				$this->app->assign_form_data("frm_user_addedit", $rsUser[0]);
								
				$this->app->assign("rs_coupons", $rsUser[0]);
				
				$obj_model_coupon_info = $this->app->load_model("coupon_info");
				$coupon_info = $obj_model_coupon_info->execute("SELECT",false,"","coupon_id='".$rsUser[0]['id']."'");
				
				$this->app->assign("coupon_info", $coupon_info[0]);

			}else{

				$this->app->redirect("index.php?view=coupon_list");

			}

		}

		

		function update_data(){		
		
		
		
		
			$code=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("coupon_code"));
			$msg=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("msg"));
			$admin_note=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("admin_note"));
				
				$types=$this->app->getPostVar('types');
				$amount=$this->app->getPostVar('amount');
				$max_amount=$this->app->getPostVar('max_amount');
				
				$exclude_shiping_type=$this->app->getPostVar('exclude_shiping_type');
				$exclude_shipping_rate_value=$this->app->getPostVar('exclude_shipping_rate_value');
								
				
				$buy_quantity=$this->app->getPostVar('buy_quantity');
				$products_buy_ids_data=implode(',',$this->app->getPostVar('products_buy_ids_data'));
				
				$get_quantity=$this->app->getPostVar('get_quantity');
				$products_get_ids_data=implode(',',$this->app->getPostVar('products_get_ids_data'));
				
				$get_discount_value=$this->app->getPostVar('get_discount_value');
								
				$applies_type=$this->app->getPostVar('applies_type');
				$works=implode(',',$this->app->getPostVar('work_item'));
				$applies_item=$this->app->getPostVar('applies_item');
				$item_items=implode(',',$this->app->getPostVar('item_item'));
				$products_ids_data=implode(',',$this->app->getPostVar('products_ids_data'));
				
				$requirement_types=$this->app->getPostVar('requirement_types');
				$order_amount=$this->app->getPostVar('order_amount');
				
				$customer_types=$this->app->getPostVar('customer_types');
				$customer_ids_data=implode(',',$this->app->getPostVar('customer_ids_data'));
				
				
				$use_limit_type=$this->app->getPostVar('use_limit_type');
				$use_limit_value=$this->app->getPostVar('use_limit_value');
				$once_per_customer_type=$this->app->getPostVar('once_per_customer_type');
				
				
				
				$start_date=$this->app->getPostVar('start_date');
				$exp_date=$this->app->getPostVar('exp_date');

				$id=$this->app->getPostVar('id');
		
			

			if($id!=""){

				
				
				
				
				
				
				$obj_model_coupon_code = $this->app->load_model("coupon");
				$rscoupon_code = $obj_model_coupon_code->execute("SELECT",false,"","coupon_code='".$code."' and vendor_id='".$_SESSION['partner']."' and status!='Trash' and id!='".$id."'");

				

				if(count($rscoupon_code)>0)
				{

					$this->app->utility->set_message("This coupon code already exist.", "ERROR");
					$this->app->redirect("index.php?view=discountcode_addedit&id='".$id."'");
					exit;				
				}
				
				
				
				
				
				
				
				
				
				
				$update_field = array();
				$update_field['coupon_code']=$code;
				
				
				
				if($types=='Percentage')
				{
					$update_field['type']='Percentage';
										
				}
				else if($types=='Fixed_Amount')
				{
					
					$update_field['type']='Fixed amount';
					
				}
				else if($types=='Free_Shipping')
				{
					
					$update_field['type']='Free shipping';
					
				}
				
				else if($types=='Buy_X_Y')
				{
					
					$update_field['type']='Buy X get Y';
					
				}
				else
				{
					$update_field['type']='';
					
				}
				
								
				
				$update_field['start_date']=$start_date;
				$update_field['exp_date']=$exp_date;
				$update_field['msg']=$msg;
				$update_field['admin_note']=$admin_note;
				
				$obj_model_coupon = $this->app->load_model("coupon");
				$obj_model_coupon->map_fields($update_field);
				$upd_id=$obj_model_coupon->execute("UPDATE",false,"","id='".$id."'");
				
				

				if($upd_id>0){
					
					
					
					
					$update_field_o=array();

					if($applies_item=='Specific Items')
					{
						$update_field_o['item_ids']=$item_items;
					}
					else
					{
						$update_field_o['item_ids']='';
					}
					
					if($types=='Percentage'  || $types=='Fixed_Amount')
					{
						if($applies_type=='Specific_Category')
						{
							$update_field_o['category_ids']=$works;
							$update_field_o['product_ids']='';
						}
						else if($applies_type=='Specific_Products')
						{
							$update_field_o['product_ids']=$products_ids_data;
							$update_field_o['category_ids']='';
						}
						else
						{
							$update_field_o['product_ids']='';
							$update_field_o['category_ids']='';
							
						}
						
						if($customer_types=='Specific_Customers')
						{
							$update_field_o['customer_ids']=$customer_ids_data;
						}
						else
						{
							$update_field_o['customer_ids']='';
							
						}
						
						$update_field_o['buy_quantity']='';
						$update_field_o['get_quantity']='';
						$update_field_o['get_product_ids']='';
						$update_field_o['get_discount_value']='';
						
						$update_field_o['exclude_shipping_rate']=0;
						
					}
					else if($types=='Free_Shipping')
					{
						
						
						
						if($applies_type=='Specific_Category')
						{
							$update_field_o['category_ids']=$works;
							$update_field_o['product_ids']='';
						}
						
						
						if($exclude_shiping_type=='Exclude Shipping')
						{
							$update_field_o['exclude_shipping_rate']=$exclude_shipping_rate_value;
							
						}
						else
						{
							$update_field_o['exclude_shipping_rate']=0;
						}
						
						if($customer_types=='Specific_Customers')
						{
							$update_field_o['customer_ids']=$customer_ids_data;
						}
						else
						{
							$update_field_o['customer_ids']='';
							
						}
						
						
						//$update_field_o['product_ids']='';
						//$update_field_o['category_ids']='';
						
						
						$update_field_o['buy_quantity']='';
						$update_field_o['product_ids']='';						
						$update_field_o['get_quantity']='';
						$update_field_o['get_product_ids']='';						
						$update_field_o['get_discount_value']='';
						
						
					}
					
					else if($types=='Buy_X_Y')
					{
						
						$update_field_o['buy_quantity']=$buy_quantity;
						$update_field_o['product_ids']=$products_buy_ids_data;						
						$update_field_o['get_quantity']=$get_quantity;
						$update_field_o['get_product_ids']=$products_get_ids_data;						
						$update_field_o['get_discount_value']=$get_discount_value;
												
						$update_field_o['category_ids']='';
						$update_field_o['exclude_shipping_rate']=0;
						$update_field_o['customer_ids']='';
							
						
						
						
					}
					
					
					if($once_per_customer_type=='once_per_customer')
					{
						$update_field_o['once_per_customer']='Yes';
					}
					else
					{
						$update_field_o['once_per_customer']='No';
					}
										
					
					if($use_limit_type=='use_limit')
					{
						$update_field_o['use_limit']=$use_limit_value;
					}
					else
					{
						$update_field_o['use_limit']=0;
					}
					
					
					
					$obj_model_coupon_info = $this->app->load_model("coupon_info");
					$obj_model_coupon_info->map_fields($update_field_o);
					$obj_model_coupon_info->execute("UPDATE",false,"","coupon_id='".$id."'");
					
					

					$this->app->utility->set_message("records updated successfull", "SUCCESS");
					$this->app->redirect("index.php?view=coupon_list");

				}else{

					$this->app->utility->set_message("Ooops... There was a problem in update records", "ERROR");

					$this->app->redirect("index.php?view=coupon_list");

				}

			}else{

				//INSERT RECORDS
				
				
								
				

				$obj_model_coupon_code = $this->app->load_model("coupon");
				$rscoupon_code = $obj_model_coupon_code->execute("SELECT",false,"","coupon_code='".$code."'  and vendor_id='".$_SESSION['partner']."' and status!='Trash'");

				
				if(count($rscoupon_code)>0)
				{

					$this->app->utility->set_message("This coupon code already exist.", "ERROR");
					$this->app->redirect("index.php?view=discountcode_addedit");
					exit;				
				}
				
				
				
				
				
				
				
				
				
				
				$update_field = array();
				$update_field['coupon_code']=$code;
				$update_field['vendor_id']=$_SESSION['partner'];
				
				
				if($types=='Percentage')
				{
					$update_field['type']='Percentage';
										
				}
				else if($types=='Fixed_Amount')
				{
					
					$update_field['type']='Fixed amount';
					
				}
				else if($types=='Free_Shipping')
				{
					
					$update_field['type']='Free shipping';
					
				}
				
				else if($types=='Buy_X_Y')
				{
					
					$update_field['type']='Buy X get Y';
					
				}
				else
				{
					$update_field['type']='';
					
				}
				
								
				
				$update_field['start_date']=$start_date;
				$update_field['exp_date']=$exp_date;
				$update_field['msg']=$msg;
				$update_field['admin_note']=$admin_note;
				
				$obj_model_coupon = $this->app->load_model("coupon");
				$obj_model_coupon->map_fields($update_field);
				$coupon_id=$obj_model_coupon->execute("INSERT");

				if($coupon_id>0){
					
					
					
					$update_field_o=array();
					$update_field_o['coupon_id']=$coupon_id;

					if($applies_item=='Specific Items')
					{
						$update_field_o['item_ids']=$item_items;
					}
					else
					{
						$update_field_o['item_ids']='';
					}
					
					if($types=='Percentage'  || $types=='Fixed_Amount')
					{
						if($applies_type=='Specific_Category')
						{
							$update_field_o['category_ids']=$works;
							$update_field_o['product_ids']='';
						}
						else if($applies_type=='Specific_Products')
						{
							$update_field_o['product_ids']=$products_ids_data;
							$update_field_o['category_ids']='';
						}
						else
						{
							$update_field_o['product_ids']='';
							$update_field_o['category_ids']='';
							
						}
						
						if($customer_types=='Specific_Customers')
						{
							$update_field_o['customer_ids']=$customer_ids_data;
						}
						else
						{
							$update_field_o['customer_ids']='';
							
						}
						
						$update_field_o['buy_quantity']='';
						$update_field_o['get_quantity']='';
						$update_field_o['get_product_ids']='';
						$update_field_o['get_discount_value']='';
						
						$update_field_o['exclude_shipping_rate']=0;
						
					}
					else if($types=='Free_Shipping')
					{
						
						
						
						if($applies_type=='Specific_Category')
						{
							$update_field_o['category_ids']=$works;
							$update_field_o['product_ids']='';
						}
						
						
						
						if($exclude_shiping_type=='Exclude Shipping')
						{
							$update_field_o['exclude_shipping_rate']=$exclude_shipping_rate_value;
							
						}
						else
						{
							$update_field_o['exclude_shipping_rate']=0;
						}
						
						if($customer_types=='Specific_Customers')
						{
							$update_field_o['customer_ids']=$customer_ids_data;
						}
						else
						{
							$update_field_o['customer_ids']='';
							
						}
						
						
						
						
						
						$update_field_o['buy_quantity']='';
						$update_field_o['product_ids']='';						
						$update_field_o['get_quantity']='';
						$update_field_o['get_product_ids']='';						
						$update_field_o['get_discount_value']='';
						
						
					}
					
					else if($types=='Buy_X_Y')
					{
						
						$update_field_o['buy_quantity']=$buy_quantity;
						$update_field_o['product_ids']=$products_buy_ids_data;						
						$update_field_o['get_quantity']=$get_quantity;
						$update_field_o['get_product_ids']=$products_get_ids_data;						
						$update_field_o['get_discount_value']=$get_discount_value;
												
						$update_field_o['category_ids']='';
						$update_field_o['exclude_shipping_rate']=0;
						$update_field_o['customer_ids']='';
							
						
						
						
					}
					
					
					if($once_per_customer_type=='once_per_customer')
					{
						$update_field_o['once_per_customer']='Yes';
					}
					else
					{
						$update_field_o['once_per_customer']='No';
					}
										
					
					if($use_limit_type=='use_limit')
					{
						$update_field_o['use_limit']=$use_limit_value;
					}
					else
					{
						$update_field_o['use_limit']=0;
					}
					
					
					
					$obj_model_coupon_info = $this->app->load_model("coupon_info");
					$obj_model_coupon_info->map_fields($update_field_o);
					$obj_model_coupon_info->execute("INSERT");
					
					
					

					$this->app->utility->set_message("Record Added Successfull", "SUCCESS");
					$this->app->redirect("index.php?view=coupon_list");

				}else{

					$this->app->utility->set_message("Please Try Again.", "ERROR");
					$this->app->redirect("index.php?view=coupon_list");

				}

				

			}

		}

		

	}	

?>