<?
	class mailqueue{
		private $app;
		
		function __construct(&$app){
			$this->app = $app;
		}
		
		function enqueue($batch_name, $mail_subject, $mail_to, $mail_html="", $mail_text="", $mail_cc="", $mail_bcc=""){
			$obj_model_mail_queue = new model_mail_queue;
			$map_fields["batch_name"]=$batch_name;
			$map_fields["mail_subject"]=$mail_subject;
			$map_fields["mail_to"]=$mail_to;
			$map_fields["mail_body_html"]=$mail_html;
			$map_fields["mail_body_text"]=$mail_text;
			$map_fields["mail_cc"]=$mail_cc;
			$map_fields["mail_bcc"]=$mail_bcc;
			$obj_model_mail_queue->map_fields($map_fields);
			if($obj_model_mail_queue->execute("INSERT")>0){
				return true;
			}else{
				return false;
			}
		}
		
		function dequeue($batch_name, $records=1){
			$sql = "SELECT * FROM mail_queue WHERE batch_name='".$batch_name."' LIMIT 0, ".$records;
			$this->app->objDB->setQuery($sql);
			$retarr = $this->app->objDB->execute("rs_mail_dequeue");
		 	$this->app->objDB->remove("rs_mail_dequeue");
			return $retarr;
		}
		
		function update_retry_count($id){
			$obj_model_mail_queue = new model_mail_queue($id);
			$fields_to_update["retry_count"] = "retry_count + 1";
			$obj_model_mail_queue->map_fields($fields_to_update);
			$obj_model_mail_queue->execute("UPDATE");
		}
		
		function delete($id){
			$obj_model_mail_queue = new model_mail_queue($id);
			$obj_model_mail_queue->execute("DELETE");
		}
	}
?>