<?
class _news_and_events_details extends controller{

	function init()
	{
	}

	function onload()
	{

		$event_slug=$this->app->getGetVar("event_slug");

		$obj_model_all = $this->app->load_model("event");
		$obj_model_all->join_table("event_category", "left", array("name","slug"), array("category_id"=>"id"));
		$records = $obj_model_all->execute("SELECT",false,"","event.id!=0 and event.status='Active'  and event.slug='".$event_slug."'","","event.id");
		$this->app->assign("records",$records[0]);
		if(count($records)<=0)
		{
			//$this->app->redirect(SERVER_ROOT);
		}

		$city_name=$_SESSION['cityName'];
		$default_string = array("{CITY}");
		$new_string   = array($city_name);
		$meta_title = str_replace($default_string, $new_string,$records[0]['meta_title']);
		$meta_keyword = str_replace($default_string, $new_string,$records[0]['meta_keywords']);
		$meta_description = str_replace($default_string, $new_string,$records[0]['meta_description']);
		$this->app->setTitle($meta_title);
		$this->app->setKeywords($meta_keyword);
		$this->app->setDescription($meta_description); 

		$obj_model_event_category= $this->app->load_model("event_category");
		$rs_category = $obj_model_event_category->execute("SELECT",false,"","status='Active'","sort_order ASC","");
		
		$array_category=[];
		for($i=0; $i <count($rs_category); $i++)
		{ 
			$obj_table = $this->app->load_model('event');
			$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,event.id from event  where category_id='".$rs_category[$i]['id']."' and event.status='Active'");
			$event_count = $result[0]['allcount'];

			$array_cat=[];
			$array_cat['name']=$rs_category[$i]['name'];
			$array_cat['slug']=$rs_category[$i]['slug'];
			$array_cat['event_count']=$event_count;
			$array_category[]=$array_cat;
		}
		$this->app->assign("rs_category",$array_category);


		// if($records[0]['tag_ids']!='')
		// {
		// 	$tagCond="blog_tag.id IN (".$records[0]['tag_ids'].")";
		// 	$obj_model_blog_tag= $this->app->load_model("blog_tag");
		// 	$rs_blog_tag = $obj_model_blog_tag->execute("SELECT",false,""," ".$tagCond." and status='Active'","sort_order ASC","");
		// 	$this->app->assign("rs_blog_tag",$rs_blog_tag);
		// }


		// $obj_model_tag= $this->app->load_model("blog_tag");
		// $rs_tag = $obj_model_tag->execute("SELECT",false,"","set_at_home='Yes' and status='Active'","sort_order ASC","");
		// $this->app->assign("rs_tag",$rs_tag);


		$obj_model_recent_event = $this->app->load_model("event");
		$recent_event = $obj_model_recent_event->execute("SELECT",false,"","event.id!='".$records[0]['id']."' and event.status='Active'","event.id DESC LIMIT 0,6");
		$this->app->assign("recent_event",$recent_event);

		$obj_model_recent_event_gallery = $this->app->load_model("event_gallery");
		$event_gallery = $obj_model_recent_event_gallery->execute("SELECT",false,"","event_gallery.event_id='".$records[0]['id']."' and status='Active'","event_gallery.id DESC");
		$this->app->assign("event_gallery",$event_gallery);


	}
}
?>