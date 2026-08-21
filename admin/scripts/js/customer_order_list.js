<!-- Start: order List  -->

$(document).ready(function(){

	

	

	var current_status=$("#current_status").val();

	$('#table_order').DataTable({

		"order": [[ 0, "desc" ]],

		"columnDefs": [ { 'targets': [1,2,3,4,5,6],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=customer_order&current_status='+current_status+'&actionType=order_list',

		},

		'columns': [

		  	{ "data": "id" },

			 { "data": "order_date" },

    
	
            { "data": "customer_name" },

			

			{ "data": "payment_type" },

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

<!-- End: Active order List -->



$(document).on("click",".order_delete_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=order_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_proposal_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#proposal_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});


$(document).on("click",".proposal_modal_submit", function ()
{
    $('#proposal_form').validate({
		rules:
		{
			proposal: {
					required: true,
					minlength:5,
					maxlength:5
			},
		},
		submitHandler: function (form)
		{
			$('.proposal_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".proposal_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'customer_order');
			dataString.append('actionType', 'orderAddEdit');
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
					$('.proposal_modal_submit').html('Submit');
					$(".proposal_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_proposal_addedit').modal('hide');
							var oTable = $('#table_order').dataTable( );
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




