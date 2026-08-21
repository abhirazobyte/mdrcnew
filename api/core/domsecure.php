<?
	class domSecure extends Singleton{
		private $objDB;
		private $app;
		public $referrerHost;
		public $isReferrerSecured;
		
		public static function &get_instance() { 
			parent::$my_name = __CLASS__; 
			return parent::get_instance(); 
		}
		
		function init(){
			$this->app = &app::get_instance();
			$this->objDB = &dbclass::get_instance();
			$this->referrerHost = $this->getReferrerHost();
		}
		
		function getReferrerHost(){
			if(array_key_exists("HTTP_REFERER", $_SERVER)){
				preg_match('@^(http://|https://)?([^/]+)@i',$_SERVER['HTTP_REFERER'],$res);
				if(count($res)>=3){
					$referrer = $res[2];
				}else{
					$referrer = "";
				}
			}else{
				try{
					$referrer = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				}catch(Exception $ex){
					$referrer = "";
				}
			}
			if($referrer==""){
				$this->isReferrerSecured = true;
			}else if($referrer==$_SERVER['HTTP_HOST']){
				$this->isReferrerSecured = true;
			}else{
				if($this->app->check_posting_host){
					if($this->objDB->exists("SELECT id FROM allowed_host WHERE host_name LIKE '%".str_replace(strtolower($referrer),"www.","")."%'")){
						$this->isReferrerSecured = true;
					}else{
						$this->isReferrerSecured = false;
					}
				}else{
					$this->isReferrerSecured = true;
				}
			}
			return $referrer;
		}
		
		function loadVariable($variable, $default="", $method="GET"){
			$method = strtoupper($method);
			if($method=="GET" || $method=="POST" || $method=="*"){
				if($method=="POST"){
					if(!$this->isReferrerSecured){
						echo "<h2>Possible hacking attack !!</h2><hr><br>You are trying to post data from a host, which is not allowed here !!";
						$this->objDB->close();
						exit;
					}
				}
				if($method=="GET"){
					if(isset($_GET[$variable]))
						return $_GET[$variable];
					else
						return $default;
				}
				if($method=="POST"){
					if(isset($_POST[$variable]))
						return $_POST[$variable];
					else
						return $default;
				}
				if($method=="*"){
					if(isset($_REQUEST[$variable]))
						return $_REQUEST[$variable];
					else
						return $default;
				}
			}else{
				echo "<h2>Function Error (loadVariable)</h2><hr><br>Invalid value passed for the argument <strong>method</strong>";
				$this->objDB->close();
				exit;
			}
		}
	}
?>