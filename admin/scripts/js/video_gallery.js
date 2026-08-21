<!-- Start: Active video_gallery List  -->

$(document).ready(function(){

	$('#table_video_gallery').DataTable({

		"order": [[ 1, "desc" ]],

		"columnDefs": [ { 'targets': [0,5],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=video_gallery&actionType=video_gallery_list',

		},

		'columns': [

		 	{ "data": "checkbox" },

		  	{ "data": "id" },

            { "data": "name" },

            { "data": "sort_order" },

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

<!-- End: Active video_gallery List -->





<!-- Start: Active video_gallery addedit modal-->

$(document).on("click",".video_gallery_addedit_onclick", function ()

{

	getId=$(this).data("id");

	$('#custom_ajax_preloader').show();

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=video_gallery_addedit&id='+getId,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		// show the response

		$('#ajax_modal_container').html(data);

		$('#modal_video_gallery_addedit').modal('show');

		$('#custom_ajax_preloader').hide();

		

		$('#video_gallery_form').parsley();

		$.getScript("scripts/js/ajax.js");

		

	})

	.fail(function()

	{

		// just in case posting your form failed

		alert( "Try again." );

		$('#custom_ajax_preloader').hide();

	});

});

<!-- End: Active video_gallery addedit modal -->



<!-- Start: modal video_gallery addedit submit  -->

$(document).on("click",".video_gallery_modal_submit", function ()

{

    $('#video_gallery_form').validate({

		rules:

		{

			name: {

					required: true,

			},

		},

		submitHandler: function (form)

		{

			$('.video_gallery_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');

			$(".video_gallery_modal_submit").attr("disabled", true);

			var dataString = new FormData(form);

			dataString.append('method', 'video_gallery');

			dataString.append('actionType', 'video_galleryAddEdit');

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

					$('.video_gallery_modal_submit').html('Submit');

					$(".video_gallery_modal_submit").attr("disabled", false);

				

				  if(responseData.RESULT==1)

				  {

							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

				  }

				  else  if(responseData.RESULT==0)

				  {

							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

							$('#modal_video_gallery_addedit').modal('hide');

							var oTable = $('#table_video_gallery').dataTable( );

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

<!-- End: modal video_gallery addedit submit -->



<!-- Start: video_gallery single delete  -->

$(document).on("click",".video_gallery_delete_onclick", function ()

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

						  data: "method=video_gallery&actionType=video_galleryDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_video_gallery').dataTable( );

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

<!-- End: video_gallery single delete  -->



<!-- Start: video_gallery Multi delete  -->

function mulitple_video_gallery_select()

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

							  data: "method=video_gallery&actionType=video_galleryMultiDelete&ids="+ids,

							  success: function(responseData){

								  if(responseData.RESULT==0)

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  else

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  var oTable = $('#table_video_gallery').dataTable( );

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

<!-- End: video_gallery Multi delete  -->




$(document).on("click",".record_delete_attribute_onclick", function ()



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



						  data: "method=video_gallery&actionType=videogalleryDelete&getid="+getid,



						  success: function(responseData)



						  {



								  if(responseData.RESULT==0)



								  {



									$(".rowd_"+getid).remove();



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
