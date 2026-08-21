<!-- Start: Active item List  -->
$(document).ready(function(){
	
	
	var service_id=$("#service_id").val();
	var tab_type=$("#tab_type").val();
	
	$('#table_item').DataTable({
		"order": [[ 1, "desc" ]],
		"columnDefs": [ { 'targets': [0],"orderable": false } ],
  		'autoWidth':false,
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':'scripts/ajax/index.php?method=item_data_for_doctors_services&actionType=item_list&service_id='+service_id+'&tab_type='+tab_type,
		},
		'columns': [
		 	{ "data": "checkbox" },
		  	{ "data": "id" },
			{ "data": "image" },
            { "data": "name" }
			
		    
			
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
<!-- End: Active item List -->



function changeTab(className,itemValue)
{
	$("#tab_type").val(itemValue);
	var oTable = $('#table_item').dataTable( );
	oTable.api().ajax.reload(null, false);
	
		
}


<!-- Start: item Multi delete  -->
function mulitple_item_select()
{
			var chk_vals=[];
	  	    $('input[name="del[]"]:checked').each(function() {chk_vals.push($(this).val());});
			if(chk_vals.length>0)
			{
				var service_id=$("#service_id").val();
				var ids=chk_vals.join(',');
				swal({
					title: "Are you sure?",
					text: "you want to remove records?",
					type: "warning",
					showCancelButton: true,
					cancelButtonClass: 'btn-primary',
					confirmButtonClass: 'btn-warning',
					confirmButtonText: "Yes, remove it!",
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
							  data: "method=item_data_for_doctors_services&actionType=itemMultiDelete&ids="+ids+"&service_id="+service_id,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  var oTable = $('#table_item').dataTable( );
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
<!-- End: item Multi delete  -->








function mulitple_item_select1()
{
			var chk_vals=[];
	  	    $('input[name="del[]"]:checked').each(function() {chk_vals.push($(this).val());});
			if(chk_vals.length>0)
			{
				
				var service_id=$("#service_id").val();
				var ids=chk_vals.join(',');
				swal({
					title: "Are you sure?",
					text: "you want to add records?",
					type: "warning",
					showCancelButton: true,
					cancelButtonClass: 'btn-primary',
					confirmButtonClass: 'btn-primary',
					confirmButtonText: "Yes, add it!",
					confirmButtonClass: "confirm btn btn-lg btn-success xyz",
					closeOnConfirm: true
					},
					function (r){
						if(r == true)
						  {
							  $.ajax({
							  type: "POST",
							  dataType: 'json',
							  url: "scripts/ajax/index.php",
							  data: "method=item_data_for_doctors_services&actionType=itemMultiAdd&ids="+ids+"&service_id="+service_id,
							  success: function(responseData){
								  if(responseData.RESULT==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}});
								  }
								  
								  var oTable = $('#table_item').dataTable( );
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

