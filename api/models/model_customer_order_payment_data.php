<?php
	class model_customer_order_payment_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_payment_data($ID=0){
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
			$this->fields["payment_type"]="varchar(100)";
			$this->nullable["payment_type"]="NO";
			$this->default_value["payment_type"]="";
			$this->fields["transaction_amount"]="float(9,2)";
			$this->nullable["transaction_amount"]="NO";
			$this->default_value["transaction_amount"]="";
			$this->fields["transction_id"]="varchar(255)";
			$this->nullable["transction_id"]="NO";
			$this->default_value["transction_id"]="";
			$this->fields["payment_status"]="varchar(50)";
			$this->nullable["payment_status"]="NO";
			$this->default_value["payment_status"]="";
			$this->fields["payment_mode"]="varchar(255)";
			$this->nullable["payment_mode"]="NO";
			$this->default_value["payment_mode"]="";
			$this->fields["payment_data"]="text";
			$this->nullable["payment_data"]="NO";
			$this->default_value["payment_data"]="";
			$this->fields["gateway_remark"]="text";
			$this->nullable["gateway_remark"]="NO";
			$this->default_value["gateway_remark"]="";
			$this->fields["transction_type"]="enum('Order','Refund')";
			$this->nullable["transction_type"]="NO";
			$this->default_value["transction_type"]="Order";
			$this->fields["transction_date_time"]="varchar(100)";
			$this->nullable["transction_date_time"]="NO";
			$this->default_value["transction_date_time"]="";
			$this->fields["payment_date"]="varchar(100)";
			$this->nullable["payment_date"]="NO";
			$this->default_value["payment_date"]="";
			$this->fields["ip"]="varchar(100)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["entry_from"]="varchar(50)";
			$this->nullable["entry_from"]="NO";
			$this->default_value["entry_from"]="";
			$this->fields["payment_gateway_response"]="longtext";
			$this->nullable["payment_gateway_response"]="NO";
			$this->default_value["payment_gateway_response"]="";
		}
	}
?>