<?php
$id=$app->getGetVar('id');

$obj_model_product = $app->load_model("product");
$rs_product = $obj_model_product->execute("SELECT",false,"","id=".$id);


$product_unit=$rs_product[0]['product_unit'];
if($product_unit=='in_gm')
				{
					$type="Gram";
					
				}
				else if($product_unit=='in_ltr')
				{
					$type="Ml";
					
				}
				else if($product_unit=='in_pcs')
				{
					$type="Pcs";
					
				}
				else if($product_unit=='in_pkt')
				{
					$type="Pkt";
					
				}
				else
				{
					$type="";
					
				}

if($id!='')
{
	$obj_model_product_option = $app->load_model("product_price");
	$rs_tab_data = $obj_model_product_option->execute("SELECT",false,"","product_id=".$id);
}

?>

<div class="modal fade" id="modal_price_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg11 modal-xl" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Product Price - <strong><?=$rs_product[0]['product_name']?> (<?=$rs_product[0]['caption']?>)</strong></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form method="post" name="product_price_form" id="product_price_form"  data-parsley-validate>
        <div class="modal-body">

		<div data-label="" class="df-example demo-forms">
            <div class="form-group" id="price_varient">
              <div class="col-md-12">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                     <th  width="15%">Weight (In <?=$type?>) <span class="tx-danger">*</span></th>
                      <th  >Price <span class="tx-danger">*</span></th>
                      <th  >Mrp </th>
                       <th >Max Quantity</th>
                    
                    
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  
                  <tbody id="use_rows">
        <?php
		 for($i=0;$i<count($rs_tab_data);$i++)
		 {
			 $pa=$rs_tab_data[$i];
			
			
			 $mrp=$pa["mrp"];
			 $price=$pa["price"];
			 
			 
			 $d_weight=$pa["weight"];
			 $max_quantity=$pa["max_quantity"];
			 
			 
			 $mrp=str_replace(".00","",$mrp);
			 $price=str_replace(".00","",$price);
			 $d_weight=str_replace(".00","",$d_weight);
			  
			  
			 $table_id=$pa["id"];
			 
			 
			 
			  ?>
                    <tr class="rowd_<?=$table_id?>">
                    <input type="hidden" name="product_id" value="<?=$app->getGetVar('id')?>">
                      <input type="hidden" name="id[]" value="<?=$pa["id"]?>">
                      
                       <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control required numbers","id"=>"rweights_1","name"=>"rweights[]","value"=>$d_weight), "") ?></td>
                       <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers required number","id"=>"rprice_1","name"=>"rprices[]","value"=>$price), "") ?></td>
                      
					   
                      <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"mrp_1","name"=>"mrps[]","value"=>$mrp), "") ?></td>
                        
                      
                      
                       <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"max_quantity_1","name"=>"max_quantitys[]","value"=>$max_quantity), "") ?></td>
                        
                    
                    
                      <td><a style="color:#fff" class="btn btn-xs btn-danger record_delete_attribute_onclick"  data-id="<?=$pa['id'];?>" data-tableid="<?=$pa['id'];?>" data-tablename="product_option"  rel="tooltip" title="Delete"> <i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php } ?>
                    <tr>
                    <input type="hidden" name="id[]" value="0" />
                    <input type="hidden" name="product_id" value="<?=$app->getGetVar('id')?>">
                     <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"Pcs"), "weight_type") ?>
                     
                      <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control required numbers","id"=>"rweights_1","name"=>"rweights[]","value"=>""), "") ?></td>
                        <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"rprice_1","name"=>"rprices[]"), "") ?></td>
                      <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"mrp_1","name"=>"mrps[]"), "") ?></td>
                    
                        <td><? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"span12 form-control numbers","id"=>"max_quantity_1","name"=>"max_quantitys[]","value"=>""), "") ?></td>
                       
                       
                        
                        
                      <td></td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                  
                  
                </table>
                <div class="padding-7" style="text-align:right;"> <a class="btn btn-sm btn-success" href="javascript:add_attr_fields();"> <i class="icon-plus "></i> <strong>+ </strong></a></div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary tx-13 submit_btn product_price_modal_submit">Submit</button>
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
	html_table_row+='<input type="hidden" name="id[]" value="0">';
	html_table_row+='<input type="hidden" name="weight_type[]" value="Pcs">';
	html_table_row+='<input type="hidden"id="product_id" name="product_id" value="<?=$app->getGetVar('id')?>" />';	
	
	html_table_row+='<td> <input type="text"id="rweights_'+row_id+'" name="rweights[]" class="span12 form-control required numbers"  /> </td>';
	
	html_table_row+='<td> <input type="text"id="rprice_'+row_id+'" name="rprices[]" class="form-control span12 numbers required number"  /> </td>';
	
	
	
	html_table_row+='<td> <input type="text"id="mrp_'+row_id+'" name="mrps[]" class="form-control span12 numbers"  /></td>';
	


	html_table_row+='<td> <input type="text"id="max_quantity_'+row_id+'" name="max_quantitys[]" class="form-control numbers"  /> </td>';
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
