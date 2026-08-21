<?php

if (!class_exists("Singleton")) {require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."singleton.php");}

class dbclass extends Singleton{

	/*============= DB Related Vars ================*/

	private $CONNECTION;

	private $AFFECTEDROWS;

	private $SQL;

	private $RESULTS;

	private $QUERY_STACK;

	public $groups;

	private $db_host;

	private $db_database;

	private $db_username;

	private $db_password;

	/*==============================================*/

	/*============== Paging Related Vars ===========*/

	var $CURRENT_PAGE;

	var $CURRENT_QUERY_STRING;

	var $CLASS_SELECTED;

	var $CLASS_LINK;

	var $CLASS_NOLINK;

	private $record_per_page = NULL;

	private $segment_length = NULL;

	/*==============================================*/

	private $custom_paging_function = NULL;

	public static function &get_instance() {

		parent::$my_name = __CLASS__;

		return parent::get_instance();

	}

	function init(){

		$this->db_host = defined("DB_HOST")?DB_HOST:"";

		$this->db_database 	= defined("DB_DATABASE")?DB_DATABASE:"";

		$this->db_username 	= defined("DB_USERNAME")?DB_USERNAME:"";

		$this->db_password 	= defined("DB_PASSWORD")?DB_PASSWORD:"";

		$this->RECORD_SET 	= array();

		$this->RESULTS 		= array();

		$this->QUERY_STACK 	= array();

		$this->app			= &app::get_instance();

	}

	public function set_db_host($val){

		$this->db_host = $val;

	}

	public function set_db_name($val){

		$this->db_database = $val;

	}

	public function set_db_user($val){

		$this->db_username = $val;

	}

	public function set_db_password($val){

		$this->db_password = $val;

	}

	public function set_paging_function($function){

			$this->custom_paging_function = $function;

	}

	public function open($is_new_connection=false){

		if($this->db_host!="" && $this->db_database!="" && $this->db_username!="" && $this->db_password!=""){

			$this->CONNECTION = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $is_new_connection) or die($this->error());

			if(!$this->CONNECTION){

				$this->error();

			}

			mysqli_select_db($this->CONNECTION,$this->db_database) or die($this->error());

		}else{

			trigger_error("Databse connection parameters is not set", E_USER_ERROR);

		}

	}

	public function close(){

		if($this->CONNECTION){

			mysqli_close($this->CONNECTION);

		}

	}

	private function error(){

		$str = "<h2>MySQL returned error</h2><hr><br><br>";

		$str.= "<strong>Error Description :</strong><hr>Error No : ".mysqli_errno($this->CONNECTION)."<br>Description : ".mysqli_error($this->CONNECTION)."<br><br>";

		if($this->SQL!=""){

			$str.="<strong>SQL Query<strong><hr>".$this->SQL;

		}

		echo $str;

		$this->close();

		exit();

	}

	public function setPagingStyle($classname_link="", $classname_nolink="", $classname_selected=""){

		$this->CLASS_LINK = $classname_link;

		$this->CLASS_NOLINK = $classname_nolink;

		if($classname_selected==""){

			$this->CLASS_SELECTED = $classname_nolink;

		}else{

			$this->CLASS_SELECTED = $classname_selected;

		}

	}

	public function set_paging_settings($records, $segments){

		if(!is_numeric($records) || !is_numeric($segments)){

			$this->app->display_error(debug_backtrace(), "The argument \$records and \$segments both must be numeric");

		}else{

			$this->record_per_page = $records;

			$this->segment_length = $segments;

		}

	}

	public function clear_paging_settings(){

		$this->record_per_page = NULL;

		$this->segment_length = NULL;

	}

	public function fillCombo($Table,$Text,$Value, $Selected,$Where){

		$SQL = "SELECT ".$Text.",".$Value." FROM ".$Table;

		if($Where!="")

			$SQL.= " ".$Where;

		$SQL.= " ORDER BY ".$Text;

		array_push($this->QUERY_STACK, $this->SQL);

		$result = mysqli_query($this->CONNECTION, $SQL) or die($this->error());

		$res = array();

		while($row=mysqli_fetch_assoc($result)){

			array_push($res, $row);

		}

		for($i=0;$i<sizeof($res);$i++)	{

			echo "<Option Value='".$res[$i][$Value]."'";

			if(is_array($Selected)){

				for($j=0;$j<count($Selected);$j++){

					if($res[$i][$Value]==$Selected[$j])

						echo "selected";

				}

			}

			else if($res[$i][$Value]==$Selected){

				echo "selected";

			}

			echo ">".$res[$i][$Text]."</Option>\n";

		}

	}

	public function setQuery($Query){

		$this->SQL = $Query;

	}

	public function getLastQuery(){

		return $this->SQL;

	}

	public function getRecordsetDetail($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getRecordsetDetail)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return $this->RESULTS[$recordset_name];

		}

	}

	public function getRecordset($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getRecordset)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return $this->RESULTS[$recordset_name]['records'];

		}

	}

	public function exists($sql, $field=NULL){

		$this->SQL = $sql;

		if($sql!=""){

			array_push($this->QUERY_STACK, $this->SQL);

			$result = mysqli_query($this->CONNECTION, $this->SQL) or die($this->error());

			if(mysqli_num_rows($result)>0){

				if($field!=NULL){

					if($row=mysqli_fetch_assoc($result)){

						mysqli_free_result($result);

						return $row[$field];

					}else{

						mysqli_free_result($result);

						return NULL;

					}

				}

				mysqli_free_result($result);

				return true;

			}else{

				mysqli_free_result($result);

				return false;

			}

		}else{

			mysqli_free_result($result);

			return false;

		}

	}

	public function getAffectedRows(){

		return $this->AFFECTEDROWS;

	}

	public function remove($RecordSetName){

		if($RecordSetName!=""){

			if(isset($this->RESULTS[$RecordSetName])){

				unset($this->RESULTS[$RecordSetName]);

			}

		}

	}

	public function getTotalRecords($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getTotalRecords)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return $this->RESULTS[$recordset_name]['total_records'];

		}

	}

	public function getStartRecord($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getStartRecord)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return $this->RESULTS[$recordset_name]['record_from'];

		}

	}

	public function getEndRecord($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getEndRecord)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return $this->RESULTS[$recordset_name]['record_to'];

		}

	}

	public function getSerialStart($recordset_name){

		if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (getSerialStart)</h2><hr><br>The provded <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else{

			return (($this->CURRENT_PAGE * $this->RESULTS[$recordset_name]['record_per_page']) + 1);

		}

	}

	public function resourceToArray($resource){

		$record_set = array();

		while($row=mysqli_fetch_assoc($resource)){

			array_push($record_set, $row);

		}

		return $record_set;

	}

	public function execute($recordset_name="", $auto_paging=false, $field_to_count="", $record_per_page=0, $segment_length=0){

		if((preg_match("/^SELECT/", $this->SQL) || preg_match("/^\(SELECT/", $this->SQL)) && $recordset_name==""){

			echo "<h2>Function Error (execute)</h2><hr><br>For <strong>SELECT Query</strong> you must provide the name for the <strong>RECORDSET</strong>.";

			$this->close();

			exit;

		}

		if((preg_match("/^SELECT/", $this->SQL) || preg_match("/^\(SELECT/", $this->SQL)) && $auto_paging===true){

			if($field_to_count==""){

				echo "<h2>Function Error (execute)</h2><hr><br>If you set <strong>auto_paging = true</strong> then you must set the value of <strong>filed_to_count</strong>.";

				$this->close();

				exit;

			}else{



				$pg_no = $this->app->getRequestVar("pg_no");

				if(is_null($pg_no)){

					$this->CURRENT_PAGE = 0;

				}else{

					$this->CURRENT_PAGE = $pg_no;

				}

				if($record_per_page!=0){

					$RECORD_PER_PAGE=$record_per_page;

					$SEGMENT_LENGTH=$segment_length;

				}else{

					if($this->record_per_page != NULL){

						$RECORD_PER_PAGE=$this->record_per_page;

						//$SEGMENT_LENGTH=$this->segment_length;

$SEGMENT_LENGTH=15;

					}else{

						if(defined("RECORD_PER_PAGE")){

							$RECORD_PER_PAGE=RECORD_PER_PAGE;

							$SEGMENT_LENGTH=SEGMENT_LENGTH;

						}else{

							$RECORD_PER_PAGE=10;

							$SEGMENT_LENGTH=5;

						}

					}

				}

				$record_set = array();

				preg_match_all("/SELECT[\s]+(.*?)[\s]FROM[\s]+([`a-zA-Z(])(.*?)/msi", $this->SQL, $found);

				$OriginalSQL = $this->SQL;

				for($i=0; $i<count($found[0]); $i++){

					if(trim($found[2][$i])!="("){

						$this->SQL = str_replace($found[1][$i]," COUNT(".$field_to_count.") AS CNT ", $this->SQL);

					}

					break;

				}

				/*============ Updated for grouping purpose ==============*/

				if(count($this->groups)>0){

					$this->SQL .= " GROUP BY ".$field_to_count;

				}

				/*========================================================*/

				array_push($this->QUERY_STACK, $this->SQL);

				$result = mysqli_query($this->CONNECTION, $this->SQL) or die($this->error());

				$total_records = 0;

				if(mysqli_num_rows($result)==1){

					$row = mysqli_fetch_assoc($result);

					$total_records = $row['CNT'];

				}else{

					$total_records = mysqli_num_rows($result);

				}

				$total_pages = ceil($total_records / $RECORD_PER_PAGE);

				if($this->CURRENT_PAGE>($total_pages-1)){

					$this->CURRENT_PAGE = $total_pages-1;

				}

				$this->SQL = $OriginalSQL;

				if($total_records>0){

					/*============ Updated for grouping purpose ==============*/

					if(count($this->groups)>0){

						$this->SQL .= " GROUP BY ".$field_to_count;

					}

					/*========================================================*/

					$this->SQL = $this->SQL." LIMIT ".($this->CURRENT_PAGE * $RECORD_PER_PAGE).", ".$RECORD_PER_PAGE;

					array_push($this->QUERY_STACK, $this->SQL);

					$result = mysqli_query($this->CONNECTION,$this->SQL) or die($this->error());

					$fields = array();

					while($field = mysqli_fetch_field($result)){

						array_push($fields, $field->name);

					}

					while($row=mysqli_fetch_assoc($result)){

						array_push($record_set, $row);

					}

					/*============ Updated for grouping purpose ==============*/

					if(count($this->groups)>0){

						$this->SQL = $OriginalSQL;

						$where_clause_start_pos = strpos($this->SQL, "WHERE");

						$before_where = substr($this->SQL, 0, $where_clause_start_pos);

						$after_where = substr($this->SQL, $where_clause_start_pos+1+5);

						$key = split("\.", $field_to_count);;

						$key = $key[count($key)-1];

						$this->SQL = $before_where;

						$this->SQL .= " WHERE ".$field_to_count.">=".$record_set[0][$key]." AND ".$field_to_count."<=".$record_set[count($record_set)-1][$key];

						if(trim($after_where)!=""){

							$this->SQL .= " AND ".$after_where;

						}

						array_push($this->QUERY_STACK, $this->SQL);

						$rs_tmp = $this->CONNECTION($this->CONNECTION,  $this->SQL) or die($this->error());

						$detailed_result = array();

						while($row = mysqli_fetch_assoc($rs_tmp)){

							array_push($detailed_result, $row);

						}

						$prev_id = 0;

						$custom_data = array();

						foreach($detailed_result as $tmp){

							if($tmp[$key] != $prev_id){

								array_push($custom_data, $tmp);

							}

							$prev_id = $tmp[$key];

							for($k=0; $k<count($this->groups["groups"]); $k++){

								$child_data = array();

								$first_group_field_value = 0;

								foreach($detailed_result as $tmp1){

									if($tmp1[$key] == $prev_id){

										if($first_group_field_value == 0){

											$first_group_field_value = $tmp1[$this->groups["groups"][$k]["grouping_field"]];

										}

										if($first_group_field_value != $tmp1[$this->groups["groups"][$k]["grouping_field"]]){

											break;

										}

										$tmp_child_row = array();

										$table_name_prefix_length = strlen($this->groups["groups"][$k]["child_table"])+1;

										foreach($fields as $reocrdset_field){

											if(substr($reocrdset_field, 0, $table_name_prefix_length) == $this->groups["groups"][$k]["child_table"]."_"){

												$tmp_child_row[$reocrdset_field] = $tmp1[$reocrdset_field];

											}

										}

										array_push($child_data, $tmp_child_row);

									}

								}

								$custom_data[count($custom_data)-1]["_".$this->groups["groups"][$k]["child_table"]."_"] = $child_data;

							}

							/*================= Remove child table fields ===============*/

							foreach($this->groups["groups"] as $group){

								$table_name_prefix_length = strlen($group["child_table"])+1;

								foreach($fields as $reocrdset_field){

									if(substr($reocrdset_field, 0, $table_name_prefix_length) == $group["child_table"]."_"){

										unset($custom_data[count($custom_data)-1][$reocrdset_field]);

									}

								}

							}

							/*==========================================================*/

						}

						$record_set = $custom_data;

					}

					/*========================================================*/

					$this->RESULTS[$recordset_name]['paging'] = true;

					$this->RESULTS[$recordset_name]['query'] = $this->SQL;

					$this->RESULTS[$recordset_name]['record_from'] = ($this->CURRENT_PAGE * $RECORD_PER_PAGE)+1;

					$this->RESULTS[$recordset_name]['record_to'] = ($this->CURRENT_PAGE * $RECORD_PER_PAGE)+count($record_set);

					$this->RESULTS[$recordset_name]['total_pages'] = $total_pages;

					$this->RESULTS[$recordset_name]['record_per_page'] = $RECORD_PER_PAGE;

					$this->RESULTS[$recordset_name]['segment_length'] = $SEGMENT_LENGTH;

					$this->RESULTS[$recordset_name]['current_segment'] = ceil(($this->CURRENT_PAGE + 1) / $SEGMENT_LENGTH);

					$this->RESULTS[$recordset_name]['fields'] = $fields;

					$this->RESULTS[$recordset_name]['total_records'] = $total_records;

					$this->RESULTS[$recordset_name]['records'] = $record_set;

				}else{

					array_push($this->QUERY_STACK, $this->SQL);

					$result = mysqli_query($this->CONNECTION, $this->SQL) or die($this->error());

					$fields = array();

					while($field = mysqli_fetch_field($result)){

						array_push($fields, $field->name);

					}

					$this->RESULTS[$recordset_name]['paging'] = true;

					$this->RESULTS[$recordset_name]['query'] = $this->SQL;

					$this->RESULTS[$recordset_name]['record_from'] = 0;

					$this->RESULTS[$recordset_name]['record_to'] = 0;

					$this->RESULTS[$recordset_name]['total_pages'] = 0;

					$this->RESULTS[$recordset_name]['current_segment'] = 0;

					$this->RESULTS[$recordset_name]['record_per_page'] = $RECORD_PER_PAGE;

					$this->RESULTS[$recordset_name]['segment_length'] = $SEGMENT_LENGTH;

					$this->RESULTS[$recordset_name]['current_segment'] = ceil(($this->CURRENT_PAGE + 1) / $SEGMENT_LENGTH);

					$this->RESULTS[$recordset_name]['fields'] = $fields;

					$this->RESULTS[$recordset_name]['total_records'] = 0;

					$this->RESULTS[$recordset_name]['records'] = array();

				}

				return $record_set;

			}

		}else if((preg_match("/^SELECT/", $this->SQL) || preg_match("/^\(SELECT/", $this->SQL)) && $auto_paging===false){

			array_push($this->QUERY_STACK, $this->SQL);

			$result = mysqli_query($this->CONNECTION, $this->SQL) or die($this->error());

			$fields = array();

			$record_set = array();

			while($field = mysqli_fetch_field($result)){

				array_push($fields, $field->name);

			}

			while($row=mysqli_fetch_assoc($result)){

				array_push($record_set, $row);

			}

			$this->RESULTS[$recordset_name]['paging'] = false;

			$this->RESULTS[$recordset_name]['query'] = $this->SQL;

			$this->RESULTS[$recordset_name]['record_from'] = 1;

			$this->RESULTS[$recordset_name]['record_to'] = count($record_set);

			$this->RESULTS[$recordset_name]['current_segment'] = 0;

			$this->RESULTS[$recordset_name]['segment_length'] = 0;

			$this->RESULTS[$recordset_name]['total_pages'] = 0;

			$this->RESULTS[$recordset_name]['record_per_page'] = 0;

			$this->RESULTS[$recordset_name]['fields'] = $fields;

			$this->RESULTS[$recordset_name]['total_records'] = count($record_set);

			$this->RESULTS[$recordset_name]['records'] = $record_set;

			return $record_set;

		}else{

			array_push($this->QUERY_STACK, $this->SQL);

			$result = mysqli_query($this->CONNECTION, $this->SQL) or die($this->error());

			if($result===false){

				$this->error();

			}else if($result===true){

				$this->AFFECTEDROWS = mysqli_affected_rows($this->CONNECTION);

				if(preg_match("/^INSERT/", $this->SQL)){

					return mysqli_insert_id($this->CONNECTION);

				}else{

					return true;

				}

			}else{

				return $result;

			}

		}

	}

	function get_query_stack(){

		return $this->QUERY_STACK;

	}

	/*============================= Paging related functions =====================*/

	public function show_paging($recordset_name="", $return=false){

		if($recordset_name==""){

			echo "<h2>Function Error (show_paging)</h2><hr><br>You must provide the name of the <strong>RECORDSET</strong> for which the paging will be shown.";

			$this->close();

			exit;

		}else if(!array_key_exists($recordset_name, $this->RESULTS)){

			echo "<h2>Function Error (show_paging)</h2><hr><br>The provided <strong>RECORDSET</strong> name is invalid.";

			$this->close();

			exit;

		}else if($this->RESULTS[$recordset_name]['paging']==false){

			echo "<h2>Function Error (show_paging)</h2><hr><br>Paging is not supported on the the provded <strong>RECORDSET</strong>";

			$this->close();

			exit;

		}else{

			$Prev_Link = "";

			$Next_Link = "";

			$Page_Link = "";

			$Query_String = "";

			$Post_Vars = "";

			$TotalPages = $this->RESULTS[$recordset_name]['total_pages'];

			$Current_Page = $this->getCurrentPageName();

			$Segments = ceil($TotalPages / $this->RESULTS[$recordset_name]['segment_length']);

			$FromCounter = (($this->RESULTS[$recordset_name]['current_segment']-1)* $this->RESULTS[$recordset_name]['segment_length']);

			$FromCounter = $FromCounter<0?0:$FromCounter;

			$PageRemained = ($TotalPages - $FromCounter);

			if($PageRemained>=$this->RESULTS[$recordset_name]['segment_length']){

				$ToCounter = $FromCounter + $this->RESULTS[$recordset_name]['segment_length'];

			}else{

				$ToCounter = $FromCounter + $PageRemained;

			}

			$ToCounter = $ToCounter<0?0:$ToCounter;

			if($ToCounter > $FromCounter){

				$Query_String = $this->filterQueryString($this->getCurrentQuerystring());

				//remove by virag for second page search remain in seesion

				//$Post_Vars = $this->getPostVars();

				//$Post_Vars = $this->getPostVars();

				$tmp = "&view=".$this->app->getCurrentView();

				if($Query_String!=""){

					$tmp.="&".$Query_String;

				}

				if($Post_Vars!=""){

					$tmp.="&".$Post_Vars;

				}

				$Query_String = $tmp;

				if($this->RESULTS[$recordset_name]['current_segment']>=2){

					if($this->custom_paging_function == NULL){

						$Prev_Link = "<a href='".$Current_Page."?pg_no=".($FromCounter-1).$Query_String."' >&laquo;</a>";

					}else{

						$Prev_Link = "<li><a href='javascript:void(0)' onclick='".$this->custom_paging_function."(".($FromCounter-1).")' >&laquo;</a</li>";

					}

				}else{

					$Prev_Link = "<li><a href='javascript: void(0)' class='page radius'>&laquo;</a></li>";

				}

				for($i=$FromCounter; $i<$ToCounter; $i++){

					$Page_Link.="";

					if($i==$this->CURRENT_PAGE){

						$Page_Link.="<li><span class='page-active radius'>".($i+1)."</span></li>";

						$this->CURRENT_QUERY_STRING = "pg_no=".$i."&".$Query_String;

					}else{

						if($this->custom_paging_function == NULL){

							$Page_Link.="<li><a href='".$Current_Page."?pg_no=".$i.$Query_String."' class='page radius'>".($i+1)."</a></li>";

						}else{

							$Page_Link.="<li><a href='javascript:void(0)' onclick='".$this->custom_paging_function."(".$i.")' >".($i+1)."</a></li>";

						}

					}

				}

				$Next_Link.= "";

				if($this->RESULTS[$recordset_name]['current_segment']<$Segments){

					if($this->custom_paging_function == NULL){

						$Next_Link.= "<li><a href='".$Current_Page."?pg_no=".$ToCounter.$Query_String."' >&raquo;</a></li>";

					}else{

						$Next_Link.= "<li><a href='javascript:void(0)' onclick='".$this->custom_paging_function."(".$ToCounter.")' >&raquo;</a></li>";

					}

				}else{

					$Next_Link.= "<li><a href='javascript: void(0)'  class='page radius'  >&raquo;</a></li>";

				}

				if($return){

					return "<ul class='pagination tcenter'>".$Prev_Link.$Page_Link.$Next_Link.'</ul>';

				}else{

					echo "<ul class='pagination tcenter'>".$Prev_Link.$Page_Link.$Next_Link.'</ul>';

				}

			}

		}

	}

	private function getCurrentPageName(){

		$tmpArr = explode("/",$_SERVER['PHP_SELF']);

		return $tmpArr[count($tmpArr)-1];

	}

	private function getCurrentQuerystring(){

		if($_SERVER['QUERY_STRING']=="")

			return "";

		else

			return $_SERVER['QUERY_STRING'];

	}

	private function filterQueryString($querystring){

		if($querystring==""){

			return "";

		}else{

			$tmpStr = "";

			$system_vars = array('pg_no', 'pg_seg', 'view');

			$get_vars = $this->app->getGetVars();

			foreach($get_vars as $key=>$val){

				if(!in_array($key, $system_vars)){

					$tmpStr.="&".$key."=".$val;

				}

			}

			if($tmpStr!=""){

				$tmpStr = substr($tmpStr,1);

			}

			return $tmpStr;

		}

	}

	private function getPostVars(){

		$tmpStr = "";

		$system_vars = array('pg_no', 'pg_seg', 'view');

		$post_vars = $this->app->getPostVars();

		foreach($post_vars as $key=>$val){

			if(!in_array($key, $system_vars)){

				$tmpStr.="&".$key."=".$val;

			}

		}

		if($tmpStr!=""){

			$tmpStr = substr($tmpStr,1);

		}

		return $tmpStr;

	}

	/*===================================================================*/

	/* Added by virag gandhi on 04-12-2019*/

	/*===================================================================*/

	function get_db_conn_var()

	{

		return $this->CONNECTION;

	}



}

?>