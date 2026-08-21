<?php
	class model_pages{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_pages($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["page_title"]="varchar(255)";
			$this->nullable["page_title"]="NO";
			$this->default_value["page_title"]="";
			$this->fields["page_description"]="text";
			$this->nullable["page_description"]="NO";
			$this->default_value["page_description"]="";
			$this->fields["page_order"]="int(11)";
			$this->nullable["page_order"]="NO";
			$this->default_value["page_order"]="";
			$this->fields["page_type"]="varchar(255)";
			$this->nullable["page_type"]="NO";
			$this->default_value["page_type"]="";
			$this->fields["page_url"]="varchar(255)";
			$this->nullable["page_url"]="NO";
			$this->default_value["page_url"]="";
			$this->fields["added_on"]="varchar(50)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
			$this->fields["show_services"]="enum('Yes','No')";
			$this->nullable["show_services"]="NO";
			$this->default_value["show_services"]="No";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keyword"]="varchar(255)";
			$this->nullable["meta_keyword"]="NO";
			$this->default_value["meta_keyword"]="";
			$this->fields["meta_description"]="varchar(255)";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
			$this->fields["slug"]="varchar(100)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>