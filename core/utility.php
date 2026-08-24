<?
class utility extends Singleton
{
	private $uploaded_file;
	public $app;
	public static function &get_instance()
	{
		parent::$my_name = __CLASS__;
		return parent::get_instance();
	}
	function init()
	{
		$this->app = &app::get_instance();
	}
	function get_uploaded_file()
	{
		return $this->uploaded_file;
	}
	function dataFromApi($url, $request_parameter)
	{
		if (function_exists('mdrc_external_api_removed') && mdrc_external_api_removed()) {
			return '';
		}
		$parameters = $request_parameter;
		$url = API_URL . $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
		$response = mdrc_curl_exec($ch);
		//echo $response;
		curl_close($ch);
		//$result=json_decode($response, true);
		return $response;
	}
	function other_upload_file($data = [])
	{
		$file = $data['file'];
		$path = $data['path'];
		$file_info = $this->get_file_info($file['name']);
		$tmpname = time() . "_" . mt_rand(1000, 2000) . "." . $file_info->extension;
		if (!move_uploaded_file($file['tmp_name'], ABS_PATH . DS . $path . DS . $tmpname)) {
			return $tmpname;
		} else {
			$this->uploaded_file = ABS_PATH . DS . $path . DS . $tmpname;
			return $tmpname;
		}
	}
	function getDepartmentData($ids)
	{
		$obj_model_tble = $this->app->load_model('item_department');
		$rs_data = $obj_model_tble->execute("SELECT", false, "", "id IN (" . $ids . ")");
		if (count($rs_data) > 0) {
			$datas = array();
			for ($i = 0; $i < count($rs_data); $i++) {
				$datas[] = '<li>' . $rs_data[$i]['name'] . '</li>';
			}
			$html = '<ul>' . implode(" ", $datas) . '</ul>';
		} else {
			$html = '';
		}
		return $html;
	}
	function checkCityData($slug)
	{
		$flag = '';
		$obj_model_tble = $this->app->load_model('city');
		$rs_city = $obj_model_tble->execute("SELECT", false, "", "slug='" . $slug . "' and status='Active'");
		if (count($rs_city) > 0) {
			$api_state_id = $rs_city[0]['api_state_id'];
			$api_city_id = $rs_city[0]['api_city_id'];
			$state_id = $rs_city[0]['state_id'];
			$cityName = $rs_city[0]['name'];
			$cityImage = $rs_city[0]['image'];
			$cityID = $rs_city[0]['id'];
			$citySlug = $rs_city[0]['slug'];
			$_SESSION['cityID'] = $cityID;
			$_SESSION['cityName'] = $cityName;
			$_SESSION['cityImage'] = $cityImage;
			$_SESSION['cityApiStateId'] = $api_state_id;
			$_SESSION['cityApiCityId'] = $api_city_id;
			$_SESSION['cityStateID'] = $state_id;
			$_SESSION['citySlug'] = $citySlug;
			$flag = 'Yes';
		}
		return $flag;
	}
	function getApiCitStateRecord($ids)
	{
		$data = array();
		if ($ids != '') {
			$obj_model_brand = $this->app->load_model('city');
			$rs_brand = $obj_model_brand->execute("SELECT", false, "", "id IN (" . $ids . ")");
			if (count($rs_brand) > 0) {
				$city_id = array();
				$state_id = array();
				$api_city_id = array();
				$api_state_id = array();
				for ($i = 0; $i < count($rs_brand); $i++) {
					$city_id[] = $rs_brand[$i]['id'];
					$state_id[] = $rs_brand[$i]['state_id'];
					$api_state_id[] = $rs_brand[$i]['api_state_id'];
					$api_city_id[] = $rs_brand[$i]['api_city_id'];
				}
				$final_city_id = array_unique($city_id);
				$final_state_id = array_unique($state_id);
				$final_api_state_id = array_unique($api_state_id);
				$final_api_city_id = array_unique($api_city_id);
				$data['city_ids'] = implode(',', $final_city_id);
				$data['state_ids'] = implode(',', $final_state_id);
				$data['api_city_ids'] = implode(',', $final_api_state_id);
				$data['api_state_ids'] = implode(',', $final_api_city_id);
			}
			return $data;
		} else {
			return $data;
		}
	}
	function getTagsIds($tags)
	{
		if ($tags != '') {
			$datas = explode(',', $tags);
			$data_ids = array();
			for ($i = 0; $i < count($datas); $i++) {
				$obj_model_brand = $this->app->load_model('blog_tag');
				$rs_brand = $obj_model_brand->execute("SELECT", false, "", "name='" . trim($datas[$i]) . "'");
				if (count($rs_brand) > 0) {
					$ID = $rs_brand[0]['id'];
				} else {
					$update_field = array();
					$update_field["name"] = trim($datas[$i]);
					$update_field["status"] = 'Active';
					$obj_model_brand = $this->app->load_model("blog_tag");
					$obj_model_brand->map_fields($update_field);
					$ID = $obj_model_brand->execute("INSERT");
				}
				$data_ids[] = $ID;
			}
			$tag_ids = implode(',', $data_ids);
			return $tag_ids;
		} else {
			return '';
		}
	}
	function productReviewCountUpdate($product_id)
	{
		$obj_model_product_reviews = $this->app->load_model("product_review");
		$rs_total_reviews = $obj_model_product_reviews->execute("SELECT", false, "SELECT COUNT(id) as TOTAL_R, SUM(product_star) AS TOTAL_RATT from product_review WHERE product_id='" . $product_id . "' AND status='Active'");
		$total_reviews = $rs_total_reviews[0]['TOTAL_R'];
		$total_ratt = $rs_total_reviews[0]['TOTAL_RATT'];
		$total_rattings = $total_ratt;
		//echo $total_rattings.' - '.$total_reviews; exit;
		$avg_ratt = $total_rattings / $total_reviews;
		$obj_model_product = $this->app->load_model("product");
		$obj_model_product->execute("UPDATE", false, "UPDATE product SET product_rate='" . $avg_ratt . "' WHERE id='" . $product_id . "'", "");
		return '';
	}
	function product_detail_review_html($val, $total_review)
	{
		$val = round($val);
		if ($val == 1) {
			$trtml = '<span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 2) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 3) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 4) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 5) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                    </span>';
		} else {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active" ></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active "></span>
                                                    </span>';
		}
		if ($total_review > 0) {
			$thtml = '<span class="kalles-rating-result__number">(' . $total_review . ' reviews)</span>';
		} else {
			$thtml = '';
		}
		$html = ' <a href="#tab_reviews_product" class="rating_sp_kl dib" >
                                                <div class="kalles-rating-result">
													' . $trtml . '
                                                    ' . $thtml . '
                                                </div>
                                            </a>';
		return $html;
	}
	function product_detail_review_html_detail($val, $total_review)
	{
		$val = round($val);
		if ($val == 1) {
			$trtml = '<span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 2) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 3) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 4) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 5) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                    </span>';
		} else {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active" ></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active "></span>
                                                    </span>';
		}
		if ($total_review > 0) {
			$thtml = '<span class="r--total-view">' . $total_review . ' <span>reviews</span></span>';
		} else {
			$thtml = '';
		}
		$html = ' <div class="r--stars cpl">
                                                                        <div class="kalles-rating-result">
                                                                            ' . $trtml . '
                                                                        </div>
                                                                          ' . $thtml . '
                                                                    </div>
                                                                </div>';
		return $html;
	}
	function product_detail_review($val)
	{
		$val = round($val);
		if ($val == 1) {
			$trtml = '<span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 2) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 3) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 4) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                    </span>';
		} else if ($val == 5) {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big "></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                    </span>';
		} else {
			$trtml = ' <span class="kalles-rating-result__pipe">
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active" ></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active"></span>
                                                        <span class="kalles-rating-result__start kalles-rating-result__start--big active "></span>
                                                    </span>';
		}
		return $trtml;
	}
	function check_order_data($type)
	{
		$obj_model_orders = $this->app->load_model("customer_order_master");
		$rs_orders = $obj_model_orders->execute("SELECT", false, "", "", "id DESC Limit 0,1");
		$last_no = $rs_orders[0]['master_order_no'];
		$master_order_no = $last_no + 1;
		$display_order_no = 'MD' . $master_order_no;
		$data = array();
		$data['master_order_no'] = $master_order_no;
		$data['display_order_no'] = $display_order_no;
		return $data;
	}
	function created_by($name)
	{
		if ($name == 'Admin') {
			$html = '<br/><span style="background-color:#67C652; padding:5px; color:#FFF">Admin</span>';
		} else {
			$html = '';
		}
		return $html;
	}
	function check_coupon_order($coupon_id)
	{
		$table = $this->app->load_model("customer_order_master");
		$rs_data = $table->execute("SELECT", false, "SELECT count(id) AS Total_Use FROM customer_order_master WHERE discount_coupon_id='" . $coupon_id . "' and order_status!='Cancelled'", "");
		$total_use = $rs_data[0]['Total_Use'];
		return $total_use;
	}
	function check_coupon_order_customer($coupon_id, $customer_id)
	{
		$table = $this->app->load_model("customer_order_master");
		$rs_data = $table->execute("SELECT", false, "SELECT count(id) AS Total_Use FROM customer_order_master WHERE discount_coupon_id='" . $coupon_id . "' and order_status!='Cancelled' and customer_id='" . $customer_id . "'", "");
		$total_use = $rs_data[0]['Total_Use'];
		return $total_use;
	}
	function generate_coupon_code($Length)
	{
		$Key = "";
		$found = false;
		while (strlen($Key) < $Length) {
			srand((float)microtime() * 1000000);
			$number = rand(50, 150);
			if ($number >= 65 && $number <= 90)
				$Key = $Key . chr($number);
			elseif ($number >= 48 && $number <= 57)
				$Key = $Key . chr($number);
		}
		return trim($Key);
	}
	function get_web_cat_url($id)
	{
		$obj_model_table = $this->app->load_model("category");
		$rs_data = $obj_model_table->execute("SELECT", false, "", "id='" . $id . "'", "");
		if (count($rs_data) > 0) {
			$parentcategory_id = $rs_data[0]['parentcategory_id'];
			$main_slug = $rs_data[0]['category_slug'];
			if ($parentcategory_id > 0) {
				$obj_model_table11 = $this->app->load_model("category");
				$rs_data1 = $obj_model_table11->execute("SELECT", false, "", "id='" . $parentcategory_id . "'", "");
				$sub_slug = $rs_data1[0]['category_slug'];
				$parentcategory_id1 = $rs_data1[0]['parentcategory_id'];
				if ($parentcategory_id1 > 0) {
					$obj_model_table12 = $this->app->load_model("category");
					$rs_data2 = $obj_model_table12->execute("SELECT", false, "", "id='" . $parentcategory_id1 . "'", "");
					$sub_sub_slug = $rs_data2[0]['category_slug'];
					$html = 'products/' . $sub_sub_slug . '/' . $sub_slug . '/' . $main_slug . '.html';
				} else {
					$html = 'products/' . $sub_slug . '/' . $main_slug . '.html';
				}
			} else {
				$html = 'products/' . $main_slug . '.html';
			}
		} else {
			$html = 'javascript:void(0)';
		}
		return $html;
	}
	function getDisplayCatNames($ids)
	{
		if ($ids != '') {
			$obj_model_user = $this->app->load_model("category");
			$check_user = $obj_model_user->execute("SELECT", false, "", "id IN (" . $ids . ") and status='Active'", "");
			if (count($check_user) > 0) {
				$cat = array();
				for ($i = 0; $i < count($check_user); $i++) {
					$cat[] = $check_user[$i]['category_name'];
				}
				return implode(', ', $cat);
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
	function CustomrReferral_from($referral_from)
	{
		if ($referral_from != '') {
			$obj_model_user = $this->app->load_model("customer");
			$check_user = $obj_model_user->execute("SELECT", false, "", "ref_key='" . $referral_from . "' and status!='Trash'", "");
			if (count($check_user) > 0) {
				$data_final = array();
				$data_final['name'] = $check_user[0]['name'] . " " . $check_user[0]['last_name'];
				$data_final['ref_key'] = $check_user[0]['ref_key'];;
				return $data_final;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
	function upload_file($file)
	{
		$file_info = $this->get_file_info($file['name']);
		$tmpname = time() . "_" . mt_rand(1000, 2000) . "." . $file_info->extension;
		if (!move_uploaded_file($file['tmp_name'], ABS_PATH . DS . "temp" . DS . $tmpname)) {
			return false;
		} else {
			$this->uploaded_file = ABS_PATH . DS . "temp" . DS . $tmpname;
			return true;
		}
	}
	function upload_file_2025($file)
	{
		$file_info = $this->get_file_info($file['name']);
		$tmpname = time() . "_" . mt_rand(1000, 2000) . "." . $file_info->extension;
		if (!move_uploaded_file($file['tmp_name'], ABS_PATH . DS . "uploads/ipo_pdfs" . DS . $tmpname)) {
			return $tmpname;
		} else {
			$this->uploaded_file = ABS_PATH . DS . "uploads/ipo_pdfs" . DS . $tmpname;
			return $tmpname;
		}
	}
	function get_customer_cart($add_cart_msg, $items_o_html, $P_QTY)
	{
		$min_order_amount = 1;
		$_SESSION['cart_vendor_id'] = '';
		$_SESSION['oshopping_CART'] = array();
		if ($_SESSION['MarwadiCustID'] > 0) {
			$customerCond = "customer_cart.customer_id='" . $_SESSION['MarwadiCustID'] . "'";
		} else {
			$customerCond = "customer_cart.session_id='" . session_id() . "'";
		}
		$min_order_amount = 0;
		$cart_total_price = 0;
		$cart_row = '';
		$cart_vendor_row = '';
		$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
		$obj_model_tmp_cartmini->join_table("product_price", "left", array(), array("cart_product_price_id" => "id"));
		$obj_model_tmp_cartmini->join_table("product", "left", array(), array("cart_product_id" => "id"));
		$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "" . $customerCond . "", "customer_cart.id DESC");
		if (count($rs_cartmini) > 0) {
			$_SESSION['cart_vendor_id'] = $rs_cartmini[0]['vendor_id'];
			$_SESSION['oshopping_CART'] = $rs_cartmini;
			$cart_vendor_row = '';
			for ($i = 0; $i < count($rs_cartmini); $i++) {
				$slug = $rs_cartmini[$i]['product_slug'];
				$cart_id = $rs_cartmini[$i]['id'];
				$product_id = $rs_cartmini[$i]['cart_product_id'];
				$product_price_id = $rs_cartmini[$i]['cart_product_price_id'];
				$cart_product_name = $rs_cartmini[$i]['cart_product_name'];
				$cart_product_opt_name = $rs_cartmini[$i]['cart_product_opt_name'];
				$cart_product_price = $rs_cartmini[$i]['cart_product_price'];
				$cart_product_mrp = $rs_cartmini[$i]['cart_product_mrp'];
				$price_display = '<ins>' . $this->moneyFormatIndia($cart_product_price) . '</ins>';
				$cart_qty = $rs_cartmini[$i]['cart_qty'];
				$cart_line_total = $rs_cartmini[$i]['cart_line_total'];
				$product_image = $rs_cartmini[$i]['product_image'];
				$sub_folder = $rs_cartmini[$i]['product_folder'];
				$folder = 'product/' . $sub_folder . '/';
				$cart_total_price = $cart_total_price + $rs_cartmini[$i]['cart_line_total'];
				$banner_img = $this->get_image_path($product_image, $folder, '');
				$image = $banner_img['medium_image'];
				$dis_t = '';
				if ($cart_product_mrp > $cart_product_price) {
					$dis1 = (($cart_product_mrp - $cart_product_price) * 100) / $cart_product_mrp;
					$dis = (int)$dis1;
					if ($dis <= 0) {
						$dis_t = '';
					} else {
						$dis_t = '<div class="offer-badge">' . $dis . '% OFF</div>';
					}
				}
				$mrp_display = '';
				if ($cart_product_mrp > $cart_product_price) {
					$mrp_display = '<del>' . $this->moneyFormatIndia($cart_product_mrp) . '</del>';
				}
				$cart_product_opt_name = $rs_cartmini[$i]['cart_product_opt_name'];
				$cart_product_opt_name2 = $rs_cartmini[$i]['cart_product_opt_name2'];
				$cart_product_opt_name3 = $rs_cartmini[$i]['cart_product_opt_name3'];
				$varient_name = array();
				if ($cart_product_opt_name != '') {
					$varient_name[] = $cart_product_opt_name;
				}
				if ($cart_product_opt_name2 != '') {
					$varient_name[] = $cart_product_opt_name2;
				}
				if ($cart_product_opt_name3 != '') {
					$varient_name[] = $cart_product_opt_name3;
				}
				$display_name = implode(', ', $varient_name);
				$cart_row .= '<div class="mini_cart_item js_cart_item flex al_center pr oh cart_item_' . $cart_id . '">
                            <div class="ld_cart_bar"></div>
                            <a href="product-detail/' . $slug . '.html" class="mini_cart_img">
                                <img class="w__100 lazyload" src="' . $image . '" width="120" height="153" alt="" >
                            </a>
                            <div class="mini_cart_info">
                                <a href="product-detail/' . $slug . '.html" class="mini_cart_title truncate">' . $cart_product_name . '</a>
                                <div class="mini_cart_meta">
                                <p class="cart_meta_variant">' . $display_name . '</p>
                                    <p class="cart_selling_plan"></p>
                                    <div class="cart_meta_price price">
                                        <div class="cart_price">
                                     ' . $price_display . '
                                      ' . $mrp_display . '
                                        </div>
                                    </div>
                                </div>
                                <div class="mini_cart_actions">
                                    <div class="quantity pr mr__10 qty__true">
                                        <input type="number" class="input-text qty text tc qty_cart_js cart_detail_qty_' . $cart_id . '" step="1" min="0" max="9999" readonly="readonly" name="quantity" value="' . $cart_qty . '" id="cart_detail_qty_' . $cart_id . '">
                                        <div class="qty tc fs__14">
                                            <button type="button" class="plus db cb pa pd__0 pr__15 tr r__0 cart_detail_qty_' . $cart_id . '" onclick="change_cart_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Plus\',)">
                                                <i class="facl facl-plus"></i>
                                            </button>
                                            <button type="button" class="minus db cb pa pd__0 pl__15 tl l__0 qty_1 cart_detail_qty_' . $cart_id . '" onclick="change_cart_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Minus\',)">
                                                <i class="facl facl-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" onclick="remove_items(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ')" class="cart_ac_remove js_cart_rem ttip_nt tooltip_top_right"><span class="tt_txt">Remove this item</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>';
			}
		} else {
			$cart_row = '<div class="empty tc mt__40"><i class="las la-shopping-bag pr mb__10"></i>
                        <p>Your cart is empty.</p>
                        <p class="return-to-shop mb__15">
                            <a class="button button_primary tu js_add_ld" href="index.html">Return To Shop</a>
                        </p>
                    </div>';
		}
		if ($cart_total_price >= $min_order_amount) {
			$static_min_cart_mesg = '';
			$disable_btn = '';
		} else {
			$static_min_cart_mesg = 'Minimum Order Amount <i class="fas fa-rupee-sign"></i>' . $min_order_amount . '';
			$disable_btn = 'disable_btn';
		}
		if ($cart_total_price == 0) {
			$disable_btn = 'disable_btn';
		}
		$cart_total_price = $this->moneyFormatIndia($cart_total_price);
		$json_class = $this->app->load_module("JSON");
		$obj_json = new $json_class(JSON_LOOSE_TYPE);
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => $add_cart_msg, "CART_TOTAL" => $cart_total_price, "MIN_ORDER_AMOUNT" => $min_order_amount, "CART_ITEMS" => count($rs_cartmini), "CART_VENDOR" => $cart_vendor_row, "CART_BODY" => $cart_row, "items_o_html" => $items_o_html, "P_QTY" => $P_QTY, "static_min_cart_mesg" => $static_min_cart_mesg, "disable_btn" => $disable_btn));
		exit;
	}
	function getprice_check_cart($product_id, $price_id, $price, $quantity)
	{
		$p_ids_data = '';
		$net_price = '';
		$net_mrp = '';
		$net_weight = '';
		$obj_model_all = $this->app->load_model("product_price");
		$obj_model_all->join_table("product", "left", array(), array("product_id" => "id"));
		$rs = $obj_model_all->execute("SELECT", false, "", "product_price.id='" . $price_id . "' and product.id='" . $product_id . "'");
		$unit_type = '';
		$stock_update = 'Yes';
		$stock_type = '';
		$substitute_qty = 1;
		$total_stock_minus = $substitute_qty * $quantity;
		$net_price = $rs[0]['price'];
		$net_mrp = $rs[0]['mrp'];
		$max_quantity = $rs[0]['max_quantity'];
		$total_quantity = $rs[0]['total_quantity'];
		if ($price != $net_price) {
			$sold_p_id = $this->encrypt($price_id);
			$p_ids_data = array("priceID" => $sold_p_id, "p_notes" => "Sorry! Price Changed, Please Update Qty.", "p_price" => $net_price, "p_mrp" => $net_mrp);
		}
		if ($rs[0]['product_status'] != 'Active' || $rs[0]['product_in_stock'] == 'No' || count($rs) == 0) {
			$sold_p_id = $this->encrypt($price_id);
			$p_ids_data = array("priceID" => $sold_p_id, "p_notes" => "Product Not Available. Please Remove", "p_price" => '', "p_mrp" => '');
		}
		if ($stock_update == 'Yes') {
			if ($max_quantity > 0) {
				if ($quantity > $max_quantity) {
					$p_ids_data = array("priceID" => $sold_p_id, "p_notes" => "Maximum Buy Qty : " . $max_quantity . "", "p_price" => '', "p_mrp" => '', "max_qty" => $max_quantity);
				}
			}
			if ($total_quantity > 0) {
				if ($quantity > $total_quantity) {
					$sold_p_id = $this->encrypt($price_id);
					$p_ids_data = array("priceID" => $sold_p_id, "p_notes" => "Stock Not Available. Available Stock Qty : " . $total_quantity . "", "p_price" => '', "p_mrp" => '', "max_qty" => $total_quantity);
				}
			}
		}
		$data = array();
		$data['price'] = $net_price;
		$data['p_ids_data'] = $p_ids_data;
		$data['weight'] = $net_weight;
		$data['product_commission'] = $product_commission;
		return $data;
	}
	function get_customer_cart_page($add_cart_msg, $items_o_html, $P_QTY)
	{
		$_SESSION['cart_vendor_id'] = '';
		$_SESSION['oshopping_CART'] = array();
		$min_order_amount = 0;
		$cart_total_price = 0;
		$cart_row = '';
		$cart_vendor_row = '';
		if ($_SESSION['MarwadiCustID'] > 0) {
			$customerCond = "customer_cart.customer_id='" . $_SESSION['MarwadiCustID'] . "'";
		} else {
			$customerCond = "customer_cart.session_id='" . session_id() . "'";
		}
		$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
		$obj_model_tmp_cartmini->join_table("product_price", "left", array(), array("cart_product_price_id" => "id"));
		$obj_model_tmp_cartmini->join_table("product", "left", array(), array("cart_product_id" => "id"));
		$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "" . $customerCond . "", "", "customer_cart.id DESC");
		if (count($rs_cartmini) > 0) {
			$_SESSION['cart_vendor_id'] = $rs_cartmini[0]['vendor_id'];
			$_SESSION['oshopping_CART'] = $rs_cartmini;
			for ($i = 0; $i < count($rs_cartmini); $i++) {
				$cart_id = $rs_cartmini[$i]['id'];
				$product_id = $rs_cartmini[$i]['cart_product_id'];
				$product_price_id = $rs_cartmini[$i]['cart_product_price_id'];
				$slug = $rs_cartmini[$i]['product_slug'];
				$cart_product_name = $rs_cartmini[$i]['cart_product_name'];
				$cart_product_opt_name = $rs_cartmini[$i]['cart_product_opt_name'];
				$cart_product_price = $rs_cartmini[$i]['cart_product_price'];
				$cart_product_mrp = $rs_cartmini[$i]['cart_product_mrp'];
				$price_display = '<ins>' . $this->moneyFormatIndia($cart_product_price) . '</ins>';
				$cart_qty = $rs_cartmini[$i]['cart_qty'];
				$cart_line_total = $rs_cartmini[$i]['cart_line_total'];
				$product_image = $rs_cartmini[$i]['product_image'];
				$sub_folder = $rs_cartmini[$i]['product_folder'];
				$folder = 'product/' . $sub_folder . '/';
				$line_total = $rs_cartmini[$i]['cart_line_total'];
				$cart_total_price = $cart_total_price + $rs_cartmini[$i]['cart_line_total'];
				$banner_img = $this->get_image_path($product_image, $folder, "");
				$image = $banner_img['medium_image'];
				$line_total = $this->moneyFormatIndia($line_total);
				$mrp_display = '';
				if ($cart_product_mrp > $cart_product_price) {
					$mrp_display = '<del>' . $this->moneyFormatIndia($cart_product_mrp) . '</del>';
				}
				$cart_product_opt_name = $rs_cartmini[$i]['cart_product_opt_name'];
				$cart_product_opt_name2 = $rs_cartmini[$i]['cart_product_opt_name2'];
				$cart_product_opt_name3 = $rs_cartmini[$i]['cart_product_opt_name3'];
				$varient_name = array();
				if ($cart_product_opt_name != '') {
					$varient_name[] = $cart_product_opt_name;
				}
				if ($cart_product_opt_name2 != '') {
					$varient_name[] = $cart_product_opt_name2;
				}
				if ($cart_product_opt_name3 != '') {
					$varient_name[] = $cart_product_opt_name3;
				}
				$display_name = implode(', ', $varient_name);
				$price1 = $this->getprice_check_cart($product_id, $product_price_id, $cart_product_price, $cart_qty);
				$p_error = array();
				if ($price1['p_ids_data'] != '') {
					$p_error[] = $price1['p_ids_data'];
					$display_error_msg = $p_error[0]['p_notes'];
					$error_notes = '<div class="mini_cart_meta"><p class="item_error">' . $display_error_msg . '</p></div>';
				} else {
					$error_notes = '';
				}
				$cart_row .= '<div class="cart_item js_cart_item cart_item_' . $cart_id . '">
                        <div class="ld_cart_bar"></div>
                        <div class="row al_center">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="page_cart_info flex al_center">
                                    <a href="product-detail/' . $slug . '.html">
                                        <img class="lazyload w__100 lz_op_ef" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%201128%201439%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" data-src="' . $image . '" alt="">
                                    </a>
                                    <div class="mini_cart_body ml__15">
                                        <h5 class="mini_cart_title mg__0 mb__5"><a href="product-detail/' . $slug . '.html">' . $cart_product_name . '</a></h5>
                                        <div class="mini_cart_meta"><p class="cart_selling_plan">' . $display_name . '</p></div>
                                        <div class="mini_cart_tool mt__10">
                                            <a href="javascript:void(0)" onclick="remove_cart_items(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ')" class="cart_ac_remove js_cart_rem ttip_nt tooltip_top_right"><span class="tt_txt">Remove this item</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </a>
                                        </div>
										' . $error_notes . '
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 tc__ tc_lg">
                                <div class="cart_meta_prices price">
                                    <div class="cart_price">  ' . $price_display . '</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-2 tc mini_cart_actions">
                                <div class="quantity pr mr__10 qty__true">
                                    <input type="number" class="input-text qty text tc qty_cart_js"  name="quantity" readonly="readonly" value="' . $cart_qty . '">
                                    <div class="qty tc fs__14">
                                        <button type="button" class="plus db cb pa pd__0 pr__15 tr r__0 cart_detail_qty_<?=$cart_id?>" onclick="change_cart_page_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Plus\',)">
                                            <i class="facl facl-plus"></i></button>
                                        <button type="button" class="minus db cb pa pd__0 pl__15 tl l__0 qty_1 cart_detail_qty_<?=$cart_id?>" onclick="change_cart_page_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Minus\',)">
                                            <i class="facl facl-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-2 tc__ tr_lg">
                                <span class="cart-item-price fwm cd js_tt_price_it">' . $line_total . '</span>
                            </div>
                        </div>
                    </div>';
				$cart_row1 = '   <tr class="cart_item_' . $cart_id . '">
                <td class="remove-item"><button type="button" onclick="remove_cart_items(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ')" class="cart-close-btn position-static"><i class="uil uil-trash-alt"></i></button></td>
                <td class="cart-img text-left"><div class="cart-item">
                    <div class="cart-product-img"> <img src="' . $image . '" alt="' . $cart_product_name . '">
                      <?=$dis_t?>
                    </div>
                    <div class="cart-text align-self-center">
                      <h4 class="mb-1">' . $cart_product_name . '</h4>
                      <label class="text-secondary mb-0">' . $cart_product_opt_name . '</label>
					  ' . $error_notes . '
                    </div>
                  </div></td>
                <td class="cart-price"><div class="cart-item-price m-auto"><i class="fas fa-rupee-sign"></i>' . $cart_product_price . ' ' . $mrp_html . '</td>
                <td class="cart-qty"><div class="quantity buttons_added qty-small">
                    <input type="button" value="-" class="minus minus-btn cart_detail_qty_' . $cart_id . '" onclick="change_cart_page_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Minus\',)" >
                    <input type="number" step="1" name="quantity" readonly="readonly" value="' . $cart_qty . '" class="input-text qty text">
                    <input type="button" value="+" class="plus plus-btn cart_detail_qty_' . $cart_id . '" onclick="change_cart_page_qty(' . $cart_id . ',' . $product_id . ',' . $product_price_id . ',\'Plus\',)">
                  </div></td>
                <td class="cart-total-price"><div class="cart-item-price total-price"><i class="fas fa-rupee-sign"></i>' . $line_total . '</div></td>
              </tr>';
			}
		} else {
			$cart_row = '';
		}
		if ($cart_total_price >= $min_order_amount) {
			$static_min_cart_mesg = '';
			$disable_btn = '';
		} else {
			$static_min_cart_mesg = 'Minimum Order Amount <i class="fas fa-rupee-sign"></i>' . $min_order_amount . '';
			$disable_btn = 'disable_btn';
		}
		if ($cart_total_price == 0) {
			$disable_btn = 'disable_btn';
		}
		$json_class = $this->app->load_module("JSON");
		$obj_json = new $json_class(JSON_LOOSE_TYPE);
		$cart_total_price = $this->moneyFormatIndia($cart_total_price);
		echo $obj_json->encode(array("RESULT" => "1", "MSG" => $add_cart_msg, "CART_TOTAL" => $cart_total_price, "MIN_ORDER_AMOUNT" => $min_order_amount, "CART_ITEMS" => count($rs_cartmini), "CART_VENDOR" => $cart_vendor_row, "CART_BODY" => $cart_row, "items_o_html" => $items_o_html, "P_QTY" => $P_QTY, "static_min_cart_mesg" => $static_min_cart_mesg, "disable_btn" => $disable_btn));
		exit;
	}
	function generateOptionHtml($id, $master_type, $master_price, $master_mrp)
	{
		if ($master_type == 'Multiple') {
			$obj_model_table_ps = $this->app->load_model("product_info");
			$rs_master_data = $obj_model_table_ps->execute("SELECT", false, "", "product_id=" . $id . "", "id DESC Limit 0,1");
			$label1 = $rs_master_data[0]['attribute_title1'];
			$label2 = $rs_master_data[0]['attribute_title2'];
			$label3 = $rs_master_data[0]['attribute_title3'];
			$price_op1_label = 'Please Select ' . $label1;
			$price_op2_label = 'Please Select ' . $label2;
			$price_op3_label = 'Please Select ' . $label3;
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $id . " and attribute_1!=''", "id ASC", "attribute_1");
			$html = '';
			//is-selected
			if (count($rs_data) > 0) {
				$html .= '<div class="variations mb__20 style__circle size_medium style_color des_color_1">
                                                    <div class="swatch is-label kalles_swatch_js">
                                                        <h4 class="swatch__title">' . $label1 . ' :
                                                            <span class="nt_name_current user_choose_js">' . $selectedFName . '</span>
                                                        </h4>
                                                        <ul class="swatches-select swatch__list_pr d-flex">';
				for ($i = 0; $i < count($rs_data); $i++) {
					$selected = '';
					$fName = $rs_data[$i]['attribute_1'];
					$html .= '<li class="nt-swatch swatch_pr_item pr ' . $selected . '" data-escape="' . $fName . '" onclick="showSecondAttri(\'' . $fName . '\',' . $id . ')">
                                                                <span class="swatch__value_pr">' . $fName . '</span>
                                                            </li>';
				}
				$html .= '</ul>
                                                    </div>
													<div class="varient1_error_' . $id . ' error_varient"></div>
                                                </div>';
				$html .= '<div class="varient_2_html_' . $id . '"></div>';
				$html .= '<div class="varient_3_html_' . $id . '"></div>';
				$html .= '<input type="hidden" name="p_options" id="price_id_' . $id . '" class="price_id_' . $id . '" value="">';
				$html .= '<input type="hidden" name="" id="" class="price_op1_' . $id . '" value="' . $price_op1_label . '">';
				$html .= '<input type="hidden" name="" id="" class="price_op2_' . $id . '" value="' . $price_op2_label . '">';
				$html .= '<input type="hidden" name="" id="" class="price_op3_' . $id . '" value="' . $price_op3_label . '">';
				$html .= '<input type="hidden" name="" id="" class="price_op1_val_' . $id . '" value="">';
				$html .= '<input type="hidden" name="" id="" class="price_op2_val_' . $id . '" value="">';
				$html .= '<input type="hidden" name="" id="" class="price_op3_val_' . $id . '" value="">';
			} else {
				$html = '';
			}
			$priceID = 0;
		} else {
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $id . "", "");
			$priceID = $rs_data[0]['id'];
			$html = '<input type="hidden" name="p_options" id="price_id_' . $id . '" class="price_id_' . $id . '" value="' . $priceID . '">';
			$html .= '<input type="hidden" name="" id="" class="price_op1_' . $id . '" value="">';
			$html .= '<input type="hidden" name="" id="" class="price_op2_' . $id . '" value="">';
			$html .= '<input type="hidden" name="" id="" class="price_op3_' . $id . '" value="">';
		}
		$data = array();
		$data['html'] = $html;
		$data['priceID'] = $priceID;
		return $data;
	}
	function customer_cart_product($p_id, $price_id, $customer_id, $page_type)
	{
		$extra_no = '';
		$cart = $_SESSION['oshopping_CART'];
		for ($i = 0; $i < count($cart); $i++) {
			if ($price_id == $cart[$i]['cart_product_price_id']) {
				$quantity = $cart[$i]['cart_qty'];
			}
		}
		if ($quantity > 0) {
			/*$data='<div class="custome-qty qty-group">
                      <div class="quantity buttons_added">
                        <input type="button" value="-" class="minus minus-btn detail_qty_p_m_'.$p_id.'" onclick="add_to_cart('.$p_id.',\'Minus\','.$extra_no.')">
                        <input type="number" id="detail_qty_'.$p_id.'" step="1" readonly="readonly" name="quantity" value="'.$quantity.'" class="input-text qty text detail_qty_'.$p_id.'">
                        <input type="button" value="+" class="plus plus-btn detail_qty_p_m_'.$p_id.'" onclick="add_to_cart('.$p_id.',\'Plus\','.$extra_no.')">
                      </div>
                    </div>';*/
			$data = '<div class="quantity pr mr__10 order-1 qty__true d-inline-block" id="sp_qty_ppr">
                                                                <input type="number" class="input-text qty text tc qty_pr_js qty_cart_js detail_qty_' . $p_id . '" name="quantity" value="' . $quantity . '" id="detail_qty_' . $p_id . '" readonly="readonly">
                                                                <div class="qty tc fs__14">
                                                                    <button type="button" class="plus db cb pa pd__0 pr__15 tr r__0 detail_qty_p_m_' . $p_id . '" onclick="add_to_cart(' . $p_id . ',\'Plus\',' . $extra_no . ')">
                                                                        <i class="facl facl-plus"></i></button>
                                                                    <button type="button" class="minus db cb pa pd__0 pl__15 tl l__0  detail_qty_p_m_' . $p_id . '" onclick="add_to_cart(' . $p_id . ',\'Minus\',' . $extra_no . ')">
                                                                        <i class="facl facl-minus"></i></button>
                                                                </div>
                                                            </div>';
		} else {
			$data = '<button type="button" data-time="6000" onclick="add_to_cart(' . $p_id . ',\'Plus\',' . $extra_no . ')" data-ani="shake" class="single_add_to_cart_button AddCartBtn_' . $p_id . ' button truncate w__100 mt__20 order-4 d-inline-block animated">
                                                                <span class="txt_add ">Add to cart</span>
                                                            </button>';
		}
		return $data;
	}
	function store_uploaded_file($uploaddir, $uploadfilename = "", $chmod = "")
	{
		if ($uploadfilename == "") {
			$uploadfilename = basename($local_file);
		}
		$tmpname = $this->uploaded_file;
		if (USE_FTP) {
			if (!class_exists("ftp")) {
				$ftp_class = $this->app->add_module("ftp");
				if ($ftp_class != NULL) {
					$ftp = new $ftp_class();
				} else {
					trigger_error("Could not load ftp module", E_USER_ERROR);
				}
			} else {
				$ftp = new ftp();
			}
			if (!$ftp->SetServer(FTP_HOST)) {
				$ftp->quit();
				return false;
			}
			if (!$ftp->connect()) {
				$ftp->quit();
				return false;
			}
			if (!$ftp->login(FTP_USERNAME, FTP_PASSWORD)) {
				$ftp->quit();
				return false;
			}
			$ftp->SetType(FTP_AUTOASCII);
			$ftp->Passive(FALSE);
			$ftp->chdir(FTP_WWWDIR . $uploaddir);
			$ftp->pwd();
			if (FALSE === $ftp->put($tmpname, $uploadfilename)) {
				if ($this->uploaded_file != $tmpname) {
					@unlink($tmpname);
				}
				$ftp->quit();
				return false;
			} else {
				if ($this->uploaded_file != $tmpname) {
					@unlink($tmpname);
				}
				if (is_numeric($chmod)) {
					$ftp->chmod($uploadfilename, $chmod);
				}
				$ftp->quit();
				return true;
			}
		} else {
			if (copy($tmpname, ABS_PATH . DS . $uploaddir . DS . $uploadfilename)) {
				if ($this->uploaded_file != $tmpname) {
					@unlink($tmpname);
				}
				return true;
			} else {
				if ($this->uploaded_file != $tmpname) {
					@unlink($tmpname);
				}
				return false;
			}
		}
	}
	function remove_uploaded_file()
	{
		@unlink($this->uploaded_file);
	}
	function HTMLSafeString($Input, $QuotedString = true)
	{
		$Output = "";
		$Output = strip_tags($Input);
		if ($QuotedString)
			$Output = str_replace("\"", "", $Output);
		return $Output;
	}
	function DateAdd($interval, $number, $date = "")
	{
		if ($date != "") {
			$date_time_array = getdate($date);
		} else {
			$date_time_array = getdate();
		}
		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];
		switch ($interval) {
			case 'yyyy':
				$year += $number;
				break;
			case 'q':
				$year += ($number * 3);
				break;
			case 'm':
				$month += $number;
				break;
			case 'y':
			case 'd':
			case 'w':
				$day += $number;
				break;
			case 'ww':
				$day += ($number * 7);
				break;
			case 'h':
				$hours += $number;
				break;
			case 'n':
				$minutes += $number;
				break;
			case 's':
				$seconds += $number;
				break;
		}
		$timestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);
		return $timestamp;
	}
	function GetPageName()
	{
		$tmpArray = explode(DS, $_SERVER['SCRIPT_FILENAME']);
		$pagename = $tmpArray[sizeof($tmpArray) - 1];
		return $pagename;
	}
	function GetPageURL()
	{
		$pageURL = 'http://';
		if (array_key_exists("HTTPS", $_SERVER)) {
			if (strtoupper($_SERVER["HTTPS"]) == "ON") {
				$pageURL = 'https://';
			}
		}
		$pageURL .= $_SERVER['HTTP_HOST'] . "/" . $_SERVER["REQUEST_URI"];
		return $pageURL;
	}
	function GetContentType($file_extension)
	{
		switch (strtolower($file_extension)) {
			case "pdf":
				$ctype = "application/pdf";
				break;
			case "exe":
				$ctype = "application/octet-stream";
				break;
			case "zip":
				$ctype = "application/zip";
				break;
			case "doc":
				$ctype = "application/msword";
				break;
			case "xls":
				$ctype = "application/vnd.ms-excel";
				break;
			case "ppt":
				$ctype = "application/vnd.ms-powerpoint";
				break;
			case "gif":
				$ctype = "image/gif";
				break;
			case "png":
				$ctype = "image/png";
				break;
			case "jpeg":
			case "jpg":
				$ctype = "image/jpg";
				break;
			case "mp3":
				$ctype = "audio/mpeg";
				break;
			case "wav":
				$ctype = "audio/x-wav";
				break;
			case "mpeg":
			case "mpg":
			case "mpe":
				$ctype = "video/mpeg";
				break;
			case "mov":
				$ctype = "video/quicktime";
				break;
			case "avi":
				$ctype = "video/x-msvideo";
				break;
			case "php":
			case "htm":
			case "html":
			case "txt":
				die("<b>Cannot be used for " . $file_extension . " files!</b>");
				break;
			default:
				$ctype = "application/x-download";
		}
		return $ctype;
	}
	function GenerateRandomKey($Length)
	{
		$Key = "";
		$found = false;
		while (strlen($Key) < $Length) {
			srand((float)microtime() * 1000000);
			$number = rand(50, 150);
			if ($number >= 65 && $number <= 90)
				$Key = $Key . chr($number);
			elseif ($number >= 48 && $number <= 57)
				$Key = $Key . chr($number);
		}
		return trim($Key);
	}
	function ParseMailTemplate($Template, $Custom = "")
	{
		$GeneralKywords = array();
		$GeneralKywords["SERVER_ROOT"] = SERVER_ROOT;
		$f = fopen(ABS_PATH . DS . MAIL_TEMPLATE_PATH . "/" . $Template, "r");
		if (!$f) {
			return NULL;
		}
		$TemplateBody = fread($f, filesize(ABS_PATH . DS . MAIL_TEMPLATE_PATH . "/" . $Template));
		fclose($f);
		$HTMLBody = $TemplateBody;
		if (is_array($Custom)) {
			foreach ($Custom as $Find => $ReplaceWith) {
				$TemplateBody = str_replace("{" . $Find . "}", $ReplaceWith, $TemplateBody);
			}
		}
		foreach ($GeneralKywords as $Find => $ReplaceWith) {
			$TemplateBody = str_replace("{" . $Find . "}", $ReplaceWith, $TemplateBody);
		}
		return $TemplateBody;
	}
	function ParseMailText($Text, $Custom = "")
	{
		$GeneralKywords = array();
		$GeneralKywords["SERVER_ROOT"] = SERVER_ROOT;
		$TemplateBody = $Text;
		$HTMLBody = $TemplateBody;
		if (is_array($Custom)) {
			foreach ($Custom as $Find => $ReplaceWith) {
				$TemplateBody = str_replace("{" . $Find . "}", $ReplaceWith, $TemplateBody);
			}
		}
		foreach ($GeneralKywords as $Find => $ReplaceWith) {
			$TemplateBody = str_replace("{" . $Find . "}", $ReplaceWith, $TemplateBody);
		}
		return $TemplateBody;
	}
	function DateDiff($endDate, $beginDate)
	{
		$date_parts1[0] = date("m", $beginDate);
		$date_parts1[1] = date("d", $beginDate);
		$date_parts1[2] = date("Y", $beginDate);
		$date_parts2[0] = date("m", $endDate);
		$date_parts2[1] = date("d", $endDate);
		$date_parts2[2] = date("Y", $endDate);
		$start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
		$end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
		return $end_date - $start_date;
	}
	function TimeDiff($bigTime, $smallTime)
	{
		list($h1, $m1, $s1) = split(":", $bigTime);
		list($h2, $m2, $s2) = split(":", $smallTime);
		$second1 = $s1 + ($h1 * 3600) + ($m1 * 60); //converting it into seconds
		$second2 = $s2 + ($h2 * 3600) + ($m2 * 60);
		if ($second1 == $second2) {
			$resultTime = "00:00:00";
			return $resultTime;
			exit();
		}
		if ($second1 < $second2) //
		{
			$second1 = $second1 + (24 * 60 * 60); //adding 24 hours to it.
		}
		$second3 = $second1 - $second2;
		//print $second3;
		if ($second3 == 0) {
			$h3 = 0;
		} else {
			$h3 = floor($second3 / 3600); //find total hours
		}
		$remSecond = $second3 - ($h3 * 3600); //get remaining seconds
		if ($remSecond == 0) {
			$m3 = 0;
		} else {
			$m3 = floor($remSecond / 60); // for finding remaining  minutes
		}
		$s3 = $remSecond - (60 * $m3);
		if ($h3 == 0) //formating result.
		{
			$h3 = "00";
		}
		if ($m3 == 0) {
			$m3 = "00";
		}
		if ($s3 == 0) {
			$s3 = "00";
		}
		$resultTime = array($h3, $m3, $s3);
		return $resultTime;
	}
	function ChangeDateFormat($Date, $FromFormat, $ToFormat)
	{
		$KnownFormat = array("012" => "ddmmyyyy", "102" => "mmddyyyy", "210" => "yyyymmdd");
		if (!in_array($FromFormat, $KnownFormat) || !in_array($ToFormat, $KnownFormat)) {
			echo "<h3>Error in
			function \"ConvertDateFormat\" : Unknown Date Format";
			exit;
		}
		$Seperator = "";
		if (strpos($Date, "/") === false) {
		} else {
			$Seperator = "/";
		}
		if (strpos($Date, "\\") === false) {
		} else {
			$Seperator = "\\";
		}
		if (strpos($Date, "-") === false) {
		} else {
			$Seperator = "-";
		}
		if ($Seperator == "") {
			echo "<h3>Error in
			function \"ChangeDateFormat\" : Unknown Date Seperator";
			exit;
		}
		$DateArr = explode($Seperator, $Date);
		$FromDateSequence = array_search($FromFormat, $KnownFormat);
		$Day = $DateArr[strpos($FromDateSequence, "0")];
		$Month = $DateArr[strpos($FromDateSequence, "1")];
		$Year = $DateArr[strpos($FromDateSequence, "2")];
		$ToDateSequence = array_search($ToFormat, $KnownFormat);
		$NewDate = $DateArr[substr($ToDateSequence, 0, 1)] . $Seperator . $DateArr[substr($ToDateSequence, 1, 1)] . $Seperator . $DateArr[substr($ToDateSequence, 2, 1)];
		return $NewDate;
	}
	function NormalizeURL($URL, $tolower = true)
	{
		$find = array("/\s+/", "/[-]+/", "/\\\/", "/'/");
		$replace_with = array("-", "-", "", "");
		$URL = preg_replace($find, $replace_with, $URL);
		if ($tolower) {
			$URL = strtolower($URL);
		}
		return strtolower($URL);
	}
	function ArraySearchRecursive($needle, $haystack)
	{
		foreach ($haystack as $value) {
			if (is_array($value))
				$match = array_search_r($needle, $value);
			if ($value == $needle)
				$match = 1;
			if ($match)
				return 1;
		}
		return 0;
	}
	function html2txt($document)
	{
		$search = array(
			"'<script[^>]*?>.*?</script>'si",	// strip out javascript
			"'<[\/\!]*?[^<>]*?>'si",		// strip out html tags
			"'([\r\n])[\s]+'",			// strip out white space
			"'@<![\s\S]*?�??[ \t\n\r]*>@'",
			"'&(quot|#34|#034|#x22);'i",		// replace html entities
			"'&(amp|#38|#038|#x26);'i",		// added hexadecimal values
			"'&(lt|#60|#060|#x3c);'i",
			"'&(gt|#62|#062|#x3e);'i",
			"'&(nbsp|#160|#xa0);'i",
			"'&(iexcl|#161);'i",
			"'&(cent|#162);'i",
			"'&(pound|#163);'i",
			"'&(copy|#169);'i",
			"'&(reg|#174);'i",
			"'&(deg|#176);'i",
			"'&(#39|#039|#x27);'",
			"'&(euro|#8364);'i",			// europe
			"'&a(uml|UML);'",			// german
			"'&o(uml|UML);'",
			"'&u(uml|UML);'",
			"'&A(uml|UML);'",
			"'&O(uml|UML);'",
			"'&U(uml|UML);'",
			"'&szlig;'i",
		);
		$replace = array(
			"",
			"",
			" ",
			"\"",
			"&",
			"<",
			">",
			" ",
			chr(161),
			chr(162),
			chr(163),
			chr(169),
			chr(174),
			chr(176),
			chr(39),
			chr(128),
			"ä",
			"ö",
			"ü",
			"�?",
			"�?",
			"�?",
			"�?",
		);
		$text = preg_replace($search, $replace, $document);
		return trim($text);
	}
	function get_file_info($file)
	{
		$file_name = basename($file);
		$tmparr = explode(".", $file_name);
		$fileinfo = (object)NULL;
		$file_name = "";
		for ($i = 0; $i < (count($tmparr) - 1); $i++) {
			$file_name .= "." . $tmparr[$i];
		}
		if (strlen($file_name) > 0) {
			$file_name = substr($file_name, 1);
		}
		$fileinfo->filename = $file_name;
		$fileinfo->extension = $tmparr[count($tmparr) - 1];
		return $fileinfo;
	}
	function random_color()
	{
		mt_srand((float)microtime() * 1000000);
		$c = '';
		while (strlen($c) < 6) {
			$c .= sprintf("%02X", mt_rand(0, 255));
		}
		return $c;
	}
	function format_currency($number, $decimal_places = 2, $decimal_symbol = ".", $thousand_seperator = ",", $currency_symbol = "", $currency_symbol_position = 'before')
	{
		if (!is_numeric($number)) {
			return $number;
		} else {
			$formatted_number = number_format($number, $decimal_places, $decimal_symbol, $thousand_seperator);
			if ($currency_symbol != "") {
				if ($currency_symbol_position == 'after') {
					$formatted_number = $formatted_number . " " . $currency_symbol;
				} else {
					$formatted_number = $currency_symbol . " " . $formatted_number;
				}
			}
			return $formatted_number;
		}
	}
	function set_message($message, $type)
	{
		$_SESSION['msg'] = $message;
		$_SESSION['type'] = $type;
	}
	function get_message()
	{
		if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
			if ($_SESSION['type'] == 'SUCCESS') {
				if (VIR_DIR != "") {
					if (VIR_DIR == "admin/") {
						$message =  '<div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                        <h4><strong>Success</strong></h4>
                                        <p>' . $_SESSION['msg'] . '</p>
                                    </div>';
					} else {
						$message = '<div class="alert alert-success">
					 <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
					<strong>Success!</strong> ' . $_SESSION['msg'] . '
					</div>';
					}
				} else {
					$message =  '<p class="alert alert-success border-0 p-3 pl-5 rounded fs__12"><i class="las la-bell fs__22 mr-2 position-absolute top-15 left-15 text-dark"></i> ' . $_SESSION['msg'] . '</p>
				';
				}
			} else if ($_SESSION['type'] == 'ERROR') {
				if (VIR_DIR != "") {
					if (VIR_DIR == "admin/") {
						$message =  '
						<div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                        <h4><strong>Error</strong></h4>
                                        <p> ' . $_SESSION['msg'] . '</p>
                                    </div>';
					} else {
						$message =  '<div class="alert alert-error">
					 <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
					 <strong>Error!</strong> ' . $_SESSION['msg'] . '
						</div>';
					}
				} else {
					$message =  '<p class="alert alert-danger border-0 p-3 pl-5 rounded fs__12"><i class="las la-bell fs__22 mr-2 position-absolute top-15 left-15 text-dark"></i> ' . $_SESSION['msg'] . '</p>
				';
				}
			} else if ($_SESSION['type'] == 'MESSAGE') {
				$message =  '<div class="alert_box r_corners warning m_bottom_10">
					 	<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
						<i class="fa fa-exclamation-triangle"></i><p>' . $_SESSION['msg'] . '</p>
						</div>';
			}
			unset($_SESSION['msg']);
			unset($_SESSION['type']);
			return $message;
		}
	}
	function string_truncate($string, $length)
	{
		$length_of_string = strlen($string);
		if ($length_of_string > $length) {
			return substr($string, 0, $length) . "..";
		} else {
			return $string;
		}
	}
	function xTimeAgo($oldTime, $newTime, $timeType)
	{
		$timeCalc = strtotime($newTime) - strtotime($oldTime);
		if ($timeType == "x") {
			if ($timeCalc == 60) {
				$timeType = "m";
			}
			if ($timeCalc == (60 * 60)) {
				$timeType = "h";
			}
			if ($timeCalc == (60 * 60 * 24)) {
				$timeType = "d";
			}
		}
		if ($timeType == "s") {
			$timeCalc .= " seconds ago";
		}
		if ($timeType == "m") {
			$timeCalc = round($timeCalc / 60) . " minutes ago";
		}
		if ($timeType == "h") {
			$timeCalc = round($timeCalc / 60 / 60) . " hours ago";
		}
		if ($timeType == "d") {
			$timeCalc = round($timeCalc / 60 / 60 / 24) . " days ago";
		}
		return $timeCalc;
	}
	function change_weight_display($value)
	{
		$round = $value / 1000;
		if ($round >= 1) {
			$num = number_format($round, 2);
			$num = $num;
			return $num . " Kg";
		} else {
			$num = $value;
			return $num . " Gm";
		}
	}
	function change_weight_display_other($value)
	{
		$round = $value / 1000;
		if ($round >= 1) {
			$num = number_format($round, 2);
			$num = $num;
			return $num . " Kg";
		} else {
			$num = $value;
			return (int) $num . " Gm";
		}
	}
	function seo_url($string)
	{
		$string = str_replace(array('[\', \']'), '', $string);
		$string = preg_replace('/\[.*\]/U', '', $string);
		$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
		$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
		return strtolower(trim($string, '-'));
	}
	function getExtension($str)
	{
		$i = strrpos($str, ".");
		if (!$i) {
			return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str, $i + 1, $l);
		return $ext;
	}
	function resize_image($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1, $user_width2, $user_width3)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		$uploadedfile = $uploadedfile_tmpname;
		$file_name = basename($uploadedfile_name);
		$file_info = $this->get_file_info($file_name);
		if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "JPEG" || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
			$new_name = rand(9, 99) . time() . "." . $file_info->extension;
		}
		if ($new_name) {
			$filename = stripslashes($uploadedfile_name);
			$i = strrpos($filename, ".");
			if (!$i) {
				return "";
			}
			$l = strlen($filename) - $i;
			$ext = substr($filename, $i + 1, $l);
			$extension = $ext;
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$change = '<div class="msgdiv">Unknown Image extension </div> ';
				$errors = 1;
			} else {
				$size = filesize($uploadedfile_tmpname);
				if ($extension == "jpg" || $extension == "jpeg") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}
				echo $scr;
				list($width, $height) = getimagesize($uploadedfile);
				if ($width > $user_width1) {
					$newwidth = $user_width1;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				} else {
					$newwidth = $width;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				}
				if ($width > $user_width2) {
					$newwidth1 = $user_width2;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				} else {
					$newwidth1 = $width;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				}
				if ($width > $user_width3) {
					$newwidth2 = $user_width3;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				} else {
					$newwidth2 = $width;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				}
				imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagecolortransparent($tmp1, imagecolorallocatealpha($tmp1, 0, 0, 0, 127));
				imagealphablending($tmp1, false);
				imagesavealpha($tmp1, true);
				imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
				imagecolortransparent($tmp2, imagecolorallocatealpha($tmp2, 0, 0, 0, 127));
				imagealphablending($tmp2, false);
				imagesavealpha($tmp2, true);
				imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);
				$filename = "../" . $image_user_config . $new_name;
				$filename1 = "../" . $image_user_config . "mediumthumb" . $new_name;
				$filename2 = "../" . $image_user_config . "thumb" . $new_name;
				if ($extension == "jpg" || $extension == "jpeg") {
					imagejpeg($tmp, $filename, 100);
					imagejpeg($tmp1, $filename1, 100);
					imagejpeg($tmp2, $filename2, 100);
				} else if ($extension == "png") {
					imagepng($tmp, $filename);
					imagepng($tmp1, $filename1);
					imagepng($tmp2, $filename2);
				} else {
					imagepng($tmp, $filename, 100);
					imagepng($tmp1, $filename1, 100);
					imagepng($tmp2, $filename2, 100);
				}
				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				imagedestroy($tmp2);
			}
		}
		return $new_name;
	}
	function resize_multi_image($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1, $user_width2, $user_width3)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		$uploadedfile = $uploadedfile_tmpname;
		$file_name = basename($uploadedfile_name);
		$file_info = $this->get_file_info($file_name);
		if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "JPGE"  || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
			$new_name = time() . rand(1125, 999) . "." . $file_info->extension;
		}
		if ($new_name) {
			$filename = stripslashes($uploadedfile_name);
			$i = strrpos($filename, ".");
			if (!$i) {
				return "";
			}
			$l = strlen($filename) - $i;
			$ext = substr($filename, $i + 1, $l);
			$extension = $ext;
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$change = '<div class="msgdiv">Unknown Image extension </div> ';
				$errors = 1;
			} else {
				$size = filesize($uploadedfile_tmpname);
				if ($extension == "jpg" || $extension == "jpeg") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}
				echo $scr;
				list($width, $height) = getimagesize($uploadedfile);
				if ($width > $user_width1) {
					$newwidth = $user_width1;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				} else {
					$newwidth = $width;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				}
				if ($width > $user_width2) {
					$newwidth1 = $user_width2;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				} else {
					$newwidth1 = $width;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				}
				if ($width > $user_width3) {
					$newwidth2 = $user_width3;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				} else {
					$newwidth2 = $width;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				}
				imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagecolortransparent($tmp1, imagecolorallocatealpha($tmp1, 0, 0, 0, 127));
				imagealphablending($tmp1, false);
				imagesavealpha($tmp1, true);
				imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
				imagecolortransparent($tmp2, imagecolorallocatealpha($tmp2, 0, 0, 0, 127));
				imagealphablending($tmp2, false);
				imagesavealpha($tmp2, true);
				imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);
				$filename = $image_user_config . $new_name;
				$filename1 = $image_user_config . "mediumthumb" . $new_name;
				$filename2 = $image_user_config . "thumb" . $new_name;
				if ($extension == "jpg" || $extension == "jpeg") {
					imagejpeg($tmp, $filename, 100);
					imagejpeg($tmp1, $filename1, 100);
					imagejpeg($tmp2, $filename2, 100);
				} else if ($extension == "png") {
					imagepng($tmp, $filename);
					imagepng($tmp1, $filename1);
					imagepng($tmp2, $filename2);
				} else {
					imagepng($tmp, $filename, 100);
					imagepng($tmp1, $filename1, 100);
					imagepng($tmp2, $filename2, 100);
				}
				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				imagedestroy($tmp2);
			}
		}
		return $new_name;
	}
	//FOr Single image resize
	function resize_single_image($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		if (!empty($uploadedfile_name)) {
			$uploadedfile = $uploadedfile_tmpname;
			$file_name = basename($uploadedfile_name);
			$file_info = $this->get_file_info($file_name);
			if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "JPEG"  || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
				$new_name = time() . rand(9, 99) . "." . $file_info->extension;
			}
			if ($new_name) {
				$filename = stripslashes($uploadedfile_name);
				$i = strrpos($filename, ".");
				if (!$i) {
					return "";
				}
				$l = strlen($filename) - $i;
				$ext = substr($filename, $i + 1, $l);
				$extension = $ext;
				$extension = strtolower($extension);
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$change = '<div class="msgdiv">Unknown Image extension </div> ';
					$errors = 1;
				} else {
					$size = filesize($uploadedfile_tmpname);
					if ($extension == "jpg" || $extension == "jpeg") {
						$uploadedfile = $uploadedfile_tmpname;
						$src = imagecreatefromjpeg($uploadedfile);
					} else if ($extension == "png") {
						$uploadedfile = $uploadedfile_tmpname;
						$src = imagecreatefrompng($uploadedfile);
					} else {
						$src = imagecreatefromgif($uploadedfile);
					}
					//echo $scr;
					list($width, $height) = getimagesize($uploadedfile);
					if ($width > $user_width1) {
						$newwidth = $user_width1;
						$newheight = ($height / $width) * $newwidth;
						$tmp = imagecreatetruecolor($newwidth, $newheight);
					} else {
						$newwidth = $width;
						$newheight = ($height / $width) * $newwidth;
						$tmp = imagecreatetruecolor($newwidth, $newheight);
					}
					imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
					imagealphablending($tmp, false);
					imagesavealpha($tmp, true);
					imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					$filename = "../" . $image_user_config . $new_name;
					if ($extension == "jpg" || $extension == "jpeg") {
						imagejpeg($tmp, $filename, 100);
					} else if ($extension == "png") {
						imagepng($tmp, $filename);
					} else {
						imagepng($tmp, $filename, 100);
					}
					imagedestroy($src);
					imagedestroy($tmp);
				}
			} else {
			}
		}
		return $new_name;
	}
	function resize_single_image_front($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		$uploadedfile = $uploadedfile_tmpname;
		$file_name = basename($uploadedfile_name);
		$file_info = $this->get_file_info($file_name);
		if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
			$new_name = time() . "." . $file_info->extension;
		}
		if ($new_name) {
			$filename = stripslashes($uploadedfile_name);
			$extension = $this->getExtension($filename);
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$change = '
 			<div class="msgdiv">Unknown Image extension </div>
';
				$errors = 1;
			} else {
				$size = filesize($uploadedfile_tmpname);
				if ($extension == "jpg" || $extension == "jpeg") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}
				echo $scr;
				list($width, $height) = getimagesize($uploadedfile);
				if ($width > $user_width1) {
					$newwidth = $user_width1;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				} else {
					$newwidth = $width;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				}
				imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				//imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				$filename = $image_user_config . $new_name;
				if ($extension == "jpg" || $extension == "jpeg") {
					imagejpeg($tmp, $filename, 100);
				} else if ($extension == "png") {
					imagepng($tmp, $filename);
				} else {
					imagepng($tmp, $filename, 100);
				}
				//imagejpeg($tmp,$filename,100);
				imagedestroy($src);
				imagedestroy($tmp);
			}
		}
		return $new_name;
	}
	function is_member_login()
	{
		if (isset($_SESSION['MemberID'])) {
			$login = true;
		} else {
			$login = false;
		}
		return $login;
	}
	function give_me_the_parentlist($input_name, $input_class)
	{
		$obj_model_category = $this->app->load_model('category');
		$rs_cat = $obj_model_category->execute("SELECT", false, "", "");
		if ($input_name == '') {
			return 'select dropdown name not found';
			exit;
		} else {
			$name = 'name="' . $input_name . '"';
			$id = 'name="' . $input_name . '"';
		}
		if ($input_class == '') {
			$class = '';
		} else {
			$class = 'class="' . $class . '"';
		}
		$option = '<select ' . $name . ' ' . $id . ' ' . $class . '>';
		$option .= '<option value="0">-----None-----</option>';
		for ($i = 0; $i < count($rs_cat); $i++) {
			if ($rs_cat[$i]["parentcategory_id"] == 0) {
				$option .= '<option value="' . $rs_cat[$i]["id"] . '">' . $rs_cat[$i]["category_name"] . '</option>';
			} else {
				$obj_model_category = $this->app->load_model('category');
				$rs_pcat = $obj_model_category->execute("SELECT", false, "", "id=" . $rs_cat[$i]["parentcategory_id"] . "");
				$option .= '<option value="' . $rs_cat[$i]["id"] . '">' . $rs_pcat[0]['category_name'] . ' &raquo; ' . $rs_cat[$i]["category_name"] . '</option>';
			}
		}
		$option .= '</select>';
		echo  $option;
	}
	function buildTree(array $data, $parent = 0)
	{
		$tree = array();
		foreach ($data as $d) {
			if ($d['parentcategory_id'] == $parent) {
				$children = $this->buildTree($data, $d['id']);
				// set a trivial key
				if (!empty($children)) {
					$d['_children'] = $children;
				}
				$tree[] = $d;
			}
		}
		return $tree;
	}
	// print_r($tree);
	function printTree($tree, $r = 0, $p = null)
	{
		foreach ($tree as $i => $t) {
			$dash = ($t['parentcategory_id'] == 0) ? '' : str_repeat('-', $r) . ' ';
			printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['category_name']);
			if ($t['parentcategory_id'] == $p) {
				// reset $r
				$r = 0;
			}
			if (isset($t['_children'])) {
				$this->printTree($t['_children'], ++$r, $t['parentcategory_id']);
			}
		}
	}
	function finaltree($tree, $name)
	{
		print("<select name='" . $name . "' id='" . $name . "'>\n");
		print('<option value="0">-----None-----</option>');
		$this->printTree($tree);
		print("</select>");
	}
	// print_r($tree);
	function countsubcat($pid)
	{
		$obj_model_category = $this->app->load_model('category');
		$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT COUNT(parentcategory_id) AS say FROM category WHERE parentcategory_id='$pid' limit 1", "");
		return $rs_cat[0]['say'];
	}
	function listmenu($pid = 0, $act, $product_id)
	{
		if ($act == 'edit') {
			$obj_model_category = $this->app->load_model('category');
			$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,category_name,parentcategory_id FROM category WHERE parentcategory_id='$pid'", "");
			$i = 0;
			foreach ($rs_cat as $cat) {
				$obj_model_product_category = $this->app->load_model('product_category');
				$rs_product_cat = $obj_model_product_category->execute("SELECT", false, "", "product_id=" . $product_id . " and category_id=" . $cat['id'] . "");
				if ($i % 2 == 0) {
					echo '<div class="even">';
				} else {
					echo '<div class="odd">';
				}
				if ($rs_product_cat[0]["category_id"] == $cat['id']) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
				print '<input type="checkbox" ' . $checked . ' name="product_category[]" value="' . $cat['id'] . '">
 ' . $cat['category_name'] . '  ';
				if ($this->countsubcat($cat['id']) > 0) {
					echo '<div class="subs">';
					$this->listmenu($cat['id'], $act, $product_id);
					echo '</div>';
				}
				echo '</div>';
			}
		} else {
			$obj_model_category = $this->app->load_model('category');
			$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,category_name,parentcategory_id FROM category WHERE parentcategory_id='$pid'", "");
			$i = 0;
			foreach ($rs_cat as $cat) {
				if ($i % 2 == 0) {
					echo '<div class="even">';
				} else {
					echo '<div class="odd">';
				}
				print '<input type="checkbox" name="product_category[]" value="' . $cat['id'] . '">
 ' . $cat['category_name'] . '  ';
				if ($this->countsubcat($cat['id']) > 0) {
					echo '<div class="subs">';
					$this->listmenu($cat['id'], '', '');
					echo '</div>';
				}
				echo '</div>';
			}
		}
		$i++;
	}
	function getCatPath($category_id)
	{
		$obj_model_category = $this->app->load_model('category');
		$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,category_name,parentcategory_id FROM category WHERE id=" . $category_id . "", "");
		if ($rs_cat[0]['parentcategory_id']) {
			$a = $this->getCatPath($rs_cat[0]['parentcategory_id']);
			$a .= ' &raquo; ' . $rs_cat[0]['category_name'];
			return $a;
		} else {
			return $rs_cat[0]['category_name'];
		}
	}
	//use in product list for category search
	function getCatPath1($category_id)
	{
		$obj_model_category = $this->app->load_model('category');
		$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,category_name,parentcategory_id FROM category WHERE id=" . $category_id . "", "");
		if ($rs_cat[0]['parentcategory_id']) {
			$a = $this->getCatPath1($rs_cat[0]['parentcategory_id']);
			$a .= ' &raquo; <a href="index.php?view=product_list&category_id=' . $rs_cat[0]['id'] . '">' . $rs_cat[0]['category_name'] . '</a>';
			return $a;
		} else {
			return '<a href="index.php?view=product_list&category_id=' . $rs_cat[0]['id'] . '">' . $rs_cat[0]['category_name'] . '</a>';
		}
	}
	function thumbnail($image_path, $thumb_path, $image_name, $thumb_width)
	{
		$src_img = imagecreatefromjpeg("$image_path/$image_name");
		$origw = imagesx($src_img);
		$origh = imagesy($src_img);
		$new_w = $thumb_width;
		$diff = $origw / $new_w;
		$new_h = $new_w;
		$dst_img = imagecreate($new_w, $new_h);
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, imagesx($src_img), imagesy($src_img));
		imagejpeg($dst_img, "$thumb_path/$image_name");
		return TRUE;
	}
	function resize($filename, $width, $height)
	{
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		}
		$info = pathinfo($filename);
		$extension = $info['extension'];
		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);
			if ($width_orig != $width || $height_orig != $height) {
				//$is=$this->app->load_module("Image");
				/*if($is == NULL)
				{
				echo 'Could not load Image Resizer Module';
			    }*/
				$is = $this->app->load_module("Image");
				$is = new Image(DIR_IMAGE . $old_image);
				$is->resize($width, $height);
				$is->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}
		if (isset($_SERVER["HTTPS"]) && (($_SERVER["HTTPS"] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return $new_image;
		} else {
			return $new_image;
		}
	}
	function highlight1($text, $words)
	{
		$split_words = explode("", $words);
		foreach ($split_words as $word) {
			$word = trim($word);
			$color = "#e5e5e5";
			$text = preg_replace("|($word)|Ui", "<b class='matched_word'><b>$1</b></b>", $text);
		}
		return $text;
	}
	function highlight($str, $keyword)
	{
		$str = preg_replace("/\b([a-z]*${keyword}[a-z]*)\b/i", "<b>$1</b>", $str);
		return $str;
	}
	function get_search_condition($s)
	{
		$array = explode(" ", $s);
		$array2 = explode(" ", $s);
		$popped = array();
		$popped_case = array();
		$like = "";
		$when = "";
		while (count($array) > 1) {
			$clause = implode("%", $array);
			if ($like) $like .= " or";
			$like .= " product_name like '%$clause%'";
			$popped[] = array_pop($array);
		}
		$i = 1;
		while (count($array2) > 1) {
			$clause2 = implode("%", $array2);
			$when .= " when product_name like '%$clause2%' then $i ";
			$popped_case[] = array_pop($array2);
			$i++;
		}
		$q .=
			$like .
			($like ? " or product_name like '%" : " product_name like '%") .
			implode(
				"%' or product_name like '%",
				array_merge($array, $popped)
			) .
			"%' ";
		return $q;
	}
	function get_search_condition_tag($s)
	{
		$array = explode(" ", $s);
		$array2 = explode(" ", $s);
		$popped = array();
		$popped_case = array();
		$like = "";
		$when = "";
		while (count($array) > 1) {
			$clause = implode("%", $array);
			if ($like) $like .= " or";
			$like .= " tag like '%$clause%'";
			$popped[] = array_pop($array);
		}
		$i = 1;
		while (count($array2) > 1) {
			$clause2 = implode("%", $array2);
			$when .= " when tag like '%$clause2%' then $i ";
			$popped_case[] = array_pop($array2);
			$i++;
		}
		$q .=
			$like .
			($like ? " or tag like '%" : " tag like '%") .
			implode(
				"%' or tag like '%",
				array_merge($array, $popped)
			) .
			"%' ";
		return $q;
	}
	function get_order_condition($s)
	{
		$array = explode(" ", $s);
		$array2 = explode(" ", $s);
		$popped = array();
		$popped_case = array();
		$like = "";
		$i = 1;
		$j = count($array);
		while (count($array) > 1) {
			$clause = implode("%", $array);
			if ($like) $like .= "";
			$like .= "when product_name like '%$clause%' -";
			$popped[] = array_pop($array);
			$i++;
		}
		$q .= $like . ("when product_name like '%") . implode("%'- when product_name like '%", array_merge($array, $popped)) . "%'-";
		$a = explode('-', $q);
		$qr = "";
		for ($k = 0; $k < count($a) - 1; $k++) {
			if ($k == count($a)) {
				//$qr.=' '.$a[$k].' '.'then '.($k+1);
			} else {
				$qr .= ' ' . $a[$k] . ' ' . ' then ' . ($k + 4);
			}
		}
		return $qr;
	}
	function get_order_condition_tag($s)
	{
		$array = explode(" ", $s);
		$array2 = explode(" ", $s);
		$popped = array();
		$popped_case = array();
		$like = "";
		$i = 1;
		$j = count($array);
		while (count($array) > 1) {
			$clause = implode("%", $array);
			if ($like) $like .= "";
			$like .= "when tag like '%$clause%' -";
			$popped[] = array_pop($array);
			$i++;
		}
		$q .= $like . ("when tag like '%") . implode("%'- when tag like '%", array_merge($array, $popped)) . "%'-";
		$a = explode('-', $q);
		$qr = "";
		for ($k = 0; $k < count($a) - 1; $k++) {
			if ($k == count($a)) {
				//$qr.=' '.$a[$k].' '.'then '.($k+1);
			} else {
				$qr .= ' ' . $a[$k] . ' ' . ' then ' . ($k + 4);
			}
		}
		return $qr;
	}
	function get_shipping_details($order_id)
	{
		$obj_model_shipping = $this->app->load_model("order_shipping_address");
		$rs_shipping = $obj_model_shipping->execute("SELECT", false, "", "id='" . $order_id . "'");
		$data = array();
		$first_name = $rs_shipping[0]['first_name'];
		$data['name'] = $first_name;
		$address_line1 = $rs_shipping[0]['address_line1'];
		$data['address_line1'] = $address_line1;
		$address_line2 = $rs_shipping[0]['address_line2'];
		$data['address_line2'] = $address_line2;
		$city = $rs_shipping[0]['city'];
		$data['city'] = $city;
		$zipcode = $rs_shipping[0]['zipcode'];
		$data['zipcode'] = $zipcode;
		$state = $rs_shipping[0]['state'];
		$data['state'] = $state;
		$country = $rs_shipping[0]['country'];
		$data['country'] = $country;
		$country = $rs_shipping[0]['country'];
		$data['country'] = $country;
		$contact_number = $rs_shipping[0]['contact_number'];
		$data['contact_number'] = $contact_number;
		$email = $rs_shipping[0]['email'];
		$data['email'] = $email;
		return $data;
	}
	function get_country_details($country_id)
	{
		$obj_model_country = $this->app->load_model("country");
		$rs_country = $obj_model_country->execute("SELECT", false, "", "id='" . $country_id . "'");
		$data = array();
		$country_code = $rs_country[0]['iso_code_2'];
		$data['country_code'] = $country_code;
		$currency_code = $rs_country[0]['currency_code'];
		$data['currency_code'] = $currency_code;
		$country_name = $rs_country[0]['name'];
		$data['country_name'] = $country_name;
		return $data;
	}
	function get_state_details($state_id)
	{
		$obj_model_zone = $this->app->load_model("zone");
		$rs_state = $obj_model_zone->execute("SELECT", false, "", "id='" . $state_id . "'");
		$data = array();
		$state_name = $rs_state[0]['name'];
		$data['state_name'] = $state_name;
		$state_code = $rs_state[0]['code'];
		$data['state_code'] = $state_code;
		return $data;
	}
	function getporefrence()
	{
		$obj_model_purchases = $this->app->load_model("purchases");
		$rs_purchases = $obj_model_purchases->execute("SELECT", false, "", "", "id DESC limit 0,1");
		$reference = $rs_purchases[0]['id'];
		$reference = $reference + 1;
		return 'PO-' . $reference;
	}
	function getlastpurchasecost($product_id)
	{
		$obj_model_purchases = $this->app->load_model("purchase_items");
		$rs_purchases = $obj_model_purchases->execute("SELECT", false, "", "product_id=" . $product_id . "", "product_id DESC limit 0,1");
		$unit_price = $rs_purchases[0]['unit_price'];
		return $unit_price;
	}
	function generateproductcode()
	{
		$obj_model_product = $this->app->load_model("product");
		$rs_product = $obj_model_product->execute("SELECT", false, "", "", "id DESC limit 0,1");
		$product_id = $rs_product[0]['id'] + 1;
		return 'KK-' . $product_id;
	}
	function getkgprice($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1000");
		if (count($rs_price) > 0) {
			$unit_price = intval($rs_price[0]['price']);
		} else {
			$rs_min_price = $obj_model_product_price->execute("SELECT", false, "SELECT MIN(price) as min_price FROM product_price WHERE product_id=" . $product_id . "", "");
			$unit_price = intval($rs_min_price[0]['min_price']);
		}
		return $unit_price;
	}
	function getkgmrp($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1000");
		if (count($rs_price) > 0) {
			$unit_price = intval($rs_price[0]['mrp']);
		} else {
			$rs_min_price = $obj_model_product_price->execute("SELECT", false, "SELECT MIN(mrp) as min_price FROM product_price WHERE product_id=" . $product_id . "", "");
			$unit_price = intval($rs_min_price[0]['min_price']);
		}
		return $unit_price;
	}
	function getpcprice($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1");
		$unit_price = intval($rs_price[0]['price']);
		return $unit_price;
	}
	function getpcprice_update($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "");
		$unit_price = intval($rs_price[0]['price']) / $rs_price[0]['weight'];
		return $unit_price;
	}
	function getpcpriceauto($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "price ASC");
		$unit_price = intval($rs_price[0]['price']);
		return $unit_price;
	}
	function getpcpriceauto2($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "price DESC");
		$unit_price = intval($rs_price[0]['price']);
		return $unit_price;
	}
	function getsingleprice($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "");
		$unit_price = intval($rs_price[0]['price']);
		return $unit_price;
	}
	function getproductname($product_id)
	{
		$obj_model_product = $this->app->load_model("product");
		$rs_product = $obj_model_product->execute("SELECT", false, "", "id='" . $product_id . "'");
		return $rs_product[0]['product_name'];
	}
	function getarea_name($area_id)
	{
		$obj_model_area = $this->app->load_model("area");
		$rs_area = $obj_model_area->execute("SELECT", false, "", "id='" . $area_id . "'");
		return $rs_area[0]['name'];
	}
	function getsupplierdetail($supplier_id)
	{
		$obj_model_supplier = $this->app->load_model("supplier");
		$rs_supplier = $obj_model_supplier->execute("SELECT", false, "", "id='" . $supplier_id . "'");
		$data = array();
		$supplier_name = $rs_supplier[0]['name'];
		$data['name'] = $supplier_name;
		$company = $rs_supplier[0]['company'];
		$data['company'] = $company;
		$address = $rs_supplier[0]['address'];
		$data['address'] = $address;
		$phone = $rs_supplier[0]['phone'];
		$data['phone'] = $phone;
		$email = $rs_supplier[0]['email'];
		$data['email'] = $email;
		return $data;
	}
	function order_weights($product_id, $order_id)
	{
		$obj_model_od = $this->app->load_model("order_detail");
		$rs = $obj_model_od->execute("SELECT", false, "SELECT order_detail.*,count(order_detail.product_weight*order_detail.quantity) as total_no, product.product_unit AS product_product_unit, order_master.order_status AS order_master_order_status FROM order_detail LEFT JOIN product AS product ON(product.id=order_detail.product_id) LEFT JOIN order_master AS order_master ON(order_master.id=order_detail.order_master_id) WHERE order_detail.id!=0 AND (product_id=" . $product_id . " and order_master.order_status='Paid')  group by order_detail.product_weight*order_detail.quantity");
		$opt = '';
		foreach ($rs as $item) {
			if ($item['line_total'] > 0) {
				if ($item['item_unit'] == 'in_gm') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else if ($item['item_unit'] == 'in_ltr') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else {
					$item_wt = (int)($item['product_weight']) . ' Pcs';
				}
				$opt .= '<span class="label label-success" style="text-decoration:underline;">' . $item_wt . ' x <b>' . $item['quantity'] . '</b> - ( <strong>' . $item['total_no'] . '</strong> )</span>';
			}
		}
		return $opt;
	}
	function order_weights_date($product_id, $order_id, $date)
	{
		$obj_model_od = $this->app->load_model("order_detail");
		$rs = $obj_model_od->execute("SELECT", false, "SELECT order_detail.*,count(order_detail.product_weight*order_detail.quantity) as total_no, product.product_unit AS product_product_unit, order_master.order_status AS order_master_order_status FROM order_detail LEFT JOIN product AS product ON(product.id=order_detail.product_id) LEFT JOIN order_master AS order_master ON(order_master.id=order_detail.order_master_id) WHERE order_detail.id!=0 AND (product_id=" . $product_id . " and order_master.order_status='Paid' " . $date . ")  group by order_detail.product_weight*order_detail.quantity");
		$opt = '';
		foreach ($rs as $item) {
			if ($item['line_total'] > 0) {
				if ($item['item_unit'] == 'in_gm') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else if ($item['item_unit'] == 'in_ltr') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else {
					$item_wt = (int)($item['product_weight']) . ' Pcs';
				}
				$opt .= '<span class="label label-success" style="text-decoration:underline;">' . $item_wt . ' x <b>' . $item['quantity'] . '</b> - ( <strong>' . $item['total_no'] . '</strong> )</span>';
			}
		}
		return $opt;
	}
	function order_weights_zone($product_id, $order_id, $zone_cond)
	{
		$obj_model_od = $this->app->load_model("order_detail");
		$rs = $obj_model_od->execute("SELECT", false, "SELECT order_detail.*,count(order_detail.product_weight*order_detail.quantity) as total_no, product.product_unit AS product_product_unit, order_master.order_status AS order_master_order_status, order_master.zone_id AS order_master_zone_id FROM order_detail LEFT JOIN product AS product ON(product.id=order_detail.product_id) LEFT JOIN order_master AS order_master ON(order_master.id=order_detail.order_master_id) WHERE order_detail.id!=0 AND (product_id=" . $product_id . " and order_master.order_status='Paid' " . $zone_cond . ")  group by order_detail.product_weight*order_detail.quantity");
		$opt = '';
		foreach ($rs as $item) {
			if ($item['line_total'] > 0) {
				if ($item['item_unit'] == 'in_gm') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else if ($item['item_unit'] == 'in_ltr') {
					$item_wt = $this->change_weight_display_other_2018($item['product_weight'], $item['item_unit']);
				} else {
					$item_wt = (int)($item['product_weight']) . ' Pcs';
				}
				$opt .= '<span class="label label-success" style="text-decoration:underline;">' . $item_wt . ' x <b>' . $item['quantity'] . '</b> - ( <strong>' . $item['total_no'] . '</strong> )</span>';
			}
		}
		return $opt;
	}
	function order_weights_b($product_id, $order_id)
	{
		$obj_model_od = $this->app->load_model("order_detail");
		$rs = $obj_model_od->execute("SELECT", false, "SELECT order_detail.*,count(order_detail.product_weight*order_detail.quantity) as total_no, product.product_unit AS product_product_unit, order_master.order_status AS order_master_order_status FROM order_detail LEFT JOIN product AS product ON(product.id=order_detail.product_id) LEFT JOIN order_master AS order_master ON(order_master.id=order_detail.order_master_id) WHERE order_detail.id!=0 AND (product_id=" . $product_id . " and order_master.order_status='Paid')  group by order_detail.product_weight*order_detail.quantity");
		$opt = '';
		foreach ($rs as $item) {
			if ($item['product_product_unit'] == 'in_gm') {
				$item_wt = $this->change_weight_display_other_2018($item['product_weight'] * $item['quantity'], $item['product_product_unit']);
			} else if ($item['product_product_unit'] == 'in_ltr') {
				$item_wt = $this->change_weight_display_other_2018($item['product_weight'] * $item['quantity'], $item['product_product_unit']);
			} else {
				$item_wt = (int)($item['product_weight'] * $item['quantity']) . 'Pcs';
			}
			$opt .= '<span class="label label-success" style="text-decoration:underline;">' . $item_wt . ' - ( <strong>' . $item['total_no'] . '</strong> )</span>';
		}
		return $opt;
	}
	function curPageURL()
	{
		$pageURL = 'http';
		//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	function removeFromString($str, $item)
	{
		$parts = explode(',', $str);
		while (($i = array_search($item, $parts)) !== false) {
			unset($parts[$i]);
		}
		return implode(',', $parts);
	}
	function keygen($length)
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $characters[rand(0, $charactersLength - 1)];
		}
		if (strlen($key) != $length) {
			$this->keygen($length);
		} else if (strlen($key) == $length) {
			if ($key != '') {
				$obj_model_user = $this->app->load_model("customer");
				$rs_user = $obj_model_user->execute("SELECT", false, "SELECT ref_key FROM customer WHERE ref_key='" . $key . "'", "");
				if (count($rs_user) > 0) {
					$this->keygen($length);
				} else {
					return $key;
				}
			} else {
				$this->keygen($length);
			}
		} else {
			$this->keygen($length);
		}
	}
	function random_password($length)
	{
		$key = '';
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		$inputs = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
		for ($i = 0; $i < $length; $i++) {
			$key .= $inputs[mt_rand(0, 61)];
		}
		return $key;
	}
	function last_id($table_name)
	{
		$obj_model_lid = $this->app->load_model($table_name);
		$rslid = $obj_model_lid->execute("SELECT", false, "", "", "id DESC LIMIT 1");
		return $rslid[0]['id'];
	}
	function unique_slug($table_name, $action, $slug_field, $value, $edit_id = 0)
	{
		if ($action == 'add') {
			$value_slug = $this->seo_url($value);
			$obj_model_slug = $this->app->load_model($table_name);
			$rsslug = $obj_model_slug->execute("SELECT", false, "", "" . $slug_field . "='" . $value_slug . "'");
			if (count($rsslug) > 0) {
				$slug_id = $this->last_id($table_name) + 1;
				$slug = $value_slug . '_' . $slug_id;
			} else {
				$slug = $value_slug;
			}
		} else {
			$value_slug = $this->seo_url($value);
			$obj_model_slug = $this->app->load_model($table_name);
			$rsslug = $obj_model_slug->execute("SELECT", false, "", "id!=" . $edit_id . " and " . $slug_field . "='" . $value_slug . "'");
			if (count($rsslug) > 0) {
				$slug_id = $edit_id;
				$slug = $value_slug . '_' . $slug_id;
			} else {
				$slug = $value_slug;
			}
		}
		return $slug;
	}
	function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	function detect_browser()
	{
		// Copyright 2013.1.5 Mehdi Jazini mr.jazini@gmail.com
		$ExactBrowserNameUA = $_SERVER['HTTP_USER_AGENT'];
		if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
			// OPERA
			$ExactBrowserNameBR = "Opera";
		} else if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
			// CHROME
			$ExactBrowserNameBR = "Chrome";
		} else if (strpos(strtolower($ExactBrowserNameUA), "msie")) {
			// INTERNET EXPLORER
			$ExactBrowserNameBR = "Internet Explorer";
		} else if (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
			// FIREFOX
			$ExactBrowserNameBR = "Firefox";
		} else if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/") == false and strpos(strtolower($ExactBrowserNameUA), "chrome/") == false) {
			// SAFARI
			$ExactBrowserNameBR = "Safari";
		} else {
			// OUT OF DATA
			$ExactBrowserNameBR = "OUT OF DATA";
		};
		return $ExactBrowserNameBR;
	}
	function get_userdata($name, $password, $email, $address, $area, $zipcode, $city, $state, $country, $mobile)
	{
		$obj_model_user = $this->app->load_model("user");
		if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0) {
			$rs_userdata = $obj_model_user->execute("SELECT", false, "", "id=" . $_SESSION['user_id'] . "");
			$userdata = $rs_userdata[0];
		} else {
			$rs_userdata = $obj_model_user->execute("SELECT", false, "", "email='" . $email . "'");
			if (count($rs_userdata) > 0) {
				$userdata = $rs_userdata[0];
			} else {
				$data = array();
				$data['name'] = $name;
				$data['email'] = $email;
				$data['login_password'] = base64_encode($password);
				$data['billing_address_line1'] = $address;
				$data['area_name'] = $area;
				$data['billing_zip_code'] = $zipcode;
				$data['billing_city'] = $city;
				$data['billing_state'] = $state;
				$data['billing_country'] = $country;
				$data['mobilephone'] = $mobile;
				$data['registration_date'] = date('d-m-Y H:i:s');
				$data['registered_with'] = 'website';
				$data['ref_key'] = $this->keygen(6);
				$obj_model_user->map_fields($data);
				$insertid = $obj_model_user->execute("INSERT");
				//Mail Code For User
				$obj_mailer = $this->app->load_module("mailer\sender");
				$mail_body = $this->ParseMailTemplate("guest_user_mail.html", array("name" => $name, "password" => $password, "email" => $email));
				if ($mail_body == NULL) {
					$this->app->display_error(NULL, "Could not parse the mail template");
				}
				$obj_mailer->create();
				$obj_mailer->subject("Username And Password");
				$obj_mailer->add_to($email);
				$obj_mailer->htmlbody($mail_body);
				$flag = $obj_mailer->send();
				$obj_model_user = $this->app->load_model("user");
				$rs_userdata = $obj_model_user->execute("SELECT", false, "", "id=" . $insertid . "");
				$userdata = $rs_userdata[0];
			}
		}
		return $userdata;
	}
	function getprocategories($product_id)
	{
		$category = $this->app->load_model("category");
		$category->join_table("product_category", "left", array("category_id"), array("id" => "category_id"));
		$rs_category = $category->execute("SELECT", false, "", "product_category.product_id=" . $product_id . "");
		//echo $category->sql;
		$cat_li = "<ul>";
		for ($i = 0; $i < count($rs_category); $i++) {
			$cat_path = $this->getCatPath($rs_category[$i]['id']);
			$cat_li .= "<li>" . $cat_path . "</li>\n";
		}
		$cat_li .= "</ul>";
		return $cat_li;
	}
	function getprocategories1($product_id)
	{
		$category = $this->app->load_model("category");
		$category->join_table("product_category", "left", array("category_id"), array("id" => "category_id"));
		$rs_category = $category->execute("SELECT", false, "", "product_category.product_id=" . $product_id . "");
		//echo $category->sql;
		$cat_li = "<ul>";
		for ($i = 0; $i < count($rs_category); $i++) {
			$cat_path = $this->getCatPath1($rs_category[$i]['id']);
			$cat_li .= "<li>" . $cat_path . "</li>\n";
		}
		$cat_li .= "</ul>";
		return $cat_li;
	}
	function get_zone($area_name)
	{
		$obj_model_area = $this->app->load_model("area");
		$rs_area = $obj_model_area->execute("SELECT", false, "", "name='" . trim($area_name) . "'");
		if (count($rs_area) > 0) {
			if ($rs_area[0]['zone'] == 'West') {
				$zone = '<span style="background-color:#67C652; padding:5px; color:#FFF">West</span>';
			} elseif ($rs_area[0]['zone'] == 'South-West') {
				$zone = '<span style="background-color:#F15F5F; padding:5px; color:#FFF">South-West</span>';
			} elseif ($rs_area[0]['zone'] == 'South') {
				$zone = '<span style="background-color:#F1B337; padding:5px; color:#FFF">South</span>';
			} elseif ($rs_area[0]['zone'] == 'North') {
				$zone = '<span style="background-color:#54A8EC; padding:5px; color:#FFF">North</span>';
			} elseif ($rs_area[0]['zone'] == 'East') {
				$zone = '<span style="background-color:#EC7E57; padding:5px; color:#FFF">East</span>';
			} else {
				$zone = '<span style="background-color:#6AC9EA; padding:5px; color:#FFF">Centeral</span>';
			}
		} else {
			$zone = '-';
		}
		return $zone;
	}
	function get_zone_name($area)
	{
		$obj_model_area = $this->app->load_model("area");
		$rs_area = $obj_model_area->execute("SELECT", false, "", "name='" . trim($area) . "'");
		if (count($rs_area) > 0) {
			$zone_name = $rs_area[0]['zone'];
		} else {
			$zone_name = '';
		}
		return $zone_name;
	}
	function get_sms_data($sms_type)
	{
		$obj_model_tabel = $this->app->load_model("sms_data");
		$rs_data = $obj_model_tabel->execute("SELECT", false, "", "name='" . $sms_type . "' and status='Active'");
		if (count($rs_data) > 0) {
			$sms_message = $rs_data[0]['sms_text'];
		} else {
			$sms_message = '';
		}
		return $sms_message;
	}
	//New Function Template Id and Language
	function get_sms_template($sms_type)
	{
		$obj_model_tabel = $this->app->load_model("sms_data");
		$rs_data = $obj_model_tabel->execute("SELECT", false, "", "name='" . $sms_type . "' and status='Active'");
		if (count($rs_data) > 0) {
			$template_id = $rs_data[0]['template_id'];
			$language = $rs_data[0]['language'];
			$sms_text = $rs_data[0]['sms_text'];
			$sms_text_system = $rs_data[0]['sms_text_system'];
			$sms_message[] = array("template_id" => $template_id, "language" => $language, "sms_text" => $sms_text, "sms_text_system" => $sms_text_system);
		} else {
			$sms_message = array();
		}
		return $sms_message;
	}
	function get_sms_balance()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://control.msg91.com/api/balance.php?authkey=368534AnUMuT68h4J6167e05cP1&type=4",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));
		$response = mdrc_curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		} else {
		}
		return $response;
	}
	function send_sms($mb, $message_text)
	{
		return "";
	}
	//New Function Template Id and Language
	function send_sms_new21($mb, $message_text, $template_id, $language)
	{
		return "";
	}
	function send_email_data($mail_data)
	{
		return "";
	}
	//New Function
	function send_sms_new($mb, $sms_type, $default_string, $new_string)
	{
		$obj_model_tabel = $this->app->load_model("sms_data");
		$rs_data = $obj_model_tabel->execute("SELECT", false, "", "name='" . $sms_type . "' and status='Active'");
		if (count($rs_data) > 0) {
			$template_id = $rs_data[0]['template_id'];
			$sms_text = $rs_data[0]['sms_text'];
			$message_text = str_replace($default_string, $new_string, $sms_text);
			if ($mb != '9510069163' && $mb != '1234567890') {
				$username = 'mdrcindia.com';
				$password = '78917494';
				$Header_Name = 'MDRCPL';
				$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $username . "&password=" . $password . "&source=" . $Header_Name . "&dmobile=91" . $mb . "&dlttempid=" . $template_id . "&message=" . $message_text);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$data = mdrc_curl_exec($ch);
			}
			$total_phone = count(explode(',', $mb));
			$update_field = array();
			$update_field['phones'] = $mb;
			$update_field['sms_count'] = $total_phone;
			$update_field['sms_text'] = $message_text;
			$update_field['sms_msg_id'] = $output;
			$update_field['sms_status'] = $sms_status;
			$update_field['entry_date'] = date('d-m-Y');
			$update_field['entry_date_time'] = date('d-m-Y H:i:s');
			$obj_model_sms_history = $this->app->load_model("sms_history");
			$obj_model_sms_history->map_fields($update_field);
			$obj_model_sms_history->execute("INSERT");
		}
	}
	function get_first_product_percentage($product_id, $pro_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		if ($rs_price[0]['mrp'] != '' && $rs_price[0]['mrp'] != $rs_price[0]['price'] && $rs_price[0]['mrp'] > $rs_price[0]['price']) {
			$dis_price = $rs_price[0]['mrp'] - $rs_price[0]['price'];
			$dis = (($dis_price) * 100) / $rs_price[0]['mrp'];
			$per_html = '<span class="product-discount" id="price_discount_' . $product_id . '">' . (int)$dis . '% OFF</span>';
		} else {
			$per_html = '<span class="product-discount" id="price_discount_' . $product_id . '"></span>';
		}
		return $per_html;
	}
	function get_select_weight_price($product_id, $pro_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$price = 'Rs.' . (int) $rs_price[0]['price'];
		if (count($rs_price) > 0) {
			if (count($rs_price) == 1) {
				$price_id = $rs_price[0]['id'];
				$weight = (int) $rs_price[0]['weight'];
				if ($rs_price[0]['mrp'] != 0 && $rs_price[0]['mrp'] > $rs_price[0]['price']) {
					$price_drop .= '<div id="mrp_' . $product_id . '" class="mrp_product m-height-30">Rs.<del><span>' . $rs_price[0]['mrp'] . '</span></del></div>';
				} else {
					$price_drop .= '<div id="mrp_' . $product_id . '" class="mrp_product m-height-30"></div>';
				}
				if ($pro_unit == 'in_gm') {
					$price_drop .= '<div class="m_bottom_10 m-price-multi">' . $this->change_weight_display_2018($weight, $pro_unit) . ' - ' . $price . ' <input type="hidden" name="product_name" id="product_price_detail_id_' . $product_id . '" value="' . $price_id . '"/></div>';
				} else if ($pro_unit == 'in_ltr') {
					$price_drop .= '<div class="m_bottom_10 m-price-multi">' . $this->change_weight_display_2018($weight, $pro_unit) . ' - ' . $price . ' <input type="hidden" name="product_name" id="product_price_detail_id_' . $product_id . '" value="' . $price_id . '"/></div>';
				} else if ($pro_unit == 'in_pkt') {
					$price_drop .= '<div class="m_bottom_10 m-price-multi">' . $weight . ' Pkt - ' . $price . ' <input type="hidden" name="product_name" id="product_price_detail_id_' . $product_id . '" value="' . $price_id . '"/></div>';
				} else {
					$price_drop .= '<div class="m_bottom_10 m-price-multi">' . $weight . ' Pcs - ' . $price . ' <input type="hidden" name="product_name" id="product_price_detail_id_' . $product_id . '" value="' . $price_id . '"/></div>';
				}
			} else {
				$weight = (int) $rs_price[0]['weight'];
				if ($this->app->getCurrentView() == 'home') {
					$width = 'width: 98%;';
				} elseif ($this->app->getCurrentView() == 'product_detail') {
					$width = 'width: 84%;';
				} elseif ($this->app->getCurrentView() == 'search_results') {
					$width = 'width: 84%;';
				}
				if ($rs_price[0]['mrp'] != 0 && $rs_price[0]['mrp'] > $rs_price[0]['price']) {
					$price_drop .= '<div id="mrp_' . $product_id . '" class="mrp_product m-height-30">Rs.<del><span>' . $rs_price[0]['mrp'] . '</span></del></div>';
				} else {
					$price_drop .= '<div id="mrp_' . $product_id . '" class="mrp_product m-height-30"></div>';
				}
				$price_drop .= '<select class="m-price-drop" name="product_name" onchange="changemrp(this,' . $product_id . ')" id="product_price_detail_id_' . $product_id . '" style="border: 1px solid #ddd; padding: 3px; ' . $width . ' margin-top: 5px; margin-bottom: 10px; font-size: 14px;" >';
				if ($pro_unit == 'in_gm') {
					for ($j = 0; $j < count($rs_price); $j++) {
						$mrp = $rs_price[$j]['mrp'];
						$price = $rs_price[$j]['price'];
						if ($mrp > $price && $mrp != 0) {
							$mrp1 = $mrp;
							$dis_price = $mrp - $price;
							$dis1 = (($dis_price) * 100) / $mrp;
							$dis1 = (int)$dis1;
						} else {
							$mrp1 = 0;
							$dis1 = 0;
						}
						$price_drop .= '<option value="' . $rs_price[$j]['id'] . '" data-mrp="' . $mrp1 . '" data-discount="' . $dis1 . '">' . $this->change_weight_display_other_2018($rs_price[$j]['weight'], $pro_unit) . ' - Rs.' . $rs_price[$j]['price'] . '</option>';
					}
				} else if ($pro_unit == 'in_ltr') {
					for ($j = 0; $j < count($rs_price); $j++) {
						$mrp = $rs_price[$j]['mrp'];
						$price = $rs_price[$j]['price'];
						if ($mrp > $price && $mrp != 0) {
							$mrp1 = $mrp;
							$dis_price = $mrp - $price;
							$dis1 = (($dis_price) * 100) / $mrp;
							$dis1 = (int)$dis1;
						} else {
							$mrp1 = 0;
							$dis1 = 0;
						}
						$price_drop .= '<option value="' . $rs_price[$j]['id'] . '" data-mrp="' . $mrp1 . '" data-discount="' . $dis1 . '">' . $this->change_weight_display_other_2018($rs_price[$j]['weight'], $pro_unit) . ' - Rs.' . $rs_price[$j]['price'] . '</option>';
					}
				} else if ($pro_unit == 'in_pkt') {
					for ($j = 0; $j < count($rs_price); $j++) {
						$mrp = $rs_price[$j]['mrp'];
						$price = $rs_price[$j]['price'];
						if ($mrp > $price && $mrp != 0) {
							$mrp1 = $mrp;
							$dis_price = $mrp - $price;
							$dis1 = (($dis_price) * 100) / $mrp;
							$dis1 = (int)$dis1;
						} else {
							$mrp1 = 0;
							$dis1 = 0;
						}
						$price_drop .= '<option value="' . $rs_price[$j]['id'] . '" data-mrp="' . $mrp1 . '" data-discount="' . $dis1 . '">' . round($rs_price[$j]['weight']) . ' Pkt - Rs.' . (int) $rs_price[$j]['price'] . '</option>';
					}
				} else {
					for ($j = 0; $j < count($rs_price); $j++) {
						$mrp = $rs_price[$j]['mrp'];
						$price = $rs_price[$j]['price'];
						if ($mrp > $price && $mrp != 0) {
							$mrp1 = $mrp;
							$dis_price = $mrp - $price;
							$dis1 = (($dis_price) * 100) / $mrp;
							$dis1 = (int)$dis1;
						} else {
							$mrp1 = 0;
							$dis1 = 0;
						}
						$price_drop .= '<option value="' . $rs_price[$j]['id'] . '" data-mrp="' . $mrp1 . '" data-discount="' . $dis1 . '">' . round($rs_price[$j]['weight']) . ' Pcs - Rs.' . (int) $rs_price[$j]['price'] . '</option>';
					}
				}
				//$price_drop.='</select></div>';
				$price_drop .= '</select>';
			}
		}
		return $price_drop;
	}
	function generate_OTP($length)
	{
		$chars = '1234567890';
		$chars_length = (strlen($chars) - 1);
		$string = $chars[rand(0, $chars_length)];
		for ($i = 1; $i < $length; $i = strlen($string)) {
			$r = $chars[rand(0, $chars_length)];
			if ($r != $string[$i - 1]) $string .= $r;
		}
		return $string;
	}
	function total_order_user($user_id)
	{
		$obj_model_order_master = $this->app->load_model("order_master");
		$rs_om = $obj_model_order_master->execute("SELECT", false, "", "user_id=" . $user_id . "");
		return count($rs_om);
	}
	function total_user_refer($refer_code)
	{
		$obj_model_user = $this->app->load_model("user");
		$rs_user = $obj_model_user->execute("SELECT", false, "", "referral_from='" . $refer_code . "'");
		return count($rs_user);
	}
	function total_user_referral_from($referral_from)
	{
		$obj_model_user = $this->app->load_model("user");
		$rs_user = $obj_model_user->execute("SELECT", false, "", "ref_key='" . $referral_from . "'");
		if (count($rs_user) > 0) {
			return $rs_user[0];
		} else {
			return '-';
		}
	}
	function get_order_count($referral_from)
	{
		if ($referral_from != '') {
			$obj_model_user = $this->app->load_model("user");
			$rs_user = $obj_model_user->execute("SELECT", false, "", "referral_from='" . $referral_from . "'");
			if (count($rs_user) > 0) {
				$obj_model_order_master = $this->app->load_model("order_master");
				$rs_om = $obj_model_order_master->execute("SELECT", false, "", "user_id=" . $rs_user[0]['id'] . "");
				if (count($rs_om) <= 0) {
					$beni = 'Yes';
				} else {
					$beni = 'No';
				}
			}
		} else {
			$beni = 'No';
		}
		return $beni;
	}
	function get_used_area($area)
	{
		$obj_model_user = $this->app->load_model("user");
		$rs_user = $obj_model_user->execute("SELECT", false, "", "area_name='" . $area . "'");
		if (count($rs_user) > 0) {
			$tag = 'Used';
		} else {
			$tag = '';
		}
		return $tag;
	}
	function get_used_zone($id)
	{
		$obj_model_user = $this->app->load_model("area");
		$rs_user = $obj_model_user->execute("SELECT", false, "", "zone_id='" . $id . "'");
		if (count($rs_user) > 0) {
			$tag = 'Used';
		} else {
			$tag = '';
		}
		return $tag;
	}
	function sum_extra_price($order_id)
	{
		$obj_model_order_detail = $this->app->load_model("order_detail");
		$rs_order_detail = $obj_model_order_detail->execute("SELECT", false, "SELECT SUM(extra_price) FROM `order_detail` WHERE order_master_id=" . $order_id . "", "");
		return $rs_order_detail['extra_price'];
	}
	function get_extracharge($order_master_id)
	{
		$obj_model_order_detail = $this->app->load_model("order_detail");
		$rs_od = $obj_model_order_detail->execute("SELECT", false, "SELECT SUM(extra_price) as extra_charge FROM order_detail WHERE order_master_id=" . $order_master_id . "", "");
		return $rs_od[0]['extra_charge'];
	}
	function operator_orders($op_id)
	{
		$obj_model_orders = $this->app->load_model("order_master");
		$rs_od = $obj_model_orders->execute("SELECT", false, "", "op_id=" . $op_id . "");
		return count($rs_od);
	}
	function wallet_balance($us_id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_user = $this->app->load_model("user");
		$rs_ud = $obj_model_user->execute("SELECT", false, "", "id=" . $us_id . "");
		return $rs_ud[0]['wallet'];
	}
	function user_name($us_id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_user = $this->app->load_model("user");
		$rs_ud = $obj_model_user->execute("SELECT", false, "", "id=" . $us_id . "");
		return $rs_ud[0]['name'];
	}
	function ticket_category_name($id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_table = $this->app->load_model("ticket_category");
		$rs_ud = $obj_model_table->execute("SELECT", false, "", "id=" . $id . "");
		return $rs_ud[0]['name'];
	}
	function total_calls($us_id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_calls = $this->app->load_model("calls");
		$rs = $obj_model_calls->execute("SELECT", false, "", "crmuser_id=" . $us_id . "");
		return count($rs);
	}
	function total_orders($us_id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_order_master = $this->app->load_model("order_master");
		$rs = $obj_model_order_master->execute("SELECT", false, "", "op_id=" . $us_id . "");
		return count($rs);
	}
	function get_crm_membername($id)
	{
		//echo 'mehul'.$us_id; exit;
		$obj_model_user = $this->app->load_model("crm_user");
		$rs_ud = $obj_model_user->execute("SELECT", false, "", "id=" . $id . "");
		return $rs_ud[0]['name'];
	}
	function getpcmrpauto2($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "price DESC");
		$mrp = $rs_price[0]['mrp'];
		$price = $rs_price[0]['price'];
		if ($mrp == 0 || $mrp <= $price) {
			$mrp1 = 0;
		} else {
			$mrp1 = $mrp;
		}
		//$unit_price=intval($rs_price[0]['mrp']);
		return $mrp1;
	}
	function total_group_user($user_id)
	{
		$a = explode(',', $user_id);
		$g_name = '';
		for ($i = 0; $i < count($a); $i++) {
			$obj_model_table = $this->app->load_model("user_group");
			$rs_table = $obj_model_table->execute("SELECT", false, "", "id='" . $a[$i] . "'");
			if ($i == (count($a) - 1)) {
				$g_name .= $rs_table[0]['name'];
			} else {
				$g_name .= $rs_table[0]['name'] . ', ';
			}
		}
		return $g_name;
	}
	function getkgmrp1($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1000");
		if (count($rs_price) > 0) {
			$unit_mrp = intval($rs_price[0]['mrp']);
			$unit_price = intval($rs_price[0]['price']);
		} else {
			//$rs_min_price = $obj_model_product_price->execute("SELECT", false, "SELECT MIN(mrp) as min_price FROM product_price WHERE product_id=".$product_id."", "product_id=".$product_id."","price desc");
			$rs_min_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "price ASC");
			$unit_mrp = intval($rs_min_price[0]['mrp']);
			$unit_price = intval($rs_min_price[0]['price']);
		}
		if ($unit_mrp == 0 || $unit_mrp <= $unit_price) {
			$mrp1 = 0;
		} else {
			$mrp1 = $unit_mrp;
		}
		//$unit_price=intval($rs_price[0]['mrp']);
		return $mrp1;
		return $unit_mrp;
	}
	function get_user_tokens()
	{
		$obj_model_cust = $this->app->load_model("user");
		$rs_gcm = $obj_model_cust->execute("SELECT", false, "", "Token!=''", "", "Token");
		$registation_ids = array();
		for ($i = 0; $i < count($rs_gcm); $i++) {
			array_push($registation_ids, $rs_gcm[$i]['Token']);
		}
		return $registation_ids;
	}
	function add_push_notification_gcm($data, $from)
	{
		// Android App
		$obj_model_table = $this->app->load_model("generel_settings");
		$rs_data = $obj_model_table->execute("SELECT", false, "", "");
		$google_key = $rs_data[0]['google_key'];
		$test_cond = "";
		$obj_model_cust = $this->app->load_model("customer_token");
		$rs_gcm = $obj_model_cust->execute("SELECT", false, "", "fcm_token!='' " . $test_cond . "", "", "fcm_token");
		$count = count($rs_gcm);
		$total_rep = $count / 1000;
		$a = 0;
		$total_rep = (int)$total_rep + 1;
		for ($i = 0; $i < $total_rep; $i++) {
			$obj_model_user = $this->app->load_model("customer_token");
			$rs_user = $obj_model_user->execute("SELECT", false, "", "fcm_token!='' " . $test_cond . "", "id ASC limit " . $a . ",1000");
			$to = '';
			if (count($rs_user) > 0) {
				$to = array();
				foreach ($rs_user as $item) {
					$this->send_push_notifaction($data,$item['fcm_token']);
				}
			}
			// $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
			// $fields = array(
			// 	'registration_ids' => $to,
			// 	'data' => $data
			// );
			// if (!defined('SERVER_KEY')) {
			// 	define("SERVER_KEY", $google_key);
			// }
			// $headers = array(
			// 	'Authorization:key=' . SERVER_KEY,
			// 	'Content-Type:application/json'
			// );
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
			// curl_setopt($ch, CURLOPT_POST, true);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			// $result = mdrc_curl_exec($ch);
			// curl_close($ch);
			$a = $a + 1000;
		}
	}
	//ss
	//for api
	function indent($json)
	{
		$result      = '';
		$pos         = 0;
		$strLen      = strlen($json);
		$indentStr   = '  ';
		$newLine     = "\n";
		$prevChar    = '';
		$outOfQuotes = true;
		for ($i = 0; $i <= $strLen; $i++) {
			// Grab the next character in the string.
			$char = substr($json, $i, 1);
			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;
				// If this character is the end of an element,
				// output a new line and indent the next line.
			} else if (($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos--;
				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}
			// Add the character to the result string.
			$result .= $char;
			// If the last character was the beginning of an element,
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos++;
				}
				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}
			$prevChar = $char;
		}
		return $result;
	}
	function encrypt($data)
	{
		return base64_encode($data);
	}
	function decrypt($data)
	{
		$value = base64_decode($data);
		return $value;
	}
	//function for app to get price of product
	function get_app_price_data($p_id, $p_option_final, $user_id)
	{
		if ($p_option_final == 'in_pcs') {
			$p_option = 'Pcs';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
						if ($dis == 0) {
							$dis = '';
						}
					} else {
						$dis = '';
						$mrp = '';
					}
					$P_ID = $this->encrypt($price_id);
					$cart_qty = $this->check_product_in_cart($price_id, $user_id);
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($dis > 0) {
						$dis = (int)$dis;
					}
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight . ' ' . $p_option, "dis" => (string)$dis, "cart_qty" => $cart_qty, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$price_list[] = array("sr" => "", "price_ID" => "", "price" => "", "mrp" => "", "weight" => "", "dis" => "", "cart_qty" => "", "max_qty" => "");
			}
		} else if ($p_option_final == 'in_pkt') {
			$p_option = 'Pkt';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
						if ($dis == 0) {
							$dis = '';
						}
					} else {
						$dis = '';
						$mrp = '';
					}
					$P_ID = $this->encrypt($price_id);
					$cart_qty = $this->check_product_in_cart($price_id, $user_id);
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($dis > 0) {
						$dis = (int)$dis;
					}
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight . ' ' . $p_option, "dis" => (string)$dis, "cart_qty" => $cart_qty, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$price_list[] = array("sr" => "", "price_ID" => "", "price" => "", "mrp" => "", "weight" => "", "dis" => "", "cart_qty" => "", "max_qty" => "");
			}
		} else if ($p_option_final == 'in_gm') {
			$p_option = 'gm';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$final_weight = $this->change_weight_display_2018($weight, $p_option_final);
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
						if ($dis == 0) {
							$dis = '';
						}
					} else {
						$dis = '';
						$mrp = '';
					}
					$P_ID = $this->encrypt($price_id);
					$cart_qty = $this->check_product_in_cart($price_id, $user_id);
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($dis > 0) {
						$dis = (int)$dis;
					}
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $final_weight, "dis" => (string)$dis, "cart_qty" => $cart_qty, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$price_list[] = array("sr" => "", "price_ID" => "", "price" => "", "mrp" => "", "weight" => "", "dis" => "", "cart_qty" => "", "max_qty" => "");
			}
		} else if ($p_option_final == 'in_ltr') {
			$p_option = 'ml';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$final_weight = $this->change_weight_display_2018($weight, $p_option_final);
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
						if ($dis == 0) {
							$dis = '';
						}
					} else {
						$dis = '';
						$mrp = '';
					}
					$P_ID = $this->encrypt($price_id);
					$cart_qty = $this->check_product_in_cart($price_id, $user_id);
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($dis > 0) {
						$dis = (int)$dis;
					}
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $final_weight, "dis" => (string)$dis, "cart_qty" => $cart_qty, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$price_list[] = array("sr" => "", "price_ID" => "", "price" => "", "mrp" => "", "weight" => "", "dis" => "", "cart_qty" => "", "max_qty" => '');
			}
		}
		return $price_list;
	}
	function get_app_price_data_old($p_id, $p_option_final)
	{
		if ($p_option_final == 'in_pcs') {
			$p_option = 'Pcs';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
					} else {
						$dis = 0;
					}
					$P_ID = $this->encrypt($price_id);
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight . ' ' . $p_option, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$i = 1;
				$price_id = '0';
				$price = '0';
				$mrp = '0';
				$weight = '0';
				$max_qty = 0;
				if ($mrp > $price) {
					$dis = (($mrp - $price) * 100) / $mrp;
				} else {
					$dis = 0;
				}
				$P_ID = $this->encrypt($price_id);
				$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
			}
		} else if ($p_option_final == 'in_pkt') {
			$p_option = 'Pkt';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
					} else {
						$dis = 0;
					}
					$P_ID = $this->encrypt($price_id);
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight . ' ' . $p_option, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$i = 1;
				$price_id = '0';
				$price = '0';
				$mrp = '0';
				$weight = '0';
				$max_qty = 0;
				if ($mrp > $price) {
					$dis = (($mrp - $price) * 100) / $mrp;
				} else {
					$dis = 0;
				}
				$P_ID = $this->encrypt($price_id);
				$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
			}
		} else if ($p_option_final == 'in_gm') {
			$p_option = 'gm';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					$final_weight = $this->change_weight_display_2018($weight, $p_option_final);
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
					} else {
						$dis = 0;
					}
					$P_ID = $this->encrypt($price_id);
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $final_weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$i = 1;
				$price_id = '0';
				$price = '0';
				$mrp = '0';
				$weight = '0';
				$max_qty = 0;
				if ($mrp > $price) {
					$dis = (($mrp - $price) * 100) / $mrp;
				} else {
					$dis = 0;
				}
				$P_ID = $this->encrypt($price_id);
				$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
			}
		} else if ($p_option_final == 'in_ltr') {
			$p_option = 'ml';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			if (count($rs_data) > 0) {
				$i = 1;
				foreach ($rs_data as $item) {
					$price_id = $item['id'];
					$price = $item['price'];
					$mrp = $item['mrp'];
					$weight = (int)$item['weight'];
					$max_qty = (int)$item['max_quantity'];
					if ($max_qty == 0) {
						$max_qty = 1000;
					}
					$final_weight = $this->change_weight_display_2018($weight, $p_option_final);
					if ($mrp > $price) {
						$dis = (($mrp - $price) * 100) / $mrp;
					} else {
						$dis = 0;
					}
					$P_ID = $this->encrypt($price_id);
					$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $final_weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
					$i++;
				}
			} else {
				$i = 1;
				$price_id = 0;
				$price = '0';
				$mrp = '0';
				$weight = '0';
				$max_qty = '0';
				if ($mrp > $price) {
					$dis = (($mrp - $price) * 100) / $mrp;
				} else {
					$dis = 0;
				}
				$P_ID = $this->encrypt($price_id);
				$price_list[] = array("sr" => (string)$i, "price_ID" => $P_ID, "price" => $price, "mrp" => $mrp, "weight" => $weight, "dis" => (string)(int)$dis, "max_qty" => (string)(int)$max_qty);
			}
		}
		return $price_list;
	}
	function get_app_price_single($p_id, $p_option)
	{
		if ($p_option == 'in_pcs') {
			$p_option = 'Pcs';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			$price = $rs_data[0]['price'];
			$mrp = $rs_data[0]['mrp'];
			$weight = $rs_data[0]['weight'];
			$max_qty = $rs_data[0]['max_quantity'];
			if ($mrp > $price) {
				$dis = (($mrp - $price) * 100) / $mrp;
			} else {
				$dis = 0;
			}
		} else if ($p_option == 'in_pkt') {
			$p_option = 'Pkt';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			$price = $rs_data[0]['price'];
			$mrp = $rs_data[0]['mrp'];
			$weight = $rs_data[0]['weight'];
			$max_qty = $rs_data[0]['max_quantity'];
			if ($mrp > $price) {
				$dis = (($mrp - $price) * 100) / $mrp;
			} else {
				$dis = 0;
			}
		} else if ($p_option == 'in_ltr') {
			$p_option = 'ml';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			$price = $rs_data[0]['price'];
			$mrp = $rs_data[0]['mrp'];
			$weight = $rs_data[0]['weight'];
			$max_qty = $rs_data[0]['max_quantity'];
			if ($mrp > $price) {
				$dis = (($mrp - $price) * 100) / $mrp;
			} else {
				$dis = 0;
			}
		} else {
			$p_option = 'gm';
			$obj_model_table = $this->app->load_model("product_price");
			$rs_data = $obj_model_table->execute("SELECT", false, "", "product_id=" . $p_id . "", "weight ASC");
			$price = $rs_data[0]['price'];
			$mrp = $rs_data[0]['mrp'];
			$weight = $rs_data[0]['weight'];
			$max_qty = $rs_data[0]['max_quantity'];
			if ($mrp > $price) {
				$dis = (($mrp - $price) * 100) / $mrp;
			} else {
				$dis = 0;
			}
		}
		if ($mrp == NULL) {
			$mrp = '0';
		}
		if ($price == NULL) {
			$price = '0';
		}
		$f_discount = (int)$dis;
		if ($f_discount <= 0) {
			$f_discount = '';
		}
		$data['mrp'] = $mrp;
		$data['dis'] = $f_discount;
		$data['price'] = $price;
		$data['weight'] = $weight;
		$data['p_option'] = $p_option;
		$data['max_qty'] = $max_qty;
		return $data;
	}
	//ss
	function getpcmrp_update($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id='" . $product_id . "'");
		$unit_price = intval($rs_price[0]['mrp']) / $rs_price[0]['weight'];
		return $unit_price;
	}
	function get_order_extraprice($oid)
	{
		$extra_price = 0;
		$obj_model_table = $this->app->load_model("order_detail");
		$rs_data = $obj_model_table->execute("SELECT", false, "", "order_master_id=" . $oid . "");
		if (count($rs_data) > 0) {
			for ($i = 0; $i < count($rs_data); $i++) {
				$extra_price = $extra_price + $rs_data[$i]['extra_price'];
			}
		} else {
			$extra_price = 0;
		}
		return $extra_price;
	}
	function web_mail_header()
	{
		$obj_model_table = $this->app->load_model("generel_settings");
		$rs_data = $obj_model_table->execute("SELECT", false, "", "");
		$title = $rs_data[0]['project_title'];
		$website = $rs_data[0]['website'];
		$logo = $rs_data[0]['logo'];
		$logourl = SERVER_ROOT . '/uploads/project_image/' . $logo;
		$html = '<!doctype html>
			<html lang="en">
			<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="x-apple-disable-message-reformatting">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>MDRS</title>
			<style>
			.o_sans,
			.o_heading {
			font-family: Helvetica, Arial, sans-serif; }
			.o_heading {
			font-weight: bold; }
			.o_sans,
			.o_heading,
			.o_sans p,
			.o_sans li {
			margin-top: 0px;
			margin-bottom: 0px; }
			a {
			text-decoration: none;
			outline: none; }
			.o_underline {
			text-decoration: underline; }
			.o_linethrough {
			text-decoration: line-through; }
			.o_nowrap {
			white-space: nowrap; }
			.o_caps {
			text-transform: uppercase;
			letter-spacing: 1px; }
			.o_nowrap {
			white-space: nowrap; }
			.o_text-xxs {
			font-size: 12px;
			line-height: 19px; }
			.o_text-xs {
			font-size: 14px;
			line-height: 21px; }
			.o_text {
			font-size: 16px;
			line-height: 24px; }
			.o_text-md {
			font-size: 19px;
			line-height: 28px; }
			.o_text-lg {
			font-size: 24px;
			line-height: 30px; }
			h1.o_heading {
			font-size: 36px;
			line-height: 47px; }
			h2.o_heading {
			font-size: 30px;
			line-height: 39px; }
			h3.o_heading {
			font-size: 24px;
			line-height: 31px; }
			h4.o_heading {
			font-size: 18px;
			line-height: 23px; }
			body,
			.e_body {
			width: 100%;
			margin: 0px;
			padding: 0px;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%; }
			.o_re {
			font-size: 0;
			vertical-align: top; }
			.o_block {
			max-width: 632px;
			margin: 0 auto; }
			.o_block-lg {
			max-width: 800px;
			margin: 0 auto; }
			.o_block-xs {
			max-width: 432px;
			margin: 0 auto; }
			.o_col,
			.o_col_i {
			display: inline-block;
			vertical-align: top; }
			.o_col {
			width: 100%; }
			.o_col-1 {
			max-width: 100px; }
			.o_col-o {
			max-width: 132px; }
			.o_col-2 {
			max-width: 200px; }
			.o_col-3 {
			max-width: 300px; }
			.o_col-4 {
			max-width: 400px; }
			.o_col-oo {
			max-width: 468px; }
			.o_col-5 {
			max-width: 500px; }
			.o_col-6s {
			max-width: 584px; }
			.o_col-6 {
			max-width: 600px; }
			img {
			-ms-interpolation-mode: bicubic;
			vertical-align: middle;
			border: 0;
			line-height: 100%;
			height: auto;
			outline: none;
			text-decoration: none; }
			.o_img-full {
			width: 100%; }
			.o_inline {
			display: inline-block; }
			.o_btn {
			mso-padding-alt: 12px 24px; }
			.o_btn a {
				display: block;
				padding: 12px 24px;
				mso-text-raise: 3px; }
			.o_btn-o {
			mso-padding-alt: 8px 20px; }
			.o_btn-o a {
				display: block;
				padding: 8px 20px;
				mso-text-raise: 3px; }
			.o_btn-xs {
			mso-padding-alt: 7px 16px; }
			.o_btn-xs a {
				display: block;
				padding: 7px 16px;
				mso-text-raise: 3px; }
			.o_btn-b {
			mso-padding-alt: 7px 8px; }
			.o_btn-b a {
				display: block;
				padding: 7px 8px;
				font-weight: bold; }
			.o_btn-b span {
				mso-text-raise: 6px;
				display: inline; }
			.img_fix {
			mso-text-raise: 6px;
			display: inline; }
			.o_bg-light {
			background-color: #dbe5ea; }
			.o_bg-ultra_light {
			background-color: #ebf5fa; }
			.o_bg-white {
			background-color: #ffffff; }
			.o_bg-dark {
			background-color: #242b3d; }
			.o_bg-primary {
			background-color: #0c2f54; }
			.o_bg-secondary {
			background-color: #424651; }
			.o_bg-success {
			background-color: #0ec06e; }
			.o_text-primary,
			a.o_text-primary span,
			a.o_text-primary strong,
			.o_text-primary.o_link a {
			color: #0c2f54; }
			.o_text-secondary,
			a.o_text-secondary span,
			a.o_text-secondary strong,
			.o_text-secondary.o_link a {
			color: #424651; }
			.o_text-dark,
			a.o_text-dark span,
			a.o_text-dark strong,
			.o_text-dark.o_link a {
			color: #242b3d; }
			.o_text-dark_light,
			a.o_text-dark_light span,
			a.o_text-dark_light strong,
			.o_text-dark_light.o_link a {
			color: #a0a3ab; }
			.o_text-white,
			a.o_text-white span,
			a.o_text-white strong,
			.o_text-white.o_link a {
			color: #ffffff; }
			.o_text-light,
			a.o_text-light span,
			a.o_text-light strong,
			.o_text-light.o_link a {
			color: #000; }
			.o_text-success,
			a.o_text-success span,
			a.o_text-success strong,
			.o_text-success.o_link a {
			color: #0ec06e; }
			.o_b-primary {
			border: 2px solid #126de5; }
			.o_bb-primary {
			border-bottom: 1px solid #126de5; }
			.o_b-secondary {
			border: 2px solid #424651; }
			.o_bx-secondary {
			border: 1px solid #424651; }
			.o_bb-secondary {
			border-bottom: 1px solid #424651; }
			.o_b-dark {
			border: 2px solid #242b3d; }
			.o_b-light {
			border: 1px solid #d3dce0; }
			.o_bb-light {
			border-bottom: 1px solid #d3dce0; }
			.o_bt-light {
			border-top: 1px solid #d3dce0; }
			.o_br-light {
			border-right: 4px solid #d3dce0; }
			.o_bb-ultra_light {
			border-bottom: 1px solid #b6c0c7; }
			.o_bb-dark_light {
			border-bottom: 1px solid #4a5267; }
			.o_bt-dark_light {
			border-top: 1px solid #4a5267; }
			.o_b-white {
			border: 2px solid #ffffff; }
			.o_bb-white {
			border-bottom: 1px solid #ffffff; }
			.o_br {
			border-radius: 4px; }
			.o_br-t {
			border-radius: 4px 4px 0px 0px; }
			.o_br-b {
			border-radius: 0px 0px 4px 4px; }
			.o_br-l {
			border-radius: 4px 0px 0px 4px; }
			.o_br-r {
			border-radius: 0px 4px 4px 0px; }
			.o_br-max {
			border-radius: 96px; }
			.o_hide,
			.o_hide-lg {
			display: none;
			font-size: 0;
			max-height: 0;
			width: 0;
			line-height: 0;
			overflow: hidden;
			mso-hide: all;
			visibility: hidden; }
			.o_center {
			text-align: center; }
			table.o_center {
			margin-left: auto;
			margin-right: auto; }
			.o_left {
			text-align: left; }
			table.o_left {
			margin-left: 0;
			margin-right: auto; }
			.o_right {
			text-align: right; }
			table.o_right {
			margin-left: auto;
			margin-right: 0; }
			.o_px {
			padding-left: 16px;
			padding-right: 16px; }
			.o_px-xs {
			padding-left: 8px;
			padding-right: 8px; }
			.o_px-md {
			padding-left: 24px;
			padding-right: 24px; }
			.o_px-lg {
			padding-left: 32px;
			padding-right: 32px; }
			.o_py {
			padding-top: 16px;
			padding-bottom: 16px; }
			.o_py-xs {
			padding-top: 8px;
			padding-bottom: 8px; }
			.o_py-md {
			padding-top: 24px;
			padding-bottom: 24px; }
			.o_py-lg {
			padding-top: 32px;
			padding-bottom: 32px; }
			.o_py-xl {
			padding-top: 2px;
			padding-bottom: 2px; }
			.o_pt-xs {
			padding-top: 8px; }
			.o_pt {
			padding-top: 16px; }
			.o_pt-md {
			padding-top: 24px; }
			.o_pt-lg {
			padding-top: 32px; }
			.o_pb-xs {
			padding-bottom: 8px; }
			.o_pb {
			padding-bottom: 16px; }
			.o_pb-md {
			padding-bottom: 24px; }
			.o_pb-lg {
			padding-bottom: 15px; }
			.o_p-icon {
			padding: 12px; }
			.o_body .o_mb-xxs {
			margin-bottom: 4px; }
			.o_body .o_mb-xs {
			margin-bottom: 8px; }
			.o_body .o_mb {
			margin-bottom: 5px; }
			.o_body .o_mb-md {
			margin-bottom: 24px; }
			.o_body .o_mb-lg {
			margin-bottom: 32px; }
			.o_body .o_mt {
			margin-top: 16px; }
			.o_body .o_mt-md {
			margin-top: 24px; }
			.o_bg-center {
			background-position: 50% 0;
			background-repeat: no-repeat; }
			.o_bg-left {
			background-position: 0 0;
			background-repeat: no-repeat; }
			@media (max-width: 449px) {
			.o_col-full {
				max-width: 100% !important; }
			.o_col-half {
				max-width: 50% !important; }
			.o_hide-lg {
				display: inline-block !important;
				font-size: inherit !important;
				max-height: none !important;
				line-height: inherit !important;
				overflow: visible !important;
				width: auto !important;
				visibility: visible !important; }
			.o_hide-xs,
			.o_hide-xs.o_col_i {
				display: none !important;
				font-size: 0 !important;
				max-height: 0 !important;
				width: 0 !important;
				line-height: 0 !important;
				overflow: hidden !important;
				visibility: hidden !important;
				height: 0 !important; }
			.o_xs-center {
				text-align: center !important; }
			.o_xs-left {
				text-align: left !important; }
			.o_xs-right {
				text-align: left !important; }
			table.o_xs-left {
				margin-left: 0 !important;
				margin-right: auto !important;
				float: none !important; }
			table.o_xs-right {
				margin-left: auto !important;
				margin-right: 0 !important;
				float: none !important; }
			table.o_xs-center {
				margin-left: auto !important;
				margin-right: auto !important;
				float: none !important; }
			h1.o_heading {
				font-size: 32px !important;
				line-height: 41px !important; }
			h2.o_heading {
				font-size: 26px !important;
				line-height: 37px !important; }
			h3.o_heading {
				font-size: 20px !important;
				line-height: 30px !important; }
			.o_xs-py-md {
				padding-top: 24px !important;
				padding-bottom: 24px !important; }
			.o_xs-pt-xs {
				padding-top: 8px !important; }
			.o_xs-pb-xs {
				padding-bottom: 8px !important; } }
			@media screen {
			@font-face {
				font-family: \'Roboto\';
				font-style: normal;
				font-weight: 400;
				src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format("woff2");
				unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
			@font-face {
				font-family: \'Roboto\';
				font-style: normal;
				font-weight: 400;
				src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4mxK.woff2) format("woff2");
				unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
			@font-face {
				font-family: \'Roboto\';
				font-style: normal;
				font-weight: 700;
				src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfChc4EsA.woff2) format("woff2");
				unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
			@font-face {
				font-family: \'Roboto\';
				font-style: normal;
				font-weight: 700;
				src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfBBc4.woff2) format("woff2");
				unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
			.o_sans,
			.o_heading {
				font-family: "Roboto", sans-serif !important; }
			.o_heading,
			strong,
			b {
				font-weight: 700 !important; }
			a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: none !important; } }
			</style>
			</head>
			<body class="o_body o_bg-white">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
			<tbody>
				<tr>
				<td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center">
					<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
					<tbody>
						<tr>
						<td class="o_bg-white o_px o_py-md o_br-t o_sans o_text" align="center"><p><a class="o_text-primary" href="' . SERVER_ROOT . '"><img src="' . SERVER_ROOT . '/mail_templates/images/logo.png" width="136" height="36" alt="MDRC" style="max-width: 136px;"></a></p></td>
						</tr>
					</tbody>
					</table>
				</td>
				</tr>
			</tbody>
			</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
				<tbody>
					<tr>
					<td class="o_bg-light o_px-xs" align="center">
						<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
						<tbody>
							<tr>
							<td class="o_bg-primary o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-white" align="center">
							</td>
							</tr>
						</tbody>
						</table>
					</td>
					</tr>
				</tbody>
				</table>';
		return $html;
	}
	function web_mail_footer()
	{
		$obj_model_table = $this->app->load_model("generel_settings");
		$rs_data = $obj_model_table->execute("SELECT", false, "", "");
		$app_url = $rs_data[0]['app_url'];
		$app_url_iphone = $rs_data[0]['app_url_iphone'];
		$support_email = $rs_data[0]['contact_email'];
		$website = $rs_data[0]['website'];
		$facebook = $rs_data[0]['facebook_link'];
		$twitter = $rs_data[0]['twitter_link'];
		$linkedin = $rs_data[0]['linkedin_link'];
		$instagram = $rs_data[0]['instagram_link'];
		$logo = $rs_data[0]['logo'];
		$logourl = SERVER_ROOT . '/uploads/project_image/' . $logo;
		$html = '
			<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
			<tbody>
				<tr>
				<td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center">
					<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
					<tbody>
						<tr>
						<td class="o_re o_bg-white o_px o_pb-lg o_bt-light" align="center">
							<div class="o_col o_col-1 o_col-full">
							<div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
							<div class="o_px-xs o_sans o_text-xs o_center">
								<p></p>
							</div>
							</div>
							<div class="o_col o_col-2 o_col-full">
							<div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
							<div class="o_px-xs o_sans o_text-xs o_center">
								<p>
								<a class="o_text-light" href="' . $facebook . '"><img src="' . SERVER_ROOT . '/mail_templates/images/facebook-light.png" width="30" height="30" alt="facebook" style="max-width: 30px;"></a>
								<a class="o_text-light" href="' . $twitter . '"><img src="' . SERVER_ROOT . '/mail_templates/images/twitter-light.png" width="30" height="30" alt="twitter" style="max-width: 30px;"></a>
								<a class="o_text-light" href="' . $instagram . '"><img src="' . SERVER_ROOT . '/mail_templates/images/instagram-light.png" width="30" height="30" alt="instagram" style="max-width: 30px;"></a>
							</div>
							</div>
							<div class="o_col o_col-1 o_col-full">
							<div style="font-size: 30px; line-height: 30px; height: 30px;">&nbsp; </div>
							<div class="o_px-xs o_sans o_text-xs o_center">
								<p></p>
							</div>
							</div>
						</td>
						</tr>
						<tr>
						<td class="o_bg-white o_px-md o_pb-lg o_br-b o_sans o_text-xs o_text-light" align="center">
							<p class="o_mb-xs">2023 All right reserved. Modern Diagnostic & Research Centre Pvt. Ltd.</p></td>
						</tr>
					</tbody>
					</table>
					<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
				<tbody>
					<tr>
					<td class="o_bg-light o_px-xs" align="center">
						<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
						<tbody>
							<tr>
							<td class="o_bg-primary o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-white" align="center">
							</td>
							</tr>
						</tbody>
						</table>
					</td>
					</tr>
				</tbody>
				</table>
					<div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div></td>
				</tr>
			</tbody>
			</table>
			</body>
			</html>
			';
		return $html;
	}
	function sendMial($data = [])
	{
		/*$template_name='booking_place';
	$send_data_arary=['name'=>'Test Name','order_id'=>'#0001','order_detail'=>$order_detail];
	$to_mail='thedezineapp@gmail.com';
	$subject='Your Booking has been place';
	sendMial(['template_name'=>$template_name,'send_data_arary'=>$send_data_arary,'to_mail'=>$to_mail,'subject'=>$subject]);
	*/
		//$bcc_mail='pratikgandhi711@gmail.com';
		$template_name = $data['template_name'] . '.html';
		$send_data_arary = $data['send_data_arary'];
		$to_mail = $data['to_mail'];
		$subject = $data['subject'];
		$mail_for = $data['mail_for'];
		if ($template_name != '' && count($send_data_arary) > 0) {
			$obj_model_gs = $this->app->load_model('generel_settings');
			$re_data = $obj_model_gs->execute("SELECT", false, "", "", "");
			if ($mail_for == 'Admin') {
				$to_mail = $re_data[0]['notification_email'];
				$cc_mail = $re_data[0]['notification_email_cc'];
			}
			if ($mail_for == 'OrderCancelAdmin') {
				$to_mail = 'care@mdrcindia.com';
				$cc_mail = 'info@mdrcindia.com';
			}
			if ($mail_for == 'corporate_tieup' || $mail_for == 'subscribe_newsletter') {
				$to_mail = 'care@mdrcindia.com';
				$cc_mail = '';
			}
			if ($mail_for == 'fullBodyCheckup') {
				$to_mail = 'leadscrm@mdrcindia.com';
				$cc_mail = '';
			}
			if ($mail_for == 'test_booking_inquiry' || $mail_for == 'home_sample_collection') {
				$to_mail = 'homecollection@mdrcindia.com';
				$cc_mail = '';
			}
			$mail_title = $re_data[0]['project_title'];
			$mail_header = $this->web_mail_header();
			$mail_footer = $this->web_mail_footer();
			$url_image = SERVER_ROOT . '/mail_templates/images';
			$mail_data_array = ['header' => $mail_header, 'footer' => $mail_footer, 'url_image' => $url_image];
			$mail_send_data_array = array_merge($send_data_arary, $mail_data_array);
			$obj_mailer = $this->app->load_module("mailer\sender");
			$mail_body = $this->ParseMailTemplate($template_name, $mail_send_data_array);
			if ($mail_body == NULL) {
				$this->app->display_error(NULL, "Could not parse the mail template");
			}
			$obj_mailer->create();
			$obj_mailer->subject($subject);
			$obj_mailer->add_to($to_mail);
			if ($cc_mail != '') {
				$obj_mailer->add_cc($cc_mail);
			}
			//for paynow only
			if ($data['template_name'] == 'direct_payment_order_admin') {
				$obj_mailer->add_cc('accounts@mdrcindia.com');
				$obj_mailer->add_cc('info@mdrcindia.com');
			}
			if ($data['template_name'] == 'booking_cancel_admin') {
				$obj_mailer->add_cc('bill@mdrcindia.com');
			}
			if ($data['template_name'] == 'job_apply_to_admin') {
				$obj_mailer->add_cc('hr@mdrcindia.com');
				$obj_mailer->add_cc('nehapandey@mdrcindia.com');
				$obj_mailer->add_cc('recruiter@mdrcindia.com');
				$obj_mailer->add_cc('dr.kanikayadav24@gmail.com');
			}
			if ($bcc_mail != '') {
				$obj_mailer->add_bcc($bcc_mail);
			}
			$obj_mailer->htmlbody($mail_body);
			$flag = $obj_mailer->send();
			if ($flag) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	function getkgprice_admin($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1000");
		if (count($rs_price) > 0) {
			$unit_price = intval($rs_price[0]['price']);
		} else {
			$rs_min_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
			$weight = $rs_min_price[0]['weight'];
			$price = $rs_min_price[0]['price'];
			$new_price = (1000 * $price) / ($weight);
			$unit_price = intval($new_price);
		}
		return $unit_price;
	}
	function getkgmrp_admin($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . " and weight=1000");
		if (count($rs_price) > 0) {
			$unit_price = intval($rs_price[0]['mrp']);
		} else {
			$rs_min_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
			$weight = $rs_min_price[0]['weight'];
			$price = $rs_min_price[0]['mrp'];
			$new_mrp = (1000 * $price) / ($weight);
			$unit_price = intval($new_mrp);
		}
		return $unit_price;
	}
	function check_orders($user_id, $coupon_id)
	{
		$obj_model_table = $this->app->load_model("order_master");
		$rs_od = $obj_model_table->execute("SELECT", false, "", "user_id='" . $user_id . "' and discount_coupon_id='" . $coupon_id . "'", "id ASC");
		if (count($rs_od) > 0) {
			$status = 'Yes';
		} else {
			$status = 'No';
		}
		return $status;
	}
	function dis_html($coupon_id, $coupon_code)
	{
		if ($coupon_code != '' && $coupon_id > 0) {
			$d_html = '<br/><br/><span id="dis_data"><b>' . $coupon_code . '</b> Coupon Use.</span>';
		} else {
			$d_html = '';
		}
		return $d_html;
	}
	function dis_html_detail($coupon_id, $coupon_code)
	{
		if ($coupon_code != '' && $coupon_id > 0) {
			$d_html = ' (<span id="dis_data"><b>' . $coupon_code . '</b> Coupon Use.</span>) ';
		} else {
			$d_html = '';
		}
		return $d_html;
	}
	function express_html($express_charge)
	{
		if ($express_charge > 0) {
			$html = '<br/><span class="express">Express</span>';
		} else {
			$html = '';
		}
		return $html;
	}
	function excel_cat_name($product_id)
	{
		$category = $this->app->load_model("product_category");
		$category->join_table("category", "left", array("category_name"), array("category_id" => "id"));
		$rs_category = $category->execute("SELECT", false, "", "product_category.product_id='" . $product_id . "'");
		$name = '';
		for ($i = 0; $i < count($rs_category); $i++) {
			if ($i == count($rs_category) - 1) {
				$name .= $rs_category[$i]['category_category_name'];
			} else {
				$name .= $rs_category[$i]['category_category_name'] . ',';
			}
		}
		return $name;
	}
	function resize_multi_image_new($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1, $user_width2, $user_width3)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		$uploadedfile = $uploadedfile_tmpname;
		$file_name = basename($uploadedfile_name);
		$file_info = $this->get_file_info($file_name);
		if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "JPEG" || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
			$new_name = $file_name;
			//echo $new_name; exit;
		}
		if ($new_name) {
			$filename = stripslashes($uploadedfile_name);
			$i = strrpos($filename, ".");
			if (!$i) {
				return "";
			}
			$l = strlen($filename) - $i;
			$ext = substr($filename, $i + 1, $l);
			$extension = $ext;
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$change = '<div class="msgdiv">Unknown Image extension </div> ';
				$errors = 1;
			} else {
				$size = filesize($uploadedfile_tmpname);
				if ($extension == "jpg" || $extension == "jpeg") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}
				echo $scr;
				list($width, $height) = getimagesize($uploadedfile);
				if ($width > $user_width1) {
					$newwidth = $user_width1;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				} else {
					$newwidth = $width;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				}
				if ($width > $user_width2) {
					$newwidth1 = $user_width2;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				} else {
					$newwidth1 = $width;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				}
				if ($width > $user_width3) {
					$newwidth2 = $user_width3;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				} else {
					$newwidth2 = $width;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				}
				imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagecolortransparent($tmp1, imagecolorallocatealpha($tmp1, 0, 0, 0, 127));
				imagealphablending($tmp1, false);
				imagesavealpha($tmp1, true);
				imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
				imagecolortransparent($tmp2, imagecolorallocatealpha($tmp2, 0, 0, 0, 127));
				imagealphablending($tmp2, false);
				imagesavealpha($tmp2, true);
				imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);
				$filename = $image_user_config . $new_name;
				$filename1 = $image_user_config . "mediumthumb" . $new_name;
				$filename2 = $image_user_config . "thumb" . $new_name;
				if ($extension == "jpg" || $extension == "jpeg") {
					imagejpeg($tmp, $filename, 100);
					imagejpeg($tmp1, $filename1, 100);
					imagejpeg($tmp2, $filename2, 100);
				} else if ($extension == "png") {
					imagepng($tmp, $filename);
					imagepng($tmp1, $filename1);
					imagepng($tmp2, $filename2);
				} else {
					imagepng($tmp, $filename, 100);
					imagepng($tmp1, $filename1, 100);
					imagepng($tmp2, $filename2, 100);
				}
				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				imagedestroy($tmp2);
			}
		}
		return $new_name;
	}
	function image_string()
	{
		$rand_val = date('YMDHIS') . rand(11111, 99999);
		return  md5($rand_val);
	}
	function getproductprice_admin_2020($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$kg_price = '';
		if (count($rs_price) > 0) {
			for ($i = 0; $i < count($rs_price); $i++) {
				if ($rs_price[$i]['weight'] == 1000) {
					$weight = $rs_price[$i]['weight'];
					// Price
					$price = $rs_price[$i]['price'];
					$new_price = (1000 * $price) / ($weight);
					$unit_price = intval($new_price);
					// MRP
					$mrp = $rs_price[$i]['mrp'];
					$new_mrp = (1000 * $mrp) / ($weight);
					$unit_mrp = intval($new_mrp);
					$kg_price = 'Yes';
				}
			}
			if ($kg_price == '') {
				$weight = $rs_price[0]['weight'];
				// Price
				$price = $rs_price[0]['price'];
				$new_price = (1000 * $price) / ($weight);
				$unit_price = intval($new_price);
				// MRP
				$mrp = $rs_price[0]['mrp'];
				$new_mrp = (1000 * $mrp) / ($weight);
				$unit_mrp = intval($new_mrp);
			}
			$price_status = 'Yes';
		} else {
			$price_status = 'No';
			$unit_price = 0;
			$unit_mrp = 0;
		}
		$data = array();
		$data['unit_price'] = $unit_price;
		$data['unit_mrp'] = $unit_mrp;
		$data['price_status'] = $price_status;
		return $data;
	}
	function getpcprice_update_2020($product_id)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$kg_price = '';
		if (count($rs_price) > 0) {
			for ($i = 0; $i < count($rs_price); $i++) {
				if ($rs_price[$i]['weight'] == 1) {
					$weight = $rs_price[$i]['weight'];
					// Price
					$price = $rs_price[$i]['price'];
					$unit_price = number_format($price / $weight, '2', '.', '');
					// MRP
					$mrp = $rs_price[$i]['mrp'];
					$unit_mrp = number_format($mrp / $weight, '2', '.', '');
					$kg_price = 'Yes';
				}
			}
			if ($kg_price == '') {
				$weight = $rs_price[0]['weight'];
				// Price
				$price = $rs_price[0]['price'];
				$unit_price = number_format($price / $weight, '2', '.', '');
				// MRP
				$mrp = $rs_price[0]['mrp'];
				$unit_mrp = number_format($mrp / $weight, '2', '.', '');
			}
			$price_status = 'Yes';
		} else {
			$price_status = 'No';
			$unit_price = 0;
			$unit_mrp = 0;
		}
		$unit_price = str_replace(".00", "", $unit_price);
		$unit_mrp = str_replace(".00", "", $unit_mrp);
		$data = array();
		$data['unit_price'] = $unit_price;
		$data['unit_mrp'] = $unit_mrp;
		$data['price_status'] = $price_status;
		return $data;
	}
	function change_weight_display_2018($value, $unit)
	{
		$round = $value / 1000;
		if ($unit == 'in_gm') {
			if ($round >= 1) {
				$num = number_format($round, 2);
				$num = $num;
				return $num . " Kg";
			} else {
				$num = $value;
				return $num . " Gm";
			}
		} else if ($unit == 'in_ltr') {
			if ($round >= 1) {
				$num = number_format($round, 2);
				$num = $num;
				return $num . " Ltr";
			} else {
				$num = $value;
				return $num . " ml";
			}
		} else {
			return " Pcs";
		}
	}
	function change_weight_display_other_2018($value, $unit)
	{
		if ($unit == 'in_gm') {
			$round = $value / 1000;
			if ($round >= 1) {
				$num = number_format($round, 2);
				$num = $num;
				return $num . " Kg";
			} else {
				$num = $value;
				return (int) $num . " Gm";
			}
		} else if ($unit == 'in_ltr') {
			$round = $value / 1000;
			if ($round >= 1) {
				$num = number_format($round, 2);
				$num = $num;
				return $num . " Ltr";
			} else {
				$num = $value;
				return (int) $num . " ml";
			}
		} else {
			$type = '';
		}
	}
	function order_print_weight_detail_data($pro_unit, $default_weight, $final_weight, $default_qty, $final_qty)
	{
		// Weight Check //
		if ($default_weight != $final_weight) {
			if ($final_weight > $default_weight) {
				$extra_weight1 = $final_weight - $default_weight;
				$extra_weight = $this->change_weight_display_other_2018($extra_weight1, $pro_unit);
				$display_extra = ' (+' . $extra_weight . ')';
			} else {
				$extra_weight1 = $default_weight - $final_weight;
				$extra_weight = $this->change_weight_display_other_2018($extra_weight1, $pro_unit);
				$display_extra = ' (-' . $extra_weight . ')';
			}
		} else {
			$display_extra = '';
		}
		$final_weight1 = $this->change_weight_display_other_2018($default_weight, $pro_unit);
		$product_weight = $final_weight1 . $display_extra;
		if ($pro_unit == 'in_gm') {
			$weight = $product_weight;
		} else if ($pro_unit == 'in_ltr') {
			$weight = $product_weight;
		} else  if ($pro_unit == 'in_pkt') {
			$default_weight = (int)($default_weight);
			$final_weight = (int)($final_weight);
			if ($default_weight != $final_weight) {
				if ($final_weight > $default_weight) {
					$extra_weight1 = $final_weight - $default_weight;
					$display_extra = ' (+' . $extra_weight1 . ' Pkt)';
				} else {
					$extra_weight1 = $default_weight - $final_weight;
					$display_extra = ' (-' . $extra_weight1 . ' Pkt)';
				}
			} else {
				$display_extra = '';
			}
			$product_weight = $default_weight . " Pkt" . $display_extra;
			$weight = $product_weight;
		} else {
			$default_weight = (int)($default_weight);
			$final_weight = (int)($final_weight);
			if ($default_weight != $final_weight) {
				if ($final_weight > $default_weight) {
					$extra_weight1 = $final_weight - $default_weight;
					$display_extra = ' (+' . $extra_weight1 . ' Pcs)';
				} else {
					$extra_weight1 = $default_weight - $final_weight;
					$display_extra = ' (-' . $extra_weight1 . ' Pcs)';
				}
			} else {
				$display_extra = '';
			}
			$product_weight = $default_weight . " Pcs" . $display_extra;
			$weight = $product_weight;
		}
		// Weight Check //
		// Qty Check //
		$default_qty = (int)($default_qty);
		$final_qty = (int)($final_qty);
		if ($default_qty != $final_qty) {
			if ($final_qty > $default_qty) {
				$extra_qty1 = $final_qty - $default_qty;
				$display_extra_qty = ' (+' . $extra_qty1 . ')';
			} else {
				$extra_qty1 = $default_qty - $final_qty;
				$display_extra_qty = ' (-' . $extra_qty1 . ')';
			}
		} else {
			$display_extra_qty = '';
		}
		$product_qty = $default_qty . "" . $display_extra_qty;
		$qty = $product_qty;
		// Qty Check //
		$data = array();
		$data['o_weight'] = $weight;
		$data['o_qty'] = $qty;
		return $data;
	}
	function web_order_status($status)
	{
		if ($status == 'Unpaid') {
			$ostatus = '<span class="label label-info">Pending</span>';
		} elseif ($status == 'Paid') {
			$ostatus = '<span class="label label-success">Confirmed</span>';
		} elseif ($status == 'Canceled') {
			$ostatus = '<span class="label label-warning">Canceled</span>';
		} elseif ($status == 'On Delivery') {
			$ostatus = '<span class="label label-blue">Dispatched</span>';
		} elseif ($status == 'Delivered') {
			$ostatus = '<span class="label label-blue">Delivered</span>';
		} elseif ($status == 'Tracking Order') {
			$ostatus = '<span class="label label-blue" style="background:#00BCD4;color:#fff">Tracking Order</span>';
		} elseif ($status == 'Delay') {
			$ostatus = '<span class="label label-blue" style="background:#000;color:#fff">Delay</span>';
		} else {
			$ostatus = '<span class="label label-blue" style="background:#000;color:#fff">' . $status . '</span>';
		}
		return $ostatus;
	}
	function order_status_html($status)
	{
		if ($status == 'Unpaid') {
			$ostatus = '<span class="label label-info">Pending</span>';
		} elseif ($status == 'Paid') {
			$ostatus = '<span class="label label-success">Confirmed</span>';
		} elseif ($status == 'Canceled') {
			$ostatus = '<span class="label label-warning">Canceled</span>';
		} elseif ($status == 'On Delivery') {
			$ostatus = '<span class="label label-blue">Dispatched</span>';
		} elseif ($status == 'Delivered') {
			$ostatus = '<span class="label label-blue">Delivered</span>';
		} elseif ($status == 'Tracking Order') {
			$ostatus = '<span class="label label-blue" style="background:#00BCD4;color:#fff">Tracking Order</span>';
		} elseif ($status == 'Delay') {
			$ostatus = '<span class="label label-blue" style="background:#000;color:#fff">Delay</span>';
		} else {
			$ostatus = '<span class="label label-blue" style="background:#000;color:#fff">' . $status . '</span>';
		}
		return $ostatus;
	}
	function order_from_info_html($order_from)
	{
		$html = $order_from;
		return $html;
	}
	function payment_info_html($payment_type, $payment_status)
	{
		if ($payment_type == 'COD' || $payment_type == 'WALLET') {
			$html = $payment_type;
		} else {
			$html = $payment_type;
			if ($payment_status == 'Failed') {
				$html .= '<br/><span class="label label-warning" style="background:red">Failed</span>';
			} else if ($payment_status == 'Success') {
				$html .= '<br/><span class="label label-success">Success</span>';
			} else {
				$html .= '';
			}
		}
		return $html;
	}
	function payment_info_html_app($payment_type, $payment_status)
	{
		$html = $payment_type;
		return $html;
	}
	function get_option_q_view_add_cart_btn($product_id, $product_price_id)
	{
		$obj_model_tmp_k = $this->app->load_model("tmp_cart");
		$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
		if (count($rskart) > 0) {
			$btn .= '<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'PLUS\')">+</button>
                    </div>';
		} else {
			$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'PLUS\')"  title="Add To Cart"><i class="fa fa-shopping-cart" ></i> Add To Cart</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function get_option_detail_add_cart_btn($product_id, $product_price_id)
	{
		$obj_model_tmp_k = $this->app->load_model("tmp_cart");
		$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
		if (count($rskart) > 0) {
			$btn .= '<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'detail\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'detail\',\'PLUS\')">+</button>
                    </div>';
		} else {
			$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'detail\',\'PLUS\')"  title="Add To Cart"><i class="fa fa-shopping-cart" ></i> Add To Cart</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function get_option_add_cart_btn($product_id, $product_price_id)
	{
		$obj_model_tmp_k = $this->app->load_model("tmp_cart");
		$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
		if (count($rskart) > 0) {
			$btn .= '<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'other\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'other\',\'PLUS\')">+</button>
                    </div>';
		} else {
			$btn .= '<a class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'other\',\'PLUS\')" style="font-size: 13px; margin-right: 3px; padding: 4px 5px;" title="Add To Cart"><i class="fa fa-shopping-cart" style="font-size:12px"></i> Add To Cart</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function get_add_cart_btn($product_id, $pro_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$btn = '<div class="pr_' . $product_id . ' incr-btn">';
		if (count($rs_price) > 0) {
			$product_price_id = $rs_price[0]['id'];
			$product_id = $rs_price[0]['product_id'];
			$obj_model_tmp_k = $this->app->load_model("tmp_cart");
			$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
			if (count($rskart) > 0) {
				$btn .= '<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'other\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'other\',\'PLUS\')">+</button>
                    </div>';
			} else {
				$btn .= '<a class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'other\',\'PLUS\')" style="font-size: 13px; margin-right: 3px; padding: 4px 5px;" title="Add To Cart"><i class="fa fa-shopping-cart" style="font-size:12px"></i> Add To Cart</a>';
			}
		} else {
			$btn .= '<a class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0 sold_out" href="javascript:void(0);"  style="font-size: 13px; margin-right: 3px; padding: 4px 5px;" title="Sold Out"> <i class="fa fa-shopping-cart" style="font-size:12px"></i> Sold Out</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function get_product_q_view_add_cart_btn($product_id, $pro_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$btn = '<div class="pr_' . $product_id . '">';
		if (count($rs_price) > 0) {
			$product_price_id = $rs_price[0]['id'];
			$product_id = $rs_price[0]['product_id'];
			$obj_model_tmp_k = $this->app->load_model("tmp_cart");
			$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
			if (count($rskart) > 0) {
				$btn .= '<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'PLUS\')">+</button>
                    </div>';
			} else {
				$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_large" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'quick_view\',\'PLUS\')"  title="Add To Cart"><i class="fa fa-shopping-cart" ></i> Add To Cart</a>';
			}
		} else {
			$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_large sold_out" href="javascript:void(0);"   title="Sold Out"> <i class="fa fa-shopping-cart" style="font-size:12px"></i> Sold Out</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function get_product_detail_add_cart_btn($product_id, $pro_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$btn = '<div class="pr_' . $product_id . '">';
		if (count($rs_price) > 0) {
			$product_price_id = $rs_price[0]['id'];
			$product_id = $rs_price[0]['product_id'];
			$obj_model_tmp_k = $this->app->load_model("tmp_cart");
			$rskart = $obj_model_tmp_k->execute("SELECT", false, "", "session_id='" . session_id() . "' AND product_id='" . $product_id . "' AND product_price_id='" . $product_price_id . "'");
			if (count($rskart) > 0) {
				$btn .= '<div class="clearfix quantity normal-quantity r_corners d_inline_middle f_size_medium color_dark">
                      <button class="bg_tr d_block f_left detail_qty_p_m_' . $product_id . '" data-direction="down" onclick="add_to_cart(' . $product_id . ',\'detail\',\'MINUS\')">-</button>
                      <input type="text" name="detail_qty" id="detail_qty" readonly="" value="' . $rskart[0]['quantity'] . '" class="f_left detail_qty_' . $product_id . '" style="text-align:center">
                      <button class="bg_tr d_block f_left  detail_qty_p_m_' . $product_id . '" data-direction="up" onclick="add_to_cart(' . $product_id . ',\'detail\',\'PLUS\')">+</button>
                    </div>';
			} else {
				$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large" href="javascript:void(0);" onclick="add_to_cart(' . $product_id . ',\'detail\',\'PLUS\')"  title="Add To Cart"><i class="fa fa-shopping-cart" ></i> Add To Cart</a>';
			}
		} else {
			$btn .= '<a class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large sold_out" href="javascript:void(0);"   title="Sold Out"> <i class="fa fa-shopping-cart" style="font-size:12px"></i> Sold Out</a>';
		}
		$btn .= '</div>';
		return $btn;
	}
	function preview_excel($inputFileName, $table_class = NULL)
	{
		try {
			echo
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}
		//Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		//  Loop through each row of the worksheet in turn
		$html = '<table class="' . $table_class . '">';
		for ($row = 1; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray(
				'A' . $row . ':' . $highestColumn . $row,
				NULL,
				TRUE,
				FALSE
			);
			$html .= '<tr>';
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$cell = $sheet->getCellByColumnAndRow($col, $row);
				$val = $cell->getValue();
				$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
				// echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
				$html .= '<td>' . $val . '<br></td>';
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}
	function export_excel($ExeclHeads, $data_array, $fields, $filename, $array_field)
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowCount = 1;
		//start of printing column names as names of MySQL fields
		$column = 'A';
		for ($i = 0; $i < count($ExeclHeads); $i++) {
			$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $ExeclHeads[$i]);
			$column++;
		}
		//end of adding column names
		//start while loop to get data
		$rowCount = 2;
		foreach ($data_array as $row) {
			$column = 'A';
			for ($j = 0; $j < count($fields); $j++) {
				if (!isset($row[$fields[$j]]))
					$value = NULL;
				elseif ($row[$fields[$j]] != "")
					$value = strip_tags($row[$fields[$j]]);
				else
					$value = "";
				$objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $value);
				foreach ($array_field as $ddd => $dddvalue) {
					if ($ddd == $fields[$j]) {
						//$pr_title=$dddvalue['prompt_title'];
						//$pr_prompt=$dddvalue['prompt'];
						//$pr_options=$dddvalue['options'];
						$objValidation3 = $objPHPExcel->getActiveSheet()->getCell($column . $rowCount)->getDataValidation();
						$objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
						$objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
						$objValidation3->setAllowBlank(false);
						$objValidation3->setShowInputMessage(true);
						$objValidation3->setShowDropDown(true);
						//$objValidation3->setPromptTitle($pr_title);
						//$objValidation3->setPrompt($pr_prompt);
						$objValidation3->setErrorTitle('Input error');
						$objValidation3->setError('Value is not in list');
						//$objValidation3->setFormula1('"'.$pr_options.'"');
					}
				}
				$column++;
			}
			$rowCount++;
		}
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
	}
	// New Added Function 2021 BY Mehul
	function getproductprice_admin_2021($product_id, $product_unit)
	{
		$obj_model_product_price = $this->app->load_model("product_price");
		$rs_price = $obj_model_product_price->execute("SELECT", false, "", "product_id=" . $product_id . "", "weight ASC");
		$kg_price = '';
		if (count($rs_price) > 0) {
			if ($product_unit == 'in_gm' || $product_unit == 'in_ltr') {
				$cal_weight = 1000;
			} else {
				$cal_weight = 1;
			}
			for ($i = 0; $i < count($rs_price); $i++) {
				if ($rs_price[$i]['weight'] == $cal_weight) {
					$weight = $rs_price[$i]['weight'];
					// Price
					$price = $rs_price[$i]['price'];
					$new_price = ($cal_weight * $price) / ($weight);
					$unit_price = intval($new_price);
					// MRP
					$mrp = $rs_price[$i]['mrp'];
					$new_mrp = ($cal_weight * $mrp) / ($weight);
					$unit_mrp = intval($new_mrp);
					$kg_price = 'Yes';
				}
			}
			if ($kg_price == '') {
				$weight = $rs_price[0]['weight'];
				// Price
				$price = $rs_price[0]['price'];
				$new_price = ($cal_weight * $price) / ($weight);
				$unit_price = intval($new_price);
				// MRP
				$mrp = $rs_price[0]['mrp'];
				$new_mrp = ($cal_weight * $mrp) / ($weight);
				$unit_mrp = intval($new_mrp);
			}
			$price_status = 'Yes';
		} else {
			$price_status = 'No';
			$unit_price = 0;
			$unit_mrp = 0;
		}
		$data = array();
		$data['unit_price'] = $unit_price;
		$data['unit_mrp'] = $unit_mrp;
		$data['price_status'] = $price_status;
		return $data;
	}
	// New Added Function 2021 BY Rahul
	function o_status_html2020($order_status)
	{
		if ($order_status == 'Pending') {
			$class = "badge-secondary";
		} else if ($order_status == 'Confirmed') {
			$class = "badge-primary";
		} else if ($order_status == 'Packed') {
			$class = "badge-info";
		} else if ($order_status == 'Dispatched') {
			$class = "badge-warning";
		} else if ($order_status == 'Delivered') {
			$class = "badge-success";
		} else if ($order_status == 'Return') {
			$class = "badge-danger";
		} else if ($order_status == 'Canceled') {
			$class = "badge-danger";
		} else {
			$class = "badge-dark";
		}
		$order_status = '<span class="badge ' . $class . '" >' . $order_status . '</span>';
		return $order_status;
	}
	function doctor_type($table_name)
	{
		$obj_table = $this->app->load_model($table_name);
		$result = $obj_table->execute("SELECT", false, "", "status!='Trash'");
		$records = array();
		$records[''] = 'Select';
		for ($i = 0; $i < count($result); $i++) {
			$records[$result[$i]['id']] = $result[$i]['name'];
		}
		return $records;
	}
	function sort_order($table_name)
	{
		$obj_table = $this->app->load_model($table_name);
		$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where id!=0 and status!='Trash'");
		$totalRecords = $result[0]['allcount'];
		$records = array();
		for ($i = 1; $i <= $totalRecords + 1; $i++) {
			$records[$i] = $i;
		}
		krsort($records);
		return $records;
	}
	function sort_order_count($table_name)
	{
		$obj_table = $this->app->load_model($table_name);
		$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount," . $table_name . ".* from " . $table_name . "  where id!=0 and status!='Trash'");
		$totalRecords = $result[0]['allcount'];
		return $totalRecords + 1;
	}
	function user_group($group_id)
	{
		$group_ids = explode(',', $group_id);
		$group_name = '';
		for ($j = 0; $j < count($group_ids); $j++) {
			$obj_model_user_group = $this->app->load_model('user_group');
			$rs_cat = $obj_model_user_group->execute("SELECT", false, "SELECT id,name FROM user_group WHERE id=" . $group_ids[$j] . "", "");
			$group_name .= '<span class="badge badge-primary">' . $rs_cat[0]['name'] . '</span> ';
		}
		return $group_name;
	}
	function user_status($user_status)
	{
		if ($user_status == 'Yes') {
			$user_status = '<span class="badge badge-warning">Yes</span>';
		} else {
			$user_status = '<span class="badge badge-danger">No</span>';
		}
		return $user_status;
	}
	function user_registered_with($registered_with)
	{
		if ($registered_with == 'website') {
			$user_status = '<span class="badge badge-warning">Website</span>';
		} else if ($registered_with == 'facebook' || $registered_with == 'facebook_app') {
			$user_status = '<span class="badge badge-secondary">Facebook</span>';
		} else if ($registered_with == 'google' || $registered_with == 'google_app') {
			$user_status = '<span class="badge badge-success">Google</span>';
		} else if ($registered_with == 'iphone') {
			$user_status = '<span class="badge badge-info">Iphone</span>';
		} else if ($registered_with == 'android_app') {
			$user_status = '<span class="badge badge-dark">Android</span>';
		} else {
			$user_status = '<span class="badge badge-light">Both</span>';
		}
		return $user_status;
	}
	function product_cat_names($product_id)
	{
		if ($product_id > 0) {
			$obj_model_tble = $this->app->load_model("product_category");
			$obj_model_tble->join_table("category", "left", array("name"), array("category_id" => "id"));
			$data = $obj_model_tble->execute("SELECT", false, "", "product_id='" . $product_id . "'");
			if (count($data) > 0) {
				$ccat_array = array();
				for ($i = 0; $i < count($data); $i++) {
					$ccat_array[] = $data[$i]['category_name'];
				}
				$cats = implode(',', $ccat_array);
				return $cats;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
	function cat_listmenu($pid = 0, $act, $product_id)
	{
		if ($act == 'edit') {
			$obj_model_category = $this->app->load_model('category');
			$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,name,parentcategory_id FROM category WHERE status='Active' and parentcategory_id='$pid'", "");
			$i = 0;
			foreach ($rs_cat as $cat) {
				$obj_model_product_category = $this->app->load_model('category_group_ids');
				$rs_product_cat = $obj_model_product_category->execute("SELECT", false, "", "group_id=" . $product_id . " and category_id=" . $cat['id'] . "");
				if ($i % 2 == 0) {
					echo '<div class="even">';
				} else {
					echo '<div class="odd">';
				}
				if ($rs_product_cat[0]["category_id"] == $cat['id']) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
				print ' <label class="csscheckbox csscheckbox-primary">
		<input class="csscheckbox csscheckbox-default" type="checkbox" ' . $checked . ' name="product_category[]" value="' . $cat['id'] . '"> <span></span>&nbsp;&nbsp;&nbsp;' . $cat['name'] . ' </label>';
				if ($this->countsubcat($cat['id']) > 0) {
					echo '<div class="subs">';
					$this->cat_listmenu($cat['id'], $act, $product_id);
					echo '</div>';
				}
				echo '</div>';
			}
		} else {
			$obj_model_category = $this->app->load_model('category');
			$rs_cat = $obj_model_category->execute("SELECT", false, "SELECT id,name,parentcategory_id FROM category WHERE status='Active' and parentcategory_id='$pid'", "");
			$i = 0;
			foreach ($rs_cat as $cat) {
				if ($i % 2 == 0) {
					echo '<div class="even">';
				} else {
					echo '<div class="odd">';
				}
				print ' <label class="csscheckbox csscheckbox-primary">
		<input type="checkbox" name="product_category[]" value="' . $cat['id'] . '"><span></span>&nbsp;&nbsp;&nbsp;' . $cat['name'] . ' </label>';
				if ($this->countsubcat($cat['id']) > 0) {
					echo '<div class="subs">';
					$this->cat_listmenu($cat['id'], '', '');
					echo '</div>';
				}
				echo '</div>';
			}
		}
		$i++;
	}
	function get_image_path($image_name, $folder, $type)
	{
		if ($image_name != "" && file_exists(ABS_PATH . "/uploads/" . $folder . "/" . $image_name)) {
			$large_image = SERVER_ROOT . "/uploads/" . $folder . "/" . $image_name;
			$medium_image = SERVER_ROOT . "/uploads/" . $folder . "/" . 'mediumthumb' . $image_name;
			$thumb_image = SERVER_ROOT . "/uploads/" . $folder . "/" . 'thumb' . $image_name;
		} else {
			if ($folder == 'customer') {
				$large_image = SERVER_ROOT . '/uploads/default_customer.png';
				$medium_image = SERVER_ROOT . '/uploads/default_customer.png';
				$thumb_image = SERVER_ROOT . '/uploads/default_customer.png';
			} else {
				$large_image = SERVER_ROOT . '/uploads/default.png';
				$medium_image = SERVER_ROOT . '/uploads/default.png';
				$thumb_image = SERVER_ROOT . '/uploads/default.png';
			}
		}
		if ($type == '') {
			$data = array();
			$data['large_image'] = $large_image;
			$data['medium_image'] = $medium_image;
			$data['thumb_image'] = $thumb_image;
		} else {
			if ($type == 'large') {
				$data = $large_image;
			} else if ($type == 'medium') {
				$data = $medium_image;
			} else if ($type == 'thumb') {
				$data = $thumb_image;
			} else {
				$data = '';
			}
		}
		return $data;
	}
	function get_zone2021($area_name)
	{
		$obj_model_area = $this->app->load_model("area");
		$rs_area = $obj_model_area->execute("SELECT", false, "", "name='" . trim($area_name) . "'");
		if (count($rs_area) > 0) {
			if ($rs_area[0]['zone'] == 'West') {
				$zone = '<span class="badge badge-primary">West</span>';
			} elseif ($rs_area[0]['zone'] == 'South-West') {
				$zone = '<span class="badge badge-secondary">South-West</span>';
			} elseif ($rs_area[0]['zone'] == 'South') {
				$zone = '<span class="badge badge-success">South</span>>';
			} elseif ($rs_area[0]['zone'] == 'North') {
				$zone = '<span class="badge badge-warning">North</span>';
			} elseif ($rs_area[0]['zone'] == 'East') {
				$zone = '<span class="badge badge-info">East</span>';
			} else {
				$zone = '<span class="badge badge-dark">Centeral</span>';
			}
		} else {
			$zone = '-';
		}
		return $zone;
	}
	function set_message2021($message, $type)
	{
		$_SESSION['msg'] = $message;
		$_SESSION['type'] = $type;
	}
	function get_message2021()
	{
		if (VIR_DIR == "admin/") {
			if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
				if ($_SESSION['type'] == 'SUCCESS') {
					$message =  '<div class="alert alert-success alert-dismissible fade show" role="alert">
									  <i class="fa fa-check mg-r-10"></i> <strong>SUCCESS </strong> ' . $_SESSION['msg'] . '
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									  </button>
									</div>';
				} else if ($_SESSION['type'] == 'ERROR') {
					$message =  '<div class="alert alert-error alert-dismissible fade show" role="alert">
									  <i class="fa fa-close mg-r-10"></i> <strong>ERROR </strong> ' . $_SESSION['msg'] . '
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									  </button>
									</div>';
				} else if ($_SESSION['type'] == 'MESSAGE') {
					$message =  '<div class="alert alert-warning alert-dismissible fade show" role="alert">
									  <i class="fa fa-bullhorn mg-r-10"></i> <strong>Information </strong> ' . $_SESSION['msg'] . '
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									  </button>
									</div>';
				}
				unset($_SESSION['msg']);
				unset($_SESSION['type']);
				return $message;
			}
		} else {
			if (isset($_SESSION['msg']) && isset($_SESSION['type'])) {
				if ($_SESSION['type'] == 'SUCCESS') {
					if (VIR_DIR != "") {
						$message = '<div class="alert alert-success">
					 <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
					<strong>Success!</strong> ' . $_SESSION['msg'] . '
				</div>';
					} else {
						$message =  '<div class="col-sm-12">
				<div class="alert_box r_corners color_green success m_bottom_10">
							<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
							<i class="fa fa-smile-o"></i><p>' . $_SESSION['msg'] . ' </p>
							</div></div>
				';
					}
				} else if ($_SESSION['type'] == 'ERROR') {
					if (VIR_DIR != "") {
						$message =  '<div class="alert alert-error">
					 <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
					 <strong>Error!</strong> ' . $_SESSION['msg'] . '
				</div>';
					} else {
						$message = '
				<div class="col-sm-12">
				<div class="alert_box r_corners error ">
							<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
							<i class="fa fa-exclamation-triangle"></i><p>' . $_SESSION['msg'] . '</p>
							</div></div>
							';
					}
				} else if ($_SESSION['type'] == 'MESSAGE') {
					$message =  '<div class="col-sm-12"><div class="alert_box r_corners warning m_bottom_10">
					 	<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
						<i class="fa fa-exclamation-triangle"></i><p>' . $_SESSION['msg'] . '</p>
						</div></div>';
				}
				unset($_SESSION['msg']);
				unset($_SESSION['type']);
				return $message;
			}
		}
	}
	function customer_total_order($customer_id)
	{
		$table = $this->app->load_model("order_master");
		$rs_data = $table->execute("SELECT", false, "SELECT count(id) AS Total_Use FROM order_master WHERE user_id='" . $customer_id . "'", "");
		$total_use = $rs_data[0]['Total_Use'];
		return $total_use;
	}
	function numerdisplayformate($number)
	{
		$num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $number);
		return $num;
	}
	function user_area($id)
	{
		$obj_model_user_group = $this->app->load_model('area');
		$rs_cat = $obj_model_user_group->execute("SELECT", false, "SELECT id,name FROM area WHERE id=" . $id . "", "");
		return $rs_cat[0]['name'];
	}
	function get_delivery_vans_name($id)
	{
		if ($id != '' && $id != 0) {
			$obj_model_delivery_vans = $this->app->load_model("delivery_vans");
			$rs_delivery_vans = $obj_model_delivery_vans->execute("SELECT", false, "", "id=" . $id . "");
			$delivery_vans = '<span class="badge badge-info">' . $rs_delivery_vans[0]['person_name'] . '</span>';
		} else {
			$delivery_vans = '';
		}
		return $delivery_vans;
	}
	function get_retting_number($exp)
	{
		if ($exp == 'Terrible') {
			$number = '1';
		} else if ($exp == 'Bad') {
			$number = '2';
		} else if ($exp == 'Okay') {
			$number = '3';
		} else if ($exp == 'Good') {
			$number = '4';
		} else if ($exp == 'Great') {
			$number = '5';
		}
		return $number;
	}
	function resize_multi_image_2020($uploadedfile_name, $uploadedfile_tmpname, $image_user_config, $user_width1, $user_width2, $user_width3)
	{
		$errors = 0;
		//$image =$_FILES["file"]["name"];
		$uploadedfile = $uploadedfile_tmpname;
		$file_name = basename($uploadedfile_name);
		$file_info = $this->get_file_info($file_name);
		if (strtoupper($file_info->extension) == "JPG" || strtoupper($file_info->extension) == "JPEG" || strtoupper($file_info->extension) == "GIF"  || strtoupper($file_info->extension) == "PNG") {
			$new_name = rand(1234, 999999) . $this->image_string() . "." . $file_info->extension;
		}
		if ($new_name) {
			$filename = stripslashes($uploadedfile_name);
			$i = strrpos($filename, ".");
			if (!$i) {
				return "";
			}
			$l = strlen($filename) - $i;
			$ext = substr($filename, $i + 1, $l);
			$extension = $ext;
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$change = '<div class="msgdiv">Unknown Image extension </div> ';
				$errors = 1;
			} else {
				$size = filesize($uploadedfile_tmpname);
				if ($extension == "jpg" || $extension == "jpeg") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$uploadedfile = $uploadedfile_tmpname;
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}
				echo $scr;
				list($width, $height) = getimagesize($uploadedfile);
				if ($width > $user_width1) {
					$newwidth = $user_width1;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				} else {
					$newwidth = $width;
					$newheight = ($height / $width) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth, $newheight);
				}
				if ($width > $user_width2) {
					$newwidth1 = $user_width2;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				} else {
					$newwidth1 = $width;
					$newheight1 = ($height / $width) * $newwidth1;
					$tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
				}
				if ($width > $user_width3) {
					$newwidth2 = $user_width3;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				} else {
					$newwidth2 = $width;
					$newheight2 = ($height / $width) * $newwidth2;
					$tmp2 = imagecreatetruecolor($newwidth2, $newheight2);
				}
				imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 0, 0, 0, 127));
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagecolortransparent($tmp1, imagecolorallocatealpha($tmp1, 0, 0, 0, 127));
				imagealphablending($tmp1, false);
				imagesavealpha($tmp1, true);
				imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
				imagecolortransparent($tmp2, imagecolorallocatealpha($tmp2, 0, 0, 0, 127));
				imagealphablending($tmp2, false);
				imagesavealpha($tmp2, true);
				imagecopyresampled($tmp2, $src, 0, 0, 0, 0, $newwidth2, $newheight2, $width, $height);
				$filename = $image_user_config . $new_name;
				$filename1 = $image_user_config . "mediumthumb" . $new_name;
				$filename2 = $image_user_config . "thumb" . $new_name;
				if ($extension == "jpg" || $extension == "jpeg") {
					imagejpeg($tmp, $filename, 90);
					imagejpeg($tmp1, $filename1, 90);
					imagejpeg($tmp2, $filename2, 90);
				} else if ($extension == "png") {
					imagepng($tmp, $filename);
					imagepng($tmp1, $filename1);
					imagepng($tmp2, $filename2);
				} else {
					imagepng($tmp, $filename, 90);
					imagepng($tmp1, $filename1, 90);
					imagepng($tmp2, $filename2, 90);
				}
				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				imagedestroy($tmp2);
			}
		}
		return $new_name;
	}
	function moneyFormatIndia($number)
	{
		$num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $number);
		$num = str_replace(".00", "", $num);
		return '<i class="fas fa-rupee-sign"></i>' . $num;
	}
	function get_product_sizes($id, $master_type)
	{
		if ($master_type == 'Single') {
			$html = '';
		} else {
			$obj_model_tble = $this->app->load_model("product_price");
			$rs_tble = $obj_model_tble->execute("SELECT", false, "", "attribute_1!='' and product_id='" . $id . "'", "id ASC", "attribute_1");
			$si = array();
			for ($m = 0; $m < count($rs_tble); $m++) {
				$si[] = $rs_tble[$m]['attribute_1'];
			}
			$html = '<div class="product-attr pa ts__03 cw op__0 tc"><p class="truncate mg__0 w__100">' . implode(', ', $si) . '</p></div>';
		}
		return $html;
	}
	function get_price_info($id, $master_price, $master_mrp)
	{
		$mrp_display = '';
		$dis_html = '';
		if ($master_mrp > $master_price && $master_mrp != 0) {
			$mrp_display = '<del>' . $this->moneyFormatIndia($master_mrp) . '</del>';
			$dis_q = $master_mrp - $master_price;
			$dis_per = $dis_q * 100 / $master_mrp;
			if ((int)$dis_per > 0) {
				$dis_html = '<span class="tc nt_labels pa pe_none cw"><span class="onsale nt_label"><span>-' . (int)$dis_per . '%</span></span></span>';
			}
		}
		$price_display = '<ins>' . $this->moneyFormatIndia($master_price) . '</ins>';
		$p_info_html = '<span class="price dib mb__5">' . $price_display . ' ' . $mrp_display . '</span>';
		$data = array();
		$data['p_info_html'] = $p_info_html;
		$data['dis_html'] = $dis_html;
		return $data;
	}
	function get_price_info_detail($id, $master_price, $master_mrp)
	{
		$mrp_display = '';
		$dis_html = '';
		if ($master_mrp > $master_price && $master_mrp != 0) {
			$mrp_display = '<del>' . $this->moneyFormatIndia($master_mrp) . '</del>';
			$dis_q = $master_mrp - $master_price;
			$dis_per = $dis_q * 100 / $master_mrp;
			if ((int)$dis_per > 0) {
				$dis_html = '<span class="disDiv">' . (int)$dis_per . '% OFF </span>';
			}
		}
		$price_display = '<ins>' . $this->moneyFormatIndia($master_price) . '</ins>';
		$p_info_html = ' <p class="price_range" id="price_ppr">' . $price_display . ' ' . $mrp_display . ' ' . $dis_html . '</p>';
		$data = array();
		$data['p_info_html'] = $p_info_html;
		$data['dis_html'] = $dis_html;
		return $data;
	}
	function GetStateName($state_id)
	{
		if ($state_id > 0) {
			$obj_model_state = $this->app->load_model("state");
			$rs_state = $obj_model_state->execute("SELECT", false, "", "id=" . $state_id . "", "id DESC limit 0,1");
			return $rs_state[0]['name'];
		}
	}
	function GetCategoryName($category_id)
	{
		if ($category_id > 0) {
			$obj_model_state = $this->app->load_model("category");
			$rs_state = $obj_model_state->execute("SELECT", false, "", "id=" . $category_id . "", "id DESC limit 0,1");
			return $rs_state[0]['category_name'];
		}
	}
	function display_show($status)
	{
		if ($status == 'App') {
			$ostatus = '<span class="badge badge-warning">App</span>';
		} elseif ($status == 'Website') {
			$ostatus = '<span class="badge badge-success">Website</span>';
		} else {
			$ostatus = '<span class="badge badge-primary">All</span>';
		}
		return $ostatus;
	}
	function load_wallet_transction($data, $limit, $serach_keyword, $total_products, $cust_id)
	{
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		//echo $order_v; exit;
		//style query condition
		$order_by = 'wallet_transction.id DESC';
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = " and (wallet_transction.amount LIKE '$q%' or wallet_transction.amount LIKE '%$q%' or wallet_transction.amount LIKE '%$q' or wallet_transction.transaction_id LIKE '$q%' or wallet_transction.transaction_id LIKE '%$q%' or wallet_transction.transaction_id LIKE '%$q' or wallet_transction.payment_status LIKE '$q%' or wallet_transction.payment_status LIKE '%$q%' or wallet_transction.payment_status LIKE '%$q' or wallet_transction.remark LIKE '$q%' or wallet_transction.remark LIKE '%$q%' or wallet_transction.remark LIKE '%$q' or wallet_transction.transaction_date LIKE '$q%' or wallet_transction.transaction_date LIKE '%$q%' or wallet_transction.transaction_date LIKE '%$q')";
		} else {
			$g_search_query = "";
		}
		if ($cust_id != '') {
			$cust_cond = "and customer_id='" . $cust_id . "'";
		} else {
			$cust_cond = "";
		}
		$obj_model_all_data = $this->app->load_model("wallet_transction");
		$result = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount, wallet_transction.* from wallet_transction where wallet_transction.id!='' " . $cust_cond . " " . $g_search_query);
		$total_products = $result[0]['allcount'];
		$obj_model_all = $this->app->load_model("wallet_transction");
		$records = $obj_model_all->execute("SELECT", false, "", "wallet_transction.id!='' " . $cust_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "", "wallet_transction.id");
		$str = '';
		//$data = $con->query($sql);
		if (count($records) > 0) {
			foreach ($records as $product) {
				$amount = $product['amount'];
				$amount_type = $product['amount_type'];
				$transaction_id = $product['transaction_id'];
				$remark = $product['remark'];
				$payment_status = $product['payment_status'];
				$transaction_date = $product['transaction_date'];
				$wallet_type = $product['wallet_type'];
				$amount = $this->moneyFormatIndia($amount);
				if ($payment_status != 'Success') {
					$label_data = '<span class="text-danger failed f-semibold mt-2 d-block">Failed</span>';
					$masterClass = 'text-red text-danger';
				} else {
					//$label_data='<span class="text-success fs__14 fwsb d-block">Success</span>';
					$masterClass = '';
					$label_data = '';
				}
				if (isset($data['site']) && $data['site'] == 'msite') {
					$amount_type_class = $amount_type == '-' ? 'th-color-red' : 'th-color-green';
					$str .= '<div class="bg-white px-3 pt-3 pb-1 border-bottom">
				<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
					<p class="mb-0 fw-600">' . $transaction_id . '</p>
					<p class="mb-0">' . $transaction_date . '</p>
				</div>
				<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
					<p class="mb-0 fw-600">' . $remark . '</p>
					<p class="mb-0 ' . $amount_type_class . '"><span>' . $amount_type . $amount . '</span> ' . $label_data . '</p>
				</div>
			</div>';
				} else {
					$str .= '<div class="row align-items-center walinfo border-bottom ps-2 pe-2 pt-3 pb-3">
							<div class="col-lg-6 col-9">
								<h6>' . $remark . ' (' . $wallet_type . ')</h6>
								<p class="mb__5">Transaction ID <span class="text-red">' . $transaction_id . '</span></p>
								<p class="fs__12">' . $transaction_date . '</p>
							</div>
							<div class="col-lg-6 text-end col-3">
								<span class="' . $masterClass . ' f-semibold">' . $amount_type . $amount . '</span>
								' . $label_data . '
							</div>
							</div>';
				}
			}
			$load_total = $page * $limit;
			$total_products = $total_products;
			$remain_load11 = $total_products - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($remain_load <= 0) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
   <input type='hidden' class='isload' value='true'>
   <input type='hidden' class='nextload_total' value='" . $remain_load . "'>
   ";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\" style=\"    margin-bottom: 100px;margin-top: 20px;\">No Transction.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			}
		}
		return $str;
	}
	function load_refer_users($data, $limit, $serach_keyword, $total_products, $cust_id)
	{
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		//echo $order_v; exit;
		//style query condition
		$order_by = 'customer.id DESC';
		$obj_model_customer = $this->app->load_model("customer");
		$rs_customer = $obj_model_customer->execute("SELECT", false, "", "customer.id='" . $cust_id . "'");
		$cust_cond = "and referral_from='" . $rs_customer[0]['ref_key'] . "'";
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = " and (customer.name LIKE '$q%' or customer.name LIKE '%$q%' or customer.name LIKE '%$q' or customer.last_name LIKE '$q%' or customer.last_name LIKE '%$q%' or customer.last_name LIKE '%$q' or customer.phone LIKE '$q%' or customer.phone LIKE '%$q%' or customer.phone LIKE '%$q' or customer.email LIKE '$q%' or customer.email LIKE '%$q%' or customer.email LIKE '%$q')";
		} else {
			$g_search_query = "";
		}
		$obj_model_all_data = $this->app->load_model("customer");
		$result = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount, customer.* from customer where customer.id!='' " . $cust_cond . " " . $g_search_query);
		$total_products = $rs_total[0]['allcount'];
		$obj_model_all = $this->app->load_model("customer");
		$records = $obj_model_all->execute("SELECT", false, "", "customer.id!='' " . $cust_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "", "customer.id");
		$str = '';
		//$data = $con->query($sql);
		if (count($records) > 0) {
			foreach ($records as $product) {
				$name = $product['name'];
				$last_name = $product['last_name'];
				$phone = $product['phone'];
				$register_date = $product['register_date'];
				$str .= '<div class="row align-items-center border-bottom pl__5 pr__5 pt__10 pb__10">
			<div class="col-lg-6 pl__15 pr__15 col-8">
				<h6 class="mb-0">' . $name . ' ' . $last_name . '</h6>
				<p class="mb-0">' . $phone . '</p>
				<p class="fs__12">Sign up On <span class="text-dark fwsb">' . $register_date . '</span></p>
			</div>
			<div class="col-auto pl__15 pr__15 text-center ml-auto">
				<h6 class="d-block fs__12 fwm text-right mb-0">You Earned</h6>
				<span class="text-success fs__16 fwsb">Rs.25</span>
			</div>
		</div>';
			}
			$load_total = $page * $limit;
			$total_products = $total_products;
			$remain_load11 = $total_products - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($remain_load <= 0) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
   <input type='hidden' class='isload' value='true'>
   <input type='hidden' class='nextload_total' value='" . $remain_load . "'>
   ";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\" style=\"    margin-bottom: 100px;margin-top: 20px;\">No Result Found.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			}
		}
		return $str;
	}
	function load_my_orders($data, $limit, $serach_keyword, $total_products, $cust_id, $site = null)
	{
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		//echo $order_v; exit;
		//style query condition
		$order_by = 'customer_order_master.id DESC';
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = "and (customer_order_master.id LIKE '$q%' or customer_order_master.id LIKE '%$q%' or customer_order_master.id LIKE '%$q' or customer_order_master.order_status LIKE '$q%' or customer_order_master.order_status LIKE '%$q%' or customer_order_master.order_status LIKE '%$q' or customer_order_master.order_date LIKE '$q%' or customer_order_master.order_date LIKE '%$q%' or customer_order_master.order_date LIKE '%$q')";
		} else {
			$g_search_query = "";
		}
		$cust_cond = "and customer_order_master.customer_id='" . $cust_id . "'";
		$obj_model_all_data = $this->app->load_model("customer_order_master");
		$result = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount, customer_order_master.* from customer_order_master where customer_order_master.id!='' " . $cust_cond . " " . $g_search_query);
		$total_products = $rs_total[0]['allcount'];
		$obj_model_all = $this->app->load_model("customer_order_master");
		$records = $obj_model_all->execute("SELECT", false, "", "customer_order_master.id!='' " . $cust_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "", "customer_order_master.id");
		$str = '';
		//$data = $con->query($sql);
		if (count($records) > 0) {
			foreach ($records as $product) {
				$id = $product['id'];
				$display_order_no = $product['display_order_no'];
				$net_order_value = $product['net_order_value'];
				$order_status = $product['order_status'];
				$order_status = $order_status == 'Canceled' ? "Cancelled" : $order_status;
				$order_date = $product['order_date'];
				$payment_type = $product['payment_type'];
				$obj_model_detail = $this->app->load_model("customer_order_detail");
				$rs_orders = $obj_model_detail->execute("SELECT", false, "", "order_master_id='" . $id . "'");
				$items = count($rs_orders);
				$net_order_value_display = $this->moneyFormatIndia($net_order_value);
				if ($site == 'msite') {
					//for mobile stie
					$str .= '<div class="card mb-3 pb-3 shadow2 d-block">
						<a href="' . SERVER_ROOT . '/order-details/' . $id . '" class="ps-3 pe-2 py-2 d-flex align-items-center justify-content-between border-bottom">
							<h3 class="theme-color font-md fw-bold">#' . $display_order_no . '</h3>
							<span><i data-feather="chevron-right"></i></span>
						</a>
						<!-- Order Summary -->
						<a href="' . SERVER_ROOT . '/order-details/' . $id . '" class="bg-white px-3 pt-3 d-block">
							<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
								<p class="mb-0">Booking Date</p>
								<p class="mb-0 fw-600">' . $order_date . '</p>
							</div>
							<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
								<p class="mb-0">Payment Type</p>
								<p class="mb-0 fw-600">' . $payment_type . '</p>
							</div>
							<div class="d-flex justify-content-between align-items-center pb-2 fw-600">
								<p class="mb-0">Status</p>
								<p class="mb-0 theme-color fw-600">' . $order_status . '</p>
							</div>
							<div class="d-flex justify-content-between align-items-center">
								<p class="mb-0 font-md fw-bold">Total Amount</p>
								<p class="mb-0 font-md fw-600"><span>' . $net_order_value_display . '</span></p>
							</div>
						</a>
					</div>';
				} else {
					$str .= '<div class="row m-auto"><div class="col-lg-12  bg-white border rounded col-12 mb20">
						<div class="row border-bottom align-items-center">
				            <div class="col-lg-6 p-0 col-6">
				           		<h5 class="m-0 head">Booking ID: ' . $display_order_no . '</h5>
				            </div>
				            <div class="col-lg-6 pt-2 pb-2 ml-auto text-end col-6">
								<a class="btn-main bg-btn1 btn-blue lnk text-uppercase opay" href="order-details/' . $id . '">View Details</a>
								<a style="display:none" class="btn-main bg-btn1 btn-blue lnk text-uppercase odetail ms-2" href="#">Pay now</a>
							</div>
			            </div>
			            <div class="row align-items-center order-dt">
							<div class="col-lg-12 pt-3 pb-3 ps-4 pr-4 col-12">
								<p class="fs-14">Total Amount : <span class="f-semibold">' . $net_order_value_display . '</span></p>
								<p class="fs-14">Quantity : <span class="f-semibold">' . $items . '</span></p>
								<p class="fs-14">Booking date : <span class="f-semibold">' . $order_date . '</span></p>
								<p class="fs-14">Payment Type : <span class="f-semibold">' . $payment_type . '</span></p>
								<p class="fs-14">Status : <span class="f-semibold text-blue">' . $order_status . '</span></p>
			            	</div>
			            </div>
					</div>
				</div>';
				}
			}
			$load_total = $page * $limit;
			$total_products = $total_products;
			$remain_load11 = $total_products - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($remain_load <= 0) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
   <input type='hidden' class='isload' value='true'>
   <input type='hidden' class='nextload_total' value='" . $remain_load . "'>
   ";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\" style=\"    margin-bottom: 100px;margin-top: 20px;\">No Result Found.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			}
		}
		return $str;
	}
	function GetMainCategorySlug($category_id)
	{
		if ($category_id > 0) {
			$obj_model_category = $this->app->load_model("category");
			$obj_model_category->set_fields_to_get(array("category_slug", "id"));
			$rs_state = $obj_model_category->execute("SELECT", false, "", "id=" . $category_id . "", "id DESC limit 0,1");
			return $rs_state[0]['category_slug'];
		}
	}
	function get_price_info_app2022($id, $master_price, $master_mrp)
	{
		$mrp_data = '';
		$dis_html = '';
		if ($master_mrp > $master_price && $master_mrp != 0) {
			$mrp_data = $this->moneyFormatIndiaApp($master_mrp);
			$dis_q = $master_mrp - $master_price;
			$dis_per = $dis_q * 100 / $master_mrp;
			if ((int)$dis_per > 0) {
				$dis_html = (int)$dis_per . '% off';
			}
		}
		$price_data = $this->moneyFormatIndiaApp($master_price);
		$data = array();
		$data['mrp'] = $mrp_data;
		$data['price'] = $price_data;
		$data['discount'] = $dis_html;
		$data['without_gst_price'] = $price_data;
		$data['without_gst_mrp'] = $mrp_data;
		$data['without_gst_disc'] = $dis_html;
		return $data;
	}
	function moneyFormatIndiaApp($number)
	{
		//$num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $number);
		$num = number_format($number, '2', '.', '');
		$num = str_replace(".00", "", $num);
		return $num;
	}
	function check_cart_amount_data($custID)
	{
		$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
		//$obj_model_tmp_cartmini->join_table("product_option", "left", array("type","ship_charge","p_min_qty"), array("product_price_id"=>"id"));
		//$obj_model_tmp_cartmini->join_table("product", "left", array("id","min_qty","group_id","image","name","slug","product_option","ship_charge","cod_status"), array("product_id"=>"id"));
		$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "customer_id='" . $custID . "'");
		if (count($rs_cartmini) > 0) {
			$total_products = count($rs_cartmini);
			$total_amount = 0;
			$total_ship_charge = 0;
			for ($i = 0; $i < count($rs_cartmini); $i++) {
				$flat_ship_charge = 0;
				$total_ship_charge = $total_ship_charge + $flat_ship_charge;
				$total_amount = $total_amount + $rs_cartmini[$i]["cart_line_total"];
			}
		} else {
			$total_products = 0;
			$total_amount = 0;
			$total_ship_charge = 0;
		}
		$data = array();
		$data['total_products'] = $total_products;
		$data['total_amount'] = $total_amount;
		$data['total_ship_charge'] = $total_ship_charge;
		return $data;
	}
	function generateToken($length)
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $characters[rand(0, $charactersLength - 1)];
		}
		if (strlen($key) != $length) {
			$this->generateToken($length);
		} else if (strlen($key) == $length) {
			if ($key != '') {
				$obj_model_user = $this->app->load_model("customer");
				$rs_user = $obj_model_user->execute("SELECT", false, "SELECT api_token FROM customer WHERE api_token='" . $key . "'", "");
				if (count($rs_user) > 0) {
					$this->generateToken($length);
				} else {
					return $key;
				}
			} else {
				$this->generateToken($length);
			}
		} else {
			$this->generateToken($length);
		}
	}
	function get_API_id($param = [])
	{
		$table = $param['table'];
		$get_column = $param['get_column'];
		$value = $param['value'];
		$obj_model_table = $this->app->load_model($table);
		$check_data = $obj_model_table->execute("SELECT", false, "", "id='" . $value . "' and status!='Trash'", "");
		if (count($check_data) > 0) {
			return $check_data[0]['' . $get_column . ''];
		} else {
			return '';
		}
	}
	function load_blogs($data, $limit, $category_id, $tag_id, $serach_keyword, $total_blogs, $sort_by)
	{
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		if ($category_id > 0) {
			$catCond = " and category_id='" . $category_id . "'";
		} else {
			$catCond = "";
		}
		if ($tag_id > 0) {
			$tagCond = " and FIND_IN_SET (" . $tag_id . ",tag_ids)";
		} else {
			$tagCond = "";
		}
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = " and (blog.name LIKE '$q%' or blog.name LIKE '%$q%' or blog.name LIKE '%$q')";
		} else {
			$g_search_query = "";
		}
		if ($sort_by == 'latest') {
			$order_by = "STR_TO_DATE(blog.entry_date_time, '%d-%m-%Y %H:%i:%s') DESC";
		} elseif ($sort_by == 'old') {
			$order_by = "STR_TO_DATE(blog.entry_date_time, '%d-%m-%Y %H:%i:%s') ASC";
		} else {
			$order_by = 'blog.sort_order ASC';
		}
		//echo $ingradiant_cond;
		$filter_cond = $catCond . $tagCond;
		$obj_model_all_data = $this->app->load_model("blog");
		$rs_total = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount,blog.*,blog_category.* from blog  LEFT JOIN blog_category AS blog_category ON(blog_category.id=blog.category_id) where blog.id!=0 and blog.status='Active' " . $filter_cond . " " . $g_search_query . "", "");
		$total_blogs = $rs_total[0]['allcount'];
		$obj_model_all = $this->app->load_model("blog");
		$obj_model_all->join_table("blog_category", "left", array("name", "slug"), array("category_id" => "id"));
		$records = $obj_model_all->execute("SELECT", false, "", "blog.status='Active' " . $filter_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "", "blog.id");
		$str = '';
		if (count($records) > 0) {
			$array_bg = array('dg-bg2', 'bg-gradient12');
			$array_bg_rand = array_rand($array_bg, 2);
			foreach ($records as $blog) {
				$id = $blog['id'];
				$blog_category_name = $blog['blog_category_name'];
				$name = $blog['name'];
				$short_info = $blog['short_info'];
				$folder = $blog['folder'];
				$image = $blog['image'];
				$blogImage = $this->get_image_path($image, 'blog/' . $folder . '/', 'large');
				$date = $blog['entry_date_time'];
				$old_date = date_create($date);
				$new_date = date_format($old_date, "M d, Y");
				$blog_category_slug = $blog['blog_category_slug'];
				$slug = $blog['slug'];
				$category_slug = 'blog/category/' . $blog_category_slug . '';
				$detail_slug = 'blog/detail/' . $slug . '';
				$str .= '<div class="col-lg-6 mt60">
								<div class="single-blog-post- shdo">
									<div class="single-blog-img-">
										<a href="' . SERVER_ROOT . '/' . $detail_slug . '"><img src="' . $blogImage . '" alt="" class="img-fluid"></a>
										<div class="entry-blog-post ' . $array_bg[$array_bg_rand[0]] . '">
											<span class="bypost-"><a href="' . SERVER_ROOT . '/' . $category_slug . '"><i class="fas fa-tag"></i> ' . $blog_category_name . '</a></span>
											<span class="posted-on-">
												<a href="#"><i class="fas fa-clock"></i> ' . $new_date . '</a>
											</span>
										</div>
									</div>
									<div class="blog-content-tt">
										<div class="single-blog-info-">
											<h4><a href="' . SERVER_ROOT . '/' . $detail_slug . '">' . $name . '</a></h4>
											<p>' . $short_info . '</p>
										</div>
									</div>
								</div>
							</div>';
			}
			$load_total = $page * $limit;
			$total_blogs = $total_blogs;
			$remain_load11 = $total_blogs - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_blogs) . "'>";
			if ($remain_load <= 0) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
				<input type='hidden' class='isload' value='true'>
				<input type='hidden' class='nextload_total' value='" . $remain_load . "'>
				";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_blogs) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\" style=\"    margin-bottom: 100px;margin-top: 20px;\">No Result Found.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\"></p>";
			}
		}
		return $str;
	}
	function load_events($data, $limit, $category_id, $tag_id, $serach_keyword, $total_events)
	{
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		$order_by = 'event.sort_order ASC';
		if ($category_id > 0) {
			$catCond = " and category_id='" . $category_id . "'";
		} else {
			$catCond = "";
		}
		if ($tag_id > 0) {
			$tagCond = " and FIND_IN_SET (" . $tag_id . ",tag_ids)";
		} else {
			$tagCond = "";
		}
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = " and (event.name LIKE '$q%' or event.name LIKE '%$q%' or event.name LIKE '%$q')";
		} else {
			$g_search_query = "";
		}
		//echo $ingradiant_cond;
		$filter_cond = $catCond . $tagCond;
		$obj_model_all_data = $this->app->load_model("event");
		$rs_total = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount,event.*,event_category.* from event  LEFT JOIN event_category AS event_category ON(event_category.id=event.category_id) where event.id!=0 and event.status='Active' " . $filter_cond . " " . $g_search_query . "", "");
		$total_events = $rs_total[0]['allcount'];
		$obj_model_all = $this->app->load_model("event");
		$obj_model_all->join_table("event_category", "left", array("name", "slug"), array("category_id" => "id"));
		$records = $obj_model_all->execute("SELECT", false, "", "event.status='Active' " . $filter_cond . " " . $g_search_query . "", "" . $order_by . " limit " . $start . "," . $limit . "", "event.id");
		$str = '';
		if (count($records) > 0) {
			$array_bg = array('dg-bg2', 'bg-gradient12');
			$array_bg_rand = array_rand($array_bg, 2);
			foreach ($records as $event) {
				$id = $event['id'];
				$blog_category_name = $event['event_category_name'];
				$name = $event['name'];
				$short_info = $event['short_info'];
				$folder = $event['folder'];
				$image = $event['image'];
				$eventImage = $this->get_image_path($image, 'event/' . $folder . '/', 'large');
				$date = $event['entry_date_time'];
				$old_date = date_create($date);
				$new_date = date_format($old_date, "M d, Y");
				$event_category_slug = $event['event_category_slug'];
				$slug = $event['slug'];
				$category_slug = 'news-and-events/category/' . $event_category_slug;
				$detail_slug = 'news-and-events/detail/' . $slug;
				$str .= '<div class="col-lg-4 mt60">
								<div class="single-blog-post- shdo">
									<div class="single-blog-img-">
										<a href="' . SERVER_ROOT . '/' . $detail_slug . '"><img src="' . $eventImage . '" alt="" class="img-fluid"></a>
										<div class="entry-blog-post ' . $array_bg[$array_bg_rand[0]] . ' d-none">
											<span class="bypost-"><a href="' . SERVER_ROOT . '/' . $category_slug . '"><i class="fas fa-tag"></i> ' . $blog_category_name . '</a></span>
											<span class="posted-on-">
												<a href="javascript:void(0)"><i class="fas fa-clock"></i> ' . $new_date . '</a>
											</span>
										</div>
									</div>
									<div class="blog-content-tt">
										<div class="single-blog-info-">
											<h4><a href="' . SERVER_ROOT . '/' . $detail_slug . '">' . $name . '</a></h4>
											<p>' . $short_info . '</p>
										</div>
									</div>
								</div>
							</div>';
			}
			$load_total = $page * $limit;
			$total_events = $total_events;
			$remain_load11 = $total_events - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_events) . "'>";
			if ($remain_load <= 0) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
				<input type='hidden' class='isload' value='true'>
				<input type='hidden' class='nextload_total' value='" . $remain_load . "'>
				";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_events) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\" style=\"    margin-bottom: 100px;margin-top: 20px;\">No Result Found.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-blogs loaderclass text-center mt-5\"></p>";
			}
		}
		return $str;
	}
	function packagePrice($id, $price, $mrp)
	{
		$html = '<span class="float-end-removed">';
		if ($price > 0) {
			$html .= '' . $this->moneyFormatIndia($price) . ' ';
		}
		if ($mrp > 0 && $mrp > $price) {
			$html .= '<del>' . $this->moneyFormatIndia($mrp) . '</del>';
		}
		$html .= '</span>';
		return $html;
	}
	function detailpackagePrice($id, $price, $mrp)
	{
		$html = '<h5><span class="">';
		if ($price > 0) {
			$html .= '' . $this->moneyFormatIndia($price) . ' ';
		}
		if ($mrp > 0 && $mrp > $price) {
			$html .= '<del>' . $this->moneyFormatIndia($mrp) . '</del>';
		}
		$html .= '</span>';
		if ($mrp > 0 && $mrp > $price) {
			$dis = $mrp - $price;
			$dis_per = (int)((100 * $dis) / $mrp);
			$html .= '<span class="percnt"> ' . $dis_per . ' % OFF</span>';
		}
		$html .= '</h5>';
		return $html;
	}
	function mpackagePrice($id, $price, $mrp)
	{
		$html = '<div class="d-flex align-items-center">';
		if ($price > 0) {
			$html .= '<p class="font-md fw-bold mb-0">' . $this->moneyFormatIndia($price) . '</p> ';
		}
		if ($mrp > 0 && $mrp > $price) {
			$html .= '<p class="cancle-rupee font-sm fw-bold ms-3 mb-0">' . $this->moneyFormatIndia($mrp) . '</p>';
		}
		if ($mrp > 0 && $mrp > $price) {
			$dis = $mrp - $price;
			$dis_per = (int)((100 * $dis) / $mrp);
			$html .= '<p class="font-sm fw-bold ms-3 th-color-green mb-0">' . $dis_per . ' % OFF</p>';
		}
		$html .= '</div>';
		return $html;
	}
	function get_category_name($ids)
	{
		$obj_model_item_ca = $this->app->load_model("item_category");
		$rs_item_ca = $obj_model_item_ca->execute("SELECT", false, "", "FIND_IN_SET(id,'" . $ids . "')", "");
		$category_name_array = [];
		for ($i = 0; $i <= count($rs_item_ca); $i++) {
			if (!empty($rs_item_ca[$i]['name'])) {
				$category_name_array[] = $rs_item_ca[$i]['name'];
			}
		}
		$category_names = implode(',', $category_name_array);
		return $category_names;
	}
	function get_departments_name($ids)
	{
		$obj_model_department = $this->app->load_model("item_department");
		$rs_department = $obj_model_department->execute("SELECT", false, "", "FIND_IN_SET(id,'" . $ids . "')", "");
		$department_array = [];
		for ($i = 0; $i <= count($rs_department); $i++) {
			if (!empty($rs_department[$i]['name'])) {
				$department_array[] = $rs_department[$i]['name'];
			}
		}
		$department = implode(',', $department_array);
		return $department;
	}
	function get_diseases_name($ids)
	{
		$obj_model_diseases = $this->app->load_model("item_diseases");
		$rs_diseases = $obj_model_diseases->execute("SELECT", false, "", "FIND_IN_SET(id,'" . $ids . "')", "");
		$diseases_array = [];
		for ($i = 0; $i <= count($rs_diseases); $i++) {
			if (!empty($rs_diseases[$i]['name'])) {
				$diseases_array[] = $rs_diseases[$i]['name'];
			}
		}
		$diseases = implode(',', $diseases_array);
		return $diseases;
	}
	function get_certificate_name($ids)
	{
		$obj_model_certificate = $this->app->load_model("item_certificate");
		$rs_certificate = $obj_model_certificate->execute("SELECT", false, "", "FIND_IN_SET(id,'" . $ids . "')", "");
		$certificate_array = [];
		for ($i = 0; $i <= count($rs_certificate); $i++) {
			if (!empty($rs_certificate[$i]['name'])) {
				$certificate_array[] = $rs_certificate[$i]['name'];
			}
		}
		$certificate = implode(',', $certificate_array);
		return $certificate;
	}
	function get_item_name($id)
	{
		$obj_model_item_type = $this->app->load_model("item_type");
		$rs_item_type = $obj_model_item_type->execute("SELECT", false, "", "id='" . $id . "'", "");
		$item_type = $rs_item_type[0]['name'];
		return $item_type;
	}
	function getCloudFareCaptchaVerify($token = null)
	{
		$secretKey = '0x4AAAAAAAbKtpmPV8PzAw4pMOrmEkFlttQ';
		if (empty($token)) {
			//die('Turnstile verification failed: no token provided.');
			return ["status" => 0, "message" => "Cloudfare captcha not verified. Please refesh page and try again."];
		}
		$url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
		$data = [
			'secret' => $secretKey,
			'response' => $token,
		];
		$options = [
			'http' => [
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			],
		];
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) {
			return ["status" => 0, "message" => "Captcha not verified. Please refesh page and try again."];
		}
		$resultData = json_decode($result, true);
		if ($resultData['success']) {
			return ["status" => 1, "message" => "verfied"];
		} else {
			//die('captcha verification failed: ' . $resultData['error-codes'][0]);
			return ["status" => false, "message" => 'Refresh page and try again. Captcha verification failed: ' . $resultData['error-codes'][0]];
		}
	}
	function load_packages($data)
	{
		$limit = $data['limit'];
		$type_ids = $data['type_ids'];
		$dieses_ids = $data['dieses_ids'];
		$total_data = $data['total_data'];
		$serach_keyword = $data['search_data'];
		$category_ids = $data['category_ids'];
		$sort_by = $data['sort_by'];
		$city_id = $data['city_id'];
		$department_id = $data['department_id'];
		$pageType = $data['pageType'];
		if (!in_array($_SESSION['getId'], explode(',', $category_ids))) {
			$_SESSION['getId'] = '';
			$_SESSION['getName'] = '';
			$_SESSION['getType'] = '';
		}
		$page = $data['page'];
		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}
		$sort_cond = "item.sort_order ASC";
		if ($sort_by != '') {
			if ($sort_by == 'name_a_z') {
				$sort_cond = "item.name ASC";
			} else if ($sort_by == 'name_z_a') {
				$sort_cond = "item.name DESC";
			} else if ($sort_by == 'price_l_h') {
				$sort_cond = "item_price.price ASC";
			} else if ($sort_by == 'price_h_l') {
				$sort_cond = "item_price.price DESC";
			}
		}
		$g_search_query = "";
		if ($serach_keyword != '') {
			$q = $serach_keyword;
			$g_search_query = " and (item.name LIKE '$q%' or item.name LIKE '%$q%' or item.name LIKE '%$q')";
		}
		$city_cond = "";
		if ($city_id != '') {
			$city_cond = " and FIND_IN_SET ('" . $city_id . "',item.city_ids) and item_price.city_id='" . $city_id . "'";
		}
		$department_cond = "";
		if ($department_id != '') {
			$department_cond = " and FIND_IN_SET ('" . $department_id . "',item_other_data.item_department_ids)";
		}
		$type_cond = "";
		if ($type_ids != '') {
			$explodeItem = explode(',', $type_ids);
			$cond = array();
			for ($i = 0; $i < count($explodeItem); $i++) {
				if ($explodeItem[$i] != '') {
					$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_type_id)";
				}
			}
			$type_cond = " and (" . implode(" OR ", $cond) . ")";
		}
		$dieses_cond = "";
		if ($dieses_ids != '') {
			$explodeItem = explode(',', $dieses_ids);
			$cond = array();
			for ($i = 0; $i < count($explodeItem); $i++) {
				if ($explodeItem[$i] != '') {
					$cond[] = " FIND_IN_SET ('" . $explodeItem[$i] . "',item_other_data.item_diseases_ids)";
				}
			}
			$dieses_cond = " and (" . implode(" OR ", $cond) . ")";
		}
		$cat_cond = "";
		if ($category_ids != '') {
			$explodeItem = explode(',', $category_ids);
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
		$total_products = $rs_total[0]['allcount'];
		$obj_model_all = $this->app->load_model("item");
		$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id" => "item_id"));
		$obj_model_all->join_table("item_other_data", "left", array(), array("id" => "item_id"));
		$obj_model_all->join_table("item_price", "left", array(), array("id" => "item_id"));
		$records = $obj_model_all->execute("SELECT", false, "", "item.id!=0 and item.status='Active'  " . $master_con . "", "" . $sort_cond . " limit " . $start . "," . $limit . "", "");
		$str = '';
		//$data = $con->query($sql);
		if (count($records) > 0) {
			foreach ($records as $item) {
				$id = $item['id'];
				$item_price_id = $item['item_price_id'];
				$slug = $item['slug'];
				$name = $item['name'];
				$test_count = $item['test_count'];
				$image = $item['image'];
				$folder = $item['folder'];
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
				$price_html = $this->packagePrice($id, $price, $mrp);
				$url = 'tests/' . $item['slug'] . '/' . $_SESSION['citySlug'];
				$description1 = strip_tags($item['item_other_data_description']);
				$description_li = '';
				if ($description1 != '') {
					$description = $this->string_truncate($description1, 100);
					$description_li = '<li><span>' . $description . '</span></li>';
				}
				$test_parameters_html = strip_tags($item['item_description_test_parameters']);
				if ($test_parameters_html != '') {
					$test_parameters_html = '<li><span>' . $this->string_truncate($test_parameters_html, 100) . '</span></li>';
				}
				$test_parameters_html = '';
				if ($pageType == 'Search' || $pageType == 'Diseases' || $pageType == 'Category' || $pageType == 'Popular Package' || $pageType == 'Popular Test') {
					$masterClass = "col-lg-3 col-md-4 col-12 position-relative mb30 packageDiv";
				} else {
					$masterClass = "col-lg-4 col-md-6 col-12 position-relative mb30 packageDiv";
				}
				if (in_array($id, $_SESSION['cartitemIds'])) {
					$Book_Now = '<a href="' . $url . '" class="btn-main bg-btn1 btn-green lnk wow fadeInUp text-uppercase book-now">Added <span class="circle"></span></a>';
					$cartbtn = '<a href="cart.html" class="add_to_cart btncart btncart-green float-end"><img src="images/icon-cart.png" alt="" /> <span class="circle"></span></a>';
				} else {
					$Book_Now = '<a href="' . $url . '" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase book-now">Book Now <span class="circle"></span></a>';
					$cartbtn = '<a href="javascript:void(0)" data-item_price_id="' . $item_price_id . '" data-item_id="' . $id . '" class="add_to_cart btncart float-end"><img src="images/icon-cart.png" alt="" /> <span class="circle"></span></a>';
				}
				if ($data['site'] == 'msite') {
					if (in_array($id, $_SESSION['cartitemIds'])) {
						$cartbtn = '<a class="add_to_cart btncart btn th-btn-green text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Added</a>
					';
					} else {
						$cartbtn = '<a href="javascript:void(0)" data-item_price_id="' . $item_price_id . '" data-item_id="' . $id . '" class="add_to_cart btncart btn th-btn-solid-sm text-white btn-md font-sm d-flex align-items-center"> <img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1">Add</a>';
					}
					$price_html = $this->mpackagePrice($id, $price, $mrp);
					$str .= '<div class="health-package-list MDRC-TEST">
					<a href="' . M_SERVER_ROOT . '/' . $url . '" class="filter font-md theme-color fw-bold mb-2" type="button">' . $name . '</a>
					<ul class="packageul">
						<li>Total no.of Tests : ' . $test_count . '</li>
						' . $description_li . '
						' . $test_parameters_html . '
					</ul>
					<div class="d-flex align-items-center justify-content-between">
						' . $price_html . '
						<div>
						' . $cartbtn . '
						</div>
					</div>
				</div>';
				} else {
					$str .= '<div class="' . $masterClass . '">
					<div class="pricing-table">
						<div class="inner-table">
							<a class="d-inline-block w-100" href="' . $url . '"><span class="title">' . $name . '</span></a>
							<ul class="list-style-  disc-list mt-3 mb30 pb5">
								<li><span>Total no.of Tests : ' . $test_count . '</span></li>
								' . $description_li . '
								' . $test_parameters_html . '
							</ul>
							<div class="d-info d-inline-block w-100">
								<h4>' . $price_html . '</h4>
								' . $Book_Now . '
								' . $cartbtn . '
							</div>
						</div>
					</div>
				</div>';
				}
			}
			$load_total = $page * $limit;
			$total_products = $total_products;
			$remain_load11 = $total_products - $load_total;
			$remain_load = (int)$remain_load11;
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($remain_load <= 0) {
				//$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\">Showing ".$total_products." out of ".$total_products." items</p>";
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			} else {
				$str .= "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'>
	   <input type='hidden' class='isload' value='true'>
	   <input type='hidden' class='nextload_total' value='" . $remain_load . "'>
	   ";
			}
		} else {
			$str .= "<input type='hidden' class='total_datas' value='" . ($total_products) . "'>";
			if ($page == 1) {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass text-center text-bold\" style=\"    margin-bottom: 100px;margin-top: 20px;\"><img src=\"images/img-nodata-found.svg\" style=\"width: 280px;\"/><br/>Currently, we do not provide service for the chosen city.</p>";
			} else {
				$str .= "<input type='hidden' class='isload' value='false'><p class=\"no-more-products loaderclass\"></p>";
			}
		}
		return $str;
	}
	function getAge($dateOfBirth)
	{
		$dob = new DateTime($dateOfBirth);
		$today = new DateTime('today');
		$age = $dob->diff($today)->y;
		return $age;
	}
	function razorpay_create_order($field_list, $url)
	{
		$key = RAZOR_PAY_KEY;
		$secret = RAZOR_PAY_SECRET;
		$field_list = json_encode($field_list);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_USERPWD, "TESTkingclean:94ee0cd7d4ccec219ee97255a9d8cc6912031d01");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $field_list);
		curl_setopt($ch, CURLOPT_USERPWD, $key . ':' . $secret);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = mdrc_curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);
		$razor_id = $data['id'];
		//$result=json_decode($response, true);
		return $razor_id;
	}
	function send_push_notifaction($data, $androidToken)
	{
		$notifData = [
			'title' => $data['title'] ?? '',
			'body' => $data['message'] ?? '',
			'image' => $data['image'] ?? '',
			'type' => $data['type'] ?? ''
		];
		$serviceAccountPath = ABS_PATH . '/fcm/service_account.json';
		$serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
		$now = time();
		$header = ['alg' => 'RS256', 'typ' => 'JWT'];
		$claims = [
			'iss' => $serviceAccount['client_email'],
			'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
			'aud' => 'https://oauth2.googleapis.com/token',
			'iat' => $now,
			'exp' => $now + 3600,
		];
		$base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
		$base64UrlClaims = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');
		$signatureInput = $base64UrlHeader . '.' . $base64UrlClaims;
		$privateKey = $serviceAccount['private_key'];
		$signature = '';
		openssl_sign($signatureInput, $signature, $privateKey, 'sha256');
		$base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
		$jwt = $base64UrlHeader . '.' . $base64UrlClaims . '.' . $base64UrlSignature;
		$tokenRequestData = http_build_query([
			'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
			'assertion' => $jwt,
		]);
		$ch = curl_init('https://oauth2.googleapis.com/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $tokenRequestData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/x-www-form-urlencoded',
		]);
		$response = mdrc_curl_exec($ch);
		curl_close($ch);
		$tokenResponse = json_decode($response, true);
		if (!isset($tokenResponse['access_token'])) {
			die("Error fetching access token:\n$response");
		}
		$accessToken = $tokenResponse['access_token'];
		$fcmUrl = 'https://fcm.googleapis.com/v1/projects/' . $serviceAccount['project_id'] . '/messages:send';
		if (!empty($androidToken)) {
			$notification = [
				'message' => [
					'token' => $androidToken,
					'data' => $notifData,
					'android' => [
						'notification' => [
							'sound' => $data['sound'],
						]
					],
				],
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $fcmUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Authorization: Bearer ' . $accessToken,
				'Content-Type: application/json',
			]);
			$result = mdrc_curl_exec($ch);
			//echo $result;exit;
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
		}
	}
}
