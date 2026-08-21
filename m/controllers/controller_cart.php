<?php
class _cart extends controller {
	function init() {
	}

	function onload() {
		$this->app->setTitle($this->app->meta['title']);
		$this->app->setKeywords($this->app->meta['keyword']);
		$this->app->setDescription($this->app->meta['description']);

		$homeCollectionDisable=["15","16","17"];
		if(in_array($_SESSION['cityID'],$homeCollectionDisable)) {
			$_SESSION['HomeCollection']	='Yes';
			$_SESSION['HomeCollectionModalShow']='No';
		}
		
	}
}
?>