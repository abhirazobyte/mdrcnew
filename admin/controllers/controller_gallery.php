<?php

class _gallery extends controller

{

	function init()

	{

		if($this->app->getCurrentAction()=="")

		{

			$this->load_data();

		}

	}



	function onload()

	{

	}	

		

	function load_data()

	{

		

		$cat_id=$this->app->getGetVar('cat_id');

		

		

		$obj_model_products= $this->app->load_model("gallery_category");

		$rs_product= $obj_model_products->execute("SELECT", false,"","gallery_category.id='".$cat_id."'");

		$this->assign("rs_product",$rs_product[0]);

		

		if(count($rs_product)<=0)

		{

			$this->app->redirect("index.php?view=gallery_list");	

			exit;

		}

		

		

		

	}	

	



}	

?>