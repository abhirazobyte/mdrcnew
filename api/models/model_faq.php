<?php
	class model_faq{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_faq($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["faq_type"]="enum('item_department','item','item_category','faq_page','item_diseases')";
			$this->nullable["faq_type"]="NO";
			$this->default_value["faq_type"]="";
			$this->fields["faq_category_id"]="varchar(255)";
			$this->nullable["faq_category_id"]="NO";
			$this->default_value["faq_category_id"]="";
			$this->fields["question"]="text";
			$this->nullable["question"]="NO";
			$this->default_value["question"]="";
			$this->fields["answer"]="text";
			$this->nullable["answer"]="NO";
			$this->default_value["answer"]="";
			$this->fields["sort_id"]="int(11)";
			$this->nullable["sort_id"]="NO";
			$this->default_value["sort_id"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["added_on"]="varchar(255)";
			$this->nullable["added_on"]="NO";
			$this->default_value["added_on"]="";
		}
	}
?>