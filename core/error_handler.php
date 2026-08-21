<?
		function custom_error($error_level, $error_message, $error_file, $error_line, $error_context){
			global $app;
			if(DEBUG==1){
				echo "ERROR in <strong>".$error_file."</strong> at line no <strong>".$error_line."</strong><br \>";
				echo "Error Description<br \><hr>";
				echo "<strong>".$error_message."</strong>";
				echo "<br \><br \>";
				echo "Error Context<br \><hr><pre>";
				print_r($error_context)."</pre><br \>";
				if($error_level==E_USER_ERROR || $error_level==E_ERROR){
					$app->objDB->close();
					exit;
				}
			}else if(DEBUG==2){
				if($error_level==E_NOTICE || $error_level==E_WARNING || $error_level==E_USER_NOTICE || $error_level==E_USER_WARNING || $error_level==E_ERROR || $error_level==E_USER_ERROR){
					echo "<strong>".$error_message."</strong><br />";
					echo "File: <strong>".$error_file."</strong><br />Line: <strong>".$error_line."</strong><br />";
					if($error_level==E_USER_ERROR || $error_level==E_ERROR){
						$app->objDB->close();
						exit;
					}
				}
			}else if(DEBUG==3){
				if($error_level==E_USER_ERROR || $error_level==E_ERROR){
					echo "<strong>".$error_message."</strong><br />";
					$app->objDB->close();
					exit;
				}
			}else if(DEBUG==4){
				if($error_level==E_USER_ERROR || $error_level==E_ERROR){
					$app->objDB->close();
					exit;
				}
			}
		}
?>