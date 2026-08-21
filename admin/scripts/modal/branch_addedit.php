<?php
$id = $app->getGetVar('id');

$obj_model_brand11 = $app->load_model("city");
$rs3 = $obj_model_brand11->execute("SELECT", false,"","status='Active'");
$records2 = array();
$records2[''] = "Select City";
for($i=0;$i<count($rs3);$i++)
{
  $records2[$rs3[$i]['id']] = $rs3[$i]['name'];
}

if ($id != '') {
  //Edit branch
  $obj_branch = $app->load_model("branch");
  $result = $obj_branch->execute("SELECT", false, "", "id='" . $id . "'");

  $name = $result[0]['name'];
  $phone1 = $result[0]['phone1'];
  $phone2 = $result[0]['phone2'];
  $email1 = $result[0]['email1'];
  $email2 = $result[0]['email2'];
  $business_url = $result[0]['business_url'];
  $address = $result[0]['address'];
  $city_id = $result[0]['city_id'];

  $sort_order = $result[0]['sort_order'];
  $status = $result[0]['status'];
  $slug = $result[0]['slug'];

  $folder = 'branch';
  //image
  $image = $result[0]["image"];

  $branch_img1 = $app->utility->get_image_path($image, $folder, "");
  $branch_img = $branch_img1['large_image'];
} else {
  //Add branch
  $branch_img = 'images/img_upl.gif';
}
?>

<div class="modal fade" id="modal_branch_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Branch Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="branch_form" id="branch_form" data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "form-control", "value" => $id), "id") ?>
        <div class="modal-body">


          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "value" => $name, "required" => ""), "name"); ?>
            </div>

          </div>



          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Phone 1</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $phone1), "phone1"); ?>
            </div>


            <div class="form-group col-md-6">
              <label for="inputEmail4">Phone 2</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $phone2), "phone2"); ?>
            </div>

          </div>



          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email 1</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $email1), "email1"); ?>
            </div>


            <div class="form-group col-md-6">
              <label for="inputEmail4">Email 2</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $email2), "email2"); ?>
            </div>

          </div>


          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Address</label>
              <? $app->htmlBuilder->buildTag("textarea", array("class" => "form-control ", "value" => $address, "rows" => "2"), "address"); ?>
            </div>

          </div>


          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Business URL</label>
              <? $app->htmlBuilder->buildTag("textarea", array("class" => "form-control ", "value" => $business_url, "rows" => "2"), "business_url"); ?>
            </div>

          </div>




          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputEmail4">City</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control select2", "selected" => $city_id, "values" => $records2, "required" => ""), "city_id"); ?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">Sort Order</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control ", "selected" => $sort_order, "values" => $app->utility->sort_order('branch'), "required" => ""), "sort_order"); ?>
            </div>
            <div class="form-group col-md-4">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $status, "values" => array("Active" => "Active", "Inactive" => "Inactive"), "required" => ""), "status"); ?>
            </div>
          </div>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn branch_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>