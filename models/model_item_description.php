<?php
	class model_item_description{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_description($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";
			$this->fields["item_name"]="varchar(500)";
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
			$this->fields["prescription_required"]="enum('Yes','No')";
			$this->nullable["prescription_required"]="NO";
			$this->default_value["prescription_required"]="Yes";
			$this->fields["required_attachment"]="varchar(255)";
			$this->nullable["required_attachment"]="NO";
			$this->default_value["required_attachment"]="";
			$this->fields["from_age_days"]="int(11)";
			$this->nullable["from_age_days"]="NO";
			$this->default_value["from_age_days"]="";
			$this->fields["to_age_days"]="int(11)";
			$this->nullable["to_age_days"]="NO";
			$this->default_value["to_age_days"]="";
			$this->fields["gender"]="varchar(50)";
			$this->nullable["gender"]="NO";
			$this->default_value["gender"]="";
		}
	}
?>