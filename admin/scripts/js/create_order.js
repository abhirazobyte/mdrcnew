// JavaScript Document



function show_all_products()
{

			

			  $.ajax({

type: "POST",

url: "../scripts/ajax/index.php",

data:'method=show_all_products_suggessions',

dataType:'json',

success: function(data){



$('#suggestions').html('<p id="searchresults">'+data.SUGG+'</p>'); // Fill the suggestions box



 if($('#suggestions').is(':hidden'))

 {

	 $('#suggestions').show(); 

	 $('#imdropping_list i').removeClass("icon-chevron-down");

	 $('#imdropping_list i').addClass("icon-chevron-up");

		if($('#searchresults').height()>150)

		{

			$('#searchresults').css('overflow-y', 'scroll');

			$('#searchresults').css('height', '150px');

			$('#searchresults').css('overflow-x', 'hidden');

		}



 }

 else

 {

	 $('#suggestions').hide(); 

	 $('#imdropping_list i').addClass("icon-chevron-down");

	$('#imdropping_list i').removeClass("icon-chevron-up");

 }

}

});

		}

		jQuery(document).ready(function($) {

          jQuery("#pp").click(function() {

			  

			  $.ajax({

type: "POST",

url: "../scripts/ajax/index.php",

data:'method=show_all_products_suggessions',

dataType:'json',

success: function(data){

 // Show the suggestions box

$('#suggestions').html('<p id="searchresults">'+data.SUGG+'</p>'); // Fill the suggestions box



 if($('#suggestions').is(':hidden'))

 {

	 $('#suggestions').show(); 

	 $('#imdropping_list i').removeClass("icon-chevron-down");

$('#imdropping_list i').addClass("icon-chevron-up");

if($('#searchresults').height()>150)

{

	$('#searchresults').css('overflow-y', 'scroll');

	$('#searchresults').css('height', '150px');

	$('#searchresults').css('overflow-x', 'hidden');

	

	

}

 }

 else

 {

	 $('#suggestions').hide(); 

	 $('#imdropping_list i').addClass("icon-chevron-down");

$('#imdropping_list i').removeClass("icon-chevron-up");

 }



			

}

});

           

        });

		

		 jQuery("body").click(function() {

			  

		if($('#suggestions').is(':visible'))

		{

			$('#suggestions').hide();

			$('#imdropping_list i').removeClass("icon-chevron-up");

			$('#imdropping_list i').addClass("icon-chevron-down");



		}

        });

		 });

		

		function lookup_product(inputString) {

	if(inputString.length == 0) {

		$('#suggestions').fadeOut(); // Hide the suggestions box

		$('#imdropping_list i').removeClass("icon-chevron-up");

			$('#imdropping_list i').addClass("icon-chevron-down");

	} else {

		

		

		var cust_id=$("#customer_id").val(); 

		

	



$.ajax({

type: "POST",

url: "../scripts/ajax/index.php",

data:'method=show_suggessions&queryString='+inputString+'&cust_id='+cust_id,

dataType:'json',

success: function(data){

$('#suggestions').fadeIn(); // Show the suggestions box

$('#suggestions').html('<p id="searchresults">'+data.SUGG+'</p>'); // Fill the suggestions box

$('#imdropping_list i').removeClass("icon-chevron-down");

$('#imdropping_list i').addClass("icon-chevron-up");

			

}

});

		

		

		

	}

}





function add_customer_cart_items()

{

	

	var customer_id=$("#customer_id").val();

	var pincode=$("#pincode").val();

	

	var order_cityID=$("#order_cityID").val();

	

	if(customer_id=='')

	{

	

		$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Please Select Customer</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

		return false;

		

	}

	

	if(pincode=='')

	{

		$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Please Select Address.</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

								

								

		return false;

	}

	

	

	

			 $("#add_cart_cust").html("Wait...");

			

			 $('#add_cart_cust').attr('disabled','disabled');

	

	

				var total_rows=$("#p_rows tr:first").attr("data-id"); 	

				

				if(total_rows==undefined)

				{

					 total_rows=0; 	

				}

				else

				{

					total_rows=$("#p_rows tr:first").attr("data-id"); 	

				}

	

	

		$.ajax(

		{



			type: "POST",

			dataType: 'json',

			url: "../scripts/ajax/index.php",

			data: "method=add_customer_cart_items&total_rows="+total_rows+'&cust_id='+customer_id+'&order_cityID='+order_cityID,



			success: function(data){

					if(data.RESULT=='OK')

					{

						

				

				

				

				

				

					if(total_rows==0)

					{

					$('#p_rows').html(data.cart_items);	

					}

					else

					{

					$('#p_rows tr:first').before(data.cart_items);	

					}

					

					//$('#suggestions').hide("slow");

					//$("#p_type").val('');

					

					

					$('.numbersOnly').keyup(function ()

					{

						if (this.value != this.value.replace(/[^0-9\.]/g, ''))

						{

						   this.value = this.value.replace(/[^0-9\.]/g, '');

						}

					});

					

					

					get_total();

					

					$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Product Added Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

					

					

					$("#add_cart_cust").html('<i class="fa fa-shopping-cart"></i> Cart Items');

			

			 		$('#add_cart_cust').removeAttr('disabled');

					

					}

					else if(data.RESULT=='NOT_OK')

					{

						

						

						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+data.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

						

						$("#add_cart_cust").html('<i class="fa fa-shopping-cart"></i> Cart Items');

			

			 			$('#add_cart_cust').removeAttr('disabled');

						return false;

						

					}

			}

		}

	);	

	

	

	

		

	

}

    

	function addproduct_to_table(product_id)

	{

		

		

		

		

		

		$.ajax(

		{



			type: "POST",

			dataType: 'json',

			url: "scripts/ajax/index.php",

			data: "method=get_product_detail_order_new&product_id="+product_id,



			success: function(data){

					if(data.RESULT=='OK')

					{

				
 				var total_rows = $("#TotalRow").val();
				

				//var total_rows=$("#p_rows tr").length; 	



				var row_id=parseInt(total_rows)+1;	



				var html_table_row='<tr height="40" class="a_rows" id="prorow_'+row_id+'">';

				 html_table_row+='<td align="center" valign="middle" class="pro_img"><img src="'+data.IMAGE+'" class="row_product_img"></td>';

				   



                    html_table_row+='<td align="center" valign="middle" class="pro_name"><input type="hidden" class="populated" value="'+data.product_name+'" id="product_names_'+row_id+'" name="product_names[]" /><input type="hidden" class="populated" value="'+data.product_unit+'" id="p_unit_'+row_id+'" name="p_unit[]" />'+data.product_name+'</td>';



             



                    html_table_row+='<td align="center" valign="middle" class="pro_weight"><input type="text" class="form-control numbers" value="'+data.product_unit_weight+'" id="weight_'+row_id+'" name="weight[]" onkeypress="get_hide('+row_id+');"/> <spna>'+data.unit_type+'</span></td>';



					



					 html_table_row+='<td align="center" valign="middle" class="pro_quantity"><input type="text" class="form-control numbers" value="1" id="quantities_'+row_id+'" name="quantities[]" onkeypress="get_hide('+row_id+');"/></td>';



					 



					 html_table_row+='<td align="center" valign="middle" class="pro_quantity"><button class="btn btn-xs btn-info" onclick="get_price('+row_id+','+product_id+');" type="button">Get Price</button>  <div id="yes_'+row_id+'" style="display:none"><img src="images/Yes.png"></div></td>';



					 



					 html_table_row+='<td align="center" valign="middle" class="pro_unit_price"><span class="populated">'+data.product_cost+'</span></td>';



					



					  html_table_row+='<td align="center" valign="middle" class="pro_unit_price"><input type="text" class="form-control" value="'+data.product_unit_cost+'"  onblur="get_total();" id="unit_cost_prices_'+row_id+'" name="unit_cost_prices[]" readonly /></td>';




                    html_table_row+='<td align="center" ><input type="hidden" class="populated" value="'+data.product_mrp+'" id="p_mrp_'+row_id+'" name="p_mrp[]" /><input type="hidden" class="populated" value="'+data.product_id+'" id="product_ids_'+row_id+'" name="product_ids[]" /><input type="hidden" class="populated" value="" id="od_ids_'+row_id+'" name="od_ids[]"><strong><a href="javascript:onclick=delete_row('+row_id+')";"  class="remove_row" id="delete_'+row_id+'"><i class="fa fa-trash" style=""></i></strong></td>';

                    html_table_row+='</tr>';



					if(total_rows==0)



					{



					$('#p_rows').html(html_table_row);	



					}



					else



					{



					//$('#p_rows tr:last').after(html_table_row);	

					

					

					$('#p_rows tr:first').before(html_table_row);	



					}


					$("#TotalRow").val(row_id);

					$("#discount_amt").val(0);

					$("#d_val").val('');

					

					

					

					



				

				

					

					$('.numbersOnly').keyup(function ()

{

    if (this.value != this.value.replace(/[^0-9\.]/g, ''))

	{

       this.value = this.value.replace(/[^0-9\.]/g, '');

    }

});





$("input.numbers").keypress(function(event) {

  return /\d/.test(String.fromCharCode(event.keyCode));

});

					

					

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

			$("#"+row_id).hide("slow", function(){$(this).remove();get_total();})

			

      

    }

	

	function get_hide(row_id)

{

	

	$("#yes_"+row_id).hide();

	

}

	

	

	function get_total()



	{

		

		

		

		var discount=$("#discount_amt").val();

		

		

		if(discount=='')

		{

			discount=0;

			

		}





		var min_order=parseInt($("#min_order").val());



		var cnt=$("tr.a_rows").length;



		var qty=0;



		var price=0;



		var row_id=0;
		

		var price_total=0;
		

		var price_total_new=0;
		

		var area=0;

		

		var getpro_order_value=0;



		var express=0;

		var b_charge=0;



		var cod=0;



		for(i=0;i<cnt;i++)



		{



			var qty=$("tr.a_rows td.pro_quantity").children('input').eq(i).val();



			var unit_cost=$("tr.a_rows td.pro_unit_price").children('input').eq(i).val();



			price_total+=parseInt(unit_cost);	

			price_total_new+=parseInt(unit_cost);	

		}

		

		

		

		

		var cart_total=price_total;



		



		//area ship charge

		

		

		if(cart_total>min_order)

		{

		



			area=0;

			

		

		}

		else

		{

			area=$("#min_ship_charge").val();

			

		}



		express=$("#express_ship_charge").val();

		

		if(express=='')

		{

			express=0;

			

		}

		



		b_charge=$("#b_charge").val();

		

		if(b_charge=='')

		{

			b_charge=0;

			

		}



		

		

		$("#area_ship_charge").val(area);

		$("#area_shipping_charge").html(area);



		//alert(price_total);

		getpro_order_value=$("#getprof_ship_order").val();

		



		


	



		price_total= parseInt(price_total) +  parseInt(area) +  parseInt(express) +  parseInt(b_charge)  - parseInt(discount);


		price_total_new= parseInt(price_total_new) +  parseInt(area) +  parseInt(express) +  parseInt(b_charge);


		

			$("#orderamount").html(cart_total);



		$("#subtotal").val(cart_total);



		



		$("#total_amt").val(price_total);



		$("#totalamount").html(price_total);
		
		
		if(discount>price_total_new)
		{
			$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Discount amount should not be more then Order Amount.</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });	
		}



	}



	

	

	

	

	

	

	

	

	function get_price(row_id,product_id)



	{

		

	

		



		var in_weight=$("#weight_"+row_id).val();



		var in_qty=$("#quantities_"+row_id).val();



		



		$.ajax(







		{







			type: "POST",







			dataType: 'json',







			url: "scripts/ajax/index.php",







			data: "method=update_order_price&product_id="+product_id+"&weight="+in_weight+"&qty="+in_qty,







			success: function(data){



				



				$("#unit_cost_prices_"+row_id).val(data.PRICE);	

				

				

				

				//$("#yes_"+row_id).show();

				

				

				$("#yes_"+row_id).css({ display: "inline-block" });



				get_total();



			}







		}







	);	



		



		



		



	



		



		



		



  



	}

	





