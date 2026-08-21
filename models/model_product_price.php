<?php
	class model_product_price{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_price($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["attribute_1"]="varchar(255)";
			$this->nullable["attribute_1"]="NO";
			$this->default_value["attribute_1"]="";
			$this->fields["attribute_2"]="varchar(255)";
			$this->nullable["attribute_2"]="NO";
			$this->default_value["attribute_2"]="";
			$this->fields["attribute_3"]="varchar(255)";
			$this->nullable["attribute_3"]="NO";
			$this->default_value["attribute_3"]="";
			$this->fields["price"]="float(9,2)";
			$this->nullable["price"]="NO";
			$this->default_value["price"]="";
			$this->fields["mrp"]="float(9,2)";
			$this->nullable["mrp"]="NO";
			$this->default_value["mrp"]="";
			$this->fields["max_quantity"]="int(11)";
			$this->nullable["max_quantity"]="NO";
			$this->default_value["max_quantity"]="";
			$this->fields["total_quantity"]="int(11)";
			$this->nullable["total_quantity"]="NO";
			$this->default_value["total_quantity"]="";
			$this->fields["weight"]="float(9,2)";
			$this->nullable["weight"]="NO";
			$this->default_value["weight"]="";
		}
	}
?>