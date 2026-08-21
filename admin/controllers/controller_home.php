<?
class _home extends controller
{
	function init()
	{
	}
	function onload()
	{
		
		$obj_model_product = $this->app->load_model("product");
		$rs_pro = $obj_model_product->execute("SELECT", false, "SELECT count(id) as total_pro FROM product");
		$this->assign("TOTAL_PRO",$rs_pro[0]['total_pro']);
		
		$obj_model_order_master = $this->app->load_model("customer_order_master");
		$rs_order_master = $obj_model_order_master->execute("SELECT", false, "SELECT count(id) as total_orm FROM customer_order_master");
		$this->assign("TOTAL_OM",$rs_order_master[0]['total_orm']);
		
		$obj_model_total_user = $this->app->load_model("customer");
		$total_user = $obj_model_total_user->execute("SELECT", false, "SELECT count(id) as total_user FROM customer");
		$this->assign("TOTAL_USER",$total_user[0]['total_user']);
		
		$obj_model_order_master_today = $this->app->load_model("customer_order_master");
		$rs_order_today= $obj_model_order_master_today->execute("SELECT", false, "","order_date='".date('d-m-Y')."'");
		$temp_all=0;
		$temp_confirm=0;
		$temp_cancel=0;
		for($i=0;$i<count($rs_order_today);$i++)
		{
			//'Unpaid','Paid','Delivery Assign','Processing','On Delivery','Delivered','Return','Canceled','Hide'
			$temp_all++;
			if($rs_order_today[$i]['order_status']!='Canceled')
			{
				$temp_confirm++;
			}
			if($rs_order_today[$i]['order_status']=='Canceled')
			{
				$temp_cancel++;
			}
		}
		$this->assign("TOTAL_TODAY",$temp_all);
		$this->assign("TOTAL_CONFIRM",$temp_confirm);
		$this->assign("TOTAL_CANCEL",$temp_cancel);
		$obj_model_user = $this->app->load_model("customer");
		$obj_model_user->join_table("customer_info", "left", array(), array("id"=>"customer_id"));
		$date=date('d-m-Y');
		$new_date=date('d-m-Y', strtotime($date.'+7 day'));
		if($this->app->getGetVar("status")=='a')
		{
			$rs_user = $obj_model_user->execute("SELECT", false, "","STR_TO_DATE(`anniversary_date`, '%d-%m') BETWEEN STR_TO_DATE('".$date."', '%d-%m') AND STR_TO_DATE('".$new_date."', '%d-%m')","anniversary_date ASC");
		}
		else
		{
			$rs_user = $obj_model_user->execute("SELECT", false, "","STR_TO_DATE(`birth_date`, '%d-%m') BETWEEN STR_TO_DATE('".$date."', '%d-%m') AND STR_TO_DATE('".$new_date."', '%d-%m')","birth_date ASC");
		}
		$this->app->assign("rs_user",$rs_user);
	}
		
	function send_mail()
	{
		$name=$this->app->getPostVar("name");
		$email=$this->app->getPostVar("email");
		$msg=$this->app->getPostVar("msg");
		$mobile=$this->app->getPostVar("mobile");
		$status=$this->app->getGetVar("status");
		$header=$this->app->utility->web_mail_header();
		$footer=$this->app->utility->web_mail_footer();
		if($mobile!="")
		{
		if($status=='a')
		{
			$sms_type='Marriage_Anniversary';
		}
		else
		{
			$sms_type='BIRTHDAY';
		}
		$default_string = array("{message}");
		$new_string   = array($sms_message);
		$this->app->utility->send_sms_new($mobile,$sms_type,$default_string,$new_string);
		}
		$obj_mailer = $this->app->load_module("mailer\sender");
		$mail_body = $this->app->utility->ParseMailTemplate("send_mail.html", array("header"=>$header,"footer"=>$footer,"NAME"=>$name,"EMAIL"=>$email,"MESSAGE"=>$msg));
		if($mail_body==NULL){
		$this->app->display_error(NULL, "Could not parse the mail template");
		}
		$obj_mailer->create();
		$obj_mailer->subject("Message From ".PROJECT_TILLE);
		$obj_mailer->add_to($email);
		$obj_mailer->htmlbody($mail_body);
		$flag = $obj_mailer->send();
		$this->app->utility->set_message("Mail is Sent Successfully to '".$name."' ", "SUCCESS");
		$this->app->redirect("index.php?view=home");
	}
	
	
}
?>