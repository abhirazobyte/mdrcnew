<?
class _for_doctors extends controller
{

	function init() {}

	function onload()
	{
		$slug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("slug"));

		$obj_model_for_doctors = $this->app->load_model("for_doctors");
		$records = $obj_model_for_doctors->execute("SELECT", false, "", "id!=0 and status='Active' and slug='" . $slug . "'");

		$obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
		$records_services = $obj_model_for_doctors_services->execute("SELECT", false, "", "id!=0 and status='Active' and for_doctors_id='" . $records[0]['id'] . "'", "sort_order ASC");


		//DOCTORS
		$recordDoctor[] = [
			"title" => $records[0]['title'],
			"description" => $records[0]['short_desc'],

		];

		//SERVICES
		foreach ($records_services as $item) {
			$image = $item['image'];
			$serviceImage = $this->app->utility->get_image_path($image, 'for_doctors_services/', 'large');
			$services[] = [
				"slug" => $item['slug'],
				"title" => $item['title'],
				"image" => $serviceImage,
			];
		}

		//accreditations
		$accreditations[] = [
			"title" => "Accreditations",
			"items" => [
				[
					"image" => SERVER_ROOT . "/images/nabh-logo.png",
					"name"  => "MIS- 2017-0045"
				],
				[
					"image" => SERVER_ROOT . "/images/nabl-new-logo.png",
					"name"  => "MC-2334"
				]
			]
		];

		//SPECIALITY

		$speciality[] = [
			"title" => "Our Specialities",
			"description" => "All Diagnostic Services Under One Roof",
			"items" => [
				[
					"image" => SERVER_ROOT . "/images/a.png",
					"title" => "Routine Testing",
					"description"  => "Routine investigations coverage from wellness to illness"
				],
				[
					"image" => SERVER_ROOT . "/images/b.png",
					"title" => "Pathology Services",
					"description"  => "Super specialized department to diagnose auto immune disorders"
				],
				[
					"image" => SERVER_ROOT . "/images/c.png",
					"title" => "Genomic Testing",
					"description"  => "Advanced genetic testing to know your health risks"
				],
				[
					"image" => SERVER_ROOT . "/images/d.png",
					"title" => "Radiology",
					"description"  => "Advanced Medical Imaging procedures for your health diagnosis"
				]
			]
		];


		//OTHER
		$other[] = [
			"title" => "Get safe testing with MODERN labs",
			"items" => [
				[
					"image" => SERVER_ROOT . "/images/about/a1.svg",
					"description"  => "Call and schedule an appointment with our Health Expert"
				],
				[
					"image" => SERVER_ROOT . "/images/about/a2.svg",
					"description"  => "We will Schedule appointment as per your availability and pick sample from your home"
				],
				[
					"image" => SERVER_ROOT . "/images/about/a3.svg",
					"description"  => "High Quality Lab testing done in our Accredited Labs"
				],
				[
					"image" => SERVER_ROOT . "/images/about/a4.svg",
					"description"  => "Get your test reports over whatsapp or Download from your web account."
				]
			]
		];

		$obj_model_meta=$this->app->load_model('meta');
		$rs_meta=$obj_model_meta->execute("SELECT",false,"","");

		$result = [
			"meta_title" => $rs_meta[0]['title'],
			"meta_keyword" => $rs_meta[0]['keyword'],
			"meta_description" => $rs_meta[0]['description'],
			"meta_schema" => '',
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"recordDoctor" => $recordDoctor,
			"services" => $services,
			"accreditations" => $accreditations,
			"speciality" => $speciality,
			"other" => $other
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
