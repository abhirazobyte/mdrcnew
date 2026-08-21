<?php
$id=$app->getGetVar('id');
?>

<div class="modal fade" id="modal_lis_visitor_detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Lis Visitor Details</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="formLisVisitorInfo" id="formLisVisitorInfo"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "lis_order_detail_id") ?>
        <div class="modal-body">

         <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Visitor ID *</label>
              <? $app->htmlBuilder->buildTag("input", array("class"=>"form-control required", "value"=>"","required"=>""), "lis_visitor_id") ;?>
            </div>
          </div>
          
         <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Visitor Password</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>''), "lis_visitor_pass") ;?>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn SubmitformLisVisitorInfo">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
