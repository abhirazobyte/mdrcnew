<?php
	class model_item_other_data{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_other_data($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";

			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["item_id"]="int(11)";
			$this->nullable["item_id"]="NO";
			$this->default_value["item_id"]="";

			$this->fields["item_category_ids"]="varchar(255)";
			$this->nullable["item_category_ids"]="NO";
			$this->default_value["item_category_ids"]="";

			$this->fields["item_rec_cat_ids"]="varchar(255)";
			$this->nullable["item_rec_cat_ids"]="NO";
			$this->default_value["item_rec_cat_ids"]="";

			$this->fields["item_key_fetures_ids"]="varchar(255)";
			$this->nullable["item_key_fetures_ids"]="NO";
			$this->default_value["item_key_fetures_ids"]="";

			$this->fields["item_department_ids"]="varchar(255)";
			$this->nullable["item_department_ids"]="NO";
			$this->default_value["item_department_ids"]="";

			$this->fields["item_rec_dept_ids"]="varchar(255)";
			$this->nullable["item_rec_dept_ids"]="NO";
			$this->default_value["item_rec_dept_ids"]="";

			$this->fields["pagewise_test"]="varchar(255)";
			$this->nullable["pagewise_test"]="NO";
			$this->default_value["pagewise_test"]="";

			$this->fields["item_diseases_ids"]="varchar(255)";
			$this->nullable["item_diseases_ids"]="NO";
			$this->default_value["item_diseases_ids"]="";

			$this->fields["item_rec_disease_ids"]="varchar(255)";
			$this->nullable["item_rec_disease_ids"]="NO";
			$this->default_value["item_rec_disease_ids"]="";

			$this->fields["other_item_ids"]="varchar(255)";
			$this->nullable["other_item_ids"]="NO";
			$this->default_value["other_item_ids"]="";

			$this->fields["item_type_id"]="int(11)";
			$this->nullable["item_type_id"]="NO";
			$this->default_value["item_type_id"]="";
			$this->fields["description"]="text";
			$this->nullable["description"]="NO";
			$this->default_value["description"]="";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keywords"]="varchar(255)";
			$this->nullable["meta_keywords"]="NO";
			$this->default_value["meta_keywords"]="";
			$this->fields["meta_desc"]="varchar(255)";
			$this->nullable["meta_desc"]="NO";
			$this->default_value["meta_desc"]="";
			$this->fields["meta_schema"]="text";
			$this->nullable["meta_schema"]="NO";
			$this->default_value["meta_schema"]="";
		}
	}
?>