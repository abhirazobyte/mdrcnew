<!-- Start: add_money List  -->
$(document).ready(function(){
	var customer_id=$('#customer_id1').val();	
	
	$('#table_add_money').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=add_money&actionType=add_money_list&customer_id='+customer_id,
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "amount" },
			{ "data": "remark" },
            { "data": "pay_with" },
			 { "data": "payment_status" },
			{ "data": "entry_date_time" }
		],
		 language: 
		 {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_ items/page',
	    }
	});
	
	$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	$('[data-toggle="tooltip"]').tooltip();
});
<!-- End: add_moneyr List -->



<!-- Start: add_money_addedit_onclick modal-->
$(document).on("click",".add_money_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=add_money_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_add_money_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		$('#add_money_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active brand addedit modal -->




<!-- Start: modal brand addedit submit  -->
$(document).on("click",".add_money_modal_submit", function ()
{
    $('#add_money_form').validate({
		submitHandler: function (form)
		{
			$('.add_money_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".add_money_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'add_money');
			dataString.append('actionType', 'add_moneyAddEdit');
			$.ajax({
                dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$('.add_money_modal_submit').html('Submit');
					$(".add_money_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#new_wallet').html('<i class="fa fa-rupee-sign"></i> '+responseData.new_wallet);
							
							$('#modal_add_money_addedit').modal('hide');
							var oTable = $('#table_add_money').dataTable( );

							oTable.api().ajax.reload(null, false);
				  }
                },
                error: function (responseData) {
                    console.log('Ajax request not recieved!');
                }
            });
            return false;
        }
    });
});
<!-- End: modal brand addedit submit -->



<!-- Start: modal customer addedit submit  -->
$(document).on("click",".customer_modal_submit", function ()
{
	var customer_id=$('#customer_id1').val();
	
	
    $('#customer_form').validate({
		rules:
		{
			name: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$('.customer_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".customer_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'customer');
			dataString.append('actionType', 'customerAddEdit');
			$.ajax({
                dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$('.customer_modal_submit').html('Submit');
					$(".customer_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_customer_addedit').modal('hide');
							var oTable = $('#table_customer').dataTable( );
							oTable.api().ajax.reload(null, false);
							location.href = 'index.php?view=customer_detail&customer_id='+customer_id;
				  }
                },
                error: function (responseData) {
                    console.log('Ajax request not recieved!');
                }
            });
            return false;
        }
    });
});
<!-- End: modal customer addedit submit -->



<!-- Start: Active customer addedit modal-->
$(document).on("click",".customer_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=customer_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_customer_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#customer_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active customer addedit modal -->



<!-- Start: customer single delete  -->
$(document).on("click",".customer_delete_onclick", function ()
{
	var getid=$(this).data('id');
	if(getid!='')
	{
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
            }, function (r)
			{
				if(r == true)
				{
					$.ajax(
					{
						  type: "POST",
						  dataType: 'json',
						  url: "scripts/ajax/index.php",
						  data: "method=customer&actionType=customerDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_customer').dataTable( );
									oTable.api().ajax.reload(null, false);
									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
									location.href = 'index.php?view=customer_list';
								  }
								  else
								  {
									  swal({ title: "Try Again...",
									  text: data.msg,
									  type: "warning",
									   timer: 1000
									  });
									  return false;
								  }
							  }
						  }
					  );
				}
				else
				{
					return false;
				}
            });
	}
	else
	{
		swal({ title: "Try Again...",
                text: "Oops Something gone wrong...",
                type: "warning",
				 timer: 1500
            });
			return false;
	}
});
<!-- End: customer single delete  -->




<!-- Start:  order List  -->
$(document).ready(function(){
	
	var customer_id=$("#customer_id1").val();
	
		$('#table_order').DataTable({
			"order": [[0, "desc" ]],
			"columnDefs": [ { 'targets': [4],"orderable": false } ],
			'autoWidth':false,
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url':'scripts/ajax/index.php?method=order&actionType=order_list&customer_id='+customer_id,
			},
	
			'columns': [
				{ "data": "id" },
				{ "data": "category_name" },
				{ "data": "order_status" },
				{ "data": "net_order_value" },
				{ "data": "btn" }
			],
			 language: 
			 {
				searchPlaceholder: 'Search...',
				sSearch: '',
				lengthMenu: '_MENU_ items/page',
			}
		});	

	
	$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	$('[data-toggle="tooltip"]').tooltip();
});
<!-- End:  order List -->



<!-- Start:order_detail_onclick  modal-->
$(document).on("click",".order_detail_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=order_detail&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_order_detail').modal('show');
		$('#custom_ajax_preloader').hide();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active brand addedit modal -->


<!-- Start: add_money List  -->
$(document).ready(function(){
	var customer_id=$('#customer_id1').val();	
	
	$('#table_rechaegr_number').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=customer_detail&actionType=table_rechaegr_number&customer_id='+customer_id,
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "order_detail_category_name" },
			{ "data": "order_detail_operator_name" },
            { "data": "master_no" }
		],
		 language: 
		 {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_ items/page',
	    }
	});
	
	$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	$('[data-toggle="tooltip"]').tooltip();
});
<!-- End: add_moneyr List -->

