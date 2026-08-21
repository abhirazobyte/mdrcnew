<?
	abstract class controller{
		var $app;
		public $view;
		public $output_buffer;
		public $view_output;
		public $view_file;
		public $parser;
		public $include_global;
		
		abstract protected function init(); 
		
		public function __construct(){
			if(!defined("__MYMVC__")){
				echo "NO ACCESS !!";
				exit;
			}
			$this->app = &app::get_instance();
			$this->view = NULL;
			$this->output_buffer = "";
			$this->view_output = "";
			$this->view_file = "";
			$this->parser = NULL;
			$this->include_global = true;
			$this->init();
		}
		
		public function update_ouput($data){
			$this->view_output = $data;
		}
		
		public function initialize(){
			if($this->include_global){
				if(class_exists("global_include")){
					$this->app->global_include = new global_include();
					if(method_exists($this->app->global_include, "initalize")){
						$this->app->global_include->initalize();
					}
				}
			}
			if(method_exists($this, "onload")){
				$this->onload();
			}
		}
				
		public function load_parser($content){
			$this->parser = $this->app->load_module("XTemplate");
			if(!file_exists(ABS_PATH.DS."temp".DS."xtemplate_temp_files".DS)){
				if(!@mkdir(ABS_PATH.DS."temp".DS."xtemplate_temp_files", 755)){
					trigger_error("Could not create directory ".ABS_PATH.DS."temp".DS."xtemplate_temp_files", E_USER_ERROR);
				}
			}
			list($usec, $sec) = explode(' ', microtime()); 
			mt_srand((float) $sec + ((float) $usec * 100000)); 
			$randval = mt_rand(); 
			$f = fopen(ABS_PATH.DS."temp".DS."xtemplate_temp_files".DS.$randval.".xtpl", "w+");
			if(!$f){
				trigger_error("Could not create file ".ABS_PATH.DS."temp".DS."xtemplate_temp_files".DS.$randval.".xtpl", E_USER_ERROR);
			}
			$content="<!-- BEGIN: main -->\n".$content."\n<!-- END: main -->";
			fwrite($f, $content, strlen($content));
			fclose($f);
			$this->parser->filename = ABS_PATH.DS."temp".DS."xtemplate_temp_files".DS.$randval.".xtpl";
			$this->parser->setup();
		}
		
		public function unload_parser(){
			if($this->parser != NULL){
				if(file_exists($this->parser->filename)){
					if(is_file($this->parser->filename)){
						unlink($this->parser->filename);
					}
				}
				unset($this->parser);
				$this->parser = NULL;
			}
		}
		
		public function set_view($view){
			$this->view_file = ABS_PATH.DS."views".DS."view_".$view.".php";
		}
		
		public function assign($var="", $val=""){
			if($var==""){
				$this->display_error(debug_backtrace(), "\$var can not be an empty string", E_USER_ERROR);
			}
			$this->app->$var = $val;
		}
	}
?>