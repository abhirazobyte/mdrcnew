<?
class _blog extends controller
{
	function init()
	{
	}

	function onload()
	{
		$category_slug=$this->app->getGetVar('category_slug');
		$tag_slug=$this->app->getGetVar('tag_slug');
		if($category_slug!='' && $tag_slug=='')
		{
			$obj_model_maincat = $this->app->load_model("blog_category");
			$rs_maincat = $obj_model_maincat->execute("SELECT",false,"","status='Active' and slug='".$category_slug."'");
			if(count($rs_maincat)<=0)
			{
				$this->app->redirect(SERVER_ROOT);
			}
			$this->app->assign("rs_maincat",$rs_maincat[0]);
			$category_id=$rs_maincat[0]['id'];
			$catCond="and category_id='".$category_id."'";
			$obj_model_all = $this->app->load_model("blog");
			$records = $obj_model_all->execute("SELECT",false,"","blog.id!=0 and status='Active' ".$catCond."");
			$this->app->assign("records",$records);
			$CatId=$category_id;
			$TagId=0;
			$array_bread=$rs_maincat[0]['name'];
		}
		else if($tag_slug!='' && $category_slug=='')
		{
			$obj_model_blog_tag = $this->app->load_model("blog_tag");
			$rs_maincat = $obj_model_blog_tag->execute("SELECT",false,"","status='Active' and slug='".$tag_slug."'");
			if(count($rs_maincat)<=0)
			{
			$this->app->redirect(SERVER_ROOT);
			}
			$this->app->assign("rs_maincat",$rs_maincat[0]);
			$tag_id=$rs_maincat[0]['id'];
			$catCond="  and FIND_IN_SET (".$tag_id.",tag_ids)";
			$obj_model_all = $this->app->load_model("blog");
			$records = $obj_model_all->execute("SELECT",false,"","blog.id!=0  and status='Active' ".$catCond."");
			$this->app->assign("records",$records);
			
			$array_bread=$rs_maincat[0]['name'];
			$TagId=$tag_id;
			$CatId=0;
		}
		else
		{
			$obj_model_all = $this->app->load_model("blog");
			$records = $obj_model_all->execute("SELECT",false,"","blog.id!=0 and status='Active'");
			$TagId=0;
			$CatId=0;
		}

		$obj_model_blog_category= $this->app->load_model("blog_category");
		$rs_category = $obj_model_blog_category->execute("SELECT",false,"","status='Active'","sort_order ASC","");
		
		$array_category=[];
		for($i=0; $i <count($rs_category); $i++)
		{ 
			$obj_table = $this->app->load_model('blog');
			$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,blog.id from blog  where category_id='".$rs_category[$i]['id']."' and blog.status='Active'");
			$blog_count = $result[0]['allcount'];

			$array_cat=[];
			$array_cat['name']=$rs_category[$i]['name'];
			$array_cat['slug']=$rs_category[$i]['slug'];
			$array_cat['blog_count']=$blog_count;
			$array_category[]=$array_cat;
		}
		$this->app->assign("rs_category",$array_category);
		
		$this->app->assign("array_bread",$array_bread);
		$this->app->assign("CatId",$CatId);
		$this->app->assign("TagId",$TagId);
		$this->app->assign("rs_data",count($records));
	}
}
?>