<?php
	class model_product_review{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_product_review($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["cust_id"]="int(11)";
			$this->nullable["cust_id"]="NO";
			$this->default_value["cust_id"]="";
			$this->fields["order_id"]="int(11)";
			$this->nullable["order_id"]="NO";
			$this->default_value["order_id"]="";
			$this->fields["name"]="varchar(100)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["company"]="varchar(255)";
			$this->nullable["company"]="NO";
			$this->default_value["company"]="";
			$this->fields["city"]="varchar(255)";
			$this->nullable["city"]="NO";
			$this->default_value["city"]="";
			$this->fields["product_id"]="int(11)";
			$this->nullable["product_id"]="NO";
			$this->default_value["product_id"]="";
			$this->fields["product_star"]="float(9,2)";
			$this->nullable["product_star"]="NO";
			$this->default_value["product_star"]="";
			$this->fields["product_desc"]="varchar(500)";
			$this->nullable["product_desc"]="NO";
			$this->default_value["product_desc"]="";
			$this->fields["review_label"]="varchar(255)";
			$this->nullable["review_label"]="NO";
			$this->default_value["review_label"]="";
			$this->fields["wallet_benifits_status"]="enum('Yes','No')";
			$this->nullable["wallet_benifits_status"]="NO";
			$this->default_value["wallet_benifits_status"]="No";
			$this->fields["added_on"]="varchar(50)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
			$this->fields["status"]="enum('Active','Inactive')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Inactive";
		}
	}
?>