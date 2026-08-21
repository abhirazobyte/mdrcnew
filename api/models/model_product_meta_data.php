<?php
	class model_product_meta_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_meta_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keyword"]="varchar(500)";
			$this->nullable["meta_keyword"]="NO";
			$this->default_value["meta_keyword"]="";
			$this->fields["meta_description"]="text";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
		}
	}
?>