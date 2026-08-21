<!-- Start: Active user List  -->
$(document).ready(function(){
	$('#table_user').DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [ { 'targets': [3,5,6,9],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=user&actionType=user_list',
		},
		'columns': [
		  	{ "data": "id" },
            { "data": "name" },
			{ "data": "is_active" },
			{ "data": "area_id" },
			{ "data": "wallet" },
			{ "data": "orders" },
			{ "data": "reffers" },
			{ "data": "otp_code" },
			{ "data": "registration_date" },
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
<!-- End: Active user List -->



<!-- Start:order_detail_onclick  modal-->
$(document).on("click",".user_detail_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=user_detail&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_user_detail').modal('show');
		$('#custom_ajax_preloader').hide();
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



<!-- Start: Active user addedit modal-->
$(document).on("click",".user_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=user_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_user_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#user_form').parsley();
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active user addedit modal -->




<!-- Start: Active user addedit modal-->
$(document).on("click",".user_sms_onclick", function ()
{
	getId=$(this).data("id");
	$('#custom_ajax_preloader').show();
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=user_sms_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		// show the response
		$('#ajax_modal_container').html(data);
		$('#modal_user_sms_addedit').modal('show');
		$('#custom_ajax_preloader').hide();
		
		$('#user_sms_form').parsley();
		CKEDITOR.replace('message');
		$.getScript("scripts/js/ajax.js");
		
	})
	.fail(function()
	{
		// just in case posting your form failed
		alert( "Try again." );
		$('#custom_ajax_preloader').hide();
	});
});
<!-- End: Active user addedit modal -->


<!-- Start: modal user addedit submit  -->
$(document).on("click",".user_sms_modal_submit", function ()
{
    $('#user_sms_form').validate({
		rules:
		{
			name: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$('.user_sms_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".user_sms_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'user');
			dataString.append('actionType', 'userSMSAddEdit');
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
					$('.user_sms_modal_submit').html('Submit');
					$(".user_sms_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
						$('#modal_user_sms_addedit').modal('hide');
						var oTable = $('#table_user').dataTable( );
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
<!-- End: modal user addedit submit -->


<!-- Start: modal user addedit submit  -->
$(document).on("click",".user_modal_submit", function ()
{
    $('#user_form').validate({
		rules:
		{
			name: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$('.user_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".user_modal_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'user');
			dataString.append('actionType', 'userAddEdit');
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
					$('.user_modal_submit').html('Submit');
					$(".user_modal_submit").attr("disabled", false);
				
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
							$('#modal_user_addedit').modal('hide');
							var oTable = $('#table_user').dataTable( );
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
<!-- End: modal user addedit submit -->

<!-- Start: user single delete  -->
$(document).on("click",".user_delete_onclick", function ()
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
						  data: "method=user&actionType=userDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_user').dataTable( );
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
<!-- End: user single delete  -->

<!-- Start: user Multi delete  -->
function mulitple_user_select()
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
							  data: "method=user&actionType=userMultiDelete&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_user').dataTable( );
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
<!-- End: user Multi delete  -->



function reset_data()
{
	$('#search_type').val('All');
	$('#search_start_date').val('');
	$('#search_end_date').val('');
	
	var search_type='';
	var search_start_date='';
	var search_end_date='';
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=user&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_user').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
}


$(function(){
	$('#search_order').click(function(){
	var search_type=$('#search_type').val();
	var search_start_date=$('#search_start_date').val();
	var search_end_date=$('#search_end_date').val();
	
	if(search_start_date=='' || search_end_date=='')
	{
		$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Please Select Date.</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
		return false;s
	}
	$.ajax
	({
		type: "POST",
		dataType: 'json',
		url: "scripts/ajax/index.php",
		data: "method=user&actionType=SessionSet&search_type="+search_type+"&search_start_date="+search_start_date+"&search_end_date="+search_end_date,
		success: function(data)
		{
			var oTable = $('#table_user').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});