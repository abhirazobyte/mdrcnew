<?php
class _news_list extends controller
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
		$relatedEventId = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("relatedEventId"));
		$sort_by = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("sort_by"));


		$g_search_query='';
		if ($search != '') {
			$q = $search;
			$g_search_query .="and (event.name LIKE '$q%' or event.name LIKE '%$q%' or event.name LIKE '%$q')";
		}

		$cust_cond = "and event.status='Active'";

		if ($relatedEventId != '') {
			$obj_model_all = $this->app->load_model("event");
			$relatedEvent = $obj_model_all->execute("SELECT", false, "", "event.id='" . $relatedEventId . "'" );
			$g_search_query .= "and category_id=".$relatedEvent[0]['category_id'];
		}

		$obj_model_all_data = $this->app->load_model("event");
		$customer_order_master = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount from event where event.id!='' " . $cust_cond . " " . $g_search_query);
		$count = $customer_order_master[0]['allcount'];

		$limit = 10;
		$total_pages = intval($count / $limit);
		$start = $page == 0 ? 0 : ($page) * $limit;

		if ($count <= 0 || $total_pages < $page) {
			$message = array("message" => "No News Found.", "msgCode" => "0");
			$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
			echo $this->app->utility->indent($opt);
			exit;
		}

		if($sort_by=='latest'){
			$order_by = "STR_TO_DATE(event.entry_date_time, '%d-%m-%Y %H:%i:%s') DESC";
		} elseif($sort_by=='old') {
			$order_by = "STR_TO_DATE(event.entry_date_time, '%d-%m-%Y %H:%i:%s') ASC";
		} else {
			$order_by='event.sort_order ASC';
		}

		$obj_model_all = $this->app->load_model("event");
		$obj_model_all->join_table("event_category", "left", array("name", "slug"), array("category_id" => "id"));
		$order = $obj_model_all->execute("SELECT", false, "", "event.id!='' " . $cust_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "");
		foreach ($order as $item) {
			$folder = $item['folder'];
			$image = $item['image'];
			$eventImage = $this->app->utility->get_image_path($image, 'event/' . $folder . '/', 'large');
			$eventList[] = [
				"id" => $item['id'],
				"slug" => $item['slug'],
				"name" => $item['name'],
				"short_info" => $item['short_info'],
				"image" => $eventImage,
				// "category" => $item['event_category_name'],
			];
		}

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='news_and_events' and status!='Trash'");

		$result = [
			"meta_title" => $meta_data[0]['page_title'],
			"meta_keyword" => $meta_data[0]['meta_keywords'],
			"meta_description" => $meta_data[0]['meta_description'],
			"meta_schema" => $meta_data[0]['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"newsList" => $eventList
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
