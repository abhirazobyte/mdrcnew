

$(document).ready(function() 
{
	
    var nextload=$('#results').find('.isload').val();
	var track_load = 1; //total loaded record group(s)
	var loading  = false; //to prevents multipal ajax loads
	var serach_keyword=$("#serach_keyword").val();
	var total_products=$("#total_products").val();
	

	$('#results').load("scripts/ajax/index.php", 
					{
						'method':'get_my_orders',
						'page':track_load,
						'serach_keyword':serach_keyword,
						'total_products':total_products
					}, 
	function() {
		
		var c=$('#results').find('.nextload_total').val();
		 var total_datas=$('#results').find('.total_datas').val();
		 
		  $('.total_result').html(total_datas);
		
		//alert(c);
		$('#load_more_total').html(c);
		
		 var nextload1=$('#results').find('.isload').val();
		  
		  if(nextload1=='false')
		  {

				$('.animation_image').hide(); 
		  }
		
		track_load++;
		
		
	}); //load first group



/*$(window).scroll(function() 
{ */
//detect page scroll


$( "#l_more" ).click(function() {


//alert("hi");


	var serach_keyword=$("#serach_keyword").val();
	
	var track_load = $('#results').find('.nextpage').val();

	var total_products=$("#total_products").val();
	
    var nextload=$('#results').find('.isload').val();

	

		if(nextload=='true' && loading==false) //there's more data to load
		{
			
			
					loading = true; //prevent further ajax loading
					
					

					$('.animation_image').hide(); //show loading image

					$.post('scripts/ajax/index.php',
						{'method':'get_my_orders','page': track_load,'serach_keyword':serach_keyword,'total_products':total_products}, 
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
									
								
								 //append received data into the element
								 
								  var nextload1=$('#results').find('.isload').val();
								  
								  if(nextload1=='true')
								  {

								$('.animation_image').show(); 
								  }//hide loading image once data is received
								  
								  

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




$("#search_keyword" ).keyup(function() {
	
	 var searct_text=$("#search_keyword").val();
	 if(searct_text!='')
	 {
		 $("#serach_keyword").val(searct_text);
	 }
	 else
	 {
		 $("#serach_keyword").val(searct_text);
	  }

	  get_filtered_data();

});



	
	



//general function call evrytime
function get_filtered_data()
{
	$('#results').html('<h3 class="loading-p loaderclass">Loading..</h3>');
	
	var serach_keyword=$("#serach_keyword").val();
	var serach_cat=$("#serach_cat").val();

	var total_products=$("#total_products").val();
	

 	$.ajax({

	     url:"scripts/ajax/index.php",
         type:"POST",
         data:"method=get_my_orders&actionfunction=showData&page=1&serach_keyword="+serach_keyword+"&total_products="+total_products,
        cache: false,
        success: function(response)
		{
		 // $('.animation_image').hide();
		  $('#results').html(response);
		 						
		 var c=$('#results').find('.nextload_total').val();
		
		//alert(c);
		$('#load_more_total').html(c);
		
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
