<?php
	class model_product_filter{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_filter($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["filter_master_ids"]="varchar(255)";
			$this->nullable["filter_master_ids"]="NO";
			$this->default_value["filter_master_ids"]="";
			$this->fields["filter_master_values"]="text";
			$this->nullable["filter_master_values"]="NO";
			$this->default_value["filter_master_values"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>