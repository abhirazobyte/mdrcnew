<?php
$id=$app->getGetVar('id');

if($id!='')
{
	$obj_brand = $app->load_model("category");
	$result = $obj_brand->execute("SELECT", false, "", "id='".$id."'");			
	
	$id=$result[0]['id'];
	$category_name=$result[0]['category_name'];
	$category_description=$result[0]['category_description'];	
	$parentcategory_id=$result[0]['parentcategory_id'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$set_at_menu=$result[0]['set_at_menu'];

  $tag=$result[0]['tag'];

	$set_at_home=$result[0]['set_at_home'];
	$show_banner=$result[0]['show_banner'];
	
	$condition="and id!='".$id."'";
	
	$folder1='category_image';
	//Mobile
	$image=$result[0]["category_image"];
	$category_image=$app->utility->get_image_path($image,$folder1,'');
	
	
	$folder='category_icon';
	$image1=$result[0]["icon"];
	$icon=$app->utility->get_image_path($image1,$folder,'thumb');
	
	$image2=$result[0]["category_offer"];
	$category_offer=$app->utility->get_image_path($image2,$folder1,'thumb');
}
else
{
	$condition="";
	$category_image='images/img_upl.gif';
	$icon='images/img_upl.gif';	
	$category_offer='images/img_upl.gif';	
  $sort_order=$app->utility->sort_order_count('category');
}



$obj_model_brand = $app->load_model("category");
$rs = $obj_model_brand->execute("SELECT", false,"","status='Active' and parentcategory_id='0' ".$condition."","category_name ASC");
		
?>

<div class="modal fade" id="modal_category_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Category Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="category_form" id="category_form"  data-parsley-validate>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>
        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>$sort_order), "sort_order") ?>
        <div class="modal-body">
          <div class="form-row">
          
          <div class="form-group col-md-12">
              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$category_name,"required"=>""), "category_name");?>
            </div>

            

            
            <div class="form-group col-md-6">
              <label for="inputEmail4">Parent Category</label>
              <select class="form-control select2" name="parentcategory_id" id="parentcategory_id">
                <option value="">Select Category</option>
                <?php for($i=0;$i<count($rs);$i++){?>
                <option <?php if($rs[$i]['id']==$parentcategory_id){ echo 'selected';}else{ echo '';}?> value="<?=$rs[$i]['id']?>">
                <?=$rs[$i]['category_name']?>
                </option>
                <?php
					$obj_model_brand1 = $app->load_model("category");
					$rs1 = $obj_model_brand1->execute("SELECT", false,"","status='Active' and parentcategory_id='".$rs[$i]['id']."' ".$condition."","category_name ASC");
					
					 for($j=0;$j<count($rs1);$j++){?>
                <option <?php if($rs1[$j]['id']==$parentcategory_id){ echo 'selected';}else{ echo '';}?> value="<?=$rs1[$j]['id']?>">----
                <?=$rs1[$j]['category_name']?>
                </option>
                <?php }?>
                <?php }?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Tag</label>
              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$tag), "tag");?>
            </div>
            
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail4">Description</label>
              <? $app->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control ckeditor","value"=>$category_description), "category_description");?>
            </div>
          </div>
          
          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="inputEmail4">App Category Icon  (500px X 500px)</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img src="<?=$icon;?>" id="image_<?=$id?>_icon" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "icon") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                  
                   <?php if($id!='' && $image1!=''){ ?>
                       <button id="btn_<?=$id?>_icon" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','category','icon','category_icon')" type="button">Remove</button>
                      <?php }?>
                      
                      
                   </div>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label for="inputEmail4">Category Page Banner</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" > <img id="image_<?=$id?>_category_image" src="<?=$category_image;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $app->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "category_image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a>
                  
                    <?php if($id!='' && $image!=''){ ?>
                       <button id="btn_<?=$id?>_category_image" class="btn btn-xs btn-outline-danger" onclick="remove_image('<?=$id?>','category','category_image','category_image')" type="button">Remove</button>
                      <?php }?>
                      
                   </div>
              </div>
            </div>
            

            
            <div class="form-group col-md-3">
              <label for="inputEmail4">Display in Main menu </label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$set_at_menu, "values"=>array("Yes"=>"Yes","No"=>"No"),"required"=>""), "set_at_menu") ;?>
             </div>
            <div class="form-group col-md-3">
              <label for="inputEmail4">Set at Home</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$set_at_home, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "set_at_home") ;?>
            </div>
            <div class="form-group col-md-3">
              <label for="inputEmail4">Category Banner Display</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$show_banner, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "show_banner") ;?>
            </div>
             
            <div class="form-group col-md-3">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn category_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
