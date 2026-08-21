<?php
	class model_popup{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_popup($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["category_id"]="int(11)";
			$this->nullable["category_id"]="NO";
			$this->default_value["category_id"]="";
			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["link"]="varchar(255)";
			$this->nullable["link"]="NO";
			$this->default_value["link"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
		}
	}
?>