<!-- Start: Active order_cancellation_report List  -->
$(document).ready(function(){
	$('#table_order_cancellation_report').DataTable({
		"order": [[0, "desc" ]],
		"columnDefs": [ { 'targets': [4,8],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=order_cancellation_report&actionType=order_cancellation_report_list',
		},
		 "drawCallback": function (settings) { 
        // Here the response
        var response = settings.json;
		$('#counter_report').html(response.counter_report)
  		 },
		  
		'columns': [
		  	{ "data": "id" },
            { "data": "order_date_time" },
		    { "data": "del_date" },
			{ "data": "user_name" },
			{ "data": "order_shipping_address_shipping_area_name" },
			{ "data": "net_order_value" },
			{ "data": "payment_type" },
			{ "data": "order_status" },
            { "data": "btn" },
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
<!-- End: Active order_cancellation_report List -->

function reset_data()
{
	$('#order_cancellation_report').hide();
	$('#counter_report').hide();
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	
	var search_start_date='';
	var search_end_date='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=order_cancellation_report&actionType=SessionSet&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_order_cancellation_report').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
}


$(function(){
	$('#search_order').click(function(){
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
		data: "method=order_cancellation_report&actionType=SessionSet&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			$('#order_cancellation_report').show();
			$('#counter_report').show();
			var oTable = $('#table_order_cancellation_report').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});


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


$("#frm_search .select2").select2();