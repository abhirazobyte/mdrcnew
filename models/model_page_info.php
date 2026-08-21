<?php
	class model_page_info{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_page_info($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["page_name"]="varchar(255)";
			$this->nullable["page_name"]="NO";
			$this->default_value["page_name"]="";
			$this->fields["page_title"]="varchar(255)";
			$this->nullable["page_title"]="NO";
			$this->default_value["page_title"]="";
			$this->fields["meta_keywords"]="text";
			$this->nullable["meta_keywords"]="NO";
			$this->default_value["meta_keywords"]="";
			$this->fields["meta_description"]="text";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["meta_schema"]="text";
			$this->nullable["meta_schema"]="NO";
			$this->default_value["meta_schema"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["content_title"]="text";
			$this->nullable["content_title"]="NO";
			$this->default_value["content_title"]="";
			$this->fields["content_desc"]="text";
			$this->nullable["content_desc"]="NO";
			$this->default_value["content_desc"]="";
		}
	}
?>