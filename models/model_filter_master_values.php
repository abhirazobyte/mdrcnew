<?php
	class model_filter_master_values{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_filter_master_values($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["filter_master_id"]="int(11)";
			$this->nullable["filter_master_id"]="NO";
			$this->default_value["filter_master_id"]="";
			$this->fields["master_name"]="varchar(255)";
			$this->nullable["master_name"]="NO";
			$this->default_value["master_name"]="";
			$this->fields["image"]="varchar(100)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["master_sort_order"]="int(11)";
			$this->nullable["master_sort_order"]="NO";
			$this->default_value["master_sort_order"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>