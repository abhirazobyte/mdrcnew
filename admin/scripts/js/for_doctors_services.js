<!-- Start: Active for_doctors_services List  -->
$(document).ready(function(){
	var for_doctors_id = $('#for_doctors_id').val();
	$('#table_for_doctors_services').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0,2,5],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=for_doctors_services&actionType=for_doctors_services_list&for_doctors_id='+for_doctors_id,
		},
		'columns': [
		 	{ "data": "checkbox" },
		  	{ "data": "id" },
		  	{ "data": "image" },
            { "data": "title" },
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
<!-- End: Active for_doctors_services List -->

<!-- Start: Active for_doctors_services addedit modal-->
$(document).on("click",".for_doctors_services_addedit_onclick", function ()
{
	
	getId=$(this).data("id");
	for_doctors_id=$(this).data("for_doctors_id");

	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=for_doctors_services_addedit&id='+getId+'&for_doctors_id='+for_doctors_id,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_for_doctors_services_addedit').modal('show');
		$('#custom_ajax_preloader').hide();

		$.getScript("scripts/js/ajax.js");
		$('#for_doctors_services_form').parsley();
		//CKEDITOR.replace('decsription');
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active for_doctors_services addedit modal -->
<!-- Start: modal for_doctors_services addedit submit  -->
$(document).on("click",".for_doctors_services_modal_submit", function ()
{
    $('#for_doctors_services_form').validate({
		rules:
		{
			title: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$('.for_doctors_services_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".for_doctors_services_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'for_doctors_services');
			dataString.append('actionType', 'for_doctors_servicesAddEdit');
			var decsription = CKEDITOR.instances['decsription'].getData();
			dataString.append('decsription', decsription);
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
					$('.for_doctors_services_modal_submit').html('Submit');
					$(".for_doctors_services_modal_submit").attr("disabled", false);
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_for_doctors_services_addedit').modal('hide');
							var oTable = $('#table_for_doctors_services').dataTable( );
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
<!-- End: modal for_doctors_services addedit submit -->
<!-- Start: for_doctors_services single delete  -->
$(document).on("click",".for_doctors_services_delete_onclick", function ()
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
						  data: "method=for_doctors_services&actionType=for_doctors_servicesDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_for_doctors_services').dataTable( );
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
<!-- End: for_doctors_services single delete  -->
<!-- Start: for_doctors_services Multi delete  -->
function mulitple_for_doctors_services_select()
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
							  data: "method=for_doctors_services&actionType=for_doctors_servicesMultiDelete&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_for_doctors_services').dataTable( );
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
<!-- End: for_doctors_services Multi delete  -->
