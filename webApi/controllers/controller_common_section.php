<?php
class _common_section extends controller
{
	function init() {}

	function onload()
	{
		$cityID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('cityID'));
		$cityID = $cityID != '' ? $this->app->utility->decrypt($cityID) : "";
		$pageSlug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('pageSlug'));

		$pageType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('pageType'));

		if (!$cityID) $cityID = 1;

		// Get city info
		$obj_model_city = $this->app->load_model('city');
		$citydata = $obj_model_city->execute("SELECT", true, "", "status='Active' AND id='" . $cityID . "'");

		// Get types array
		$types = $this->app->getPostVar('types');
		if (!is_array($types)) $types = array($types);

		// Sanitize
		$types = array_map(function ($t) {
			return mysqli_real_escape_string($this->app->set_db_conn(), trim($t));
		}, $types);


		//-----------------TAGS :: START------------------------
		if (in_array('tags', $types)) {

			// Cities
			$obj_model_city = $this->app->load_model('city');
			$rs_gs_city = $obj_model_city->execute("SELECT", false, "", "status='Active'", "sort_order ASC");

			// Items
			$obj_model = $this->app->load_model('item');
			$obj_model->join_table("item_other_data", "left", ['item_id', 'item_category_ids', 'item_key_fetures_ids', 'item_department_ids', 'item_diseases_ids', 'item_type_id'], ['id' => 'item_id']);
			$obj_model->join_table("item_price", "left", [], ['id' => 'item_id']);
			$city_cond = " AND FIND_IN_SET('" . $cityID . "', item.city_ids) AND item_price.city_id='" . $cityID . "'";
			$items = $obj_model->execute("SELECT", false, "", "item.status='Active'" . $city_cond, "item.id DESC");

			// Item category
			$obj_model = $this->app->load_model('item_category');
			$item_category = $obj_model->execute("SELECT", false, "", "item_category.status='Active'", "sort_order ASC");

			// Item diseases
			$obj_model = $this->app->load_model('item_diseases');
			$item_diseases = $obj_model->execute("SELECT", false, "", "item_diseases.status='Active'", "sort_order ASC");


			// 1. Our Presence (Cities)
			if (count($rs_gs_city) > 0) {
				$cityLinks = [];
				foreach ($rs_gs_city as $city) {
					$cityLinks[] = [
						"title" => $city['name'],
						"link"  => "/premium-health-checkup/" . $city['slug'],
					];
				}

				$accordion[] = [
					"title" => "Our Presence",
					"key"   => "city",
					"child" => $cityLinks
				];
			}

			// 2. Popular Health Tests & Packages
			$popularTests = [];
			$j = 0;
			foreach ($items as $test) {
				$testCats = explode(',', $test['item_other_data_item_department_ids']);
				if (in_array('2', $testCats) && $test['set_at_popular_test'] === 'Yes') {
					if ($j++ >= 30) break;
					$popularTests[] = [
						"title" => $test['name'] . ' In ' . $citydata[0]['name'],
						"link"  => "/tests/{$test['slug']}/{$citydata[0]['slug']}"
					];
				}
			}

			$accordion[] = [
				"title" => "Popular Health Tests & Packages",
				"key"   => "popular_tests",
				"child" => $popularTests
			];

			// 3. Popular Radiology Tests & Packages
			$popularRadiology = [];
			$j = 0;
			foreach ($items as $test) {
				$testCats = explode(',', $test['item_other_data_item_department_ids']);
				if (in_array('1', $testCats) && $test['set_at_popular_test'] === 'Yes') {
					if ($j++ >= 30) break;
					$popularRadiology[] = [
						"title" => $test['name'] . ' In ' . $citydata[0]['name'],
						"link"  => "/tests/{$test['slug']}/{$citydata[0]['slug']}"
					];
				}
			}

			$accordion[] = [
				"title" => "Popular Radiology Tests & Packages",
				"key"   => "popular_radiology",
				"child" => $popularRadiology
			];

			// 4. Popular Categories
			$popularCategories = [];
			$j = 0;
			foreach ($item_category as $cat) {
				$Cats = explode(',', $cat['item_department_ids']);
				if (in_array('2', $Cats)) {
					if ($j++ >= 30) break;
					$popularCategories[] = [
						"title" => $cat['name'],
						"link"  => "/category/{$citydata[0]['slug']}/{$cat['slug']}"
					];
				}
			}

			$accordion[] = [
				"title" => "Popular Categories",
				"key"   => "categories",
				"child" => $popularCategories
			];

			// 5. Test by Risk 
			$testByRisk = [];
			$j = 0;
			foreach ($item_diseases as $disease) {
				$Cats = explode(',', $disease['item_department_ids']);
				if (in_array('1', $Cats)) {
					if ($j++ >= 30) break;
					$testByRisk[] = [
						"title" => $disease['name'],
						"link"  => "/diseases/{$citydata[0]['slug']}/{$disease['slug']}"
					];
				}
			}

			$accordion[] = [
				"title" => "Test by Risk",
				"key"   => "risk",
				"child" => $testByRisk
			];

			// 6. Full Body Checkup 
			if (count($rs_gs_city) > 0) {
				$fullBodyLinks = [];
				foreach ($rs_gs_city as $city) {
					$fullBodyLinks[] = [
						"title" => "Full body Checkup Test in " . $city['name'],
						"link"  => "/premium-health-checkup/" . $city['slug']
					];
				}

				$accordion[] = [
					"title" => "Full Body Checkup",
					"key"   => "full_body",
					"child" => $fullBodyLinks
				];
			}
			//-----------------TAGS :: END------------------------
		}


		//-----------------FAQ :: START------------------------
		$faqData = [];
		if(in_array('faq', $types))
		{
			$faq_con = '';
			if($pageType=='radiology') {
				$page_con = " and page_name='radiology'";
				$faq_con = " and faq_category_id=1";

				$obj_meta = $this->app->load_model('page_info');
				$meta_data = $obj_meta->execute("SELECT", false, "","status!='Trash' ".$page_con."");
				$description = $meta_data[0]['description'];

			} else if($pageType=='pathology') {
				$page_con = " and page_name='pathology'";
				$faq_con = " and faq_category_id=2";

				$obj_meta = $this->app->load_model('page_info');
				$meta_data = $obj_meta->execute("SELECT", false, "","status!='Trash' ".$page_con."");
				$description = $meta_data[0]['description'];

			} else if($pageType=='premium-health-checkup') {
				$page_con = " and page_name='premium_health_checkup'";
				$faq_con = " and faq_category_id=4";

				$obj_meta = $this->app->load_model('page_info');
				$meta_data = $obj_meta->execute("SELECT", false, "","status!='Trash' ".$page_con."");
				$description = $meta_data[0]['description'];

			} else if($pageType=='home') {
				$page_con = " and page_name='home'";
				$faq_con = " and faq_category_id=3";

				$obj_meta = $this->app->load_model('page_info');
				$meta_data = $obj_meta->execute("SELECT", false, "","status!='Trash' ".$page_con."");
				$description = $meta_data[0]['description'];

			}
			else if($pageType=='category') {

				$obj_model = $this->app->load_model('item_category');
				$item_category = $obj_model->execute("SELECT", false, "", "item_category.status='Active' and item_category.slug='".$pageSlug."'", "sort_order ASC");
				
				$page_con = " and page_name='category'";
				$faq_con = " and faq_type='item_category' and faq_category_id=".$item_category[0]['id'];
				$description = $item_category[0]['decsription'];

			 }
			 else if($pageType=='diseases') {
				$obj_model = $this->app->load_model('item_diseases');
				$item_diseases = $obj_model->execute("SELECT", false, "", "item_diseases.status='Active' and item_diseases.slug='".$pageSlug."'", "sort_order ASC");
				$page_con = " and page_name='diseases'";
				$faq_con = " and faq_type='item_diseases' and faq_category_id=".$item_diseases[0]['id'];

				$description = $item_diseases[0]['description'];

			}elseif($pageType=='item') {
				$obj_model = $this->app->load_model('item');
				$item = $obj_model->execute("SELECT", false, "", "item.status='Active' and item.slug='".$pageSlug."'", "sort_order ASC");
				$page_con = " and page_name='item'";
				$faq_con = " and faq_type='item' and faq_category_id=".$item[0]['id'];
			 }

			if($faq_con!='')
			{
				
				
				$obj_model_faq = $this->app->load_model("faq");
				$rs_faq_data = $obj_model_faq->execute("SELECT", false, "", "status='Active' ".$faq_con."", "faq.id desc");

				foreach ($rs_faq_data as $faq) {
					$question = str_replace("{CITY}", $citydata[0]['name'], $faq['question']);
					$answer   = str_replace("{CITY}", $citydata[0]['name'], $faq['answer']);

					$faqData[] = [
						"title" => $question,
						"answer" => $answer
					];
				}
			}
		}
		//-----------------FAQ :: END------------------------



		//-----------------TESTIMONIAL :: START------------------------
		$testimonials = [];

		if (in_array('testimonial', $types)) {

			$obj_model_testimonial = $this->app->load_model('testimonial');
			$rs_testimonial = $obj_model_testimonial->execute("SELECT", false, "", "status='Active'", "sort_id ASC");

			foreach ($rs_testimonial as $t) {

				$image = $this->app->utility->get_image_path($t['image'], 'testimonial', 'large');
				$testimonials[] = [
					"name"    => $t['name'],
					"city"    => $t['city'],
					"rating" => $t['ratting'],
					"image"  => $image,
					"content" => $t['content'],
					"date" => $t['view_date']
				];
			}
		}
		//-----------------TESTIMONIAL :: END------------------------


		$result = [
			"tags" => $accordion,
			"faqs"  => $faqData,
			"faq_description"  =>  str_replace("{CITY}", $citydata[0]['name'], $description),
			"testimonials" => $testimonials,

		];
		$message = array("message" => '', "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
