$(document).ready(function(){
	$('#table_push_notification').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0,2,5],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=push_notification&actionType=push_notification_list',
		},
		'columns': [
		 	{ "data": "checkbox" },
		  	{ "data": "id" },
			{ "data": "title" },
            { "data": "image" },
			{ "data": "message" },
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
$(document).on("click",".push_notification_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=push_notification_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_push_notification_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		$('#push_notification_form').parsley();
		$.getScript("scripts/js/ajax.js");
		$.getScript("lib/selectdropdown/jquery-ui.min.js");

//--------------------------------------------
		$(function() {
			$("#search").autocomplete({
				source: function( request, response ) {
					var type=$("#type option:selected").val();
					$("#search_id").val('');
					$.ajax({
						url: "scripts/ajax/index.php",
						type: 'post',
						dataType: "json",
						data:'method=show_suggession_type&type='+type+'&queryString='+request.term,
						success: function(data) {
							response(data);
						}
					});
				},
				minLength: 0,
				select: function (event, ui) {
					$('#search').val(ui.item.label); // display the selected text
					$("#search_id").val(ui.item.value);		 
					return false;
				}
			}).focus(function () {
				$(this).autocomplete("search");
			});
		});
	})

	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});

$(document).on("click",".push_notification_resend_onclick", function ()
{
	var getId=$(this).data('id');
	if(getId!='')
	{
		 swal({
                title: "Are you sure?",
                text: "You will not be able to undo after this action!",
                type: "warning",
                showCancelButton: true,
				cancelButtonClass: 'btn-primary',
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, Resend it!",
				confirmButtonClass: "confirm btn btn-lg btn-warning xyz",
                closeOnConfirm: true
            }, function (r)
			{
				if(r==true)
				{
					$.ajax({
						dataType: 'json',
						type: "POST",
						url: "scripts/ajax/index.php",
						data: "method=push_notification&actionType=resend_notification&id="+getId,
						success:function(responseData)
						{ 
							if(responseData.RESULT==0)
							{
								$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
								var oTable = $('#table_push_notification').dataTable( );
								oTable.api().ajax.reload(null, false);
								return false;
							}
							else
							{
								swal({ title: "Try Again...",
								text: responseData.msg,
								type: "warning",
								 timer: 1000
								});
								return false;
							}
						},
						error: function (responseData) {
							console.log('Ajax request not recieved!');
							return false;
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

$(document).on("click",".push_notification_modal_submit", function ()
{
    $('#push_notification_form').validate({
		rules:
		{
			push_notification: {
					required: true,
					minlength:5,
					maxlength:5
			},
		},
		submitHandler: function (form)
		{
			$('.push_notification_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".push_notification_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'push_notification');
			dataString.append('actionType', 'push_notificationAddEdit');
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
					$('.push_notification_modal_submit').html('Submit');
					$(".push_notification_modal_submit").attr("disabled", false);
				  if(responseData.RESULT==1)
				  {
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
						$('#modal_push_notification_addedit').modal('hide');
						var oTable = $('#table_push_notification').dataTable( );
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
$(document).on("click",".push_notification_delete_onclick", function ()
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
						  data: "method=push_notification&actionType=push_notificationDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_push_notification').dataTable( );
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

function mulitple_push_notification_select()
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
							  data: "method=push_notification&actionType=push_notificationMultiDelete&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_push_notification').dataTable( );
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

function getType()
{
	var type=$("#type option:selected").val();
	if(type=="Radiology" || type=="Pathology")
	{
		$(".Type").addClass("d-none");
		$(".Type").hide();
	}
	else
	{
		$(".Type").removeClass("d-none");
		$(".Type").show();
	}
}