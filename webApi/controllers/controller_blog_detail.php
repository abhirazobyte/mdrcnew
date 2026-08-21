<?
class _blog_detail extends controller
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


		$g_search_query = "and blog.status='Active'";
		$obj_model_all = $this->app->load_model("blog");
		$obj_model_all->join_table("blog_category", "left", array("name", "slug"), array("category_id" => "id"));
		$item = $obj_model_all->execute("SELECT", false, "", "blog.slug='" . $detailSlug . "'" . $g_search_query);
		$item = $item[0];



		$folder = $item['folder'];
		$image = $item['image'];
		$blogImage = $this->app->utility->get_image_path($image, 'blog/' . $folder . '/', 'large');

		if($item['tag_ids']!=''){
			$obj_model_tag = $this->app->load_model("blog_tag");
			$tagItem = $obj_model_tag->execute("SELECT", false, "", "id IN (" . $item['tag_ids'] . ")" );
			foreach ($tagItem as $tag) {
				$tags_array[] = [
					"name" => $tag['name'],
					"slug" => $tag['slug']
				];
			}
		} else{
			$tags_array[]=null;
		}
		
		

		$blogDetail = [
			"id" => $item['id'],
			"slug" => $item['slug'],
			"name" => $item['name'],
			"short_info" => $item['short_info'],
			"image" => $blogImage,
			"category" => $item['blog_category_name'],
			"detail" => $item['about_info'],
			"tags" => $item['tags'],
			"tags_array" => $tags_array,
		];

		$obj_model_all = $this->app->load_model("blog_category");
		$categories = $obj_model_all->execute("SELECT", false, "", " status='Active'");
		foreach ($categories as $category) {
			$blogCategories[] = [
				"id" => $category['id'],
				"slug" => $category['slug'],
				"name" => $category['name'],
			];
		}

		$result = [
			"meta_title" => $item['meta_title'],
			"meta_keyword" => $item['meta_keywords'],
			"meta_description" => $item['meta_description'],
			"meta_schema" => $item['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"blogDetail" => $blogDetail,
			"categories" => $blogCategories
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
