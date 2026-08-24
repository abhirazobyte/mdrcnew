<?php
	ob_start("execution_complete");
	session_start();
	session_gc();
	define("__APP__","1");
	define("__PRODUCT__", "MyMVC");
	define("__VER__","2.0.0");
	define("DS", DIRECTORY_SEPARATOR);
	if(strtoupper(substr(PHP_OS, 0, 3))=="WIN"){
		define("OS", "WIN");
	}else{
		define("OS", "UNIX");
	}
	function execution_complete($buffer){
		//TO DO
		//Output caching or output validation
		return $buffer;
	}
	/*============== If config was not included try to include ============*/
	if(!defined("__CONFIG__")){
		$core_directory = dirname(__FILE__);
		if(file_exists($core_directory.DS."config.php")){
			require_once($core_directory.DS."config.php");
			/*=== Check here for some mandatory constants in the config file===*/
			//TO DO
			/*=================================================================*/
		}else{
			/*====== IF CONF file is missing then redirect to setup folder ===== */
			header("location: setup/index.php");
			exit;
			/*=================================================================*/
		}
	}
	/*=====================================================================*/
	require_once(ABS_PATH.DS."core".DS."singleton.php");
	require_once(ABS_PATH.DS."core".DS."dbclass.php");
	require_once(ABS_PATH.DS."core".DS."utility.php");
	require_once(ABS_PATH.DS."core".DS."domsecure.php");
	require_once(ABS_PATH.DS."core".DS."htmlbuilder.php");
	require_once(ABS_PATH.DS."core".DS."controller.php");
	require_once(ABS_PATH.DS."core".DS."model.php");
	require_once(ABS_PATH.DS."core".DS."error_handler.php");
	require_once(ABS_PATH.DS."3rdparty".DS."inputfilter".DS."inputfilter.php");
	/*================= User Config Include ==================*/
	if(file_exists(ABS_PATH.DS."core".DS."user_config.php")){
		include(ABS_PATH.DS."core".DS."user_config.php");
	}
	/*========================================================*/
	/*================= Global Include =======================*/
	if(file_exists(ABS_PATH.DS."core".DS."global_include.php")){
		include(ABS_PATH.DS."core".DS."global_include.php");
	}
	/*========================================================*/
	/*================= Error handler and logging ============*/
	set_error_handler("custom_error");
	if(defined("ERROR_LOG")){
		if(ERROR_LOG != ""){
			if(is_writable(ERROR_LOG)){
				ini_set("log_errors", 1);
				ini_set("error_log", ERROR_LOG);
			}else{
				ini_set("log_errors", 0);
				trigger_error("Error log [".ERROR_LOG."] is not writable", E_USER_WARNING);
			}
		}
	}else{
		ini_set("log_errors", 0);
	}
	/*========================================================*/
	class app extends Singleton{
		public $objDB;
		public $mailer;
		public $mailqueue;
		public $domSecure;
		public $utility;
		public $htmlBuilder;
		public $isPostBack;
		public $referrer;
		public $no_html;
		public $no_view;
		public $root_relative;
		public $base_href;
		public $form_data;
		public $charset;
		public $check_posting_host;
		public $encrypt_url;
		public $enc_key;
		public $objCrypto;
		private $pageTitle;
		private $metaKeywords;
		private $metaDescription;
		private $metaSchema;
		private $view;
		private $controller;
		private $act;
		private $postVars;
		private $getVars;
		private $extra_header_tags;
		private $externalCSS;
		private $externalJS;
		private $bodyOnLoad;
		private $bodyStyle;
		private $usePageInfoTable;
		private $model;
		private $modules;
		private $output_buffer;
		private $is_complied;
		private	$is_packaged;
		private $cache;
		private $cache_file;
		private $cache_directory;
		private $cache_time;
		private $need_to_cache;
		private $execution_start_time;
		/*============ Public Functions ==================*/
		public function init(){
			define("__MYMVC__", "1");
			$this->objDB			= dbclass::get_instance();
			$this->model			= model::get_instance();
			$this->utility 			= utility::get_instance();
			$this->domSecure 		= domSecure::get_instance();
			$this->htmlBuilder		= htmlBuilder::get_instance();
			$this->inputfilter		= InputFilter::get_instance();
			$this->userconfig		= (object)NULL;
			$this->global_include	= (object)NULL;
			$this->no_html			= false;
			$this->root_relative	= "";
			$this->bodyOnLoad		= array();
			$this->bodyStyle		= array();
			$this->extra_header_tags = array();
			$this->postVars			= array();
			$this->getVars			= array();
			$this->externalCSS		= array();
			$this->externalJS		= array();
			$this->pageTitle		= NULL;
			$this->metaKeywords		= NULL;
			$this->metaDescription	= NULL;
			$this->metaSchema		= NULL;
			$this->usePageInfoTable	= true;
			$this->form_data		= array();
			$this->modules			= array();
			$this->base_href		= NULL;
			$this->charset			= "iso-8859-1";
			$this->output_buffer	= "";
			$this->check_posting_host = false;
			$this->is_complied		= false;
			$this->is_packaged		= false;
			$this->encrypt_url 		= false;
			$this->enc_key			= "";
			$this->objCrypto		= NULL;
			$this->cache			= false;
			$this->cache_directory	= "";
			$this->set_cache_time	= 0;
			$this->need_to_cache	= false;
			$this->base_href 		= SERVER_ROOT."/".VIR_DIR;
			$this->execution_start_time = (float) array_sum(explode(' ',microtime()));
			$this->initialize();
		}
		public static function get_instance() {
			parent::$my_name = __CLASS__;
			return parent::get_instance();
		}
		public function initialize(){
			if($this->encrypt_url){
				if($this->enc_key==""){
					trigger_error("It is must to setup app::enc_key while using app::encrypt_url", E_USER_ERROR);
					return;
				}else{
					$this->objCrypto = $this->load_module("crypto");
					$this->objCrypto->key = $this->enc_key;
				}
			}
			/*============== Input filtering / stop code injection =========*/
			$_POST = $this->inputfilter->process($_POST);
			$_GET = $this->inputfilter->process($_GET);
			/*=============================================================*/
			/*============== DUMP all GET and POST variables securely ======*/
			foreach($_POST as $key=>$val){
				$this->postVars[$key]=$this->domSecure->loadVariable($key,"","POST");
			}
			if($this->encrypt_url){
				if(array_key_exists("__mvc__", $_GET)){
					$data = $this->domSecure->loadVariable("__mvc__","","GET");
					if($data==""){
						trigger_error("It does not seems to be a valid Encrypted Data", E_USER_ERROR);
					}else{
						try{
							$decrypted_data = $this->objCrypto->decodeString(urldecode($data));
							$tmp_array = explode("&", $decrypted_data);
							foreach($tmp_array as $key_val_pair){
								$tmp = explode("=", $key_val_pair);
								$this->getVars[$tmp[0]]=count($tmp)==2?$tmp[1]:"";
							}
						}catch(Exception $e){
							trigger_error("It does not seems to be a valid Encrypted Data", E_USER_ERROR);
						}
					}
				}
			}else{
				foreach($_GET as $key=>$val){
					$this->getVars[$key]=$this->domSecure->loadVariable($key,"","GET");
				}
			}
			/*=============================================================*/
			foreach($_POST as $key=>$val){
				unset($_POST[$key]);
			}
			foreach($_GET as $key=>$val){
				unset($_GET[$key]);
			}
			foreach($_REQUEST as $key=>$val){
				unset($_REQUEST[$key]);
			}
			$this->objDB->open();
			if(class_exists("userconfig")){
				$this->userconfig = new userconfig;
			}
			$tmparr = explode("/", VIR_DIR);
			foreach($tmparr as $val){
				if(trim($val)!=""){
					$this->root_relative.="../";
				}
			}
			$this->referrer		= $this->domSecure->referrerHost;
			//$this->view			= $this->getRequestVar("view","default");
			if(VIR_DIR=='admin/'){
				$this->view			= $this->getRequestVar("view","default");
			}
			else {
				$this->view			= $this->getRequestVar("view","home");
			}
			$this->act			= $this->getRequestVar("act","");
			if($_SERVER['REQUEST_METHOD']=="POST"){
				$ref_view = "";
				if(isset($_POST[__PRODUCT__."_REF_VIEW"])){
					$ref_view = $_POST[__PRODUCT__."_REF_VIEW"];
				}else{
					$tmparr = array();
					if(isset($_SERVER['HTTP_REFERER'])){
						$tmparr = explode("?",$_SERVER['HTTP_REFERER']);
					}
					if(count($tmparr)>1){
						$tmparr = explode("&", $tmparr[1]);
						foreach($tmparr as $pair){
							$keyval = explode("=",$pair);
							if($keyval[0]=="view"){
								$ref_view = $keyval[1];
								break;
							}
						}
					}
				}
				if(($ref_view!="" || $this->view!="") && $ref_view==$this->view){
					$this->isPostBack = true;
				}else{
					$this->isPostBack = false;
				}
			}
		}
		function unload(){
			$this->objDB->close();
			if(count(ob_get_status())>0){
				ob_flush();
			}
		}
		public function enable_cache($cache_file_name){
			$ok = false;
			if($cache_file_name!=""){
				if($this->cache_directory==""){
					if(defined("CACHE_DIR")){
						if(CACHE_DIR != ""){
							if($this->set_cache_directory(CACHE_DIR)){
								$ok = true;
							}
						}else{
							trigger_error("CACHE_DIR can not be an empty string", E_USER_WARNING);
						}
					}else{
						trigger_error("Cache directory is not set. Set CACHE_DIR in config file or use app::set_cache_directory() to specify a cache directory", E_USER_WARNING);
					}
				}else{
					$ok = true;
				}
				if($ok){
					$this->cache = true;
					if($this->cache_time ==0){
						if(!$this->set_cache_time(defined("CACHE_TIME")?CACHE_TIME:60)){
							$this->set_cache_time(60);
						}
					}
					$this->cache_file = basename($cache_file_name);
				}
			}else{
				trigger_error("Cache file name cannot be empty", E_USER_WARNING);
			}
			return $ok;
		}
		public function disable_cache(){
			$this->cache = false;
		}
		public function set_cache_directory($directory){
			$ok = false;
			if(is_dir($directory)){
				if(is_writable($directory)){
					/*=============== Remove trailing \ or / ===============*/
					$tmp = substr($directory, strlen($directory)-1, 1);
					while($tmp=="\\" || $tmp=="/"){
						$directory = substr($directory, 0, strlen($directory)-1);
						$tmp = substr($directory, strlen($directory)-1, 1);
					}
					/*======================================================*/
					$this->cache_directory = $directory;
					$ok = true;
				}
			}
			if(!$ok){
				trigger_error("Cache directory [".$directory."] is not writable", E_USER_WARNING);
			}
			return $ok;
		}
		public function set_cache_time($time){
			if(is_numeric($time)){
				if($time < 30){
					trigger_error("You cannot set a cache time lower than 30 seconds", E_USER_WARNING);
					return false;
				}else{
					$this->cache_time = $time;
					return true;
				}
			}else{
				trigger_error("Invalid argument. The argument \$time should be numeric and greater than 29", E_USER_WARNING);
				return false;
			}
		}
		public function getPageTitle(){
			return $this->pageTitle;
		}
		public function getMetaSchema(){
			return $this->metaSchema;
		}
		public function getCurrentPage(){
			return $this->getRequestVar("pg_no")==NULL?0:$this->getRequestVar("pg_no");
		}
		public function getCurrentView(){
			return $this->view;
		}
		public function getCurrentAction(){
			return $this->act;
		}
		public function getMetaKeywords(){
			return $this->metaKeywords;
		}
		public function getMetaDescription(){
			return $this->metaDescription;
		}
		public function getPostVars(){
			return $this->postVars;
		}
		public function getGetVars(){
			return $this->getVars;
		}
		public function getPostVar($key, $default_value = NULL){
			if(isset($this->postVars[$key])){
				return $this->postVars[$key];
			}else{
				return $default_value;
			}
		}
		public function getGetVar($key, $default_value = NULL){
			if(isset($this->getVars[$key])){
				return $this->getVars[$key];
			}else{
				return $default_value;
			}
		}
		public function getRequestVar($key, $default_value = NULL){
			if(isset($this->getVars[$key])){
				return $this->getVars[$key];
			}else if(isset($this->postVars[$key])){
				return $this->postVars[$key];
			}else{
				return $default_value;
			}
		}
		function display_error($debug_info=NULL, $err_msg="", $errortype=E_USER_WARNING){
			if($debug_info==NULL){
				$debug_info = debug_backtrace();
			}
			$errmsg = "Error in: function <strong>".$debug_info[0]["function"]."()</strong><br />";
			$errmsg.= "in <strong>".$debug_info[0]["file"]."</strong><br />";
			$errmsg.= "at line no <strong>".$debug_info[0]["line"]."</strong><br />";
			$errmsg.= "Additional Information<hr>";
			$errmsg.= $err_msg==""?"No more information available":$err_msg;
			trigger_error($errmsg, $errortype);
		}
		function addheadertag($tag){
			array_push($this->extra_header_tags, $tag);
		}
		function bodyonload($onload){
			array_push($this->bodyOnLoad, $onload);
		}
		function bodystyle($style){
			$this->bodyStyle = $style;
		}
		public function addcss($css){
			array_push($this->externalCSS, $css);
		}
		public function addjs($js){
			array_push($this->externalJS, $js);
		}
		function redirect($url){
			$this->objDB->close();
			header("location: ".$url);
			exit;
		}
		function stop(){
			$this->objDB->close();
			exit;
		}
		function get_user_config($var){
			if(isset($this->userconfig->config[$var])){
				return $this->userconfig->config[$var];
			}else{
				$this->display_error(debug_backtrace(),"There is no varilable named <strong>".$var."</strong> in user config", E_USER_WARNING);
			}
		}
		public function use_page_info_table($newval){
			$this->usePageInfoTable = (bool)$newval;
		}
		public function assign($var="", $val=""){
			if($var==""){
				$this->display_error(debug_backtrace(), "\$var can not be an empty string", E_USER_ERROR);
			}
			$this->$var = $val;
		}
		public function load_module($module_name, $force_new_load = false){
			  $module_name = str_replace("\\", "/", $module_name);
			/*======== Remove preeceding and trailing slashes ======*/
			if(substr($module_name, 0 , 1)=="/"){
				$module_name = substr($module_name, 1);
			}
			if(substr($module_name, strlen($module_name)-1 , 1)=="/"){
				$module_name = substr($module_name, 0, strlen($module_name)-1);
			}
			/*======================================================*/
			$tmp = explode("/", $module_name);
				if(count($tmp)==1){
					$module_path = $module_name;
				}else{
					$module_path = implode(DS, $tmp);
					$module_name = $tmp[count($tmp)-1];
				}
			if(class_exists($module_name) && array_key_exists($mdoule_name, $this->modules) && $force_new_load==false){
				return $this->modules[$module_name];
			}else if(class_exists($module_name) && !array_key_exists($mdoule_name, $this->modules)){
				$this->modules[$module_name] = new $module_name();
				return $this->modules[$module_name];
			}else{
				$module = ABS_PATH.DS."modules".DS.$module_path.DS."class.".$module_name.".php";
				if(file_exists($module)){
					require_once($module);
						if(!class_exists($module_name)){
							$this->display_error(debug_backtrace(), "<strong>".$module."</strong> does not have a class named <strong>".$module_name."</strong>",  E_USER_ERROR);
							return NULL;
						}else{
							$this->modules[$module_name] = new $module_name();
							return $this->modules[$module_name];
						}
				}
				else{
					$this->display_error(debug_backtrace(), "could not find the module <strong>".$module."</strong>",  E_USER_ERROR);
					return NULL;
				}
			}
		}
		public function stringEval($str){
			preg_match_all("/{([a-z_]+)=>([a-z_]+)=>([a-z_]+)=>([a-z_]+)}/",$str,$matches);
			if(count($matches)>0){
				for($cnt=0;$cnt<count($matches[0]);$cnt++){
					$val="";
					if(substr($matches[3][$cnt],0,2)=="g_"){
						$val = $this->getGetVar(substr($matches[3][$cnt],2));
					}
					if(substr($matches[3][$cnt],0,2)=="p_"){
						$val = $this->getPostVar(substr($matches[3][$cnt],2));
					}
					if(substr($matches[3][$cnt],0,2)=="s_"){
						$val = $_SESSION[substr($matches[3][$cnt],2)];
					}
					if(substr($matches[3][$cnt],0,2)=="u_"){
						$val = substr($matches[3][$cnt],2);
					}
					if($val!=""){
						$this->objDB->setQuery("SELECT ".$matches[4][$cnt]." FROM ".$matches[1][$cnt]." WHERE ".$matches[2][$cnt]."='".$val."'");
						$rsTmp = $this->objDB->execute("eval");
						if(count($rsTmp)>0){
							$str = str_replace($matches[0][$cnt],$rsTmp[0][$matches[3][$cnt]],$str);
						}else{
							$str = str_replace($matches[0][$cnt],"",$str);
						}
						$this->objDB->remove("eval");
					}else{
						$str = str_replace($matches[0][$cnt],"",$str);
					}
				}
			}
			return $str;
		}
		public function execute(){
			$error = $this->execute_controller();
			if($error!=""){
				$this->display_error(debug_backtrace(), $error, E_USER_ERROR);
			}else{
				if($this->cache===$this->need_to_cache){
					if(!$this->is_packaged){
						$this->package();
					}
				}
			}
			if($this->need_to_cache){
				file_put_contents($this->cache_directory.DS.$this->cache_file, $this->output_buffer);
			}
			$execution_end_time = (float) array_sum(explode(' ',microtime()));
			if(VIR_DIR == 'appApi/' || VIR_DIR == 'webApi/' || VIR_DIR == 'deliveryApi/'   || VIR_DIR == 'iosapp/' || VIR_DIR == 'mapp/'   ){
			}
			else
			{
			$this->output_buffer.="\n<!-- Generated by ".__PRODUCT__." ".__VER__." in ".sprintf("%.4f", ($execution_end_time-$this->execution_start_time))." seconds -->";
			}
			echo $this->output_buffer;
			ob_flush();
		}
		public function package(){
			if(!$this->is_complied){
				$this->compile();
			}
			$this->output_buffer.=ob_get_contents();
			ob_clean();
			if(!$this->no_html){
				$this->output_buffer.= $this->getHTMLHeader();
			}
			$this->output_buffer.= $this->controller->view_output;
			if(!$this->no_html){
				$this->output_buffer.= $this->getHTMLFooter();
			}
		}
		/*=========== Parse The View File Content ========*/
		public function compile(){
			$this->output_buffer.= ob_get_contents();
			ob_clean();
			if(!$this->no_view && $this->controller->view_file!=""){
				$tmp = file_get_contents($this->controller->view_file);
				if(preg_match("/<body>(.*?)<\/body>/is", $tmp, $matches)){
					$tmp = $matches[1];
				}
				if($this->encrypt_url){
					if(preg_match_all("/(<a .*?href.*?=.*?[\"|'])(.*?)([\"|'].*?)(>)/is", $tmp, $matches)){
						foreach($matches[2] as $link){
							$url_info = parse_url($link);
							$encrypted_url = $url_info["path"]."?__mvc__=".urlencode($this->objCrypto->encodeString($url_info["query"]));
							$tmp = str_replace($link, $encrypted_url, $tmp);
						}
					}
				}
				eval("?>".$tmp."<?");
				$this->controller->view_output =ob_get_contents();
				ob_clean();
			}
			$this->is_complied = true;
			return $this->controller->view_output;
		}
		/*================================================*/
		/*===================================================
		/* Include Controller and View
		/* Validate Controller Class
		/* Validate if controller contains the method of act
		/*=================================================*/
		private function execute_controller(){
			$ret_val = "";
			$Controller = ABS_PATH.DS.VIR_DIR."controllers".DS."controller_".$this->view.".php";
			/*======= Check if controller file exists =======*/
			if(file_exists($Controller)){
				include($Controller);
				/*=== Check if controller contain the class (_[$this->view]) ==*/
				if(class_exists("_".$this->view)){
					$ControllerClass = "_".$this->view;
					$this->controller = new $ControllerClass;
					if(get_parent_class($this->controller)=="controller"){
						$continue = true;
						if($this->cache){
							if($this->cache_directory != ""){
								$cache_file = $this->cache_directory.DS.$this->cache_file;
								if(file_exists($cache_file)){
									if ((file_exists($cache_file)) && (time() <= (filemtime($cache_file) + $this->cache_time))){
										echo file_get_contents($cache_file);
										$this->need_to_cache = false;
										$continue = false;
									}else{
										$this->need_to_cache = true;
									}
								}else{
									$this->need_to_cache = true;
								}
							}else{
								trigger_error("Cache directory is not set. Set CACHE_DIR in config file or use app::set_cache_directory() to specify a cache directory", E_USER_WARNING);
							}
						}
						if($continue){
							if($this->controller->view == NULL){
								$this->controller->view = $this->view;
							}
							$ViewFile = ABS_PATH.DS.VIR_DIR."views".DS."view_".$this->controller->view.".php";
							if(file_exists($ViewFile)){
								$this->controller->view_file = $ViewFile;
							}else{
								$this->controller->view_file = "";
								trigger_error("View file [".$ViewFile."] does not exists. If you do not have a view file, then set app::no_view to TRUE", E_USER_WARNING);
							}
							$this->controller->initialize();
							/*=== If $this->act not blank, check existance of method inside controller class ==*/
							if($this->act!=""){
								if (!method_exists($this->controller, $this->act)){
									//Raise Error Missing Class In Controller
									$ret_val = "Controller class [".$ControllerClass."] does not have the method ".$this->act;
									$invalidAct=1;
								}else{
									$action = $this->act;
									$this->controller->$action();
								}
							}
						}
					}else{
						$ret_val = "class <strong>_".$this->view."</strong> should extends the base class <strong>controller</strong>";
					}
				}else{
					//Raise Error Missing Class In Controller
					$ret_val = "Controller does not have the class _".$this->view;
				}
			}else{
				//Raise Error Missing Controller
				$ret_val = "Missing Controller controller_".$this->view;
			}
			return $ret_val;
		}
		/*================================================*/
		public function load_model($model_name, $ID=0){
			$model_class = $this->__load_model($model_name);
			if($model_class != NULL){
				$obj_model = new $model_class($ID);
				$this->model->set_model_data($obj_model);
				$this->model->set_fields_to_get(NULL);
				$this->model->clear_groups();
				return $this->model;
			}else{
				return NULL;
			}
		}
		public function __load_model($model_name){
			$model_class = NULL;
			if(!class_exists("model_".$model_name)){
				if(file_exists(ABS_PATH.DS."models".DS."model_".$model_name.".php")){
					include(ABS_PATH.DS."models".DS."model_".$model_name.".php");
					if(class_exists("model_".$model_name)){
						$model_class = "model_".$model_name;
					}else{
						trigger_error("Could not load Model ".$model_name, E_USER_ERROR);
					}
				}else{
					trigger_error("Could not load Model ".$model_name, E_USER_ERROR);
				}
			}else{
				$model_class = "model_".$model_name;
			}
			return $model_class;
		}
		/*= Functions to iterate js folder and include the files ===*/
		private function IncludeJS($JsFile){
			$JsFile = $this->utility->HTMLSafeString($JsFile);
			return "<script type=\"text/javascript\" src=\"".$JsFile."\"></script>\n";
		}
		private function LookForJS(){
			$JSIncludes="";
			$arrFiles = array();
			$JsDirPath = ABS_PATH.DS.VIR_DIR."js";
			if(file_exists($JsDirPath)){
				$d = opendir($JsDirPath);
				if($d){
					while($f = readdir($d)){
						array_push($arrFiles, $f);
					}
					asort($arrFiles);
					foreach($arrFiles as $file){
						if(strlen($file)>4){
							$tmpArr = explode(".",$file);
							if(count($tmpArr)>0){
								$EXT = strtoupper($tmpArr[count($tmpArr)-1]);
								unset($tmpArr);
								if($EXT=="JS"){
									$JSIncludes.= $this->IncludeJS("js/".$file);
								}
							}
						}
					}
					closedir($d);
				}
			}
			return $JSIncludes;
		}
		/*==========================================================*/
		/*= Functions to iterate css folder and include the files ==*/
		private function IncludeCSS($CSSFile){
			$CSSFile = $this->utility->HTMLSafeString($CSSFile);
			return "<link href=\"".$CSSFile."\" rel=\"stylesheet\" type=\"text/css\" />\n";
		}
		private function LookForCSS(){
			$CSSIncludes="";
			$CSSDirPath = ABS_PATH.DS.VIR_DIR."css";
			if(file_exists($CSSDirPath)){
				$d = opendir($CSSDirPath);
				if($d){
					while($f = readdir($d)){
						if(strlen($f)>4){
							$tmpArr = explode(".",$f);
							if(count($tmpArr)>0){
								$EXT = strtoupper($tmpArr[count($tmpArr)-1]);
								unset($tmpArr);
								if($EXT=="CSS"){
									$CSSIncludes.= $this->IncludeCSS("css/".$f);
								}
							}
						}
					}
				}
			}
			return $CSSIncludes;
		}
		/*==========================================================*/
		function add_extra_header_tags(){
			$retStr="";
			foreach($this->extra_header_tags as $tag){
				$retStr.=$tag."\n";
			}
			return $retStr;
		}
		function add_external_css(){
			$retStr="";
			foreach($this->externalCSS as $css){
				$retStr.= $this->IncludeCSS($css);
			}
			return $retStr;
		}
		function add_external_js(){
			$retStr="";
			foreach($this->externalJS as $js){
				$retStr.= $this->IncludeJS($js);
			}
			return $retStr;
		}
		private function getHTMLHeader(){
			/*============== Set Page Title, Keyword, Description =================*/
			$CurrentView = $this->view;
			if($CurrentView==""){
				if($this->pageTitle==NULL){
					$this->pageTitle = DEFAULT_TITLE;
				}
				if($this->metaKeywords==NULL){
					$this->metaKeywords	= DEFAULT_KEYWORDS;
				}
				if($this->metaDescription==NULL){
					$this->metaDescription = DEFAULT_DESCRIPTION;
				}
				if($this->metaSchema==NULL){
					$this->metaSchema =NULL;
				}
			}else{
				if($this->usePageInfoTable){
					$this->objDB->setQuery("SELECT * FROM page_info WHERE page_name='".$CurrentView."'");
					$rs = $this->objDB->execute("pageinfo");
				}else{
					$rs = array();
				}
				if(count($rs)>0){
					$default_string = array("{CITY}");
					$new_string = array($_SESSION['cityName']);
					if($this->pageTitle==NULL){
						$meta_title = str_replace($default_string, $new_string,$rs[0]["page_title"]);
						$this->pageTitle = $meta_title;
					}
					if($this->metaKeywords==NULL){
						$meta_keyword = str_replace($default_string, $new_string,$rs[0]["meta_keywords"]);
						$this->metaKeywords	= $meta_keyword;
					}
					if($this->metaDescription==NULL){
						$meta_description = str_replace($default_string, $new_string,$rs[0]["meta_description"]);
						$this->metaDescription = $meta_description;
					}
					if($this->metaSchema==NULL){
						$meta_schema = str_replace($default_string, array(strtolower($_SESSION['cityName'])),$rs[0]["meta_schema"]);
						$this->metaSchema = $meta_schema;
					}
				}else{
					if($this->pageTitle==NULL){
						$this->pageTitle = DEFAULT_TITLE;
					}
					if($this->metaKeywords==NULL){
						$this->metaKeywords	= DEFAULT_KEYWORDS;
					}
					if($this->metaDescription==NULL){
						$this->metaDescription = DEFAULT_DESCRIPTION;
					}
					if($this->metaSchema==NULL){
						$this->metaSchema =NULL;
					}
				}
				$this->objDB->remove("pageinfo");
			}
			/*===================================================================*/
			/*========== If Title, Keyword or Description has variables =========*/
			$this->pageTitle 		= $this->stringEval($this->pageTitle);
			$this->metaKeywords 	= $this->stringEval($this->metaKeywords);
			$this->metaDescription 	= $this->stringEval($this->metaDescription);
			/*===================================================================*/
			if(VIR_DIR == 'admin/' )
			{
		$tmpStr="<!DOCTYPE html>\n";
		$tmpStr.="<html lang=\"en\">\n";
		if($this->base_href!=NULL)
		{
			$tmpStr.="<base href=\"".$this->base_href."\" />\n";
		}
		$tmpStr.="<head>\n";
		//$tmpStr.="<meta charset=\"utf-8\" />\n";
		$tmpStr.="<meta charset='utf-8'>\n";
		$tmpStr.="<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>\n";
		$tmpStr.="<link rel='shortcut icon' type='image/x-icon' href='../images/favicon.png'>\n";
		
		
		$tmpStr.="<title>".$this->getPageTitle()."</title>\n";
		$tmpStr.="<meta name=\"keywords\" content=\"".$this->getMetaKeywords()."\"  />\n";
		$tmpStr.="<meta name=\"description\" content=\"".$this->getMetaDescription()."\"  />\n";
		$tmpStr.="<meta name='robots' content='noindex,nofollow'/>\n";
		
		$tmpStr.="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\" />\n";
		
		$tmpStr.=$this->add_external_js();
		$tmpStr.=$this->add_extra_header_tags();
		
		
		$tmpStr.="</head>\n";
		$tmpStr.="<body class='df-roboto'";
		$tmpStr.=">\n";
	}
	else if(VIR_DIR == 'm/' )
	{
		$tmpStr="<!DOCTYPE HTML>\n";
		$tmpStr.="<html lang=\"en\">\n";
		if($this->base_href!=NULL){
			$tmpStr.="<base href=\"".$this->base_href."\" />\n";
		}
		$tmpStr.="\n";
		$tmpStr.="<head>\n";
		
		$tmpStr.="<meta name='robots' content='noindex,nofollow'/>\n";
		$tmpStr.="\n";

		$tmpStr.="<meta http-equiv=\"Content-Type\" charset=\"text/html; charset=UTF-8\">\n";
		
		$tmpStr.="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\">\n";
		$tmpStr.="<title>".$this->getPageTitle()."</title>\n";
		$tmpStr.="<link rel=\"icon\" type=\"image/x-icon\" href=\"assets/images/favicon.png\">\n";
		$tmpStr.="\n";
		$tmpStr.='
		<!-- Bootstrap 5 -->
		<link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.css" />
	
		<!-- Iconly Icon css -->
		<link rel="stylesheet" type="text/css" href="assets/css/iconly.css" />
	
		<!-- Slick css -->
		<link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css" />
	
		<!-- Style css -->
		<link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
	
		<!-- Custom Css -->
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css?v=1.2" />
		<link rel="stylesheet" type="text/css" href="assets/css/custom2.css" />

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css" />	
		';
		$tmpStr.="\n";
	}
			else
			{
			$tmpStr.="<!DOCTYPE HTML>\n";
			$tmpStr.="<!--[if IE 9 ]><html class=\"ie9\" lang=\"en\"><![endif]-->\n";
			$tmpStr.="<!--[if (gt IE 9)|!(IE)]><!--><html lang=\"en\"><!--<![endif]-->\n";
			if($this->base_href!=NULL){
				$tmpStr.="<base href=\"".$this->base_href."\" />\n";
			}
			$tmpStr.="\n";
			$tmpStr.="<head>\n";
			
			$tmpStr.="<meta name='robots' content='noindex,nofollow'/>\n";
			$tmpStr.="\n";
			
			$tmpStr.="<meta charset=\"utf-8\">\n";
			$tmpStr.="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\">\n";
			$tmpStr.="<title>".$this->getPageTitle()."</title>\n";
			$tmpStr.="<link rel=\"icon\" type=\"image/ico\" href=\"images/favicon.png\">\n";
			$tmpStr.="\n";
			
			 
			$tmpStr.="<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\">\n";
     		//$tmpStr.="<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i&display=swap\" rel=\"stylesheet\">\n";
    		//$tmpStr.="<link href=\"https://fonts.googleapis.com/css?family=Libre+Baskerville:300,300i,400,400i,500,500i&display=swap\" rel=\"stylesheet\">\n";
			$tmpStr.="<link href=\"https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,900&display=swap\" rel=\"stylesheet\">\n";
			 
			$tmpStr.="\n";
			// EXTERNAL API REMOVED: Cloudflare Turnstile
			$tmpStr.="\n";

			 $tmpStr.="</head>\n";
				
				
				
				
				
				if($this->getCurrentView()=='home') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-index kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				else if($this->getCurrentView()=='products') 
				{					
					$tmpStr.="<body class=\"kalles-template single-product-template zoom_tp_2 header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 css_scrollbar template-index kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				else if($this->getCurrentView()=='product_detail') 
				{					
					$tmpStr.="<body class=\"kalles-template single-product-template zoom_tp_2 header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 css_scrollbar template-index kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				
				else if($this->getCurrentView()=='about_us') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				else if($this->getCurrentView()=='contact_us') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				else if($this->getCurrentView()=='page') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				else if($this->getCurrentView()=='cart') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				else if($this->getCurrentView()=='checkout') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				else if($this->getCurrentView()=='wishlist') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				else if($this->getCurrentView()=='account') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				
				else if($this->getCurrentView()=='my_wallet') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				else if($this->getCurrentView()=='faq') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				else if($this->getCurrentView()=='my_address') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
			
			
					else if($this->getCurrentView()=='payment_success') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
				
				
					else if($this->getCurrentView()=='payment_failed') 
				{					
					$tmpStr.="<body class=\"kalles-template header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-cart kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				
				
			
			
				
				
				
				
				
				
				else
				{
					$tmpStr.="<body class=\"kalles-template single-product-template zoom_tp_2 header_full_true des_header_3 css_scrollbar lazy_icons btnt4_style_2 css_scrollbar template-index kalles_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true hide_scrolld_true lazyload\">";
				}
				$tmpStr.="\n";
	
	
			}
			return $tmpStr;
		}
		private function getHTMLFooter()
		{
			if(VIR_DIR == 'appApi/' || VIR_DIR == 'webApi/' || VIR_DIR == 'deliveryApi/')
			{
			}
			else
			{
				$tmpStr.="</body>\n";
				$tmpStr.="</html>";
				return $tmpStr;
			}
		}
		/************************************************/
		/*	Addded by Rakesh on 7-11-2008 to controll	*/
		/*	Title, Keywords and Description Manually 	*/
		/************************************************/
		public function setTitle($title){
			$this->pageTitle = $title;
		}
		public function setKeywords($keywords){
			$this->metaKeywords = $keywords;
		}
		public function setDescription($description){
			$this->metaDescription = $description;
		}
		public function setSchema($metaSchema){
			$this->metaSchema = $metaSchema;
		}
		/************************************************/
		/************************************************/
		/*	Addded by Atul on 12-08-2009 to populate	*/
		/*	form data from record set directly		 	*/
		/************************************************/
		function assign_form_data($form_name, $recordset){
			$this->form_data[$form_name] = $recordset;
		}
		/************************************************/
		/************************************************/
		/*	Addded by Rakesh on 06-04-2010				*/
		/*	Get SQL Query Stack		 					*/
		/************************************************/
		function get_query_stack(){
			return $this->objDB->get_query_stack();
		}
		/************************************************/
		/************************************************/
		/*	Addded by Rakesh on 06-04-2010				*/
		/*	Get a detailed recordset Array()			*/
		/************************************************/
		function get_recordset_detail($model_name){
			return $this->objDB->getRecordset("model_".$model_name);
		}
		function set_db_conn(){
			return $this->objDB->get_db_conn_var();
		}
	}
?>