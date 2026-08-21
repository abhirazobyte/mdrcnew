<?
class _item_list extends controller
{
	function init() {}
	function onload()
	{
		$ip = $_SERVER['REMOTE_ADDR'];

		$cityID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('cityID'));
		$cityID = $this->app->utility->decrypt($cityID);

		$userID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userID'));
		$userID = $this->app->utility->decrypt($userID);
		$userPhone = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('userPhone'));
		$deviceType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("deviceType"));

		$search = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("search"));
		$page = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("page"));
		$page = $page == '' ? 0 : $page;

		$categoryIDs = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("categoryID"));
		$typeIDs = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("typeID"));
		$diesesID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("diesesID"));

		//$categoryIDs=$diesesID;
		//$diesesID='';
		//$diesesID=$diesesID!=''?$this->app->utility->decrypt($diesesID):'';
		$pageType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("pageType"));

		$sortBy = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("sortBy"));
		$departmentID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("departmentID"));

		$cartItemIds = array();
		if ($userID != '') {
			$obj_model_cart = $this->app->load_model("customer_cart");
			$cart = $obj_model_cart->execute("SELECT", false, "", "customer_cart.customer_id='" . $userID . "'", "customer_cart.id DESC");
			foreach ($cart as $item) {
				$cartItemIds[] = $item["cart_item_id"];
			}
		}


		if ($cityID != '') {
			$filterList = [];
			if ($page == 0) {
				if ($pageType == 'Pathology') {
					$obj_model = $this->app->load_model("item_category");
					$diseases = $obj_model->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_category.item_department_ids)", "sort_order ASC");
					foreach ($diseases as $item) {
						$filterList[] = ["filterID" => $item['id'], "name" => $item['name']];
					}
				} else if ($pageType == 'Radiology') {
					$obj_model = $this->app->load_model("item_category");
					$diseases = $obj_model->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_category.item_department_ids)", "sort_order ASC");
					foreach ($diseases as $item) {
						$filterList[] = ["filterID" => $item['id'], "name" => $item['name']];
					}
				}
			}
			/* if($userID!='')
			{
				$obj_model_customer= $this->app->load_model("customer");
				$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
				if(count($rs_user)<=0)
				{
					
					$response=array("message"=>"Customer not found.","msgCode"=>"0");
					$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
					$final_response=$this->app->utility->indent($opt);
					echo $final_response; exit; 
				}
			} */
			$bannerList = [];
			if ($page == 0) {

				if ($pageType == 'Popular Package') {
					$show_page = 'premium';
				} else if ($pageType == 'Diseases') {
					$show_page = 'diseases';
				} else if ($pageType == 'Category') {
					$show_page = 'category';
				} else if ($pageType == 'Radiology') {
					$show_page = 'radiology';
				} else if ($pageType == 'Pathology') {
					$show_page = 'pathology';
				} else if ($pageType == 'Popular Test') {
					$show_page = 'premium';
				}

				$obj_model_banner = $this->app->load_model('banner');
				$rs_banner = $obj_model_banner->execute("SELECT", false, "", "status='Active' and show_page='" . $show_page . "' and (FIND_IN_SET ('" . $cityID . "',banner.city_ids) or city_ids='')", "sort_id ASC");
				foreach ($rs_banner as $banner) {
					$folder = 'main_banner_images';
					$image = $this->app->utility->get_image_path($banner['banner_image'], $folder, "large");
					$bannerList[] = [
						"image" => $image
					];
				}
			}

			$sort_cond = "item.sort_order ASC";
			if ($sortBy != '') {
				if ($sortBy == 'name_a_z') {
					$sort_cond = "item.name ASC";
				} else if ($sortBy == 'name_z_a') {
					$sort_cond = "item.name DESC";
				} else if ($sortBy == 'price_l_h') {
					$sort_cond = "item_price.price ASC";
				} else if ($sortBy == 'price_h_l') {
					$sort_cond = "item_price.price DESC";
				}
			}

			if ($search != '') {
				$g_search_query = " and (item.name LIKE '$search%' or item.name LIKE '%$search%' or item.name LIKE '%$search')";
			}

			$city_cond = "";
			if ($cityID != '') {
				$city_cond = " and FIND_IN_SET ('" . $cityID . "',item.city_ids) and item_price.city_id='" . $cityID . "'";
			}

			$department_cond = "";
			if ($departmentID != '') {
				$department_cond = " and FIND_IN_SET ('" . $departmentID . "',item_other_data.item_department_ids)";
			}

			$type_cond = "";
			if ($typeIDs != '') {
				$explodeItem = explode(',', $typeIDs);
				$cond = array();
				for ($i = 0; $i < count($explodeItem); $i++) {
					if ($explodeItem[$i] != '') {
						$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_type_id)";
					}
				}
				$type_cond = " and (" . implode(" OR ", $cond) . ")";
			}

			$dieses_cond = "";
			if ($diesesID != '') {
				$explodeItem = explode(',', $diesesID);
				$cond = array();
				for ($i = 0; $i < count($explodeItem); $i++) {
					if ($explodeItem[$i] != '') {
						$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_diseases_ids)";
					}
				}
				$dieses_cond = " and (" . implode(" OR ", $cond) . ")";
			}

			$cat_cond = "";
			if ($categoryIDs != '') {
				$explodeItem = explode(',', $categoryIDs);
				$cond = array();
				for ($i = 0; $i < count($explodeItem); $i++) {
					if ($explodeItem[$i] != '') {
						$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_category_ids)";
					}
				}
				$cat_cond = " and (" . implode(" OR ", $cond) . ")";
			}

			$popular_pack_cond = "";
			if ($pageType == 'Popular Package') {
				$popular_pack_cond = " and item_other_data.item_type_id=1 and set_at_popular_package='Yes'";
			}

			$master_con = $g_search_query . $city_cond . $department_cond . $type_cond . $dieses_cond . $cat_cond . $popular_pack_cond;
			$obj_model_all_data = $this->app->load_model("item");
			$rs_total = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount,item.*,item_other_data.*,item_price.*  from item
			LEFT JOIN  item_other_data ON item.id=item_other_data.item_id
			LEFT JOIN  item_price ON item.id=item_price.item_id
			where  item.id!=0 and item.status='Active' " . $master_con . "", "");
			$count = $rs_total[0]['allcount'];

			$limit = 10;
			$total_pages = intval($count / $limit);
			$start = $page == 0 ? 0 : ($page) * $limit;

			if ($count <= 0 || $total_pages < $page) {
				$title = '';
				if ($pageType == 'Popular Package') {
					$title = 'Premium Health Checkup';
				} else if ($pageType == 'Diseases') {
					$obj_model_all = $this->app->load_model("item_diseases");
					$item_diseases = $obj_model_all->execute("SELECT", false, "", "id='" . $diesesID . "'");
					$title = $item_diseases[0]['name'];
				} else if ($pageType == 'Category') {
					$obj_model_all = $this->app->load_model("item_category");
					$item_category = $obj_model_all->execute("SELECT", false, "", "id='" . $categoryIDs . "'");
					$title = $item_category[0]['name'];
				} else if ($pageType == 'Radiology') {
					$title = 'Radiology Scan Test';
				} else if ($pageType == 'Pathology') {
					$title = 'Pathology Blood Test';
				} else if ($pageType == 'Popular Test') {
					$title = 'Popular Test';
				}

				$result = ["title" => $title];
				$message = array("message" => "No Items Found.", "msgCode" => "0", "result" => $result);
				$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}

			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id" => "item_id"));
			$obj_model_all->join_table("item_other_data", "left", array(), array("id" => "item_id"));
			$obj_model_all->join_table("item_price", "left", array(), array("id" => "item_id"));
			$records = $obj_model_all->execute("SELECT", false, "", "item.id!=0 and item.status='Active' " . $master_con . "", "" . $sort_cond . " limit " . $start . "," . $limit . "", "");
			foreach ($records as $item) {
				$id = $item['id'];
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
				$description1 = strip_tags($item['item_other_data_description']);
				$description_li = '';
				if ($description1 != '') {
					$description = mysqli_real_escape_string($this->app->set_db_conn(), $description1);
					$description = strip_tags($description);
					$description = str_replace(['\\r', '\\n'], ' ', $description);
					$description = $this->app->utility->string_truncate($description, 150);
					$description_li = $description;
				}
				$test_parameters_html1 = strip_tags($item['item_description_test_parameters']);
				$test_parameters_html = mysqli_real_escape_string($this->app->set_db_conn(), $test_parameters_html1);
				$test_parameters_html = strip_tags($test_parameters_html);
				$test_parameters_html = str_replace(['\\r', '\\n'], ' ', $test_parameters_html);
				if ($test_parameters_html != '') {
					$test_parameters_html = $this->app->utility->string_truncate($test_parameters_html, 150);
				}
				$test_parameters_html = '';

				$inCart = in_array($item['id'], $cartItemIds) ? true : false;
				// $itemInfo = [];
				// $itemInfo[] = 'Total no.of Tests : ' . $test_count;
				// $itemInfo[] = $description_li;
				// if ($test_parameters_html != '') {
				// 	$itemInfo[] = $test_parameters_html;
				// }

				$itemInfo = [];

				$itemInfo[] = $this->cleanUtf8('Total no.of Tests : ' . $test_count);

				if (!empty($description_li)) {
					$itemInfo[] = $this->cleanUtf8($description_li);
				}

				if (!empty($test_parameters_html)) {
					$itemInfo[] = $this->cleanUtf8($test_parameters_html);
				}

				$itemList[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name" => $name,
					"inCart" => $inCart,
					"price" => $price,
					"mrp" => $mrp > $price ? $mrp : '0.00',
					"percentage" => '',
					"itemInfo" => $itemInfo,
				];
				unset($itemInfo);
			}

			$title = '';
			if ($pageType == 'Popular Package') {
				$title = 'Premium Health Checkup';
			} else if ($pageType == 'Diseases') {
				$obj_model_all = $this->app->load_model("item_diseases");
				$item_diseases = $obj_model_all->execute("SELECT", false, "", "id='" . $diesesID . "'");
				$title = $item_diseases[0]['name'];
			} else if ($pageType == 'Category') {
				$obj_model_all = $this->app->load_model("item_category");
				$item_category = $obj_model_all->execute("SELECT", false, "", "id='" . $categoryIDs . "'");
				$title = $item_category[0]['name'];
			} else if ($pageType == 'Radiology') {
				$title = 'Radiology Scan Test';
			} else if ($pageType == 'Pathology') {
				$title = 'Pathology Blood Test';
			} else if ($pageType == 'Popular Test') {
				$title = 'Popular Test';
			} else {
				$title = 'Test';
			}

			$result = ["bannerList" => $bannerList, "itemList" => $itemList, "filterList" => $filterList, "title" => $title, "certificateImage" => SERVER_ROOT . '/uploads/pathology_image.png'];

			$message = array("message" => "success", "msgCode" => "1", "result" => $result);
		} else {
			$message = array("message" => "Date missing.", "msgCode" => "0");
		}

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
		print_r($this->app->utility->indent($opt));
		exit;
	}

	function cleanUtf8($string)
	{
		if (!is_string($string)) return $string;

		// Remove invalid UTF-8 characters
		$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');

		// Remove control characters except new line
		$string = preg_replace('/[^\P{C}\n]+/u', '', $string);

		return trim($string);
	}
}
