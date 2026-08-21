<?php
	class model_product_label_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_label_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["label_master_id"]="int(11)";
			$this->nullable["label_master_id"]="NO";
			$this->default_value["label_master_id"]="";
			$this->fields["label_name"]="varchar(255)";
			$this->nullable["label_name"]="NO";
			$this->default_value["label_name"]="";
			$this->fields["label_value"]="varchar(255)";
			$this->nullable["label_value"]="NO";
			$this->default_value["label_value"]="";
		}
	}
?>