<?php
	class model_customer_cart_notification_logs{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_cart_notification_logs($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["customer_id"]="int(11)";
			$this->nullable["customer_id"]="NO";
			$this->default_value["customer_id"]="";
			$this->fields["noti_desc"]="text";
			$this->nullable["noti_desc"]="Yes";
			$this->default_value["noti_desc"]="";
			$this->fields["title"]="varchar(100)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";
			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>