<!-- Start: Active welcome_reward_report List  -->
$(document).ready(function(){
	$('#table_welcome_reward_report').DataTable({
		"order": [[0, "desc" ]],
		"columnDefs": [ { 'targets': [5,6],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=welcome_reward_report&actionType=welcome_reward_report_list',
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "name" },
		    { "data": "email" },
            { "data": "phone" },
			{ "data": "amount" },
			{ "data": "transaction_date" },
            { "data": "remark" }
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
<!-- End: Active welcome_reward_report List -->

function reset_data()
{
	$('#table_welcome_reward_report_wrapper').hide();
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	
	var search_type='';
	var search_start_date='';
	var search_end_date='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=welcome_reward_report&actionType=SessionSet&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_welcome_reward_report').dataTable( );
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
		data: "method=welcome_reward_report&actionType=SessionSet&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			$('#table_welcome_reward_report_wrapper').show();
			var oTable = $('#table_welcome_reward_report').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});
