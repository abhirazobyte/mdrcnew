<?php
	class model_customer_order_detail_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_customer_order_detail_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["order_master_id"]="int(11)";
			$this->nullable["order_master_id"]="NO";
			$this->default_value["order_master_id"]="";
			$this->fields["order_detail_id"]="int(11)";
			$this->nullable["order_detail_id"]="NO";
			$this->default_value["order_detail_id"]="";
			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";
			$this->fields["itemid"]="varchar(100)";
			$this->nullable["itemid"]="NO";
			$this->default_value["itemid"]="";
			$this->fields["itemcode"]="varchar(100)";
			$this->nullable["itemcode"]="NO";
			$this->default_value["itemcode"]="";
			$this->fields["item_name"]="varchar(255)";
			$this->nullable["item_name"]="NO";
			$this->default_value["item_name"]="";
			$this->fields["sample_remark"]="text";
			$this->nullable["sample_remark"]="NO";
			$this->default_value["sample_remark"]="";
			$this->fields["sample_type_name"]="varchar(500)";
			$this->nullable["sample_type_name"]="NO";
			$this->default_value["sample_type_name"]="";
			$this->fields["sample_remark1"]="text";
			$this->nullable["sample_remark1"]="NO";
			$this->default_value["sample_remark1"]="";
			$this->fields["test_parameters"]="text";
			$this->nullable["test_parameters"]="NO";
			$this->default_value["test_parameters"]="";
			$this->fields["prescription_required"]="varchar(20)";
			$this->nullable["prescription_required"]="NO";
			$this->default_value["prescription_required"]="";
			$this->fields["required_attachment"]="varchar(255)";
			$this->nullable["required_attachment"]="NO";
			$this->default_value["required_attachment"]="";
		}
	}
?>