<?php
	class model_coupon{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_coupon($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["vendor_id"]="int(11)";
			$this->nullable["vendor_id"]="NO";
			$this->default_value["vendor_id"]="";
			$this->fields["coupon_code"]="varchar(50)";
			$this->nullable["coupon_code"]="NO";
			$this->default_value["coupon_code"]="";
			$this->fields["type"]="enum('Percentage','Fixed amount','Free shipping','Buy X get Y')";
			$this->nullable["type"]="NO";
			$this->default_value["type"]="Percentage";
			$this->fields["amount"]="int(11)";
			$this->nullable["amount"]="NO";
			$this->default_value["amount"]="";
			$this->fields["max_amount"]="int(11)";
			$this->nullable["max_amount"]="NO";
			$this->default_value["max_amount"]="";
			$this->fields["order_amount"]="int(11)";
			$this->nullable["order_amount"]="NO";
			$this->default_value["order_amount"]="";
			$this->fields["exp_date"]="varchar(50)";
			$this->nullable["exp_date"]="NO";
			$this->default_value["exp_date"]="";
			$this->fields["msg"]="varchar(1000)";
			$this->nullable["msg"]="NO";
			$this->default_value["msg"]="";
			$this->fields["success_apply_msg"]="varchar(1000)";
			$this->nullable["success_apply_msg"]="NO";
			$this->default_value["success_apply_msg"]="";
			$this->fields["admin_note"]="varchar(500)";
			$this->nullable["admin_note"]="NO";
			$this->default_value["admin_note"]="";
			$this->fields["start_date"]="varchar(50)";
			$this->nullable["start_date"]="NO";
			$this->default_value["start_date"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["display_list"]="enum('Yes','No')";
			$this->nullable["display_list"]="NO";
			$this->default_value["display_list"]="No";
			$this->fields["c_type"]="enum('System','Refer','Admin')";
			$this->nullable["c_type"]="NO";
			$this->default_value["c_type"]="Admin";
			$this->fields["auto_apply"]="enum('Yes','No')";
			$this->nullable["auto_apply"]="NO";
			$this->default_value["auto_apply"]="No";
		}
	}
?>