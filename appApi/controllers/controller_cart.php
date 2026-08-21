<?
class _cart extends controller{
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);

		$cartID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cartID'));
		$cartID=$cartID!=''?$this->app->utility->decrypt($cartID):"";

		$itemID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('itemID'));
		$itemID=$itemID!=''?$this->app->utility->decrypt($itemID):"";

		$memberID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('memberID'));
		$memberID=$memberID!=''?$this->app->utility->decrypt($memberID):"";
		
		$itemPriceID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('itemPriceID'));
		$itemPriceID=$itemPriceID!=''?$this->app->utility->decrypt($itemPriceID):"";

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";

		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));

		if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='addToCart' && $itemID!='' && $itemPriceID!='')
		{
			$obj_model_customer= $this->app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model_item = $this->app->load_model("item");
			$obj_model_item->join_table("item_description", "left", array("prescription_required"), array("id"=>"item_id"));
			$obj_model_item->join_table("item_other_data", "left", array("item_department_ids"), array("id"=>"item_id"));
			$rs_item = $obj_model_item->execute("SELECT", false, "", "item.status='Active' and item.id=".$itemID);

			$obj_model_item_price = $this->app->load_model("item_price");
			$rs_item_price = $obj_model_item_price->execute("SELECT", false, "", "id=".$itemPriceID);

			$city_id=$rs_item_price[0]['city_id'];
			$prescription_require=$rs_item[0]['item_description_prescription_required'];
			$cart_item_department_ids=$rs_item[0]['item_other_data_item_department_ids'];
			$price=$rs_item_price[0]['price'];
			$sch_price=$rs_item_price[0]['sch_price'];
			$sch_start_date=$rs_item_price[0]['sch_start_date'];
			$sch_end_date=$rs_item_price[0]['sch_end_date'];
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
			if(count($rs_item)<=0)
			{
				$response=array("message"=>"Item not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model_tmp_cart = $this->app->load_model("customer_cart");
			$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","customer_cart.customer_id='".$userID."' and cart_item_id='".$itemID."' and cart_item_price_id='".$itemPriceID."'");
			
			$data = array();
			$data["customer_id"] = $userID;
			$data["city_id"]=$cityID;
			$data["prescription_require"]=$prescription_require;
			$data["cart_item_name"] = $rs_item[0]['name'];
			$data["cart_item_id"] = $itemID;
			$data["cart_item_price_id"] = $itemPriceID;
			$data["cart_gst_per"] = $rs_item[0]['gst_per'];
			$data["cart_item_price"] = $price;
			$data["cart_item_mrp"] = $rs_item_price[0]['mrp'];
			$data["cart_qty"] = 1;
			$data["cart_line_total"] = (1 * $price);
			$data["entry_from"] = 'Web';
			$data["entry_date_time"] = date("d-m-Y H:i:s");
			$data["cart_item_department_ids"] = $cart_item_department_ids;
			$obj_model_tmp_cart = $this->app->load_model("customer_cart");
			$obj_model_tmp_cart->map_fields($data);
			if(count($rs_cart)==0) {
				$result = $obj_model_tmp_cart->execute("INSERT");
			} else {
				$result = $obj_model_tmp_cart->execute("UPDATE", false, "", "id='".$rs_cart[0]['id']."'");
			}
			
			$obj_model_tmp_cart = $this->app->load_model("customer_cart");
			$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","customer_cart.customer_id='".$userID."'");
			$cartCount=count($rs_cart);
			$cartLineTotal = count($rs_cart)>0?array_sum(array_column($rs_cart,'cart_line_total')):0;

			$result=["cartCount"=>$cartCount,"cartSubtotal"=>$cartLineTotal];
			$message=array("message"=>'Item added in Cart.',"msgCode"=>"1","result"=>$result);
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartItemDelete' && $cartID!='')
		{
			$obj_model_customer= $this->app->load_model("customer_cart");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$cartID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Item not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->execute("DELETE", false, "", "customer_cart.id='".$cartID."' and customer_cart.customer_id='".$userID."'");

			$obj_model_tmp_cart = $this->app->load_model("customer_cart");
			$rs_cart = $obj_model_tmp_cart->execute("SELECT",false,"","customer_cart.customer_id='".$userID."'");
			$cartCount=count($rs_cart);
			$cartLineTotal = count($rs_cart)>0?array_sum(array_column($rs_cart,'cart_line_total')):0;

			$result=["cartCount"=>$cartCount,"cartSubtotal"=>$cartLineTotal];
			$message=array("message"=>'Item Removed From Cart.',"msgCode"=>"1","result"=>$result);
		}

		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartClear')
		{
			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->execute("DELETE", false, "", "customer_cart.customer_id='".$userID."'");

			$cartCount=0;
			$cartLineTotal = 0;

			$result=["cartCount"=>$cartCount,"cartSubtotal"=>$cartLineTotal];
			$message=array("message"=>'Cart is clear.',"msgCode"=>"1","result"=>$result);
		}

		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartItemMemberAssign' && $cartID!='' && $memberID!='' && $cityID!='')
		{
			//cartItemMemberAssign start
			$customerCond=" and customer_cart.customer_id='".$userID."'";
			//check memeber and current city match
			$obj_model_customer_members  = $this->app->load_model("customer_members");
			//$obj_model_customer_members->join_table("city", "left", array(), array("city_id"=>"id"));
			$selected_member = $obj_model_customer_members->execute("SELECT", false, "","customer_members.id='".$memberID."'");
			if($selected_member[0]['city_id']!=$cityID)
			{
				$response=array("message"=>"Selected Patient Address not match with Selected City.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			//check test gender condition
			$obj_model_item_detail = $this->app->load_model("customer_cart");
			$obj_model_item_detail->join_table("item_description", "left", array(), array("cart_item_id"=>"item_id"));
			$item_detail = $obj_model_item_detail->execute("SELECT", false, "","customer_cart.id='".$cartID."'");
			if($item_detail[0]['item_description_gender']=='Male' && $selected_member[0]['gender']!='Male')
			{
				$response=array("message"=>"Selected Test is only for Male.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			if($item_detail[0]['item_description_gender']=='Female' && $selected_member[0]['gender']!='Female')
			{
				$response=array("message"=>"Selected Test is only for Female.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET customer_members_id='".$memberID."' WHERE customer_cart.id='".$cartID."' ".$customerCond."");
			
			//get member details
			$item=$selected_member[0];
			$pincode=$item['pincode'];

			$obj_model_tble = $this->app->load_model("pincode");
			$obj_model_tble->join_table("state", "left", array("name"), array("state_id"=>"id"));
			$obj_model_tble->join_table("city", "left", array("name"), array("city_id"=>"id"));
			$rs_pincode_data= $obj_model_tble->execute("SELECT", false, "", "pincode.name='".$pincode."'","pincode.id DESC");
			$city=$rs_pincode_data[0]['city_name'];
			$state=$rs_pincode_data[0]['state_name'];

			$cartItemMember=$item['prefix'].' '.$item['first_name'].' '.$item['last_name'].' | '.$item['relation'].'<br/>'.$item['line1'].', '.$item['area'].','.$city.' - '.$pincode.', '.$state;
			$result=["cartItemMember"=>$cartItemMember];
			$message=array("message"=>'Member Assign to Test.',"msgCode"=>"1","result"=>$result);
			//cartItemMemberAssign end
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartItemMemberRemove' && $cartID!='')
		{
			$customerCond=" and customer_cart.customer_id='".$userID."'";
			$obj_model_customer= $this->app->load_model("customer_cart");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$cartID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Item not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}
			$obj_model = $this->app->load_model("customer_cart");
			$obj_model->execute("UPDATE", false, "UPDATE customer_cart SET customer_members_id=0 WHERE customer_cart.id='".$cartID."' ".$customerCond."");
			$message=array("message"=>'Member Removed From Item.',"msgCode"=>"1");
		} 
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartItemPrescriptionRemove' && $cartID!='')
		{
			$customerCond=" and customer_cart.customer_id='".$userID."'";
			$obj_model_customer= $this->app->load_model("customer_cart");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$cartID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Item not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}
			$obj_model = $this->app->load_model("customer_cart");
			$obj_model->execute("UPDATE", false, "UPDATE customer_cart SET prescription_data='' WHERE customer_cart.id='".$cartID."' ".$customerCond."");
			$message=array("message"=>'Member Removed From Item.',"msgCode"=>"1");
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartItemPrescriptionAssign' && $cartID!='')
		{
			$customerCond=" and customer_cart.customer_id='".$userID."'";
			$obj_model_customer= $this->app->load_model("customer_cart");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$cartID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Item not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			if(empty($_FILES['prescriptionFile']['name']))
			{
				$response=array("message"=>"Please Upload Prescription File..","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$upload_dir="prescription";
			$banner_img11=$this->app->utility->resize_multi_image_2020($_FILES['prescriptionFile']['name'],$_FILES['prescriptionFile']['tmp_name'],'../uploads/'.$upload_dir.'/','400','800','100');
			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->execute("UPDATE", false, "UPDATE customer_cart SET prescription_data='".$banner_img11."' WHERE customer_cart.id='".$cartID."'");

			$cartItemPrescriptionFile=SERVER_ROOT.'/uploads/prescription/'.$banner_img11;
			$result=["cartItemPrescriptionFile"=>$cartItemPrescriptionFile];
			$message=array("message"=>'Member Removed From Item.',"msgCode"=>"1","result"=>$result);
		} 
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartList')
		{
			$sampleCollectShow='No';
			$obj_model_customer= $this->app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($rs_user)<=0)
			{
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}

			$obj_model = $this->app->load_model("customer_cart");
			$obj_model->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
			$obj_model->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","line1","pincode","area_id","area"), array("customer_members_id"=>"id"));
			$obj_model->join_table("item", "left", array(), array("cart_item_id"=>"id"));
			$obj_model->join_table("item_other_data", "left", array("item_type_id"), array("cart_item_id"=>"item_id"));
			$cartItems = $obj_model->execute("SELECT", false, "", "customer_cart.customer_id='".$userID."'","customer_cart.id DESC");
			if(count($cartItems)>0)
			{
				$subtotal=0;
				$depIDs=array();
				foreach($cartItems as $item)
				{
					$item_type_id=$item['item_other_data_item_type_id'];
					$item_type_name=$item_type_id=1?'package':'test';
					$depIDs[]=$item['cart_item_department_ids'];
					$itemName=$item['cart_item_name'];
					$testCount=$item['item_test_count'];
					$cartID=$item['id'];
					$cart_item_id=$item['cart_item_id'];
					$price=$item['cart_item_price'];
					$mrp=$item['cart_item_mrp'];
					$customer_members_id=$item['customer_members_id'];
					$prescription_require=$item['prescription_require'];
					$prescription_data=$item['prescription_data'];
					$sch_price=$item['item_price_sch_price'];
					$sch_start_date=$item['item_price_sch_start_date'];
					$sch_end_date=$item['item_price_sch_end_date'];
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
					$cart_line_total=$item['cart_line_total'];
					if($price!=$item['cart_item_price'])
					{
						$cart_line_total=$price*$item['cart_qty'];

						$obj_model_tmp_cart11 = $this->app->load_model("customer_cart");
						$obj_model_tmp_cart11->execute("UPDATE",false,"UPDATE customer_cart SET cart_item_price='".$price."',cart_line_total='".$cart_line_total."' WHERE customer_cart.id='".$item['id']."'","");
					}
					$subtotal=$subtotal+$cart_line_total;
					
					$member_html='';
					$memberSatisfy='No';
					if($customer_members_id>0 && $item['customer_members_first_name']!='')
					{
						$line1=$item['customer_members_line1'];
						$area=$item['customer_members_area'];
						$pincode=$item['customer_members_pincode'];

						$obj_model_tble = $this->app->load_model("pincode");
						$obj_model_tble->join_table("state", "left", array("name"), array("state_id"=>"id"));
						$obj_model_tble->join_table("city", "left", array("name"), array("city_id"=>"id"));
						$rs_pincode_data= $obj_model_tble->execute("SELECT", false, "", "pincode.name='".$pincode."'","pincode.id DESC");
						$city=$rs_pincode_data[0]['city_name'];
						$state=$rs_pincode_data[0]['state_name'];

						$member_html=$item['customer_members_prefix'].' '.$item['customer_members_first_name'].' '.$item['customer_members_last_name'].' | '.$item['customer_members_relation'].'<br/>'.$line1.', '.$area.','.$city.' - '.$pincode.', '.$state;
						$memberSatisfy='Yes';
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
							$extraItemsHtml=' href="javascript:void(0)" data-id="'.$cartID.'"' ;
							$preSelectClass='prescriptionSelect';
							$prescription_html='<a class="adpatient d-inline-block text-blue mt-2 mb-2 '.$preSelectClass.'" '.$extraItemsHtml.'><i class="fas fa-plus me-2"></i> Add Prescription</a>';
						}
					}
					else
					{
						$prescriptionSatisfy='Yes';
					}
					
					$cartList[]=[
						"cartID"=>$this->app->utility->encrypt($cartID),
						"name"=>$itemName,
						"cartItemID"=>$this->app->utility->encrypt($cart_item_id),
						"cartItemTestCount"=>'Includes '.$testCount.' Tests',
						"price"=>$price,
						"mrp"=>$price>=$mrp?'':$mrp,
						"dis"=>'',
						"cartItemMember"=>$member_html,
						"cartItemPrescriptionFile"=>$item['prescription_data']!=''?SERVER_ROOT.'/uploads/prescription/'.$item['prescription_data']:'',
						"cartItemPrescriptionRequire"=>$prescription_require,
						"cartItemMemberRequire"=>'Yes',
					];
				}

				$final_ids=array_unique($depIDs);
				$depID=implode(',',$final_ids);
				$obj_model_tble = $this->app->load_model("item_department");
				$rs_check_home_collection= $obj_model_tble->execute("SELECT", false, "", "id IN (".$depID.") and status='Active' and home_collection='Yes'");
				if(count($rs_check_home_collection)>0)
				{
					$sampleCollectShow='Yes';
					$homeCollectionDisable=["15","16","17"];
					if(in_array($cityID,$homeCollectionDisable)) {
						$sampleCollectShow='No';
					}
				}
				
			} else {
				$cartList=[];
			}

			$result=["cartList"=>$cartList,"cartCount"=>count($cartList),"cartSubtotal"=>$subtotal,"sampleCollectShow"=>$sampleCollectShow];
			$message=array("message"=>"success.","msgCode"=>"1","result"=>$result);
		}
		else if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='cartCheckForCheckout'){
			$sampleCollect=$this->app->getPostVar("sampleCollect");

			$customerCond="customer_cart.customer_id='".$userID."'";
			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation"), array("customer_members_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item_other_data", "left", array("item_type_id"), array("cart_item_id"=>"item_id"));
			$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
			if(count($rs_cartmini)>0)
			{
				$item_lab_ids=[];
				for($i=0;$i<count($rs_cartmini);$i++)
				{
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
					$prescriptionSatisfy='No';
					if($prescription_require=='Yes')
					{
						if($prescription_data!='')
						{
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
							$message=array("message"=>'Please add patient for this '.$item_type_name.' ('.$itemName.')',"msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
						}
						else
						{
							$message=array("message"=>'Please add prescription for this '.$item_type_name.' (<strong>'.$itemName.'</strong>)',"msgCode"=>"0");
							$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
							echo $this->app->utility->indent($opt);
							exit;
						}
					}
				}

				$unique_item_lab_ids=array_filter(array_unique($item_lab_ids));
				if(count($unique_item_lab_ids)>1 && count($rs_cartmini)>1)
				{
					//get lab name
					$obj_model_lab = $this->app->load_model("item_lab");
					$rs_lab = $obj_model_lab->execute("SELECT", false, "", " id in (".implode(',',$unique_item_lab_ids).")","");
					
					foreach($rs_lab as $item_lab)
					{
						$lab[$item_lab['id']]=$item_lab['name'];
					}

					$lab_error_msg='Please book the tests mentioned individually. ';
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

							$lab_error_msg.='Test'.$item['cart_item_name'].' is available only in '.$lab_ava;
						}
					}
				
					$message=array("message"=>$lab_error_msg,"msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}
				$message=array("message"=>"Checkout","msgCode"=>"1");
			}
			else
			{
				$message=array("message"=>"Please add items in cart.","msgCode"=>"0");
			}
		}
		else
		{
			$message=array("message"=>"Date missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>