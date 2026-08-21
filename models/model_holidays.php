<?php
	class model_holidays{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_holidays($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(100)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["city_ids"]="varchar(255)";
			$this->nullable["city_ids"]="NO";
			$this->default_value["city_ids"]="";
			$this->fields["remark"]="varchar(255)";
			$this->nullable["remark"]="NO";
			$this->default_value["remark"]="";
			$this->fields["entry_date_time"]="varchar(50)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>