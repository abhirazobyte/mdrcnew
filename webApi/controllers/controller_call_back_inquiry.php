<?

class _call_back_inquiry extends controller
{



	function init() {}

	function onload()
	{

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);

		$name = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('name'));
		$phone = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("phone"));
		$city = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("city"));
		$fmessage = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("message"));

		if ($name != '' && $phone != '') {

			$fields_map = array();
			$fields_map['customer_id'] = $userID;
			$fields_map['name'] = $name;
			$fields_map['city'] = $city;
			$fields_map['phone'] = $phone;
			$fields_map['message'] = $fmessage;
			$fields_map['ip'] = $_SERVER['REMOTE_ADDR'];
			$fields_map['added'] =  date('Y-m-d');

			$obj_model_newsletter = $this->app->load_model('get_call_back');
			$obj_model_newsletter->map_fields($fields_map);
			$id = $obj_model_newsletter->execute("INSERT");


			if ($id > 0) {
				/*------------------Start for mail function------------------*/
				$template_name = 'get_in_touch_admin';
				$send_data_arary = ['name' => $name, 'city' => $city, 'phone' => $phone, 'message' => $fmessage];
				$subject = 'Get In Touch from ' . $name . ' on Website';
				$mail_for = 'Admin';
				$data = ['template_name' => $template_name, 'send_data_arary' => $send_data_arary, 'subject' => $subject, 'mail_for' => $mail_for];
				$this->app->utility->sendMial($data);
				/*------------------End for mail function------------------*/

				//call api for add data in crm
				$obj_model_phone = $this->app->load_model('get_call_back');
				$checkPhone = $obj_model_phone->execute("SELECT", false, "", "phone='" . $phone . "'");
				if (count($checkPhone) <= 0 && !(function_exists('mdrc_external_api_removed') && mdrc_external_api_removed())) {
					require_once('../ripcord-master/ripcord.php');

					$url = CRM_URL;
					$db = CRM_DB;
					$email = CRM_EMAIL;
					$password = CRM_PASSWORD;

					$common = ripcord::client("$url/xmlrpc/2/common");
					$uid = $common->authenticate($db, $email, $password, []);

					if (!empty($uid)) {
						$models = ripcord::client("$url/xmlrpc/2/object");

						// an example of how to call the create method in res.partner model
						$values = [
							'name' => $name,
							'city' => $city,
							'mobile' => $phone
						];
						$partners = $models->execute_kw($db, $uid, $password, 'res.partner', 'create', [$values]);
					}
				}


				$inquiryData = ['inquiryID' => $this->app->utility->encrypt($id), 'name' => $name, 'phone' => $phone, 'city' => $city, 'message' => $fmessage];
				$result = ["inquiryData" => $inquiryData];
				$message = array("message" => 'Call Back Inquiry Submitted Successfully.', "msgCode" => "1", "result" => $result);
			} else {
				$message = array("message" => "Something went wrong !.", "msgCode" => "0");
			}
		} else {
			$message = array("message" => "Date missing.", "msgCode" => "0");
		}

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
