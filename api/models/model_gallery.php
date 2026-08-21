<?php
	class model_gallery{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_gallery($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["gallery_category_id"]="int(11)";
			$this->nullable["gallery_category_id"]="NO";
			$this->default_value["gallery_category_id"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["set_at_home"]="enum('Active','Inactive')";
			$this->nullable["set_at_home"]="NO";
			$this->default_value["set_at_home"]="Inactive";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>