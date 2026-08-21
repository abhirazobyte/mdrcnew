<?
class _payment_success extends controller
{

	function init() {}

	function onload()
	{

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);
		$orderID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('orderID'));
		// $orderID = $this->app->utility->decrypt($orderID);
		$orderPayID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('orderPayID'));

		$obj_order_master = $this->app->load_model("customer_order_master");
		$rs_data = $obj_order_master->execute("SELECT", false, "", "customer_order_master.id='" . $orderID . "'");
		if (count($rs_data) > 0) {
			$bookingSummary = [
				"order_no" => $rs_data[0]['display_order_no'],
				"order_date" => $rs_data[0]['order_date'],
				"grand_total" => $rs_data[0]['net_order_value'],
			];

			$obj_order_table = $this->app->load_model("customer_order_collection_address");
			$obj_order_table->join_table("city", "left", array("name"), array("city_id" => "id"));
			$obj_order_table->join_table("state", "left", array("name"), array("state_id" => "id"));
			$rs_collection_address = $obj_order_table->execute("SELECT", false, "", "customer_order_collection_address.order_master_id='" . $orderID . "'");
			$collectionAddressData = [
				"collection_date" => $rs_data[0]['home_collection_date'],
				"collection_time" => $rs_data[0]['home_collection_slot'],
				"prefix" => $rs_collection_address[0]['prefix'],
				"first_name" => $rs_collection_address[0]['first_name'],
				"last_name" => $rs_collection_address[0]['last_name'],
				"gender" => $rs_collection_address[0]['gender'],
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
				"collection_date" => $rs_data[0]['lab_prefer_date'],
				"collection_time" => $rs_data[0]['lab_prefer_slot'],
			];


			$obj_order_tble = $this->app->load_model("customer_order_detail");
			$obj_order_tble->join_table("customer_members", "left", array("prefix", "first_name", "last_name", "gender", "relation", "line1", "pincode", "area_id", "area"), array("customer_members_id" => "id"));
			$rs_order_detail = $obj_order_tble->execute("SELECT", false, "", "customer_order_detail.order_master_id='" . $orderID . "'");
			// Loop through multiple order details
			$orderItemData = [];

			if (!empty($rs_order_detail)) {
				foreach ($rs_order_detail as $key => $row) {
					$orderItemData[] = [
						"order_item_name"               => $row['order_item_name'],
						"order_item_test_count"         => $row['order_item_test_count'],
						"price"                         => $row['price'],
						"mrp"                           => $row['mrp'],
						"total"                         => $row['total'],
						"customer_members_prefix"       => $row['customer_members_prefix'],
						"customer_members_first_name"   => $row['customer_members_first_name'],
						"customer_members_last_name"    => $row['customer_members_last_name'],
						"customer_members_gender"       => $row['customer_members_gender'],
						"customer_members_relation"     => $row['customer_members_relation'],
					];
				}
			}
			//get payment data if order is online
			if ($orderPayID > 0) {
				$obj_model_payment_data = $this->app->load_model("customer_order_payment_data");
				$result_pay = $obj_model_payment_data->execute("SELECT", false, "", "id='" . $orderPayID . "'");

				$obj_model_payment_data = $this->app->load_model("customer_order_payment_data");
				$payments = $obj_model_payment_data->execute("SELECT", false, "", "order_master_id='" . $orderID . "' and payment_status='Success'");

				$paymentData = [
					"payment_type" => $result_pay[0]['payment_type'],
					"subtotal" => $rs_data[0]['subtotal'],
					"collection_charge" => $rs_data[0]['collection_charge'],
					"discount" => $rs_data[0]['discount'],
					"wallet_amount" => $rs_data[0]['wallet_amount'],
					"promo_wallet_amount" => $rs_data[0]['promo_wallet_amount'],
					"online_amount" => $rs_data[0]['online_amount'],
					"total_amount" => $rs_data[0]['net_order_value'],
					"payment_status" => $result_pay[0]['payment_status'],
					'total_paid_amount' =>$payments ? array_sum(array_column($payments, 'transaction_amount')) : 0,
					"due_amount" => $rs_data[0]['net_order_value'] - (array_sum(array_column($payments, 'transaction_amount'))),
				];
			}

			$result = ["bookingSummary" => $bookingSummary,  "orderItemData" => $orderItemData, "labData" => $labData, "paymentData" => $paymentData, "collectionAddress" => $collectionAddressData,];
			$message = array("message" => '', "msgCode" => "1", "data" => $result);
		} else {
			$message = array("message" => "Something Went Wong.", "msgCode" => "0");
		}
		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
