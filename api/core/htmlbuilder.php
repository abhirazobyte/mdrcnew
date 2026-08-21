<?
	class htmlBuilder extends Singleton{	
		var $app;
		var $current_form;
		
		public static function &get_instance() { 
			parent::$my_name = __CLASS__; 
			return parent::get_instance(); 
		}
		
		function init(){
			$this->app = &app::get_instance();
			$this->current_form = "";
		}
		
		function buildTag($tag, $properties, $field_name=""){
			global $app;
			if(is_array($field_name)){
				foreach($field_name as $key=>$val){
					$id = $key;
					$name = $val;
				}
			}else{
				$name = $field_name;
				$id = $field_name;
			}
			$tag = strtolower($tag);
			$tmpStr="";
			if(isset($properties["type"])){
				$type = $properties["type"];
			}else{
				$type = "";
			}
			$post_back_value = NULL;
			if($app->isPostBack){
				$post_back_value = $app->getPostVar(str_replace("[]","",$name));
			}
			$auto_field = "field_".str_replace("[]","",$name);
			switch($tag){
				case "iframe";
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="value"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=">";
					$tmpStr.="</".$tag.">";
				case "textarea";
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="value"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=">";
					if(isset($properties["value"])){
						$tmpStr.=$properties["value"];
					}else if(isset($this->app->$auto_field)){
						$tmpStr.=$this->app->$auto_field;
					}else if($this->current_form!=""){
						if(array_key_exists($this->current_form, $this->app->form_data)){
							if(array_key_exists($name, $this->app->form_data[$this->current_form])){
								$tmpStr.=$this->app->form_data[$this->current_form][$name];
							}
						}else if($post_back_value!=NULL){
							$tmpStr.=$post_back_value;
						}
					}
					$tmpStr.="</".$tag.">";
				break;
				case "form":
					$this->current_form = $name;
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\" method=\"post\" enctype=\"multipart/form-data\"";
					}
					if(!isset($properties["action"])){
						$tmpStr.=" action=\"index.php?view=".$this->app->getCurrentView()."\"";
					}
					foreach($properties as $key=>$val){
						$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
					}
					$tmpStr.=">\n";
					$tmpStr.="<input type=\"hidden\" name=\"".__PRODUCT__."_REF_VIEW\" value=\"".$this->app->getCurrentView()."\">\n";
				break;
				case "select":
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						if(strtolower($key)!="values" && strtolower($key)!="selected"){
							$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
						}
					}
					$tmpStr.=" >";
					if(array_key_exists("values", $properties)){
						if(is_array($properties["values"])){
							foreach($properties["values"] as $option=>$text){
								$tmpStr.="\n<option ";
								if(isset($this->app->$auto_field)){
									if(is_array($this->app->$auto_field)){
										if(in_array($option, $this->app->$auto_field)){
											$tmpStr.=" selected";
										}
									}else{
										if($this->app->$auto_field==$option){
											$tmpStr.=" selected";
										}
									}
								}else if(isset($properties["selected"])){
									if(is_array($properties["selected"])){
										if(in_array($option, $properties["selected"])){
											$tmpStr.=" selected";
										}
									}else{
										if($properties["selected"]==$option){
											$tmpStr.=" selected";
										}
									}
								}else if($this->current_form!=""){
									if(array_key_exists($this->current_form, $this->app->form_data)){
										if(array_key_exists($name, $this->app->form_data[$this->current_form])){
											if(is_array($this->app->form_data[$this->current_form][$name])){
												if(in_array($option, $this->app->form_data[$this->current_form][$name])){
													$tmpStr.=" selected";
												}
											}else{
												if($option == $this->app->form_data[$this->current_form][$name]){
													$tmpStr.=" selected";
												}
											}
										}
									}else if($post_back_value!=NULL){
										if(is_array($post_back_value)){
											if(in_array($option, $post_back_value)){
												$tmpStr.=" selected";
											}
										}else{
											if($post_back_value==$option){
												$tmpStr.=" selected";
											}
										}
									}
								}
								$tmpStr.=" value=\"".$option."\">".$text."</option>";
							}
						}
					}
					$tmpStr.="</".$tag.">";
				break;
				default:
					$tmpStr = "<".$tag;
					if($name!=""){
						$tmpStr.=" name=\"".$name."\" id=\"".$id."\"";
					}
					foreach($properties as $key=>$val){
						$tmpStr.=" ".strtolower($key)."=\"".$val."\"";
					}
					if($type=="text" || $type=="password" || $type=="hidden"){
						if(!isset($properties["value"])){
							if(isset($this->app->$auto_field)){
								$tmpStr.=" value=\"".$this->app->$auto_field."\"";
							}else if($this->current_form!=""){
								if(array_key_exists($this->current_form, $this->app->form_data)){
									if(array_key_exists($name, $this->app->form_data[$this->current_form])){
										$tmpStr.=" value=\"".$this->app->form_data[$this->current_form][$name]."\"";
									}
								}else if($post_back_value!=NULL){
									$tmpStr.=" value=\"".$post_back_value."\"";
								}
							}
						}
					}else if($type=="checkbox"){
						if(isset($properties["value"])){
							if(isset($this->app->$auto_field)){
								if(is_array($this->app->$auto_field)){
									if(in_array($properties["value"], $this->app->$auto_field)){
										$tmpStr.=" checked=\"checked\"";
									}
								}else{
									if($this->app->$auto_field==$properties["value"]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if(isset($properties["selected"])){
								if(is_array($properties["selected"])){
									if(in_array($properties["value"], $properties["selected"])){
										$tmpStr.=" checked=\"checked\"";
									}
								}else{
									if($properties["selected"]==$properties["value"]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if($this->current_form!=""){
								if(array_key_exists($this->current_form, $this->app->form_data)){
									if(array_key_exists($name, $this->app->form_data[$this->current_form])){
										if(is_array($this->app->form_data[$this->current_form][$name])){
											if(in_array($properties["value"], $this->app->form_data[$this->current_form][$name])){
												$tmpStr.=" checked=\"checked\"";
											}
										}else{
											if($this->app->form_data[$this->current_form][$name]==$properties["value"]){
												$tmpStr.=" checked=\"checked\"";
											}
										}
									}
								}else if($post_back_value!=NULL){
									if(is_array($post_back_value)){
										if(in_array($properties["value"], $post_back_value)){
											$tmpStr.=" checked=\"checked\"";
										}
									}else{
										if($post_back_value==$properties["value"]){
											$tmpStr.=" checked=\"checked\"";
										}
									}
								}								
							}
						}
					}else if($type=="radio"){
						if(isset($this->app->$auto_field) && isset($properties["value"])){
							if($properties["value"]==$this->app->$auto_field){
								$tmpStr.=" checked=\"checked\"";
							}
						}else if($this->current_form!="" && isset($properties["value"])){
							if(array_key_exists($this->current_form, $this->app->form_data)){
								if(array_key_exists($name, $this->app->form_data[$this->current_form])){
									if($properties["value"]==$this->app->form_data[$this->current_form][$name]){
										$tmpStr.=" checked=\"checked\"";
									}
								}
							}else if($post_back_value!=NULL && isset($properties["value"])){
								if($properties["value"]==$post_back_value){
									$tmpStr.=" checked=\"checked\"";
								}
							}
						}
					}
					$tmpStr.=" />";
				break;
			}
			echo $tmpStr;
		}
		
		function closeForm(){
			echo "</form>";
			$this->current_form = "";
		}
	}
?>