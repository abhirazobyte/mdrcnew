<?php
	class model_direct_payment_order{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_direct_payment_order($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="bigint(20)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["email"]="varchar(255)";
			$this->nullable["email"]="NO";
			$this->default_value["email"]="";
			$this->fields["mobile"]="varchar(255)";
			$this->nullable["mobile"]="NO";
			$this->default_value["mobile"]="";
			$this->fields["amount"]="int(11)";
			$this->nullable["amount"]="NO";
			$this->default_value["amount"]="";
			$this->fields["message"]="text";
			$this->nullable["message"]="NO";
			$this->default_value["message"]="";
			$this->fields["order_pay_status"]="enum('Cancel','Confirm')";
			$this->nullable["order_pay_status"]="NO";
			$this->default_value["order_pay_status"]="Cancel";
			$this->fields["payment_id"]="varchar(255)";
			$this->nullable["payment_id"]="NO";
			$this->default_value["payment_id"]="";
			$this->fields["transction_date_time"]="varchar(255)";
			$this->nullable["transction_date_time"]="NO";
			$this->default_value["transction_date_time"]="";
			$this->fields["created_date"]="varchar(255)";
			$this->nullable["created_date"]="NO";
			$this->default_value["created_date"]="";
			$this->fields["payment_gateway_response"]="longtext";
			$this->nullable["payment_gateway_response"]="NO";
			$this->default_value["payment_gateway_response"]="";
			$this->fields["ip"]="varchar(255)";
			$this->nullable["ip"]="NO";
			$this->default_value["ip"]="";
			$this->fields["gateway_remark"]="varchar(255)";
			$this->nullable["gateway_remark"]="NO";
			$this->default_value["gateway_remark"]="";
		}
	}
?>