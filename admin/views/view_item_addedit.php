<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashforge.auth.css">
<link href="lib/select2/css/select2.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- file upload  -->
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />
<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<!-- new added by developer -->
<link rel="stylesheet" href="assets/css/custom.css">
<style>
  .sweet-alert {
    z-index: 999999 !important;
  }

  .scrollbox {
    overflow-y: scroll;
    max-height: 220px;
    border: 1px solid #dae0e8;
  }

  .even {
    margin-left: 20px;
  }

  .price_varient {
    padding: 0;
    margin: 0;
  }



  /* NEW DROPDOWN SELECT INPUT */
.custom-multi-select {
  position: relative;
}

.custom-multi-select > label {
  margin-bottom: 8px;
  display: inline-block;
  color: #1f2937;
}

.custom-multi-select .category-selectbox {
  position: relative;
  width: 100%;
}

.custom-multi-select .category-selectbox-title {
  min-height: 46px;
  border: 1px solid #d0d5dd;
  border-radius: 5px;
  background: #fff;
  padding: 11px 42px 11px 14px;
  display: flex;
  align-items: center;
  position: relative;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
}

.custom-multi-select .category-selectbox-title:hover {
  border-color: #b8c0cc;
}

.custom-multi-select .category-selectbox.open .category-selectbox-title {
  border-color: #0d6efd;
  box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.12);
}

.custom-multi-select .plzselect {
  color: #6b7280;
  font-size: 14px;
}

.custom-multi-select .selected-text {
  color: #111827;
  font-size: 14px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: calc(100% - 20px);
}

.custom-multi-select .select-arrow {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  transition: transform 0.25s ease;
  pointer-events: none;
}

.custom-multi-select .category-selectbox.open .select-arrow {
  transform: translateY(-50%) rotate(180deg);
}

.custom-multi-select .category-selectbox-content {
  display: none;
  position: absolute;
  top: calc(100% + 8px);
  left: 0;
  width: 100%;
  background: #fff;
  border: 1px solid #e4e7ec;
  border-radius: 12px;
  box-shadow: 0 16px 40px rgba(16, 24, 40, 0.12);
  z-index: 999;
  padding: 12px;
}

.custom-multi-select .category-selectbox.open .category-selectbox-content {
  display: block;
  animation: categoryDropdownFade 0.2s ease;
}

@keyframes categoryDropdownFade {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.custom-multi-select .category-search-wrap {
  display: flex;
  align-items: center;
  border: 1px solid #d0d5dd;
  border-radius: 10px;
  background: #f9fafb;
  overflow: hidden;
  margin-bottom: 12px;
}

.custom-multi-select .category-search-icon,
.custom-multi-select .category-clear-search {
  width: 40px;
  min-width: 40px;
  height: 40px;
  border: none;
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #667085;
}

.custom-multi-select .category-clear-search {
  cursor: pointer;
  transition: all 0.2s ease;
}

.custom-multi-select .category-clear-search:hover {
  background: #eef2f7;
  color: #111827;
}

.custom-multi-select .category-search-box {
  flex: 1;
  border: none;
  outline: none;
  box-shadow: none;
  background: transparent;
  padding: 10px 2px;
  font-size: 14px;
  color: #111827;
}

.custom-multi-select .category-search-box::placeholder {
  color: #98a2b3;
}

.custom-multi-select .category-ul-list {
  list-style: none;
  margin: 0;
  padding: 0;
  max-height: 240px;
  overflow-y: auto;
}

.custom-multi-select .category-ul-list::-webkit-scrollbar {
  width: 6px;
}

.custom-multi-select .category-ul-list::-webkit-scrollbar-thumb {
  background: #d0d5dd;
  border-radius: 20px;
}

.custom-multi-select .category-ul-list li {
  margin: 0;
}

.custom-multi-select .category-checkbox {
  display: none;
}

.custom-multi-select .category-checkbox-label {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 14px;
  color: #111827;
  transition: all 0.2s ease;
  margin: 0;
  font-weight: 400;
}

.custom-multi-select .category-checkbox-label:hover {
  background: #f3f6fb;
}

.custom-multi-select .category-checkbox-label::before {
  content: "";
  width: 18px;
  height: 18px;
  min-width: 18px;
  border: 1.5px solid #c5ccd8;
  border-radius: 6px;
  background: #fff;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.custom-multi-select .category-checkbox:checked + .category-checkbox-label {
  background: #eff6ff;
  color: #0f172a;
  font-weight: 500;
}

.custom-multi-select .category-checkbox:checked + .category-checkbox-label::before {
  content: "\f00c";
  font-family: "FontAwesome";
  font-size: 11px;
  color: #fff;
  background: #0d6efd;
  border-color: #0d6efd;
}

.custom-multi-select .category-no-data,
.custom-multi-select .category-no-results {
  padding: 10px 12px;
  font-size: 14px;
  color: #6b7280;
}
</style>
<?php include('includes/menu.php'); ?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php'); ?>
  <!-- content-header -->
  <div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">Page</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                <?= $this->to_do ?>
              </li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">
            <?= $this->to_do ?>
            <?= $this->manage_for ?>
          </h4>
        </div>
        <div class="d-none d-md-block"> </div>
      </div>
      <?= $this->utility->get_message() ?>
      <? $this->htmlBuilder->buildTag("form", array("action" => "", "data-parsley-validate" => "", "class" => "form-horizontal form-bordered form-validate"), "frm_item_addedit"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->id), "id"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->getGetVar('pg_no')), "pg_no"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => "update_data"), "act"); ?>
      <? $this->htmlBuilder->buildTag("input", array("type" => "hidden", "value" => $this->folder), "folder"); ?>
      <div class="row">
        <div class="col-lg-8">
          <div data-label="item Basic Information" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Name <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "required" => "", "value" => $this->rsitem['name']), "name1") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Tags </label>
              <? $this->htmlBuilder->buildTag("textarea", array("class" => "form-control ", "value" => $this->rsitem['tags']), "tags") ?>
              <span class="text-danger">Note: Enter keywords by comma separated.(e.g. test1,test2)</span>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Item ID <span class="tx-danger">*</span></label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "required" => ""), "itemid") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Item Code <span class="tx-danger">*</span></label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "required" => ""), "itemcode") ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Item Type <span class="tx-danger">*</span></label>
                  <? $this->htmlBuilder->buildTag("select", array("selected" => $this->rsitem['item_other_data_item_type_id'], "class" => "form-control", "values" => $this->item_type, "required" => "", "onchange" => "changeTestPackageData(this.value)"), "item_type_id") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Test Count <span class="tx-danger">*</span></label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control numbers numberOnly", "required" => ""), "test_count") ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Key Features</label>
                  <select class="form-control select2" multiple="multiple" name="work_item_key_fetures[]" required="">
                    <?
                    $rs_work = $this->item_key_fetures;
                    $ids_data = $this->rsitem['item_other_data_item_key_fetures_ids'];
                    for ($i = 0; $i < count($rs_work); $i++) {
                      $micro_items = explode(',', $ids_data);
                    ?>
                      <option value="<?= $rs_work[$i]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                                  if ($rs_work[$i]['id'] == trim($micro_items[$j])) {
                                                                    echo 'selected';
                                                                  }
                                                                } ?>>
                        <?= $rs_work[$i]['name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Department <span class="tx-danger">*</span></label>
                  <select class="form-control select2" multiple="multiple" name="work_item1[]" required="">
                    <?
                    $rs_work = $this->item_department;
                    $ids_data = $this->rsitem['item_other_data_item_department_ids'];
                    for ($i = 0; $i < count($rs_work); $i++) {
                      $micro_items = explode(',', $ids_data);
                    ?>
                      <option value="<?= $rs_work[$i]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                                  if ($rs_work[$i]['id'] == trim($micro_items[$j])) {
                                                                    echo 'selected';
                                                                  }
                                                                } ?>>
                        <?= $rs_work[$i]['name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              
              <div class="form-group col-md-12 custom-multi-select" id="diseasesMultiSelect">
                <label for="diseasesSearch">Diseases</label>

                <div class="category-selectbox">
                  <div class="category-selectbox-title form-control" tabindex="0">
                    <span class="plzselect">Please Select</span>
                    <span class="selected-text" style="display:none;"></span>
                    <span class="select-arrow"><i class="fa fa-angle-down"></i></span>
                  </div>

                  <div class="category-selectbox-content">
                    <div class="category-search-wrap">
                      <span class="category-search-icon"><i class="fa fa-search"></i></span>
                      <input id="diseasesSearch" class="category-search-box" type="text" placeholder="Search" autocomplete="off"/>
                      <button class="category-clear-search" type="button"><i class="fa fa-close"></i></button>
                    </div>

                    <ul class="category-ul-list">
                      <?php
                      $rs_diss = $this->item_diseases;
                      $ids_data_diss = $this->rsitem['item_other_data_item_diseases_ids'];
                      $micro_diseases = is_array($ids_data_diss) ? $ids_data_diss : explode(',', $ids_data_diss);

                      if (count($rs_diss) > 0) {
                        for ($i = 0; $i < count($rs_diss); $i++) { ?>
                          <li>
                            <input class="category-checkbox" name="work_item2[]" type="checkbox" id="disease_<?= $rs_diss[$i]['id'] ?>" value="<?= $rs_diss[$i]['id'] ?>"
                              <?php if (in_array($rs_diss[$i]['id'], array_map('trim', $micro_diseases))) echo 'checked'; ?>
                            >
                            <label for="disease_<?= $rs_diss[$i]['id'] ?>" class="category-checkbox-label"><?= $rs_diss[$i]['name'] ?></label>
                          </li>
                        <?php }
                      } else { ?>
                        <li class="category-no-data">No diseases available</li>
                      <?php } ?>
                    </ul>

                    <div class="category-no-results" style="display:none;">No matching disease found</div>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-12 custom-multi-select" id="categoryMultiSelect">
                <label for="categorySearch">Category</label>

                <div class="category-selectbox">
                  <div class="category-selectbox-title form-control" tabindex="0">
                    <span class="plzselect">Please Select</span>
                    <span class="selected-text" style="display:none;"></span>
                    <span class="select-arrow"><i class="fa fa-angle-down"></i></span>
                  </div>

                  <div class="category-selectbox-content">
                    <div class="category-search-wrap">
                      <span class="category-search-icon"><i class="fa fa-search"></i></span>
                      <input id="categorySearch" class="category-search-box" type="text" placeholder="Search" autocomplete="off"/>
                      <button class="category-clear-search" type="button"><i class="fa fa-close"></i></button>
                    </div>

                    <ul class="category-ul-list">
                      <?php
                      $rs_cate = $this->item_category;
                      $ids_data_cat = $this->rsitem['item_other_data_item_category_ids'];
                      $micro_category = is_array($ids_data_cat) ? $ids_data_cat : explode(',', $ids_data_cat);

                      if (count($rs_cate) > 0) {
                        for ($i = 0; $i < count($rs_cate); $i++) { ?>
                          <li>
                            <input class="category-checkbox" name="work_item3[]" type="checkbox" id="category_<?= $rs_cate[$i]['id'] ?>" value="<?= $rs_cate[$i]['id'] ?>"
                              <?php if (in_array($rs_cate[$i]['id'], array_map('trim', $micro_category))) echo 'checked'; ?>
                            >
                            <label for="category_<?= $rs_cate[$i]['id'] ?>" class="category-checkbox-label"><?= $rs_cate[$i]['name'] ?></label>
                          </li>
                        <?php }
                      } else { ?>
                        <li class="category-no-data">No categories available</li>
                      <?php } ?>
                    </ul>

                    <div class="category-no-results" style="display:none;">No matching category found</div>
                  </div>
                </div>
              </div>


              <?php
              if ($this->rsitem['item_other_data_item_type_id'] == 1) {
                $display = 'style="display:none"';
              } else {
                $display = '';
              }
              ?>
              <div class="col-lg-12 testFileds" <?= $display ?>>
                <div class="form-group">
                  <label class="d-block">Sample Remark </label>
                  <? $this->htmlBuilder->buildTag("textarea", array("rows" => "2", "class" => "form-control", "value" => $this->rsitem['item_description_sample_remark']), "sample_remark") ?>
                </div>
              </div>
              <div class="col-lg-12 testFileds" <?= $display ?>>
                <div class="form-group">
                  <label class="d-block">Sample Type Name </label>
                  <? $this->htmlBuilder->buildTag("textarea", array("rows" => "2", "class" => "form-control", "value" => $this->rsitem['item_description_sample_type_name']), "sample_type_name") ?>
                </div>
              </div>
              <div class="col-lg-12 testFileds" <?= $display ?>>
                <div class="form-group">
                  <label class="d-block">Sample Remark 1</label>
                  <? $this->htmlBuilder->buildTag("textarea", array("rows" => "2", "class" => "form-control", "value" => $this->rsitem['item_description_sample_remark1']), "sample_remark1") ?>
                </div>
              </div>
              <div class="col-lg-12 testFileds" <?= $display ?>>
                <div class="form-group">
                  <label class="d-block">Test Parameters <span class="tx-danger">*</span></label>
                  <? $this->htmlBuilder->buildTag("textarea", array("rows" => "2", "class" => "form-control ckeditor", "value" => $this->rsitem['item_description_test_parameters']), "test_parameters") ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div data-label="item Image" class="df-example demo-forms">
            <label class="d-block">Image</label>
            <?php
            $file_class = "fileupload-new";
            if ($this->getGetVar('id')) {
              if ($this->rsitem['image'] != '' &&  file_exists(ABS_PATH . "/" . $this->get_user_config("item") . '/' . $this->folder . '/' . $this->rsitem['image'])) {
                $img = '../uploads/item/' . $this->folder . '/' . $this->rsitem['image'];
                $file_class = "fileupload-exists";
              } else {
                $img = 'images/img_upl.gif';
              }
            } else {
              $img = 'images/img_upl.gif';
            }
            // $file_class="fileupload-new";
            ?>
            <div class="fileupload <?= $file_class; ?>" data-provides="fileupload">
              <div class="fileupload-new"> <img src="images/img_upl.gif" class="up_img"> </div>
              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?= $img; ?>" /> </div>
              <div>
                <span class="btn btn-file btn-default">
                  <span class="fileupload-new btn btn-white btn-xs">Select image</span>
                  <span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "image") ?>
                </span>
                <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
            <span class="tx-11-f tx-danger"><strong>Dimensions :</strong> 1000 x 1000 px</span>
          </div>
          <div data-label="Gender & Days" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">From Age</label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control numbers numberOnly", "required" => "", "value" => $this->rsitem['item_description_from_age_days']), "from_age_days") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">To Age </label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control numbers numberOnly", "required" => "", "value" => $this->rsitem['item_description_to_age_days']), "to_age_days") ?>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Gender</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $this->rsitem['item_description_gender'], "values" => array("Both" => "Both", "Male" => "Male", "Female" => "Female")), "gender") ?>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Min Price" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Min Advance Price for Book</label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control numberOnly", "value" => $this->rsitem['min_price']), "min_price") ?>
                </div>
              </div>
            </div>
          </div>
          <div data-label="Show IN" class="df-example demo-forms" <?= $display2 ?>>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Show In.</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control select2", "multiple" => "", "selected" => explode(',', $this->rsitem['item_other_data_pagewise_test']), "values" => array("therapeutic-drug-monitoring" => "Therapeutic Drug Monitoring", "oncology" => "Oncology", "pregnancy-care" => "Pregnancy Care", "most_book_checkup" => "Most Book Checkup")), "show_in[]") ?>
                </div>
              </div>
            </div>
          </div>
          <?php
          if ($this->rsitem['item_other_data_item_type_id'] == 1) {
            $display2 = '';
          } else {
            $display2 = 'style="display:none"';
          }
          ?>
          <div data-label="Popular Package" class="df-example demo-forms popPackage" <?= $display2 ?>>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Show Popular Package?</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $this->rsitem['set_at_popular_package'], "values" => array("No" => "No", "Yes" => "Yes")), "set_at_popular_package1") ?>
                </div>
              </div>
            </div>
          </div>
          <?php
          if ($this->rsitem['item_other_data_item_type_id'] == 2) {
            $display3 = '';
          } else {
            $display3 = 'style="display:none"';
          }
          ?>
          <div data-label="Popular Test" class="df-example demo-forms popTest" <?= $display3 ?>>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Show Popular Test?</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $this->rsitem['set_at_popular_test'], "values" => array("No" => "No", "Yes" => "Yes")), "set_at_popular_test1") ?>
                </div>
              </div>
            </div>
          </div>
          <div data-label="item Other Data" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Prescription Required?</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $this->rsitem['item_description_prescription_required'], "values" => array("No" => "No", "Yes" => "Yes"), "onchange" => "changeData(this.value)"), "prescription_required") ?>
                </div>
              </div>
              <?php
              if ($this->rsitem['item_description_prescription_required'] == 'Yes') {
                $display1 = '';
              } else {
                $display1 = 'style="display:none"';
              }
              ?>
              <div class="col-lg-12 otherFileds" <?= $display1 ?>>
                <div class="form-group">
                  <label class="d-block">Required Attachment </label>
                  <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "value" => $this->rsitem['item_description_required_attachment']), "required_attachment") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Show Home?</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => array("No" => "No", "Yes" => "Yes")), "set_at_home") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Status</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => array("Active" => "Active", "Inactive" => "Inactive")), "status") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Sort Order</label>
                  <? $this->htmlBuilder->buildTag("select", array("class" => "form-control", "values" => $this->utility->sort_order('item')), "sort_order") ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label class="d-block">Description</label>
            <? $this->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ckeditor", "style" => "height:150px", "value" => $this->rsitem['item_other_data_description']), "description") ?>
          </div>
        </div>
      </div>
      <div class="row varientMasterRow">
        <div class="col-lg-12">
          <div data-label="Item Price" class="df-example demo-forms">
            <input type="hidden" name="masterRowID" id="masterRowID" value="<?= count($this->rs_tab_data) + 1 ?>">
            <div style="display:none">
              <? $this->htmlBuilder->buildTag("select", array("values" => $this->citys, "class" => "span12 form-control", "id" => "attrmaster", "name" => ""), "") ?>
              <? $this->htmlBuilder->buildTag("select", array("values" => $this->certies, "class" => "span12 form-control", "id" => "cert_attr_master", "name" => ""), "") ?>
              <? $this->htmlBuilder->buildTag("select", array("values" => $this->labsList, "class" => "span12 form-control", "id" => "lab_attr_master", "name" => ""), "") ?>
            </div>
            <div class="form-group" id="price_varient">
              <div class="col-md-12">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th width="15%" class="atr1_span">City <span class="tx-danger">*</span></th>
                      <th width="15%">Price <span class="tx-danger">*</span></th>
                      <th width="15%">MRP</th>
                      <th width="15%">Schedule Price</th>
                      <th width="15%">Start Date</th>
                      <th width="15%">End Date</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody id="use_rows">
                    <?php
                    for ($i = 0; $i < count($this->rs_tab_data); $i++) {
                      $pa = $this->rs_tab_data[$i];
                      $attribute_1 = $pa["city_id"];
                      $price = $pa["price"];
                      $mrp = $pa["mrp"];
                      if ($mrp <= 0) {
                        $mrp = '';
                      }
                      $sch_prices = $pa["sch_price"];
                      if ($sch_prices <= 0) {
                        $sch_prices = '';
                      }
                      $starts = $pa["sch_start_date"];
                      $ends = $pa["sch_end_date"];
                      $item_certificate_ids = $pa["item_certificate_ids"];
                      $item_lab_ids = $pa["item_lab_ids"];
                      $table_id = $pa["id"];
                    ?>
                      <tr class="rowd_<?= $table_id ?>">
                        <td><? $this->htmlBuilder->buildTag("select", array("values" => $this->citys, "class" => "span12 form-control required", "selected" => $attribute_1, "id" => "attr1", "name" => "attr1[]"), "") ?>
                          <input type="hidden" name="meeting_task_id[]" value="<?= $table_id ?>">
                          <input type="hidden" name="master_data_id[]" value="<?= $i ?>">
                        </td>
                        <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "value" => $price, "id" => "price", "name" => "prices[]"), "") ?></td>
                        <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "value" => $mrp, "id" => "mrp", "name" => "mrps[]"), "") ?></td>
                        <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "value" => $sch_prices, "id" => "sch_prices", "name" => "sch_prices[]"), "") ?>
                        </td>
                        <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control input-datepicker", "autocomplete" => "off", "value" => $starts, "id" => "starts_e_" . $i . "", "name" => "starts[]"), "") ?>
                        </td>
                        <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control input-datepicker", "autocomplete" => "off", "value" => $ends, "id" => "ends_e_" . $i . "", "name" => "ends[]"), "") ?></td>
                        <td><a style="color:#fff" class="btn btn-xs btn-danger record_delete_attribute_onclick" data-id="<?= $pa['id']; ?>" data-tableid="<?= $pa['id']; ?>" data-tablename="item_price" rel="tooltip" title="Delete"> <i class="fa fa-trash"></i></a></td>
                      </tr>
                      <tr class="rowd_<?= $table_id ?>">
                        <td colspan="1" style="border:none"><label>Certificate :</label></td>
                        <td colspan="5" style="border:none">
                          <select class="form-control select2" multiple="multiple" name="work_certi_item_<?= $i ?>[]">
                            <?
                            $rs_work = $this->rs_item_certificate;
                            for ($m = 0; $m < count($rs_work); $m++) {
                              $micro_items = explode(',', $item_certificate_ids);
                            ?>
                              <option value="<?= $rs_work[$m]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                                          if ($rs_work[$m]['id'] == trim($micro_items[$j])) {
                                                                            echo 'selected';
                                                                          }
                                                                        } ?>>
                                <?= $rs_work[$m]['name']; ?>
                              </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr class="rowd_<?= $table_id ?>">
                        <td colspan="1" style="border:none"><label>Choose Lab :</label></td>
                        <td colspan="5" style="border:none">
                          <select class="form-control select2" multiple="multiple" name="work_lab_item_<?= $i ?>[]">
                            <? $rs_lab = $this->rs_item_lab;
                            for ($m = 0; $m < count($rs_lab); $m++) {
                              $micro_items = explode(',', $item_lab_ids);
                            ?>
                              <option value="<?= $rs_lab[$m]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                                          if ($rs_lab[$m]['id'] == trim($micro_items[$j])) {
                                                                            echo 'selected';
                                                                          }
                                                                        } ?>>
                                <?= $rs_lab[$m]['name']; ?>
                              </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    <?php } ?>
                    <?php
                    $mi = $i + 1;
                    ?>
                    <tr>
                      <td><? $this->htmlBuilder->buildTag("select", array("values" => $this->citys, "class" => "span12 form-control", "id" => "attr1", "name" => "attr1[]"), "") ?>
                        <input type="hidden" name="meeting_task_id[]" value="">
                        <input type="hidden" name="master_data_id[]" value="<?= $mi ?>">
                      </td>
                      <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "id" => "price", "name" => "prices[]"), "") ?></td>
                      <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "id" => "mrp", "name" => "mrps[]"), "") ?></td>
                      <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control numbersOnly", "id" => "sch_prices", "name" => "sch_prices[]"), "") ?>
                      </td>
                      <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control input-datepicker", "id" => "starts_p_0", "data-date-format" => "dd-mm-yyyy", "autocomplete" => "off", "name" => "starts[]"), "") ?>
                      </td>
                      <td><? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "span12 form-control input-datepicker", "id" => "ends_p_0", "data-date-format" => "dd-mm-yyyy", "autocomplete" => "off", "name" => "ends[]"), "") ?></td>
                      <td></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="1" style="border:none"><label>Certificate :</label></td>
                      <td colspan="5" style="border:none">
                        <select class="form-control select2" multiple="multiple" name="work_certi_item_<?= $mi ?>[]">
                          <?
                          $rs_work = $this->rs_item_certificate;
                          $item_certificate_ids = '';
                          for ($m = 0; $m < count($rs_work); $m++) {
                            $micro_items = explode(',', $item_certificate_ids);
                          ?>
                            <option value="<?= $rs_work[$m]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                  if ($rs_work[$m]['id'] == trim($micro_items[$j])) {
                                                    echo 'selected';
                                                  }
                                                } ?>>
                              <?= $rs_work[$m]['name']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1" style="border:none"><label>Choose Lab :</label></td>
                      <td colspan="5" style="border:none">
                        <select class="form-control select2" multiple="multiple" name="work_lab_item_<?= $mi ?>[]">
                          <?
                          $rs_lab = $this->rs_item_lab;
                          for ($m = 0; $m < count($rs_lab); $m++) { ?>
                            <option value="<?= $rs_lab[$m]['id']; ?>"><?= $rs_lab[$m]['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="padding-7" style="text-align:right;"> <a class="btn btn-sm btn-success" href="javascript:add_attr_fields();"> <i class="icon-plus "></i> <strong>+ </strong></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div data-label="Meta Description" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Title <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "value" => $this->rsitem['item_other_data_meta_title']), "meta_title") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Keywords <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control ", "value" => $this->rsitem['item_other_data_meta_keywords']), "meta_keywords") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Description <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ", "value" => $this->rsitem['item_other_data_meta_desc']), "meta_desc") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Meta Schema</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type" => "text", "class" => "form-control ", "value" => $this->rsitem['item_other_data_meta_schema']), "meta_schema") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Note : Write city name like {CITY} in meta details. It will change with current city. <span class="tx-danger">*</span></label>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div data-label="Recommendation" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Recommendation Department</label>
              <select class="form-control select2" multiple="multiple" name="work_item10[]">
                <? $rs_work = $this->item_department;
                $ids_data = $this->rsitem['item_other_data_item_rec_dept_ids'];
                for ($i = 0; $i < count($rs_work); $i++) {
                  $micro_items = explode(',', $ids_data); ?>
                  <option value="<?= $rs_work[$i]['id']; ?>"
                    <? for ($j = 0; $j < count($micro_items); $j++) {
                      if ($rs_work[$i]['id'] == trim($micro_items[$j])) {
                        echo 'selected';
                      }
                    } ?>>
                    <?= $rs_work[$i]['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="d-block">Recommendation Diseases</label>
              <select class="form-control select2" multiple="multiple" name="work_item11[]">
                <?
                $rs_work = $this->item_diseases;
                $ids_data = $this->rsitem['item_other_data_item_rec_disease_ids'];
                for ($i = 0; $i < count($rs_work); $i++) {
                  $micro_items = explode(',', $ids_data);
                ?>
                  <option value="<?= $rs_work[$i]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                    if ($rs_work[$i]['id'] == trim($micro_items[$j])) { echo 'selected'; }
                  } ?>>
                    <?= $rs_work[$i]['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="d-block">Recommendation Category</label>
              <select class="form-control select2" multiple="multiple" name="work_item12[]">
                <?
                $rs_work = $this->item_category;
                $ids_data = $this->rsitem['item_other_data_item_rec_cat_ids'];
                for ($i = 0; $i < count($rs_work); $i++) {
                  $micro_items = explode(',', $ids_data);
                ?>
                  <option value="<?= $rs_work[$i]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                              if ($rs_work[$i]['id'] == trim($micro_items[$j])) {
                                                                echo 'selected';
                                                              }
                                                            } ?>>
                    <?= $rs_work[$i]['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="d-block">Other Item</label>
              <select class="form-control select2" multiple="multiple" name="work_item13[]">
                <?
                $rs_work = $this->all_items;
                $ids_data = $this->rsitem['item_other_data_other_item_ids'];
                for ($i = 0; $i < count($rs_work); $i++) {
                  $micro_items = explode(',', $ids_data);
                ?>
                  <option value="<?= $rs_work[$i]['id']; ?>" <? for ($j = 0; $j < count($micro_items); $j++) {
                                                              if ($rs_work[$i]['id'] == trim($micro_items[$j])) {
                                                                echo 'selected';
                                                              }
                                                            } ?>>
                    <?= $rs_work[$i]['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row mg-t-15">
        <div class="col-lg-12">
          <input type="hidden" name="save_btn" id="save_btn" value="Save">
          <button class="btn btn-primary" id="item_btn" onclick="update_type('Save')" type="submit">Save</button>
          <a class="btn btn-secondary" href="index.php?view=item_list">Cancel</a>
        </div>
      </div>
      </form>
      <?php include('includes/footer.php'); ?>
    </div>
    <!-- container -->
  </div>
</div>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/feather-icons/feather.min.js"></script>
<script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="lib/prismjs/prism.js"></script>
<script src="lib/parsleyjs/parsley.min.js"></script>
<script src="lib/select2/js/select2.min.js"></script>
<script>
  // Adding placeholder for search input
  (function($) {
    'use strict'
    var Defaults = $.fn.select2.amd.require('select2/defaults');
    $.extend(Defaults.defaults, {
      searchInputPlaceholder: ''
    });
    var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
    var _renderSearchDropdown = SearchDropdown.prototype.render;
    SearchDropdown.prototype.render = function(decorated) {
      // invoke parent method
      var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
      this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
      return $rendered;
    };
  })(window.jQuery);
  $(function() {
    'use strict'
    // Basic with search
    $('.select2').select2({
      placeholder: 'Choose one',
      searchInputPlaceholder: 'Search options'
    });
  });
</script>
<script src="lib/typeahead.js/typeahead.bundle.min.js"></script>
<script src="lib/handlebars/handlebars.min.js"></script>
<script src="assets/js/dashforge.aside.js"></script>
<script src="assets/js/dashforge.js"></script>
<!-- other include -->
<script src="lib/alert/js/sweet-alert.min.js"></script>
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
<script>
  $(document).on("click", ".record_delete_attribute_onclick", function() {
    var getid = $(this).data('id');
    var tableid = $(this).data('tableid');
    var tablename = $(this).data('tablename');
    if (tableid != '' && getid != '' && tablename != '') {
      swal({
        title: "Are you sure?",
        text: "You will not be able to undo after this action!",
        type: "warning",
        showCancelButton: true,
        cancelButtonClass: 'btn-primary',
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        confirmButtonClass: "confirm btn btn-lg btn-warning xyz",
        closeOnConfirm: true
      }, function(r) {
        if (r == true) {
          $.ajax({
            type: "POST",
            dataType: 'json',
            url: "scripts/ajax/index.php",
            data: "method=item&actionType=item_option_delete&tableid=" + tableid + "&getid=" + getid + "&tablename=" + tablename,
            success: function(data) {
              if (data.RESULT == 0) {
                $('.rowd_' + getid).html('');
              } else {
                swal({
                  title: "Try Again...",
                  text: data.msg,
                  type: "warning",
                  timer: 1000
                });
                return false;
              }
            }
          });
        } else {
          return false;
        }
      });
    } else {
      swal({
        title: "Try Again...",
        text: "Oops Something gone wrong...",
        type: "warning",
        timer: 1500
      });
      return false;
    }
  });

  function remove_user_row(del_id) {
    var row_id = "row_" + del_id;
    $("." + row_id).remove();
  }

  function add_attr_fields() {
    var attrmaster = $("#attrmaster").html();
    var cert_attr_master = $("#cert_attr_master").html();
    var lab_attr_master = $("#lab_attr_master").html();
    //var total_rows=$("#use_rows tr").length;
    var total_rows = $("#masterRowID").val();
    var row_id = parseInt(total_rows) + 1;
    var html_table_row = '<tr class="row_' + row_id + '">';
    html_table_row += '<td> <select class="span12 form-control" id="attr1" name="attr1[]">' + attrmaster + '</select> <input type="hidden" name="meeting_task_id[]" value=""><input type="hidden" name="master_data_id[]" value="' + row_id + '"></td>';
    html_table_row += '<td> <input type="text" id="price_' + row_id + '" name="prices[]" class="form-control numbersOnly span12"  /> </td>';
    html_table_row += '<td> <input type="text" id="mrp_' + row_id + '" name="mrps[]" class="form-control numbersOnly span12"  /></td>';
    html_table_row += '<td> <input type="text" id="sch_prices_' + row_id + '" name="sch_prices[]" class="form-control numbersOnly span12 "  /> </td>';
    html_table_row += '<td> <input type="text" id="starts_' + row_id + '" name="starts[]" class="form-control  span12  input-datepicker" autocomplete="off"  /> </td>';
    html_table_row += '<td> <input type="text" id="ends_' + row_id + '" name="ends[]" class="form-control  span12 input-datepicker" autocomplete="off"  /> </td>';
    html_table_row += '<td> <a class="btn btn-sm btn-danger" href="javascript:remove_user_row(' + row_id + ')"> <i class="icon-remove"></i>  <strong>X</strong> </a></td>';
    html_table_row += '</tr>';
    html_table_row += '<tr class="row_' + row_id + '"><td colspan="1" style="border:none"><label>Certificate  :</label></td><td colspan="5" style="border:none"><select class="form-control select2" multiple="multiple" name="work_certi_item_' + row_id + '[]" >' + cert_attr_master + '</select></td></tr>';
    html_table_row += '<tr class="row_' + row_id + '"><td colspan="1" style="border:none"><label>Choose Lab  :</label></td><td colspan="5" style="border:none"><select class="form-control select2" multiple="multiple" name="work_lab_item_' + row_id + '[]" >' + lab_attr_master + '</select></td></tr>';
    $('#use_rows tr:last').after(html_table_row);
    $("#masterRowID").val(row_id);
    $('.select2').select2({
      placeholder: 'Choose one',
    });
    jQuery(document).ready(function($) {});
    $('.input-datepicker').datepicker({
      dateFormat: 'dd-mm-yy',
    })
    $('.numbersOnly').keyup(function() {
      if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
        this.value = this.value.replace(/[^0-9\.]/g, '');
      }
    });
  }

  function update_type(a) {
    $("#save_btn").val(a);
  }

  function change_dtypes(a) {
    if (a == 'in_pkt') {
      $(".dtype").html('Pkt');
    } else if (a == 'in_pcs') {
      $(".dtype").html('Pcs');
    } else if (a == 'in_ltr') {
      $(".dtype").html('Ml');
    } else if (a == 'in_gm') {
      $(".dtype").html('Gram');
    } else {
      $(".dtype").html('Pkt');
    }
  }

  function show_suggestion(s) {
    var value = s.toLowerCase();
    $(".scrollbox .even").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }
  $(document).on("click", "#item_btn", function() {
    $('#frm_item_addedit').validate({
      rules: {
        banner: {
          required: true,
          minlength: 5,
          maxlength: 5
        },
      },
      submitHandler: function(form) {
        $('#item_btn').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
        $("#item_btn").attr("disabled", true);
        var dataString = new FormData(form);
        dataString.append('method', 'item');
        dataString.append('actionType', 'itemAddEdit');
        $.ajax({
          dataType: 'json',
          type: "POST",
          url: "scripts/ajax/index.php",
          data: dataString,
          cache: false,
          contentType: false,
          processData: false,
          success: function(responseData) {
            if (responseData.RESULT == '0') {
              form.submit();
            } else {
              $('#item_btn').html('Submit');
              $("#item_btn").attr("disabled", false);
              $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>' + responseData.msg + '</p>', {
                type: 'danger',
                delay: 3000,
                allow_dismiss: true,
                offset: {
                  from: 'top',
                  amount: 20
                }
              });
            }
          },
          error: function(responseData) {
            console.log('Ajax request not recieved!');
          }
        });
        return false;
      }
    });
  });
</script>
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<!-- ckeditor -->
<script src="lib/editor/ckeditor/ckeditor.js"></script>
<script src="lib/jqueryui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="lib/selectdropdown/jquery-ui.min.css">
<script>
  function changeTestPackageData(a) {
    $(".popPackage").hide();
    $(".popTest").hide();
    if (a == 1) {
      $(".testFileds").hide();
      $(".popPackage").show();
    } else {
      $(".testFileds").show();
      $(".popTest").show();
    }
  }

  function changeData(id) {
    if (id == 'No') {
      $(".otherFileds").hide();
    } else {
      $(".otherFileds").show();
    }
  }
  $('.input-datepicker').datepicker({
    dateFormat: 'dd-mm-yy'
  })
</script>



<script>
  $(document).ready(function () {
    $('.custom-multi-select').each(function () {
      const $dropdown = $(this);
      const $selectBox = $dropdown.find('.category-selectbox');
      const $title = $dropdown.find('.category-selectbox-title');
      const $search = $dropdown.find('.category-search-box');
      const $clear = $dropdown.find('.category-clear-search');
      const $list = $dropdown.find('.category-ul-list');
      const $placeholder = $dropdown.find('.plzselect');
      const $selectedText = $dropdown.find('.selected-text');
      const $noResults = $dropdown.find('.category-no-results');

      function updateSelectedText() {
        const $checked = $list.find('input[type="checkbox"]:checked');
        const count = $checked.length;

        if (count > 0) {
          let names = [];
          $checked.each(function (index) {
            if (index < 2) {
              names.push($(this).next('label').text().trim());
            }
          });

          let text = names.join(', ');
          if (count > 2) {
            text += ' +' + (count - 2);
          }

          if (!text) {
            text = count + ' selected';
          }

          $placeholder.hide();
          $selectedText.text(text).show();
        } else {
          $selectedText.hide().text('');
          $placeholder.show();
        }
      }

      function reorderSelectedItems() {
        const $checkedItems = $list.find('input[type="checkbox"]:checked').closest('li');
        const $uncheckedItems = $list.find('input[type="checkbox"]:not(:checked)').closest('li');
        $list.append($checkedItems).append($uncheckedItems);
      }

      function filterItems() {
        const value = $search.val().toLowerCase().trim();
        let visibleCount = 0;

        $list.find('li').each(function () {
          const text = $(this).text().toLowerCase();
          const isMatch = text.indexOf(value) > -1;
          $(this).toggle(isMatch);
          if (isMatch) visibleCount++;
        });

        $noResults.toggle(visibleCount === 0);
      }

      $title.on('click', function (e) {
        e.stopPropagation();
        $('.custom-multi-select .category-selectbox').not($selectBox).removeClass('open');
        $selectBox.toggleClass('open');

        if ($selectBox.hasClass('open')) {
          reorderSelectedItems();
          setTimeout(function () {
            $search.focus();
          }, 100);
        }
      });

      $dropdown.find('.category-selectbox-content').on('click', function (e) {
        e.stopPropagation();
      });

      $(document).on('click', function () {
        $selectBox.removeClass('open');
      });

      $clear.on('click', function () {
        $search.val('');
        filterItems();
        $search.focus();
      });

      $search.on('keyup', function () {
        filterItems();
      });

      $list.on('change', 'input[type="checkbox"]', function () {
        reorderSelectedItems();
        updateSelectedText();
        filterItems();
      });

      updateSelectedText();
      reorderSelectedItems();
    });
  });
</script>