<!-- Start:  product List  -->

$(document).ready(function(){

	

		var product_id=$("#product_id").val();

	
	$('#table_product').DataTable({

		"order": [[ 1, "desc" ]],

		"columnDefs": [ { 'targets': [0,1,2,4,5],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,
		
		'stateSave': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=product_images&actionType=product_images_list&product_id='+product_id,

		},

		'columns': [

		 	{ "data": "checkbox" },

		  	{ "data": "id" },
			{ "data": "image" },

            

           
		   
			 
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

<!-- End:  product List -->







<!-- Start: Active brand addedit modal-->
$(document).on("click",".product_images_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=product_images_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_product_images_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#brand_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active brand addedit modal -->

<!-- Start: modal brand addedit submit  -->
$(document).on("click",".product_images_modal_submit", function ()
{
    $('#product_images_form').validate({
		rules:
		{
			brand: {
					required: true,
					minlength:5,
					maxlength:5
			},
		},
		submitHandler: function (form)
		{
			$('.product_images_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".product_images_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'product_images');
			dataString.append('actionType', 'product_imagesAddEdit');
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
					$('.product_images_modal_submit').html('Submit');
					$(".product_images_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_product_images_addedit').modal('hide');
							var oTable = $('#table_product').dataTable( );
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








<!-- Start:  product single delete  -->

$(document).on("click",".product_delete_onclick", function ()

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

						  data: "method=product_images&actionType=productDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									var oTable = $('#table_product').dataTable( );

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

<!-- End: product single delete  -->



<!-- Start: product Multi delete  -->

function mulitple_product_select()

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

							  data: "method=product&actionType=productMultiDelete&ids="+ids,

							  success: function(responseData){

								  if(responseData.RESULT==0)

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  else

								  {

									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});

								  }

								  var oTable = $('#table_product').dataTable( );

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

<!-- End: product Multi delete  -->







//Delete Price

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

						  data: "method=product_images&actionType=productpriceDelete&getid="+getid,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

									$(".rowd_"+getid).remove();

									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

									  var oTable = $('#table_product').dataTable( );

					 oTable.api().ajax.reload(null, false);

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





<!-- Start:Price  addedit modal-->


<!-- End: Active brand addedit modal -->



<!-- Start: modal Price addedit submit  -->









$("#frm_search .select2").select2();


function reset_data()
{

	$('#search_category').select2('val', '0')
	$('#search_brand').select2('val', '0')
	
	var search_category='';
	var search_brand='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=product&actionType=SessionSet&search_category="+search_category+"&search_brand="+search_brand,
		success: function(data)
		{
			var oTable = $('#table_product').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
}


$(function(){
	$('#search_product').click(function(){
	var search_category=$('#search_category').val();
	var search_brand=$('#search_brand').val();
	
	if((search_category=='' || search_category=='0') && (search_brand=='' || search_brand=='0'))
	{
		$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Please Select Data.</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
		return false;s
	}
	$.ajax
	({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=product&actionType=SessionSet&search_category="+search_category+"&search_brand="+search_brand,
		success: function(data)
		{
			var oTable = $('#table_product').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});


