<?php
date_default_timezone_set("Asia/Kolkata");
$jsonclass = $app->load_module("Services_JSON");
$obj_JSON = new $jsonclass(SERVICES_JSON_LOOSE_TYPE);

$date=$app->getPostVar('deli_date');
	
	 if($date != ''){
		 
		$day=date("l",strtotime($date));
		 
		$obj_model_time_slot = $app->load_model("time_slot");
		$rs_time_slot = $obj_model_time_slot->execute("SELECT", false, "", "FIND_IN_SET('".$day."',day)","");
		
		$time='';
		
		if(count($rs_time_slot)>0)
		{
			$time.='<select name="del_time" id="del_time" class="form-control required" required="">
			
			<option value="">Select</option>';
			$current_time=strtotime(date('h:i A'));
			
			if($date==date('d-m-Y'))
			{
				for($i=0;$i<count($rs_time_slot);$i++)
				{
					$start_time = strtotime($rs_time_slot[$i]['start_time']);
					//if($start_time>$current_time){
					$time.='<option>'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';	
					//}else{
					//$time.='<option disabled="disabled" style="background-color: #FDDBDB;">'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';
					//}
				}
			}
			else
			{
				for($i=0;$i<count($rs_time_slot);$i++)
				{
					$time.='<option>'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';	
				}
			}
				
			
			$time.='</select>';
			echo $obj_JSON->encode(array("RESULT"=>"1", "TIME"=>$time));
		}
		else
		{
			$time.='<select name="del_time" id="del_time" class="form-control required" required="">
			
			<option value="">Select</option>';
			$time.='</select>';
			
			
			$time.='<strong style="color:#DC1717;">Delivery Not Available On '.$day.'</strong>';
			echo $obj_JSON->encode(array("RESULT"=>"0", "TIME"=>$time));
		}
		 		 	
	 }
	 else
	 {
		 echo $obj_JSON->encode(array("RESULT"=>"0"));
	 }
	
	
?>