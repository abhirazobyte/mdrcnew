<?php
$id=$app->getGetVar('id');
$del_date=$app->getGetVar('del_date');
$del_time=$app->getGetVar('del_time');
$order_reff_data=$app->getGetVar('order_reff_data');


if($del_date !='')
{
	$day=date("l",strtotime($del_date));
	$obj_model_time_slot = $app->load_model("time_slot");
	$rs_time_slot = $obj_model_time_slot->execute("SELECT", false, "", "FIND_IN_SET('".$day."',day)","");
	$time='';
	if(count($rs_time_slot)>0)
	{
		$time.='<option value="">Select Time</option>';
		$current_time=strtotime(date('h:i A'));
		if($date==date('d-m-Y'))
		{
			$sabzi=0;
			for($i=0;$i<count($rs_time_slot);$i++)
			{
				$start_time = strtotime($rs_time_slot[$i]['start_time']);
				if($start_time>$current_time)
				{
					$msg='';	
					if($del_time==$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'])
					{
						$selected="selected";
					}
					else
					{
						$selected="";	
					}
					$time.='<option '.$selected.' value="'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'">'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';	
				}
				else
				{		
				
					$time.='<option disabled="disabled">'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';
					$sabzi++;
					if(count($rs_time_slot)==$sabzi)
					{
						$msg='<p>Delivery Time Not Available On '.$day.' Please Select Other Date.</p>';
					}
					else
					{	
						$msg='';
					}
				}
			}
		}
		else
		{
			$msg='';
			for($i=0;$i<count($rs_time_slot);$i++)
			{
				if($del_time==$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'])
				{
					$selected="selected";
				}
				else
				{
					$selected="";	
				}
					
				$time.='<option '.$selected.' value="'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'">'.$rs_time_slot[$i]['start_time'].' - '.$rs_time_slot[$i]['end_time'].'</option>';	
			}
		}
	}
	else
	{
		$msg='<p>Delivery Not Available On '.$day.'</p>';
		$time='<option value="">Select Time</option>';
	}
}
else
{
$msg='';
$time='<option value="">Select Time</option>';
}

?>

<div class="modal fade" id="modal_order_delivery_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Order Delivery Date Upadet (#<?=$id?>)</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="order_delivery_date_form" id="order_delivery_date_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "delID") ?>
        <div class="modal-body">

           <div class="form-row">
            <div class="form-group col-md-12">
                <p>Current Delivery Date : <strong> <?=$del_date?></strong> & Time : <strong><?=$del_time?></strong></p>
            </div>
           
            <div class="form-group col-md-6">
                <label for="inputEmail4">Delivery Date <span class="tx-danger">*</span></label>
                
                <div class="input-group">

            <div class="input-group-prepend">

                      <div class="input-group-text">

                        <i class="far fa-calendar-alt"></i>

                      </div>

                    </div>

                <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control required input-datepicker","placeholder"=>"DD-MM-YYYY","data-date-format"=>"dd-mm-yyyy","value"=>$del_date,"required"=>"","onclick"=>"change_time_slot(this.value)"), "del_date") ;?>

            </div>
                
  
              
             </div>
            
             <div class="form-group col-md-6">
                <label for="inputEmail4">Time Slot<span class="tx-danger">*</span></label>
                 <div id="get_time">
                <select name="del_time" id="del_time" class="form-control required">
                  <?=$time?>
                </select>
                 <div id="get_msg"><?=$msg?></div>
              </div>
            </div>
            
             
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn order_delivery_date_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>



$('.input-datepicker, .input-daterange').datepicker({ 
	dateFormat: 'dd-mm-yy',
	  minDate: '0'
	})
	.on('changeDate', function(e){ $(this).datepicker('hide'); });


function change_time_slot(deli_date)
{
	if(deli_date!='')
	{
 	  	$.ajax({
		type: "POST",
		url: "scripts/ajax/index.php",
		data:'method=order&actionType=orderDeliveryDate&deli_date='+deli_date,
		dataType:'json',
			success: function(data){
				if(data.RESULT==1)
				{
					$('#get_time').html(data.url);
					$('#get_msg').html(data.msg);
				}
				else
				{
					$('#get_time').html(data.url);
				}
			}
		});
	}
	else
	{
		$('#get_time').html('');
	}
}
</script>