<?
class _order_list extends controller{
	function init(){
	}
	function onload()
	{
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

			if($search!='')
			{
				$q=$search;
				$g_search_query="and (customer_order_master.id LIKE '$q%' or customer_order_master.id LIKE '%$q%' or customer_order_master.id LIKE '%$q' or customer_order_master.order_status LIKE '$q%' or customer_order_master.order_status LIKE '%$q%' or customer_order_master.order_status LIKE '%$q' or customer_order_master.order_date LIKE '$q%' or customer_order_master.order_date LIKE '%$q%' or customer_order_master.order_date LIKE '%$q')";
			}

			$cust_cond="and customer_order_master.customer_id='".$userID."'";
			$obj_model_all_data = $this->app->load_model("customer_order_master");
			$customer_order_master = $obj_model_all_data->execute("SELECT", false, "SELECT count(*) as allcount from customer_order_master where customer_order_master.id!='' ".$cust_cond." ".$g_search_query);
			$count=$customer_order_master[0]['allcount'];

			$limit=10;
			$total_pages=intval($count/$limit);
			$start=$page==0?0:($page)*$limit;

			if($count<=0 || $total_pages<$page) {
				$message=array("message"=>"No Orders Found.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt); exit;
			}

			$order_by='customer_order_master.id DESC';
			$obj_model_all = $this->app->load_model("customer_order_master");
			$order = $obj_model_all->execute("SELECT",false,"","customer_order_master.id!='' ".$cust_cond." ".$g_search_query."","".$order_by." limit ".$start.",".$limit."","customer_order_master.id");
			foreach($order as $item)
			{
				$orderItemList[]=["title"=>"Booking ID","value"=>$item['display_order_no']];
				$orderItemList[]=["title"=>"Booking date","value"=>$item['order_date']];
				$orderItemList[]=["title"=>"Payment Type","value"=>$item['payment_type']];

				$orderList[]=[
					"id"=>'#'.$item['id'],
					"itemList"=>$orderItemList,
					"orderAmount"=>$item['net_order_value'],
					"orderStatus"=>$item['order_status']=='Canceled'?"Cancelled":$item['order_status'],
					"orderStatusColor"=>'#000000',
					"orderAmount"=>$item['net_order_value'],
					"orderDetailUrl"=>SERVER_ROOT.'/order-details/'.$item['id'].'?callfrom=app'
				];
				unset($orderItemList);
			}

			$result=["orderList"=>$orderList];
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