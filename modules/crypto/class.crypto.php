<?php
	class crypto{
		public $key = "";
		public $use_hash = true;
		public $seperator = ":";
	
		public function encodeString($string){
			$crypt = $this->crypt($string,$this->key);		
			if ($this->use_hash){
				$crypt .= $this->seperator . $this->hash($crypt);
			}			
			return base64_encode($crypt);
		}
	
		public function decodeString($string){
			if($this->isValidEncodedString($string)){
				$string = base64_decode($string);		
				if ($this->use_hash){
					$string = explode($this->seperator,$string);
					if (count($string) < 2) return null;
					array_pop($string); //remove hash string
					$string = implode($this->seperator,$string);
				}		
				return $this->crypt($string,$this->key);
			}else{
				trigger_error("The data is not in a valid encrypted format", E_USER_ERROR);
			}
		}
		
		public function isValidEncodedString($string){
			if ($this->use_hash){
				$string = base64_decode($string);			
				$string = explode($this->seperator,$string);
				if (count($string) < 2) return false;
				$hash = array_pop($string); //remove hash string
				$string = implode($this->seperator,$string);	
				if ($hash != $this->hash($string)){
					return false;
				}
			}		
			return true;
		}
		
		protected function hash($text){
			return dechex(crc32(md5($text) . md5($this->key)));
		}
		
		protected function crypt($text,$key){
			$key = md5($key);
			$crypt = "";
			$j = 0;
			$k = strlen($key);
			
			for ($i=0;$i<strlen($text);$i++){
				$crypt .= chr(ord($text[$i]) ^ ord($key[$j]));			
				$j++;
				if ($j >= $k) $j = 0;
			}
			
			return $crypt;
		}
	}
?>