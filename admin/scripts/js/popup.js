<!-- Start:  popup List  -->
$(document).ready(function(){
	$('#table_popup').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0,2,4],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=popup&actionType=popup_list',
		},
		'columns': [
		 	{ "data": "checkbox" },
		  	{ "data": "id" },
            { "data": "image" },
			
			
			
			{ "data": "link" },
			
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
<!-- End: Active popup List -->


<!-- Start: Active popup addedit modal-->
$(document).on("click",".popup_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=popup_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_popup_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#popup_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active popup addedit modal -->

<!-- Start: modal popup addedit submit  -->
$(document).on("click",".popup_modal_submit", function ()
{
    $('#popup_form').validate({
		rules:
		{
			popup: {
					required: true,
					minlength:5,
					maxlength:5
			},
		},
		submitHandler: function (form)
		{
			$('.popup_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".popup_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'popup');
			dataString.append('actionType', 'popupAddEdit');
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
					$('.popup_modal_submit').html('Submit');
					$(".popup_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_popup_addedit').modal('hide');
							var oTable = $('#table_popup').dataTable( );
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
<!-- End: modal popup addedit submit -->

<!-- Start: popup single delete  -->
$(document).on("click",".popup_delete_onclick", function ()
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
						  data: "method=popup&actionType=popupDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_popup').dataTable( );
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
<!-- End: popup single delete  -->

<!-- Start: popup Multi delete  -->
function mulitple_popup_select()
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
							  data: "method=popup&actionType=popupMultiDelete&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_popup').dataTable( );
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
<!-- End: popup Multi delete  -->

