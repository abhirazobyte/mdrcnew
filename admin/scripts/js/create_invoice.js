

	 $( function() {
        $( "#p_type" ).autocomplete({
            source: function( request, response ) {
				
				var vendor_id=$("#vendor_id").val();
				
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=sales_product_suggession&queryString='+request.term+"&vendor_id="+vendor_id,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                $('#p_type').val(''); // display the selected text
				
				
				 addproduct_to_table(ui.item.value,$('#customer_id').val(),ui.item.product_id);
				//  fill_data(ui.item.value);
				  // save selected id to input
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li><div><img src='"+item.img+"'><span>"+item.label+"</span></div></li>" ).appendTo( ul );
      };
    });
	
		

    

	function addproduct_to_table(product_price_id,cust_id,product_id)

	{
		
		
		//alert(product_price_id);

		
		var product_id=product_price_id;

		$.ajax(

		{



			type: "POST",

			dataType: 'json',

			url: "scripts/ajax/index.php",

			data: "method=get_product_detail_order2022&product_price_id="+product_price_id+'&cust_id='+cust_id+'&product_id='+product_id,



			success: function(data){

					if(data.RESULT=='OK')

					{

				

				var total_rows=$("#p_rows tr:first").attr("data-id"); 	

				

				if(total_rows==undefined)

				{

					 total_rows=0; 	

				}

				else

				{

					total_rows=$("#p_rows tr:first").attr("data-id"); 	

				}

				

				//alert(total_rows);

				

				var row_id=parseInt(total_rows)+1;	

				var html_table_row='<tr height="40" class="a_rows prorow_'+row_id+'" id="prorow_'+row_id+'" data-id="'+row_id+'">';

                   

				   

				      html_table_row+=' <td align="center" valign="middle" class="pro_image" width="10%"><img src="'+data.product_image+'" width="120" style="padding:10px; width:90px; max-height:140px;" /></td>';

				   

				   

				    html_table_row+='<td align="center" valign="middle" class="pro_name" width="10%"><input type="hidden" class="populated" value="'+data.product_name+'" id="product_names_'+row_id+'" name="product_names[]" /><input type="hidden" class="populated" value="" id="table_ids_'+row_id+'" name="table_ids[]" />'+data.product_name+'<br/> <strong> SKU : </strong>'+data.sku_code+'<br/>'+data.others_opt+'</td>';

             



			 

			 
			 
				

					html_table_row+='<td align="center" class="pro_final_price" width="10%"><input type="text" class="populated1 form-control numbersOnly" value="'+data.product_new_price+'" id="price_main_'+row_id+'" name="prices_main[]" onkeyup="get_price('+row_id+','+product_id+');"  /></td>';

					

					

					

					

					html_table_row+='<td align="center" class="pro_dis_price" width="5%" style="display:none"><input type="text" id="price_discount_'+row_id+'" name="price_discount[]" class="form-control numbersOnly" onkeyup="get_price('+row_id+','+product_id+');" value="0">%</td>';

					

					

					html_table_row+='<td align="center" class="pro_unit_price" width="10%" style="display:none"><input type="text" readonly="readonly" class="populated1 form-control numbersOnly" value="'+data.product_new_price+'" id="price_'+row_id+'" name="prices[]" onkeyup="get_price('+row_id+','+product_id+');"  /></td>';

					

					

					

			  

			  

			  html_table_row+='<td align="center"  class="pro_quantity" width="5%"><input type="text" class="populated1 form-control numbers" value="1" id="quantities_'+row_id+'" name="quantities[]" onkeyup="get_price('+row_id+','+product_id+');"  /></td>';

					 

			  

			    

				

			
					

					

					  html_table_row+='<td align="center"  class="pro_total_price" width="15%"><input type="text" class="populated_total form-control" value="'+data.product_unit_cost+'"  onblur="get_total();" id="unit_cost_prices_'+row_id+'" name="unit_cost_prices[]" readonly /></td>';

					  

                    html_table_row+='<td align="center" width="5%"><input type="hidden" class="populated" value="'+data.product_id+'" id="product_ids_'+row_id+'" name="product_ids[]" /><input type="hidden" class="populated" value="" id="data_ids_'+row_id+'" name="dataID[]" /><input type="hidden" class="populated" value="'+data.product_price_id+'" id="product_price_ids_'+row_id+'" name="product_price_ids[]" /><input type="hidden" class="populated" value="'+data.product_info_1+'" id="product_price_ids_'+row_id+'" name="product_info_1[]" /><input type="hidden" class="populated" value="'+data.product_info_2+'" id="product_price_ids_'+row_id+'" name="product_info_2[]" /><input type="hidden" class="populated" value="'+data.product_info_3+'" id="product_price_ids_'+row_id+'" name="product_info_3[]" /><input type="hidden" class="populated" value="'+data.product_attribute_1+'" id="product_price_ids_'+row_id+'" name="product_attribute_1[]" /><input type="hidden" class="populated" value="'+data.product_attribute_2+'" id="product_price_ids_'+row_id+'" name="product_attribute_2[]" /><input type="hidden" class="populated" value="'+data.product_attribute_3+'" id="product_price_ids_'+row_id+'" name="product_attribute_3[]" /><strong><a href="javascript:onclick=delete_row('+row_id+')";"  class="remove_row" id="delete_'+row_id+'"><i class="fa fa-trash" style=""></i></strong></td>';

                    html_table_row+='</tr>';

					

					

					

					if(total_rows==0)

					{

					$('#p_rows').html(html_table_row);	

					}

					else

					{

					$('#p_rows tr:first').before(html_table_row);	

					}





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

					
					

					$("#p_type").val('');

					

					get_total();

					

					}

			}

		}

	);	

	}

	

	function delete_row(del_id)

	{

			//var arr=del_id.split('_');

			var row_id="prorow_"+del_id;

			$("."+row_id).hide("slow", function(){$(this).remove();get_total();})

			

      

    }

	function get_total()

	{



		var p_type=$("#invoice_payment_type").val();
		
		
		var total_ship_amount=$("#shipcharge").val();
		
		var total_wallet_amount=$("#wallettotal").val();
		var dis_amount=$("#dis_amount").val();
		
		
		if(total_wallet_amount==''){total_wallet_amount=0;}
		if(total_ship_amount==''){total_ship_amount=0;}
		if(dis_amount==''){dis_amount=0;}
		
		
		

		var cnt=$("tr.a_rows").length;

		var qty=0;

		var price=0;

		var row_id=0;

		var price_total=0;

		var area=0;

		var express=0;

		var cod=0;

		

		var dis=0;

		

		var gst_total=0;

		

		var vat=15.00;

		for(i=0;i<cnt;i++)

		{

			var qty=$("tr.a_rows td.pro_quantity").children('input').eq(i).val();

			var unit_cost=$("tr.a_rows td.pro_total_price").children('input').eq(i).val();

			
			

			

			price_total+=parseFloat(unit_cost);	

		}

		

		//area ship charge

		
		

		

		var ordertotal=parseFloat(price_total).toFixed(2);
		$("#subtotal_amount").html('<i class="fas fa-rupee-sign"></i> '+ordertotal);
		$("#subtotal").val(ordertotal);

		



		

		var grandtotal=parseFloat(ordertotal) + parseFloat(total_ship_amount) - parseFloat(dis_amount) - parseFloat(total_wallet_amount);

		

		

		var grandtotal=parseFloat(grandtotal).toFixed(2);

		

		

		$("#total_amount").html('<i class="fas fa-rupee-sign"></i> '+grandtotal);

		$("#totalamount").val(grandtotal);
		
		
		
		
		
		

		

		

		

		

	}

	

	

	

	function get_price(row_id,product_id)

	{

		
		
		

		
		
		var in_qty=$("#quantities_"+row_id).val();


		var in_price=$("#price_main_"+row_id).val();



		

		

		var total1=parseFloat(in_qty)*parseFloat(in_price);
		
		var total=parseFloat(total1).toFixed(2);

		



		

		

		

		$("#unit_cost_prices_"+row_id).val(total);	

		

		

		get_total();

		

	

	

		

		

		

  

	}

	

	

	



	



