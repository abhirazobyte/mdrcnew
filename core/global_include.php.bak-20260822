<?
class global_include
{
	private $settings = array();
	private $app;
	private $initialized = false;
	private $system_acl_permission = array();
	public function __construct()
	{
		$this->app = &app::get_instance();
	}
	public function initalize()
	{
		if(!$this->initialized)
		{
			$this->initialized=true;
			if(VIR_DIR=="admin/")
			{
				mysqli_set_charset($this->app->set_db_conn(),'utf-8');
				/*$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$new_url=str_replace("https://","",$url);
				$new_url=str_replace("http://","",$new_url);
				$new_url=str_replace("www.","",$new_url);
				$new_url=str_replace("WWW.","",$new_url);
				if (strpos($url, "http://")!==false)
				{
					$this->app->redirect("https://www.".$new_url);
				}
				if (strpos($url, "www")!==false)
				{
				}
				else
				{
					$this->app->redirect("https://www.".$new_url);
				}*/
				setcookie('Grocery_page', $this->app->getCurrentView(), time() + (86400 * 30), "/admin/");
				$this->app->setTitle(DEFAULT_TITLE." - Administrator");
				if($this->app->getCurrentView()!="forgot_password")
				{
					if($this->app->getCurrentView()!="default" && (empty($_SESSION["admin"])))
					{
						$this->app->redirect($this->app->root_relative."admin/index.php");
					}
					else if($this->app->getCurrentView()=="default" && (isset($_SESSION["admin"])) && $this->app->getCurrentAction()!="do_logout")
					{
						$this->app->redirect($this->app->root_relative."admin/index.php?view=home");
					}
					else
					{
						if(empty($_SESSION['records']))
						{
							$_SESSION['records'] = ($this->app->getPostVar("record_per_page")==NULL?10:$this->app->getPostVar("record_per_page"));
						}
						else
						{
							if($this->app->getPostVar("record_per_page") != NULL)
							{
								$_SESSION['records'] = $this->app->getPostVar("record_per_page");
							}
					}
					$rs  = array();
					$val = 5;
					for($i=0;$i<10;$i++)
					{
						$rs[$val] = $val;
						$val = $val+5;
					}
					$this->app->assign("record", $rs);
					$this->app->assign("field_record_per_page", $_SESSION['records']);
				 }
				}
				$new_page=$this->app->getCurrentView();
				if($_SESSION['search_by']!='' && $_SESSION['search_keyword']!='' && $_SESSION['current_page']=='')
				{
							$_SESSION['current_page']=$this->app->getCurrentView();
				}
				if($_SESSION['current_page']!=$new_page)
				{
					$_SESSION['current_page']='';
					//$_SESSION['search_start_date']='';
					//$_SESSION['search_end_date']='';
					$_SESSION['search_category']='';
					$_SESSION['search_brand']='';
					$_SESSION['search_type']='';
					$_SESSION['search_del_date']='';
					$_SESSION['search_delivery_boy']='';
				}
				$this_page=$this->app->getCurrentView();
				$obj_model_admin = $this->app->load_model("admin");
				$rs_admin = $obj_model_admin->execute("SELECT", false, "", "id='".$_SESSION['admin']."'");
				$this->app->assign("rs_admin",$rs_admin[0]);
				if($_SESSION['admin']!='1' && $this->app->getCurrentView()=="account_list")
				{
					$this->app->redirect($this->app->root_relative."admin/index.php?view=home");
				}
				$obj_model_generel_settings= $this->app->load_model("generel_settings");
				$rs_gs = $obj_model_generel_settings->execute("SELECT", false, "", "");
				$this->app->assign("gs",$rs_gs[0]);
			}

			if(VIR_DIR=="m33/")
			{
				$page_name=$_SERVER[REQUEST_URI];
				$page_name=substr($page_name, 1);

				if($page_name=='index.html' || $page_name=='index.php'){
					$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
				}else{
					$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				}

				$new_url=str_replace("https://","",$url);
				$new_url=str_replace("http://","",$new_url);
				$new_url=str_replace("www.","",$new_url);
				$new_url=str_replace("WWW.","",$new_url);
				if($page_name=='index.html' || $page_name=='index.php'){
					$this->app->redirect("https://www.".$new_url);
				}
				if (strpos($url, "http://")!==false){
					$this->app->redirect("https://www.".$new_url);
				}
				
				if (strpos($url, "www")!==false){}
				else{
					$this->app->redirect("https://www.".$new_url);
				}

				if($_SESSION['cityID']=='' && $this->app->getGetVar("city")!='')
				{
					setcookie("MDRCCitySelect", "Yes", time() + 2 * 24 * 60 * 60,"/","mdrcindia.com",true); 
					$obj_model_tble=$this->app->load_model("city");
					$rs_city = $obj_model_tble->execute("SELECT",false,"","slug='".$this->app->getGetVar("city")."' and status='Active'","");
					if(count($rs_city)>0)
					{
						$_SESSION['cityID']=$rs_city[0]['id'];
						$_SESSION['cityName']=$rs_city[0]['name'];
						$_SESSION['cityImage']=$rs_city[0]['image'];
						$_SESSION['cityApiStateId']=$rs_city[0]['api_state_id'];
						$_SESSION['cityApiCityId']=$rs_city[0]['api_city_id'];	
						$_SESSION['cityStateID']=$rs_city[0]['state_id'];
						$_SESSION['citySlug']=$rs_city[0]['slug'];

						if($_SESSION['MDRCCustID']>0){
							$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";								
						}else{
							$customerCond="customer_cart.session_id='".session_id()."'";						
						}
						$obj_model_tmp_cart_delete = $this->app->load_model("customer_cart");
						$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
					}
				}

				if($_SESSION['cityID']!='' && $this->app->getGetVar("city")!='')
				{
					if($_SESSION['citySlug']!=$this->app->getGetVar("city"))
					{
						setcookie("MDRCCitySelect", "Yes", time() + 2 * 24 * 60 * 60,"/","mdrcindia.com",true); 
						$obj_model_tble=$this->app->load_model("city");
						$rs_city = $obj_model_tble->execute("SELECT",false,"","slug='".$this->app->getGetVar("city")."' and status='Active'","");
						if(count($rs_city)>0)
						{						
							$_SESSION['cityID']=$rs_city[0]['id'];
							$_SESSION['cityName']=$rs_city[0]['name'];
							$_SESSION['cityImage']=$rs_city[0]['image'];
							$_SESSION['cityApiStateId']=$rs_city[0]['api_state_id'];	
							$_SESSION['cityApiCityId']=$rs_city[0]['api_city_id'];	
							$_SESSION['cityStateID']=$rs_city[0]['state_id'];
							$_SESSION['citySlug']=$rs_city[0]['slug'];
							$_SESSION['cityPhone']=$rs_city[0]['phone'];

							if($_SESSION['MDRCCustID']>0){
								$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";								
							}else{
								$customerCond="customer_cart.session_id='".session_id()."'";						
							}
							$obj_model_tmp_cart_delete = $this->app->load_model("customer_cart");
							$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
						}
					}
				}

				$obj_model_city=$this->app->load_model('city');
				$rs_gs_city=$obj_model_city->execute("SELECT",false,"","status='Active'","sort_order ASC");
				$this->app->assign("rs_gs_city", $rs_gs_city);
				if($_SESSION['cityID']<=0)
				{
					//Default Set City
					$api_state_id=$rs_gs_city[0]['api_state_id'];
					$_SESSION['cityID']=$rs_gs_city[0]['id'];
					$_SESSION['cityName']=$rs_gs_city[0]['name'];
					$_SESSION['cityImage']=$rs_gs_city[0]['image'];
					$_SESSION['cityApiStateId']=$rs_gs_city[0]['api_state_id'];
					$_SESSION['cityApiCityId']=$rs_gs_city[0]['api_city_id'];
					$_SESSION['cityStateID']=$rs_gs_city[0]['state_id'];
					$_SESSION['citySlug']=$rs_gs_city[0]['slug'];
					$_SESSION['cityPhone']=$rs_gs_city[0]['phone'];
				}

				//for cart
				$_SESSION['cart_vendor_id']='';
				$_SESSION['cart_weight']=0;
				$app_price=0;
				$cart_weight=0;
				$_SESSION['sub_total']=0;
				$_SESSION['oshopping_CART']=array();
				if($_SESSION['MDRCCustID']>0){
					$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
				}else{
					$customerCond="customer_cart.session_id='".session_id()."'";
				}
				$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
				$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
				$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
				$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
				$cartitemIds=array();
				if(count($rs_cartmini)<=0){ $_SESSION['HomeCollection']=''; }
				if(count($rs_cartmini)>0)
				{
					$_SESSION['cart_vendor_id']=0;
					$this->app->assign("rs_cartmini", $rs_cartmini);
					$_SESSION['oshopping_CART']=$rs_cartmini;
					$depIDs=array();
					foreach($rs_cartmini as $item)
					{
						$depIDs[]=$item['cart_item_department_ids'];
						$product_id=$item["cart_item_id"];
						$product_price_id=$item["cart_item_price_id"];
						$product_quantity=$item["cart_qty"];
						$app_price+=($item["cart_item_price"]*$product_quantity);
						$weight=$item['cart_product_opt_weight']*$item["cart_qty"];
						$cart_weight= $cart_weight+$weight;
						$cartitemIds[]=$item["cart_item_id"];
					}
					$_SESSION['cart_weight']=$cart_weight;
					$_SESSION['sub_total']=number_format($app_price,'2','.','');
					$final_ids=array_unique($depIDs);
					$depID=implode(',',$final_ids);
					$_SESSION['checkoutCod']='Yes';
					$_SESSION['checkoutOnline']='';
					if($depID==2) {
						$_SESSION['checkoutCod']='Yes';
						$_SESSION['checkoutOnline']='Yes';
					} else if($depID==1) {
						$_SESSION['checkoutOnline']='Yes';
					} else {
						$_SESSION['checkoutOnline']='Yes';
					}
					$obj_model_tble = $this->app->load_model("item_department");
					$rs_check_home_collection= $obj_model_tble->execute("SELECT", false, "", "id IN (".$depID.") and status='Active' and home_collection='Yes'");
					if(count($rs_check_home_collection)>0)
					{
						if($_SESSION['HomeCollection']=='') {
						$_SESSION['HomeCollectionModalShow']='Yes';
						}
					}
				}
				$_SESSION['cartitemIds']=$cartitemIds;
				//for cart end

				//for customer login
				if($_SESSION['MDRCCustID']>0 || $_COOKIE['MDRCToken']!='')
				{
					if($_SESSION['MDRCCustID']>0 && $_COOKIE['MDRCToken']!='')
					{
						$cond="(api_token='".$_COOKIE['MDRCToken']."' and id='".$_SESSION['MDRCCustID']."')";
					}
					else
					{
						$cond="(api_token='".$_COOKIE['MDRCToken']."')";
					}
					$obj_model_check_cookie=$this->app->load_model('customer');
					$rs_customer=$obj_model_check_cookie->execute("SELECT",false,"","".$cond." and status='Active'");
					if(count($rs_customer)<=0)
					{
						$_SESSION['MDRCCustID']='';
						$_SESSION['MDRCCustFirstName']='';
						$_SESSION['MDRCCustLastName']='';
						$_SESSION['MDRCCustEmail']='';
						$_SESSION['MDRCCustPhone']='';
						$_SESSION['MDRCCustImage']='';
						$_SESSION['MDRCCustWallet']='';
						setcookie('MDRCToken', '', -1, "/");
					}
					if(count($rs_customer)>0)
					{
						$_SESSION['MDRCCustID']=$rs_customer[0]['id'];
						$_SESSION['MDRCCustFirstName']=$rs_customer[0]['name'];
						$_SESSION['MDRCCustLastName']=$rs_customer[0]['last_name'];
						$_SESSION['MDRCCustEmail']=$rs_customer[0]['email'];
						$_SESSION['MDRCCustPhone']=$rs_customer[0]['phone'];
						$_SESSION['MDRCCustImage']=$rs_customer[0]['image'];
						$_SESSION['MDRCCustWallet']=$rs_customer[0]['wallet'];
						if($_SESSION['MDRCCustFirstName']=='')
						{
							$_SESSION['MDRCCustFirstName']='Guest';
						}
					}
					$this->app->assign("rs_customer", $rs_customer[0]);
				}
				//for customer login end

				mysqli_set_charset($this->app->set_db_conn(),'utf-8');

			}

			if(VIR_DIR=="" || VIR_DIR=="m/")
			{
				$fullURL = "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
				if($fullURL==SERVER_ROOT.'/radiology')
				{
					$this->app->redirect(SERVER_ROOT."/modern-imaging");
				}
				if($fullURL==SERVER_ROOT.'/pathology')
				{
					$this->app->redirect(SERVER_ROOT."/modern-lab");
				}

				$page_name=$_SERVER[REQUEST_URI];
				$page_name=substr($page_name, 1);

				if($page_name=='index.html' || $page_name=='index.php' || $page_name=='index.php/')
				{
					$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
				}
				else
				{
					$url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				}

				$new_url=str_replace("https://","",$url);
				$new_url=str_replace("http://","",$new_url);
				$new_url=str_replace("www.","",$new_url);
				$new_url=str_replace("WWW.","",$new_url);
				if($page_name=='index.html' || $page_name=='index.php' || $page_name=='index.php/')
				{
					$this->app->redirect("https://www.".$new_url);
				}
				if (strpos($url, "http://")!==false)
				{
					$this->app->redirect("https://www.".$new_url);
				}
				if (strpos($url, "www")!==false)
				{
				}
				else
				{
					$this->app->redirect("https://www.".$new_url);
				}

				//------------
				if($_SESSION['cityID']=='' && $this->app->getGetVar("city")!='')
				{
					setcookie("MDRCCitySelect", "Yes", time() + 2 * 24 * 60 * 60,"/","mdrcindia.com",true); 
					$obj_model_tble=$this->app->load_model("city");
					$rs_city = $obj_model_tble->execute("SELECT",false,"","slug='".$this->app->getGetVar("city")."' and status='Active'","");
					if(count($rs_city)>0)
					{
						$api_state_id=$rs_city[0]['api_state_id'];						
						$api_city_id=$rs_city[0]['api_city_id'];	
						$state_id=$rs_city[0]['state_id'];
						$cityName=$rs_city[0]['name'];
						$cityImage=$rs_city[0]['image'];
						$cityCertificateImage=$rs_city[0]['certi_image'];
						$cityID=$rs_city[0]['id'];
						$citySlug=$rs_city[0]['slug'];
					
						$_SESSION['cityID']=$cityID;
						$_SESSION['cityName']=$cityName;
						$_SESSION['cityImage']=$cityImage;
						$_SESSION['cityCertificateImage']=$cityCertificateImage;
						$_SESSION['cityApiStateId']=$api_state_id;
						$_SESSION['cityApiCityId']=$api_city_id;
						$_SESSION['cityStateID']=$state_id;
						$_SESSION['citySlug']=$citySlug;

						if($_SESSION['MDRCCustID']>0){
							$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";								
						}else{
							$customerCond="customer_cart.session_id='".session_id()."'";						
						}
						$obj_model_tmp_cart_delete = $this->app->load_model("customer_cart");
						$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
					}
				}

				if($_SESSION['cityID']!='' && $this->app->getGetVar("city")!='')
				{
					if($_SESSION['citySlug']!=$this->app->getGetVar("city"))
					{
						setcookie("MDRCCitySelect", "Yes", time() + 2 * 24 * 60 * 60,"/","mdrcindia.com",true); 
						$obj_model_tble=$this->app->load_model("city");
						$rs_city = $obj_model_tble->execute("SELECT",false,"","slug='".$this->app->getGetVar("city")."' and status='Active'","");
						if(count($rs_city)>0)
						{
							$api_state_id=$rs_city[0]['api_state_id'];						
							$api_city_id=$rs_city[0]['api_city_id'];	
							$state_id=$rs_city[0]['state_id'];
							$cityName=$rs_city[0]['name'];
							$cityImage=$rs_city[0]['image'];
							$cityCertificateImage=$rs_city[0]['certi_image'];
							$cityID=$rs_city[0]['id'];
							$citySlug=$rs_city[0]['slug'];
						
							$_SESSION['cityID']=$cityID;
							$_SESSION['cityName']=$cityName;
							$_SESSION['cityImage']=$cityImage;
							$_SESSION['cityCertificateImage']=$cityCertificateImage;
							$_SESSION['cityApiStateId']=$api_state_id;
							$_SESSION['cityApiCityId']=$api_city_id;
							$_SESSION['cityStateID']=$state_id;
							$_SESSION['citySlug']=$citySlug;
							$_SESSION['cityPhone']=$rs_city[0]['phone'];

							if($_SESSION['MDRCCustID']>0){
								$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";								
							}else{
								$customerCond="customer_cart.session_id='".session_id()."'";						
							}
							$obj_model_tmp_cart_delete = $this->app->load_model("customer_cart");
							$obj_model_tmp_cart_delete->execute("DELETE",false,"","".$customerCond."");
						}
					}
				}
				//----------


				mysqli_set_charset($this->app->set_db_conn(),'utf-8');
				$obj_model_meta=$this->app->load_model('meta');
				$rs_meta=$obj_model_meta->execute("SELECT",false,"","");
				$this->app->assign("meta", $rs_meta[0]);

				$obj_model_city=$this->app->load_model('city');
				$rs_gs_city=$obj_model_city->execute("SELECT",false,"","status='Active'","sort_order ASC");
				$_SESSION['allCity']=$rs_gs_city;

				$this->app->assign("rs_gs_city", $rs_gs_city);
				
				if($_SESSION['cityID']<=0)
				{
					//Default Set City
					$api_state_id=$rs_gs_city[0]['api_state_id'];
					$api_city_id=$rs_gs_city[0]['api_city_id'];
					$state_id=$rs_gs_city[0]['state_id'];
					$cityName=$rs_gs_city[0]['name'];
					$cityImage=$rs_gs_city[0]['image'];
					$cityCertificateImage=$rs_gs_city[0]['certi_image'];
					$cityID=$rs_gs_city[0]['id'];
					$citySlug=$rs_gs_city[0]['slug'];
					$_SESSION['cityID']=$cityID;
					$_SESSION['cityName']=$cityName;
					$_SESSION['cityImage']=$cityImage;
					$_SESSION['cityCertificateImage']=$cityCertificateImage;
					$_SESSION['cityApiStateId']=$api_state_id;
					$_SESSION['cityApiCityId']=$api_city_id;
					$_SESSION['cityStateID']=$state_id;
					$_SESSION['citySlug']=$citySlug;
					$_SESSION['cityPhone']=$rs_gs_city[0]['phone'];
				}
				$popular_pack_cond=" and item_other_data.item_type_id=1 and set_at_popular_package='Yes'";
				$city_cond=" and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and item_price.city_id='".$_SESSION['cityID']."'";
				$obj_model_footer_popular_item = $this->app->load_model("item");
				$obj_model_footer_popular_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
				$obj_model_footer_popular_item->join_table("item_price", "left", array(), array("id"=>"item_id"));
				$rs_footer_popular_item = $obj_model_footer_popular_item->execute("SELECT",false,"","item.id!=0 and item.status='Active'  ".$popular_pack_cond." ".$city_cond."","item.sort_order ASC limit 0,7","");
				$this->app->assign("rs_footer_popular_item", $rs_footer_popular_item);
				$popular_pack_cond1=" and item_other_data.item_type_id=2 and set_at_popular_test='Yes'";
				$city_cond=" and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and item_price.city_id='".$_SESSION['cityID']."'";
				$obj_model_footer_popular_item = $this->app->load_model("item");
				$obj_model_footer_popular_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
				$obj_model_footer_popular_item->join_table("item_price", "left", array(), array("id"=>"item_id"));
				$rs_footer_popular_test = $obj_model_footer_popular_item->execute("SELECT",false,"","item.id!=0 and item.status='Active'  ".$popular_pack_cond1." ".$city_cond."","item.sort_order ASC limit 0,30","");
				$this->app->assign("rs_footer_popular_test", $rs_footer_popular_test);
				//Login web feature
				$obj_model_testimonial=$this->app->load_model('testimonial');
				$rs_testimonial=$obj_model_testimonial->execute("SELECT",false,"","status='Active'","sort_id ASC");
				$this->app->assign("rs_testimonial", $rs_testimonial);
				//for meta setting
				//admin
				$obj_model_admin=$this->app->load_model('admin');
				$re_admin=$obj_model_admin->execute("SELECT",false,"","");
				$this->app->assign("admin", $re_admin[0]);
				$obj_model_popup = $this->app->load_model("popup");
				$rs_popup = $obj_model_popup->execute("SELECT",false,"","status='Active'","popup.id DESC Limit 0,1");
				$this->app->assign("popup",$rs_popup[0]);
				if($_SESSION['MDRCCustID']>0 || $_COOKIE['MDRCToken']!='')
				{
					if($_SESSION['MDRCCustID']>0 && $_COOKIE['MDRCToken']!='')
					{
						$cond="(api_token='".$_COOKIE['MDRCToken']."' and id='".$_SESSION['MDRCCustID']."')";
					}
					else
					{
						$cond="(api_token='".$_COOKIE['MDRCToken']."')";
					}
					$obj_model_check_cookie=$this->app->load_model('customer');
					$rs_customer=$obj_model_check_cookie->execute("SELECT",false,"","".$cond." and status='Active'");
					if(count($rs_customer)<=0)
					{
						$_SESSION['MDRCCustID']='';
						$_SESSION['MDRCCustFirstName']='';
						$_SESSION['MDRCCustLastName']='';
						$_SESSION['MDRCCustEmail']='';
						$_SESSION['MDRCCustPhone']='';
						$_SESSION['MDRCCustImage']='';
						$_SESSION['MDRCCustWallet']='';
						setcookie('MDRCToken', '', -1, "/");
					}
					if(count($rs_customer)>0)
					{
						$_SESSION['MDRCCustID']=$rs_customer[0]['id'];
						$_SESSION['MDRCCustFirstName']=$rs_customer[0]['name'];
						$_SESSION['MDRCCustLastName']=$rs_customer[0]['last_name'];
						$_SESSION['MDRCCustEmail']=$rs_customer[0]['email'];
						$_SESSION['MDRCCustPhone']=$rs_customer[0]['phone'];
						$_SESSION['MDRCCustImage']=$rs_customer[0]['image'];
						$_SESSION['MDRCCustWallet']=$rs_customer[0]['wallet'];
						if($_SESSION['MDRCCustFirstName']=='')
						{
							$_SESSION['MDRCCustFirstName']='Guest';
						}
					}
					$this->app->assign("rs_customer", $rs_customer[0]);
				}
				//Navigation Menu
				$obj_model_category = $this->app->load_model("category");
				$rscategory = $obj_model_category->execute("SELECT",false,"","category.status='Active' AND category.parentcategory_id=0 and set_at_menu='Yes'"," category.sort_order asc");
				for($i=0;$i<count($rscategory);$i++)
				{
					//second level
					$rssubcategory = $obj_model_category->execute("SELECT",false,"","category.status='Active' AND category.parentcategory_id=".$rscategory[$i]['id'].""," category.sort_order asc");
					if(count($rssubcategory)>0)
					{
						$rscategory[$i]['subcategory'] = $rssubcategory;
						for($j=0;$j<count($rssubcategory);$j++)
						{
							//check third level
							$rssubsubcategory = $obj_model_category->execute("SELECT",false,"","category.status='Active' AND category.parentcategory_id=".$rssubcategory[$j]['id']." "," category.sort_order asc");
							if(count($rssubsubcategory)>0)
							{
								$rscategory[$i]['subcategory'][$j]['subsubcategory'] = $rssubsubcategory;
							}
							else
							{
								$rscategory[$i]['subcategory'][$j]['subsubcategory'] =  array();
							}
						}
					}
					else
					{
						$rscategory[$i]['subcategory'] = array();
					}
				}
				$this->app->assign("rscategory", $rscategory);
				$obj_model_pages_footer=$this->app->load_model('pages');
				$rs_pages=$obj_model_pages_footer->execute("SELECT",false,"","status='Active'","page_order ASC");
				$this->app->assign("rs_pages", $rs_pages);
				$obj_model_generel_settings=$this->app->load_model('generel_settings');
				$rs_generel_settings=$obj_model_generel_settings->execute("SELECT",false,"","");
				$this->app->assign("gs", $rs_generel_settings[0]);
				$_SESSION['store_data']='Stores';
				$_SESSION['support_phone']=$rs_generel_settings[0]['contact_number'];
				$obj_model_wish=$this->app->load_model("cust_wishlist");
				$rs_wish=$obj_model_wish->execute("SELECT",false,"","cust_id='".$_SESSION['MDRCCustID']."'");
				if(count($rs_wish)>0)
				{
					$data_wish=array();
					for($i=0;$i<count($rs_wish);$i++)
					{
						$data_wish[$i]=$rs_wish[$i]['product_id'];
					}
					$_SESSION['wish']=$data_wish;
				}
				else
				{
					$_SESSION['wish']=array();
				}
				$this->app->assign("rs_wish",$rs_wish);
					$this_page=$this->app->getCurrentView();
					$_SESSION['MDRCCurrentPage']=$this_page;
					if($_SESSION['MDRCCustID']=='' && ($this_page=='my_orders' || $this_page=='my_wallet' || $this_page=='my_profile' || $this_page=='my_family_friends' || $this_page=='my_addresses' || $this_page=='my_addresses' || $this_page=='my_prescription'))
					{
						$this->app->redirect(SERVER_ROOT);
					}
					if($this_page=='payment_success' || $this_page=='payment_failed' || $this_page=='pay' ||  $this_page=='paytm_result')
					{

					}
					else
					{
						$_SESSION['OrderID']='';
						$_SESSION['orderPayID']='';
					}
					$_SESSION['cart_vendor_id']='';
					$_SESSION['cart_weight']=0;
					$app_price=0;
					$cart_weight=0;
					$_SESSION['sub_total']=0;
					$_SESSION['oshopping_CART']=array();
					if($_SESSION['MDRCCustID']>0)
					{
						$customerCond="customer_cart.customer_id='".$_SESSION['MDRCCustID']."'";
					}
					else
					{
						$customerCond="customer_cart.session_id='".session_id()."'";
					}
					$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
					$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
					$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
					$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
					//echo $obj_model_tmp_cartmini->sql;
					$cartitemIds=array();
					if(count($rs_cartmini)<=0)
					{
						$_SESSION['HomeCollection']='';
					}
					if(count($rs_cartmini)>0)
					{
						$_SESSION['cart_vendor_id']=0;
						$this->app->assign("rs_cartmini", $rs_cartmini);
						$_SESSION['oshopping_CART']=$rs_cartmini;
						$depIDs=array();
						foreach($rs_cartmini as $item)
						{
							//$product_id=$item["id"];
							$depIDs[]=$item['cart_item_department_ids'];
							$product_id=$item["cart_item_id"];
							$product_price_id=$item["cart_item_price_id"];
							$product_quantity=$item["cart_qty"];
							$app_price+=($item["cart_item_price"]*$product_quantity);
							$weight=$item['cart_product_opt_weight']*$item["cart_qty"];
							$cart_weight= $cart_weight+$weight;
							$cartitemIds[]=$item["cart_item_id"];
						}
						$_SESSION['cart_weight']=$cart_weight;
						$_SESSION['sub_total']=number_format($app_price,'2','.','');
						$final_ids=array_unique($depIDs);
						$depID=implode(',',$final_ids);
						$_SESSION['checkoutCod']='Yes';
						$_SESSION['checkoutOnline']='';
						if($depID==2)
						{
							$_SESSION['checkoutCod']='Yes';
							$_SESSION['checkoutOnline']='Yes';
						}
						else if($depID==1)
						{
							$_SESSION['checkoutOnline']='Yes';
						}
						else
						{
							$_SESSION['checkoutOnline']='Yes';
						}
						//echo $depID;
						$obj_model_tble = $this->app->load_model("item_department");
						$rs_check_home_collection= $obj_model_tble->execute("SELECT", false, "", "id IN (".$depID.") and status='Active' and home_collection='Yes'");
						if(count($rs_check_home_collection)>0)
						{
							if($_SESSION['HomeCollection']=='')
							{
							$_SESSION['HomeCollectionModalShow']='Yes';
							}
						}
					}
					$_SESSION['cartitemIds']=$cartitemIds;
					if($this->app->getCurrentView()!="radiology")
					{
						$_SESSION['getId']=$getId;
						$_SESSION['getName']=$getName;
						$_SESSION['getType']='category';
					}
					if($this->app->getCurrentView()!="checkout")
					{
						$_SESSION['homeCollection']='';
						$_SESSION['checkoutAddressID']='';
						$_SESSION['checkoutCollectionDate']='';
						$_SESSION['checkoutCollectionTime']='';
						$_SESSION['checkoutLabID']='';
						$_SESSION['labDate']='';
						$_SESSION['labTime']='';
						$_SESSION['payment_type']='';
						$_SESSION['min_price_amount']='';
						$_SESSION['total_ship_charge']=0;
						$_SESSION['weight_charge']=0;
						$_SESSION['bag_charge']=0;
						$_SESSION['discount']=0;
						$_SESSION['DIS_ID']='';
						$_SESSION['discount_msg']='';
						$_SESSION['bag_label']='';
						$_SESSION['promo_wallet_check']='';
						$_SESSION['wallet_check']='';
						$_SESSION['collection_charge']='';
					}
					if($this->app->getCurrentView()=="home")
					{
						$page_type_cond=" and page_types='Home'";
					}
					else if($this->app->getCurrentView()=="products" || $this->app->getCurrentView()=="product_detail" )
					{
						$page_type_cond=" and page_types='Product'";
					}
					else if($this->app->getCurrentView()=="all_aisles" )
					{
						$page_type_cond=" and page_types='Category'";
					}
					else if($this->app->getCurrentView()=="cart" )
					{
						$page_type_cond=" and page_types='Cart'";
					}
					else if($this->app->getCurrentView()=="checkout" ||  $this->app->getCurrentView()=="checkout_test")
					{
						$page_type_cond=" and page_types='Checkout'";
					}
					else if($this->app->getCurrentView()=="profile" || $this->app->getCurrentView()=="my_orders" || $this->app->getCurrentView()=="order_detail" || $this->app->getCurrentView()=="my_wallet" || $this->app->getCurrentView()=="wishlist" || $this->app->getCurrentView()=="my_address")
					{
						$page_type_cond=" and page_types='My Account'";
					}
					else
					{
						$page_type_cond=" and page_types=''";
					}
					$obj_model_offer_message=$this->app->load_model("offer_message");
					$rs_offer_msg=$obj_model_offer_message->execute("SELECT",false,"","status='Active' ".$page_type_cond."","sort_order ASC");
					//echo $obj_model_offer_message->sql;
					$offer_m_id=0;
					if(count($rs_offer_msg)>0)
					{
						for($i=0;$i<count($rs_offer_msg);$i++)
						{
							if($rs_offer_msg[$i]['start_date']!='' && $rs_offer_msg[$i]['start_time']!='')
							{
								$start_date=$rs_offer_msg[$i]['start_date'].' '.$rs_offer_msg[$i]['start_time'];
							}
							else
							{
								$start_date="01/01/2020 12:00:00";
							}
							if($rs_offer_msg[$i]['end_date']!='' && $rs_offer_msg[$i]['end_time']!='')
							{
								$end_date=$rs_offer_msg[$i]['end_date'].' '.$rs_offer_msg[$i]['end_time'];
							}
							else
							{
								$end_date="01/01/2025 24:00:00";
							}
							$today_time=strtotime(date('m/d/Y H:i:s'));
							$s_time=strtotime($start_date);
							$e_time=strtotime($end_date);
							if($s_time<=$today_time && $today_time<=$e_time && $_COOKIE["headerNoti_".$rs_offer_msg[$i]['id']]!=$rs_offer_msg[$i]['id'])
							{
								$offer_m_id=$rs_offer_msg[$i]['id'];
							}
						}
					}
					// General
					if($offer_m_id<=0)
					{
						$page_type_cond=" and page_types=''";
						$obj_model_offer_message=$this->app->load_model("offer_message");
						$rs_offer_msg=$obj_model_offer_message->execute("SELECT",false,"","status='Active' ".$page_type_cond."","sort_order ASC");
						if(count($rs_offer_msg)>0)
						{
							for($i=0;$i<count($rs_offer_msg);$i++)
							{
								if($rs_offer_msg[$i]['start_date']!='' && $rs_offer_msg[$i]['start_time']!='')
								{
									$start_date=$rs_offer_msg[$i]['start_date'].' '.$rs_offer_msg[$i]['start_time'];
								}
								else
								{
									$start_date="01/01/2020 12:00:00";
								}
								if($rs_offer_msg[$i]['end_date']!='' && $rs_offer_msg[$i]['end_time']!='')
								{
									$end_date=$rs_offer_msg[$i]['end_date'].' '.$rs_offer_msg[$i]['end_time'];
								}
								else
								{
									$end_date="01/01/2025 24:00:00";
								}
								$today_time=strtotime(date('m/d/Y H:i:s'));
								$s_time=strtotime($start_date);
								$e_time=strtotime($end_date);
								if($s_time<=$today_time && $today_time<=$e_time && $_COOKIE["headerNoti_".$rs_offer_msg[$i]['id']]!=$rs_offer_msg[$i]['id'])
								{
									$offer_m_id=$rs_offer_msg[$i]['id'];
								}
							}
						}
					}
					
					// Final Display Data
					$obj_model_d_msg=$this->app->load_model("offer_message");
					$rs_d_msg=$obj_model_d_msg->execute("SELECT",false,"","status='Active' and id='".$offer_m_id."'","");
					$this->app->assign("rs_offer_msg",$rs_d_msg[0]);

					$obj_model_for_doctors=$this->app->load_model("for_doctors");
					$rs_for_doctors=$obj_model_for_doctors->execute("SELECT",false,"","status='Active'","sort_order ASC");
					$this->app->assign("rs_for_doctors",$rs_for_doctors);


					$obj_model_for_doctors = $this->app->load_model("for_doctors");
					$records = $obj_model_for_doctors->execute("SELECT",false,"","id!=0 and status='Active' and slug='super-specialised-services'");

					$obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
					$records_services_h = $obj_model_for_doctors_services->execute("SELECT",false,"","id!=0 and status='Active' and for_doctors_id='".$records[0]['id']."'","sort_order ASC");
					$this->app->assign("records_services_h",$records_services_h);

					
			}
		}
	}
}
	/*==================================================================================*/
	/*	DEFINE ALL GLOBAL FUNCTIONS HERE												*/
	/*==================================================================================*/
?>