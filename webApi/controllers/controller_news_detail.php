<?
class _news_detail extends controller
{
	function init() {}
	function onload()
	{

		$ip = $_SERVER['REMOTE_ADDR'];

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);
		$userPhone = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userPhone'));
		$deviceType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("deviceType"));
		$search = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("search"));
		$page = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("page"));
		$detailId = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("detailId"));
		$detailSlug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("detailSlug"));


		$g_search_query = "and event.status='Active'";
		$obj_model_all = $this->app->load_model("event");
		$obj_model_all->join_table("event_category", "left", array("name", "slug"), array("category_id" => "id"));
		$item = $obj_model_all->execute("SELECT", false, "", "event.slug='".$detailSlug."'".$g_search_query);
		$item = $item[0];

		$folder = $item['folder'];
		$image = $item['image'];
		$eventImage = $this->app->utility->get_image_path($image, 'event/' . $folder . '/', 'large');
		$eventDetail[] = [
			"id" => $item['id'],
			"slug" => $item['slug'],
			"name" => $item['name'],
			"short_info" => $item['short_info'],
			"image" => $eventImage,
			// "category" => $item['event_category_name'],
			"detail" => $item['about_info'],
			"tags" => $item['tags'],

		];

		$result = ["newsDetail" => $eventDetail];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
