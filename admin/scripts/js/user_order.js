<!-- Start: Active Banner List  -->

$(document).ready(function(){

	var user_id=$('#user_id').val();
	$('#table_user_order').DataTable({

		"order": [[0, "desc" ]],

		"columnDefs": [ { 'targets': [2,3,5,6,8],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=user_order&actionType=user_order_list&user_id='+user_id,

		},

		'columns': [


		  	{ "data": "id" },

            { "data": "order_date_time" },

            { "data": "area_name" },

			{ "data": "express_charge" },
			
			{ "data": "net_order_value" },
			
			{ "data": "wallet_value" },
			
			{ "data": "confirmation_remark" },
			
			{ "data": "order_status" },

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

<!-- End: Active user_order List -->


