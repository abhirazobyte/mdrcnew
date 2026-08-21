<?
	class paypal{
		private $app			= NULL;
		private $mode			= "live";
		private $product_name	= "";
		private $return_success	= "";
		private $return_cancel	= "";
		private $notify_url		= "";
		private $button			= "";
		private $custom			= "";
		private $order_total	= 0;
		public $merchant_email 	= "";		
		public $currency		= "";
		public $cbt				= "";		
		public $cpp_header_image = "";
				
		public function __construct(){
			global $app;
			$this->app = $app;	
			$this->button = "<input type=\"submit\" value=\"Pay Using Paypal\" name=\"btn_pay\" \>";
			
			$this->set_return_success(SERVER_ROOT."/index.php?view=payment_confirm");
			$this->set_return_cancel(SERVER_ROOT."/index.php?view=payment_cancel");
			$this->set_notify_url(SERVER_ROOT."/index.php?view=ipn");
		}
		
		public function display(){
			if($this->merchant_email==""){
				$this->app->display_error(debug_backtrace(), "Please set the merchant email", E_USER_ERROR);
				return false;
			}else if($this->order_total==0){
				$this->app->display_error(debug_backtrace(), "Please set the order total value", E_USER_ERROR);
				return false;
			}else if($this->currency==""){
				$this->app->display_error(debug_backtrace(), "Please set the currency value", E_USER_ERROR);
				return false;
			}else if($this->product_name==""){
				$this->app->display_error(debug_backtrace(), "Please specify the product name", E_USER_ERROR);
				return false;
			}else if($this->return_success==""){
				$this->app->display_error(debug_backtrace(), "Please enter the success return URL", E_USER_ERROR);
				return false;
			}else if($this->return_cancel==""){
				$this->app->display_error(debug_backtrace(), "Please enter the cancel return URL", E_USER_ERROR);
				return false;
			}else{
				$paypal_form = "<form ";
				if($this->mode=="demo"){
					$paypal_form.= "action=\"https://www.sandbox.paypal.com/row/cgi-bin/webscr\"";
				}else{
					$paypal_form.= "action=\"https://www.paypal.com/row/cgi-bin/webscr\"";
				}
				
				$paypal_form.= " method=\"post\" name=\"payment_gateway_form\" >\n";
				$paypal_form.= "<input type=\"hidden\" name=\"rm\" value=\"2\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n";	
				$paypal_form.= "<input type=\"hidden\" name=\"business\" value=\"".$this->merchant_email."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"custom\" value=\"".$this->custom."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"currency_code\" value=\"".$this->currency."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"no_shipping\" value=\"1\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"item_name\" value=\"".$this->product_name."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"amount\" value=\"".number_format($this->order_total,2,".","")."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"cancel_return\" value=\"".$this->return_cancel."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"return\" value=\"".$this->return_success."\">\n";
				$paypal_form.= "<input type=\"hidden\" name=\"notify_url\" value=\"".$this->notify_url."\">\n";
				
				if($this->cbt!=""){
					$paypal_form.= "<input type=\"hidden\" name=\"cbt\" value=\"".$this->cbt."\">\n";
				}
				
				if($this->cpp_header_image!=""){
					$paypal_form.= "<input type=\"hidden\" name=\"cpp_header_image\" value=\"".$this->cpp_header_image."\">\n";
				}
				
				$paypal_form.= $this->button."\n";
				$paypal_form.= "</form>\n";

				return $paypal_form;
			}			
		}
		
		public function set_mode($mode="live"){
			$this->mode = $mode;
		}
		
		public function set_button($button){
			$this->button = $button;
		}
		
		public function set_merchant($email){
			$this->merchant_email = $email;
		}
		
		public function set_custom($custom){
			$this->custom = $custom;
		}
		
		public function set_order_total($order_total){
			$this->order_total = $order_total;
		}
		
		public function set_currency($currency){
			$this->currency = $currency;
		}
		
		public function set_product_name($product_name){
			$this->product_name = $product_name;
		}
		
		public function set_return_success($return_success){
			$this->return_success = $return_success;
		}
		
		public function set_return_cancel($return_cancel){
			$this->return_cancel = $return_cancel;
		}
		
		public function set_notify_url($notify_url){
			$this->notify_url = $notify_url;
		}
	}
?>