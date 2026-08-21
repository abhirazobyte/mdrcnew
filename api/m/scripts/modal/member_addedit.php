<?php
$id = $app->getGetVar('id');
$cartID = $app->getGetVar('cartID');

$getType = $app->getGetVar('getType');

if ($id == '') {
  $id = 0;
}


$customer_id = $_SESSION['MDRCCustID'];

$obj_model_user = $app->load_model("customer_members");
$rs_adderess = $obj_model_user->execute("SELECT", false, "", "customer_id=" . $_SESSION['MDRCCustID'] . " and id='" . $id . "'", "id DESC limit 0,1");

$prefix = $rs_adderess[0]['prefix'];
$first_name = $rs_adderess[0]['first_name'];
$last_name = $rs_adderess[0]['last_name'];
$phone1 = $rs_adderess[0]['phone1'];
$gender = $rs_adderess[0]['gender'];
$phone2 = $rs_adderess[0]['phone2'];
$relation = $rs_adderess[0]['relation'];
$age = $rs_adderess[0]['age'];
$dob = $rs_adderess[0]['dob'];
$id = $rs_adderess[0]['id'];


$line1 = $rs_adderess[0]['line1'];
$area = $rs_adderess[0]['area'];
$pincode = $rs_adderess[0]['pincode'];
$city_id = $rs_adderess[0]['city_id'];
$state_id = $rs_adderess[0]['state_id'];


if ($id > 0) {
  $add_title = 'Edit';
} else {
  $add_title = 'Add New';
}



$obj_model_state = $app->load_model("state");
$rs = $obj_model_state->execute("SELECT", false, "", "status='Active'");
$records0 = array();
$records0[''] = " Select";
for ($i = 0; $i < count($rs); $i++) {
  $records0[$rs[$i]['id']] = $rs[$i]['name'];
}


$obj_model_city = $app->load_model("city");
$rs2 = $obj_model_city->execute("SELECT", false, "", "status='Active' and state_id='" . $state_id . "'");
$records4 = array();
$records4[''] = " Select";
for ($i = 0; $i < count($rs2); $i++) {
  $records4[$rs2[$i]['id']] = $rs2[$i]['name'];
}


$obj_model_pincode = $app->load_model("pincode");
$rs3 = $obj_model_pincode->execute("SELECT", false, "", "status='Active' and city_id='" . $city_id . "'", "", "pincode.name");


$records3 = array();
$records3[''] = " Select";
for ($i = 0; $i < count($rs3); $i++) {


  $records3[$rs3[$i]['name']] = $rs3[$i]['name'];
}









$obj_model_state = $app->load_model("customer_prefix");
$rs = $obj_model_state->execute("SELECT", false, "", "status='Active'");
$records1 = array();
$records1[''] = " Select";
for ($i = 0; $i < count($rs); $i++) {
  $records1[$rs[$i]['name']] = $rs[$i]['name'];
}


$records2 = array();
$records2[''] = " Select";
$records2['Self'] = 'Self';
$records2['Spouse'] = 'Spouse';
$records2['Child'] = 'Child';
$records2['Parent'] = 'Parent';
$records2['Grand Parent'] = 'Grand Parent';
$records2['Sibling'] = 'Sibling';
$records2['Friend'] = 'Friend';
$records2['Relative'] = 'Relative';
$records2['Neighbour'] = 'Neighbour';
$records2['Colleague'] = 'Colleague';
$records2['Other'] = 'Other';


if ($id == '') {
  $gender = 'Male';
}
?>
<!-- The Modal -->
<div class="action action-confirmation offcanvas offcanvas-bottom common-popup" tabindex="-1" id="modalform-add-member" aria-labelledby="modalform-add-member">


<div class="offcanvas-header">
		<div class="d-flex align-items-center justify-content-between w-100">
			<h3 class="fw-600">Add New Family Member</h3>
			<div class="btnclose">
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
		</div>
	</div>
  <div class="offcanvas-body small pt-0">
    
      <!-- <div class="modal-header">
        <div class="common-heading">
          <h4 class="mt0 mb0">Add New Family Member</h4>
        </div>
        <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
      </div> -->
    
        <div class="form-block fdgn2 mt10 mb10">
          <form action="" method="post" name="add_customer_members" id="add_customer_members" class="custom-form">
            <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="<?= $customer_id ?>">
            <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $id), "id") ?>
            <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $cartID), "cartID") ?>


            <div class="fieldsets row">

              <div class="col-md-4 col-12 input-box">


                <label for="f-name" class="cust">Prefix</label>
                <? $app->htmlBuilder->buildTag("select", array("class" => "rounded form-select", "selected" => $prefix, "values" => $records1, "required" => ""), "prefix"); ?>
              </div>
              <div class="col-md-4 col-12 input-box">
                <label class="cust">First Name</label>


                <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "required form-control", "value" => $first_name), "first_name") ?>


              </div>

              <div class="col-md-4 col-12 input-box">
                <label class="cust">Last Name</label>


                <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "required form-control", "value" => $last_name), "last_name") ?>


              </div>
            </div>
            <div class="fieldsets row">

              <div class="col-md-6 col-12 input-box">

                <?php
                $male = '';
                $female = '';
                if ($gender == 'Male') {
                  $male = 'checked';
                } else {
                  $female = 'checked';
                }
                ?>

                <label class="w-100 mb-3 cust">Gender</label>
                <div class="d-flex">
                <label class="text-dark me-3 cust d-flex align-items-center"><input type="radio" name="gender" value="Male" <?= $male ?> /> Male</label>
                <label class="text-dark cust d-flex align-items-center"><input type="radio" name="gender" value="Female" <?= $female ?> /> Female</label>
                </div>
              </div>

              <div class="col-md-6 col-12 input-box">
                <label class="cust">Mobile Number </label>
                <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "numbersOnly numbers  required  form-control", "value" => $phone1, "maxlength" => "10", "minlength" => "10"), "phone1") ?>
              </div>


            </div>
            <div class="fieldsets row ">
              <div class="col-md-6 col-12 input-box">
                <label class="cust">Date Of Birth</label>
                <? $app->htmlBuilder->buildTag("input", array("type" => "date", "class" => "form-control", "value" => $dob, "onchange" => "calculateage(this.value)"), "dob") ?>
              </div>
              <!-- <div class="col-md-3 col-12 input-box">
                <label class="cust">Age</label> -->
                <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "numbersOnly numbers form-control", "value" => $age, "maxlength" => "3", "minlength" => "1"), "age") ?>
              <!-- </div> -->






              <div class="col-md-3 col-12 input-box">


                <label for="f-name" class="cust">Relation</label>
                <? $app->htmlBuilder->buildTag("select", array("class" => "rounded form-select", "selected" => $relation, "values" => $records2, "required" => ""), "relation"); ?>
              </div>
            </div>





            <div class="fieldsets row ">
              <div class="col-md-12 col-12 input-box">
                <label class="cust">Address (Area and Street) *</label>


                <? $app->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "required form-control", "rows" => "1", "cols" => "5", "value" => $line1), "line1") ?>
              </div>
              <div class="col-md-6 col-12 input-box">
                <label for="" id="" class="cust">State *</label>
                <? $app->htmlBuilder->buildTag("select", array("class" => "required form-select", "onchange" => "change_city_area(this.value)", "selected" => $state_id, "values" => $records0, "required" => ""), "state_id"); ?>
              </div>


              <div class="col-md-6 col-12 input-box">


                <label for="" id="" class="cust">City *</label>
                <? $app->htmlBuilder->buildTag("select", array("class" => "required form-select", "onchange" => "change_pincode_area(this.value)", "selected" => $city_id, "values" => $records4, "required" => ""), "city_id"); ?>
              </div>



              <div class="col-md-6 col-12 input-box">
                <label for="" id="" class="cust">Area *</label>
                <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "required form-control", "value" => $area), "area") ?>
              </div>

              <div class="col-md-6 col-12 input-box">
                <label for="" id="" class="cust">Pincode *</label>
                <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "numbersOnly numbers required form-control", "value" => $pincode), "pincode") ?>

                <?php //$app->htmlBuilder->buildTag("select", array("class"=>"required","selected"=>$pincode, "values"=>$records3,"required"=>""), "pincode") ;
                ?>
              </div>

            </div>





            <div class="fieldsets d-flex justify-content-center">
              <a href="javascript:void(0)" class="btn btn-outline-solid me-2 lnk" data-bs-dismiss="modal">Cancel<span class="circle"></span></a>
              <button type="submit" name="submit" class="btn-solid lnk btn-main bg-btn w-auto  ms-2 ajax_modal_submit_member">Save<span class="circle"></span></button>
            </div>
          </form>
        </div>
    

  </div>
</div>
<script type="text/javascript">
  $('.numbersOnly').keyup(function() {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
      this.value = this.value.replace(/[^0-9\.]/g, '');
    }
  });

  $("input.numbers").keypress(function(event) {

    return /\d/.test(String.fromCharCode(event.keyCode));

  });

  function calculateage(dob) {
    var userinput = document.getElementById("dob").value;
    var dob = new Date(userinput);
    if (userinput == null || userinput == '') {
      return false;
    } else {

      //calculate month difference from current date in time  
      var month_diff = Date.now() - dob.getTime();

      //convert the calculated difference in date format  
      var age_dt = new Date(month_diff);

      //extract year from date      
      var year = age_dt.getUTCFullYear();

      //now calculate the age of the user  
      var age = Math.abs(year - 1970);

      $("#age").val(age);
    }
  }
</script>