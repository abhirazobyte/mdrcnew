<?
class _order_detail extends controller
{
	function init() {}
	function onload()
	{
		$ip = $_SERVER['REMOTE_ADDR'];

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);
		$orderID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('id'));

		if ($orderID <= 0 || $orderID == '') {
			$message = array("message" => "Please Verify Order ID.", "msgCode" => "0");
		} else {
			$obj_order_master = $this->app->load_model("customer_order_master");
			$rs_data = $obj_order_master->execute("SELECT", false, "", "customer_order_master.id='" . $orderID . "'");
			$orderMaster = $rs_data[0];
			
			$obj_model_order_detail_all= $this->app->load_model("customer_order_payment_data");
			$rs_payment= $obj_model_order_detail_all->execute("SELECT", false, "","customer_order_payment_data.order_master_id='".$orderID."' AND customer_order_payment_data.payment_status='Success'");
			$this->app->assign("rs_payment",$rs_payment);
			

			$orderMasterData = [
				"id" => $orderMaster['id'],
				"display_order_no" => $orderMaster['display_order_no'],
				"order_date" => $orderMaster['order_date'],
				'status' => $orderMaster['order_status'],
				"payment_type" => $orderMaster['payment_type'],
				"subtotal" => $orderMaster['subtotal'],
				"collection_charge" => $orderMaster['collection_charge'],
				"discount" => $orderMaster['discount'],
				"wallet_amount" => $orderMaster['wallet_amount'],
				"promo_wallet_amount" => $orderMaster['promo_wallet_amount'],
				"online_amount" => $orderMaster['online_amount'],
				"total_amount" => $orderMaster['net_order_value'],
				'total_paid_amount' => $rs_payment ? array_sum(array_column($rs_payment, 'transaction_amount')) : 0,
				"due_amount" => $orderMaster['net_order_value'] - ($rs_payment ? array_sum(array_column($rs_payment, 'transaction_amount')) : 0),
			];

			$obj_order_table = $this->app->load_model("customer_order_collection_address");
			$obj_order_table->join_table("city", "left", array("name"), array("city_id" => "id"));
			$obj_order_table->join_table("state", "left", array("name"), array("state_id" => "id"));
			$rs_collection_address = $obj_order_table->execute("SELECT", false, "", "customer_order_collection_address.order_master_id='" . $orderID . "'");
			$collectionAddressData = [
				"collection_date" => $orderMaster['home_collection_date'],
				"collection_time" => $orderMaster['home_collection_slot'],
				"prefix" => $rs_collection_address[0]['prefix'],
				"first_name" => $rs_collection_address[0]['first_name'],
				"last_name" => $rs_collection_address[0]['last_name'],
				"gender" => $rs_collection_address[0]['gender'],
				"phone1" => $rs_collection_address[0]['phone1'],
				"address" => $rs_collection_address[0]['line1'],
				"area" => $rs_collection_address[0]['area'],
				"city_name" => $rs_collection_address[0]['city_name'],
				"state_name" => $rs_collection_address[0]['state_name'],
				"pincode" => $rs_collection_address[0]['pincode'],

			];

			$obj_order_tble = $this->app->load_model("customer_order_lab_address");
			$rs_lab_data = $obj_order_tble->execute("SELECT", false, "", "customer_order_lab_address.order_master_id='" . $orderID . "'");

			$labData = [
				"lab_name" => $rs_lab_data[0]['lab_name'],
				"lab_email" => $rs_lab_data[0]['lab_email'],
				"lab_phone" => $rs_lab_data[0]['lab_phone'],
				"lab_address" => $rs_lab_data[0]['lab_address'],
			];

			$obj_order_tble = $this->app->load_model("customer_order_detail");
			$obj_order_tble->join_table("customer_members", "left", array("prefix", "first_name", "last_name", "gender", "relation", "line1", "pincode", "area_id", "area", "age", "dob"), array("customer_members_id" => "id"));
			$rs_order_detail = $obj_order_tble->execute("SELECT", false, "", "customer_order_detail.order_master_id='" . $orderID . "'", "", "customer_members.id");
			
			$orderItemData = [];

			if(!empty($rs_order_detail))
			{
				foreach($rs_order_detail as $key => $row)
				{
					$id=$row['item_id'];

					$obj_model_all = $this->app->load_model("item");
					$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
					$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
					$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));					
					$rs_data = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.id='".$id."'","item.sort_order ASC limit 0,1","");

					$item_type=$rs_data[0]['item_other_data_item_type_id'];

					if($item_type==1)
					{
						$obj_model_packages = $this->app->load_model("item_package_data");
						$obj_model_packages->join_table("item_description", "left", array(), array("data_id"=>"item_id"));
						$rs_package_data = $obj_model_packages->execute("SELECT",false,"","item_package_data.item_id='".$rs_data[0]['id']."'","");
					}

					$item_description='';
					if(count($rs_package_data)>0) {
						$pName=array();
						for($i=0;$i<count($rs_package_data);$i++)
						{
							$pName[]=$rs_package_data[$i]['item_description_item_name'];
						}
						$item_description = implode(', ',$pName);
					}

					$question = [];
					$sampleRemark = [];
					$sampleType = [];
					$sampleRemark1 = [];
					$testParameters = [];

					if($rs_data[0]['item_other_data_item_type_id']==1)
					{
						for($i=0;$i<count($rs_package_data);$i++)
						{
							if($rs_package_data[$i]['item_description_sample_remark']!='') {
								$sampleRemark[] = $rs_package_data[$i]['item_description_sample_remark'];
							}
							if($rs_package_data[$i]['item_description_sample_type_name']!='') {
								$sampleType[] = $rs_package_data[$i]['item_description_sample_type_name'];
							}
							if($rs_package_data[$i]['item_description_sample_remark1']!='') {
								$sampleRemark1[] = $rs_package_data[$i]['item_description_sample_remark1'];
							}
						}

						foreach ($rs_package_data as $item) {

							$question = $item['item_description_item_name'];
							$detail   = $item['item_description_test_parameters'];

							if (!isset($testParameters[$question])) {
								$testParameters[$question] = [
									'question' => $question,
									'details'  => []
								];
							}

							if (!empty($detail)) {
								$testParameters[$question]['details'][] = $detail;
							}
						}

						$testParameters = array_values($testParameters);


					}
					else
					{
						$question[] = $rs_data[0]['item_description_item_name'];
						if($rs_data[0]['item_description_sample_remark']!='') {
							$sampleRemark[] = $rs_data[0]['item_description_sample_remark'];
						}
						if($rs_data[0]['item_description_sample_type_name']!='') {
							$sampleType[] = $rs_data[0]['item_description_sample_type_name'];
						}
						if($rs_data[0]['item_description_sample_remark1']!='') {
							$sampleRemark1[] = $rs_data[0]['item_description_sample_remark1'];
						}
						if($rs_data[0]['item_description_test_parameters']!='') {
							$testParameters[] = $rs_data[0]['item_description_test_parameters'];
						}
					}

					$packageDetails=[
						'name' => $rs_data[0]['name'],
						'inclusion' => $rs_data[0]['test_count'],
						'item_description' => $item_description,
						'question' => $question,
						'sample_remark' => $sampleRemark,
						'sample_type' => $sampleType,
						'sample_remark1' => $sampleRemark1,
						'test_parameters' => $testParameters,
					];
				
					$orderItemData[] = [
						"order_item_name"               => $row['order_item_name'],
						"order_item_test_count"         => $row['order_item_test_count'],
						"order_quantity"                => $row['order_quantity'],
						"price"                         => $row['price'],
						"mrp"                           => $row['mrp'],
						"total"                         => $row['total'],
						"customer_members_Id"       	=> $row['customer_members_id'],
						"customer_members_prefix"       => $row['customer_members_prefix'],
						"customer_members_first_name"   => $row['customer_members_first_name'],
						"customer_members_last_name"    => $row['customer_members_last_name'],
						"customer_members_gender"       => $row['customer_members_gender'],
						"customer_members_relation"     => $row['customer_members_relation'],
						"customer_members_line1"        => $row['customer_members_line1'],
						"customer_members_pincode"      => $row['customer_members_pincode'],
						"customer_members_area"         => $row['customer_members_area'],
						"customer_members_age"          => $row['customer_members_age'],
						"customer_members_dob"          => $row['customer_members_dob'],
						"prescription_data"             => $row['prescription_data'],
						"packageDetails"                => $packageDetails
					];
				}
			}

			


			$result = [
				"orderMasterData" => $orderMasterData,
				"labData" => $labData,
				"collectionAddress" => $collectionAddressData,
				"orderItemData" => $orderItemData
			];
			$message = array("message" => '', "msgCode" => "1", "data" => $result);
		}
		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
