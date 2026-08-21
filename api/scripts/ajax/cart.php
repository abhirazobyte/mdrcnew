<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$action_type=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("actionType"));
$osType='Web';
$ip=$_SERVER['REMOTE_ADDR'];
// Login Flow
$homeCollectionHtml='<input type="hidden" name="home_collection" id="home_collection" value="No">';
if($action_type=='cartItemCollectionStatus')
{
	$status_type=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("status_type"));
	if($status_type!='')
	{
		$_SESSION['HomeCollection']	=$status_type;
		$_SESSION['HomeCollectionModalShow']='No';
	}
	echo $obj_json->encode(array("RESULT"=>"OK"));
	exit;
}
if($action_type=='cartItems')
{
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond="customer_cart.session_id='".session_id()."'";
	}
	$obj_model_tmp_cartmini = $app->load_model("customer_cart");
	$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","line1","pincode","area_id","area"), array("customer_members_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("item_other_data", "left", array("item_type_id"), array("cart_item_id"=>"item_id"));
	$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
	if(count($rs_cartmini)>0)
	{
		$subtotal=0;
		$html='';
		$depIDs=array();
		for($i=0;$i<count($rs_cartmini);$i++)
		{

			$item_type_id=$rs_cartmini[$i]['item_other_data_item_type_id'];
			if($item_type_id==1)
			{
				$item_type_name="package";
			}
			else
			{
				$item_type_name="test";
			}
			$depIDs[]=$rs_cartmini[$i]['cart_item_department_ids'];
			$itemName=$rs_cartmini[$i]['cart_item_name'];
			$testCount=$rs_cartmini[$i]['item_test_count'];
			$cartID=$rs_cartmini[$i]['id'];
			$cart_item_id=$rs_cartmini[$i]['cart_item_id'];
			$price=$rs_cartmini[$i]['cart_item_price'];
			$mrp=$rs_cartmini[$i]['cart_item_mrp'];
			$customer_members_id=$rs_cartmini[$i]['customer_members_id'];
			$prescription_require=$rs_cartmini[$i]['prescription_require'];
			$prescription_data=$rs_cartmini[$i]['prescription_data'];
			$sch_price=$rs_cartmini[$i]['item_price_sch_price'];
			$sch_start_date=$rs_cartmini[$i]['item_price_sch_start_date'];
			$sch_end_date=$rs_cartmini[$i]['item_price_sch_end_date'];
			if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
			{
				$today_date=date('d-m-Y');
				$todaySlot=strtotime($today_date);
				$startSlot=strtotime($sch_start_date);
				$endSlot=strtotime($sch_end_date);
				if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
				{
					$price=$sch_price;
				}
			}
			$cart_line_total=$rs_cartmini[$i]['cart_line_total'];
			if($price!=$rs_cartmini[$i]['cart_item_price'])
			{
				$cart_line_total=$price*$rs_cartmini[$i]['cart_qty'];
				$obj_model_tmp_cart11 = $app->load_model("customer_cart");
				$obj_model_tmp_cart11->execute("UPDATE",false,"UPDATE customer_cart SET cart_item_price='".$price."',cart_line_total='".$cart_line_total."' WHERE customer_cart.id='".$rs_cartmini[$i]['id']."'","");
			}
			$subtotal=$subtotal+$cart_line_total;
			$price_html=''.$app->utility->moneyFormatIndia($price).'';
			if($mrp>0 && $mrp>$price)
			{
				$price_html.=' <del>'.$app->utility->moneyFormatIndia($mrp).'</del>';
			}
			$memberSatisfy='No';
			if($customer_members_id>0 && $rs_cartmini[$i]['customer_members_first_name']!='')
			{
				$line1=$rs_cartmini[$i]['customer_members_line1'];
				$area=$rs_cartmini[$i]['customer_members_area'];
				$pincode=$rs_cartmini[$i]['customer_members_pincode'];
				$obj_model_tble = $app->load_model("pincode");
				$obj_model_tble->join_table("state", "left", array("name"), array("state_id"=>"id"));
				$obj_model_tble->join_table("city", "left", array("name"), array("city_id"=>"id"));
				$rs_pincode_data= $obj_model_tble->execute("SELECT", false, "", "pincode.name='".$pincode."'","pincode.id DESC");
				$city=$rs_pincode_data[0]['city_name'];
				$state=$rs_pincode_data[0]['state_name'];
				$member_html='<a class="vtest-btn text-dark d-inline-block w-100 mb-2 cartMemberRemove" data-id="'.$cartID.'" href="javascript:void(0)">'.$rs_cartmini[$i]['customer_members_prefix'].' '.$rs_cartmini[$i]['customer_members_first_name'].' '.$rs_cartmini[$i]['customer_members_last_name'].' | '.$rs_cartmini[$i]['customer_members_relation'].'<br/><span class=" ">'.$line1.', '.$area.','.$city.' - '.$pincode.', '.$state.'</span>  <i class="far float-end fa-times-circle"></i></a>';
				$memberSatisfy='Yes';
			}
			else
			{
				if($_SESSION['MDRCCustID']>0)
				{
					$extraItemsHtml=' href="javascript:void(0)" data-id="'.$cartID.'"' ;
					$memberSelectClass='customerMemberSelect';
				}
				else
				{
					$extraItemsHtml='data-bs-toggle="offcanvas" href="#offcanvasExample-login"';
					$memberSelectClass='';
				}
				$member_html='<a class="adpatient d-inline-block border-end text-blue mt-2 mb-2 '.$memberSelectClass.'" '.$extraItemsHtml.'><i class="fas fa-plus me-2"></i> Add patients for this '.$item_type_name.'</a>';
			}
			$prescription_html='';
			$prescriptionSatisfy='No';
			if($prescription_require=='Yes')
			{
				if($prescription_data!='')
				{
					$prescription_html='<div class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Prescription Info <a class="float-end vdet text-blue prescriptionView" data-id="'.$cartID.'">View Details</a> <a class="float-end vdet text-blue prescriptionRemove" data-id="'.$cartID.'"><i class="far float-end fa-times-circle"></i></a></div>';
					$prescriptionSatisfy='Yes';
				}
				else
				{
					if($_SESSION['MDRCCustID']>0)
					{
						$extraItemsHtml=' href="javascript:void(0)" data-id="'.$cartID.'"' ;
						$preSelectClass='prescriptionSelect';
					}
					else
					{
						$extraItemsHtml='data-bs-toggle="offcanvas" href="#offcanvasExample-login"';
						$preSelectClass='';
					}
					$prescription_html='<a class="adpatient d-inline-block text-blue mt-2 mb-2 '.$preSelectClass.'" '.$extraItemsHtml.'><i class="fas fa-plus me-2"></i> Add Prescription</a>';
				}
			}
			else
			{
				$prescriptionSatisfy='Yes';
			}
			if($prescriptionSatisfy=='Yes' && $memberSatisfy=='Yes')
			{
				$other_class='col-lg-12 ps-3 pe-3';
			}
			else
			{
				$other_class='col-lg-12 p-0 border-top';
			}
			$other_html='<div class="'.$other_class.'">
							'.$member_html.' '.$prescription_html.'
						</div>';
			$html.='<div class="col-lg-12 bg-white shadow-normal mb-3">
	      				<div class="col-lg-12 bg-white  d-flex p-3">
      						<div class="packname">
      							<h4>'.$itemName.' <a class="ms-2 itemsDetails" data-id="'.$cart_item_id.'"><i class="fas fa-chevron-down text-black"></i></a><br><span>Includes '.$testCount.' Tests</span></h4>
      						</div>
      						<div class="pricdiv ms-auto">
								<h5><span class="float-end">'.$price_html.'</span></h5>
							</div>
							<a class="delbtn float-end ms-3 mt-1 cartDelete" data-id="'.$cartID.'" href="javascript:void(0)"><i class="far fa-trash-alt"></i></a>
						</div>
	      				'.$other_html.'
					</div>';
		}

		$RESULT='OK';
		$final_ids=array_unique($depIDs);
		$depID=implode(',',$final_ids);
		$obj_model_tble = $app->load_model("item_department");
		$rs_check_home_collection= $obj_model_tble->execute("SELECT", false, "", "id IN (".$depID.") and status='Active' and home_collection='Yes'");
		if(count($rs_check_home_collection)>0)
		{
			if($_SESSION['HomeCollection']=='Yes')
			{
				$checked="checked";
			}
			else
			{
				$checked='';
			}
			$homeCollectionDisable=["15","16","17"];
			if(in_array($_SESSION['cityID'],$homeCollectionDisable)) {
				$disable="disabled";
			}else { $disable='';}
			$homeCollectionHtml='<div class=" newpart">
										<div class="cart-extra-sevc d-flex div-for-data">
												<img class="img_del_boy" src="images/Dlrvry_Boy.png" alt="">
												<h6 class="mb-0 pb-1 ">Sample Home Collection Service.
													<p class="text-202024 font-weight-normal tx-14">Blood tests can be done through home blood sample collection services.</p>
												</h6>
												<div class="custom-control custom-checkbox float-right">
													<input onclick="changeHomeCollection()" type="checkbox" '.$disable.' class="custom-control-input" id="home_collection" name="home_collection" value="Yes" '.$checked.'>
													<label class="custom-control-label" for="customCheck-Promo"></label>
												</div>
										</div>
									</div>';
		}
	}
	else
	{
		$_SESSION['HomeCollection']='';
		$html='<div class="col-lg-12 bg-white shadow-normal mb-3 pb-4">
<div class="col-lg-12 text-center">
				<img class="carimg" src="images/empry-cart-main.png" />
				<h5 class="mt-0">Your Cart is Empty!</h5>
				<p class="fs-14">There are no test and package in your cart. Explore and add it!</p>
			</div>
					</div>';
		$RESULT='OK';
		$subtotal='0.00';
	}
	$subtotal=number_format($subtotal,'2','.','');
	$subtotal=$app->utility->moneyFormatIndia($subtotal);
	echo $obj_json->encode(array("RESULT"=>$RESULT,"html"=>$html,"subtotal"=>$subtotal,"homeCollectionHtml"=>$homeCollectionHtml,"cartCount"=>count($rs_cartmini)));
	exit;
}
if($action_type=='cartItemsDelete')
{
	$id=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("id"));
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond=" and customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond=" and customer_cart.session_id='".session_id()."'";
	}
	$obj_model_tmp_cartmini = $app->load_model("customer_cart");
	$rsDelete = $obj_model_tmp_cartmini->execute("DELETE", false, "", "customer_cart.id='".$id."' ".$customerCond."");
	if($rsDelete)
	{
		$RESULT='OK';
	}
	else
	{
		$RESULT='NOK';
	}
	echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
	exit;
}
if($action_type=='cartItemMemberAssign')
{
	$membersID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("membersID"));
	$cartID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cartID"));
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond=" and customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond=" and customer_cart.session_id='".session_id()."'";
	}
	if($membersID>0 && $cartID>0)
	{
		//check memeber and current city match
		$obj_model_customer_members  = $app->load_model("customer_members");
		$obj_model_customer_members->join_table("city", "left", array(), array("city_id"=>"id"));
		$selected_member = $obj_model_customer_members->execute("SELECT", false, "","customer_members.id='".$membersID."'");
		if($selected_member[0]['city_name']!=$_SESSION['cityName'])
		{
			$RESULT='NOK';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>'Selected Patient Address not match with Selected City.'));
			exit;
		}

		//check test gender condition
		$obj_model_item_detail = $app->load_model("customer_cart");
		$obj_model_item_detail->join_table("item_description", "left", array(), array("cart_item_id"=>"item_id"));
		$item_detail = $obj_model_item_detail->execute("SELECT", false, "","customer_cart.id='".$cartID."'");
		if($item_detail[0]['item_description_gender']=='Male' && $selected_member[0]['gender']!='Male')
		{
			$RESULT='NOK';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>'Selected Test is only for Male.'));
			exit;
		}

		if($item_detail[0]['item_description_gender']=='Female' && $selected_member[0]['gender']!='Female')
		{
			$RESULT='NOK';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>'Selected Test is only for Female.'));
			exit;
		}

		$obj_model_tmp_cartmini = $app->load_model("customer_cart");
		$rsUpdate = $obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET customer_members_id='".$membersID."' WHERE customer_cart.id='".$cartID."' ".$customerCond."");
		if($rsUpdate)
		{
			$RESULT='OK';
		}
		else
		{
			$RESULT='NOK';
		}
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
	else
	{
		$RESULT='NOK';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
}
if($action_type=='cartMemberRemove')
{
	$cartID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cartID"));
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond=" and customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond=" and customer_cart.session_id='".session_id()."'";
	}
	if($cartID>0)
	{
		$obj_model_tmp_cartmini = $app->load_model("customer_cart");
		$rsUpdate = $obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET customer_members_id=0 WHERE customer_cart.id='".$cartID."' ".$customerCond."");
		if($rsUpdate)
		{
			$RESULT='OK';
		}
		else
		{
			$RESULT='NOK';
		}
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
	else
	{
		$RESULT='NOK';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
}
if($action_type=='cartItemsCheck')
{
	$home_collection=$app->getPostVar("home_collection");
	$_SESSION['homeCollection']=$home_collection;
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond="customer_cart.session_id='".session_id()."'";
	}
	$obj_model_tmp_cartmini = $app->load_model("customer_cart");
	$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation"), array("customer_members_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
	$obj_model_tmp_cartmini->join_table("item_other_data", "left", array("item_type_id"), array("cart_item_id"=>"item_id"));
	$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
	if(count($rs_cartmini)>0)
	{
		$item_lab_ids=[];

		$lab_value_counts = array();
    	$total_labs_count = count($rs_cartmini);

		for($i=0;$i<count($rs_cartmini);$i++)
		{

			$values = explode(',', $rs_cartmini[$i]['item_price_item_lab_ids']);
			foreach ($values as $value) {
				$value = trim($value); // Remove any extra spaces
				if (isset($lab_value_counts[$value])) {
					$lab_value_counts[$value]++;
				} else {
					$lab_value_counts[$value] = 1;
				}
			}

			$item_lab_ids=array_merge($item_lab_ids,array_unique(explode(',',$rs_cartmini[$i]['item_price_item_lab_ids'])));
			$item_type_id=$rs_cartmini[$i]['item_other_data_item_type_id'];
			if($item_type_id==1)
			{
				$item_type_name="package";
			}
			else
			{
				$item_type_name="test";
			}
			$subtotal=$subtotal+$rs_cartmini[$i]['cart_line_total'];
			$itemName=$rs_cartmini[$i]['cart_item_name'];
			$testCount=$rs_cartmini[$i]['item_test_count'];
			$cartID=$rs_cartmini[$i]['id'];
			$cart_item_id=$rs_cartmini[$i]['cart_item_id'];
			$price=$rs_cartmini[$i]['cart_item_price'];
			$mrp=$rs_cartmini[$i]['cart_item_mrp'];
			$customer_members_id=$rs_cartmini[$i]['customer_members_id'];
			$prescription_require=$rs_cartmini[$i]['prescription_require'];
			$prescription_data=$rs_cartmini[$i]['prescription_data'];
			$memberSatisfy='No';
			if($customer_members_id>0 && $rs_cartmini[$i]['customer_members_first_name']!='')
			{
				$memberSatisfy='Yes';
			}
			$prescription_html='';
			$prescriptionSatisfy='No';
			if($prescription_require=='Yes')
			{
				if($prescription_data!='')
				{
					$prescription_html='';
					$prescriptionSatisfy='Yes';
				}
			}
			else
			{
				$prescriptionSatisfy='Yes';
			}
			if($prescriptionSatisfy=='Yes' && $memberSatisfy=='Yes')
			{
			}
			else
			{
				if($memberSatisfy=='No')
				{
					$html='Please add patient for this '.$item_type_name.' (<strong>'.$itemName.'</strong>)';
				}
				else
				{
					$html='Please add prescription for this '.$item_type_name.' (<strong>'.$itemName.'</strong>)';
				}
				$RESULT='NOK';
				echo $obj_json->encode(array("RESULT"=>$RESULT,"html"=>$html,"subtotal"=>$subtotal));
				exit;
			}
		}
		//find common labes in all test
		$common_labs = array();
		foreach ($lab_value_counts as $value => $count) {
			if ($count == $total_labs_count) {
				$common_labs[] = $value;
			}
		}
		
		$unique_item_lab_ids=array_filter(array_unique($item_lab_ids));
		//if(count($unique_item_lab_ids)>1 && count($rs_cartmini)>1)
		if(empty($common_labs) && count($rs_cartmini)>1)
		{
			//get lab name
			$obj_model_lab = $app->load_model("item_lab");
			$rs_lab = $obj_model_lab->execute("SELECT", false, "", " id in (".implode(',',$unique_item_lab_ids).")","");
			
			foreach($rs_lab as $item_lab)
			{
				$lab[$item_lab['id']]=$item_lab['name'];
			}

			$lab_error_msg='Please book the tests mentioned below individually.<br/>';
			foreach($rs_cartmini as $item)
			{
				if($item['item_price_item_lab_ids']!='')
				{
					$lab_ids=explode(',',$item['item_price_item_lab_ids']);
					$lab_ava='';
					foreach($lab_ids as $lab_ids)
					{
						$lab_ava.=$lab[$lab_ids].',';
					}

					$lab_error_msg.='Test <strong>'.$item['cart_item_name'].'</strong> is available only in '.$lab_ava.'<br/>';
				}
			}
		
			$html=$lab_error_msg;
			$RESULT='NOK';
			echo $obj_json->encode(array("RESULT"=>$RESULT,"html"=>$html,"subtotal"=>$subtotal));
			exit;
		}
		$RESULT='OK';
		$html='';
		$URL=SERVER_ROOT.'/checkout';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"html"=>$html,"URL"=>$URL));
		exit;
	}
	else
	{
		$html='Please add items in cart.';
		$RESULT='NOK';
		$URL='';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"html"=>$html,"URL"=>$URL));
		exit;
	}
}
if($action_type=='prescripttionAddEdit')
{
	$cartID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cartID"));
	if(empty($_FILES['img_logo']['name']))
	{
		echo $obj_json->encode(array("RESULT"=>"1","msg"=>"Please Upload Prescription File."));
		exit;
	}
	$upload_dir="prescription";
	$banner_img11=$app->utility->resize_multi_image_2020($_FILES['img_logo']['name'],$_FILES['img_logo']['tmp_name'],'../../uploads/'.$upload_dir.'/','400','800','100');
	$obj_model_tmp_cartmini = $app->load_model("customer_cart");
	$rsUpdate = $obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET prescription_data='".$banner_img11."' WHERE customer_cart.id='".$cartID."'");
	echo $obj_json->encode(array("RESULT"=>"0","msg"=>"Success"));
	exit;
}
if($action_type=='cartPrescriptionRemove')
{
	$cartID=mysqli_real_escape_string($app->set_db_conn(),$app->getPostVar("cartID"));
	if($_SESSION['MDRCCustID']>0)
	{
		$customerCond=" and customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
	}
	else
	{
		$customerCond=" and customer_cart.session_id='".session_id()."'";
	}
	if($cartID>0)
	{
		$obj_model_tmp_cartmini = $app->load_model("customer_cart");
		$rsUpdate = $obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET prescription_data='' WHERE customer_cart.id='".$cartID."' ".$customerCond."");
		if($rsUpdate)
		{
			$RESULT='OK';
		}
		else
		{
			$RESULT='NOK';
		}
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
	else
	{
		$RESULT='NOK';
		echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>''));
		exit;
	}
}
echo $obj_json->encode(array("RESULT"=>$RESULT,"MSG"=>$MSG));
?>