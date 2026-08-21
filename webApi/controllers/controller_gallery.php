<?



class _gallery extends controller
{



	function init() {}
	function onload()
	{

		$ip = $_SERVER['REMOTE_ADDR'];

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);

	

		$obj_model_gallery = $this->app->load_model("gallery");
		$obj_model_gallery->join_table("gallery_category", "left", array(), array("gallery_category_id" => "id"));
		$order = $obj_model_gallery->execute("SELECT", false, "", "gallery.status='Active' and gallery_category.status='Active'", "gallery.id DESC");

		foreach ($order as $item) {
			$image = $item['image'];
			$galleryImage = $this->app->utility->get_image_path($image, 'gallery/', 'large');
			$galleryList[] = [
				"id" => $item['id'],
				"image" => $galleryImage,
				"category" => $item['gallery_category_name'],
			];
		}

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='gallery' and status!='Trash'");

		$result = [
			"meta_title" => $meta_data[0]['page_title'],
			"meta_keyword" => $meta_data[0]['meta_keywords'],
			"meta_description" => $meta_data[0]['meta_description'],
			"meta_schema" => $meta_data[0]['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"galleryList" => $galleryList
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
