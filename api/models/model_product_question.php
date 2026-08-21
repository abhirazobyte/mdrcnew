<?php
	class model_product_question{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_question($ID=0){
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
			$this->fields["cust_name"]="varchar(255)";
			$this->nullable["cust_name"]="NO";
			$this->default_value["cust_name"]="";
			$this->fields["added_from"]="enum('Admin','Website','Android','Iphone')";
			$this->nullable["added_from"]="NO";
			$this->default_value["added_from"]="Admin";
			$this->fields["question"]="varchar(500)";
			$this->nullable["question"]="NO";
			$this->default_value["question"]="";
			$this->fields["answer"]="varchar(500)";
			$this->nullable["answer"]="NO";
			$this->default_value["answer"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Inactive";
			$this->fields["added_on"]="varchar(100)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";
		}
	}
?>