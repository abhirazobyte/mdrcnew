<?php
class _blog_list extends controller
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
		$relatedBlogId = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("relatedBlogId"));
		$sort_by = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("sort_by"));

		$filter_by = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("filter_by"));
		$filter_value = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("filter_value"));


		$g_search_query='';
		if ($search != '') {
			$q = $search;
			$g_search_query .="and (blog.name LIKE '$q%' or blog.name LIKE '%$q%' or blog.name LIKE '%$q')";
		}

		if ($filter_by != '' && $filter_by == 'category' && $filter_value != '') {
			$obj_model_f = $this->app->load_model("blog_category");
			$filterResult = $obj_model_f->execute("SELECT", false, "", "slug='" . $filter_value . "'" );
			if(count($filterResult)>0){
				$g_search_query .="and category_id='".$filterResult[0]['id']."'";
			}
		}

		if ($filter_by != '' && $filter_by == 'tag' && $filter_value != '') {
			$obj_model_f = $this->app->load_model("blog_tag");
			$filterResult = $obj_model_f->execute("SELECT", false, "", "name='" . $filter_value . "'" );
			if(count($filterResult)>0){
				$g_search_query .= " AND FIND_IN_SET('".$filterResult[0]['id']."', tag_ids)";
			}
		}


		$cust_cond = "and blog.status='Active'";

		if ($relatedBlogId != '') {
			$obj_model_all = $this->app->load_model("blog");
			$relatedBlog = $obj_model_all->execute("SELECT", false, "", "blog.id='" . $relatedBlogId . "'" );
			$g_search_query .= "and category_id=".$relatedBlog[0]['category_id'];
		}

		$obj_model_all_data = $this->app->load_model("blog");
		$customer_order_master = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount from blog where blog.id!='' " . $cust_cond . " " . $g_search_query);
		$count = $customer_order_master[0]['allcount'];

		$limit = 10;
		$total_pages = intval($count / $limit);
		$start = $page == 0 ? 0 : ($page) * $limit;

		if ($count <= 0 || $total_pages < $page) {
			$message = array("message" => "No Blog Found.", "msgCode" => "0");
			$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
			echo $this->app->utility->indent($opt);
			exit;
		}

		if($sort_by=='latest'){
			$order_by = "STR_TO_DATE(blog.entry_date_time, '%d-%m-%Y %H:%i:%s') DESC";
		} elseif($sort_by=='old') {
			$order_by = "STR_TO_DATE(blog.entry_date_time, '%d-%m-%Y %H:%i:%s') ASC";
		} else {
			$order_by='blog.id DESC';
		}

		$obj_model_all = $this->app->load_model("blog");
		$obj_model_all->join_table("blog_category", "left", array("name", "slug"), array("category_id" => "id"));
		$order = $obj_model_all->execute("SELECT", false, "", "blog.id!='' " . $cust_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "");
		foreach ($order as $item) {
			$folder = $item['folder'];
			$image = $item['image'];
			$blogImage = $this->app->utility->get_image_path($image, 'blog/' . $folder . '/', 'large');
			$blogList[] = [
				"id" => $item['id'],
				"slug" => $item['slug'],
				"name" => $item['name'],
				"short_info" => $item['short_info'],
				"image" => $blogImage,
				"category" => $item['blog_category_name'],
			];
		}

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='blog' and status!='Trash'");

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
			"meta_title" => $meta_data[0]['page_title'],
			"meta_keyword" => $meta_data[0]['meta_keywords'],
			"meta_description" => $meta_data[0]['meta_description'],
			"meta_schema" => $meta_data[0]['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"blogList" => $blogList,
			"categories" => $blogCategories,
			"heading" => 'Modern Diagnostic Health Blogs',
			"title" => 'Health & Fitness insights for a healthier you',
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
