// -------------------- DATATABLE --------------------
$(document).ready(function(){
	$('#table_lis_item').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0,1,2,3,4,5],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=lis_item&actionType=lis_item_list',
		},
		'columns': [
			{ "data": "checkbox" },
		  	{ "data": "id" },
            { "data": "name" },
			{ "data": "center_id" },
			{ "data": "price" },
			{ "data": "city" },
			{ "data": "code" },
            { "data": "btn" }
		],
		 language:
		 {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_ lis_items/page',
	    }
	});
	$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	$('[data-toggle="tooltip"]').tooltip();
});
// ----------------------------------------
// -------------------- SYNC LIS WEB OPEN MODAL --------------------
$(document).on("click",".sync_lis_test_item_save_onclick", function ()
{
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php',
	dataType : 'json',
	data:"method=lis_item&actionType=sync_lis_item_save_backup",
	success: function (responseData)
	{
		if(responseData.RESULT==1)
		{
			$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
		}
		else  if(responseData.RESULT==0)
		{
			$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
		}
	},
	error: function (responseData) {
		console.log('Ajax request not recieved!');
	}
	});
});
// ----------------------------------------
// -------------------- SYNC LIS WEB MODAL SUBMIT --------------------
$(document).on("click",".sync_lis_web_item_addedit_onclick", function ()
{
	swal({
		title: "Are you sure?",
		text: "You will not be able to undo after this action!",
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
			$.ajax({
                dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: "method=lis_item&actionType=sync_web_lis_itemAddEdit",
	 			success: function (responseData)
				{
					$('#custom_ajax_preloader').hide();
					
				  if(responseData.RESULT==1)
				  {
							$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				  }
				  else  if(responseData.RESULT==0)
				  {
					$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
					var oTable = $('#table_lis_item').dataTable( );
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
// ----------------------------------------
// -------------------- SYNC RECORD & MAP --------------------
$(document).on("click",".sync_lis_test_item_addedit_onclick", function ()
{
	var getid=$(this).data('id');
	swal({
		title: "Are you sure?",
		text: "You will not be able to undo after this action!",
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
				data: "method=lis_item&actionType=sync_lis_test_item&getid="+getid,
				success: function(responseData)
				{
					$('#custom_ajax_preloader').hide();
					if(responseData.RESULT==0)
					{
						var oTable = $('#table_lis_item').dataTable( );
						oTable.api().ajax.reload(null, false);
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Sync Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
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
			});
		}
		else
		{
			return false;
		}
	});
});
$(document).on("click",".sync_lis_test_item_empty_onclick", function ()
{
	swal({
		title: "Are you sure?",
		text: "You will not be able to undo after this action!",
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
				data: "method=lis_item&actionType=sync_lis_item_empty",
				success: function(responseData)
				{
					$('#custom_ajax_preloader').hide();
					if(responseData.RESULT==0)
					{
						var oTable = $('#table_lis_item').dataTable( );
						oTable.api().ajax.reload(null, false);
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Sync Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
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
			});
		}
		else
		{
			return false;
		}
	});
});
// ----------------------------------------
function mulitple_item_select()
{
			var chk_vals=[];
	  	    $('input[name="del[]"]:checked').each(function() {chk_vals.push($(this).val());});
			if(chk_vals.length>0)
			{
				var ids=chk_vals.join(',');
				swal({
					title: "Are you sure?",
					text: "you want to Inactive records?",
					type: "warning",
					showCancelButton: true,
					cancelButtonClass: 'btn-primary',
					confirmButtonClass: 'btn-warning',
					confirmButtonText: "Yes, Inactive it!",
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
							  data: "method=lis_item&actionType=itemMultiInactive&ids="+ids,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_lis_item').dataTable( );
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
// -------------------- SINGLE DELETE --------------------
$(document).on("click",".lis_item_delete_onclick", function ()
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
						  data: "method=lis_item&actionType=lis_itemDelete&getid="+getid,
						  success: function(responseData)
						  {
								  if(responseData.RESULT==0)
								  {
									var oTable = $('#table_lis_item').dataTable( );
									oTable.api().ajax.reload(null, false);
									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
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
// ----------------------------------------