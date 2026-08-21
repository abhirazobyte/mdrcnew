<?php
	class model_category_banner{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_category_banner($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["category_id"]="int(11)";
			$this->nullable["category_id"]="NO";
			$this->default_value["category_id"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["app_image"]="varchar(225)";
			$this->nullable["app_image"]="NO";
			$this->default_value["app_image"]="";
			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["display"]="varchar(255)";
			$this->nullable["display"]="NO";
			$this->default_value["display"]="";
			$this->fields["link"]="varchar(255)";
			$this->nullable["link"]="NO";
			$this->default_value["link"]="";
			$this->fields["sort_order"]="int(100)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["status"]="varchar(255)";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
		}
	}
?>