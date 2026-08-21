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
		$categorySlug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("categorySlug"));
		$typeIDs = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("typeID"));
		$diesesID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("diesesID"));
		$diesesSlug = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("diseaseSlug"));

		//$categoryIDs=$diesesID;
		//$diesesID='';
		//$diesesID=$diesesID!=''?$this->app->utility->decrypt($diesesID):'';
		$pageType = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("pageType"));

		$sortBy = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("sortBy"));
		$departmentID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("departmentID"));

		# BLANK DEFINE
		$radiologyAndImagingTest=[];
		
		$cateSlugCond = '';
		if($categorySlug != '') {
			$obj_model = $this->app->load_model("item_category");
			$categories = $obj_model->execute("SELECT", false, "", "status='Active' and slug = '".$categorySlug."'");
			$categoryIDs = $categories[0]['id'];
			
			$categoryID = $categories[0]['id'];
			$cateSlugCond = " or FIND_IN_SET ('".$categorySlug."',banner.show_page) ";
		}
		if($diesesSlug != '') {
			$obj_model_tble = $this->app->load_model("item_diseases");
			$rs_diseases = $obj_model_tble->execute("SELECT", false, "", "status='Active' and slug='".$diesesSlug."'");
			$diesesID=$rs_diseases[0]['id'];
		}

		$cartItemIds = array();
		if ($userID != '') {
			$obj_model_cart = $this->app->load_model("customer_cart");
			$cart = $obj_model_cart->execute("SELECT", false, "", "customer_cart.customer_id='" . $userID . "'", "customer_cart.id DESC");
			foreach ($cart as $item) {
				$cartItemIds[] = $item["cart_item_id"];
			}
		}


		if ($cityID != '') {
			$filterList = [
				"Category" => [],
				"Diseases" => [],
			];
			if ($page == 0) {
				if ($pageType == 'Pathology') {
					// DISEASES/RISK AREAS
					$obj_model_tble = $this->app->load_model("item_diseases");
					$rs_diseases = $obj_model_tble->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_diseases.item_department_ids)", "sort_order ASC");
					foreach ($rs_diseases as $item) {
						$filterList["Diseases"][] = [
							"filterID" => $item['id'],
							"name"     => $item['name']
						];
					}
					//CATEORY
					$obj_model = $this->app->load_model("item_category");
					$categories = $obj_model->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_category.item_department_ids)", "sort_order ASC");
					foreach ($categories as $item) {
						$filterList["Category"][] = [
							"filterID" => $item['id'],
							"name"     => $item['name']
						];
					}
				} else if ($pageType == 'Radiology') {
					//FACILITIES
					$obj_model_tble = $this->app->load_model("item_category");
					$rs_category = $obj_model_tble->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_category.item_department_ids)", "sort_order ASC");
					foreach ($rs_category as $item) {
						$filterList["Category"][] = ["filterID" => $item['id'], "name" => $item['name']];
					}

					// DISEASES/RISK AREAS
					$obj_model_tble = $this->app->load_model("item_diseases");
					$rs_diseases = $obj_model_tble->execute("SELECT", false, "", "status='Active' and FIND_IN_SET ('" . $departmentID . "',item_diseases.item_department_ids)", "sort_order ASC");
					foreach ($rs_diseases as $item) {
						$filterList["Diseases"][] = ["filterID" => $item['id'], "name" => $item['name']];
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
				$rs_banner = $obj_model_banner->execute("SELECT", false, "", "status='Active' and mobile_image!='' and (FIND_IN_SET ('" . $show_page . "',banner.show_page) " . $cateSlugCond . ") and (FIND_IN_SET ('" . $cityID . "',banner.city_ids) or city_ids='')", "sort_id ASC");
				foreach ($rs_banner as $banner) {
					$folder = 'main_banner_images';
					$image = $this->app->utility->get_image_path($banner['mobile_image'], $folder, "large");
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

			if(!empty($typeIDs)){
				$finalTypes = ['1']; // always include 2

				if ($typeIDs != '') {
					$explodeItem = explode(',', $typeIDs);

					for ($i = 0; $i < count($explodeItem); $i++) {
						if ($explodeItem[$i] == '2') {
							$finalTypes[] = '2';
						}
					}
				}

				$finalTypes = array_unique($finalTypes);
				// print_r($finalTypes); exit;

				/* ===== SAME QUERY STRUCTURE ===== */
				$type_cond = "";
				$cond = array();

				for ($i = 0; $i < count($finalTypes); $i++) {
					if ($finalTypes[$i] != '') {
						$cond[] = " FIND_IN_SET ('" . $finalTypes[$i] . "', item_other_data.item_type_id)";
					}
				}

				if (count($cond) > 0) {
					$type_cond = " and (" . implode(" OR ", $cond) . ")";
				}
			}

			// $type_cond = "";
			// if ($typeIDs != '') {
			// 	$explodeItem = explode(',', $typeIDs);
			// 	$cond = array();
			// 	for ($i = 0; $i < count($explodeItem); $i++) {
			// 		if ($explodeItem[$i] != '') {
			// 			$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_type_id)";
			// 		}
			// 	}
			// 	$type_cond = " and (" . implode(" OR ", $cond) . ")";
			// }

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

			$obj_model_city=$this->app->load_model('city');
			$rs_city=$obj_model_city->execute("SELECT",false,"","id='".$cityID."'");

			$obj_meta = $this->app->load_model('page_info');
			if ($pageType == 'Pathology')
			{
				$meta_data = $obj_meta->execute("SELECT", false, "","page_name='pathology' and status!='Trash'");

				$meta_title = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['page_title']);
				$meta_keyword = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_keywords']);
				$meta_description = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_description']);
				$meta_schema = $meta_data[0]['meta_schema'];
			}
			elseif($pageType == 'Radiology')
			{
				$meta_data = $obj_meta->execute("SELECT", false, "","page_name='radiology' and status!='Trash'");

				$meta_title = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['page_title']);
				$meta_keyword = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_keywords']);
				$meta_description = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_description']);
				$meta_schema = $meta_data[0]['meta_schema'];
				
			}
			elseif($pageType == 'Diseases')
			{
				$meta_title = str_replace('{CITY}', $rs_city[0]['name'],$rs_diseases[0]['meta_title']);
				$meta_keyword = str_replace('{CITY}', $rs_city[0]['name'],$rs_diseases[0]['meta_keywords']);
				$meta_description = str_replace('{CITY}', $rs_city[0]['name'],$rs_diseases[0]['meta_description']);
				$meta_schema = str_replace('{CITY}', $rs_city[0]['name'],$rs_diseases[0]['meta_schema']);

				# SET STARTING PRICE
				$obj_model_tble = $this->app->load_model("item_diseases");
				$rs_diseas = $obj_model_tble->execute("SELECT", false, "", "status='Active' and set_at_home='Yes' and slug!='".$diesesSlug."' and item_department_ids='".$rs_diseases[0]['item_department_ids']."'", "sort_order ASC");
				foreach ($rs_diseas as $item) {
					$folder = 'item_diseases';
					$image = $item['image'];
					$slug = $item['slug'];
					$blogImage = $this->app->utility->get_image_path($image, $folder, "large");
					$radiologyAndImagingTest[] = [
						"name" => $item['name'],
						"slug" => $item['slug'],
						"starting_price" => $item['starting_price'],
						"image" => $blogImage,
					];
				}
			}
			elseif($pageType == 'Category')
			{
				$meta_title = str_replace('{CITY}', $rs_city[0]['name'],$categories[0]['meta_title']);
				$meta_keyword = str_replace('{CITY}', $rs_city[0]['name'],$categories[0]['meta_keywords']);
				$meta_description = str_replace('{CITY}', $rs_city[0]['name'],$categories[0]['meta_description']);
				$meta_schema = str_replace('{CITY}', $rs_city[0]['name'],$categories[0]['meta_schema']);

				# SET STARTING PRICE
				$obj_model_tble = $this->app->load_model("item_category");
				$rs_diseas = $obj_model_tble->execute("SELECT", false, "", "status='Active' and set_at_home='Yes' and slug!='".$categorySlug."' and item_department_ids='".$categories[0]['item_department_ids']."'", "sort_order ASC");
				foreach ($rs_diseas as $item) {
					$folder = 'item_category';
					$image = $item['image'];
					$slug = $item['slug'];
					$blogImage = $this->app->utility->get_image_path($image, $folder, "large");
					$radiologyAndImagingTest[] = [
						"name" => $item['name'],
						"slug" => $item['slug'],
						"starting_price" =>'',
						"image" => $blogImage,
					];
				}
			}
			elseif($pageType == 'Popular Package')
			{
				$meta_data = $obj_meta->execute("SELECT", false, "","page_name='popular_packages' and status!='Trash'");

				$meta_title = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['page_title']);
				$meta_keyword = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_keywords']);
				$meta_description = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_description']);
				$meta_schema = str_replace('{CITY}', $rs_city[0]['name'],$meta_data[0]['meta_schema']);
			}

			if ($count <= 0 || $total_pages < $page) {
				$title = '';
				if ($pageType == 'Popular Package') {
					$title = 'Premium Health Checkup';
				} else if ($pageType == 'Diseases') {
					$obj_model_all = $this->app->load_model("item_diseases");
					$item_diseases = $obj_model_all->execute("SELECT", false, "", "id='" . $diesesID . "'");
					$title = $item_diseases[0]['name'];
					if($item_diseases[0]['name'] == ''){
						$title = 'Diseases';
					}
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

				$result = [
					"meta_title" => $meta_title ,
					"meta_keyword" => $meta_keyword,
					"meta_description" => $meta_description,
					"meta_schema" => $meta_schema,
					"title" => $title,
					"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
					"bannerList" => $bannerList,
					"itemList" => [],
					"filterList" => $filterList,
					"certificateImage" => SERVER_ROOT . '/uploads/pathology_image.png',
					"radiologyAndImagingTest" => $radiologyAndImagingTest,
				];

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
				$slug = $item['slug'];
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
				$test_parameters_html = strip_tags($item['item_description_test_parameters']);
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

				$is_package = $item['item_other_data_item_type_id']==1 ? 'Yes' : 'No';
				if($item['item_other_data_item_department_ids']=='1'){
					$line1 = 'Test Count : '.$test_count;
					$line2 = 'High-end Machines, Non Invasive Procedure, Painless & Online Reports';
				}else{
					$line1 = 'Parameters Included : '.$test_count;
					$line2 = 'Reports in 12 hours';
				}
				$itemList[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name" => $name,
					"slug" => $slug,
					"inCart" => $inCart,
					"price" => $price,
					"mrp" => $mrp > $price ? $mrp : '0.00',
					"percentage" => $percentage,
					"itemInfo" => $itemInfo,
					"line1" =>   $line1,
					"line2" => $line2,
					"is_package" => $is_package,
					"department" => $item['item_other_data_item_department_ids']??''
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
				if($item_diseases[0]['name'] == ''){
					$title = 'Diseases';
				}
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



			#------------------------------ START : RELATED ITEM ------------------------------#

			if($pageType == 'Diseases' && $diesesID!='') {
				$condition = " AND FIND_IN_SET('$diesesID', item_other_data.item_rec_disease_ids) > 0";
			} elseif($pageType == 'Category' && $categoryIDs!='') {
				$condition = " AND FIND_IN_SET('$categoryIDs', item_other_data.item_rec_cat_ids) > 0";
			} elseif(($pageType == 'Pathology' || $pageType == 'Radiology') && $departmentID!='') {
				$condition = " AND FIND_IN_SET('$departmentID', item_other_data.item_rec_dept_ids) > 0";
			} else {
				$records = $obj_model_all->execute("SELECT", false, "", "item.status='Active'", "item.name ASC limit 0,20");
			}

			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id" => "item_id"));
			$obj_model_all->join_table("item_other_data", "left", array(), array("id" => "item_id"));
			$obj_model_all->join_table("item_price", "left", array(), array("id" => "item_id"));
			$records = $obj_model_all->execute("SELECT", false, "", "item.status='Active' $condition", "item.name ASC limit 0,20");
			
			$relatedCartItem=[];
			
			foreach ($records as $item) {
				$item_price_id = $item['item_price_id'];
				$name = $item['name'];
				$slug = $item['slug'];
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
				$test_parameters_html = strip_tags($item['item_description_test_parameters']);
				if ($test_parameters_html != '') {
					$test_parameters_html = $this->app->utility->string_truncate($test_parameters_html, 100);
				}
				$test_parameters_html = '';

				$itemInfo[] = 'Total no.of Tests : ' . $test_count;
				$itemInfo[] = $description_li;
				if ($test_parameters_html != '') {
					$itemInfo[] = $test_parameters_html;
				}
				$percentage = 0;

				if ($mrp > $price && $mrp > 0) {
					$percentage = round((($mrp - $price) / $mrp) * 100) . '%';
				}

				$is_package = $item['item_other_data_item_type_id']==1 ? 'Yes' : 'No';

				if($item['item_other_data_item_department_ids']=='1'){
					$line1 = 'Test Count : '.$test_count;
					$line2 = 'High-end Machines, Non Invasive Procedure, Painless & Online Reports';
				}else{
					$line1 = 'Parameters Included : '.$test_count;
					$line2 = 'Reports in 12 hours';
				}

				$relatedCartItem[] = [
					"itemID" => $this->app->utility->encrypt($item['id']),
					"priceID" => $this->app->utility->encrypt($item_price_id),
					"name" => $name,
					"slug" => $slug,
					"price" => $price,
					"mrp" => $mrp > $price ? $mrp : '0.00',
					"percentage" => $percentage,
					"itemInfo" => $itemInfo,
					"line1" =>   $line1,
					"line2" => $line2,
					"is_package" => $is_package,
					"department" => $item['item_other_data_item_department_ids']??''
				];
				unset($itemInfo);
			}
			#------------------------------ END : RELATED ITEM ------------------------------#

			
			
			$result = [
				"meta_title" => $meta_title,
				"meta_keyword" => $meta_keyword,
				"meta_description" => $meta_description,
				"meta_schema" => $meta_schema,
				"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
				"bannerList" => $bannerList,
				"itemList" => $itemList,
				"filterList" => $filterList,
				"title" => $title,
				"certificateImage" => SERVER_ROOT . '/uploads/pathology_image.png',
				"radiologyAndImagingTest" => $radiologyAndImagingTest,
				"relatedCartItems" => $relatedCartItem,
			];

			$message = array("message" => "success", "msgCode" => "1", "result" => $result);
		} else {
			$result = [
				"meta_title" => '',
				"meta_keyword" => '',
				"meta_description" => '',
				"meta_schema" => '',
			];
			$message = array("message" => "Date missing.", "msgCode" => "0","result"=>$result);
		}
		// print_r($message);exit;
		// echo json_encode($message); exit;
		$opt = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
