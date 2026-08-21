<?php
	class model_ipo_pdfs{
		public $fields= array();
		public $nullable= array();
		public $default_value= array();
		public $ID= 0;
		public $KEY= "";

		function model_ipo_pdfs($ID=0){
			$this->ID = $ID;
			$this->KEY = "id";

			$this->fields["id"]="int(11)";
			$this->nullable["id"]="NO";
			$this->default_value["id"]="";

			$this->fields["title"]="varchar(255)";
			$this->nullable["title"]="NO";
			$this->default_value["title"]="";

			$this->fields["file_name"]="varchar(255)";
			$this->nullable["file_name"]="NO";
			$this->default_value["file_name"]="";

			$this->fields["page_type"]="enum('Policies', 'IPO', 'News Releases')";
			$this->nullable["page_type"]="NO";
			$this->default_value["page_type"]="";

			$this->fields["qr_code"]="enum('Yes', 'No')";
			$this->nullable["qr_code"]="NO";
			$this->default_value["qr_code"]="";

			$this->fields["sort_order"]="int(11)";
			$this->nullable["sort_order"]="NO";
			$this->default_value["sort_order"]="";

			$this->fields["status"]="enum('Active', 'Inactive', 'Trash') ";
			$this->nullable["status"]="NO";
			$this->default_value["status"]="Active";
		}
	}
?>