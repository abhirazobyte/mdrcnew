<?php
	abstract class Singleton { 
		protected static $my_name = __CLASS__; 
		protected static $instances = array(); 
	
		protected final function __construct() {}   
		protected final function __clone() {trigger_error('Cloning not allowed on a singleton object', E_USER_ERROR);}   
		public function __destruct() {unset(self::$instances[self::getClass()]);}
		abstract protected function init(); 
	   
		/** 
		 * Gets an instance of this singleton. If no instance exists, a new instance is created and returned. 
		 * If one does exist, then the existing instance is returned. 
		 */ 
		public static function &get_instance() {       
			$class = self::getClass(); 
			if (!array_key_exists($class, self::$instances)){
				self::$instances[$class] = new $class(); 
				self::$instances[$class]->init(); 
			}
			return self::$instances[$class]; 
		} 
	   
		/** 
		 * Returns the classname of the child class extending this class 
		 * 
		 * @return string The class name 
		 */ 
		private static function getClass() { 
			$implementing_class = self::$my_name; 
			$original_class = __CLASS__; 			
			if ($implementing_class === $original_class) {
				trigger_error("You MUST provide a <code>parent::\$my_name = __CLASS__;</code> statement in your Singleton-class!", E_USER_ERROR); 
			}			
			return $implementing_class; 
		} 
	} 
?>