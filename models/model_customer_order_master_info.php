<?php
	class model_customer_order_master_info{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_master_info($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["order_master_id"]="int(11)";
			$this->nullable["order_master_id"]="NO";
			$this->default_value["order_master_id"]="";
			$this->fields["order_remark"]="text";
			$this->nullable["order_remark"]="NO";
			$this->default_value["order_remark"]="";
			$this->fields["order_date_time"]="varchar(100)";
			$this->nullable["order_date_time"]="NO";
			$this->default_value["order_date_time"]="";
		}
	}
?>