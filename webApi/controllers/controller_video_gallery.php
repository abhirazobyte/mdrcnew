<?



class _video_gallery extends controller
{



	function init() {}

	function onload()
	{

		$ip = $_SERVER['REMOTE_ADDR'];

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);

		$obj_model_gallery = $this->app->load_model("video_gallery");
		$rs_gallery = $obj_model_gallery->execute("SELECT", false, "", "status='Active'", "sort_order ASC");

		foreach ($rs_gallery as $item) {
			$galleryVideoList[] = [
				"id" => $item['id'],
				"video_link" => $item['video_link'],
			];
		}

		$result = ["galleryVideoList" => $galleryVideoList];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
