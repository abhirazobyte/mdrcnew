$(document).ready(function(){
	$('#table_user_cart_notification').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=user_cart_notification_list&actionType=user_cart_notification',
			'data': function(data) {
				data.search_start_date = $('#search_start_date').val();
				data.search_end_date = $('#search_end_date').val();
			}
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "customer_name" },
            { "data": "title" },
            { "data": "noti_desc" },
            { "data": "entry_date_time" },
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


$('#search_order').click(function(){
	var oTable = $('#table_user_cart_notification').dataTable( );
	oTable.api().ajax.reload();
});

function reset_data()
{
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	var oTable = $('#table_user_cart_notification').dataTable( );
	oTable.api().ajax.reload();
}