<?php
class _doctor_details extends controller {

	function init() {
	}

	function onload() {
		$doctor_slug = $this->app->getGetVar("doctor_slug");

		if ($doctor_slug == '') {
			$this->app->redirect(SERVER_ROOT . "/our-doctors");
			exit;
		}

		$obj_model_doctor = $this->app->load_model("doctor");
		$obj_model_doctor->join_table("doctor_category", "left", array("name"), array("category_id" => "id"));
		$records = $obj_model_doctor->execute(
			"SELECT",
			false,
			"",
			"doctor.status='Active' and doctor.slug='" . $doctor_slug . "'",
			"doctor.id"
		);

		if (count($records) <= 0) {
			$this->app->redirect(SERVER_ROOT . "/404");
			exit;
		}

		$doctor = $records[0];
		$this->app->assign("doctor", $doctor);

		$obj_model_related = $this->app->load_model("doctor");
		$obj_model_related->join_table("doctor_category", "left", array("name"), array("category_id" => "id"));
		$rs_related = $obj_model_related->execute(
			"SELECT",
			false,
			"",
			"doctor.status='Active' and doctor.id!='" . $doctor['id'] . "' and doctor.category_id='" . $doctor['category_id'] . "'",
			"doctor.sort_order ASC LIMIT 0,4"
		);
		$this->app->assign("rs_related", $rs_related);

		$meta_title = $doctor['name'] . " - Our Doctors | MDRC India";
		$meta_description = !empty($doctor['designation'])
			? $doctor['name'] . " - " . $doctor['designation']
			: $doctor['name'] . " - MDRC India";

		$this->app->setTitle($meta_title); 
		$this->app->setDescription($meta_description);
	}
}
?>
