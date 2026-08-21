<?php
	class model_event{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_event($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["category_id"]="int(11)";
			$this->nullable["category_id"]="NO";
			$this->default_value["category_id"]="";
			$this->fields["tag_ids"]="text";
			$this->nullable["tag_ids"]="NO";
			$this->default_value["tag_ids"]="";
			$this->fields["tags"]="text";
			$this->nullable["tags"]="NO";
			$this->default_value["tags"]="";
			$this->fields["short_info"]="text";
			$this->nullable["short_info"]="NO";
			$this->default_value["short_info"]="";
			$this->fields["about_info"]="text";
			$this->nullable["about_info"]="NO";
			$this->default_value["about_info"]="";
			$this->fields["folder"]="varchar(50)";
			$this->nullable["folder"]="NO";
			$this->default_value["folder"]="";
			$this->fields["image"]="varchar(100)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["set_at_home"]="enum('Yes','No')";
			$this->nullable["set_at_home"]="NO";
			$this->default_value["set_at_home"]="No";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keywords"]="varchar(255)";
			$this->nullable["meta_keywords"]="NO";
			$this->default_value["meta_keywords"]="";
			$this->fields["meta_description"]="varchar(500)";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>