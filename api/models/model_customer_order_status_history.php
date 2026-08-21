<?php
	class model_customer_order_status_history{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_status_history($ID=0){
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
			$this->fields["o_status"]="varchar(100)";
			$this->nullable["o_status"]="NO";
			$this->default_value["o_status"]="";
			$this->fields["remark"]="text";
			$this->nullable["remark"]="NO";
			$this->default_value["remark"]="";
			$this->fields["remark_other"]="varchar(255)";
			$this->nullable["remark_other"]="NO";
			$this->default_value["remark_other"]="";
			$this->fields["remark_customer"]="varchar(255)";
			$this->nullable["remark_customer"]="NO";
			$this->default_value["remark_customer"]="";
			$this->fields["entry_date"]="varchar(100)";
			$this->nullable["entry_date"]="NO";
			$this->default_value["entry_date"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
			$this->fields["entry_from"]="varchar(50)";
			$this->nullable["entry_from"]="NO";
			$this->default_value["entry_from"]="";
			$this->fields["ip"]="varchar(100)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
		}
	}
?>