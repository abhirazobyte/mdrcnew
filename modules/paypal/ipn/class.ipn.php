<?		
	class ipn{
		private $keyarray = array();
		public $app = NULL;
		public $debug = false;
		public $log_file = "";
		
		public function __construct($debug=false, $debug_log=""){
			$this->debug = $debug;
			$this->log_file = $debug_log;
			$this->app = &app::get_instance();
		}
		
		public function get_value($var){
			if(array_key_exists($var, $this->keyarray)){
				return $this->keyarray[$var];
			}else{
				return NULL;
			}
		}
		
		public function get_ipn_data(){
			return $this->keyarray;
		}
		
		public function is_valid(){
			$f = NULL;
			if($this->debug==true && $this->log_file!=""){
				$f = fopen($this->log_file,"a+");
			}
			
			$referrer = $this->app->referrer;
			
			if($referrer==""){
				$referrer = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				if($referrer==""){
					return false;
				}
			}
			
			if($f){
				$str = "REFERRER HOST: ".$referrer."\n\n";
				fwrite($f, $str, strlen($str));
			}
			
			if(strpos($referrer, "sandbox")!==false){
				$ipn_url = "http://www.sandbox.paypal.com/row/cgi-bin/webscr";
			}else{
				$ipn_url = "http://www.paypal.com/row/cgi-bin/webscr";
			}
			$req = 'cmd=_notify-validate';
			
			$POST = $this->app->getPostVars();
			foreach ($POST as $key => $value){
				$value = urlencode(stripslashes($value));
				if($f){
					$str = $key." => ".$value."\n";
					fwrite($f, $str, strlen($str));
				}
				$req .= "&$key=$value";
				if (strlen(trim($key)) == 0) continue;
				$this->keyarray[urldecode($key)] = urldecode($value);
			}
			
			if($f){
				$str = "Tyring to verify the IPN Call\n\n";
				fwrite($f, $str, strlen($str));
			}
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $ipn_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			$ret = curl_exec ($ch);
			curl_close ($ch);
			
			if($f){
				$str = "IPN Status => ".$ret."\n\n\n";
				fwrite($f, $str, strlen($str));
			}
			
			if(strcmp($ret, "VERIFIED") == 0){
				return true;
			}else{
				return false;
			}
		}
	}
?>