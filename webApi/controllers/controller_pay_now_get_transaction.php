<?
class _pay_now_get_transaction extends controller{
	function init()
	{
		###
	}
	function onload()
	{
		$id=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('id'));
		
		if($id!='')
		{
			$obj_model_direct_payment_order = $this->app->load_model("direct_payment_order");
			$result = $obj_model_direct_payment_order->execute("SELECT", false, "", "id='".$id."'");
			unset($result[0]['payment_gateway_response']);
			unset($result[0]['ip']);
			unset($result[0]['gateway_remark']);
			unset($result[0]['id']);
			if(!empty($result))
			{
				$message = array("message" => "Transaction details found.", "msgCode" => "1","result"=>"success", "data" => $result[0]);
			}
			else
			{
				$message = array("message" => "No transaction found.","result"=>"success", "msgCode" => "0");
			}
		}
		else
		{
			$message = array("message" => "Invalid request.","result"=>"success", "msgCode" => "0");
		}
		
		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>