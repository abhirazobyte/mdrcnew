<?



class _gallery extends controller{



	function init(){



	}



	function onload(){



	
	$obj_model_table= $this->app->load_model("gallery_category");
	$rs_category= $obj_model_table->execute("SELECT",false,"","status='Active'","sort_order ASC");
	$this->app->assign("rs_category",$rs_category);
	
	
	$obj_model_gallery= $this->app->load_model("gallery");
	$obj_model_gallery->join_table("gallery_category", "left", array(), array("gallery_category_id"=>"id"));
	$rs_gallery= $obj_model_gallery->execute("SELECT",false,"","gallery.status='Active' and gallery_category.status='Active'","gallery.id DESC");
	$this->app->assign("rs_gallery",$rs_gallery);





	}



	



	



	



}



?>