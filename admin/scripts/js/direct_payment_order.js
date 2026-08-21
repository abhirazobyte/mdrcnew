<!-- Start: Active direct_payment_order List  -->
$(document).ready(function(){
	var current_status=$("#current_status").val();
	$('#table_direct_payment_order').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [6],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=direct_payment_order&actionType=direct_payment_order_list&current_status='+current_status,
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "name" },
            { "data": "mobile" },
			{ "data": "amount" },
			{ "data": "order_pay_status" },
			{ "data": "created_date" },
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
<!-- End: Active direct_payment_order List -->



<!-- Start: Active direct_payment_order modal-->
$(document).on("click",".direct_payment_order_detail_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=direct_payment_order_detail&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_direct_payment_order_detail').modal('show');
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
<!-- End: Active direct_payment_order modal -->