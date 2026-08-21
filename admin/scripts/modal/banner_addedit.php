<?php

$id = $app->getGetVar('id');


if ($id != '') 
{
  $obj_brand = $app->load_model("banner");
  $result = $obj_brand->execute("SELECT", false, "", "id='" . $id . "'");
  $show_page = $result[0]['show_page'];
  $link = $result[0]['link'];
  $sort_id = $result[0]['sort_id'];
  $city_ids = $result[0]['city_ids'];
  $banner_link = $result[0]['banner_link'];
  $status = $result[0]['status'];
  $name = $result[0]['name'];
  $folder = 'main_banner_images';
  $image = $result[0]["banner_image"];
  $banner_img = $app->utility->get_image_path($image, $folder, 'large');
  $img_name = $result[0]["mobile_image"];
  $log_img = $app->utility->get_image_path($img_name, $folder, 'large');
} else {
  //Add Banner
  $log_img = 'images/img_upl.gif';
  $banner_img = 'images/img_upl.gif';
}

$obj_model_tble = $app->load_model("city");
$rs_work = $obj_model_tble->execute("SELECT", false, "", "city.status='Active'", "city.sort_order ASC");

$obj_model_tble = $app->load_model("item_category");
$rs_category = $obj_model_tble->execute("SELECT", false, "", "item_category.status='Active'", "item_category.sort_order ASC");

$displayOptions = ['home' => 'Home Main Banner', 'home_radiology' => 'Home - Radiology section Banners', 'home_pathology' => 'Home - Pathology section Banners', 'radiology' => 'Radiology Department', 'pathology' => 'Pathology Department', 'premium' => 'Premium (FBC) Banner', 'diseases' => 'Health Risk Banner', 'category' => 'Health Categories Banner', 'radiology_item' => 'Items Banner- Radiology', 'pathology_item' => 'Items Banner- Pathology'];

$micro_items = explode(',', $city_ids??'');
$show_page = explode(',', $show_page??'');
?>
<style>
  /*select style*/
  .selectwrap {
    position: relative;
    float: left;
    width: 100%;
  }

  .selectwrap:after {
    content: "";
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    text-align: center;
    line-height: 36px;
    position: absolute;
    width: 26px;
    height: 36px;
    background: white;
    right: 1px;
    top: 1px;
    pointer-events: none;
  }

  /***** CUSTOM CHECKBOX STYLES *****/
  .custom-checkbox-label .checkbox-pad {
    padding-top: 7px;
  }

  .custom-checkbox label {
    font-weight: normal;
  }

  .checkbox-custom {
    opacity: 0;
    position: absolute;
    display: inline-block;
    vertical-align: middle;
    margin: 0px;
    cursor: pointer;
  }

  .checkbox-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 0px;
    cursor: pointer;
    position: relative;
  }

  .checkbox-custom+.checkbox-custom-label:before {
    content: "";
    background: white;
    display: inline-block;
    vertical-align: middle;
    width: 18px;
    height: 18px;
    padding: 0px;
    text-align: center;
    border: 1px solid #000;
    border-radius: 0px;
    margin-bottom: 4px;
    margin-right: 10px;
  }

  .checkbox-custom:checked+.checkbox-custom-label:before {
    content: "\2713";
    /* Unicode for checkmark */
    font-family: "FontAwesome";
    color: #000;
    font-size: 12px;
    font-weight: 100;
    line-height: 5px;
    padding-top: 6px;
  }

  .checkbox-custom:focus+.checkbox-custom-label {
    outline: 0px solid #dddddd;
  }

  .selectbox-content {
    display: none;
    position: absolute;
    z-index: 999;
    background: #fff;
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px;
  }

  .selectbox.open .selectbox-content {
    display: block;
  }

  .check-30 {
    width: 30px;
    height: 30px;
  }

  .form-check-input:checked {
    background-color: var(--theme-color);
    border-color: var(--theme-color);
    box-shadow: none;
  }

  .form-check-input:focus {
    box-shadow: none;
  }
  .selectbox {
    width: 100%;
    display: inline-block;
}

.selectbox-title.form-control {
    padding-left: 16px;
}

.selectbox-content {
    border: 1px solid #d5d5d5;
    max-height: 205px;
    overflow: auto;
    display: none;
    border-top: none;
    position: absolute;
    z-index: 99;
    background: white;
    width: 100%;
}

.selectbox-content ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
    cursor: pointer;
    position: relative;
}

.selectbox-content ul li {
    padding-top: 10px;
    width: 100%;
    display: inline-block;
}

.selectbox-content ul li:last-child {
    border-bottom: none;
}

.selectbox-content ul li:first-child {
    border-top: none;
}

.selectbox-content .input-group {
    padding: 5px;
}

.loadbutton {
    padding: 10px;
}

.loadbutton .btn-primary {
    padding-top: 8px;
    padding-bottom: 8px;
}

.ul-list label {
    padding-left: 20px;
}

#box {
    height: 40px;
}
.input-group-addon {
    border-radius: 0;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: normal;
    line-height: 1;
    color: #091d3a;
    background-color: #e6e6e6;
    border: 1px solid #d5d5d5;
    display: flex;
    align-items: center;
}
</style>
<div class="modal fade" id="modal_banner_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Banner Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="banner_form" id="banner_form" data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "form-control", "value" => $id), "id") ?>
        <div class="modal-body">
          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="inputEmail4">Display</label>
              <div class="form-group clearfix">
                <div class="selectbox selectwrap">
                  <div class="selectbox-title form-control">
                    <span class="plzselect">Please Select</span>
                    <span class="selected">selected</span>
                  </div>
                  <div class="selectbox-content">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                      <input class="form-control search-box" type="text" placeholder="Search" data-target="features-list">
                      <span class="input-group-btn">
                        <button class="btn btn-default clear-search" type="button"><i class="fa fa-close"></i></button>
                      </span>
                    </div>
                    <ul class="ul-list" id="features-list">

                      <?php 
                        foreach ($displayOptions as $id => $name) { ?>
                          <li>
                            <input class="checkbox-custom" name="display[]" type="checkbox" id="feature_<?= $id ?>" value="<?= $id ?>"
                              <?php if (is_array($show_page) && in_array($id, $show_page)): ?>checked<?php endif; ?>>
                            <label for="feature_<?= $id ?>" class="checkbox-custom-label checkbox"><?= $name ?></label>
                          </li>
                        <?php }
                      ?>
                      <?php 
                        foreach ($rs_category as $category) { 
                        ?>

                          <li>
                            <input class="checkbox-custom" name="display[]" type="checkbox" id="feature1_<?= $category['id'] ?>" value="<?= $category['slug'] ?>"
                              <?php if (is_array($show_page) && in_array($category['slug'], $show_page)): ?>checked<?php endif; ?>>
                            <label for="feature1_<?= $category['id'] ?>" class="checkbox-custom-label checkbox"><?= $category['name'] ?></label>
                          </li>
                        <?php }
                     ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label for="inputEmail4">City</label>
              <div class="form-group clearfix">
                <div class="selectbox selectwrap">
                  <div class="selectbox-title form-control">
                    <span class="plzselect">Please Select</span>
                    <span class="selected">selected</span>
                  </div>
                  <div class="selectbox-content">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                      <input class="form-control search-box" type="text" placeholder="Search" data-target="city-list">
                      <span class="input-group-btn">
                        <button class="btn btn-default clear-search" type="button"><i class="fa fa-close"></i></button>
                      </span>
                    </div>
                    <ul class="ul-list" id="city-list">

                      <?php if (count($rs_work) > 0) {
                        
                        for ($i = 0; $i < count($rs_work); $i++) { ?>

                          <li>
                            <input class="checkbox-custom" name="work_item[]" type="checkbox" id="city_<?= $rs_work[$i]['id'] ?>" value="<?= $rs_work[$i]['id'] ?>"
                              <?php if (is_array($micro_items) && in_array($rs_work[$i]['id'], $micro_items)): ?>checked<?php endif; ?>>
                            <label for="city_<?= $rs_work[$i]['id'] ?>" class="checkbox-custom-label checkbox"><?= $rs_work[$i]['name'] ?></label>
                          </li>
                        <?php }
                      } else { ?>
                        <li>No feature tags available</li>
                      <?php } ?>

                    </ul>
                  </div>
                </div>
              </div>
              <span style="font-size: 12px;">Make Blank for All city.</span>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Web Banner Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new"> <img src="<?= $banner_img; ?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "banner_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">App Banner Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new"> <img src="<?= $log_img; ?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    <? $app->htmlBuilder->buildTag("input", array("type" => "file", "class" => ""), "mobile_banner") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label for="inputEmail4">Link</label>
              <? $app->htmlBuilder->buildTag("input", array("type" => "text", "class" => "form-control", "value" => $banner_link), "banner_link") ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Sort Id</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control ", "selected" => $sort_id, "values" => $app->utility->sort_order('banner'), "required" => ""), "sort_id"); ?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class" => "form-control", "selected" => $status, "values" => array("Active" => "Active", "Inactive" => "Inactive"), "required" => ""), "status"); ?>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn banner_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).on("click", ".selectbox-title", function () {
        $(this).siblings(".selectbox-content").slideToggle("fast");
    });

    // Filter options in list
    $(document).on("keyup", ".search-box", function () {
        var valThis = $(this).val().toLowerCase();
        var targetListId = $(this).data("target"); // e.g., 'features-list'
        $("#" + targetListId + " > li").each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(valThis) >= 0);
        });
    });

    // Clear search input
    $(document).on("click", ".clear-search", function () {
        var $input = $(this).closest('.input-group').find('.search-box');
        $input.val("").keyup();
    });


    $(document).on("change", '.ul-list input[type="checkbox"]', function () {
        // Get the closest filter block (individual column)
        var filterBlock = $(this).closest('.product-filters-block');

        // Count checked checkboxes in this block only
        var countChecked = filterBlock.find('.ul-list input[type="checkbox"]:checked').length;

        // Find elements within this specific block
        var plzselect = filterBlock.find('.plzselect');
        var selected = filterBlock.find('.selected');

        if (countChecked > 0) {
            plzselect.hide();
            selected.text(countChecked + " selected").show();
        } else {
            plzselect.show();
            selected.hide();
        }
    });

    $(document).ready(function () {
        $('.product-filters-block').each(function () {
            var filterBlock = $(this);
            var countChecked = filterBlock.find('.ul-list input[type="checkbox"]:checked').length;
            var plzselect = filterBlock.find('.plzselect');
            var selected = filterBlock.find('.selected');

            if (countChecked > 0) {
                plzselect.hide();
                selected.text(countChecked + " selected").show();
            } else {
                plzselect.show();
                selected.hide();
            }
        });
    });
  $(document).ready(function () {

  
    $('.selectbox-title').on('click', function (e) {
        e.stopPropagation();
        $('.selectbox').not($(this).closest('.selectbox')).removeClass('open');
        $(this).closest('.selectbox').toggleClass('open');

        const listId = $(this).closest('.selectbox').find('.ul-list').attr('id');
        reorderSelectedTags('#' + listId);
    });

    $(document).on('click', function () {
        $('.selectbox').removeClass('open');
    });

    $('.selectbox-content').on('click', function (e) {
        e.stopPropagation();
    });

  
    function reorderSelectedTags(listSelector) {
        const $list = $(listSelector);
        if (!$list.length) return;

        const $checked = $list.find('input[type="checkbox"]:checked').closest('li');
        const $unchecked = $list.find('input[type="checkbox"]:not(:checked)').closest('li');

        $list.html('').append($checked).append($unchecked);
    }

    updateSelectBoxTitle('features-list');
    updateSelectBoxTitle('city-list');
    
    $(document).on('change', '.selectbox-content input[type="checkbox"]', function () {
        const $list = $(this).closest('.ul-list');
        reorderSelectedTags('#' + $list.attr('id'));
    });

    function updateSelectBoxTitle(listId) {
        const checkedCount = $('#' + listId + ' input[type="checkbox"]:checked').length;
        const titleBox = $('#' + listId).closest('.selectbox').find('.selectbox-title');

        if (checkedCount > 0) {
            titleBox.find('.plzselect').hide();
            titleBox.find('.selected')
                .text(checkedCount + ' selected')
                .show();
        } else {
            titleBox.find('.selected').hide();
            titleBox.find('.plzselect').show();
        }
    }

    $(document).on('change', '.ul-list input[type="checkbox"]', function () {
        const listId = $(this).closest('.ul-list').attr('id');
        updateSelectBoxTitle(listId);
    });
});
</script>