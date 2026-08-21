<?
	if(!defined("__CONFIG__")){
		require_once("../../core/config.php");
	}
	if(!class_exists("app")){
		require_once("../../core/app.php");
	}
	if(!class_exists("dbclass")){
		require_once("../../core/dbclass.php");
	}
	
	$objDB = dbclass::get_instance();
	
	$objDB->open();	
	$objDB->setQuery("SHOW TABLES");
	$rsTables = $objDB->resourceToArray($objDB->execute("tables"));
	$objDB->remove("tables");

	for($i=0; $i<count($rsTables); $i++){
		$objDB->setQuery("DESC ".$rsTables[$i]["Tables_in_".DB_DATABASE]);
		$rsStruct = $objDB->resourceToArray($objDB->execute("struct"));
		$objDB->remove("struct");
		
		if(count($rsStruct)>0){
			$className = "model_".$rsTables[$i]["Tables_in_".DB_DATABASE];
			$fp = fopen("../../models/".$className.".php", "w+");
			$indentation = 0;
			$strToWrite = indent($indentation)."<?php\n";		
			$indentation++;	
			$strToWrite.= indent($indentation)."class ".$className."{\n";
			$indentation++;	
			$strToWrite.= indent($indentation)."public \$fields= array();\n";
			$strToWrite.= indent($indentation)."public \$nullable= array();\n";
			$strToWrite.= indent($indentation)."public \$default_value= array();\n";
			$strToWrite.= indent($indentation)."public \$ID= 0;\n";
			$strToWrite.= indent($indentation)."public \$KEY= \"\";\n\n";
			
			$strToWrite.= indent($indentation)."function ".$className."(\$ID=0){\n";
			$indentation++;	
			$strToWrite.= indent($indentation)."\$this->ID = \$ID;\n";
			for($j=0; $j<count($rsStruct); $j++){
					if($rsStruct[$j]['Key']=="PRI"){
						$strToWrite.= indent($indentation)."\$this->KEY = \"".$rsStruct[$j]['Field']."\";\n";
					}
					$strToWrite.= indent($indentation)."\$this->fields[\"".$rsStruct[$j]['Field']."\"]=\"".$rsStruct[$j]['Type']."\";\n";
					$strToWrite.= indent($indentation)."\$this->nullable[\"".$rsStruct[$j]['Field']."\"]=\"".$rsStruct[$j]['Null']."\";\n";
					/*============= Special handling for default value of ENUM ==============*/
						$tmpArr = explode("(", $rsStruct[$j]['Type']);
						$datatype = strtolower($tmpArr[0]);
						if(strtolower($datatype)=="enum" && $rsStruct[$j]['Default']==""){
							$enumvals = explode(",",substr($tmpArr[1],0, strlen($tmpArr[1])-1));
							$strToWrite.= indent($indentation)."\$this->default_value[\"".$rsStruct[$j]['Field']."\"]=\"".str_replace("'", "", $enumvals[0])."\";\n";
						}else{
							$strToWrite.= indent($indentation)."\$this->default_value[\"".$rsStruct[$j]['Field']."\"]=\"".$rsStruct[$j]['Default']."\";\n";
						}
					/*=======================================================================*/
			}
			$indentation--;
			$strToWrite.= indent($indentation)."}\n";
			$indentation--;
			$strToWrite.= indent($indentation)."}\n";
			$indentation--;
			$strToWrite.= indent($indentation)."?>";
			fwrite($fp, $strToWrite, strlen($strToWrite));
			fclose($fp);
		}
	}
	
	function indent($indentation){
		$str = "";
		if($indentation!=0){			
			for($i=0; $i<$indentation; $i++){
				$str.="\t";
			}			
		}
		return $str;
	}
	
	$objDB->close();
?>