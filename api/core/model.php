<?php

	class model extends Singleton{

		public $sql;

		private $relations;

		private $tablename;

		private $fieldmapping;

		private $fieldstoselect;

		private $app;

		private $trim_post_vars;

		private $model_data;

		private $groups;

		

		public $only_custom_data;

								

		function init(){

			if(!defined("__MYMVC__")){

				echo "NO ACCESS !!";

				exit;

			}else{

				$this->app 				= &app::get_instance();

				$this->fieldmapping 	= array();

				$this->foreign_tables 	= array();

				$this->fieldstoselect	= array();

				$this->sql 				= "";

				$this->relations 		= array();

				$this->model_data		= NULL;

				$this->groups			= array();		

				if(defined("AUTO_TRIM")){

					$this->trim_post_vars = (bool)AUTO_TRIM;

				}else{

					$this->trim_post_vars = false;

				}

			}

		}

		

		public static function &get_instance() { 

			parent::$my_name = __CLASS__; 

			return parent::get_instance(); 

		} 

		

		function set_trimming($newval){

			$this->trim_post_vars = (bool)$newval;

		}

		

		public function set_model_data($obj_model_data){

			$this->relations = array();

			$this->model_data = $obj_model_data;

			$this->tablename = str_replace("model_", "", get_class($obj_model_data));

		}

		

		function set_paging_settings($records, $segments){

			if(!is_numeric($records) || !is_numeric($segments)){

				$this->app->display_error(debug_backtrace(), "The argument \$records and \$segments both must be numeric");

			}else{

				$this->app->objDB->set_paging_settings($records, $segments);

			}

		}

		

		function set_paging_function($function){

			$this->app->objDB->set_paging_function($function);

		}

		

		function show_paging($return=true){

			if($return){

				return $this->app->objDB->show_paging("records_".get_class($this), true);

			}else{

				$this->app->objDB->show_paging("records_".get_class($this), false);

			}

		}

		

		function get_serial_start(){

			return $this->app->objDB->getSerialStart("records_".get_class($this));

		}

		

		function set_fields_to_get($fields=NULL){

			if($fields == NULL){

				$this->fieldstoselect = array();

			}else{

				if($fields==""){

					$this->app->display_error(debug_backtrace(), "The argument <strong>\$fields</strong> should not be empty. It should be a String or an Array()");

				}else if(is_array($fields)){

					foreach($fields as $field){

						if(!isset($this->model_data->fields[$field])){

							$this->app->display_error(debug_backtrace(), "There is no field named <strong>".$field."</strong> in model <strong>".get_class($this)."</strong>");

						}else{

							array_push($this->fieldstoselect, $field);

						}

					}

				}else{

					if(!isset($this->model_data->fields[$fields])){

						$this->app->display_error(debug_backtrace(), "There is no field named <strong>".$fields."</strong> in model <strong>".get_class($this)."</strong>");

					}else{

						array_push($this->fieldstoselect, $fields);

					}

				}

			}

		}

		

		public function clear_groups(){

			$this->groups = array();

		}

		

		function group_records($master_table, $grouping_field, $child_table){

			if($master_table=="" || $grouping_field=="" || $child_table==""){

				trigger_error("function group_records() does not accept any empty argument. All 3 arguments should be non empty string", E_USER_ERROR);

				return false;

			}else{

				if(count($this->groups)>0){

					if($this->groups["master_table"] != $master_table){

						trigger_error("All grouping should be done on a single master table", E_USER_ERROR);

						return false;

					}

					foreach($this->groups["grouping_fields"] as $field=>$tbl){

						if ($field == $grouping_field){

							trigger_error("Specified grouping field [".$grouping_field."] already exists)", E_USER_ERROR);

							return false;

						}

					}

				}

				if(count($this->groups)<=0){

					$this->groups["master_table"] = $master_table;

					$this->groups["groups"] = array();

				}

				

				array_push($this->groups["groups"], array("grouping_field"=>$grouping_field, "child_table"=>$child_table));

				return true;

			}

		}

		

		function get_fields($fields="", $where=""){

			$this->set_fields_to_get($fields);

			return $this->execute("SELECT",false,"",$where);

		}

		

		function get_detail(){

			return $this->app->objDB->getRecordsetDetail("records_".get_class($this));

		}

		

		function return_scaler($field, $where=""){

			if(!isset($this->model_data->fields[$field])){

				$this->app->display_error(debug_backtrace(), "There is no field named <strong>".$field."</strong> in model <strong>".get_class($this)."</strong>");

			}else if($where=="" && $this->model_data->ID==0){

				$this->app->display_error(debug_backtrace(), "To use this function you must set at least the IDENTITY of this model or pass the WHERE CLAUSE");

			}else{

				$this->sql = "SELECT ".$field." FROM `".$this->tablename."` WHERE `".$this->tablename."`.".$this->model_data->KEY."!=0 AND";

				if($this->model_data->ID!=0){

					$this->sql.=" `".$this->tablename."`.".$this->model_data->KEY."=".$this->model_data->ID;

				}

				if($where!=""){

					$this->sql.=" ".$where;

				}

				$this->app->objDB->setQuery($this->sql);

				$rstmp = $this->app->objDB->execute("tmp");

				if(count($rstmp)>0){

					return $rstmp[0][$field];

				}else{

					return NULL;

				}

			}

		}

						

		function map_fields($mapping=array()){

			if(!is_array($mapping)){

				$this->app->display_error(debug_backtrace(), "The argument \$mapping should be an array");

			}

			$this->fieldmapping = $mapping;

		}

		

		function record_exists($field_value=NULL, $return_field=NULL){

			$this->sql = "SELECT ";

			$this->sql.= $return_field!=NULL?$return_field:"`".$this->model_data->KEY."`";

			$this->sql.= " FROM `".$this->tablename."` WHERE ".$this->model_data->KEY." <>0 ";

			$strWhereClause="";

			if(!is_array($field_value) && $this->model_data->ID==0){

				if($field_value==""){

					$this->app->display_error(debug_backtrace(), "The argument \$field_value can not be blank", E_USER_ERROR);

				}

				$strWhereClause.="AND (".$field_value.")";

			}else if(is_array($field_value) && count($field_value)==0 && $this->model_data->ID==0){

				$this->app->display_error(debug_backtrace(), "The argument \$field_value should not be an empty array", E_USER_ERROR);

			}

			if($field_value!=NULL){

				if(is_array($field_value)){

					foreach($field_value as $key=>$value){

						if(array_key_exists($key, $this->model_data->fields)){

							$tmpArr = explode("(", $this->model_data->fields[$key]);

							$datatype = strtolower($tmpArr[0]);

							switch($datatype){

								case "int":

								case "tinyint":

								case "smallint":

								case "bigint":

								case "double":

								case "float":

								case "decimal":

									if($value!=""){

										$strWhereClause.=" AND `".$key."`=".$value;

									}else{

										$strWhereClause.=" AND `".$key."`=0";

									}

									break;

								case "varchar":

								case "tinytext":

								case "blob":

								case "mediumblob":

								case "longtext":

								case "mediumtext":

								case "longblob":

									$strWhereClause.=" AND `".$key."`='".$value."'";

									break;

								case "enum":

									if($value!=""){

										$strValues.=",'".$value."'";

									}else{

										$strWhereClause.=" AND `".$key."`='".$this->model_data->default_value[$key]."'";

									}

									break;

								case "date":

									if($value==""){

										$strWhereClause.=" AND `".$key."`='".date("Y-m-d")."'";

									}else{

										$strWhereClause.=" AND `".$key."`='".$value."'";

									}

									break;

								case "datetime":

									if($value==""){

										$strWhereClause.=" AND `".$key."`='".date("Y-m-d H:i:s")."'";

									}else{

										$strWhereClause.=" AND `".$key."`='".$value."'";

									}

									break;

								default:

									$strWhereClause.=" AND `".$key."`='".$value."'";

							}

						}else{

							$this->app->display_error(debug_backtrace(), "There is no field named ".$key." in the table ".$this->tablename, E_USER_ERROR);

						}

					}

				}

			}

			if($this->model_data->ID!=0){

				$strWhereClause.=" AND ".$this->model_data->KEY."=".$this->model_data->ID;



			}

			$this->sql.=$strWhereClause;

			if($return_field!=NULL){

				return $this->app->objDB->exists($this->sql, $return_field);

			}else{

				return $this->app->objDB->exists($this->sql);

			}

		}

		

		function build_query($QueryType, $SQL="", $WHERE="", $ORDERBY="", $GROUPBY=""){

			$this->sql = "";

			$QueryType = strtoupper($QueryType);

			switch($QueryType){

				case "INSERT":

					if($SQL!=""){

						$this->sql = $SQL;

					}else{

						$this->sql = "INSERT INTO `".$this->tablename."`";

						$arrFields=array();

						$arrValues=array();

						foreach($this->model_data->fields as $key=>$val){

							$value=NULL;

							if($this->model_data->KEY!=$key){

								if(array_key_exists($key, $this->fieldmapping)){

									if($this->trim_post_vars){

										$value=trim($this->fieldmapping[$key]);

									}else{

										$value=$this->fieldmapping[$key];

									}

								}

								if(!$this->only_custom_data){

									if($this->app->getPostVar($key)!==NULL){

										if($this->trim_post_vars){

											$value=trim($this->app->getPostVar($key));

										}else{

											$value=$this->app->getPostVar($key);

										}

									}else if($this->app->getGetVar($key)!==NULL){

										if($this->trim_post_vars){

											$value=trim($this->app->getGetVar($key));

										}else{

											$value=$this->app->getGetVar($key);

										}

									}

								}

								array_push($arrFields, $key);

								$tmpArr = explode("(", $val);

								$datatype = strtolower($tmpArr[0]);

								switch($datatype){

									case "int":

									case "tinyint":

									case "smallint":

									case "bigint":

									case "double":

									case "float":

									case "decimal":

										if($value!==NULL){

											$value=$value==""?"0":$value;

											array_push($arrValues, $value);

										}else{

											$value=$this->model_data->default_value[$key]==""?"0":$this->model_data->default_value[$key];

											array_push($arrValues, $value);

										}

										break;

									case "varchar":

									case "tinytext":

									case "blob":

									case "mediumblob":

									case "text":

									case "longtext":

									case "mediumtext":

									case "longblob":

										if($value!==NULL){

										

												$value = mysqli_real_escape_string($this->app->set_db_conn(),stripslashes($value));

											

											array_push($arrValues, "'".$value."'");

										}else{

											array_push($arrValues, "'".$this->model_data->default_value[$key]."'");

										}

										break;

									case "enum":

										if($value!==NULL){

											array_push($arrValues, "'".$value."'");

										}else{

											array_push($arrValues, "'".$this->model_data->default_value[$key]."'");

										}

										break;

									case "date":

										if($value=="" || $value===NULL){

											if($this->model_data->nullable[$key]=="NO"){

												array_push($arrValues, "'".date("Y-m-d")."'");

											}else{

												if($this->model_data->default_value[$key]!=""){

													array_push($arrValues, "'".$this->model_data->default_value[$key]."'");

												}else{

													array_push($arrValues, "NULL");

												}

											}

										}else{

											array_push($arrValues, "'".$value."'");

										}

										break;

									case "datetime":

										if($value==="" || $value===NULL){

											if($this->model_data->nullable[$key]=="NO"){

												array_push($arrValues, "'".date("Y-m-d H:i:s")."'");

											}else{

												if($this->model_data->default_value[$key]!=""){

													array_push($arrValues, "'".$this->model_data->default_value[$key]."'");

												}else{

													array_push($arrValues, "NULL");

												}

											}

										}else{

											array_push($arrValues, "'".$value."'");

										}

										break;

									default:

										array_push($arrValues, "'".$value."'");

								}

							}

						}

						$strFields="";

						$strValues="";

						for($i=0; $i<count($arrFields); $i++){

							if($i==(count($arrFields)-1)){

								$strFields.= "`".$arrFields[$i]."`";

								$strValues.= $arrValues[$i];

							}else{

								$strFields.= "`".$arrFields[$i]."`,";

								$strValues.= $arrValues[$i].",";

							}

						}

						$this->sql.= "(".$strFields.")";

						$this->sql.= " VALUES(".$strValues.")";

					}

				break;

				case "UPDATE";

					if($SQL!=""){

						$this->sql = $SQL;

					}else{

						$this->sql = "UPDATE `".$this->tablename."` SET ";

						$arrFields=array();

						$arrValues=array();

						foreach($this->model_data->fields as $key=>$val){

							$value=NULL;

							if($this->model_data->KEY!=$key){

								if(array_key_exists($key, $this->fieldmapping)){

									if($this->trim_post_vars){

										$value=trim($this->fieldmapping[$key]);

									}else{

										$value=$this->fieldmapping[$key];

									}

								}else if(!$this->only_custom_data){

									if($this->app->getPostVar($key)!==NULL){

										if($this->trim_post_vars){

											$value=trim($this->app->getPostVar($key));

										}else{

											$value=$this->app->getPostVar($key);

										}

									}else if($this->app->getGetVar($key)!==NULL){

										if($this->trim_post_vars){

											$value=trim($this->app->getGetVar($key));

										}else{

											$value=$this->app->getGetVar($key);

										}

									}else{

										continue;

									}

								}else{

									continue;

								}

								array_push($arrFields,$key);

								$tmpArr = explode("(", $val);

								$datatype = strtolower($tmpArr[0]);

								switch($datatype){

									case "int":

									case "tinyint":

									case "smallint":

									case "bigint":

									case "double":

									case "float":

									case "decimal":

										if($value!==NULL){

											$value=$value==""?"0":$value;

											array_push($arrValues,$value);

										}else{

											$value=$this->model_data->default_value[$key]==""?"0":$this->model_data->default_value[$key];

											array_push($arrValues, $value);

										}

										break;

									case "varchar":

									case "tinytext":

									case "blob":

									case "mediumblob":

									case "text":

									case "longtext":

									case "mediumtext":

									case "longblob":

										if($value!==NULL){

											

												$value = mysqli_real_escape_string($this->app->set_db_conn(),stripslashes($value));

											

											array_push($arrValues,"'".$value."'");

										}else{

											array_push($arrValues,"'".$this->model_data->default_value[$key]."'");

										}

										break;

									case "enum":

										if($value!==NULL){

											array_push($arrValues,"'".$value."'");

										}else{

											array_push($arrValues,"'".$this->model_data->default_value[$key]."'");

										}

										break;

									case "date":

										if($value=="" || $value===NULL){

											array_push($arrValues,"'".date("Y-m-d")."'");

										}else{

											array_push($arrValues,"'".$value."'");

										}

										break;

									case "datetime":

										if($value=="" || $value===NULL){

											array_push($arrValues,"'".date("Y-m-d H:i:s")."'");

										}else{

											array_push($arrValues,"'".$value."'");

										}

										break;

									default:

										array_push($arrValues,"'".$value."'");

								}

							}

						}

						for($i=0; $i<count($arrFields); $i++){

							if($i==(count($arrFields)-1)){

								$this->sql .= "`".$arrFields[$i]."` = ".$arrValues[$i]." ";

							}else{

								$this->sql .= "`".$arrFields[$i]."` = ".$arrValues[$i].", ";

							}

						}

						$this->sql.= " WHERE id!=0";

						if($WHERE!=""){

							$this->sql.=" AND ".$WHERE;

						}

						if($this->model_data->ID!=0){

							$this->sql.= " AND `".$this->tablename."`.".$this->model_data->KEY."=".$this->model_data->ID;

						}

					}

				break;

				case "DELETE";

					if($SQL!=""){

						$this->sql = $SQL;

					}else if($this->model_data->ID!=0 || $WHERE!=""){

						$this->sql = "DELETE FROM `".$this->tablename."` WHERE `".$this->tablename."`.".$this->model_data->KEY."!=0";

						if($this->model_data->ID!=0){

							$this->sql.=" AND `".$this->tablename."`.".$this->model_data->KEY."=".$this->model_data->ID;

						}

						if($WHERE!=""){

							$this->sql.= " AND ".$WHERE;

						}

					}else{

						$this->app->display_error(debug_backtrace(), "While executing delete QUERY, you must specify the value of Primary Key or a Where Clause", E_USER_ERROR);

					}

				break;

				case "SELECT";

					if($SQL==""){

						if(count($this->fieldstoselect)==0){

							$this->sql = "SELECT `".$this->tablename."`.* FROM `".$this->tablename."`";	

						}else{

							$this->sql = "SELECT `".$this->tablename."`.".$this->model_data->KEY;

							foreach($this->fieldstoselect as $field){

								$this->sql.= ", `".$this->tablename."`.".$field;

							}

							$this->sql.= " FROM `".$this->tablename."`";

						}

						$this->sql.= " WHERE id!=0";					

						if($WHERE!=""){

							$this->sql.=" AND ".$WHERE;

						}

						if($this->model_data->ID!=0){

							$this->sql.= " AND `".$this->tablename."`.".$this->model_data->KEY."=".$this->model_data->ID;

						}

						if($GROUPBY!=""){

							$this->sql.=" GROUP BY ".$GROUPBY;

						}

						if($ORDERBY!=""){

							$this->sql.=" ORDER BY ".$ORDERBY;

						}

					}else{

						$this->sql = $SQL;

					}				

				break;

				default:

					$this->sql = $SQL;

			}

		}

		

		public function join_table($table, $join_type="left", $fields=array(), $keys=array(), $join_condition=""){ 			

			if(is_array($table)){

				if(count($table)==1){

					$tmp				= array_keys($table);

					$primary_tbl_name	= $this->tablename;

					$primary_tbl_alias	= $this->tablename;

					$tbl_name			= $tmp[0];

					$alias 				= $table[$tmp[0]];

				}else if(count($table)==2){

					$tmp 				= array_keys($table);

					$primary_tbl_name	= $tmp[0];

					$primary_tbl_alias	= $table[$tmp[0]];

					$tbl_name			= $tmp[1];

					$alias 				= $table[$tmp[1]];

				}else{

					trigger_error("Invalid value for parameter $table", E_USER_ERROR);

					return false;

				}

			}else{

				$primary_tbl_name	= $this->tablename;

				$primary_tbl_alias	= $this->tablename;

				$tbl_name			= $table;

				$alias				= $table;

			}

			

			if(!is_array($fields)){

				if(strlen($fields)>0){

					$tmp_array = explode(",", $fields);

					$fields = array();

					foreach($tmp_array as $str){

						array_push($fields, trim($str));

					}

				}else{

					$fields = array();

				}

			}

			$model_class = $this->app->__load_model($tbl_name);

			if($model_class == NULL){

				trigger_error("No model found for ".$tbl_name, E_USER_ERROR);

				return false;

			}else{

				$obj_join_model = new $model_class();

			}

						

			if($primary_tbl_name != $this->tablename){

				$found = false;

				foreach($this->relations as $join_info){

					if($join_info["table"]["name"] == $primary_tbl_name){

						$found = true;

						break;

					}

				}

				if(!$found){

					trigger_error("Invalid primary table [".$primary_tbl_name."]. Primary table must be joined first", E_USER_ERROR);

					return false;

				}

				$model_class = $this->app->__load_model($primary_tbl_name);

				if($model_class == NULL){

					trigger_error("No model found for ".$primary_tbl_name, E_USER_ERROR);

					return false;

				}else{

					$obj_join_model_primary = new $model_class();

				}

			}else{

				$obj_join_model_primary = $this->model_data;

			}

			

			$join_info = array();

			

			if(strtoupper($join_type)=="LEFT"){

				$join_info["join_type"] = "LEFT";

			}else if(strtoupper($join_type)=="RIGHT"){

				$join_info["join_type"] = "RIGHT";

			}else if(strtoupper($join_type)=="INNER"){

				$join_info["join_type"] = "INNER";

			}else if(strtoupper($join_type)=="OUTER"){

				$join_info["join_type"] = "OUTER";

			}else{

				trigger_error("Invalid JOIN operation. Supported (left, right, inner, outer)", E_USER_ERROR);

				return false;

			}

			

			foreach($this->relations as $tmp_join_info){

				if($tmp_join_info["table"]["alias"] == $alias){

					trigger_error("Duplicate Table/Alias in JOIN operation", E_USER_ERROR);

					return false;

				}

			}



			$join_info["primary_table"] = array("name"=>$primary_tbl_name, "alias"=>$primary_tbl_alias);

			$join_info["table"] = array("name"=>$tbl_name, "alias"=>$alias);

			if(!is_array($fields)){

				trigger_error("Invalid value for parameter $fields. Parameter must be an array", E_USER_ERROR);

				return false;

			}

			if(count($fields)>0){

				$join_info["fields"] = $fields;

			}else{

				$join_info["fields"] = array_keys($obj_join_model->fields);

			}

			if(count($keys)>0){

				$tmp = array_keys($keys);

				$primary_table_key = $tmp[0];

				$foreign_table_key = $keys[$primary_table_key];

			}else{

				$primary_table_key = $obj_join_model_primary->KEY;

				$foreign_table_key = $primary_tbl_name."_".$obj_join_model_primary->KEY;

			}



						

			if(!array_key_exists($primary_table_key, $obj_join_model_primary->fields)){

				if(count($keys)>0){

					$msg = "Column ".$primary_table_key." is not found in the primary table schema (".$primary_tbl_name.")";

				}else{

					$msg = "No custom KEYS provided for join operation. Assumed default key ".$primary_table_key.", but this column is not found in the primary table schema (".$primary_tbl_name.")";

				}

				trigger_error($msg, E_USER_ERROR);

				return false;

			}else if(!array_key_exists($foreign_table_key, $obj_join_model->fields)){

				if(count($keys)>0){

					$msg = "Column ".$foreign_table_key." is not found in the foreign table schema (".$tbl_name.")";

				}else{

					$msg = "No custom KEYS provided for join operation. Assumed default key ".$foreign_table_key.", but this column is not found in the foreign table schema (".$tbl_name.")";

				}

				trigger_error($msg, E_USER_ERROR);

				return false;

			}else{

				$join_info["keys"] = array($primary_table_key=>$foreign_table_key);

			}		

			

			$join_info["join_condition"] = $join_condition==""?NULL:join_condition;

			array_push($this->relations, $join_info);

			return true;

		}

		

		function execute($QueryType, $Paging=false, $SQL="", $WHERE="", $ORDERBY="", $GROUPBY=""){

			if(count($this->relations)==0 || $QueryType!="SELECT"){

				$this->build_query($QueryType, $SQL, $WHERE, $ORDERBY, $GROUPBY);

				$this->app->objDB->groups = $this->groups;

				$this->app->objDB->setQuery($this->sql);

				return $this->app->objDB->execute("records_".get_class($this),$Paging, $this->tablename.".".$this->model_data->KEY);

			}else{	

				if(count($this->fieldstoselect)==0){

					$this->sql = "SELECT ".$this->tablename.".*";	

				}else{

					$this->sql = "SELECT ".$this->tablename.".".$this->model_data->KEY;

					foreach($this->fieldstoselect as $field){

						$this->sql.= ", ".$this->tablename.".".$field;

					}

				}

				foreach($this->relations as $join_info){

					if(is_array($join_info["fields"])){

						$tmp = array();

						foreach($join_info["fields"] as $field){

							array_push($tmp, $join_info["table"]["alias"].".".$field." AS ".$join_info["table"]["alias"]."_".$field);

						}

						$this->sql.= ", ".implode(", ", $tmp);

					}else{

						$this->sql.= ", ".$join_info["table"]["alias"].".".$join_info["fields"];

					}

				}

				$this->sql.= " FROM ".$this->tablename;

				foreach($this->relations as $join_info){

					$join_statement = " ";

					$join_statement.= $join_info["join_type"]." JOIN ".$join_info["table"]["name"]." AS ".$join_info["table"]["alias"]." ON(";

					$tmp = array_keys($join_info["keys"]);

					$join_statement.= $join_info["table"]["alias"].".".$join_info["keys"][$tmp[0]]."=".$join_info["primary_table"]["alias"].".".$tmp[0];

					if($join_info["join_condition"]!=NULL){

						$join_statement.=" ".$join_info["join_condition"];

					}

					$join_statement.=")";	

					$this->sql.=$join_statement;

				}

				$this->sql.= " WHERE ".$this->tablename.".".$this->model_data->KEY."!=0";

				if($this->model_data->ID!=0){

					$this->sql.=" AND ".$this->tablename.".".$this->model_data->KEY."=".$this->model_data->ID;

				}

				if($WHERE!=""){

					$this->sql.= " AND (".$WHERE.")";

				}

				if($GROUPBY!=""){

					$this->sql.= " GROUP BY ".$GROUPBY;

				}

				if($ORDERBY!=""){

					$this->sql.= " ORDER BY ".$ORDERBY;

				}

				$this->app->objDB->groups = $this->groups;

				$this->app->objDB->setQuery($this->sql);					

				return $this->app->objDB->execute("records_".get_class($this),$Paging, $this->tablename.".".$this->model_data->KEY);					

			}

		}

	}

?>