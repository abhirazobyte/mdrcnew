<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit sizechart
	$obj_sizechart = $app->load_model("sizechart");
	$result = $obj_sizechart->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$slug=$result[0]['slug'];
	
	$folder='sizechart';
	//image
	$image=$result[0]["image"];

	$sizechart_img1=$app->utility->get_image_path($image,$folder,"");
	$sizechart_img=$sizechart_img1['large_image'];
}
else
{
	//Add sizechart
	$sizechart_img='images/img_upl.gif';	
}
?>

<div class="modal fade" id="modal_sizechart_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Sizechart Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="sizechart_form" id="sizechart_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">


	 	 <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>
            </div>
            
          </div>
          
          
          

	<div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Image (Size : 1300 x 400 Px.)</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new" >
            <img src="<?=$sizechart_img;?>" id="image_<?=$id?>_image" class="up_img">
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
            <span class="btn btn-file btn-default">
            <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span><? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "sizechart_image") ?></span>
            <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
            
             <?php if($id!='' && $image!=''){ ?>
               <button id="btn_<?=$id?>_image" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','sizechart','image','sizechart')" type="button">Remove</button>
              <?php }?>
            
            </div>
        </div>
  		  </div>
        
			
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('sizechart'),"required"=>""), "sort_order") ;?>
            <br />
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn sizechart_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
