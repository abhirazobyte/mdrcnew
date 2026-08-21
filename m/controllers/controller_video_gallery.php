<?



class _video_gallery extends controller{



	function init(){



	}



	function onload(){



		



	
	
	$obj_model_gallery= $this->app->load_model("video_gallery");
	$rs_gallery= $obj_model_gallery->execute("SELECT",false,"","status='Active'","sort_order ASC");
	$this->app->assign("rs_gallery",$rs_gallery);




	



	}



	



	



	



}



?>