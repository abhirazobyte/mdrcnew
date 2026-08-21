<!-- Start: Active Banner List  -->

$(document).ready(function(){

	$('#table_notification').DataTable({

		"order": [[ 1, "desc" ]],

		"columnDefs": [ { 'targets': [0,4],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=notification&actionType=notification_list',

		},

		'columns': [

		 	{ "data": "checkbox" },

				

		  	{ "data": "id" },
			
			
            { "data": "title" },
			
            { "data": "image" },

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

<!-- End: Active notification List -->





<!-- Start: Active notification addedit modal-->

$(document).on("click",".notification_resend_onclick", function ()
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

                confirmButtonText: "Yes, Resend Notification it!",

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

						  data: "method=notification&actionType=notificationResend&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_notification').dataTable( );

									oTable.api().ajax.reload(null, false);

									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Resend Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

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

<!-- Start: Active notification addedit modal-->

$(document).on("click",".notification_addedit_onclick", function ()

{

	getId=$(this).data("id");

	$('#custom_ajax_preloader').show();

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=notification_addedit&id='+getId,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		// show the response

		$('#ajax_modal_container').html(data);

		$('#modal_notification_addedit').modal('show');

		$('#custom_ajax_preloader').hide();

		

		$('#notification_form').parsley();
		
				 $( function() {
  
        $( "#product" ).autocomplete({
            source: function( request, response ) {
			   	$("#product_id").val('');  
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=show_suggessions_product&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
								
                 $('#product').val(ui.item.label); 
				  $('#product_id').val(ui.item.value);
			
				  
				  // display the selected text
				 //$('#brand_id').val(ui.item.value); 
				 
				 fill_data_user(ui.item.value);
				 // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });

		$.getScript("scripts/js/ajax.js");

		

	})

	.fail(function()

	{

		// just in case posting your form failed

		alert( "Try again." );

		$('#custom_ajax_preloader').hide();

	});

});

<!-- End: Active notification addedit modal -->



<!-- Start: modal notification addedit submit  -->

$(document).on("click",".notification_modal_submit", function ()

{

    $('#notification_form').validate({

		rules:

		{

			notification: {

					required: true,

					minlength:5,

					maxlength:5

			},

		},

		submitHandler: function (form)

		{

			$('.notification_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');

			$(".notification_modal_submit").attr("disabled", true);

			var dataString = new FormData(form);

			dataString.append('method', 'notification');

			dataString.append('actionType', 'notificationAddEdit');

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

					$('.notification_modal_submit').html('Submit');

					$(".notification_modal_submit").attr("disabled", false);

				

				  if(responseData.RESULT==1)

				  {

							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

				  }

				  else  if(responseData.RESULT==0)

				  {

							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

							$('#modal_notification_addedit').modal('hide');

							var oTable = $('#table_notification').dataTable( );

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

<!-- End: modal notification addedit submit -->



<!-- Start: notification single delete  -->

$(document).on("click",".notification_delete_onclick", function ()

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

						  data: "method=notification&actionType=notificationDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_notification').dataTable( );

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

<!-- End: notification single delete  -->



<!-- Start: notification Multi delete  -->

function mulitple_notification_select()

{

			var chk_vals=[];

	  	    $('input[name="del[]"]:checked').each(function() {chk_vals.push($(this).val());});

			if(chk_vals.length>0)

			{

				var ids=chk_vals.join(',');

				swal({

					title: "Are you sure?",

					text: "you want to delete records?",

					type: "warning",

					showCancelButton: true,

					cancelButtonClass: 'btn-primary',

					confirmButtonClass: 'btn-warning',

					confirmButtonText: "Yes, delete it!",

					confirmButtonClass: "confirm btn btn-lg btn-warning xyz",

					closeOnConfirm: true

					},

					function (r){

						if(r == true)

						  {

							  $.ajax({

							  type: "POST",

							  dataType: 'json',

							  url: "scripts/ajax/index.php",

							  data: "method=notification&actionType=notificationMultiDelete&ids="+ids,

							  success: function(responseData){

								  if(responseData.RESULT==0)

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  else

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  var oTable = $('#table_notification').dataTable( );

								  oTable.api().ajax.reload(null, false);

							  }

						  });

						 }

						else

						{

							return false;

						}

					}

				);

			}

			else

			{

				swal({

						 title:"Please Select Record",

						 type:"warning",

              			 timer: 1500

           			 });

			return false;

			}

}

<!-- End: notification Multi delete  -->



