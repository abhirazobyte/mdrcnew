<?php
	class eExchangeRate{
		public $api_key = "";
		
		function get_conversion_rate($cur_from, $cur_to){
			if($this->api_key == ""){
				return false;
			}
			if(strlen( $cur_from ) == 0)
				$cur_from = "USD";		
			if(strlen( $cur_to ) == 0)
				$cur_to = "USD";		
			if($cur_from == $cur_to)
				return "1";
						
			$data = "";
			$host = "exchangerate-api.com";
			$fp = @fsockopen($host, 80, $errno, $errstr, 30);
			if(!$fp){
				return false;
			}else{
				$file = "/".$cur_from."/".$cur_to."/1";
				$str = "?k=".$this->api_key;
				$out = "GET " . $file . $str . " HTTP/1.0\r\n";
				$out .= "Host: www.exchangerate-api.com\r\n";
				$out .= "Connection: Close\r\n\r\n";				
				@fputs( $fp, $out );
				while( !@feof( $fp ) )
					$data .= @fgets( $fp, 128 );
				@fclose( $fp );		
				@preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $data, $match );
				$data = $match[2];
				return $data;
			}
		} 
	}
?>