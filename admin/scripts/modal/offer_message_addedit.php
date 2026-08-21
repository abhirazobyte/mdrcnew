<?php
$id=$app->getGetVar('id');

if($id!='')
{
	//Edit offer_message
	$obj_brand = $app->load_model("offer_message");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			

	$popup_type=$result[0]['popup_type'];
	$message_text=$result[0]['message_text'];
	$description=$result[0]['description'];
	
	$link=$result[0]['link'];
		
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	
	
	
	$page_types=$result[0]['page_types'];
	$start_date=$result[0]['start_date'];
	$end_date=$result[0]['end_date'];
	$start_time=$result[0]['start_time'];
	$end_time=$result[0]['end_time'];
	
	$folder='popup';

	//Mobile
	$image=$result[0]["image"];
	$offer_message_img=$app->utility->get_image_path($image,$folder,'thumb');
}
else
{
	//Add offer_message
	$offer_message_img='images/img_upl.gif';
	
	$start_date=date("m/d/Y");
	$start_time=date("H:i");
}

//Sort Order
$obj_model_offer_message = $app->load_model("offer_message");				
$rs = $obj_model_offer_message->execute("SELECT", false);
$records = array();
for($i=1;$i<=count($rs)+1;$i++)
{
	$records[$i] = $i;
}

?>

<div class="modal fade" id="modal_offer_message_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Offer Message Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="offer_message_form" id="offer_message_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
		
        
        <!--Text-->
         <div class="form-row">
                <div class="form-group col-md-12">
                <label for="inputEmail4">Message<span class="tx-danger">*</span></label>
                <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","value"=>$message_text,"rows"=>"5","required"=>""), "message_text") ;?>
                </div>
                </div>

	
           <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputEmail4">Sort Order<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$records,"required"=>""), "sort_order") ;?>
            </div>
            
            <div class="form-group col-md-3">
              <label for="inputEmail4">Offer Display Page</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$page_types,"values"=>array(""=>"All pages","Home"=>"Home","Product"=>"Product","Category"=>"Category","Cart"=>"Cart","Checkout"=>"Checkout","My Account"=>"My Account")), "page_types") ;?>
            </div>
            
             <div class="form-group col-md-6">
              <label for="inputEmail4">Type</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$popup_type,"onchange"=>"show_data(this.value)","values"=>array(""=>"Only Text","Image_Popup"=>"Image Popup","Text_Popup"=>"Text Popup","Link"=>"Link")), "popup_type") ;?>
            </div>
          </div>
          
          
          <div class="form-row">
            
            
            
            
            
            
              
              
            
            
             
             
            
            
          </div>

<?php
if($id=='')
{
	$images='style="display:none"';
	$texts='style="display:none"';
	$links='style="display:none"';
}
else
{
	if($popup_type=='Image_Popup')
	{
		$images='';
		$texts='style="display:none"';
		$links='style="display:none"';;
	}
	else if($popup_type=='Text_Popup')
	{
		$images='style="display:none"';
		$texts='';
		$links='style="display:none"';
	}
	else if($popup_type=='Link')
	{
		$images='style="display:none"';
		$texts='style="display:none"';
		$links='';
	}
	else
	{
		$images='style="display:none"';
		$texts='style="display:none"';
		$links='style="display:none"';
	}
}
?>     


          
          
          <div class="form-row">	
                <!--Image-->

              <div class="form-group col-md-12" id="images" <?=$images?>>
                <label for="inputEmail4">Large Image (Size : 1300 x 400 Px.)<span class="tx-danger">*</span></label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new" >
                    <img src="<?=$offer_message_img;?>" class="up_img">
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                    <span class="btn btn-file btn-default">
                    <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "image") ?></span>
                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
  		  </div> 
             
             	<!--Text-->
                <div class="form-group col-md-12" id="texts" <?=$texts?>>
                <label for="inputEmail4">Text<span class="tx-danger">*</span></label>
                <? $app->htmlBuilder->buildTag("textarea", array("class"=>"form-control required","value"=>$description,"rows"=>"5"), "description") ;?>
                </div>
                
                
                <!--Link-->
                <div class="form-group col-md-12" id="links" <?=$links?>>
                <label for="inputEmail4">Link<span class="tx-danger">*</span></label>
                <? $app->htmlBuilder->buildTag("input", array("class"=>"form-control required","value"=>$link), "link") ;?>
                </div>          
          </div>
          
          
          
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          

          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn offer_message_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

 <script>
   
function show_data(a)
{
	if(a=='Image_Popup')
	{
		 $("#images").show();
		 $("#texts").hide();
		 $("#links").hide();
		
	}
	else if(a=='Text_Popup')
	{
		 $("#images").hide();
		 $("#texts").show();
		 $("#links").hide();
		
	}
	else if(a=='Link')
	{
		 $("#images").hide();
		 $("#texts").hide();
		 $("#links").show();
	}
	else
	{
		 $("#images").hide();
		 $("#texts").hide();
		 $("#links").hide();
		
	}
	   
}
</script>
