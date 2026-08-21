<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit video_gallery
	$obj_video_gallery = $app->load_model("video_gallery_category");
	$result = $obj_video_gallery->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
  

  $obj_video_gallery_link = $app->load_model("video_gallery");
  $rs_tab_data = $obj_video_gallery_link->execute("SELECT", false, "", "category_id='".$id."'"); 
}

?>

<div class="modal fade" id="modal_video_gallery_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Video Gallery Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="video_gallery_form" id="video_gallery_form"  data-parsley-validate>
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
              <label for="inputEmail4">Sort Order</label>
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('video_gallery_category'),"required"=>""), "sort_order") ;?>
           </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>

 <div class="row">
          <div class="col-md-12">

                <table class="table table-condensed">

                  <thead>

                    <tr>

                      <th>Link <span class="tx-danger">*</span></th>

                      <th >Status </th>

                      <th >Sort Order </th>
                    
                      <th>&nbsp;</th>

                    </tr>

                  </thead>

                  
                  <tbody id="use_rows">

              <?php

             for($i=0;$i<count($rs_tab_data);$i++)

             {

               $pa=$rs_tab_data[$i];

               $link=$pa["video_link"];

               $status=$pa["status"];

               $sort_order=$pa["sort_order"];


               $table_id=$pa["id"];

               

                ?>

                    <tr class="rowd_<?=$table_id?>">

                    <input type="hidden" name="cat_id" value="<?=$app->getGetVar('id')?>">

                      <input type="hidden" name="ids[]" value="<?=$pa["id"]?>">


                        <td width="60%"><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control required","id"=>"links_1","name"=>"links[]","value"=>$link),"") ?></td>

                      <td><? $app->htmlBuilder->buildTag("select", array("class"=>"form-control span12","id"=>"status_1","values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"selected"=>$status,"required"=>"","name"=>"status[]"), "") ;?></td>

                      <td width="15%"><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"sort_orders_1","name"=>"sort_orders[]","value"=>$sort_order), "") ?></td>


                      <td><a style="color:#fff" class="btn btn-xs btn-danger record_delete_attribute_onclick"  data-id="<?=$pa['id'];?>" data-tableid="<?=$pa['id'];?>" data-tablename="product_option"  rel="tooltip" title="Delete"> <i class="fa fa-trash"></i></a></td>

                    </tr>

                    <?php } ?>

                    <tr>
                    <input type="hidden" name="ids[]" value="0" />

                    <input type="hidden" name="cat_id" value="<?=$app->getGetVar('id')?>">

                      <td width="60%"><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control required","id"=>"links_1","name"=>"links[]","value"=>""),"") ?></td>

                      <td><? $app->htmlBuilder->buildTag("select", array("class"=>"form-control span12","id"=>"status_1","values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>"","name"=>"status[]"), "") ;?></td>

                      <td width="15%"><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"sort_orders_1","name"=>"sort_orders[]"), "") ?></td>
                

                      <td></td>

                      <td>&nbsp;</td>

                    </tr>

                  </tbody>

 
                </table>
                <div class="padding-7" style="text-align:right;"> <a class="btn btn-sm btn-success" href="javascript:add_attr_fields();"> <i class="icon-plus "></i> <strong>+ </strong></a></div>
              </div>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn video_gallery_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>




<script>

function add_attr_fields()

{

  var tabname_rows=$("#tabname_1").html();

  var tabqty_rows=$("#tabqty_1").html();

  var tabmember=$("#tabsq").html();

  var total_rows=$("#use_rows tr").length;

  var row_id=parseInt(total_rows)+1;

  var html_table_row='<tr id="row_'+row_id+'">';

  html_table_row+='<input type="hidden" name="ids[]" value="0">';

  html_table_row+='<input type="hidden"id="cat_id" name="cat_id" value="<?=$app->getGetVar('id')?>" />';  

  

  html_table_row+='<td> <input type="text"id="links_'+row_id+'" name="links[]" class="span12 form-control required"  /> </td>';

  html_table_row+='<td> <select class="form-control span12" id="status_'+row_id+'" name="status[]"><option value="Active">Active</option><option value="Inactive">Inactive</option></select> </td>';

  

  html_table_row+='<td> <input type="text"id="sort_orders_'+row_id+'" name="sort_orders[]" class="form-control span12 numbers"  /></td>';

  

  html_table_row+='<td> <a class="btn btn-sm btn-danger" href="javascript:remove_user_row('+row_id+')"> <i class="icon-remove"></i>  <strong>X</strong> </a></td>';

  html_table_row+='</tr>';

  $('#use_rows tr:last').after(html_table_row);

    jQuery(document).ready(function($) {

  });

  

  $("input.numbers").keypress(function(event) {

  return /\d/.test(String.fromCharCode(event.keyCode));

});

  

  
  

   $('.numbersOnly').keyup(function ()

{

    if (this.value != this.value.replace(/[^0-9\.]/g, ''))

  {

       this.value = this.value.replace(/[^0-9\.]/g, '');

    }

});

  

  
   remove_error_class();

   
}





function remove_user_row(del_id)

  {

  var row_id="row_"+del_id;

  $("#"+row_id).remove();

  get_total();

    }


</script> 

