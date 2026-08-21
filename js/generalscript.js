
$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});
$("input.numbers").keypress(function(event) {
	return /\d/.test(String.fromCharCode(event.keyCode));
});
 $( function() {
        $( "#searchInput" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=search_item_suggestions&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
				 location.href = 'tests/'+ui.item.slug+'/'+ui.item.citySlug;
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li class='searchLi'><div><span  class='searchItem'>"+item.label+"</span><span class='float-end searchType label"+item.itemLabel+"'>"+item.itemLabel+"</span></div></li>" ).appendTo( ul );
      };
    });
	 $( function() {
        $( "#searchMobileInput" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                   	url: "scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=search_item_suggestions&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
				 location.href = 'tests/'+ui.item.slug+'/'+ui.item.citySlug;
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li class='searchLi'><div><span  class='searchItem'>"+item.label+"</span><span class='float-end searchType label"+item.itemLabel+"'>"+item.itemLabel+"</span></div></li>" ).appendTo( ul );
      };
    });
$('#searchForm').validate({
		rules:
		{
			email: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			var searchKeyword=$(".searchKeyword").val();
			var cityUrl=$("#cityUrl").val();
			location.href = 'search/'+cityUrl+'/'+searchKeyword+'.html';
		}
   });
$('#searchMobileForm').validate({
		rules:
		{
			email: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			var searchKeyword=$(".searchMobileKeyword").val();
			var cityUrl=$("#cityUrl").val();
			location.href = 'search/'+cityUrl+'/'+searchKeyword+'.html';
		}
   });
$(document).on("click","#subscribe_submit", function ()
{
    $('#subscribe_form').validate({
		rules:
		{
			email: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$("#subscribe_form").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'subscribe_inq');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$("#subscribe_form").attr("disabled", false);
					if(responseData==0)
					{
						$('#subscribe_form').find("#email").val('');
						$('#error_msg').html('<h5 class="text-white">Thank you for Subscribe! </h5>');
             		}
             		else if(responseData==2)
             		{
             			$('#subscribe_form').find("#email").val('');
						$('#error_msg').html('<h5 style="color: #d32e13 !important;" class="text-white">Already Subscribe this Email-ID</h5>');
             		}
             		else
             		{
             			$('#error_msg').html('<h5 style="color: #d32e13 !important;" class="text-white">Something went wrong !</h5>');
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
$(document).on("click","#form-submit", function ()
{
    $('#Contact_Form').validate({
		rules:
		{
			name: {
					required: true,
			},
			name: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$("#Contact_Form").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'help_inq');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$("#Contact_Form").attr("disabled", false);
					if(responseData==0)
					{
						$('#ContactmsgSubmit').html('<h5 class="text-white">Thank you for Cuntact Inquiry! </h5>');
             		}
             		else
             		{
             			$('#ContactmsgSubmit').html('<h5 style="color: #d32e13 !important;" class="text-white">Something went wrong !</h5>');
             		}
                },
                error: function (responseData) {
                    console.log('Ajax request not recieved!');
                }
            });
            $('#Contact_Form').find("#name").val('');
            $('#Contact_Form').find("#phone").val('');
            $('#Contact_Form').find("#city").val('');
            return false;
        }
   });
});
$('.login_f_data').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $("#loginpopup_submit").trigger('click');
    return false;
  }
});
$(document).ready(function ()
{
    $('#signin_popup_form').validate({
		rules: {
       phone:
			{
            required: true,
			minlength:10,
			maxlength:10
        	},
		email: {
            email: true,
        },
		},
		submitHandler: function (form)
		{
			$("#loginpopup_submit").attr('disabled','disabled');
			$("#invalid_login").html('');
			 var dataString ='method=login&'+$('#signin_popup_form').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#loginpopup_submit").removeAttr('disabled','disabled');
						//$("#loginpopup_submit").html("Login");
						if(data.RESULT=="OK")
						{
							$('#offcanvasExample-login').offcanvas('hide');
							$('#offcanvasExample-otpverify').offcanvas('show');
							$(".signup_login_phone").html(data.signup_login_phone);
							$("#resend_otp_p").attr('disabled','disabled');
							claimcountdown();
							//$(".resend_otp").show();
							//$(".popup_form_title").html('OTP');
							//$("#invalid_otp").html('<div class="alert alert-success custome-succes" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>'+data.MSG+'</div></div>');
						}
						else
						{
							$("#invalid_login").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});
$(document).ready(function ()
{
    $('#otp_popup_form').validate({
		rules: {
       otpch1:
			{
            required: true,
			minlength:4,
			maxlength:4
        	},
			 otpch2:
			{
            required: true,
			minlength:1,
			maxlength:1
        	},
			 otpch3:
			{
            required: true,
			minlength:1,
			maxlength:1
        	},
			 otpch4:
			{
            required: true,
			minlength:1,
			maxlength:1
        	},
		},
		submitHandler: function (form)
		{
			$("#otppopup_submit").attr('disabled','disabled');
			 $("#invalid_otp").html('');
			 var dataString ='method=login&'+$('#otp_popup_form').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#otppopup_submit").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							$().toastmessage('showSuccessToast', data.MSG);
							location.reload();
						}
						else
						{
							$("#invalid_otp").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
							$("#otppopup_submit").val("Verify OTP");
						}
					}
				}
			);
            return false;
        }
    });
});
 $('#resend_otp_p').click(function() {
		$('#invalid_otp').html('');
		$("#resend_otp_p").attr('disabled','disabled');
		$('#resend_otp_p').html("<i class='fa fa-clock-o fa-spin' style='margin:0'></i> Wait..");
  		jQuery.ajax({
		url:'scripts/ajax/index.php',
		type:'post',
		dataType:'json',
		data:'method=login&action_type=resend_otp',
		success:function(data, textStatus, XMLHttpRequest)
		{
			if(data.RESULT=="OK")
			{
				$("#invalid_otp").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
				$('#resend_otp_p').html('Resend OTP');
				claimcountdown();
			}
			else
			{
				$("#invalid_otp").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
				$('#resend_otp_p').html('Resend OTP');
				$('#success_otp').html('');
				$("#resend_otp_p").removeAttr('disabled','disabled');
			}
		}
  		});
	return false;
  });
 function change_city_area(state_id)
 {
	 $('#city_id').find('option').remove().end();
	 var newopt='<option value=""> Select</option>';
	 $('#city_id').append(newopt);
	 $('#pincode').find('option').remove().end();
	 var newopt='<option value=""> Select</option>';
	 $('#pincode').append(newopt);
	if(state_id>0)
	{
		$.ajax(
			{
				type: "POST",
				dataType: 'json',
				url: "scripts/ajax/index.php",
				data: "method=get_city_area_list&state_id="+state_id,
				success: function(data){
					for(i=0; i<data.DATA.length; i++){
						var newopt='<option value="'+data.DATA[i].id+'">'+data.DATA[i].name+'</option>';
						$('#city_id').append(newopt);
					}
				}
			}
		);
	}
	else
	{
		return false;
	}
 }
 function change_pincode_area(city_id)
 {
	 $('#pincode').find('option').remove().end();
	 var newopt='<option value=""> Select</option>';
	 $('#pincode').append(newopt);
	if(city_id>0)
	{
		$.ajax(
			{
				type: "POST",
				dataType: 'json',
				url: "scripts/ajax/index.php",
				data: "method=get_pincode_area_list&city_id="+city_id,
				success: function(data){
					for(i=0; i<data.DATA.length; i++){
						var newopt='<option value="'+data.DATA[i].name+'">'+data.DATA[i].name+'</option>';
						$('#pincode').append(newopt);
					}
				}
			}
		);
	}
	else
	{
		return false;
	}
 }
function timedOut2()
{
	$("#resend_otp_p").removeAttr('disabled','disabled');
	$("#claim_counter").html('');
}
function claimcountdown() {
    var seconds = 10;
    function tick2() {
        var counter = document.getElementById("claim_counter");
        seconds--;
        counter.innerHTML = "00:" + (seconds < 10 ? "0" : "") + String(seconds);
        if( seconds > 0 ) {
            setTimeout(tick2, 1000);
        } else
		{
			timedOut2();
            //alert("Game over");
        }
    }
    tick2();
}
function changeCityData(country_id)
{
			$(".LoaderDiv").show();
			 var dataString ='method=cityData&country_id='+country_id;
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$(".LoaderDiv").hide();
						if(data.RESULT=="OK")
						{
							$("#state_id").html(data.STATE);
						}
						else
						{
							$(".ErrorStep").html('<div class="alert alert-danger custome-error" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>'+data.MSG+'</div></div>');
						}
					}
				}
			);
}
//Profile Update Rahul Code
$(document).ready(function (){
    $('#customerForm').validate({
        rules: {
       phone:
            {
            required: true,
            minlength:10,
            maxlength:10
            },
        email: {
            email: true,
        },
        },
        submitHandler: function (form)
        {
            $(".customerFormSubmit").attr('disabled','disabled');
            $(".customerFormSubmit").html("<i class='fa fa-clock-o fa-spin'></i> Wait..");
            var dataString = new FormData(form);
            dataString.append('dataType', 'profile_update');
            dataString.append('method', 'profile_update');
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
                    if(responseData.RESULT=="0")
                    {
                        $(".customerFormSubmit").html("Save");
                        $(".customerFormSubmit").removeAttr('disabled','disabled');
                        $().toastmessage('showSuccessToast', responseData.MSG);
						if(responseData.profile_img!="")
						{
							$(".userimg").attr('src',responseData.profile_img);
						}
                        //location.reload();
                    }
                    else
                    {
                        $(".ajax_modal_submit").html("Save");
                        $(".ajax_modal_submit").removeAttr('disabled','disabled');
                        $().toastmessage('showErrorToast', responseData.MSG);
                    }
                }
            });
            return false;
        }
    });
});
$(document).on("click",".otp_submit", function ()
{
    $('#customer_otp').validate({
    rules: {
       cust_otp:
            {
            required: true,
            minlength:4,
            maxlength:4
            }
        },
        submitHandler: function (form)
        {
            $(".otp_submit").attr('disabled','disabled');
            $(".otp_submit").html("<i class='fa fa-clock-o fa-spin'></i> Wait..");
             var dataString ='method=profile_update&dataType=verify_otp&'+$('#customer_otp').serialize();
                $.ajax({
                    type: "POST",
                    url: "scripts/ajax/index.php",
                    dataType:'json',
                    data: dataString,
                    success:function(data, textStatus, XMLHttpRequest)
                    {
                        $(".otp_submit").removeAttr('disabled','disabled');
                        $(".otp_submit").html("Verify");
                        if(data.RESULT=="0")
                        {
                            $('#otp-modal').modal('hide');
                            $().toastmessage('showSuccessToast', data.MSG);
                            $('#add_customer_address').submit();
                        }
                        else
                        {
                            $().toastmessage('showErrorToast', data.MSG);
                        }
                    }
                }
            );
            return false;
        }
    });
});
$(document).on("click",".address_delete", function ()
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
      },
      function (r)
			{
				if(r == true)
				{
					$.ajax(
					{
						  type: "POST",
						  dataType: 'html',
						  url: "scripts/ajax/index.php",
						  data: "method=address_delete&id="+getid,
						  success: function(responseData)
						  {
								  if(responseData==0)
								  {
								  	$('.row_data_'+getid).remove();
										$().toastmessage('showSuccessToast', 'Delete Successfully !');
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
$(document).on("click",".cust_member_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=member_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		$('#ajax_modal_container').html(data);
		$('#modalform-add-member').modal('show');
	})
	.fail(function()
	{
		alert( "Try again." );
	});
});
$(document).on("click",".ajax_modal_submit_member", function ()
{
    $('#add_customer_members').validate({
		rules: {
        phone: {
            required: true,
			minlength:10,
			maxlength:10
        },
		  pincode: {
      required: true,
			minlength:6,
			maxlength:6
        },
        first_name: {
      required: true
        },
       last_name: {
      required: true
        },
        line1: {
      required: true
        }
		},
		submitHandler: function (form)
		{
			$('#eroormessage_add').hide();
			$('#suc_message_add').hide();
			$('.ajax_modal_submit_member').html('Wait...');
			var dataString ='method=add_customer_members&'+$('#add_customer_members').serialize();
			$.ajax({
			    dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
        success: function (responseData)
				{
						$('.ajax_modal_submit_member').html('Save');
					  if(responseData.RESULT==1)
						{
								$().toastmessage('showErrorToast', responseData.MSG);
						}
						else  if(responseData.RESULT==0)
						{
								if(parseInt(responseData.cartID)>0)
								{
									$('#modalform-add-member').modal('hide');
									cartItemMemberAssign(responseData.memberID,responseData.cartID);
								}
								else
								{
									$().toastmessage('showSuccessToast', responseData.MSG);
									$('#modalform-add-member').modal('hide');
									location.reload();
								}
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
$(document).on("click",".member_delete", function ()
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
      },
      function (r)
			{
				if(r == true)
				{
					$.ajax(
					{
						  type: "POST",
						  dataType: 'html',
						  url: "scripts/ajax/index.php",
						  data: "method=member_delete&id="+getid,
						  success: function(responseData)
						  {
								  if(responseData==0)
								  {
								  	$('.row_data_'+getid).remove();
										$().toastmessage('showSuccessToast', 'Delete Successfully !');
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
$(document).on("click",".cust_address_addedit_onclick", function ()
{
	getId=$(this).data("id");
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=address_addedit&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		$('#ajax_modal_container').html(data);
		$('#address-modal').modal('show');
	})
	.fail(function()
	{
		alert( "Try again." );
	});
});
$(document).on("click",".itemsDetails", function ()
{
	getId=$(this).data("id");
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=itemDetails&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		$('#ajax_modal_container').html(data);
		$('#offcanvasExample-package-details').offcanvas('show');
	})
	.fail(function()
	{
		alert( "Try again." );
	});
});
$(document).on("click",".ajax_modal_submit", function ()
{
    $('#add_customer_address').validate({
		rules: {
        phone: {
            required: true,
			minlength:10,
			maxlength:10
        },
		  zipcode: {
      required: true,
			minlength:6,
			maxlength:6
        },
        first_name: {
      required: true
        },
       last_name: {
      required: true
        },
        line1: {
      required: true
        }
		},
		submitHandler: function (form)
		{
			$('#eroormessage_add').hide();
			$('#suc_message_add').hide();
			$('.ajax_modal_submit').html('Wait...');
			var dataString ='method=add_customer_address&'+$('#add_customer_address').serialize();
			$.ajax({
			    dataType: 'json',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
        success: function (responseData)
				{
						$('.ajax_modal_submit').html('Save and Deliver Here');
					  if(responseData.RESULT==1)
						{
								$('#address-modal').modal('hide');
								$().toastmessage('showErrorToast', responseData.MSG);
						}
						else  if(responseData.RESULT==0)
						{
								$().toastmessage('showSuccessToast', responseData.MSG);
								$('#address-modal').modal('hide');
								location.reload();
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

function addtocart(item_id,item_price_id)
{
	$('.addToClass').attr("disabled", "disabled");
	var dataString ='method=add_to_cart&item_id='+item_id+'&quantity=1&item_price_id='+item_price_id;
	$.ajax(
	{
		type: "POST",
		url: "scripts/ajax/index.php",
		dataType:'json',
		data: dataString,
		success:function(data, textStatus, XMLHttpRequest){
			$('.addToClass').removeAttr("disabled", "disabled");
			if(data.RESULT=="1")
			{
				$().toastmessage('showSuccessToast', data.MSG);
				$(".cartCount").html(data.cartCount);
				if(data.items_o_html!='')
				{
					$(".pr_"+item_id).html(data.items_o_html);
				}
			}
			else
			{
				swal({ title: "Try Again...",
						  text: data.MSG,
						  type: "warning",
						   timer: 1000
						  });
						  return false;
			}
		}
	});
}


$(document).on("click",".pricing-table a.add_to_cart", function ()
{
	element = this;
	$(element).attr("disabled", "disabled");
	var item_id=$(element).data('item_id');
	var item_price_id=$(element).data('item_price_id');

	var dataString ='method=add_to_cart&item_id='+item_id+'&quantity=1&item_price_id='+item_price_id;
	$.ajax(
	{
		type: "POST",
		url: "scripts/ajax/index.php",
		dataType:'json',
		data: dataString,
		success:function(data, textStatus, XMLHttpRequest){
			$(element).removeAttr("disabled", "disabled");
			if(data.RESULT=="1")
			{
				$().toastmessage('showSuccessToast', data.MSG);
				$(".cartCount").html(data.cartCount);
				$(element).addClass('btncart-green');
				$(element).attr("href", "cart.html")
				$(element).parent('div').find('a.book-now').addClass('btn-green');
				$(element).parent('div').find('a.book-now').removeClass('btn-blue');
				$(element).parent('div').find('a.book-now').html('Added');
			}
			else
			{
				swal({ title: "Try Again...",
					text: data.MSG,
					type: "warning",
					timer: 1000
				});
				return false;
			}
		}
	});
});


$(document).on("click",".prescriptionOrderView", function ()
{
	getId=$(this).data("id");
	$.ajax({
	type: 'POST',
	url: 'scripts/modal/index.php?method=viewOrderPrescription&id='+getId,
	dataType : 'html',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		$('#ajax_modal_container').html(data);
		$('#modal-UploadPrescription-details').modal('show');
	})
	.fail(function()
	{
		alert( "Try again." );
	});
});
function show_suggestion(s)
 {
    var value = s.toLowerCase();
    $(".sCity li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }
function changeCity(id,page=null)
{
				//var page=$('.footer_changecity_'+id).data("page");
			 	var dataString ='method=changeCity&id='+id+'&page='+page;
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						if(data.RESULT=="OK")
						{
							if(data.URL!='')
							{
								location.href = data.URL;
							}
							else
							{
								location.reload();
							}
						}
						else
						{
							alert("Try Again.");
							location.reload();
						}
					}
				}
			);
            return false;
}
function changeHomeCollectionStatus(a)
{
			 	var dataString ='method=cart&actionType=cartItemCollectionStatus&status_type='+a;
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$('#modal-homeCollection').modal('hide');
						cartItems();
					}
				}
			);
            return false;
}
function changeHomeCollection()
{
				if($("input[name='home_collection']:checked").val()=='Yes')
				{
					var status_type='Yes';
				}
			 	else
				{
					var status_type='No';
				}
			 	var dataString ='method=cart&actionType=cartItemCollectionStatus&status_type='+status_type;
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
					}
				}
			);
            return false;
}
$(document).on("click",".radiologyCatClick", function ()
{
	getId=$(this).data("id");
	getName=$(this).data("name");
	$.ajax({
	type: 'POST',
	url: 'scripts/ajax/index.php?method=radiologyCatClick&getId='+getId+'&getName='+getName,
	dataType : 'json',
	data: $(this).serialize()
	})
	.done(function(data)
	{
		
		//location.href = 'radiology.html';
		location.href = data.URL;
	})
	.fail(function()
	{
		alert( "Try again." );
	});
});
$(document).on("click",".collection_appointment_btn", function ()
{
    $('#collection_appointment').validate({
		rules:
		{
			email: {
					required: true,
					email: true
			},
			name: {
					required: true,
			},
			phone: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$("#collection_appointment_btn").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'collection_appointment_inq');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$("#collection_appointment_btn").attr("disabled", false);
					if(responseData==0)
					{
						$('#collection_appointment_error_msg').html('<h5 class="text-center">Thank you for Collection Appointment! </h5>');
						$('#collection_appointment')[0].reset();
             		}
             		else
             		{
             			$('#collection_appointment_error_msg').html('<h5 class="text-center" style="color: #f00 !important;">Something went wrong !</h5>');
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
$(document).on("click",".job_opning_modal", function (){
	var job_opening_id = $(this).data('id');
	$('#job-opning-form-modal').modal('show');
	$('#job_opening_id').val(job_opening_id);
});
$(document).on("click",".job_opning_submit", function ()
{
    $('#job_opning_form').validate({
		rules:
		{
			email: {
					required: true,
					email: true
			},
			name: {
					required: true,
			},
			phone: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$("#job_opning_submit").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'job_opning_inq');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$("#job_opning_submit").attr("disabled", false);
					if(responseData==0)
					{
						$('#job_opning_error_msg').html('<h5 class="text-center">Thank you for Apply Job Opening! </h5>');
						$('#job_opning_form')[0].reset();
             		}
             		else
             		{
             			$('#job_opning_error_msg').html('<h5 class="text-center" style="color: #f00 !important;">Something went wrong !</h5>');
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



$(document).on("click",".get-call-back-submit", function ()
{
	element = this;
	var form_name = $(element).data('form');

   	$('#'+form_name).validate({
    rules: {
       name:
            {
            	required: true,
            },
            phone:
            {
            	required: true,
            },
            city:
            {
            	required: true,
            }
        },
        submitHandler: function (form)
        {
            $(element).attr('disabled','disabled');
            $(element).html("Wait.. <span class='circle'></span>");
             var dataString ='method=get_call_back_inq&'+$('#'+form_name).serialize();
                $.ajax({
                    type: "POST",
                    url: "scripts/ajax/index.php",
                    dataType:'json',
                    data: dataString,
                    success:function(data, textStatus, XMLHttpRequest)
                    {
                        $(element).removeAttr('disabled','disabled');
                        $(element).html("Submit <span class='circle'></span>");
                        if(data.RESULT=="1")
                        {
							$('.thankYouMessage').removeClass('d-none');
                            $().toastmessage('showSuccessToast', data.MSG);
                            $('#'+form_name)[0].reset();
                        }
                        else
                        {
                            $().toastmessage('showErrorToast', data.MSG);
                        }
                    }
                }
            );
            return false;
        }
    });
});

$(document).ready(function(){            
	if ($.cookie('MDRCCitySelect')) { //if cookie isset
	   
	} else {
		//$.cookie("MDRCCitySelect", "Yes", { expires: 1, secure: true , domain: 'mdrcindia.com'});
		//$('#modal-cities').modal('show');
	}       
});


$(document).on("click",".prescription_booking_btn", function ()
{
    $('#prescription_booking').validate({
		rules:
		{
			email: {
					required: true,
					email: true
			},
			name: {
					required: true,
			},
			phone: {
					required: true,
			},
		},
		submitHandler: function (form)
		{
			$(".prescription_booking_btn").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'test_booking_enquiry');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					turnstile.reset('.cf-turnstile');

					$(".prescription_booking_btn").attr("disabled", false);
					if(responseData==0)
					{
						$('#prescription_booking_error_msg').html('<h5 class="text-center">Thank you for Test Booking Enquiry ! </h5>');
						$('#prescription_booking')[0].reset();
             		}
             		else
             		{
             			$('#prescription_booking_error_msg').html('<h5 class="text-center" style="color: #f00 !important;">Refresh page and try again.</h5>');
             		}
                },
                error: function (responseData) {
                    console.log('Ajax request not recieved!');
					turnstile.reset('.cf-turnstile');
                }
            });
            return false;
        }
   });
});

$(document).ready(function ()
{
    $('#download_test_report').validate({
		rules: {
			lab_password:
			{
            required: true,
        	},
			lab_id: {
			required: true,
        	},
		},
		submitHandler: function (form)
		{
			$("#download_report_submit").attr('disabled','disabled');
			$("#no_report_found").html('');
			 var dataString ='method=download_test_report&'+$('#download_test_report').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#download_report_submit").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							//success
							if(data.URL!='')
							{
								window.open(data.URL);
							}
							$("#no_report_found").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						} else if(data.RESULT=="NO_REPORT")
						{
							$("#no_report_found").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
						else
						{
							$("#no_report_found").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});


$(document).ready(function ()
{
    $('#download_test_report_page').validate({
		rules: {
			lab_password_page:
			{
            required: true,
        	},
			lab_id_page: {
			required: true,
        	},
		},
		submitHandler: function (form)
		{
			$("#download_report_submit_page").attr('disabled','disabled');
			$("#no_report_found").html('');
			 var dataString ='method=download_test_report_page&'+$('#download_test_report_page').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#download_report_submit_page").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							//success
							// if(data.URL!='')
							// {
							// 	window.open(data.URL);
							// }
							if(data.table_html!="")
							{
								$('.result_html').show();
								$('.table_html').html(data.table_html);
							}
							if(data.button_html!="")
							{
								$('.button_html').html(data.button_html);
							}
							$('html, body').animate({
								scrollTop: parseInt($("#result_html").offset().top)-140
							}, 1000);

							$("#no_report_found_page").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						} else if(data.RESULT=="NO_REPORT")
						{
							$("#no_report_found_page").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
						else
						{
							$("#no_report_found_page").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});



$(document).ready(function ()
{
    $('#profile_popup_form').validate({
		rules: {
		email: {
            email: true,
        },
		},
		submitHandler: function (form)
		{
			$("#profile_popup_btn").attr('disabled','disabled');
			 var dataString ='method=profile_details&'+$('#profile_popup_form').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#profile_popup_btn").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							//$('#offcanvasExample-signup').offcanvas('hide');
							location.reload();
						}
						else
						{
							$('form#profile_popup_form').find("#msgSubmit").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});


$(document).ready(function ()
{
    $('#direct_order_pay').validate({
		rules: {
			pay_amount:
			{
            required: true,
        	},
			pay_email: {
			required: true,
        	},
		},
		submitHandler: function (form)
		{
			$("#direct_pay_order_btn").attr('disabled','disabled');
			 var dataString ='method=direct_order_pay&'+$('#direct_order_pay').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#direct_pay_order_btn").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							//$('#encRequest').val(data.paymentGateway.encRequest);
							//$('#access_code').val(data.paymentGateway.access_code);
							//$("#redirect").submit();

							var options = data.paymentGateway.json;

							options.handler = function(response) {
								document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
								document.getElementById('razorpay_signature').value = response.razorpay_signature;
								document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
								document.razorpayform.submit();
							};
							options.theme.image_padding = false;
							options.modal = {
								ondismiss: function() {
									console.log("This code runs when the popup is closed");
								},
								escape: true,
								backdropclose: false
							};
							var rzp = new Razorpay(options);
							rzp.open();
							// document.getElementById('rzp-button1').onclick = function(e) {
							// 	rzp.open();
							// 	e.preventDefault();
							// }
						} 
						else
						{
							$("#error_pay").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});

$(document).ready(function ()
{
    $('#tracking-details-verify-form').validate({
		submitHandler: function (form)
		{
			$("#tracking-details-submit").attr('disabled','disabled');
			$("#tracking-details-invalid").html('');
			 var dataString ='method=orderCustomerMemeberStatus&'+$('#tracking-details-verify-form').serialize();
				$.ajax(
				{
					type: "POST",
					url: "scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#tracking-details-submit").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							$('#offcanvasExample-tracking-details-verify').offcanvas('hide');
							var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample-tracking-details'));
    						bsOffcanvas.show();
							$('.order-track-detail-html').html(data.HTML);
						}
						else
						{
							$("#tracking-details-invalid").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.MSG+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
						}
					}
				}
			);
            return false;
        }
    });
});

function callOrderCustomerStatus(orderID,orderCustomerMemeberID)
{
	if(orderID!='' && orderCustomerMemeberID!='')
	{
		var dataString ='method=orderCustomerMemeberStatus&orderID='+orderID+'&orderCustomerMemeberID='+orderCustomerMemeberID;
		$.ajax(
		{
			type: "POST",
			url: "scripts/ajax/index.php",
			dataType:'json',
			data: dataString,
			success:function(data, textStatus, XMLHttpRequest){
				if(data.RESULT=="AskPassword")
				{
					var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample-tracking-details-verify'));
    				bsOffcanvas.show();
					$('#track-orderID').val(orderID);
					$('#track-orderCustomerMemeberID').val(orderCustomerMemeberID);
				}
				else if(data.RESULT=="OK")
				{
					var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample-tracking-details'));
    				bsOffcanvas.show();
					$('.order-track-detail-html').html(data.HTML);
				}
				else
				{
					var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample-tracking-details'));
    				bsOffcanvas.show();
					$('.order-track-detail-html').html(data.HTML);
				}
			}
		}
		);
	}
}

$(document).on("click",".corporate_tieup_btn", function ()
{
	$('#corporate_tieup_success_msg').html('');
	$('#corporate_tieup_error_msg').html('');
    $('#corporate_tieup').validate({
		submitHandler: function (form)
		{
			$(".corporate_tieup_btn").attr("disabled", true);
			var dataString = new FormData(form);
			dataString.append('method', 'corporate_tieup_enquiry');
			$.ajax({
                dataType: 'html',
                type: "POST",
				url: "scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$(".corporate_tieup_btn").attr("disabled", false);
					if(responseData==0)
					{
						$('#corporate_tieup_success_msg').html('<h5 class="text-center text-white">Thank you for inquiry.</h5>');
						$('#corporate_tieup')[0].reset();
             		}
             		else
             		{
             			$('#corporate_tieup_error_msg').html('<h5 class="text-center" style="color: #f00 !important;">Refresh page and try again.</h5>');
             		}
                },
                error: function (responseData) {
                    console.log('error');
                }
            });
            return false;
        }
   });
});


