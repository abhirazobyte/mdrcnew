<?php
$id=$app->getGetVar('id');
if($id!='')
{
	//Edit filter_master
	$obj_filter_master = $app->load_model("filter_master");
	$result = $obj_filter_master->execute("SELECT", false, "", "id='".$id."'");			
	
	$name=$result[0]['name'];
	$sort_order=$result[0]['sort_order'];
	$status=$result[0]['status'];
	$slug=$result[0]['slug'];
	
	$folder='filter_master';
	//image
	$image=$result[0]["image"];

	$filter_master_img1=$app->utility->get_image_path($image,$folder,"");
	$filter_master_img=$filter_master_img1['large_image'];
}
else
{
	//Add filter_master
	$filter_master_img='images/img_upl.gif';	
}






$obj_model_catalogue_price_data= $app->load_model("filter_master_values");
$rs_tab_data = $obj_model_catalogue_price_data->execute("SELECT",false,"","filter_master_id='".$id."'");


?>

<div class="modal fade" id="modal_filter_master_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Filter Form</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="filter_master_form" id="filter_master_form"  data-parsley-validate>
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
           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('filter_master'),"required"=>""), "sort_order") ;?>
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Status</label>
              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>
            </div>
          </div>
          
          
          
          <div class="form-row">
            <div class="col-md-12">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th  >Value <span class="tx-danger">*</span></th>
                    <th  >Sort Order </th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody id="use_rows">
                  <?php
		 for($i=0;$i<count($rs_tab_data);$i++)
		 {
			 $pa=$rs_tab_data[$i];
			 $final_price=$pa["master_name"];
			 $points=$pa["master_sort_order"];
			 
			
			
				  $display_none="";
			
			
			 $table_id=$pa["id"];
			 
			 
			  ?>
                  <tr class="rowd_<?=$table_id?>">
                    <input type="hidden" name="catalogue_id" value="<?=$app->getGetVar('id')?>">
                    <input type="hidden" name="table_id[]" value="<?=$pa["id"]?>">
                    
                    <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control ","required"=>"","id"=>"final_price_p_1","name"=>"final_price_p[]","value"=>$final_price), "") ?></td>
                    
                    <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers number","id"=>"points_p_1","name"=>"points_p[]","value"=>$points), "") ?></td>
   
                    <td><a style="color:#fff;<?=$display_none?>" class="btn btn-xs btn-danger record_delete_attribute_onclick"  data-id="<?=$pa['id'];?>" data-tableid="<?=$pa['id'];?>" data-tablename="product_option"  rel="tooltip" title="Delete"> <i class="fa fa-trash"></i></a></td>
                  </tr>
                  <?php } ?>
              <?php if(count($rs_tab_data)==0){?>    
                  <tr>
                    <input type="hidden" name="table_id[]" value="0" />
                    <input type="hidden" name="catalogue_id" value="<?=$app->getGetVar('id')?>">
                    
                    <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control","required"=>"","id"=>"final_price_p_1","name"=>"final_price_p[]","value"=>""), "") ?></td>
                    
                    <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"points_p_1","name"=>"points_p[]"), "") ?></td>
                    
                    <td></td>
                    <td>&nbsp;</td>
                  </tr>
               <?php }?> 
                </tbody>
              </table>
              <div class="padding-7" style="text-align:right;"> <a class="btn btn-sm btn-success" href="javascript:add_attr_fields();"> <i class="icon-plus "></i> <strong>+ </strong></a></div>
            </div>
          </div>
          

        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn filter_master_modal_submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function show_suggestion(s)
 {
    var value = s.toLowerCase();
    $(".scrollbox .even").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }
	 </script> 
<script>
function add_attr_fields()
{
	var tabname_rows=$("#tabname_1").html();
	var tabqty_rows=$("#tabqty_1").html();
	var tabmember=$("#tabsq").html();
	var total_rows=$("#use_rows tr").length;
	var row_id=parseInt(total_rows)+1;
	var html_table_row='<tr id="row_'+row_id+'">';
	html_table_row+='<input type="hidden" name="table_id[]" value="0">';
	html_table_row+='<input type="hidden"id="catalogue_id" name="catalogue_id" value="<?=$app->getGetVar('id')?>" />';
	html_table_row+='<td> <input type="text"id="final_price_p_'+row_id+'" name="final_price_p[]" class="span12 form-control required"  /> </td>';
	html_table_row+='<td> <input type="text"id="points_p_'+row_id+'" name="points_p[]" class="form-control span12 numbers number"  /> </td>';
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
	function remove_user_row1(del_id)
	{
	var row_id="row_"+del_id;
	$("#"+row_id).remove();
	 get_total();
    }
</script> 
