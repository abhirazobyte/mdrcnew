<?
class _newsletter extends controller{
	function init(){
	}
	function onload()
	{
		$email=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('email'));
		if($email!=''){

			# SEND MAIL
			$template_name = 'subscribe_newsletter_admin';
			$send_data_arary = ['email' => $email];

			$subject = 'New Newsletter Subscription Notification';
			$mail_for = 'subscribe_newsletter';
			$data = ['template_name' => $template_name, 'send_data_arary' => $send_data_arary, 'subject' => $subject, 'mail_for' => $mail_for];
			$this->app->utility->sendMial($data);

			$message=array("message"=>"Thank you for subscribing with us","msgCode"=>"1");
		} else {
			$message=array("message"=>"fail","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>