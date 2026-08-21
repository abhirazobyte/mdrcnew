<?php
$id=$app->getGetVar('id');
if($id!='')
{
  //Edit job_opening
  $obj_brand = $app->load_model("job_opening");
  $result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");
  $id=$result[0]['id'];
  $title=$result[0]['title'];
  $description=$result[0]['description'];
  $city_id=$result[0]['city_id'];
  $no_of_opening=$result[0]['no_of_opening'];
  $salary_range=$result[0]['salary_range'];
  $status=$result[0]['status'];
  $sort_order=$result[0]['sort_order'];
}

$obj_model_brand = $app->load_model("city");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active'");
$records1 = array();
$records1[''] = " Select City";
for($i=0;$i<count($rs);$i++){
  $records1[$rs[$i]['id']] = $rs[$i]['name'];
}
?>
<div class="modal fade" id="modal_job_opening_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Job Opening Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="job_opening_form" id="job_opening_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

             <div class="form-group col-md-12">
              <label for="inputEmail4">Title <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$title,"required"=>""), "title") ?>
            </div>

             <div class="form-group col-md-4">
              <label for="inputEmail4">No Of Opening <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$no_of_opening,"required"=>""), "no_of_opening") ?>
            </div>

            <div class="form-group col-md-4">
              <label for="inputEmail4">Salary Range <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$salary_range,"required"=>""), "salary_range") ?>
            </div>

            <div class="form-group col-md-4">
              <label for="inputEmail4">City</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","selected"=>$city_id, "values"=>$records1,"required"=>""), "city_id") ;?>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">Description <span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control ckeditor","value"=>$description,"style"=>"height: 250px;","required"=>""), "description") ?>
            </div>

        
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Orde</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('job_opening'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn job_opening_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.ckeditor').each( function () 
{
    CKEDITOR.replace( this.id );
});
</script>

<script>
    // Disable Bootstrap's focus enforcement to allow CKEditor dialogs
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>