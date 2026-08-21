<!-- Start: Active product_sale_report List  -->
$(document).ready(function(){
	$('#table_product_sale_report').DataTable({
		"order": [[0, "desc" ]],
		"columnDefs": [ { 'targets': [0,1,2,3],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=product_sale_report&actionType=product_sale_report_list',
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "p_product_name" },
		    { "data": "product_weight" },
            { "data": "pro_amount" },
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
<!-- End: Active product_sale_report List -->

function reset_data()
{
	$('#product_sale_report').hide();
	$('#search_type').val('All');
	$('#search_start_date').val('');
	$('#search_end_date').val('');

	$('#export_btn').hide();
	
	
	var search_type='';
	var search_start_date='';
	var search_end_date='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=product_sale_report&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			$('#export_btn').hide();
			var oTable = $('#table_product_sale_report').dataTable( );
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
		data: "method=product_sale_report&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			$('#export_btn').show();
			$('#product_sale_report').show();
			var oTable = $('#table_product_sale_report').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});
