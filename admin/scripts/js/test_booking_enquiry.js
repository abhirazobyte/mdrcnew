<!-- Start: Admin Logins List  -->

$(document).ready(function(){

	$('#table_test_booking_enquiry').DataTable({

		"order": [[ 0, "desc" ]],

		"columnDefs": [ { 'targets': [7],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=test_booking_enquiry&actionType=test_booking_enquiry_list',

		},

		'columns': [

		  	{ "data": "id" },
			{ "data": "name" },
			{ "data": "email" },
			{ "data": "city" },
			{ "data": "brief_details" },
			{ "data": "file" },
            { "data": "added_date" },  
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

<!-- End: Admin Logins List -->



<!-- Start: Admin Logins single delete  -->

$(document).on("click",".newsletter_delete_onclick", function ()

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

						  data: "method=test_booking_enquiry&actionType=test_booking_enquiryDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_test_booking_enquiry').dataTable( );

									oTable.api().ajax.reload(null, false);

									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

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

<!-- End: Admin Logins single delete  -->


