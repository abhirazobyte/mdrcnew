<?
class _page extends controller
{
	function init() {
		###
	}

	function onload()
	{
		$slug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("slug"));

		$obj_model_all = $this->app->load_model("pages");
		$item = $obj_model_all->execute("SELECT", false, "", "pages.slug='" . $slug . "'");

		$blogCategories=[];
		foreach ($item as $category) {
			$blogCategories[] = [
				"id" => $category['id'],
				"page_title" => $category['page_title'],
				"page_description" => $category['page_description'],
			];
		}

		$result = ["page" => $blogCategories];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
