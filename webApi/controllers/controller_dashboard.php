<?
class _dashboard extends controller
{
	function init() {}
	function onload()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);
		$userPhone = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userPhone'));
		$deviceType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("deviceType"));
		$fcmToken = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("fcmToken"));
		$deviceId = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("deviceId"));
		$appVersion = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("appVersion"));

		$cityID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('cityID'));
		$cityID = $cityID == '' ? "1" : $this->app->utility->decrypt($cityID);

		$cartItemIds = array();
		if ($userID != '') {
			$obj_model_cart = $this->app->load_model("customer_cart");
			$cart = $obj_model_cart->execute("SELECT", false, "", "customer_cart.customer_id='" . $userID . "'", "customer_cart.id DESC");
			foreach ($cart as $item) {
				$cartItemIds[] = $item["cart_item_id"];
			}
		}

		if ($userID != '' && $userPhone != '' && $fcmToken != '') {
			$obj_model = $this->app->load_model("customer_token");
			$obj_model->set_fields_to_get(array("fcm_token"));
			$customer_token = $obj_model->execute("SELECT", false, "", "customer_id='" . $userID . "'");

			$data_t = array();
			if ($deviceType == 'Android') {
				$data_t['android_version'] = $appVersion;
				$data_t['fcm_token'] = $fcmToken;
				$data_t['android_device'] = $deviceId;
				$data_t['android_updated_at'] = date('d-m-Y H:i:s');
				$data_t['android_ip_address'] = $ip;
			} else {
				$data_t['iphone_version'] = $appVersion;
				$data_t['iphone_token'] = $fcmToken;
				$data_t['iphone_updated_at'] = date('d-m-Y H:i:s');
				$data_t['iphone_ip_address'] = $ip;
			}
			$obj_model = $this->app->load_model("customer_token");

			if (count($customer_token) > 0) {
				$obj_model->map_fields($data_t);
				$obj_model->execute("UPDATE", false, "", "customer_id='" . $userID . "'");
			} else {
				$data_t['customer_id'] = $userID;
				$obj_model->map_fields($data_t);
				$obj_model->execute("INSERT");
			}
		}

		
		$obj_model_city = $this->app->load_model('city');
		$city = $obj_model_city->execute("SELECT", false, "", "id='" . $cityID . "'");

		$cityDetail = [
					"id" => $this->app->utility->encrypt($city[0]['id']),
					"name" => $city[0]['name'],
					"slug" => $city[0]['slug'],
					"phone" => $city[0]['phone'],
					"whatsapp"=>'918586988847',
					"image" => $image
				];

		$obj_model_banner = $this->app->load_model('banner');
		$rs_banner = $obj_model_banner->execute("SELECT", false, "", "status='Active' and mobile_image!='' and FIND_IN_SET ('home',banner.show_page) and (FIND_IN_SET ('" . $cityID . "',banner.city_ids) or city_ids='')", "sort_id ASC");
		foreach ($rs_banner as $item) {
			$folder = 'main_banner_images';
			$image = $this->app->utility->get_image_path($item['mobile_image'], $folder, "large");

			$item['banner_link'] = str_replace('/category/','/category/' . $city[0]['slug'] . '/',$item['banner_link']);
			$item['banner_link'] = str_replace('/diseases/','/diseases/' . $city[0]['slug'] . '/',$item['banner_link']);

			$banner[] = [
				"ID" => $this->app->utility->encrypt($item['id']),
				"image" => $image,
				"itemID" => "",
				"page" => $item['banner_link']
			];
		}

		$obj_model_item_diseases = $this->app->load_model('item_diseases');
		$rs_item_diseases = $obj_model_item_diseases->execute("SELECT", false, "", "status='Active' and set_at_home='Yes'", "sort_order ASC limit 0,20");
		foreach ($rs_item_diseases as $item) {
			$folder = 'item_diseases';
			$image = $this->app->utility->get_image_path($item['image'], $folder, "large");
			$diseases[] = [
				"ID" => $item['id'],
				"image" => $image,
				"name" => $item['name'],
				"slug" => $item['slug'],
			];
		}

		$obj_model_item_category = $this->app->load_model('item_category');
		$item_category = $obj_model_item_category->execute("SELECT", false, "", "status='Active' and set_at_home='Yes'", "sort_order ASC limit 0,4");
		foreach ($item_category as $item) {
			$folder = 'item_category';
			$image = $this->app->utility->get_image_path($item['image'], $folder, "large");
			$category[] = [
				"ID" => $item['id'],
				"image" => $image,
				"name" => $item['name'],
				"slug" => $item['slug']
			];
		}

		$obj_model_popular_category = $this->app->load_model('item_category');
		$rs_popular_category = $obj_model_popular_category->execute("SELECT", false, "", "status='Active' and most_book_checkup='Yes'", "sort_order ASC limit 0,5");

		foreach ($rs_popular_category as $item) {
			$folder = 'item_category';
			$image = $this->app->utility->get_image_path($item['most_book_icon'], $folder, "large");
			$popular_category[] = [
				"ID" => $item['id'],
				"image" => $image,
				"name" => $item['name'],
				"slug" => $item['slug'],
				"type" => "category",
			];
		}

		$obj_most_book_checkup_item = $this->app->load_model('item');
		$obj_most_book_checkup_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$rs_most_book_checkup_item = $obj_most_book_checkup_item->execute("SELECT", false, "", "item.status='Active' and FIND_IN_SET('most_book_checkup', item_other_data.pagewise_test)", "sort_order ASC limit 0,5");

		foreach ($rs_most_book_checkup_item as $item) {
			$folder = 'item';
			$image = $this->app->utility->get_image_path($item['image'], $folder.'/'.$item['folder'], "large");
			$popular_category[] = [
				"ID" => $item['id'],
				"image" => $image,
				"name" => $item['name'],
				"slug" => $item['slug'],
				"type" => "item",
			];
		}

		$sort_cond = "item.sort_order ASC";
		$master_con = " and FIND_IN_SET ('" . $cityID . "',item.city_ids) and item_price.city_id='" . $cityID . "'";
		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id" => "item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id" => "item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id" => "item_id"));
		$records = $obj_model_all->execute("SELECT", false, "", "item.id!=0 and item.status='Active' and  item.set_at_home='Yes' " . $master_con . "", "" . $sort_cond . " limit 0,12", "");
		foreach ($records as $item) {

			$item_price_id = $item['item_price_id'];
			$name = $item['name'];
			$test_count = $item['test_count'];
			$price = $item['item_price_price'];
			$mrp = $item['item_price_mrp'];
			$sch_price = $item['item_price_sch_price'];
			$sch_start_date = $item['item_price_sch_start_date'];
			$sch_end_date = $item['item_price_sch_end_date'];
			if ($sch_price > 0 && $sch_start_date != '' && $sch_end_date != '') {
				$today_date = date('d-m-Y');
				$todaySlot = strtotime($today_date);
				$startSlot = strtotime($sch_start_date);
				$endSlot = strtotime($sch_end_date);
				if ($todaySlot >= $startSlot && $todaySlot <= $endSlot) {
					$price = $sch_price;
				}
			}
			$description1 = ($item['item_other_data_description']);
			$description_li = '';
			if ($description1 != '') {
				$description = mysqli_real_escape_string($this->app->set_db_conn(), $description1);
				$description = strip_tags($description);
				$description = str_replace(['\\r', '\\n'], ' ', $description);
				$description = $this->app->utility->string_truncate($description, 150);
				$description_li = $description;
			}
			$test_parameters_html = ($item['item_description_test_parameters']);
			if ($test_parameters_html != '') {
				$test_parameters_html = $this->app->utility->string_truncate($test_parameters_html, 100);
			}
			$test_parameters_html = '';

			$inCart = in_array($item['id'], $cartItemIds) ? true : false;

			$itemInfo[] = 'Total no.of Tests : ' . $test_count;
			$itemInfo[] = $description_li;
			if ($test_parameters_html != '') {
				$itemInfo[] = $test_parameters_html;
			}
			$percentage = 0;

			if ($mrp > $price && $mrp > 0) {
				$percentage = round((($mrp - $price) / $mrp) * 100) . '%';
			}

			$name = $item['name'];
			$item_price_id = $item['item_price_id'];
			$items[] = [
				"itemID" => $this->app->utility->encrypt($item['id']),
				"priceID" => $this->app->utility->encrypt($item_price_id),
				"name" => $name,
				"inCart" => $inCart,
				"price" => $price,
				"mrp" => $mrp > $price ? $mrp : '0.00',
				"percentage" => $percentage,
				"itemInfo" => $itemInfo
			];
			unset($itemInfo);
		}



		//-----------------START :: Radiology Scans & Imaging Tests
		$department_id = 1;
		$obj_model_tble = $this->app->load_model("item_category");
		$rs_category = $obj_model_tble->execute("SELECT", false, "", "status='Active' and set_at_home='Yes' and FIND_IN_SET ('" . $department_id . "',item_category.item_department_ids)", "sort_order ASC");


		foreach ($rs_category as $item) {
			$folder = 'item_category';
			$image = $item['banner_image'];
			$slug = $item['slug'];
			$blogImage = $this->app->utility->get_image_path($image, $folder, "large");
			$url = SERVER_ROOT . '/category/' .  $city[0]['slug'] . '/' . $slug . '';
			$radiologyAndImagingTest[] = [
				"name" => $item['name'],
				"slug" => $item['slug'],
				"short_description" => $item['short_description'],
				"starting_price" => $item['starting_price'],
				"image" => $blogImage,
				"url" => $url,
			];
		}
		//-----------------END :: Radiology Scans & Imaging Tests


		// HOME PATHOLOGY BANNER
		$obj_banner_pathology = $this->app->load_model("banner");
		$rs_pathology_banner = $obj_banner_pathology->execute("SELECT", false, "", "status='Active' and mobile_image!='' and show_page='home_pathology'", "sort_id ASC");
		$pathologyCatAndItemBanner = [];
		foreach($rs_pathology_banner as $banner_pathology) {
			$pathologyCatAndItemBanner[] = $this->app->utility->get_image_path($banner_pathology['mobile_image'], "main_banner_images", "large");
		}

		// HOME RADIOLOGY BANNER
		$obj_banner_radiology = $this->app->load_model("banner");
		$rs_banner_radiology = $obj_banner_radiology->execute("SELECT", false, "", "status='Active' and mobile_image!='' and show_page='home_radiology'", "sort_id ASC");
		$homeHealthTestsBanner = [];
		foreach($rs_banner_radiology as $banner_radiology) {
			$homeHealthTestsBanner[] = $this->app->utility->get_image_path($banner_radiology['mobile_image'], "main_banner_images", "large");
		}

		
		#-----------------------------------------------------------------------------#
		#-------------------- START : RADIOLOGY CATEGORY AND ITEM --------------------#
		#-----------------------------------------------------------------------------#
		$obj_model_item_home_category = $this->app->load_model('item_category');
		$rs_item_home_category = $obj_model_item_home_category->execute("SELECT", false, "", "status='Active' and FIND_IN_SET('1', item_department_ids) > 0 and set_at_home='Yes'", "sort_order ASC Limit 0,12");

		$homeHealthTests = [];

		foreach ($rs_item_home_category as $cat) {

			// Category URL
			$catUrl = SERVER_ROOT . '/category/' . $city[0]['slug'] . '/' . $cat['slug'];

			// Conditions (same as view)
			$sort_cond = "item.sort_order ASC";
			$city_cond = " and FIND_IN_SET ('" . $city[0]['id'] . "',item.city_ids)
                   and item_price.city_id='" . $city[0]['id'] . "'";
			$cat_cond  = " and FIND_IN_SET ('" . $cat['id'] . "',item_other_data.item_category_ids)";

			// $master_con = $g_search_query . $city_cond . $department_cond .
			// 	$type_cond . $dieses_cond . $cat_cond . $popular_pack_cond;

			$master_con =  $city_cond . $cat_cond;

			// Item Model
			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", ['test_parameters'], ["id" => "item_id"]);
			$obj_model_all->join_table("item_other_data", "left", [], ["id" => "item_id"]);
			$obj_model_all->join_table("item_price", "left", [], ["id" => "item_id"]);

			$records = $obj_model_all->execute(
				"SELECT",
				false,
				"",
				"item.id!=0 and item.status='Active' and item.set_at_home='Yes' " . $master_con,
				$sort_cond . " limit 0,12"
			);

			// Items Array
			$items = [];

			foreach ($records as $item) {

				// Price logic
				$mrp = $item['item_price_mrp'];
				$price = $item['item_price_price'];
				if (
					$item['item_price_sch_price'] > 0 &&
					strtotime(date('d-m-Y')) >= strtotime($item['item_price_sch_start_date']) &&
					strtotime(date('d-m-Y')) <= strtotime($item['item_price_sch_end_date'])
				) {
					$price = $item['item_price_sch_price'];
				}
				$inCart = in_array($item['id'], $cartItemIds) ? true : false;
				$percentage = 0;

				if ($mrp > $price && $mrp > 0) {
					$percentage = round((($mrp - $price) / $mrp) * 100) . '%';
				}
				$item_price_id = $item['item_price_id'];
				if($item['item_other_data_item_department_ids']=='1'){
					$line1 = 'Test Count : '.$test_count;
					$line2 = 'High-end Machines, Non Invasive Procedure, Painless & Online Reports';
				}else{
					$line1 = 'Parameters Included : '.$test_count;
					$line2 = 'Reports in 12 hours';
				}
				$items[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name"          => $item['name'],
					"slug"          => $item['slug'],
					"inCart" 		=> $inCart,
					"price"         => $price,
					"mrp" 			=> $mrp > $price ? $mrp : '0.00',
					"percentage" 	=> $percentage,
					"description"   => strip_tags($item['item_other_data_description']),
					"line1" 		=> $line1,
					"line2" 		=> $line2,
					"department" => $item['item_other_data_item_department_ids']??'',
					"url"           => SERVER_ROOT . '/tests/' . $item['slug'] . '/' . $city[0]['slug'],
				];
			}

			// Category Level
			$homeHealthTests[] = [
				"category_name" => $cat['name'],
				"slug"          => $cat['slug'],
				"url"           => $catUrl,
				"items"         => $items
			];
		}
		#-----------------------------------------------------------------------------#
		#--------------------- END : RADIOLOGY CATEGORY AND ITEM ---------------------#
		#-----------------------------------------------------------------------------#



		#-----------------------------------------------------------------------------#
		#-------------------- START : PATHOLOGY CATEGORY AND ITEM --------------------#
		#-----------------------------------------------------------------------------#
		$obj_model_item_home_category = $this->app->load_model('item_category');
		$rs_item_home_category = $obj_model_item_home_category->execute("SELECT", false, "", "status='Active' and FIND_IN_SET('2', item_department_ids) > 0 and set_at_home='Yes'", "sort_order ASC Limit 0,12");

		$pathologyCatAndItem = [];

		foreach ($rs_item_home_category as $cat) {

			// Category URL
			$catUrl = SERVER_ROOT . '/category/' . $city[0]['slug'] . '/' . $cat['slug'];

			// Conditions (same as view)
			$sort_cond = "item.sort_order ASC";
			$city_cond = " and FIND_IN_SET ('" . $city[0]['id'] . "',item.city_ids)
                   and item_price.city_id='" . $city[0]['id'] . "'";
			$cat_cond  = " and FIND_IN_SET ('" . $cat['id'] . "',item_other_data.item_category_ids)";

			$master_con =  $city_cond . $cat_cond;

			// Item Model
			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", ['test_parameters'], ["id" => "item_id"]);
			$obj_model_all->join_table("item_other_data", "left", [], ["id" => "item_id"]);
			$obj_model_all->join_table("item_price", "left", [], ["id" => "item_id"]);

			$records = $obj_model_all->execute(
				"SELECT",
				false,
				"",
				"item.id!=0 and item.status='Active' and item.set_at_home='Yes' " . $master_con,
				$sort_cond . " limit 0,8"
			);

			// Items Array
			$items = [];

			foreach ($records as $item) {

				// Price logic
				$mrp = $item['item_price_mrp'];
				$price = $item['item_price_price'];
				if (
					$item['item_price_sch_price'] > 0 &&
					strtotime(date('d-m-Y')) >= strtotime($item['item_price_sch_start_date']) &&
					strtotime(date('d-m-Y')) <= strtotime($item['item_price_sch_end_date'])
				) {
					$price = $item['item_price_sch_price'];
				}
				$inCart = in_array($item['id'], $cartItemIds) ? true : false;
				$percentage = 0;

				if ($mrp > $price && $mrp > 0) {
					$percentage = round((($mrp - $price) / $mrp) * 100) . '%';
				}
				$item_price_id = $item['item_price_id'];
				if($item['item_other_data_item_department_ids']=='1'){
					$line1 = 'Test Count : '.$test_count;
					$line2 = 'High-end Machines, Non Invasive Procedure, Painless & Online Reports';
				}else{
					$line1 = 'Parameters Included : '.$test_count;
					$line2 = 'Reports in 12 hours';
				}
				$items[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name"          => $item['name'],
					"slug"          => $item['slug'],
					"inCart" 		=> $inCart,
					"price"         => $price,
					"mrp" 			=> $mrp > $price ? $mrp : '0.00',
					"percentage" 	=> $percentage,
					"description"   => strip_tags($item['item_other_data_description']),
					"line1" 		=> $line1,
					"line2" 		=> $line2,
					"department" => $item['item_other_data_item_department_ids']??'',
					"url"           => SERVER_ROOT . '/tests/' . $item['slug'] . '/' . $city[0]['slug'],
				];
			}

			// Category Level
			$pathologyCatAndItem[] = [
				"category_name" => $cat['name'],
				"slug"          => $cat['slug'],
				"url"           => $catUrl,
				"items"         => $items
			];
		}
		#-----------------------------------------------------------------------------#
		#--------------------- END : PATHOLOGY CATEGORY AND ITEM ---------------------#
		#-----------------------------------------------------------------------------#


		$video_url ='https://youtu.be/EsZ0IVlCGRY';
		$forceUpdate = false;
		$showPopup = false;
		// if($appVersion=='1.4'){
		// 	$forceUpdate=false;
		// 	$showPopup=true;
		// }
		$appUpdate = ["forceUpdate" => $forceUpdate, "title" => "Alert", "msg" => "New App available", "showPopup" => $showPopup];

		$otherBanner[] = ["imageType" => "howItWork", "actionType" => "", "actionID" => "", "image" => SERVER_ROOT . '/uploads/otherBanner/how_it_work_image.png'];
		$otherBanner[] = ["imageType" => "certificate", "actionType" => "", "actionID" => "", "image" => SERVER_ROOT . '/uploads/otherBanner/accreditation1.png'];
		$otherBanner[] = ["imageType" => "bottomImage", "actionType" => "", "actionID" => "", "image" => SERVER_ROOT . '/uploads/otherBanner/dashboard_bottom_banner.png'];


		$aboutInfo[] = ["name" => "20 Labs Across 7 State", "image" => SERVER_ROOT . '/uploads/aboutInfo/features.png'];
		$aboutInfo[] = ["name" => "1800+ Touch Points Across India", "image" => SERVER_ROOT . '/uploads/aboutInfo/touch-points.png'];
		$aboutInfo[] = ["name" => "International Reach", "image" => SERVER_ROOT . '/uploads/aboutInfo/international.png'];
		$aboutInfo[] = ["name" => "38+ Year of\nExperience", "image" => SERVER_ROOT . '/uploads/aboutInfo/experience.png'];

		$obj_model_generel_settings = $this->app->load_model('generel_settings');
		$rs_generel_settings = $obj_model_generel_settings->execute("SELECT", false, "", "id='1'");

		$top_text = $rs_generel_settings[0]['display_coupon_code'];

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='home' and status!='Trash'");


		// Home item
		

			// Conditions (same as view)
			$sort_cond = "item.sort_order ASC";
			$city_cond = " and FIND_IN_SET ('" . $city[0]['id'] . "',item.city_ids)
                   and item_price.city_id='" . $city[0]['id'] . "'";
			
			$master_con =  $city_cond;

			// Item Model
			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", ['test_parameters'], ["id" => "item_id"]);
			$obj_model_all->join_table("item_other_data", "left", [], ["id" => "item_id"]);
			$obj_model_all->join_table("item_price", "left", [], ["id" => "item_id"]);

			$records = $obj_model_all->execute(
				"SELECT",
				false,
				"",
				"item.id!=0 and item.status='Active' and item.set_at_home='Yes' " . $master_con,
				$sort_cond . " limit 0,8"
			);

			// Items Array
			$homeItems = [];

			foreach ($records as $item) {

				// Price logic
				$mrp = $item['item_price_mrp'];
				$price = $item['item_price_price'];
				if (
					$item['item_price_sch_price'] > 0 &&
					strtotime(date('d-m-Y')) >= strtotime($item['item_price_sch_start_date']) &&
					strtotime(date('d-m-Y')) <= strtotime($item['item_price_sch_end_date'])
				) {
					$price = $item['item_price_sch_price'];
				}
				$inCart = in_array($item['id'], $cartItemIds) ? true : false;
				$percentage = 0;

				if ($mrp > $price && $mrp > 0) {
					$percentage = round((($mrp - $price) / $mrp) * 100) . '%';
				}
				$item_price_id = $item['item_price_id'];
				if($item['item_other_data_item_department_ids']=='1'){
					$line1 = 'Test Count : '.$test_count;
					$line2 = 'High-end Machines, Non Invasive Procedure, Painless & Online Reports';
				}else{
					$line1 = 'Parameters Included : '.$test_count;
					$line2 = 'Reports in 12 hours';
				}
				$homeItems[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name"          => $item['name'],
					"slug"          => $item['slug'],
					"inCart" 		=> $inCart,
					"price"         => $price,
					"mrp" 			=> $mrp > $price ? $mrp : '0.00',
					"percentage" 	=> $percentage,
					"description"   => strip_tags($item['item_other_data_description']),
					"line1" 		=> $line1,
					"line2" 		=> $line2,
					"department" => $item['item_other_data_item_department_ids']??'',
					"url"           => SERVER_ROOT . '/tests/' . $item['slug'] . '/' . $city[0]['slug'],
				];
			}

			
		

		$result = [
			"meta_title" => $meta_data[0]['page_title'],
			"meta_keyword" => $meta_data[0]['meta_keywords'],
			"meta_description" => $meta_data[0]['meta_description'],
			"meta_schema" => $meta_data[0]['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"debug" => 'false',
			"banner" => $banner,
			"diseases" => $diseases, "category" => $category,
			"popular_category" => $popular_category, 
			"items" => $homeItems,
			 "cityDetail" => $cityDetail, "otherBanner" => $otherBanner,
			"aboutInfo" => $aboutInfo, "appUpdate" => $appUpdate, "whatsapp" => "918586988847",
			"radiologyAndImagingTest" => $radiologyAndImagingTest,
			"healthTestAndPackages" => $homeHealthTests,
			"pathologyCatAndItem" => $pathologyCatAndItem,
			"pathologyCatAndItemBanner" => $pathologyCatAndItemBanner,
			"video_url"=>$video_url,"top_text"=>$top_text,
			"homeHealthTestsBanner"=>$homeHealthTestsBanner
		];

		$message = array("message" => "success.", "msgCode" => "1", "result" => $result);
		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
