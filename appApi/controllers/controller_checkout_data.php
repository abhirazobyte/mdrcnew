<?
class _checkout_data extends controller {
	function init(){
	}
	function onload()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$userID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userID'));
		$userID=$this->app->utility->decrypt($userID);
		$cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"";
		$userPhone=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('userPhone'));
		$deviceType=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("deviceType"));
		$action=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("action"));
		$sampleCollect=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar("sampleCollect"));
		if($userID!='' && $userPhone!='' && $deviceType!='' && $action=='step1' && $sampleCollect!='')
		{
			$obj_model_customer= $this->app->load_model("customer");
			$customer=$obj_model_customer->execute("SELECT",false,"","id='".$userID."'");
			if(count($customer)<=0)
			{
				$response=array("message"=>"Customer not found.","msgCode"=>"0");
				$opt=json_encode($response, JSON_UNESCAPED_UNICODE);
				$final_response=$this->app->utility->indent($opt);
				echo $final_response; exit;
			}
			$customerCond="customer_cart.customer_id='".$userID."'";
			$obj_model_tmp_cartmini = $this->app->load_model("customer_cart");
			$obj_model_tmp_cartmini->join_table("item_price", "left", array(), array("cart_item_price_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item_other_data", "left", array('item_department_ids'), array("cart_item_id"=>"item_id"));
			$obj_model_tmp_cartmini->join_table("customer_members", "left", array("prefix","first_name","last_name","gender","relation","line1","pincode","area_id","area"), array("customer_members_id"=>"id"));
			$obj_model_tmp_cartmini->join_table("item", "left", array(), array("cart_item_id"=>"id"));
			$rs_cartmini = $obj_model_tmp_cartmini->execute("SELECT", false, "", "".$customerCond."","customer_cart.id DESC");
			if(count($rs_cartmini)>0)
			{
				$subtotal=0;
				$cartCount=0;
				$depIDs=array();
				$membersData=[];
				$item_lab_ids=[];
				$step_third_heading='';
				$boolean_radiology=false;
				$boolean_pathology=false;
				//ss
				for($i=0;$i<count($rs_cartmini);$i++)
				{
					$item_lab_ids=array_merge($item_lab_ids,array_unique(explode(',',$rs_cartmini[$i]['item_price_item_lab_ids'])));
					$membersData[]=$rs_cartmini[$i]['customer_members_id'];
					//if radiology then Radiology priority else other
					if(in_array('1',explode(',',$rs_cartmini[$i]['item_other_data_item_department_ids'])))
					{
						$step_third_heading=' Nearby Diagnostic Centre for Radiology Imaging Test';
						$boolean_radiology=true;
					}
					if($rs_cartmini[$i]['item_other_data_item_department_ids']==2 && $step_third_heading=='')
					{
						$step_third_heading='Select Near By Lab/Collection Point';
						$boolean_pathology=true;
					}
					if($boolean_pathology && $boolean_radiology)
					{
						$step_third_heading=' Nearby Diagnostic Centre for scheduling Radiology & Pathology test';
					}
					$depIDs[]=$rs_cartmini[$i]['cart_item_department_ids'];
					$subtotal=$subtotal+$rs_cartmini[$i]['cart_line_total'];
					$cartCount=$cartCount+1;
					$itemName=$rs_cartmini[$i]['cart_item_name'];
					$testCount=$rs_cartmini[$i]['item_test_count'];
					$cartID=$rs_cartmini[$i]['id'];
					$cart_item_id=$rs_cartmini[$i]['cart_item_id'];
					$price=$rs_cartmini[$i]['cart_item_price'];
					$mrp=$rs_cartmini[$i]['cart_item_mrp'];
					$customer_members_id=$rs_cartmini[$i]['customer_members_id'];
					$prescription_require=$rs_cartmini[$i]['prescription_require'];
					$prescription_data=$rs_cartmini[$i]['prescription_data'];

					$memberSatisfy='No';
					if($customer_members_id>0 && $rs_cartmini[$i]['customer_members_first_name']!='')
					{
						$memberSatisfy='Yes';
					}
					$prescriptionSatisfy='No';
					if($prescription_require=='Yes')
					{
						if($prescription_data!='')
						{
							$prescriptionSatisfy='Yes';
						}
					}
					else
					{
						$prescriptionSatisfy='Yes';
					}
				}
				$unique_item_lab_ids=array_unique($item_lab_ids);
				$final_ids=array_unique($depIDs);
				$depID=implode(',',$final_ids);
				$labSelection='Yes';
				if($depID=='2' && $sampleCollect=='Yes')
				{
					$labSelection='No';
				}

				$mem=array_unique($membersData);
				$membersID=implode(',',$mem);
				if($membersID=='')
				{
					$membersID=0;
				}

				$unique_item_lab_ids=array_filter($unique_item_lab_ids);
				$lab_con=count($unique_item_lab_ids)>0?' and id in ('.implode(',',$unique_item_lab_ids).')':'';
				$obj_model_item_lab = $this->app->load_model("item_lab");
				$rs_lab = $obj_model_item_lab->execute("SELECT", false, "", "item_lab.city_id='".$cityID."' and item_lab.status='Active' ".$lab_con."","item_lab.sort_order ASC");

				$obj_model_member_address = $this->app->load_model("customer_members");
				$obj_model_member_address->join_table("state", "left", array("name"), array("state_id"=>"id"));
				$obj_model_member_address->join_table("city", "left", array("name"), array("city_id"=>"id"));
				$rs_add= $obj_model_member_address->execute("SELECT", false, "", "customer_members.id IN (".$membersID.") and customer_members.status='Active'","customer_members.id DESC");

				$obj_model_tmp_cartmini = $this->app->load_model("holidays");
				$holidays = $obj_model_tmp_cartmini->execute("SELECT", false, "", "status='Active'");
				if(count($holidays)>0)
				{
					$holidaysDate=array_column($holidays, 'name');
				}else {
					$holidaysDate=[];
				}

				for($i=1;$i<=20;$i++)
				{
					$nextDateCheck=date('d-m-Y', strtotime('+'.$i.' day', strtotime(date('d-m-Y'))));
					$nextDateCheckTemp=str_replace('-','/',$nextDateCheck);
					if(count($holidaysDate)>0 && in_array($nextDateCheckTemp,$holidaysDate))
					{
						continue;
					}
					$nextDate[]=["dateValue"=>$nextDateCheck,"date"=>date('d', strtotime('+'.$i.' day', strtotime(date('d-m-Y')))),"dateMonth"=>strtoupper(date('M', strtotime('+'.$i.' day', strtotime(date('d-m-Y')))))];	
				}

				

				$homeCollectionHeading='';
				if($sampleCollect=='Yes')
				{
					$homeCollectionHeading="Choose Home Sample Collection address";
					for($i=0;$i<count($rs_add);$i++){
						$nameString=$rs_add[$i]['prefix'].' '.$rs_add[$i]['first_name'].' '.$rs_add[$i]['last_name'].'<br/>'.$rs_add[$i]['gender'].', '.$rs_add[$i]['age'].' yrs. <br/>';
						$nameString.=$rs_add[$i]['line1'].' '.$rs_add[$i]['area'].' '.$rs_add[$i]['city_name'].'-'.$rs_add[$i]['pincode'].', '.$rs_add[$i]['state_name'];
						$homeCollectionSelection[]=["id"=>$rs_add[$i]['id'],"name"=>$nameString];
					}

					$obj_model_settings = $this->app->load_model("timing_settings");
					$home_collection_data= $obj_model_settings->execute("SELECT", false, "", "type='HomeCollection'");
					$datastartTime=$home_collection_data[0]['start_time'];
					$dataendTime=$home_collection_data[0]['end_time'];
					$dataslot=$home_collection_data[0]['slot'];
					for($i=0;$i<9;$i++)
					{																		
						$m=$i+1;
						$start=$i*$dataslot;
						$end=$m*$dataslot;
						$strartTime = date('h:i A', strtotime('+'.$start.' minutes', strtotime($datastartTime)));
						$endTime = date('h:i A', strtotime('+'.$end.' minutes', strtotime($datastartTime)));
						$timeList[]=$strartTime.' - '.$endTime;		
					}

					$homeCollectionStep=["homeCollectionHeading"=>$homeCollectionHeading,"homeCollectionSelection"=>$homeCollectionSelection,"dateList"=>$nextDate,"timeList"=>$timeList];
				}
				else
				{
					$homeCollectionStep=(object)[];
				}
				

				if($labSelection=='Yes'){
					$labCollectionHeading="Nearby Diagnostic Centre for Radiology Imaging Test";
					for($i=0;$i<count($rs_lab);$i++) {
						$nameString=$rs_lab[$i]['name'];
						$labCollectionSelection[]=["id"=>$rs_lab[$i]['id'],"name"=>$nameString,"address"=>$rs_lab[$i]['address']];
					}

					$obj_model_settings = $this->app->load_model("timing_settings");
					$lab_timiming_data= $obj_model_settings->execute("SELECT", false, "", "type='Lab'");

					$datastartTime=$lab_timiming_data[0]['start_time'];
					$dataendTime=$lab_timiming_data[0]['end_time'];
					$dataslot=$lab_timiming_data[0]['slot'];

					for($i=0;$i<3;$i++) {													
						$m=$i+1;
						$start=$i*$dataslot;
						$end=$m*$dataslot;
						$strartTime = date('h:i A', strtotime('+'.$start.' minutes', strtotime($datastartTime)));
						$endTime = date('h:i A', strtotime('+'.$end.' minutes', strtotime($datastartTime)));
						$labTimeList[]=$strartTime.' - '.$endTime;
					}

					$labCollectionStep=["labCollectionHeading"=>$labCollectionHeading,"labCollectionSelection"=>$labCollectionSelection,"dateList"=>$nextDate,"labTimeList"=>$labTimeList];
				}
				else
				{
					$labCollectionStep=(object)[];
				}
				
				$payments[]=["paymentLabel"=>"Cash on Sample Collection / Bill at MDRC Centre","paymentValue"=>"COD"];
				$payments[]=["paymentLabel"=>"Pay Online / UPI / Cards / QR Code","paymentValue"=>"ONLINE"];
				$couponEnterShow='Yes';
				//ss
				$allTotals=["wallet"=>(int)$customer[0]['wallet'],"subtotal"=>(int)$subtotal,"cartCount"=>(int)$cartCount];
				$result=["allTotals"=>$allTotals,"homeCollectionStep"=>$homeCollectionStep,"labCollectionStep"=>$labCollectionStep,"payments"=>$payments,"paymentHeading"=>"Select Payment Method","couponEnterShow"=>$couponEnterShow];
				$message=array("message"=>'success',"msgCode"=>"1","result"=>$result);
			}
			else
			{
				//2 means redirect to cart
				$message=array("message"=>"Your Cart is empty.","msgCode"=>"2");
				$opt=json_encode($message, JSON_UNESCAPED_UNICODE);
				echo $this->app->utility->indent($opt);
				exit;
			}
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