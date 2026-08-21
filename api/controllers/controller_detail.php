<?
class _detail extends controller {

	function init() {
	}

	function onload() {

		$slug=$this->app->getGetVar("slug");

		if($slug!='')
		{
			$city_id=$_SESSION['cityID'];
			$city_name=$_SESSION['cityName'];

			$city_cond=" and FIND_IN_SET ('".$city_id."',item.city_ids) and item_price.city_id='".$city_id."'";
		
			$master_con=$city_cond;

			$obj_model_all = $this->app->load_model("item");
			$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
			$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));					
			$rs_data = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.slug='".$slug."'  ".$master_con."","item.sort_order ASC limit 0,1","");
			if(count($rs_data)<=0)
			{
				$this->app->redirect(SERVER_ROOT."/404");	
				exit;
			}
			
			$city=$this->app->getGetVar("city");
			if($city!=''){
				$citySlugs = array_column($_SESSION['allCity'], 'slug');
				
				if(!in_array($city,$citySlugs)){
					$this->app->redirect(SERVER_ROOT."/404");
				}
			}

			if($city=='')
			{
				$this->app->redirect(SERVER_ROOT."/tests/".$slug."/".$_SESSION['citySlug']);
			}

			$this->app->assign("rs_data",$rs_data[0]);

			$item_type=$rs_data[0]['item_other_data_item_type_id'];
			$item_certificate_ids=$rs_data[0]['item_price_item_certificate_ids'];
			
			if($item_certificate_ids!='')
			{
				$obj_model_all_certif= $this->app->load_model("item_certificate");
				$rs_certi_data = $obj_model_all_certif->execute("SELECT",false,"","item_certificate.status='Active' and item_certificate.id IN (".$item_certificate_ids.")","item_certificate.sort_order ASC","");
				$this->app->assign("rs_certi_data",$rs_certi_data);
					
			}

			//key fetures
			$item_key_fetures_ids=$rs_data[0]['item_other_data_item_key_fetures_ids'];
			if($item_key_fetures_ids!='')
			{
				$obj_model_item_key_fetures= $this->app->load_model("item_key_fetures");
				$rs_key_fetures_data = $obj_model_item_key_fetures->execute("SELECT",false,"","item_key_fetures.id!=0 and item_key_fetures.id IN (".$item_key_fetures_ids.")","item_key_fetures.sort_order ASC","");
				$this->app->assign("rs_key_fetures_data",$rs_key_fetures_data);
			}

			if($item_type==1)
			{
				$obj_model_packages = $this->app->load_model("item_package_data");
				$obj_model_packages->join_table("item_description", "left", array(), array("data_id"=>"item_id"));
				$rs_package_data = $obj_model_packages->execute("SELECT",false,"","item_package_data.item_id='".$rs_data[0]['id']."'","");
			}

			//load banner
			$item_department_ids=explode(',',$rs_data[0]['item_other_data_item_department_ids']);
			if(in_array(1,$item_department_ids) && in_array(2,$item_department_ids)) {
				$banner_con="(FIND_IN_SET ('radiology_item',banner.show_page) or FIND_IN_SET ('pathology_item',banner.show_page))";
			} else if(in_array(1,$item_department_ids)) {
				$banner_con='FIND_IN_SET ("radiology_item",banner.show_page)';
			} else if(in_array(2,$item_department_ids)) {
				$banner_con='FIND_IN_SET ("pathology_item",banner.show_page)';
			} else {
				$banner_con='show_page=""';
			}
			$obj_model_banner=$this->app->load_model('banner');
			$rs_banner=$obj_model_banner->execute("SELECT",false,"","status='Active' and ".$banner_con." and (FIND_IN_SET ('".$_SESSION['cityID']."',banner.city_ids) or city_ids='')","sort_id ASC");
			$this->app->assign("rs_banner", $rs_banner);
			

			$this->app->assign("rs_package_data",$rs_package_data);
			$this->app->assign("city_id",$city_id);
			$this->app->assign("city_name",$city_name);


			$default_string = array("{CITY}");
			$new_string   = array($city_name);

			$meta_title = str_replace($default_string, $new_string,$rs_data[0]['item_other_data_meta_title']);
			$meta_keyword = str_replace($default_string, $new_string,$rs_data[0]['item_other_data_meta_keywords']);
			$meta_description = str_replace($default_string, $new_string,$rs_data[0]['item_other_data_meta_desc']);
			$meta_schema = str_replace($default_string, $_SESSION['citySlug'],$rs_data[0]['item_other_data_meta_schema']);
			$this->app->setTitle($meta_title);
			$this->app->setKeywords($meta_keyword);
			$this->app->setDescription($meta_description);
			$this->app->setSchema($meta_schema);

			$obj_model_faq = $this->app->load_model("faq");
			$rs_faq_data = $obj_model_faq->execute("SELECT",false,"","faq_type='item' and status='Active' and faq_category_id='".$rs_data[0]['id']."'","faq.id desc");
			$this->app->assign("rs_faq_data",$rs_faq_data);
		}
		else
		{
			$this->app->redirect(SERVER_ROOT);	
			exit;
		}
	}
}
?>