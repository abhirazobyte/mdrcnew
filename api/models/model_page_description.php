<?php
	class model_page_description{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_page_description($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";

			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["page_info_id"]="int(11)";
			$this->nullable["page_info_id"]="NO";
			$this->default_value["page_info_id"]="";

			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";

			$this->fields["description"]="longtext";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";

			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>