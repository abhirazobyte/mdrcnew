<!-- Start:  order List  -->
$(document).ready(function(){
	
	var current_status=$("#current_status").val();
	$('#table_order').DataTable({
		"order": [[0, "desc" ]],
		"columnDefs": [ { 'targets': [6],"orderable": false } ],
		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=order&actionType=order_list&current_status='+current_status,
		},

		"drawCallback": function (settings) { 
			var response = settings.json;
			$('#All_orders_count').html(response.All_orders_count);
			$('#Pending_orders_count').html(response.Pending_orders_count);
			$('#Paid_orders_count').html(response.Paid_orders_count);
			$('#Canceled_orders_count').html(response.Canceled_orders_count);
		},

		'columns': [
			{ "data": "id" },
			{ "data": "order_date" },
			{ "data": "customer_name" },
			{ "data": "city_name" },
			{ "data": "total" },
			{ "data": "status" },
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




$(document).on("click",".order_status_submit", function (){
	$('#order_status_form').validate({
		rules:
		{
		},
		submitHandler: function (form)
		{
			swal({
				title: "Are you sure?",
				text: "Order Status Change!",
				type: "warning",
				showCancelButton: true,
				cancelButtonClass: 'btn-primary',
				confirmButtonClass: 'btn-warning',
				confirmButtonText: "Yes, Change it!",
				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",
				closeOnConfirm: true
			}, function (r){
				if(r == true)
				{
					$('.order_status_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
					$(".order_status_submit").attr("disabled", true);
					var dataString = new FormData(form);
					dataString.append('method', 'order');
					dataString.append('actionType', 'orderStatusChange');
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
							$('.order_status_submit').html('Submit');
							$(".order_status_submit").attr("disabled", false);
							if(responseData.RESULT==1)
							{
								$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							}
							else  if(responseData.RESULT==0)
							{
								$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
								location.reload();
							}
						},
						error: function (responseData) {
							console.log('Ajax request not recieved!');
						}
					});

				}
				else
				{
					return false;
				}
			});
		}
	});
});


function smsDataGet(status)
{
	var customer_id=$('#customer_id').val();
	var order_master_id=$('#order_master_id').val();
	$.ajax({
        dataType: 'json',
        type: "POST",
        url: "scripts/ajax/index.php",
        data: 'method=order&actionType=smsTextGet&status='+status+'&customer_id='+customer_id+'&order_master_id='+order_master_id,
        success: function (responseData)
        {
        	if(responseData.RESULT==0)
        	{
         		$('#remark').val(responseData.msg);
        	}
        	else
        	{
        		$('#remark').val('');
        	}
        },
        error: function (responseData) {
            console.log('Ajax request not recieved!');
        }
    });
}



$(document).on("click",".order_api_onclick", function ()
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
                confirmButtonText: "Yes, Order Place it!",
				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",
                closeOnConfirm: true
            }, function (r)
			{
				if(r == true)
				{
					$('.order_api_onclick_'+getid).html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
					$('.order_api_onclick_'+getid).prop( "disabled", true);
					

					$.ajax({
						  type: "POST",
						  dataType: 'json',
						  url: "scripts/ajax/index.php",
						  data: "method=order_synchronization&actionType=BookingAPINew&getid="+getid,
						  success: function(responseData)
						  {
							$('.order_api_onclick_'+getid).html('<i class="fas fa-info"></i>');
							$('.order_api_onclick_'+getid).prop( "disabled", false);
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_order').dataTable();
									oTable.api().ajax.reload(null, false);
									$.bootstrapGrowl('<h4><strong>LIS Api called </strong></h4> <p>Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
 									return false;
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
						  });
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


$(document).on("click",".update_lis_visitor_id", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=orderDetailLisVisitorUpdate&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_lis_visitor_detail').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#formLisVisitorInfo').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});

$(document).on("click",".SubmitformLisVisitorInfo", function ()
{
    $('#formLisVisitorInfo').validate({
		submitHandler: function (form)
		{
			$('.SubmitformLisVisitorInfo').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".SubmitformLisVisitorInfo").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'order');
			dataString.append('actionType', 'updateLisVisitorinfo');
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
					$('.SubmitformLisVisitorInfo').html('Submit');
					$(".SubmitformLisVisitorInfo").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_lis_visitor_detail').modal('hide');
							location.reload(true);
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

$("#frm_search .select2").select2();

