<?

class _service_details extends controller
{


	function init() {}

	function onload()
	{
		$slug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("slug"));
		$obj_model_for_doctors = $this->app->load_model("for_doctors_services");
		$records = $obj_model_for_doctors->execute("SELECT", false, "", "id!=0 and status='Active' and slug='" . $slug . "'");

		$obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
		$other_services = $obj_model_for_doctors_services->execute("SELECT", false, "", "id!='" . $records[0]['id'] . "' and status='Active' and for_doctors_id='" . $records[0]['for_doctors_id'] . "'", "sort_order ASC");

		//DOCTORS
		$image = $records[0]['image'];
		$serviceImage = $this->app->utility->get_image_path($image, 'for_doctors_services/', 'large');
		$serviceDetail[] = [
			"title" => $records[0]['title'],
			"short_desc" => $records[0]['short_desc'],
			"image" => $serviceImage,
			"description" => $records[0]['decsription'],
		];

		//SERVICES
		foreach ($other_services as $item) {
			$image = $item['image'];
			$otherserviceImage = $this->app->utility->get_image_path($image, 'for_doctors_services/', 'large');
			$otherServices[] = [
				"slug" => $item['slug'],
				"title" => $item['title'],
				"image" => $otherserviceImage,
			];
		}


		$result = ["serviceDetail" => $serviceDetail, "otherServices" => $otherServices];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}

	
}
