// <!-- Start: Active item_lab List  -->
$(document).ready(function(){
	$('#table_item_lab').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0,2,6],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=item_lab&actionType=item_lab_list',
		},
		'columns': [
		 	{ "data": "checkbox" },
		  	{ "data": "id" },
			{ "data": "image" },
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
// <!-- End: Active item_lab List -->


// <!-- Start: Active item_lab addedit modal-->
$(document).on("click",".item_lab_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=item_lab_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_item_lab_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#item_lab_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
// <!-- End: Active item_lab addedit modal -->

// <!-- Start: modal item_lab addedit submit  -->
$(document).on("click",".item_lab_modal_submit", function ()
{
    $('#item_lab_form').validate({
		rules:
		{
			item_lab: {
					required: true,
					minlength:5,
					maxlength:5
			},
		},
		submitHandler: function (form)
		{
			$('.item_lab_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".item_lab_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'item_lab');
			dataString.append('actionType', 'item_labAddEdit');
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
					$('.item_lab_modal_submit').html('Submit');
					$(".item_lab_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_item_lab_addedit').modal('hide');
							var oTable = $('#table_item_lab').dataTable( );
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
// <!-- End: modal item_lab addedit submit -->

// <!-- Start: item_lab single delete  -->
$(document).on("click",".item_lab_delete_onclick", function ()
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
						  data: "method=item_lab&actionType=item_labDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_item_lab').dataTable( );
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
// <!-- End: item_lab single delete  -->

// <!-- Start: item_lab Multi delete  -->
function mulitple_item_lab_select()
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
							  data: "method=item_lab&actionType=item_labMultiDelete&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_item_lab').dataTable( );
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
// <!-- End: item_lab Multi delete  -->


// 

// -------------------- SYNC DEPARTMENT --------------------
$(document).on("click",".sync_department_onclick", function ()
{
	var rate_list_panel_id=$(this).data('rate_list_panel_id');
	swal({
		title: "Are you sure?",
		text: "You want to SYNC Department data!",
		type: "warning",
		showCancelButton: true,
		cancelButtonClass: 'btn-primary',
		confirmButtonClass: 'btn-warning',
		confirmButtonText: "Yes, Sync it!",
		confirmButtonClass: "confirm btn btn-lg btn-warning xyz",
		closeOnConfirm: true
	}, function (r)
	{
		if(r == true)
		{
			$('#custom_ajax_preloader').show();
			$.ajax(
			{
				type: "POST",
				dataType: 'json',
				url: "scripts/ajax/index.php",
				data: "method=item_lab&actionType=sync_department&rate_list_panel_id="+rate_list_panel_id,
				success: function(responseData)
				{
					$('#custom_ajax_preloader').hide();
					if(responseData.RESULT==0)
					{
						// var oTable = $('#table_lis_item').dataTable( );
						// oTable.api().ajax.reload(null, false);
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Sync Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
						// return false;
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
			});
		}
		else
		{
			return false;
		}
	});
});
// ----------------------------------------