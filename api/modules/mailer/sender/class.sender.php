<?
	require_once(ABS_PATH.DS."modules".DS."mailer".DS."sender".DS."MAIL5.php");
		
	class sender{
		var $app;
		var $htmlbody;
		var $textbody;
		var $fromemail;
		var $fromname;
		var $m;
		
		function sender(){
			$this->app = &app::get_instance();
			$this->m = NULL;
			$this->htmlbody = "";
			$this->textbody = "";
			$this->fromemail = "";
			$this->fromname = "";
		}
		
		function create(){
			$this->m = new MAIL;
		}
		
		function clear(){
			$this->m->DelTo();
			$this->m->DelBcc();
			$this->m->DelCc();
			$this->m->DelHeader();
			$this->m->DelAttach();
		}
		
		function add_to($mailto, $name=""){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$t = $this->m->AddTo($mailto, $name==""?$mailto:$name);
			if(!$t){
				$this->app->display_error(debug_backtrace(), "Could not add the recipeint");
			}
		}
		
		function add_cc($mailto, $name=""){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$c = $this->m->AddCC($mailto, $name==""?$mailto:$name);
			if(!$c){
				$this->app->display_error(debug_backtrace(), "Could not add the CC recipeint");
			}
		}
		
		function add_bcc($bcc){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$b = $this->m->AddBcc($bcc);
			if(!$b){
				$this->app->display_error(debug_backtrace(), "Could not add the BCC recipeint");
			}
		}
		
		function subject($subject){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$s = $this->m->Subject($subject);
			if(!$s){
				$this->app->display_error(debug_backtrace(), "Could not set the Mail Subject");
			}
		}
		
		function htmlbody($html){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$this->htmlbody = $html;
			$this->m->Html($this->htmlbody);
		}
		
		function textboxy($text){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$this->textbody = $text;
			$this->m->Text($this->textbody);
		}
		
		function attatch($file){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}	
			if(!file_exists($file)){
				$this->app->display_error(debug_backtrace(), "Could not find the file to attach: ".$file);
			}
			$a = $this->m->attach(file_get_contents($file), FUNC::mime_type($file), 'photo.gif', null, null, 'inline', MIME::unique());
			if(!$a){
				$this->app->display_error(debug_backtrace(), "Could not attatch the file ".$file);
			}			
		}
		
		function mailfrom($email, $name=""){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			$this->fromemail = $email;
			$this->fromname = $name;
			$f = $this->m->From($email, $name==""?$email:$name);
			if(!$f){
				$this->app->display_error(debug_backtrace(), "Could not set the sender of the email <".$mail."> ".$name);
			}
		}		
		
		function send(){
			if($this->m==NULL){
				$this->app->display_error(debug_backtrace(), "Please call mailer->create() first");
			}
			if($this->htmlbody!="" && $this->textbody==""){
				$this->m->Text($this->app->utility->html2txt($this->htmlbody));
			}
			if($this->fromemail==""){
				$this->mailfrom(FROM_EMAIL, FROM_NAME);
			}
			if(SMTPDIRECT=="1"){
				$s = $this->m->Send('client');
			}else if(SMTPHOST==""){
				$s = $this->m->Send();
			}else{
				if(SMTPUSER==""){
					$c = SMTP::Connect(SMTPHOST, (int)SMTPPORT);
				}else if(SMTPSECURITY==""){
					$c = SMTP::Connect(SMTPHOST, (int)SMTPPORT, SMTPUSER, SMTPPASS);
				}else{
					$c = SMTP::Connect(SMTPHOST, (int)SMTPPORT, SMTPUSER, SMTPPASS, SMTPSECURITY, 10);
				}
				if(!$c){
					$this->app->display_error(debug_backtrace(), "Could not connect to SMTP Server");
				}
				$s = $this->m->Send($c);	
				SMTP::Disconnect($c);	
			}
			if(!$s){
				$this->app->display_error(debug_backtrace(), "Could not send the mail");
				return false;
			}else{
				return true;
			}
		}
	}
?>