<!-- Start:  help List  -->

$(document).ready(function(){

	

		var current_status=$("#current_status").val();

	
	$('#table_help').DataTable({

		"order": [[ 0, "desc" ]],

		"columnDefs": [ { 'targets': [3],"orderable": false } ],

  		'autoWidth':false,

		'processing': true,

		'serverSide': true,

		'serverMethod': 'post',

		'ajax': {

			'url':'scripts/ajax/index.php?method=help&actionType=help_list&current_status='+current_status,

		},

		'columns': [

		 	
			

		  	{ "data": "id" },
			{ "data": "name" },

            { "data": "subject" },

            { "data": "message" },

            
		{ "data": "date" },
			

			
			
			
			 { "data": "status" }
			 

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

<!-- End:  help List -->



<!-- Start:  help single delete  -->



<!-- End: help single delete  -->



<!-- Start: help Multi delete  -->



<!-- End: help Multi delete  -->







//Delete Price





<!-- Start:Price  addedit modal-->



<!-- End: Active brand addedit modal -->



<!-- Start: modal Price addedit submit  -->






function change_help_status(id,value)

{

				$.ajax(

					{

						  type: "POST",

						  dataType: 'json',

						  url: "scripts/ajax/index.php",

						  data: "method=help&actionType=help_status_update&getid="+id+"&value="+value,

						  success: function(responseData)

						  {

								  if(responseData.RESULT==0)

								  {

								

									$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Updated Successfully.</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });

									

									 /* var oTable = $('#table_help').dataTable( );

									 	oTable.api().ajax.reload(null, false);

 										return false;*/

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




function update_soldout_status(my_value,my_id)
{	
	$.ajax({
			type: "POST",
			dataType: 'json',
			url: "scripts/ajax/index.php",
			data: "method=change_pro_soldout&value="+my_value+"&id="+my_id,
			success: function(data)
			{
				swal({
						 title:"Successfully Updated.",
						 type:"success",
              			 timer: 1500
           			});
			}
		}
	);	
}

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
		data: "method=help&actionType=SessionSet&search_category="+search_category+"&search_brand="+search_brand,
		success: function(data)
		{
			var oTable = $('#table_help').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
}


$(function(){
	$('#search_help').click(function(){
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
		data: "method=help&actionType=SessionSet&search_category="+search_category+"&search_brand="+search_brand,
		success: function(data)
		{
			var oTable = $('#table_help').dataTable( );
			oTable.api().ajax.reload();		
		}
	});	 
});
});