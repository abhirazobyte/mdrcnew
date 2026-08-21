$(document).ready(function() 

{	

    var nextload=$('#results').find('.isload').val();

	var track_load = 1; //total loaded record group(s)

	var loading  = false; //to prevents multipal ajax loads

	

	

	var type_ids=$("#type_ids").val();

    var dieses_ids=$("#dieses_ids").val();

    var total_data=$("#total_data").val();

	var search_data=$("#search_data").val();

	var category_ids=$("#category_ids").val();

	

	var sort_by=$("#sort_by").val();

	var city_id=$("#city_id").val();

	var department_id=$("#department_id").val();
	var pageType=$("#pageType").val();
	

	

	   



	



	$('#results').load("scripts/ajax/index.php", 

					{

						'method':'packages',

						'actionType':'list',

						'page':track_load,

						'type_ids':type_ids,

						'dieses_ids':dieses_ids,

						'search_data':search_data,

						'category_ids':category_ids,

						'sort_by':sort_by,

						'city_id':city_id,

						'department_id':department_id,
						'pageType':pageType,

						'total_data':total_data

					}, 

	function() {

		

					

			  var c=$('#results').find('.nextload_total').val();

			  var total_datas=$('#results').find('.total_datas').val();				

			  $('.total_result').html(total_datas);

			  

			  //alert(c);

			  $('#load_more_total').html(c);

			  

			  $('.loaderDiv').hide(); 

			  

			   var nextload1=$('#results').find('.isload').val();

				

				if(nextload1=='false')

				{



					  $('.animation_image').hide(); 

					  

				}

				else

				{

					 $('.animation_image').show(); 

					

				}

				

				 $('.numbersOnly').keyup(function ()

				 {

					  if (this.value != this.value.replace(/[^0-9\.]/g, ''))

					  {

						 this.value = this.value.replace(/[^0-9\.]/g, '');

					  }

				 });

		

		

		track_load++;

		

		

	}); //load first group







$( "#l_more" ).click(function() {





	var type_ids=$("#type_ids").val();

    var dieses_ids=$("#dieses_ids").val();

    var total_data=$("#total_data").val();

	var search_data=$("#search_data").val();

	var category_ids=$("#category_ids").val();

	var sort_by=$("#sort_by").val();

	var city_id=$("#city_id").val();

	var department_id=$("#department_id").val();
	var pageType=$("#pageType").val();

	

	



    var nextload=$('#results').find('.isload').val();

	

		

	



		if(nextload=='true' && loading==false) //there's more data to load

		{

			

			

					loading = true; //prevent further ajax loading

					

					$('.animation_image').hide(); //show loading image

					

					 $('.loaderDiv').show(); 



					$.post('scripts/ajax/index.php',

						{'method':'packages','page': track_load,'type_ids':type_ids,'dieses_ids':dieses_ids,'total_data':total_data,'search_data':search_data,'category_ids':category_ids,'actionType':'list','sort_by':sort_by,'pageType':pageType,'city_id':city_id,'department_id':department_id}, 

							function(data)

							{

								

								

								    $('#results').find('.nextpage').remove();

		   							$('#results').find('.isload').remove();

									$('#results').find('.nextload_total').remove();

									$("#results").append(data);

								

								

								//alert($('#results').find('.nextload_total').val());

									

								var c=$('#results').find('.nextload_total').val();

								

								//alert(c);

								$('#load_more_total').html(c);

								

								 $('.loaderDiv').hide(); 

									

								

								 //append received data into the element

								 

								  var nextload1=$('#results').find('.isload').val();

								  

								  if(nextload1=='true')

								  {



									$('.animation_image').show(); 

								  }//hide loading image once data is received

								  

								  

								  $('.numbersOnly').keyup(function ()

								{

									if (this.value != this.value.replace(/[^0-9\.]/g, ''))

									{

									   this.value = this.value.replace(/[^0-9\.]/g, '');

									}

								});



								track_load++; //loaded group increment

								

								

								

								

								loading = false;

						

								$(".pro_a").hover(function() 

								{

								

								},

								function()

								{

									 

								}

					

							);

					

							

							var pim=$(".product_item").length;

					

							$('#item_per_page').html(pim); 

					

							

								

							}).fail(function(xhr, ajaxOptions, thrownError) 

							{

									alert(thrownError); //alert with HTTP error

									$('.animation_image').show(); //hide loading image

									loading = false;

									

							});



				

			}

		

	});

	

});





function ChanegeSortOrder(a)
{
	
	$("#sort_by").val(a);
	get_filtered_data();	
}


function searchData(a)
{
	
	$("#search_data").val(a);
	get_filtered_data();	
}


function show_suggestion_diseases(s)
{
	var value = s.toLowerCase();
    $(".diseasesDiv div").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
	
}

function show_suggestion_category(s)
{
	var value = s.toLowerCase();
    $(".categoryDiv div").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
	
}




$('input[name="types[]"]').click(function()

{

		  

			var chk_vals=[];

		    $('input[name="types[]"]:checked').each(function() {chk_vals.push($(this).val());});	  

		    if(chk_vals.length>0)

			{

				var time=chk_vals.join(',');	

				$("#type_ids").val(time);			

			}

			else

			{

				$("#type_ids").val('');				

			}

			

			

			get_filtered_data();			

		  

		  

});



$('input[name="diseases[]"]').click(function()

{
	
	
	
	
	
	
			if ($(this).is(':checked'))
			{

				var d_value=$(this).val();
				var  d_id=$(this).attr("id");
				var d_title=$(this).attr("data-title");
				var html_tag='<li class="'+d_id+'"><label class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" for="'+d_id+'">'+d_title+'</label></li>';
				$("#crnt-select").append(html_tag);
				$(".filterDivMaster").show();

			}
			else
			{
				var  d_id=$(this).attr("id");
				$("."+d_id).remove();
				
				if($('#crnt-select li').length<=0)
				{
					$(".filterDivMaster").hide();
					
				}
			}


		  

			var chk_vals=[];

		    $('input[name="diseases[]"]:checked').each(function() {chk_vals.push($(this).val());});	  

		    if(chk_vals.length>0)

			{

				var time=chk_vals.join(',');	

				$("#dieses_ids").val(time);			

			}

			else

			{

				$("#dieses_ids").val('');				

			}

			

			

			get_filtered_data();			

		  

		  

});





$('input[name="category[]"]').click(function()

{

		  
			if ($(this).is(':checked'))
			{

				var d_value=$(this).val();
				var  d_id=$(this).attr("id");
				var d_title=$(this).attr("data-title");
				var html_tag='<li class="'+d_id+'"><label class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" for="'+d_id+'">'+d_title+'</label></li>';
				$("#crnt-select").append(html_tag);
				$(".filterDivMaster").show();

			}
			else
			{
				var  d_id=$(this).attr("id");
				$("."+d_id).remove();
				
				
				
				if($('#crnt-select li').length<=0)
				{
					$(".filterDivMaster").hide();
					
				}
			}

			
			var chk_vals=[];

		    $('input[name="category[]"]:checked').each(function() {chk_vals.push($(this).val());});	  

		    if(chk_vals.length>0)

			{

				var time=chk_vals.join(',');	

				$("#category_ids").val(time);			

			}

			else

			{

				$("#category_ids").val('');				

			}

			

			

			get_filtered_data();			

		  

		  

});





	

//general function call evrytime

function get_filtered_data()

{

	

	

	

	

	$('#results').html('');

	 $('.loaderDiv').show(); 

	 $('.animation_image').hide();

	var type_ids=$("#type_ids").val();

    var dieses_ids=$("#dieses_ids").val();

    var total_data=$("#total_data").val();

	var search_data=$("#search_data").val();

	var category_ids=$("#category_ids").val();

	var sort_by=$("#sort_by").val();

	var city_id=$("#city_id").val();

	var department_id=$("#department_id").val();
	var pageType=$("#pageType").val();

	

	

	$.ajax({



	     url:"scripts/ajax/index.php",

         type:"POST",

         data:"method=packages&actionfunction=showData&page=1&type_ids="+type_ids+"&dieses_ids="+dieses_ids+"&total_data="+total_data+"&actionType=list&search_data="+search_data+"&category_ids="+category_ids+"&sort_by="+sort_by+"&city_id="+city_id+"&department_id="+department_id+"&pageType="+pageType,

		

        cache: false,

        success: function(response)

		{

		 // $('.animation_image').hide();

		  $('#results').html(response);

		 						

								 var c=$('#results').find('.nextload_total').val();

								

								//alert(c);

								$('#load_more_total').html(c);

								

								 $('.loaderDiv').hide(); 

								

								 var nextload1=$('#results').find('.isload').val();

								 

								  var total_datas=$('#results').find('.total_datas').val();

								  

								  $('.total_result').html(total_datas);

								  

								  if(nextload1=='false')

								  {



										$('.animation_image').hide(); 

										

								  }

								  else

								  {

									  $('.animation_image').show(); 

									  

								   }

								   

								   

								   

								   

								   

								   

		  

		}

	});  



}











