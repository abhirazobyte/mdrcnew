<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for active zone datatbale loading

if($get_actionType=="order_list")

{

	

	$current_status=$app->getGetVar("current_status");

	

	if($current_status!='')
	{

		$status_cond=" AND order_status='".$current_status."'";

	}
	else
	{

		$status_cond="";

	}

	

	

	

	

			
	

	

	

	

	$table_name='customer_order_master';



	## Read value

	$draw = $app->getPostVar('draw');

	$row = $app->getPostVar('start');

	$rowperpage = $app->getPostVar('length'); // Rows display per page

	$orderArray = $app->getPostVar('order');

	$columnIndex = $orderArray[0]['column']; // Column index

	

	$columnArray = $app->getPostVar('columns');

	$columnName = $columnArray[$columnIndex]['data']; // Column name

	

	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')

	{

		$columnName='id';

	}

	

	$columnSortorder = $orderArray[0]['dir']; // asc or desc

	

	$searchArray=$app->getPostVar('search');

	$searchValue = $searchArray['value']; // Search value

	

	## Search 

	$searchQuery = " ";

	if($searchValue != '')

	{

		$searchQuery = " and (	

		".$table_name.".id like '".$searchValue."%' or 

		".$table_name.".display_order_no like '".$searchValue."%' or 

		customer.name like '%".$searchValue."%' or
		customer.last_name like '%".$searchValue."%' or

		customer.phone like '%".$searchValue."%' or

		 
		 
		

		

		".$table_name.".order_status like '%".$searchValue."%' 

		

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where ".$table_name.". id!=0 ".$status_cond."");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,customer.name AS customer_name,customer.last_name AS customer_last_name,customer.phone AS customer_phone
	
	
	
	 from ".$table_name."
LEFT JOIN customer AS customer ON(customer.id=".$table_name.".customer_id) 



where  ".$table_name.".id!=0 ".$status_cond."  ".$searchQuery);	

	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("customer", "left", array( "name","phone","last_name"), array("customer_id"=>"id"));	
	//$obj_brand->join_table("vendor", "left", array( "company_name","company_phone"), array("vendor_id"=>"id"));	
	
//	$obj_brand->join_table("webadmin", "left", array( "first_name","last_name","phone"), array("delivery_boy_id"=>"id"));	

	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0 ".$status_cond." ".$sql_city_cond." ".$sql_order_date." ".$sql_del_date."  ".$searchQuery.""," ".$columnName." ".$columnSortorder." limit ".$row.",".$rowperpage." ");

	$data = array();

	for($i=0;$i<count($result);$i++)

	{
		
											$item=$result[$i];
											$order_from=$item['order_from'];
											$displayID=$item['display_order_no'];
											
											
											
											$customer_name=$item['customer_name'].' '.$item['customer_last_name'].'<br/>'.$item['customer_phone'];
											
											
											
											$order_total=$item['net_order_value'];													
											
																				
											$payment_type=$item['payment_type'];
											$payment_status=$item['payment_status'];
											
																					
														
											
											
											
											$book_date=$item['order_date'];										
											$status=$item['order_status'];
											
											$o_day=date("l", strtotime($book_date));
											$o_date=date("d M Y", strtotime($book_date));
											
											
											$delivery_date=$item['delivery_date'];
											$delivery_time=$item['delivery_time'];	
											
											//$ap_day=date("l", strtotime($appointment_date));
											
											//$ap_date=date("d M Y", strtotime($appointment_date));
											
											
											
											
										
											$order_admin_html='<b>'.$order_from.'</b>';
												
											
											
																						
											$order_date=$item['order_date']."<br/>".$order_type.$order_admin_html;
											
											
											
											
										
										
												$delivery_boy_name='';
												
												
											
											
											
											
											
											$schedule_text="".$delivery_date."<br/>".$delivery_time."".$delivery_boy_name;
								
											
											
											
											
											
											
											$total='<i class="fas fa-rupee-sign"></i>'.$order_total;
											
											
											
											
											
		
											
											
											
											
											$status=$app->utility->o_status_html2020($result[$i]['order_status']);
			
		
		
		
			$edit_btn='';
			
			if($result[$i]['order_status']=='Pending' || $result[$i]['order_status']=='Confirmed')
			{
				
				$edit_btn='<a href="index.php?view=create_order&id='.$result[$i]['id'].'" class="btn btn-xs btn-primary btn-icon mg-r-5 '.$edit_btn.'"><i class="fas fa-edit"></i></a>';	
				
												
												
			}
		
		


			
			
			
			
			

			
			
			$detail_btn='<a href="index.php?view=customer_order_detail&id='.$result[$i]['id'].'" class="btn btn-xs btn-info btn-icon mg-r-5"><i class="fas fa-play"></i></a>';	

$status_btn='<a href="javascript:void(0)" class="btn btn-xs btn-warning btn-icon order_delete_onclick  mg-r-5" data-id="'.$result[$i]['id'].'" ><i class="fas fa-cog"></i></a>';	

			if($result[$i]['order_status']=='Return' || $result[$i]['order_status']=='Canceled')
			{
			
				$status_btn='';

			
			}		
			
			
			
			if($result[$i]['order_status']=='Delivered' &&  $result[$i]['final_bill']=='Yes')
			{
				$status_btn='';
				
			}
			
			
			
			$print_btn='<a target="_blank" href="index.php?view=invoice_print&id='.$result[$i]['id'].'" class="btn btn-xs btn-success btn-icon mg-r-5" style="background:#868383;border-color:#868383"><i class="fas fa-print"></i></a>';
			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$detail_btn.' '.$status_btn.'  '.$print_btn.'</div></div>';
			
									
		
		
		
		
			

		//data

		$data[] = array

		(

			"id"=>'<a href="javascript:void(0)"  >'.$displayID.'</a>',

			"order_date"=>$order_date,


			"customer_name"=>$customer_name,

			
			

			

			"payment_type"=>$payment_type,

			"total"=>$total,

			"status"=>$status,

			"btn"=>$option

		);

	}

	
	

	## Response

	$response = array(

		"draw" => $draw,

		"iTotalRecords" => $totalRecords,

		"iTotalDisplayRecords" => $totalRecordwithFilter,

		"aaData" => $data

	);

		

	echo json_encode($response);

	exit;

}



if($actionType=="orderAddEdit")

{

	
	

	$remark_data=$app->getPostVar('remark_data');
	$status_order=$app->getPostVar('status_order');
	$delivery_boy_id1=$app->getPostVar('delivery_boy_id1');

	$id=$app->getPostVar('id');

	if($status_order!='' && $id!='')

	{
		
		
		
		
		/*if($status_order=='Dispatched')
		{
			if($delivery_boy_id1<=0 || $delivery_boy_id1=='')
			{
				$msg='Please Select Delivery Boy.';
				$msgcode=1;
				echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
				exit;
				
			}
			
		}
		*/
		
		
		$obj_model_partner_shop = $app->load_model("customer_order_master");
		$obj_model_partner_shop->join_table("customer", "left", array(), array("customer_id"=>"id"));
		//$obj_model_partner_shop->join_table("vendor", "left", array(), array("vendor_id"=>"id"));
		$rs_business = $obj_model_partner_shop->execute("SELECT",false,"","customer_order_master.id='".$id."' ".$cust_cond."","customer_order_master.id DESC limit 0,1","customer_order_master.id");
		
		$update_title='Updated';

		


		 //Insert Update Record

		$update_field = array();
		$update_field['order_status'] =$status_order;
		if($status_order=='Dispatched')
		{
			$update_field['delivery_boy_id'] =$delivery_boy_id1;
			
		}
		
		if($status_order=='Delivered')
		{
		
			$update_field['order_delivery_date']=date('d-m-Y H:i:s');
		
		
		}
		$obj_model_user = $app->load_model("customer_order_master");
		$obj_model_user->map_fields($update_field);
		$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id."'");
		
		
							$ip=$_SERVER['REMOTE_ADDR'];
														
							$update_field_shis = array();
							$update_field_shis["order_master_id"] = $id;
							$update_field_shis["customer_id"] = $rs_business[0]['customer_id'];
							
												
							$update_field_shis["o_status"] = $status_order;
							$update_field_shis["remark"] = $remark_data;
							$update_field_shis["remark_other"] = "From Admin";
							$update_field_shis["ip"] = $ip;
							$update_field_shis["entry_date"] = date('d-m-Y');
							$update_field_shis["entry_date_time"] = date('d-m-Y H:i:s');
							$update_field_shis["entry_from"] = 'Admin';
																		
							$obj_model_o_history= $app->load_model("customer_order_status_history");
							$obj_model_o_history->map_fields($update_field_shis);
							$ins=$obj_model_o_history->execute("INSERT");
							
							
							/*if($status_order=='Canceled')
							{
								
									$obj_order_order_detail = $app->load_model("order_detail");
									$cart_array=$obj_order_order_detail->execute("SELECT",false,"","order_master_id='".$id."'");
									
									foreach($cart_array as $item)
									{
											$product_id=$item["product_id"];
											$product_price_id=$item["product_price_id"];
											
											$obj_product = $app->load_model("product");
											$obj_product->join_table("product_option", "left", array(), array("id"=>"product_id"));
											$rs_product = $obj_product->execute("SELECT", false, "", "product_option.id=".$product_price_id."");
											
											
											
											$stock_update=$rs_product[0]["stock_update"];
											$stock_type=$rs_product[0]["stock_type"];
																
										
											$order_substitute_qty=$item["order_substitute_qty"];
																
											
											$qty=$item["quantity"];
											$total_stock_minus=$qty*$order_substitute_qty;
											
											
											
											if($stock_update=='Yes')
											{
												if($stock_type=='Single')
												{
													
													$current_stock=$rs_product[0]["master_stock"];
													$new_stock=$current_stock+$total_stock_minus;
													
													
													$obj_product_update = $app->load_model("product");
													$obj_product_update->execute("SELECT", false, "UPDATE product SET master_stock='".$new_stock."' WHERE id=".$product_id."");
													
												}
												else
												{
													$current_stock=$rs_product[0]["product_option_stock"];
													$new_stock=$current_stock+$total_stock_minus;
													
													
													$obj_product_update = $app->load_model("product_option");
													$obj_product_update->execute("SELECT", false, "UPDATE product_option SET stock='".$new_stock."' WHERE id=".$product_price_id."");
													
												}
												
																			
													
											}
																
											
											
											
											
									}
								
								
								
							}
							*/
							
							
							
							
						/*	
							if($status_order=='Delivered')
							{
								$delivery_boy_id1=$rs_business[0]['delivery_boy_id'];
								
							}
							
							
							$order_no=$rs_business[0]['display_order_no'];
							$bill_amount=$rs_business[0]['net_order_value'];
											
							$order_id=$rs_business[0]['id'];
							$customer_name=$rs_business[0]['customer_first_name'];
							$customer_phone=$rs_business[0]['customer_phone'];
							$amount=$rs_business[0]['net_order_value'];
							$adp_id=$rs_business[0]['adp_id'];
							$vendor_name=$rs_business[0]['vendor_company_name'];
							
							$adp_support_contact_data=$app->utility->get_adp_detail($adp_id);
							$adp_support_contact=$adp_support_contact_data['suport_phone'];
							
							
							if($delivery_boy_id1>0)
							{
								$delivery_boy_data=$app->utility->get_delivery_boy_detail($delivery_boy_id1);
								$delivery_person_name=$delivery_boy_data['first_name'];
								$delivery_person_contact=$delivery_boy_data['phone'];
								$delivery_token=$delivery_boy_data['fcm_token'];
								
							}
							else
							{
								$delivery_person_name='';
								$delivery_person_contact='';
								
							}
							
										
							
						    $sms_type=$app->utility->get_order_sms_type($status_order);
						    $support_contact=$_SESSION['support_contact'];
						    $default_sms_string=array("{name}","{order_id}","{partner_name}","{support_contact}","{adp_support_contact}","{delivery_person_name}","{delivery_person_contact}","{bill_amount}");
						    $new_sms_string= array($customer_name,$order_no,$vendor_name,$support_contact,$adp_support_contact,$delivery_person_name,$delivery_person_contact,$bill_amount);								
						    $app->utility->send_sms_new($customer_phone,$sms_type,$default_sms_string,$new_sms_string);
							
							
							
							
							
							
							
							
							
							
							
							
									// Customer Notifications
									
									$vendor_name=$rs_business[0]['vendor_company_name'];
						
									$customer_name=$rs_business[0]['customer_first_name'];
									$vendor_id=$rs_business[0]['vendor_id'];
									$customer_id=$rs_business[0]['customer_id'];
									
									$Title="Oshoppingsathi";
									$MESSAGE=$app->utility->get_order_noti_msg($customer_name,$order_no,$vendor_name,$status_order);
									
									
									
									
									
									
									
									
									
										if($status_order=='Delivered')
										{
											
											if($MESSAGE!='')
											{
											
												$vendorID1=$app->utility->encrypt($vendor_id);
												$custID1=$app->utility->encrypt($customer_id);
												$orderID1=$order_id;
												$image='';
												$from='App';
												$data=array('type'=>'OrderFeedback','vendorID'=>$vendorID1,"custID"=>$custID1,"orderID"=>$orderID1,'title'=>$Title,'image'=>$image,'message'=>$MESSAGE);
												
												$app->utility->add_push_notification_customer($customer_id,$data,$from);	
											
											
											}
											
											
											
												// Vendor Notification
						
												$vendor_name=$rs_business[0]['vendor_company_name'];
												$vendor_id=$rs_business[0]['vendor_id'];
												$customer_id=$rs_business[0]['customer_id'];
												$order_id=$rs_business[0]['id'];
												
												$Title="Oshoppingsathi";
												$MESSAGE="Dear ".$vendor_name.",Order(#".$order_no.") Delivered.";
												
												$vendorID1=$app->utility->encrypt($vendor_id);
												$custID1=$app->utility->encrypt($customer_id);
												$orderID1=$app->utility->encrypt($order_id);
												$image='';
												$from='App';
																					
												$data=array('type'=>'Order_Detail','vendorID'=>$vendorID1,"custID"=>$custID1,"orderID"=>$orderID1,'title'=>$Title,'image'=>$image,'message'=>$MESSAGE);
												
												$app->utility->add_push_notification_vendor($vendor_id,$data,$from);
											
											
											
											
											
											
										
											
										}
										else
										{
											
											
											
											
											
											
											
											
											
											
											
												
											if($MESSAGE!='')
											{
											
												$vendorID1=$app->utility->encrypt($vendor_id);
												$custID1=$app->utility->encrypt($customer_id);
												$orderID1=$order_id;
												$image='';
												$from='App';
												$data=array('type'=>'Order_Detail','vendorID'=>$vendorID1,"custID"=>$custID1,"orderID"=>$orderID1,'title'=>$Title,'image'=>$image,'message'=>$MESSAGE);
												
												$app->utility->add_push_notification_customer($customer_id,$data,$from);	
											
											
											}
										
										
										
										}
									
									
									
									
									
									
									
									
									
									
									
									if($status_order=='On Delivery')
									{
										
										// Vendor Notification
						
										$vendor_name=$rs_business[0]['vendor_company_name'];
										$vendor_id=$rs_business[0]['vendor_id'];
										$customer_id=$rs_business[0]['customer_id'];
										$order_id=$rs_business[0]['id'];
										
										$Title="Oshoppingsathi";
										$MESSAGE="Dear ".$vendor_name.",Order(#".$order_no.") Collected by Delivery Boy.";
										
										$vendorID1=$app->utility->encrypt($vendor_id);
										$custID1=$app->utility->encrypt($customer_id);
										$orderID1=$app->utility->encrypt($order_id);
										$image='';
										$from='App';
																			
										$data=array('type'=>'Order_Detail','vendorID'=>$vendorID1,"custID"=>$custID1,"orderID"=>$orderID1,'title'=>$Title,'image'=>$image,'message'=>$MESSAGE);
										
										$app->utility->add_push_notification_vendor($vendor_id,$data,$from);
										
										
									
										
									}
									
									
									if($status_order=='Return')
										{
											
												// Vendor Notification
						
												$vendor_name=$rs_business[0]['vendor_company_name'];
												$vendor_id=$rs_business[0]['vendor_id'];
												$customer_id=$rs_business[0]['customer_id'];
												$order_id=$rs_business[0]['id'];
												
												$Title="Oshoppingsathi";
												$MESSAGE="Dear ".$vendor_name.",Order(#".$order_no.") Returned.";
												
												$vendorID1=$app->utility->encrypt($vendor_id);
												$custID1=$app->utility->encrypt($customer_id);
												$orderID1=$app->utility->encrypt($order_id);
												$image='';
												$from='App';
																					
												$data=array('type'=>'Order_Detail','vendorID'=>$vendorID1,"custID"=>$custID1,"orderID"=>$orderID1,'title'=>$Title,'image'=>$image,'message'=>$MESSAGE);
												
												$app->utility->add_push_notification_vendor($vendor_id,$data,$from);
											
											
											
										}
									
									
									
									
									if($status_order=='Dispatched')
									{
										
											if($delivery_token!='')
											{
								
																				
												
												$Title="Oshoppingsathi";
												$MESSAGE='New Order(#'.$order_no.') Assigned.';
												$image='';
												$data=array('title'=>$Title,'image'=>$image,'message'=>$MESSAGE,'type'=>'Order');
												$send_notice=$app->utility->add_push_notification_delivery_boy($data,$delivery_token);
								
												
								
											}

									}*/
									
															
							
							
							
							
							

		

		if($rs>0)

		{

			$msg="Record ".$update_title." Successfully.";

			$msgcode=0;

		 }

		 else

		 {

			$msg='Please Try Again.';

			$msgcode=1;

		 }

	}

	else

	{

			$msg='Please Fill Require Data';

			$msgcode=1;

	}

}




echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>
