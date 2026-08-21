<?php
	class model_cust_wishlist{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_cust_wishlist($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["cust_id"]="int(11)";
			$this->nullable["cust_id"]="NO";
			$this->default_value["cust_id"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["date"]="varchar(255)";
			$this->nullable["date"]="NO";
			$this->default_value["date"]="";
		}
	}
?>