<?
class _checkout extends controller {
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

		$sampleCollect=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("sampleCollect"));

		$homeCollectionAddressID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("homeCollectionAddressID"));
		$homeCollectionDate=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("homeCollectionDate"));
		$homeCollectionTime=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("homeCollectionTime"));
		$labCollectionAddressID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("labCollectionAddressID"));
		$labCollectionDate=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("labCollectionDate"));
		$labCollectionTime=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("labCollectionTime"));
		$paymentMode=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("paymentMode"));
		$couponCode=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("couponCode"));
		$couponDiscount=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("couponDiscount"));
		$walletUsed=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("walletUsed"));
		$walletAmount=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("walletAmount"));
		$grandTotal=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("grandTotal"));
		
		if($userID!='' && $userPhone!='' && $deviceType!='' && $grandTotal!='' && $walletUsed!='' && $paymentMode!='' && $sampleCollect!='')
		{
			//check validation start
			if($sampleCollect=='Yes'){

				if($homeCollectionAddressID==''){
					$message=array("message"=>"Please Select Address.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}

				if($homeCollectionDate==''){
					$message=array("message"=>"Please Select Date.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}

				if($homeCollectionTime==''){
					$message=array("message"=>"Please Select Time.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}
			}

			if($labCollectionAddressID!='') {
				if($labCollectionDate=='') {
					$message=array("message"=>"Please Select Date.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}

				if($labCollectionTime==''){
					$message=array("message"=>"Please Select Time.","msgCode"=>"0");
					$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
					echo $this->app->utility->indent($opt);
					exit;
				}
			}
			//check validation end

			$promo_wallet_check='No';
			$collection_charge=0;
			$dis_id='';
			$dis_value=$couponDiscount;
			$customer_address_id=$homeCollectionAddressID;
			$order_from=$deviceType;
			$customer_id=$userID;
			$payment_method=$paymentMode;
			$app_order_total='';
			$app_final_total=$grandTotal;
			$wallet_selected='No';
			$instruction='';

			if($couponCode!=''){
				$obj_model = $this->app->load_model("coupon");
				$couponData = $obj_model->execute("SELECT", false, "", "coupon_code='".$couponCode."'");
				if(count($couponData)>0){
					$dis_id=$couponData[0]['id'];
				}
			}

			$customerCond="customer_cart.customer_id='".$customer_id."'";
			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation"), array("customer_members_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
			$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
			if(count($rs_cartmini)<=0)
			{
				$message=array("message"=>"Your Card is empty.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
			$subtotal=0;
			for($i=0;$i<count($rs_cartmini);$i++)
			{
				$subtotal=$subtotal+$rs_cartmini[$i]['cart_line_total'];

				/* check item price */
				$sch_price=$rs_cartmini[$i]['item_price_sch_price'];
				$sch_start_date=$rs_cartmini[$i]['item_price_sch_start_date'];
				$sch_end_date=$rs_cartmini[$i]['item_price_sch_end_date'];
				if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
				{
					$today_date=date('d-m-Y');
					$todaySlot=strtotime($today_date);
					$startSlot=strtotime($sch_start_date);
					$endSlot=strtotime($sch_end_date);
					$dbPrice=$rs_cartmini[$i]['item_price_price'];
					if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
					{
						$dbPrice=$sch_price;
					}
					if($rs_cartmini[$i]['item_status']!='Active'){
						$message=array("message"=>$rs_cartmini[$i]['item_name']." Not Available. Please remove form cart.","msgCode"=>"0");
						$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
						echo $this->app->utility->indent($opt);
						exit;
					}
					if($rs_cartmini[$i]['cart_item_price']!=$dbPrice && $rs_cartmini[$i]['item_status']=='Active'){
						$message=array("message"=>$rs_cartmini[$i]['item_name']." price has changed! Remove this product from your cart and add it again to see the updated price.","msgCode"=>"0");
						$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
						echo $this->app->utility->indent($opt);
						exit;
					}
				}
			}

			$obj_model_customer= $this->app->load_model("customer");
			$rs_customer = $obj_model_customer->execute("SELECT", false, "", "id='".$customer_id."' and status='Active'");
			$customerWallet=$rs_customer[0]['wallet'];
			$customerPromoWallet=$rs_customer[0]['promoWallet'];
			
			// Net Order Value
			$total1=$subtotal+$collection_charge-$dis_value;
			if($promo_wallet_check=='Yes' && $total1>0 && $customerPromoWallet>0)
			{
				if($total1>$customerPromoWallet)
				{
					$promo_wallet_use=$customerPromoWallet;
				}
				else
				{
					$promo_wallet_use=$total1;
				}
			}
			else
			{
				$promo_wallet_use=0;
			}
			$total=$subtotal+$collection_charge-$dis_value-$promo_wallet_use;
			// Total Other Charges.
			$wallet_selected=$walletUsed;
			if($payment_method=='COD')
			{
				if($wallet_selected=='Yes' && $total>0 && $customerWallet>0)
				{
					if($total>$customerWallet)
					{
						$wallet_value=$customerWallet;
						$order_status='Pending';
						$pay_value=$total-$wallet_value;
						$payment_type='COD';
					}
					else
					{
						$wallet_value=$total;
						$order_status='Confirmed';
						$pay_value=0;
						$payment_type='WALLET';
					}
				}
				else
				{
					$wallet_value=0;
					$order_status='Pending';
					$pay_value=$total;
					$payment_type='COD';
				}
			}
			elseif($payment_method=='ONLINE')
			{
				if($wallet_selected=='Yes' && $total>0 && $customerWallet>0)
				{
					if($total>$customerWallet)
					{
						$wallet_value=$customerWallet;
						$order_status='Pending';
						$pay_value=$total-$wallet_value;
						$payment_type='ONLINE';
						$payment_status='Failed';
					}
					else
					{
						$wallet_value=$total;
						$order_status='Confirmed';
						$pay_value=0;
						$payment_type='WALLET';
						$payment_status='';
					}
				}
				else
				{
					$wallet_value=0;
					$order_status='Pending';
					$pay_value=$total;
					$payment_type='ONLINE';
					$payment_status='Failed';
				}
			}
			else
			{
			}
			$order_dat=$this->app->utility->check_order_data($order_type);
			$master_order_no=$order_dat['master_order_no'];
			$display_order_no=$order_dat['display_order_no'];
			$city_state_data=$this->app->utility->getApiCitStateRecord($cityID);
			$city_id=$city_state_data['city_ids'];
			$state_id=$city_state_data['state_ids'];
			$data = array();
			$data["discount_coupon_id"] = $dis_id;
			$data["master_order_no"] = $master_order_no;
			$data["display_order_no"] = $display_order_no;
			$data["lab_id"] = $labCollectionAddressID;
			$data["lab_prefer_date"] = $labCollectionDate;
			$data["lab_prefer_slot"] = $labCollectionTime;
			$data["home_address_id"] = $homeCollectionAddressID;
			$data["home_collection_date"] = $homeCollectionDate;
			$data["home_collection_slot"] = $homeCollectionTime;
			$data["state_id"] = $state_id;
			$data["city_id"] = $city_id;
			$data["customer_id"] = $customer_id;
			$data["admin_id"] = $admin_id;
			$data["subtotal"] =$subtotal;
			$data["collection_charge"] = 0;
			$data["discount"] =$dis_value;
			$data["promo_wallet_amount"] = $promo_wallet_use;
			$data["wallet_amount"] = $wallet_value;
			$data["net_order_value"] =$pay_value;
			$data["online_amount"] =0;
			$data["order_status"] = $order_status;
			$data["payment_type"] = $payment_type;
			$data["order_from"] = $order_from;
			$data["order_date"] = date('d-m-Y');
			$data["ip"] = $_SERVER['REMOTE_ADDR'];
			$obj_order_master = $this->app->load_model("customer_order_master");
			$obj_order_master->map_fields($data);
			$order_id = $obj_order_master->execute("INSERT");
			if($order_id>0)
			{
				if($wallet_value>0)
				{
					//===================== update user table =========================//
					$walletU=$customerWallet-$wallet_value;
					$data_u=array();
					$data_u['wallet']=$walletU;
					$obj_model_user=$this->app->load_model("customer");
					$obj_model_user->map_fields($data_u);
					$obj_model_user->execute("UPDATE",false,"","id='".$customer_id."'");
					//===================== insert wallet transaction table =========================//
					$last_bal=$customerWallet;
					$last_promo_bal=$customerPromoWallet;
					$data_t=array();
					$data_t['customer_id']=$customer_id;
					$data_t['order_id']=$order_id;
					$data_t['amount']=$wallet_value;
					$data_t['amount_type']='-';
					$data_t['last_bal']=$last_bal;
					$data_t['last_promo_bal']=$last_promo_bal;
					$data_t["payment_status"] = "Success";
					$data_t['pay_with']='Web';
					$data_t['transaction_date']=date('d-m-Y');
					$data_t['entry_type']='Order';
					$data_t['remark']='Order #'.$display_order_no.' Payment';
					$data_t['added_by']='System';
					$data_t['wallet_type']='Wallet';
					$data_t['ip']=$_SERVER['REMOTE_ADDR'];
					$data_t['entry_date_time']=date('d-m-Y H:i:s');
					$obj_model_wallet_transaction=$this->app->load_model("wallet_transction");
					$obj_model_wallet_transaction->map_fields($data_t);
					$obj_model_wallet_transaction->execute("INSERT");
					$data_amt=array();
					$data_amt['customer_id']=$customer_id;
					$data_amt['order_master_id']=$order_id;
					$data_amt['payment_type']='Wallet';
					$data_amt['transaction_amount']=$wallet_value;
					$data_amt['payment_status']='Success';
					$data_amt['transction_date_time']=date('d-m-Y H:i:s');
					$data_amt['payment_date']=date('d-m-Y');
					$data_amt['entry_from']=$order_from;
					$data_amt['ip']=$_SERVER['REMOTE_ADDR'];
					$obj_model_opd=$this->app->load_model("customer_order_payment_data");
					$obj_model_opd->map_fields($data_amt);
					$obj_model_opd->execute("INSERT");
				}
				if($promo_wallet_use>0)
				{
					//===================== update user table =========================//
					$walletP=$customerPromoWallet-$promo_wallet_use;
					$data_u=array();
					$data_u['promoWallet']=$walletP;
					$obj_model_user=$this->app->load_model("customer");
					$obj_model_user->map_fields($data_u);
					$obj_model_user->execute("UPDATE",false,"","id='".$customer_id."'");
					//===================== insert wallet transaction table =========================//
					$last_bal=$customerWallet;
					$last_promo_bal=$customerPromoWallet;
					$data_t=array();
					$data_t['customer_id']=$customer_id;
					$data_t['order_id']=$order_id;
					$data_t['amount']=$promo_wallet_use;
					$data_t['amount_type']='-';
					$data_t['last_bal']=$last_bal;
					$data_t['last_promo_bal']=$last_promo_bal;
					$data_t["payment_status"] = "Success";
					$data_t['pay_with']='Web';
					$data_t['transaction_date']=date('d-m-Y');
					$data_t['entry_type']='Order';
					$data_t['remark']='Order #'.$display_order_no.' Payment';
					$data_t['added_by']='System';
					$data_t['wallet_type']='Promo Wallet';
					$data_t['ip']=$_SERVER['REMOTE_ADDR'];
					$data_t['entry_date_time']=date('d-m-Y H:i:s');
					$obj_model_wallet_transaction=$this->app->load_model("wallet_transction");
					$obj_model_wallet_transaction->map_fields($data_t);
					$obj_model_wallet_transaction->execute("INSERT");
					$data_amt=array();
					$data_amt['customer_id']=$customer_id;
					$data_amt['order_master_id']=$order_id;
					$data_amt['payment_type']='Promo Wallet';
					$data_amt['transaction_amount']=$promo_wallet_use;
					$data_amt['payment_status']='Success';
					$data_amt['transction_date_time']=date('d-m-Y H:i:s');
					$data_amt['payment_date']=date('d-m-Y');
					$data_amt['entry_from']=$order_from;
					$data_amt['ip']=$_SERVER['REMOTE_ADDR'];
					$obj_model_opd=$this->app->load_model("customer_order_payment_data");
					$obj_model_opd->map_fields($data_amt);
					$obj_model_opd->execute("INSERT");
				}
				$data_oh=array();
				$data_oh["order_master_id"] =$order_id;
				$data_oh["customer_id"] =$customer_id;
				$data_oh["o_status"] =$order_status;
				$data_oh["remark"] ="Order Placed";
				$data_oh["entry_date"] = date("d-m-Y");
				$data_oh["entry_date_time"] = date("d-m-Y H:i:s");
				$data_oh["entry_from"] = $order_from;
				$data_oh["ip"] = $_SERVER['REMOTE_ADDR'];
				$obj_order_history = $this->app->load_model("customer_order_status_history");
				$obj_order_history->map_fields($data_oh);
				$oh = $obj_order_history->execute("INSERT");
				$data_other = array();
				$data_other["order_date_time"] = date('d-m-Y H:i:s');
				$data_other["order_master_id"] = $order_id;
				$data_other["order_remark"] = $instruction;
				$obj_order_order_master_info = $this->app->load_model("customer_order_master_info");
				$obj_order_order_master_info->map_fields($data_other);
				$obj_order_order_master_info->execute("INSERT");
				if($homeCollectionAddressID>0)
				{
					$obj_model_add= $this->app->load_model("customer_members");
					$rs_add = $obj_model_add->execute("SELECT", false, "", "id='".$homeCollectionAddressID."'");
					$data_billing = array();
					$data_billing["order_master_id"] = $order_id;
					$data_billing["customer_id"] = $customer_id;
					$data_billing["customer_address_id"] = $rs_add[0]['id'];
					$data_billing["prefix"] = $rs_add[0]['prefix'];
					$data_billing["first_name"] = $rs_add[0]['first_name'];
					$data_billing["last_name"] = $rs_add[0]['last_name'];
					$data_billing["gender"] = $rs_add[0]['gender'];
					$data_billing["phone1"] = $rs_add[0]['phone1'];
					$data_billing["phone2"] = $rs_add[0]['phone2'];
					$data_billing["relation"] = $rs_add[0]['relation'];
					$data_billing["age"] = $rs_add[0]['age'];
					$data_billing["dob"] = $rs_add[0]['dob'];
					$data_billing["line1"] = $rs_add[0]['line1'];
					$data_billing["area"] = $rs_add[0]['area'];
					$data_billing["pincode"] = $rs_add[0]['pincode'];
					$data_billing["city_id"] = $rs_add[0]['city_id'];
					$data_billing["state_id"] = $rs_add[0]['state_id'];
					$data_billing["area_id"] = $rs_add[0]['area_id'];
					$data_billing["api_state_id"] = $rs_add[0]['api_state_id'];
					$data_billing["api_city_id"] = $rs_add[0]['api_city_id'];
					$data_billing["api_area_id"] = $rs_add[0]['api_area_id'];
					$data_billing["entry_date_time"] = date("d-m-Y H:i:s");
					$obj_order_data_billing = $this->app->load_model("customer_order_collection_address");
					$obj_order_data_billing->map_fields($data_billing);
					$obj_order_data_billing->execute("INSERT");
				}
				if($labCollectionAddressID>0)
				{
					$obj_model_add= $this->app->load_model("item_lab");
					$rs_add = $obj_model_add->execute("SELECT", false, "", "id='".$labCollectionAddressID."'");
					$data_shipping = array();
					$data_shipping["order_master_id"] = $order_id;
					$data_shipping["customer_id"] = $customer_id;
					$data_shipping["lab_id"] = $rs_add[0]['id'];
					$data_shipping["api_id"] = $rs_add[0]['api_id'];
					$data_shipping["code"] = $rs_add[0]['code'];
					$data_shipping["lab_name"] = $rs_add[0]['name'];
					$data_shipping["lab_email"] = $rs_add[0]['email'];
					$data_shipping["lab_phone"] = $rs_add[0]['phone'];
					$data_shipping["lab_address"] = $rs_add[0]['address'];
					$data_shipping["entry_date_time"] = date("d-m-Y H:i:s");
					$obj_order_shipping_address = $this->app->load_model("customer_order_lab_address");
					$obj_order_shipping_address->map_fields($data_shipping);
					$obj_order_shipping_address->execute("INSERT");
				}
				$order_items='';
				foreach($rs_cartmini as $item)
				{
					$obj_product = $this->app->load_model("item");
					$obj_product->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
					$obj_product->join_table("item_description", "left", array(), array("id"=>"item_id"));
					$rs_product = $obj_product->execute("SELECT", false, "", "item.id=".$item["item_id"]."");
					$itemid=$rs_product[0]['itemid'];
					$itemcode=$rs_product[0]['itemcode'];
					$order_item_folder_name=$rs_product[0]['folder'];
					$order_item_image=$rs_product[0]['image'];
					$order_item_test_count=$rs_product[0]['test_count'];
					$item_category_ids=$rs_product[0]['item_other_data_item_category_ids'];
					$item_department_ids=$rs_product[0]['item_other_data_item_department_ids'];
					$item_diseases_ids=$rs_product[0]['item_other_data_item_diseases_ids'];
					$item_type_id=$rs_product[0]['item_other_data_item_type_id'];
					$data_od = array();
					$data_od["order_detail_date"] = date('d-m-Y');
					$data_od["order_master_id"] = $order_id;
					$data_od["customer_id"] = $customer_id;
					$data_od["customer_members_id"] = $item["customer_members_id"];
					$data_od["prescription_require"] = $item["prescription_require"];
					$data_od["prescription_data"] = $item["prescription_data"];
					$data_od["item_id"] = $item["item_id"];
					$data_od["item_price_id"] = $item["item_price_id"];
					$data_od["order_item_name"] = $item["cart_item_name"];
					$data_od["itemid"] = $itemid;
					$data_od["itemcode"] = $itemcode;
					$data_od["order_item_folder_name"] = $order_item_folder_name;
					$data_od["order_item_image"] = $order_item_image;
					$data_od["order_item_test_count"] = $order_item_test_count;
					$data_od["item_category_ids"] = $item_category_ids;
					$data_od["item_department_ids"] = $item_department_ids;
					$data_od["item_diseases_ids"] = $item_diseases_ids;
					$data_od["item_type_id"] = $item_type_id;
					$data_od["order_quantity"] = $item["cart_qty"];
					$data_od["quantity"] = $item["cart_qty"];
					$data_od["price"] = $item["cart_item_price"];
					$data_od["mrp"] = $item["cart_item_mrp"];
					$data_od["total"] = $item["cart_line_total"];
					$obj_order_detail = $this->app->load_model("customer_order_detail");
					$obj_order_detail->map_fields($data_od);
					$order_detail_id=$obj_order_detail->execute("INSERT");
					if($item_type_id==1)
					{
						$obj_model_packages = $this->app->load_model("item_package_data");
						$obj_model_packages->join_table("item_description", "left", array(), array("data_id"=>"item_id"));
						$rs_package_data = $obj_model_packages->execute("SELECT",false,"","item_package_data.item_id='".$item["item_id"]."'","");
						for($i=0;$i<count($rs_package_data);$i++)
						{
							$data_other=array();
							$data_other["order_master_id"] = $order_master_id;
							$data_other["order_detail_id"] = $order_detail_id;
							$data_other["item_id"] = $rs_package_data[$i]["data_id"];
							$data_other["itemid"] = $rs_package_data[$i]["itemid"];
							$data_other["item_name"] = $rs_package_data[$i]["item_description_item_name"];
							$data_other["sample_remark"] = $rs_package_data[$i]["item_description_sample_remark"];
							$data_other["sample_type_name"] = $rs_package_data[$i]["item_description_sample_type_name"];
							$data_other["sample_remark1"] = $rs_package_data[$i]["item_description_sample_remark1"];
							$data_other["test_parameters"] = $rs_package_data[$i]["item_description_test_parameters"];
							$data_other["prescription_required"] = $rs_package_data[$i]["item_description_prescription_required"];
							$data_other["required_attachment"] = $rs_package_data[$i]["item_description_required_attachment"];
							$obj_order_detail_ot = $this->app->load_model("customer_order_detail_data");
							$obj_order_detail_ot->map_fields($data_other);
							$obj_order_detail_ot->execute("INSERT");
						}
					}
					else
					{
						$data_other=array();
						$data_other["order_master_id"] = $order_master_id;
						$data_other["order_detail_id"] = $order_detail_id;
						$data_other["item_id"] = $rs_product[0]["id"];
						$data_other["itemid"] = $rs_product[0]["itemid"];
						$data_other["item_name"] = $rs_product[0]["item_description_item_name"];
						$data_other["sample_remark"] = $rs_product[0]["item_description_sample_remark"];
						$data_other["sample_type_name"] = $rs_product[0]["item_description_sample_type_name"];
						$data_other["sample_remark1"] = $rs_product[0]["item_description_sample_remark1"];
						$data_other["test_parameters"] = $rs_product[0]["item_description_test_parameters"];
						$data_other["prescription_required"] = $rs_product[0]["item_description_prescription_required"];
						$data_other["required_attachment"] = $rs_product[0]["item_description_required_attachment"];
						$obj_order_detail_ot = $this->app->load_model("customer_order_detail_data");
						$obj_order_detail_ot->map_fields($data_other);
						$obj_order_detail_ot->execute("INSERT");
					}
				}
			}
			if($payment_type=='COD' || $payment_type=='WALLET')
			{
				// $sms_type='CUSTOMER_ORDER_PLACE';
				// $default_sms_string=array("{name}","{order_id}","{store_data}");
				// $new_sms_string= array($customer_name,$display_order_no,$_SESSION['store_data']);
				// $this->app->utility->send_sms_new($customer_phone,$sms_type,$default_sms_string,$new_sms_string);

				/*------------------Start for mail function------------------*/
				$obj_model_order_cust_detail= $this->app->load_model("customer_order_detail");
				$obj_model_order_cust_detail->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","age","pincode","area_id","area"), array("customer_members_id"=>"id"));
				$rs_cust_detail= $obj_model_order_cust_detail->execute("SELECT",false,"","customer_order_detail.order_master_id='".$order_id."'","","customer_members.id");

				$rs_detail_array=[];
				foreach ($rs_cust_detail as $key => $value)
				{
					$obj_model_order_detail= $this->app->load_model("customer_order_detail");
					$obj_model_order_detail->join_table("item_other_data", "inner", array("item_department_ids"), array("item_id"=>"id"));
					$rs_detail= $obj_model_order_detail->execute("SELECT", false, "","customer_order_detail.order_master_id='".$order_id."' and customer_order_detail.customer_members_id='".$value['customer_members_id']."'");

					$rs_detail_array[]=['cust_detail'=>$value,'order_detail'=>$rs_detail];
				}
				$order_detail='';

				
				for($i=0;$i<count($rs_detail_array);$i++)
				{
					$for_html='';
					if($i==0){ $for_html='For<br/>'; }	

					$items_html='';
					for($j=0; $j < count($rs_detail_array[$i]['order_detail']) ; $j++) 
					{            
						$items=$rs_detail_array[$i]['order_detail'][$j];
						$items_html.='<p><strong>-  '.$items['order_item_name'].'</strong></p>';
					}
					
					$customer_members=$rs_detail_array[$i]['cust_detail']['customer_members_prefix'].' '.$rs_detail_array[$i]['cust_detail']['customer_members_first_name'].' '.$rs_detail_array[$i]['cust_detail']['customer_members_last_name'];

					$order_detail.='<p class="o_mb">'.$for_html.'<strong>'.$customer_members.'</strong></p><br>'.$items_html.'<br><hr><br>';
				}

				$orderID='#'.$order_id;
				$cust_name=$rs_customer[0]['name']." ".$rs_customer[0]['last_name'];
				$template_name='booking_place_admin';
				$send_data_arary=['name'=>$cust_name,'order_id'=>$orderID,'order_detail'=>$order_detail];
				$subject='New Booking from '.$rs_customer[0]['phone'].' on Website';
				$mail_for='Admin';
				$data=['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'subject'=>$subject,'mail_for'=>$mail_for];
				$this->app->utility->sendMial($data);
				/*------------------End for mail function------------------*/
				

				$obj_cart = $this->app->load_model("customer_cart");
				$obj_cart->execute("DELETE", false, "","customer_id='".$customer_id."'");
				$order_id;
				
				$result=["orderID"=>$order_id,"msg1"=>"Thank You.","msg2"=>"Your Booking(#".$order_id.") is Confirmed"];
				$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
			else
			{
				$data_od = array();
				$data_od["order_detail_date"] = date('d-m-Y');
				$data_od["order_master_id"] = $order_id;
				$data_od["customer_id"] = $customer_id;
				$data_od["transaction_amount"] = $pay_value;
				$data_od["payment_type"] = $payment_type;
				$data_od["payment_status"] = 'Failed';
				$data_od["transction_type"] = 'Order';
				$data_od["transction_date_time"] = date('d-m-Y H:i:s');
				$data_od["ip"] = $_SERVER['REMOTE_ADDR'];
				$data_od["entry_from"] = 'Web';
				$obj_order_payment= $this->app->load_model("customer_order_payment_data");
				$obj_order_payment->map_fields($data_od);
				$orderPayID=$obj_order_payment->execute("INSERT");
				//$_SESSION['orderPayID']=$orderPayID;
				//$_SESSION['OrderID']=$order_id;
				//$_SESSION['Transaction_Amount']=$pay_value;

				$result=[
					"orderID"=>$order_id,
					"paymentID"=>$orderPayID,
					"failMsg1"=>"Your Payment Failed.",
					"failMsg2"=>"COD order(#".$order_id.") is placed. You can retry payment or cancel order.",
					"retryPayButton"=>"No",
					"cancelButton"=>"No",
					"webViewUrl"=>SERVER_ROOT."/appApi/index.php?view=order_payment_webview&orderID=".$order_id."&paymentID=".$orderPayID
				];
				$message=array("message"=>'success',"msgCode"=>"3","result"=>$result);
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
		}
		else
		{
			$message=array("message"=>"Data missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>