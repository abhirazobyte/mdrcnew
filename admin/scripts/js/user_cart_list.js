$(document).ready(function(){
	$('#table_user_cart').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=user_cart_list&actionType=user_cart',
			'data': function(data) {
				data.search_start_date = $('#search_start_date').val();
				data.search_end_date = $('#search_end_date').val();
				data.search_city_id = $('#search_city_id').val();
			}
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "customer_name" },
            { "data": "cart_item_name" },
            { "data": "cart_line_total" },
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
	var oTable = $('#table_user_cart').dataTable( );
	oTable.api().ajax.reload();
});

function reset_data()
{
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	$('#search_city_id').val('').trigger('change');
	var oTable = $('#table_user_cart').dataTable( );
	oTable.api().ajax.reload();
}