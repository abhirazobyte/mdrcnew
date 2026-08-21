<?php
	class model_job_opening{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_job_opening($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";
			$this->fields["no_of_opening"]="int(11)";
			$this->nullable["no_of_opening"]="NO";
			$this->default_value["no_of_opening"]="";
			$this->fields["salary_range"]="varchar(255)";
			$this->nullable["salary_range"]="NO";
			$this->default_value["salary_range"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["added_date"]="varchar(255)";
			$this->nullable["added_date"]="NO";
			$this->default_value["added_date"]="";
		}
	}
?>