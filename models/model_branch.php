<?php
	class model_branch{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_branch($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["city_id"]="int(11)";
			$this->nullable["city_id"]="NO";
			$this->default_value["city_id"]="";

			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["address"]="text";
			$this->nullable["address"]="NO";
			$this->default_value["address"]="";
			$this->fields["phone1"]="varchar(50)";
			$this->nullable["phone1"]="NO";
			$this->default_value["phone1"]="";
			$this->fields["phone2"]="varchar(50)";
			$this->nullable["phone2"]="NO";
			$this->default_value["phone2"]="";
			$this->fields["email1"]="varchar(100)";
			$this->nullable["email1"]="NO";
			$this->default_value["email1"]="";
			$this->fields["email2"]="varchar(100)";
			$this->nullable["email2"]="NO";
			$this->default_value["email2"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
			$this->fields["business_url"]="text";
			$this->nullable["business_url"]="NO";
			$this->default_value["business_url"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>