<?php
	class model_product_info{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_info($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["short_description"]="text";
			$this->nullable["short_description"]="NO";
			$this->default_value["short_description"]="";
			$this->fields["product_description"]="text";
			$this->nullable["product_description"]="NO";
			$this->default_value["product_description"]="";
			$this->fields["attribute_title1"]="varchar(255)";
			$this->nullable["attribute_title1"]="NO";
			$this->default_value["attribute_title1"]="";
			$this->fields["attribute_title2"]="varchar(255)";
			$this->nullable["attribute_title2"]="NO";
			$this->default_value["attribute_title2"]="";
			$this->fields["attribute_title3"]="varchar(255)";
			$this->nullable["attribute_title3"]="NO";
			$this->default_value["attribute_title3"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>