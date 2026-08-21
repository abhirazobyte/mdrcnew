<!-- Start:  gallery List  -->

$(document).ready(function(){

	

		var event_id=$("#event_id").val();

	
	$('#table_event_gallery').DataTable({

		"order": [[ 1, "desc" ]],

		"columnDefs": [ { 'targets': [0,1,2,4],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,
		
		'stateSave': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=event_gallery_images&actionType=gallery_images_list&event_id='+event_id,

		},

		'columns': [

		 	{ "data": "checkbox" },

		  	{ "data": "id" },

			{ "data": "image" },
			
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

<!-- End:  gallery List -->




<!-- Start:  gallery single delete  -->

$(document).on("click",".gallery_delete_onclick", function ()

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

						  data: "method=event_gallery_images&actionType=galleryDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_event_gallery').dataTable( );

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

<!-- End: gallery single delete  -->



<!-- Start: gallery Multi delete  -->

function mulitple_gallery_select()

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

							  data: "method=event_gallery_images&actionType=galleryMultiDelete&ids="+ids,

							  success: function(responseData){

								  if(responseData.RESULT==0)

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  else

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  var oTable = $('#table_event_gallery').dataTable( );

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

<!-- End: gallery Multi delete  -->

