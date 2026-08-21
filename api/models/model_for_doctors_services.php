<?php
	class model_for_doctors_services{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_for_doctors_services($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["for_doctors_id"]="int(11)";
			$this->nullable["for_doctors_id"]="NO";
			$this->default_value["for_doctors_id"]="";
			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="YES";
			$this->default_value["image"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["short_desc"]="text";
			$this->nullable["short_desc"]="YES";
			$this->default_value["short_desc"]="";
			$this->fields["decsription"]="text";
			$this->nullable["decsription"]="YES";
			$this->default_value["decsription"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="YES";
			$this->default_value["sort_order"]="";
			$this->fields["added_date"]="varchar(255)";
			$this->nullable["added_date"]="YES";
			$this->default_value["added_date"]="";
			$this->fields["button_name"]="varchar(255)";
			$this->nullable["button_name"]="YES";
			$this->default_value["button_name"]="";
			$this->fields["button_link"]="varchar(255)";
			$this->nullable["button_link"]="YES";
			$this->default_value["button_link"]="";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keywords"]="varchar(255)";
			$this->nullable["meta_keywords"]="NO";
			$this->default_value["meta_keywords"]="";
			$this->fields["meta_description"]="varchar(255)";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
		}
	}
?>