<?php
	class model_item_category{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_item_category($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";
			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";
			$this->fields["item_department_ids"]="varchar(255)";
			$this->nullable["item_department_ids"]="NO";
			$this->default_value["item_department_ids"]="";
			$this->fields["name"]="varchar(255)";
			$this->nullable["name"]="NO";
			$this->default_value["name"]="";
			$this->fields["slug"]="varchar(255)";
			$this->nullable["slug"]="NO";
			$this->default_value["slug"]="";
			$this->fields["image"]="varchar(255)";
			$this->nullable["image"]="NO";
			$this->default_value["image"]="";
			$this->fields["banner_image"]="varchar(255)";
			$this->nullable["banner_image"]="NO";
			$this->default_value["banner_image"]="";
			$this->fields["decsription"]="text";
			$this->nullable["decsription"]="YES";
			$this->default_value["decsription"]="";
			$this->fields["short_description"]="text";
			$this->nullable["short_description"]="YES";
			$this->default_value["short_description"]="";
			$this->fields["status"]="enum('Active','Inactive','Trash')";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
			$this->fields["set_at_home"]="enum('Yes','No')";
			$this->nullable["set_at_home"]="NO";
			$this->default_value["set_at_home"]="No";
			$this->fields["starting_price"]="varchar(255)";
			$this->nullable["starting_price"]="NO";
			$this->default_value["starting_price"]="";
			$this->fields["meta_title"]="varchar(255)";
			$this->nullable["meta_title"]="NO";
			$this->default_value["meta_title"]="";
			$this->fields["meta_keywords"]="text";
			$this->nullable["meta_keywords"]="NO";
			$this->default_value["meta_keywords"]="";
			$this->fields["meta_description"]="text";
			$this->nullable["meta_description"]="NO";
			$this->default_value["meta_description"]="";
			$this->fields["meta_schema"]="text";
			$this->nullable["meta_schema"]="NO";
			$this->default_value["meta_schema"]="";
			$this->fields["show_in_banner"]="enum('Yes','No')";
			$this->nullable["show_in_banner"]="NO";
			$this->default_value["show_in_banner"]="No";
			$this->fields["sort_order"]="int(100)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";

			$this->fields["most_book_checkup"]="varchar(255)";
			$this->nullable["most_book_checkup"]="NO";
			$this->default_value["most_book_checkup"]="";

			$this->fields["most_book_icon"]="varchar(255)";
			$this->nullable["most_book_icon"]="NO";
			$this->default_value["most_book_icon"]="";

			$this->fields["entry_date_time"]="varchar(100)";
			$this->nullable["entry_date_time"]="NO";
			$this->default_value["entry_date_time"]="";
		}
	}
?>