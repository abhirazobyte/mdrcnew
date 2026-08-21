<?
class _notification extends controller {
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$this->app->utility->decrypt($cityID);
		
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));

		$search=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("search"));
		$page=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("page"));
		$page=$page==''?0:$page;

		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));
		
		if($cityID!='' && $action="list")
		{
			$obj_model_all_data = $this->app->load_model("push_notification");
			$rs_total = $obj_model_all_data->execute("SELECT",false,"SELECT count(*) as allcount from push_notification where id!=''");
			$count=$rs_total[0]['allcount'];
			
			$limit=10;
			$total_pages=intval($count/$limit);
			$start=$page==0?0:($page)*$limit;

			if($count<=0 || $total_pages<$page) {
				$message=array("message"=>"No Item Found.","msgCode"=>"0");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt); exit;
			}

			$obj_model_all = $this->app->load_model("push_notification");
			$records = $obj_model_all->execute("SELECT",false,"","id!=0","id desc limit ".$start.",".$limit);
			
			foreach($records as $item)
			{
				$id=$item['id'];
				$image=$this->app->utility->get_image_path($item['image'],"push_notification",'large');
			
				if($item['type']=='Item')
				{
					$btn='Item Detail';
				}
				else 
				{
					$btn='Book Test';
				}

				$notificationList[]=[
					"notificationID"=>$this->app->utility->encrypt($item['id']),
					"notificationType"=>$item['notification_type'],
					"title"=>$item['title'],
					"message"=>$item['message'],
					"image"=>$item['image']!=''?$image:"",
					"type"=>$item['type'],
					"search_id"=>$item['search_id'],
					"btnName"=>$btn,
					"itemID"=>$this->app->utility->encrypt($item['id']),
					"date"=>date("d-m-Y", strtotime($item['added_on']))
				];
			}

			$result=["notificationList"=>$notificationList];
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