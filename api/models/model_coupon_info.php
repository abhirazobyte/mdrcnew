<?php
	class model_coupon_info{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_coupon_info($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["coupon_id"]="int(11)";
			$this->nullable["coupon_id"]="NO";
			$this->default_value["coupon_id"]="";

			$this->fields["category_ids"]="varchar(500)";
			$this->nullable["category_ids"]="NO";
			$this->default_value["category_ids"]="";
			
			$this->fields["item_ids"]="varchar(500)";
			$this->nullable["item_ids"]="NO";
			$this->default_value["item_ids"]="";

			$this->fields["cat_include"]="enum('Yes','No')";
			$this->nullable["cat_include"]="NO";
			$this->default_value["cat_include"]="Yes";

			$this->fields["item_include"]="enum('Yes','No')";
			$this->nullable["item_include"]="NO";
			$this->default_value["item_include"]="No";

			$this->fields["product_ids"]="varchar(500)";
			$this->nullable["product_ids"]="NO";
			$this->default_value["product_ids"]="";
			$this->fields["get_product_ids"]="varchar(500)";
			$this->nullable["get_product_ids"]="NO";
			$this->default_value["get_product_ids"]="";
			$this->fields["buy_quantity"]="int(11)";
			$this->nullable["buy_quantity"]="NO";
			$this->default_value["buy_quantity"]="";
			$this->fields["get_quantity"]="int(11)";
			$this->nullable["get_quantity"]="NO";
			$this->default_value["get_quantity"]="";
			$this->fields["get_discount_value"]="float(9,2)";
			$this->nullable["get_discount_value"]="NO";
			$this->default_value["get_discount_value"]="";
			$this->fields["customer_ids"]="varchar(500)";
			$this->nullable["customer_ids"]="NO";
			$this->default_value["customer_ids"]="";
			$this->fields["once_per_customer"]="varchar(20)";
			$this->nullable["once_per_customer"]="NO";
			$this->default_value["once_per_customer"]="";
			$this->fields["use_limit"]="int(11)";
			$this->nullable["use_limit"]="NO";
			$this->default_value["use_limit"]="";
			$this->fields["exclude_shipping_rate"]="float(9,2)";
			$this->nullable["exclude_shipping_rate"]="NO";
			$this->default_value["exclude_shipping_rate"]="";
		}
	}
?>