<?
class userconfig
{
	var $config;
	/*==================================================================================*/
	/*  WRITE ALL USER CONFIG VARIABLE IN THIS FILE WHICH IS USED MORE THEN ONE TIME 	*/
	/*	FOR EXAMPLE , is given below , THIS VARIABLE IS DEFINED FOR UPLOADING FILE PATH */
	/*==================================================================================*/
	function __construct()
	{
			$this->config["paypal_merchant_email"] = "";
			$this->config["paypal_currency"] = "USD";
			$this->config["cms_path"] =	"/uploads/cms_images/";
			$this->config["portfolio_image"] = "/uploads/portfolio_image/";
			$this->config["product"] = "/uploads/product/";
			$this->config["gallery"] = "/uploads/gallery/";
			$this->config["home_banner"] = "/uploads/home_banner/";
			$this->config["category_banner"] = "uploads/category_banner/";
			$this->config["services_image"] = "/uploads/services_images/";
			$this->config["profile_image"] = "/uploads/profile_image/";
			$this->config["page_banner"] = "/uploads/page_banner/";
			$this->config["banner_image"] = "/uploads/banner_image/";
			$this->config["category_image"] = "/uploads/category_image/";
			$this->config["image"] = "/uploads/image/";
			$this->config["user_image"] = "uploads/user_image/";
			$this->config["offer_banner_images"] = "/uploads/offer_banner_images/";
			$this->config["main_banner_images"] = "/uploads/main_banner_images/";
			$this->config["popup_image"] = "/uploads/popup_image/";
			$this->config["push_image"] = "/uploads/push_image/";
			$this->config["files"] =	"/uploads/resume/";
			$this->config["crm_member"] = "/uploads/crm_member/";
			$this->config["category_icon"] = "/uploads/category_icon/";
			$this->config["project_image"] = "/uploads/project_image/";
			$this->config["category_banner"] = "/uploads/category_banner/";
			$this->config["brand"] = "/uploads/brand/";
			$this->config["feature"] = "/uploads/feature/";
			$this->config["imports"] = "/uploads/imports/";
			$this->config["product_image1"] = "/uploads/product_image/";
			$this->config["testimonial"] = "/uploads/testimonial/";
			$this->config["customer"] = "/uploads/customer/";
			$this->config["popup"] = "/uploads/popup/";
			$this->config["doctor"] = "/uploads/doctor/";
			$this->config["blog"] = "/uploads/blog/";
			$this->config["event"] = "/uploads/event/";
			$this->config["item_department"] = "/uploads/item_department/";
			$this->config["item_category"] = "/uploads/item_category/";
			$this->config["item_diseases"] = "/uploads/item_diseases/";
			$this->config["item_type"] = "/uploads/item_type/";
			$this->config["item_lab"] = "/uploads/item_lab/";
			$this->config["item"] = "/uploads/item/";
			$this->config["prescription"] = "/uploads/prescription/";
			$this->config["city"] = "/uploads/city/";
			$this->config["item_certificate"] = "/uploads/item_certificate/";
			$this->config["item_key_fetures"] = "/uploads/item_key_fetures/";
			$this->config["for_doctors_services"] = "/uploads/for_doctors_services/";
			$this->config["test_booking_file"] = "/uploads/test_booking_file/";
			$this->config["item_category_banner"] = "/uploads/item_category_banner/";
			$this->config["item_diseases_banner"] = "/uploads/item_diseases_banner/";
		}
	}
?>