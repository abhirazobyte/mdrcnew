cartItems();



//general function call evrytime

function cartItems()

{

	

	$(".cartError").html("");

 	$.ajax({



	    type: "POST",

		url: "scripts/ajax/index.php",

		dataType:'json',

        data:"method=cart&actionType=cartItems",

        cache: false,

        success: function(data)

		{

			if(data.RESULT=="OK")

			{

				

				$(".sub_total").html(''+data.subtotal);

				$(".CartItems").html(data.html);
				
				$(".HomeCollection").html(data.homeCollectionHtml);
				
				$(".cartCount").html(data.cartCount);

				

				

				

			}

			else

			{

				cartItems();

					

			}

			

		}

	});  



}



$(document).on("click",".cartDelete", function ()

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

      },

      function (r)

			{

				if(r == true)

				{

					$.ajax(

					{

						  type: "POST",

						  dataType:'json',

						  url: "scripts/ajax/index.php",

						  data: "method=cart&actionType=cartItemsDelete&id="+getid,

						  success: function(data)

						  {

								  if(data.RESULT=="OK")

								  {						  		

										

										$().toastmessage('showSuccessToast', 'Delete Successfully !');

										cartItems();

										

								  }

								  else

								  {

									  swal({ title: "Try Again...",

									  text: '',

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





$(document).on("click",".customerMemberSelect", function ()

{

	getId=$(this).data("id");

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=memberList&id='+getId,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		$('#ajax_modal_container').html(data);

		$('#Modalselect-add-patients').modal('show');

		

		

	})

	.fail(function()

	{

		alert( "Try again." );

	});

});





$(document).on("click",".prescriptionSelect", function ()

{

	getId=$(this).data("id");

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=addPrescription&id='+getId,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		$('#ajax_modal_container').html(data);

		$('#modal-UploadPrescription').modal('show');
		
	$(".dropzone").change(function () {

  readFile(this);

});



$('.dropzone-wrapper').on('dragover', function (e) {

  e.preventDefault();

  e.stopPropagation();

  $(this).addClass('dragover');

});



$('.dropzone-wrapper').on('dragleave', function (e) {

  e.preventDefault();

  e.stopPropagation();

  $(this).removeClass('dragover');

});



$('.remove-preview').on('click', function () {

  var boxZone = $(this).parents('.preview-zone').find('.box-body');

  var previewZone = $(this).parents('.preview-zone');

  var dropzone = $(this).parents('.form-group').find('.dropzone');

  boxZone.empty();

  previewZone.addClass('hidden');

  reset(dropzone);

});

		

		

	})

	.fail(function()

	{

		alert( "Try again." );

	});

});








$(document).on("click",".selectMemberData", function ()

{

	

	

	$('.error_div').html('');

	var membersID=$("input[name='members']:checked").val();

	

	$('.selectMemberData').prop('disabled', true);

	

	

	

	

	

	

	if(membersID==undefined)

	{

		

		$('.selectMemberData').prop('disabled', false);

		

		

		

		

		

		$("#ListCouponDiv").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Please Select Members.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

	

	

	

		

	}

	else

	{

		

		

		var cartID=$("#cartID").val();

		cartItemMemberAssign(membersID,cartID);

		

		

		

		

	}	

	

});



function cartItemMemberAssign(membersID,cartID)

{

	

	

	

	

 	$.ajax({



	    type: "POST",

		url: "scripts/ajax/index.php",

		dataType:'json',

        data:"method=cart&actionType=cartItemMemberAssign&membersID="+membersID+"&cartID="+cartID+"",

        cache: false,

        success: function(data)

		{

			$('#Modalselect-add-patients').modal('hide');

			if(data.RESULT=="OK")

			{

				

				cartItems();

				

				

			}

			else

			{

				cartItems();
				if(data.RESULT=="NOK")
				{
					swal({ title: "Alert",
									  text: data.MSG,
									  type: "warning",
									   timer: 3000
									  });
									  return false;
				}
					

			}

			

		}

	});  



}





$(document).on("click",".cartMemberRemove", function ()

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

				confirmButtonText: "Yes, remove it!",

				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",

				closeOnConfirm: true

      },

      function (r)

			{

				if(r == true)

				{

					$.ajax({



						type: "POST",

						url: "scripts/ajax/index.php",

						dataType:'json',

						data:"method=cart&actionType=cartMemberRemove&cartID="+getid+"",

						cache: false,

						success: function(data)

						{

							

							

							if(data.RESULT=="OK")

							{

								

								cartItems();

								

								

							}

							else

							{

								cartItems();

									

							}

							

						}

					}); 

					

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







$(document).on("click",".AddMemberData", function ()

{

	getId='';

	cartID=$(this).data("id");

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=member_addedit&id='+getId+'&cartID='+cartID,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		$('#Modalselect-add-patients').modal('hide');

		$('#ajax_modal_container').html(data);

		$('#modalform-add-member').modal('show');

	})

	.fail(function()

	{

		alert( "Try again." );

	});

});





function paynow()

{

	$(".cartError").html("");


	
	
	var home_collection_check=$("input[name='home_collection']:checked").val();
	if(home_collection_check=='Yes')
	{
		var home_collection='Yes';
		
	}
	else
	{
		var home_collection='No';
	}
	
	 

	 $.ajax({



			type: "POST",

			url: "scripts/ajax/index.php",

			dataType:'json',

			data:"method=cart&actionType=cartItemsCheck&home_collection="+home_collection,

			cache: false,

			success: function(data)

			{

				

				

				if(data.RESULT=="OK")

				{

					

					

					window.location.href=data.URL;

					

					

				}

				else

				{

					

					$(".cartError").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.html+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

					

						

				}

				

			}

		}); 

		

}



$(document).on("click",".item_modal_submit", function ()

{

$('#preForm').validate({

		rules:

		{

			item: {

					required: true,

					minlength:5,

					maxlength:5

			},

		},

		submitHandler: function (form)

		{

			//$('.item_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			
			$(".errorDiv").html("");

			$(".item_modal_submit").attr("disabled", true);

			var dataString = new FormData(form);

			dataString.append('method', 'cart');

			dataString.append('actionType', 'prescripttionAddEdit');

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

					//$('.item_modal_submit').html('Submit');

					$(".item_modal_submit").attr("disabled", false);

				

				  if(responseData.RESULT==0)

				  {
					  		$('#modal-UploadPrescription').modal('hide');
							cartItems();

				  }

				  else 

				  {
					  
					  	//$(".errorDiv").html(responseData.msg);
						
						$(".errorDiv").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+responseData.msg+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

							

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





$(document).on("click",".prescriptionRemove", function ()

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

				confirmButtonText: "Yes, remove it!",

				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",

				closeOnConfirm: true

      },

      function (r)

			{

				if(r == true)

				{

					$.ajax({



						type: "POST",

						url: "scripts/ajax/index.php",

						dataType:'json',

						data:"method=cart&actionType=cartPrescriptionRemove&cartID="+getid+"",

						cache: false,

						success: function(data)

						{

							

							

							if(data.RESULT=="OK")

							{

								

								cartItems();

								

								

							}

							else

							{

								cartItems();

									

							}

							

						}

					}); 

					

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





$(document).on("click",".prescriptionView", function ()

{

	getId=$(this).data("id");

	$.ajax({

	type: 'POST',

	url: 'scripts/modal/index.php?method=viewPrescription&id='+getId,

	dataType : 'html',

	data: $(this).serialize()

	})

	.done(function(data)

	{

		$('#ajax_modal_container').html(data);

		$('#modal-UploadPrescription-details').modal('show');
		
	

		

		

	})

	.fail(function()

	{

		alert( "Try again." );

	});

});















