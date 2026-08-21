<?php
	class model_customer_order_rattings{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_rattings($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["order_master_id"]="int(11)";
			$this->nullable["order_master_id"]="NO";
			$this->default_value["order_master_id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["ratt_star"]="float(9,2)";
			$this->nullable["ratt_star"]="NO";
			$this->default_value["ratt_star"]="";
			$this->fields["order_remark"]="text";
			$this->nullable["order_remark"]="NO";
			$this->default_value["order_remark"]="";
			$this->fields["ip"]="varchar(100)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["entry_date"]="varchar(100)";
			$this->nullable["entry_date"]="NO";
			$this->default_value["entry_date"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
			$this->fields["entry_from"]="varchar(100)";
			$this->nullable["entry_from"]="NO";
			$this->default_value["entry_from"]="";
			$this->fields["status"]="varchar(100)";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="";
		}
	}
?>