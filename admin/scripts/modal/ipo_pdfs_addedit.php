<?php
$id=$app->getGetVar('id');

if($id!='')
{
	//Edit ipo_pdfs
	$obj_brand = $app->load_model("ipo_pdfs");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");

  $page_type=$result[0]['page_type'];
	$title=$result[0]['title'];
	$qr_code=$result[0]['qr_code'];
  $sort_order=$result[0]['sort_order'];
  $status=$result[0]['status'];
}
?>

<div class="modal fade" id="modal_ipo_pdfs_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">IPO Pdf Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="ipo_pdfs_form" id="ipo_pdfs_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">Page Type</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$page_type, "values"=>array("Policies"=>"Policies","IPO"=>"IPO / Offer Documents","News Releases"=>"News Releases"),"required"=>""), "page_type") ;?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Title</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$title,"required"=>""), "title") ?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">QR Code</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=> $qr_code, "values"=>array("Yes"=>"Yes","No"=>"No"),"required"=>""), "qr_code") ;?>
            </div>
          
            <div class="form-group col-md-12">
              <label class="" for="example-email">Select File</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => "form-control"), "file_2") ?>
              <?php if($result[0]['file_name'] != '') { ?>
                <a href="../../uploads/ipo_pdfs/<?=$result[0]['file_name']?>" target="_blank"><?=$result[0]['file_name']?></a>
              <?php } ?>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('ipo_pdfs'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn ipo_pdfs_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
