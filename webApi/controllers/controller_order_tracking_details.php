<?
class _order_tracking_details extends controller
{


	function init() {}

	function onload()
	{

		$track_orderID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("track-orderID"));
		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("userID"));

		$track_orderCustomerMemeberID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("track-orderCustomerMemeberID"));

		$orderID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("orderID"));
		$orderCustomerMemeberID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("orderCustomerMemeberID"));

		$orderID = $track_orderID == '' ? $orderID : $track_orderID;
		$orderCustomerMemeberID = $track_orderCustomerMemeberID == '' ? $orderCustomerMemeberID : $track_orderCustomerMemeberID;

		$track_password = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("tracking-password"));

		if ($orderID != '' && $orderCustomerMemeberID != '') {

			$obj_model_order_cust_detail = $this->app->load_model("customer_order_detail");
			$obj_model_order_cust_detail->join_table("customer_members", "left", [], ["customer_members_id" => "id"]);
			$obj_model_order_cust_detail->join_table("customer_order_master", "left", ["display_order_no"], ["order_master_id" => "id"]);

			$rs_cust_detail = $obj_model_order_cust_detail->execute(
				"SELECT",
				false,
				"",
				"order_master_id='" . $orderID . "' and customer_order_detail.customer_members_id='" . $orderCustomerMemeberID . "'"
			);

			if (count($rs_cust_detail) <= 0 || $userID <= 0) {
				$message = ["message" => "Please try after sometime.", "msgCode" => "0"];
				$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}

			$visitor_id = $rs_cust_detail[0]['lis_visitor_id'];
			$lab_password = $rs_cust_detail[0]['lis_visitor_pass'];
			$orderNo = $rs_cust_detail[0]['customer_order_master_display_order_no'];
			$customerName = $rs_cust_detail[0]['customer_members_prefix'] . ' ' . $rs_cust_detail[0]['customer_members_first_name'] . ' ' . $rs_cust_detail[0]['customer_members_last_name'];

			// Call LIS API
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => LIS_API_URL . '/BookingAPI/TestStatusAPI',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => 'WorkOrderID=' . $visitor_id,
				CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
			]);
			$response = mdrc_curl_exec($curl);
			curl_close($curl);

			$api_response = $response ? json_decode($response, true) : [];

			// print_r($rs_cust_detail);
			// exit;

			if (empty($api_response[0]['Booking_Status'])) {
				$message = ["message" => "Please enter valid details.", "msgCode" => "0"];
				$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}

			// Password validation
			$PMPassword_webob = $api_response[0]['Password_web'] ?? '';
			if (!empty($track_password) && $track_password != $PMPassword_webob) {
				$message = ["message" => "Invalid password", "msgCode" => "0"];
				$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}



			// Prepare response arrays
			$patientInfo = [
				"orderNo" => $orderNo,
				"patientName" => $customerName,
				"patientMobile" => $api_response[0]['PMob'] ?? '',
				"bookingDate" => $api_response[0]['EntryDate'] ?? ''
			];

			$tests = [];
			$report_ready = false;
			foreach ($api_response as $item) {
				$status = $item['Booking_Status'];
				if (in_array($status, ['Report Ready', 'Dispatched', 'Printed'])) {
					$status_name = 'Report Ready';
					$report_ready = true;
				} else if (in_array($status, ['Sample Receive At Lab', 'Rejected Test', 'Sample Collected', 'Tested', 'Hold'])) {
					$status_name = 'Received in lab';
				} else {
					$status_name = $status;
				}

				$tests[] = [
					"itemName" => $item['ItemName'] ?? '',
					"status" => $status_name
				];
			}

			$downloadUrl = $report_ready ? SERVER_ROOT . "/Design/Lab/labreportnew.aspx?reportid=" . $visitor_id . "_" . $lab_password : "";

			$result = [
				"patientInfo" => $patientInfo,
				"tests" => $tests,
				"reportReady" => $report_ready,
				"downloadUrl" => $downloadUrl
			];

			$message = ["message" => "success", "msgCode" => "1", "result" => $result];
			$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
			echo $this->app->utility->indent($opt);
			exit;
		} else {
			$message = ["message" => "Data missing", "msgCode" => "0"];
			$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
			echo $this->app->utility->indent($opt);
			exit;
		}
	}
}
