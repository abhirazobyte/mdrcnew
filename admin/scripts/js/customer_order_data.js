// Order Detail
$(document).on("click",".order_detail", function () 
{
	getId=$(this).data("id");
	
	
	$('#custom_ajax_preloader').show();
	
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=order_detail_module&id='+getId,
	dataType : 'html',  
	data: $(this).serialize()
	})
	.done(function(data)
	{     
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_order_detail_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
	
	
		$.getScript("other/common/load_temp_js.js");
	})
	.fail(function()
	{ 
		// just in case posting your form failed
		alert( "Try again." ); 
		$('#custom_ajax_preloader').hide();   
	});
});



// Order Label Print Detail
$(document).on("click",".order_print_label", function () 
{
	getId=$(this).data("id");
	
	
	$('#custom_ajax_preloader').show();
	
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=order_print_label&id='+getId,
	dataType : 'html',  
	data: $(this).serialize()
	})
	.done(function(data)
	{     
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_order_print_label').modal('show');
		$('#custom_ajax_preloader').hide();
	
	
		$.getScript("other/common/load_temp_js.js");
	})
	.fail(function()
	{ 
		// just in case posting your form failed
		alert( "Try again." ); 
		$('#custom_ajax_preloader').hide();   
	});
});




$(document).on("click",".coupon_order_detail", function () 
{
	getId=$(this).data("id");
	
	
	$('#custom_ajax_preloader').show();
	
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=coupon_order_detail_module&id='+getId,
	dataType : 'html',  
	data: $(this).serialize()
	})
	.done(function(data)
	{     
		// show the response
		$('#ajax_modal_container1').html(data);
		$('#modal_coupon_order_detail_module').modal('show');
		$('#custom_ajax_preloader').hide();
	
	
		$.getScript("other/common/load_temp_js.js");
	})
	.fail(function()
	{ 
		// just in case posting your form failed
		alert( "Try again." ); 
		$('#custom_ajax_preloader').hide();   
	});
});
