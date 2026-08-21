<?
class _wallet_transaction_list extends controller {
	function init(){
	}
	function onload()
	{
		$walletAmount=0;
		$promoWalletAmount=0;
		$ip=$_SERVER['REMOTE_ADDR'];

		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$search=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("search"));
		$page=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("page"));
		
		if($userID!='' && $userPhone!='' && $deviceType!='')
		{
			$obj_model_customer= $this->app->load_model("customer");
			$rs_user=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($rs_user)<=0)
			{
				
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit; 
			}
			$walletAmount=$rs_user[0]['wallet'];
			$promoWalletAmount=$rs_user[0]['promoWallet'];

			if($search!='')
			{
				$q=$search;
				$g_search_query=" and (wallet_transction.amount LIKE '$q%' or wallet_transction.amount LIKE '%$q%' or wallet_transction.amount LIKE '%$q' or wallet_transction.transaction_id LIKE '$q%' or wallet_transction.transaction_id LIKE '%$q%' or wallet_transction.transaction_id LIKE '%$q' or wallet_transction.payment_status LIKE '$q%' or wallet_transction.payment_status LIKE '%$q%' or wallet_transction.payment_status LIKE '%$q' or wallet_transction.remark LIKE '$q%' or wallet_transction.remark LIKE '%$q%' or wallet_transction.remark LIKE '%$q' or wallet_transction.transaction_date LIKE '$q%' or wallet_transction.transaction_date LIKE '%$q%' or wallet_transction.transaction_date LIKE '%$q')";
			}

			$cust_cond="and wallet_transction.customer_id='".$userID."'";
			$obj_model_all_data = $this->app->load_model("wallet_transction");
			$customer_order_master = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount from wallet_transction where wallet_transction.id!='' ".$cust_cond." ".$g_search_query);
			$count=$customer_order_master[0]['allcount'];

			$limit=10;
			$total_pages=intval($count/$limit);
			$start=$page==0?0:($page)*$limit;

			if($count<=0 || $total_pages<$page) {
				$message=array("message"=>"No wallet transaction Found.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt); exit;
			}

			$order_by='wallet_transction.id DESC';
			$obj_model_all = $this->app->load_model("wallet_transction");
			$order = $obj_model_all->execute("SELECT",false,"","wallet_transction.id!='' ".$cust_cond." ".$g_search_query."","".$order_by." limit ".$start.",".$limit."","wallet_transction.id");
			foreach($order as $item)
			{
				$transactionList[]=[
					"id"=>$this->app->utility->encrypt($item['id']),
					"amount"=>$item['amount'],
					"amountType"=>$item['amount_type'],
					"transactionID"=>$item['transaction_id']==''?'#'.$item['id']:$item['transaction_id'],
					"remark"=>$item['remark'],
					"paymentStatus"=>$item['payment_status'],
					"Date"=>$item['transaction_date'],
					"walletType"=>$item['wallet_type']
				];
			}

			$result=["transactionList"=>$transactionList,"walletAmount"=>$walletAmount,"promoWalletAmount"=>$promoWalletAmount,"promoWalletShow"=>false];
			$message=array("message"=>"success","msgCode"=>"1","result"=>$result);
		}
		else
		{
			$message=array("message"=>"Date missing.","msgCode"=>"0");
		}
		$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>