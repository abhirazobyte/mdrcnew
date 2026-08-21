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
            { "data": "customer_name" },
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
	var vendor_id = $('#vendor_id1').val();
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=add_money_addedit&vendor_id='+vendor_id,
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
		

  $( function() {
        $( "#phone" ).autocomplete({
            source: function( request, response ) {
			   	     $("#customer_id").val('');
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=show_suggessions_customer_wallet&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
				 minLength: 0,
           		 select: function (event, ui) {
                 $('#phone').val(ui.item.label); // display the selected text
				 $('#customer_id').val(ui.item.value);
				 
				 fill_data_user(ui.item.value);
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
	
	function fill_data_user(id)
	{
		$.ajax({
			type: "POST",
			url: "scripts/ajax/index.php",
			data:'method=customer_detail_data&id='+id,
			dataType:'json',
				success: function(data){
					if(data.RESULT=='OK')
					{
						 $("#phone").val(data.phone+data.name);
						 $("#customer_id").val(data.id);
						  $("#bal").html('<i class="fa fa-rupee-sign"></i>'+data.wallet);
						 $('#phone').attr("disabled",true);
						$('#phone').attr("readonly","readonly");
					}
					else
					{
						 alert("User Not Found.");
						 $("#phone").val('');
						 $("#customer_id").val('');
						  $("#bal").html('<i class="fa fa-rupee-sign"></i> 0.00');
					}
				}
			});
 	}

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



function reset_data()
{
	$('#search_type').val('All');
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	
	var search_type='';
	var search_start_date='';
	var search_end_date='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=add_money&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_add_money').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
}


$(function(){
	$('#search_order').click(function(){
	var search_type=$('#search_type').val();
	var search_start_date=$('#search_start_date').val();
	var search_end_date=$('#search_end_date').val();
	
	if(search_start_date=='' || search_end_date=='')
	{
		$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Please Select Date.</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
		return false;s
	}
	$.ajax
	({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=add_money&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_add_money').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});
