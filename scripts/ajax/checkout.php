<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$action_type = mysqli_real_escape_string($app->set_db_conn(), $app->getPostVar("actionType"));
$osType = 'Web';
$ip = $_SERVER['REMOTE_ADDR'];
// Login Flow
$homeCollectionHtml = '<input type="hidden" name="home_collection" id="home_collection" value="No">';
if ($action_type == 'cartItems') 
{
	if ($_SESSION['MDRCCustID'] > 0) {
		$customerCond = "customer_cart.customer_id='" . $_SESSION['MDRCCustID'] . "'";
	} else {
		$customerCond = "customer_cart.session_id='" . session_id() . "'";
	}
	$obj_model_tmp_cartmini = $app->load_model("customer_cart");
	$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id" => "id"));
	$obj_model_tmp_cartmini->join_table("item_other_data", "left", array('item_department_ids'), array("cart_item_id" => "item_id"));
	$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix", "first_name", "last_name", "gender", "relation", "line1", "pincode", "area_id", "area"), array("customer_members_id" => "id"));
	$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id" => "id"));
	$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "" . $customerCond . "", "customer_cart.id DESC");
	if (count($rs_cartmini) > 0) {
		$subtotal = 0;
		$html = '';
		$depIDs = array();
		$step_third_heading = '';
		$boolean_radiology = false;
		$boolean_pathology = false;
		$minAdvanceAmount=0;
		for ($i = 0; $i < count($rs_cartmini); $i++) {
			//if radiology then Radiology priority else other
			if (in_array('1', explode(',', $rs_cartmini[$i]['item_other_data_item_department_ids']))) {
				$step_third_heading = ' Nearby Diagnostic Centre for Radiology Imaging Test';
				$boolean_radiology = true;
			}
			if ($rs_cartmini[$i]['item_other_data_item_department_ids'] == 2 && $step_third_heading == '') {
				$step_third_heading = 'Select Near By Lab/Collection Point' . $test;
				$boolean_pathology = true;
			}
			if ($boolean_pathology && $boolean_radiology) {
				$step_third_heading = ' Nearby Diagnostic Centre for scheduling Radiology & Pathology test';
			}
			$depIDs[] = $rs_cartmini[$i]['cart_item_department_ids'];
			$subtotal = $subtotal + $rs_cartmini[$i]['cart_line_total'];
			$itemName = $rs_cartmini[$i]['cart_item_name'];
			$testCount = $rs_cartmini[$i]['item_test_count'];
			$cartID = $rs_cartmini[$i]['id'];
			$cart_item_id = $rs_cartmini[$i]['cart_item_id'];
			$price = $rs_cartmini[$i]['cart_item_price'];
			$mrp = $rs_cartmini[$i]['cart_item_mrp'];
			$customer_members_id = $rs_cartmini[$i]['customer_members_id'];
			$prescription_require = $rs_cartmini[$i]['prescription_require'];
			$prescription_data = $rs_cartmini[$i]['prescription_data'];
			$minAdvanceAmount += $rs_cartmini[$i]['item_min_price']>0 ? $rs_cartmini[$i]['item_min_price'] : $price;
			$price_html = '<i class="fas fa-rupee-sign"></i>' . $price . '';
			if ($mrp > 0 && $mrp > $price) {
				$price_html .= ' <del><i class="fas fa-rupee-sign"></i>' . $mrp . '</del>';
			}
			$memberSatisfy = 'No';
			if ($customer_members_id > 0 && $rs_cartmini[$i]['customer_members_first_name'] != '') {
				$line1 = $rs_cartmini[$i]['customer_members_line1'];
				$area = $rs_cartmini[$i]['customer_members_area'];
				$pincode = $rs_cartmini[$i]['customer_members_pincode'];
				$obj_model_tble = $app->load_model("pincode");
				$obj_model_tble->join_table("state", "left", array("name"), array("state_id" => "id"));
				$obj_model_tble->join_table("city", "left", array("name"), array("city_id" => "id"));
				$rs_pincode_data = $obj_model_tble->execute("SELECT", false, "", "pincode.name='" . $pincode . "'", "pincode.id DESC");
				$city = $rs_pincode_data[0]['city_name'];
				$state = $rs_pincode_data[0]['state_name'];
				$member_html = '<a class="vtest-btn text-dark d-inline-block w-100 mb-2 cartMemberRemove" data-id="' . $cartID . '" href="javascript:void(0)">' . $rs_cartmini[$i]['customer_members_prefix'] . ' ' . $rs_cartmini[$i]['customer_members_first_name'] . ' ' . $rs_cartmini[$i]['customer_members_last_name'] . ' | ' . $rs_cartmini[$i]['customer_members_relation'] . '<br/><span class=" ">' . $line1 . ', ' . $area . ',' . $city . ' - ' . $pincode . ', ' . $state . '</span> </a>';
				$memberSatisfy = 'Yes';
			} else {
				if ($_SESSION['MDRCCustID'] > 0) {
					$extraItemsHtml = ' href="javascript:void(0)" data-id="' . $cartID . '"';
					$memberSelectClass = 'customerMemberSelect';
				} else {
					$extraItemsHtml = 'data-bs-toggle="offcanvas" href="#offcanvasExample-login"';
					$memberSelectClass = '';
				}
				$member_html = '<a class="adpatient d-inline-block border-end text-blue mt-2 mb-2 ' . $memberSelectClass . '" ' . $extraItemsHtml . '><i class="fas fa-plus me-2"></i> Add patients for this item</a>';
			}
			$prescription_html = '';
			$prescriptionSatisfy = 'No';
			if ($prescription_require == 'Yes') {
				if ($prescription_data != '') {
					$prescription_html = '<div class="vtest-btn text-dark d-inline-block w-100 mb-2" href="#">Prescription Info <a class="float-end vdet text-blue prescriptionView" data-id="' . $cartID . '">View Details</a> </div>';
					$prescriptionSatisfy = 'Yes';
				} else {
					if ($_SESSION['MDRCCustID'] > 0) {
						$extraItemsHtml = ' href="javascript:void(0)" data-id="' . $cartID . '"';
						$preSelectClass = 'prescriptionSelect';
					} else {
						$extraItemsHtml = 'data-bs-toggle="offcanvas" href="#offcanvasExample-login"';
						$preSelectClass = '';
					}
					$prescription_html = '<a class="adpatient d-inline-block text-blue mt-2 mb-2 ' . $preSelectClass . '" ' . $extraItemsHtml . '><i class="fas fa-plus me-2"></i> Add Prescription</a>';
				}
			} else {
				$prescriptionSatisfy = 'Yes';
			}
			if ($prescriptionSatisfy == 'Yes' && $memberSatisfy == 'Yes') {
				$other_class = 'col-lg-12 ps-3 pe-3';
			} else {
				$other_class = 'col-lg-12 p-0 border-top';
			}
			$other_html = '<div class="' . $other_class . '">
							' . $member_html . ' ' . $prescription_html . '
						</div>';
			$html .= '<div class="col-lg-12 bg-white shadow-normal mb-3">
	      				<div class="col-lg-12 bg-white  d-flex p-3">
      						<div class="packname">
      							<h4>' . $itemName . ' <a class="ms-2 itemsDetails" data-id="' . $cart_item_id . '"><i class="fas fa-chevron-down text-black"></i></a><br><span>Includes ' . $testCount . ' Tests</span></h4>
      						</div>
      						<div class="pricdiv ms-auto">
								<h5><span class="float-end">' . $price_html . '</span></h5>
							</div>
						</div>
	      				' . $other_html . '
					</div>';
		}
		$RESULT = 'OK';
		$final_ids = array_unique($depIDs);
		$depID = implode(',', $final_ids);
	} else {
		$html = '<div class="col-lg-12 bg-white shadow-normal mb-3">
	      				<p>No Items Added.</p>
					</div>';
		$RESULT = 'OK';
		$subtotal = '0.00';
	}
	$subtotal = number_format($subtotal, '2', '.', '');
	$_SESSION['min_price_amount']=$minAdvanceAmount;
	if(empty($_SESSION['payment_type']))
	{
		$_SESSION['payment_type']="COD";
	}
	
	echo $obj_json->encode(array("RESULT" => $RESULT, "html" => $html, "subtotal" => $subtotal, "homeCollectionHtml" => $homeCollectionHtml, "step_third_heading" => $step_third_heading));
	exit;
}
if ($action_type == 'homeAddressSelect') {
	$collectionDate = $app->getPostVar("collectionDate");
	$collectionTime = $app->getPostVar("collectionTime");
	$addID = $app->getPostVar("addID");
	if ($addID <= 0) {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Address"));
		exit;
	}
	if ($collectionDate == '') {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Collection Date"));
		exit;
	}
	if ($collectionTime == '') {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Collection Time"));
		exit;
	}
	$_SESSION['checkoutAddressID'] = $addID;
	$_SESSION['checkoutCollectionDate'] = $collectionDate;
	$_SESSION['checkoutCollectionTime'] = $collectionTime;
	if ($_SESSION['labSelection'] == 'No') {
		$payment_option = 'Yes';
	} else {
		$payment_option = 'No';
	}
	echo $obj_json->encode(array("RESULT" => "0", "MSG" => "Success", "payment_option" => $payment_option));
	exit;
}
if ($action_type == 'labSelection') {
	$labDate = $app->getPostVar("labDate");
	$labTime = $app->getPostVar("labTime");
	$labID = $app->getPostVar("labID");
	if ($labID <= 0) {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Address"));
		exit;
	}
	if ($labDate == '') {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Date"));
		exit;
	}
	if ($labTime == '') {
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => "Please Select Time"));
		exit;
	}
	$_SESSION['checkoutLabID'] = $labID;
	$_SESSION['labDate'] = $labDate;
	$_SESSION['labTime'] = $labTime;
	echo $obj_json->encode(array("RESULT" => "0", "MSG" => "Success"));
	exit;
}
echo $obj_json->encode(array("RESULT" => $RESULT, "MSG" => $MSG));
