<?
class _career_list extends controller
{

	function init() {}

	function onload()
	{

		$ip = $_SERVER['REMOTE_ADDR'];

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);

		$obj_model_job_opening = $this->app->load_model("job_opening");
		$jobOpenings = $obj_model_job_opening->execute("SELECT", false, "", "status='Active'", "sort_order ASC");

		foreach ($jobOpenings as $item) {
			$jobList[] = [
				"id" => $item['id'],
				"title" => $item['title'],
				"no_of_opening" => $item['no_of_opening'],
				"description" =>  $item['description'],
			];
		}


		$other = [
			"heading" => 'Career',
			"description" => 'Everyone seeks a rewarding career. Modern Diagnostic & Research Centre welcomes every such individual with ignited minds We believe in nurturing talent, encouraging innovation, and providing opportunities to grow professionally in a supportive environment. Join us to build a meaningful career where your skills and passion truly matter.',
			"section_image" => "https://www.mdrcindia.com/images/clinic-patient.png",
			"section_heading" => 'Perspective of clinic to patient',
			"section_description" => 'Our success is based on teamwork, working together to have an environment based on dignity and respect across the wide variety of job roles that exist within our company Since the inception of Modern in 1985, it is our mission to bring the best and latest technology available anywhere in the world so as to diagnose diseases at an early stage and thus help the patient and the clinician in better management of illness.',
		];

		$result = ["jobList" => $jobList, "other" => $other];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
