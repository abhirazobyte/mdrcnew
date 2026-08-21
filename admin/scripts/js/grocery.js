$('[data-toggle="tooltip"]').tooltip();

$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$('.numberOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$("input.numbers").keypress(function(event) {
	return /\d/.test(String.fromCharCode(event.keyCode));
});

/*function to view value*/
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});

jQuery(document).ready(function($)
{

var pathname = window.location.search;
var current_view = $.getUrlVar('view');
var li_len=jQuery("ul.sidebar-nav li.mysub").length;
var li_len_sub=jQuery("ul.sub_main1 li").length;

 for(i=0;i<li_len;i++)
 {
	var a=$("ul.sidebar-nav li.mysub").eq(i); 
	var ab=$("ul.sidebar-nav li.mysub").eq(i).attr("data-main");
	var ac=$("ul.sub_main1 li").eq(i).attr("data-sub"); 

	if(ab.indexOf(',') === -1)
	{
			if(ab==current_view)
			{
				 a.addClass("active");		
			}
			
			 for(j=0;j<li_len_sub;j++)
			 {
				 if(ab==current_view)
				{
				} 
				 	var ac=$("ul.sub_main1 li").eq(j).attr("data-sub"); 
					if(ac==current_view)
					{
						if(ab==current_view)
						{
						 a.addClass("active2");	
						}
						$("ul.sub_main1 li").eq(j).addClass("active");
					}
			 }		
	}
	else
	{
			var arr=ab.split(',');
			if(jQuery.inArray(current_view,arr) === -1)
			{
			}
			else
			{	
				a.addClass("active show");
			}
	}
 }
});

// Top sticky Notifictaion
(function(){var t;t=jQuery,t.bootstrapGrowl=function(e,s){var a,o,l;switch(s=t.extend({},t.bootstrapGrowl.default_options,s),a=t("<div>"),a.attr("class","bootstrap-growl alert"),s.type&&a.addClass("alert-"+s.type),s.allow_dismiss&&a.append('<a class="close" data-dismiss="alert" href="#">&times;</a>'),a.append(e),s.top_offset&&(s.offset={from:"top",amount:s.top_offset}),l=s.offset.amount,t(".bootstrap-growl").each(function(){return l=Math.max(l,parseInt(t(this).css(s.offset.from))+t(this).outerHeight()+s.stackup_spacing)}),o={position:"body"===s.ele?"fixed":"absolute",margin:0,"z-index":"9999",display:"none"},o[s.offset.from]=l+"px",a.css(o),"auto"!==s.width&&a.css("width",s.width+"px"),t(s.ele).append(a),s.align){case"center":a.css({left:"50%","margin-left":"-"+a.outerWidth()/2+"px"});break;case"left":a.css("left","20px");break;default:a.css("right","20px")}return a.fadeIn(),s.delay>0&&a.delay(s.delay).fadeOut(function(){return t(this).alert("close")}),a},t.bootstrapGrowl.default_options={ele:"body",type:"info",offset:{from:"top",amount:20},align:"right",width:250,delay:4e3,allow_dismiss:!0,stackup_spacing:10}}).call(this);

//for checkbox selection
/*$(document).ready(function(){
	$('.checkAll').click(function()
	{
		var check=$("input[name='select_multiple']:checked").val();
		if(check=='Yes'){
			$('.delAll').attr('checked',true);
		}else{
			$('.delAll').attr('checked',false);
		}
	});
});*/

$('.checkAll').change(function () {
    ($(this).is(":checked") ? $('.delAll').prop("checked", true) :   $('.delAll').prop("checked", false))
});

//for input validation
$('.numbersOnly').keyup(function ()
{
    if (this.value != this.value.replace(/[^0-9\.]/g, ''))
	{
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});


//CKEDITOR.replace('ckeditor');
$('.ckeditor').each( function () 
{
    CKEDITOR.replace( this.id );
});


//for magnific image popup
$('.image-popup').magnificPopup({
	type: 'image',
	closeBtnInside: false,
	mainClass: 'mfp-with-zoom mfp-img-mobile',

	image: {
		verticalFit: true,
		titleSrc: function(item) {
	
	var caption = item.el.attr('title');
	
	var pinItURL = "https://pinterest.com/pin/create/button/";
	
	// Refer to https://developers.pinterest.com/pin_it/
	pinItURL += '?url=' + 'http://dimsemenov.com/plugins/magnific-popup/';
	pinItURL += '&media=' + item.el.attr('href');
	pinItURL += '&description=' + caption;
	
	return caption ;
		}
	},


gallery: {
  enabled: true 
}, 

callbacks: {
  open: function() {
	this.wrap.on('click.pinhandler', '.pin-it', function(e) {
	  
	  // This part of code doesn't work on CodePen, as it blocks window.open
	  // Uncomment it on your production site, it opens a window via JavaScript, instead of new page
	  /*window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

	  
	  return false;*/
	});
  },
  beforeClose: function() {
   //this.wrap.off('click.pinhandler');
  }
}

});

$(document).ajaxComplete(function(event,request,settings){      
    $('.image-popup').magnificPopup({type:'image', gallery: { enabled: true } });
});

//end magnific image popup

<!-- Start: Admin logout -->
function userLogout()
{
	var dataString ='method=admin&actionType=adminLogout';
	$.ajax({
		dataType: 'json',
		type: "POST",
		url: "scripts/ajax/index.php",
		data: dataString,
		success: function (responseData)
		{
			if(responseData.RESULT==0)
			{
				$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
				location.href = 'index.php';
			}
			else
			{
				$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
			}
		},
		error: function (responseData) {
			console.log('Ajax request not recieved!');
		}
	});
}
<!-- End: Admin logout -->


//for change status
function change_status(id, table_name, current_status){
	$('#status_'+id).removeAttr('onclick');
	$.ajax(
		{
			type: "POST",
			url: "scripts/ajax/index.php",
			data: "method=change_status&id="+id+"&table_name="+table_name+"&current_status="+current_status,
			success: function(msg)
			{
				if(msg=='OK')
				{
					var status = (current_status=='Active')?'assets/img/status/Inactive.png':'assets/img/status/Active.png';
					$('#status_'+id).attr('src',status);
					$('#status_'+id).unbind('click');
					$('#status_'+id).click(function(){change_status(id, table_name, current_status=='Active'?'Inactive':'Active')});
					 swal({
						 title:"Successfully Updated.",
						 type:"success",
              			 timer: 1500
           			 });
				}
				else if(msg=='CANCEL')
				{
				}
			}
		}
	);
}
function change_set_as_home(id, table_name, current_status){
	$('#set_as_home_'+id).removeAttr('onclick');
	$.ajax(
		{
			type: "POST",
			url: "scripts/ajax/index.php",
			data: "method=change_set_at_home&id="+id+"&table_name="+table_name+"&current_status="+current_status,
			success: function(msg)
			{
				if(msg=='OK')
				{
					var status = (current_status=='Active')?'assets/img/status/Inactive.png':'assets/img/status/Active.png';
					$('#set_as_home_'+id).attr('src',status);
					$('#set_as_home_'+id).unbind('click');
					$('#set_as_home_'+id).click(function(){change_set_as_home(id, table_name, current_status=='Active'?'Inactive':'Active')});
					 swal({
						 title:"Successfully Updated.",
						 type:"success",
              			 timer: 1500
           			 });
				}
				else if(msg=='CANCEL')
				{
				}
			}
		}
	);
}





//Single Record Delete
$(document).on("click",".record_delete_onclick", function ()
{
	var getid=$(this).data('id');
	var tableid=$(this).data('tableid');
	var tablename=$(this).data('tablename');
	if(tableid!='' && getid!='' && tablename!='')
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
							  data: "method=datatable_record_delete&tableid="+tableid+"&getid="+getid+"&tablename="+tablename,
							  success: function(data)
							  {
								  if(data.result==0)
								  {
									  if(tableid=='reload')
									  {
										  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}
                });
										location.reload();
										return false;
									  }
									  else
									  {
									var oTable = $('#'+tableid).dataTable( );
									oTable.api().ajax.reload()
$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>Record Deleted Successfully.</p>', {type:'warning',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}
                });
 									return false;
									  }
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
				timer: 1500});
			return false;
	}
});

//multiple record delete
function mulitple_select(tablename)
{
			var chk_vals=[];
	  	    $('input[name="del[]"]:checked').each(function() {chk_vals.push($(this).val());});
			if(chk_vals.length>0)
			{
				var ids=chk_vals.join(',');
				var tableid=$("#tableid").val();
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
							  data: "method=datatable_record_delete_multiple&ids="+ids+"&tablename="+tablename,
							  success: function(responseData){
								  if(responseData.result==0)
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'success',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}
				  });
								  }
								  else
								  {
									  $.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20}
				  });
								  }
								  var oTable = $('#'+tableid).dataTable( );
								  oTable.api().ajax.reload()
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





//for change status
function remove_image(id, table, col, folder)
{
	$.ajax({
		type: "POST",
		url: "scripts/ajax/index.php",
		data: "method=remove_image&id="+id+"&table="+table+"&col="+col+"&folder="+folder,
		success: function(msg)
		{
			if(msg=='0')
			{
				$('#image_'+id+'_'+col).attr('src','images/img_upl.gif');
				$('#btn_'+id+'_'+col).hide();
			}

		}
	});
}



function SortOrderChange(val,id,table,col)
{
	alert(val);
	alert(id);
	alert(table);
	alert(col);
}