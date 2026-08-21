$(document).ready(function()
{
    var nextload=$('#result_data').find('.isload').val();
	var track_load = 1; //total loaded record group(s)
	var loading  = false; //to prevents multipal ajax loads
	var catv=$("#catv").val();
    var tagv=$("#tagv").val();
	var serach_keyword=$("#serach_keyword").val();
	var total_events=$("#total_events").val();
	
	$('#result_data').load("scripts/ajax/index.php",
	{
		'method':'get_event',
		'page':track_load,
		'cat':catv,
		'tag':tagv,
		'serach_keyword':serach_keyword,
		'total_events':total_events
	},

	function(){
		var c=$('#result_data').find('.nextload_total').val();
		var total_datas=$('#result_data').find('.total_datas').val();
		$('.total_result').html(total_datas);
		//alert(c);
		$('#load_more_total').html(c);
		var nextload1=$('#result_data').find('.isload').val();
		if(nextload1=='false')
		{
			$('.animation_image').hide();
		}
		track_load++;
	}); //load first group


/*$(window).scroll(function()
{ */
//detect page scroll
	$( "#load_more_event" ).click(function(){
		
		var catv=$("#catv").val();
		var tagv=$("#tagv").val();
		var serach_keyword=$("#serach_keyword").val();
		var track_load = $('#result_data').find('.nextpage').val();
		var total_events=$("#total_events").val();
	    var nextload=$('#result_data').find('.isload').val();
		if(nextload=='true' && loading==false) //there's more data to load
		{
			loading = true; //prevent further ajax loading
			$('.animation_image').hide(); //show loading image
			$.post('scripts/ajax/index.php',
			{'method':'get_event','page': track_load,'cat':catv,'tag':tagv,'serach_keyword':serach_keyword,'total_events':total_events},
			function(data){
				$('#result_data').find('.nextpage').remove();
				$('#result_data').find('.isload').remove();
				$('#result_data').find('.nextload_total').remove();
				$("#result_data").append(data);
				var c=$('#result_data').find('.nextload_total').val();
				$('#load_more_total').html(c);
				//append received data into the element
				var nextload1=$('#result_data').find('.isload').val();
				if(nextload1=='true')
				{
					$('.animation_image').show();
				}
				track_load++; //loaded group increment
				loading = false;
			}).fail(function(xhr, ajaxOptions, thrownError){
				alert(thrownError); //alert with HTTP error
				$('.animation_image').show(); //hide loading image
				loading = false;
			});
		}
	});
});


$("#serach_keyword" ).keyup(function() {
	 var searct_text=$("#serach_keyword").val();
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
	$('#result_data').html('<h3 class="loading-p loaderclass">Loading..</h3>');
	var catv=$("#catv").val();
	var tagv=$("#tagv").val();
	var serach_keyword=$("#serach_keyword").val();
	var total_events=$("#total_events").val();
	$.ajax({
		url:"scripts/ajax/index.php",
		type:"POST",
		data:"method=get_event&page=1&cat="+catv+"&tag="+tagv+"&serach_keyword="+serach_keyword+"&total_events="+total_events,
		cache: false,
		success: function(response)
		{
			$('#result_data').html(response);
			var c=$('#result_data').find('.nextload_total').val();
			//alert(c);
			$('#load_more_total').html(c);
			var nextload1=$('#result_data').find('.isload').val();
			var total_datas=$('#result_data').find('.total_datas').val();
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
