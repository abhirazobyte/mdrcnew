$(document).on("click", ".loginModal", function () {
    var dataString = new FormData();
    dataString.append('method', 'checkLogin');
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: "scripts/ajax/index.php",
        data: dataString,
        cache: false,
        contentType: false,
        processData: false,
        success: function (responseData) {
            if (responseData.RESULT == 1) {
                var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('login'));
                bsOffcanvas.show();
            } else {
                location.reload();
            }
        },
        error: function (responseData) {
            console.log('Ajax request not recieved!');
        }
    });
    return false;
});

$(document).on("click", ".changeCityClick", function () {
    var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('cityPopup'));
    bsOffcanvas.show();
});



$('.login_f_data').keypress(function (e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
        $("#loginpopup_submit").trigger('click');
        return false;
    }
});

$(document).ready(function () {
    $('#signin_popup_form').validate({
        rules: {
            phone:
            {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                email: true,
            },
        },
        submitHandler: function (form) {
            $("#loginpopup_submit").attr('disabled', 'disabled');
            $("#invalid_login").html('');
            var dataString = 'method=login&' + $('#signin_popup_form').serialize();
            $.ajax(
                {
                    type: "POST",
                    url: "../scripts/ajax/index.php",
                    dataType: 'json',
                    data: dataString,
                    success: function (data, textStatus, XMLHttpRequest) {
                        $("#loginpopup_submit").removeAttr('disabled', 'disabled');
                        if (data.RESULT == "OK") {
                            $('#login').offcanvas('hide');
                            $('#otpverify').offcanvas('show');
                            $(".signup_login_phone").html(data.signup_login_phone);
                            $("#resend_otp_p").attr('disabled', 'disabled');
                            claimcountdown();
                        }
                        else {
                            $("#invalid_login").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data.MSG + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                    }
                }
            );
            return false;
        }
    });
});

$(document).ready(function () {
    $('#otp_popup_form').validate({
        submitHandler: function (form) {
            $("#otppopup_submit").attr('disabled', 'disabled');
            $("#invalid_otp").html('');
            var dataString = 'method=login&' + $('#otp_popup_form').serialize();
            $.ajax(
                {
                    type: "POST",
                    url: "../scripts/ajax/index.php",
                    dataType: 'json',
                    data: dataString,
                    success: function (data, textStatus, XMLHttpRequest) {
                        $("#otppopup_submit").removeAttr('disabled', 'disabled');
                        if (data.RESULT == "OK") {
                            $().toastmessage('showSuccessToast', data.MSG);
                            location.reload();
                        }
                        else {
                            $("#invalid_otp").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data.MSG + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $("#otppopup_submit").val("Verify OTP");
                        }
                    }
                }
            );
            return false;
        }
    });
});

$('#resend_otp_p').click(function () {
    $('#invalid_otp').html('');
    $("#resend_otp_p").attr('disabled', 'disabled');
    $('#resend_otp_p').html("<i class='fa fa-clock-o fa-spin' style='margin:0'></i> Wait..");
    jQuery.ajax({
        url: '../scripts/ajax/index.php',
        type: 'post',
        dataType: 'json',
        data: 'method=login&action_type=resend_otp',
        success: function (data, textStatus, XMLHttpRequest) {
            if (data.RESULT == "OK") {
                $("#invalid_otp").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + data.MSG + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#resend_otp_p').html('Resend OTP');
                claimcountdown();
            }
            else {
                $("#invalid_otp").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data.MSG + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#resend_otp_p').html('Resend OTP');
                $('#success_otp').html('');
                $("#resend_otp_p").removeAttr('disabled', 'disabled');
            }
        }
    });
    return false;
});

function claimcountdown() {
    var seconds = 10;
    function tick2() {
        var counter = document.getElementById("claim_counter");
        seconds--;
        counter.innerHTML = "00:" + (seconds < 10 ? "0" : "") + String(seconds);
        if (seconds > 0) {
            setTimeout(tick2, 1000);
        } else {
            timedOut2();
        }
    }
    tick2();
}

function timedOut2() {
    $("#resend_otp_p").removeAttr('disabled', 'disabled');
    $("#claim_counter").html('');
}

$(document).ready(function () {
    $('#profile_popup_form').validate({
        rules: {
            email: {
                email: true,
            },
        },
        submitHandler: function (form) {
            $("#profile_popup_btn").attr('disabled', 'disabled');
            var dataString = 'method=profile_details&' + $('#profile_popup_form').serialize();
            $.ajax(
                {
                    type: "POST",
                    url: "../scripts/ajax/index.php",
                    dataType: 'json',
                    data: dataString,
                    success: function (data, textStatus, XMLHttpRequest) {
                        $("#profile_popup_btn").removeAttr('disabled', 'disabled');
                        if (data.RESULT == "OK") {
                            location.reload();
                        }
                        else {
                            $('form#profile_popup_form').find("#msgSubmit").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data.MSG + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                    }
                }
            );
            return false;
        }
    });
});

function show_suggestion(s) {
    var value = s.toLowerCase();
    $(".sCity li").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}

function m_show_suggestion(s) {
    var value = s.toLowerCase();
    $(".sCity a").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}

function changeCity(id, page = null) {
    var dataString = 'method=changeCity&id=' + id + '&page=' + page;
    $.ajax(
        {
            type: "POST",
            url: "../scripts/ajax/index.php",
            dataType: 'json',
            data: dataString,
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.RESULT == "OK") {
                    if (data.URL != '') {
                        //location.href = data.URL.replace("https://www.mdrcindia.com", "https://www.mdrcindia.com/m");
                        location.href = "https://www.mdrcindia.com";
                    }
                    else {
                        location.reload();
                    }
                }
                else {
                    alert("Try Again.");
                    location.reload();
                }
            }
        }
    );
    return false;
}

$(document).on("click",".MDRC-TEST a.add_to_cart", function ()
{
	element = this;
	$(element).attr("disabled", "disabled");
	var item_id=$(element).data('item_id');
	var item_price_id=$(element).data('item_price_id');

	var dataString ='method=add_to_cart&item_id='+item_id+'&quantity=1&item_price_id='+item_price_id;
	$.ajax(
	{
		type: "POST",
		url: "../scripts/ajax/index.php",
		dataType:'json',
		data: dataString,
		success:function(data, textStatus, XMLHttpRequest){
			$(element).removeAttr("disabled", "disabled");
			if(data.RESULT=="1")
			{
				$().toastmessage('showSuccessToast', data.MSG);
				$(".cartCount").html(data.cartCount);
                if ($(".cartLineTotal")[0]){
                $(".cartLineTotal").html(data.cartLineTotal);
                }
				$(element).attr("href", "cart")
				$(element).addClass('th-btn-green');
				$(element).removeClass('th-btn-solid-sm');
				$(element).html('<img src="assets/images/mdrc/icons/shopping-cart-white.svg" alt="" class="me-1"> Added');
                if(data.cartCount>0) {
                    $(".msite_cart").show();
                } else {
                    $(".msite_cart").hide();
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
});


$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$("input.numbers").keypress(function(event) {
	return /\d/.test(String.fromCharCode(event.keyCode));
});

if ($("#searchMobileInput")[0]){
$( function() {
    $( "#searchMobileInput" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "../scripts/ajax/index.php",
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
                url: "../scripts/ajax/index.php",
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
		//$('#modal-UploadPrescription-details').modal('show');
        var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('orderPrescriptionImg'));
        bsOffcanvas.show();
	})
	.fail(function()
	{
		alert( "Try again." );
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
			url: "../scripts/ajax/index.php",
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
					url: "../scripts/ajax/index.php",
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

function changeHomeCollectionStatus(a)
{
    var dataString ='method=cart&actionType=cartItemCollectionStatus&status_type='+a;
    $.ajax(
    {
        type: "POST",
        url: "../scripts/ajax/index.php",
        dataType:'json',
        data: dataString,
        success:function(data, textStatus, XMLHttpRequest){
            $('#modal-homeCollection').modal('hide');
            cartItems();
        }
    });
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
        url: "../scripts/ajax/index.php",
        dataType:'json',
        data: dataString,
        success:function(data, textStatus, XMLHttpRequest){
        }
    });
    return false;
}

$(document).on("click",".job_opning_modal", function (){
	var job_opening_id = $(this).data('id');
	$('#job_opening_id').val(job_opening_id);
    var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('job-opning-form-modal'));
    bsOffcanvas.show();
});

$(document).on("click",".bookATestMdrc", function (){
    var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('bookATestMdrc-offcanvas'));
    bsOffcanvas.show();
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
				url: "../scripts/ajax/index.php",
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
				url: "../scripts/ajax/index.php",
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
        var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('modalform-add-member'));
        bsOffcanvas.show();
		//$('#modalform-add-member').modal('show');
	})
	.fail(function()
	{
		alert( "Try again." );
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
						  url: "../scripts/ajax/index.php",
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
				url: "../scripts/ajax/index.php",
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
                                    $('#modalform-add-member').offcanvas('hide');
									//$('#modalform-add-member').modal('hide');
									cartItemMemberAssign(responseData.memberID,responseData.cartID);
								}
								else
								{
                                    $('#modalform-add-member').offcanvas('hide');
									$().toastmessage('showSuccessToast', responseData.MSG);
									//$('#modalform-add-member').modal('hide');
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
				url: "../scripts/ajax/index.php",
				data: dataString,
				cache:false,
          	  	contentType: false,
           	 	processData: false,
	 			success: function (responseData)
				{
					$(".prescription_booking_btn").attr("disabled", false);
					if(responseData==0)
					{
						$('#prescription_booking_error_msg').html('<h5 class="text-center">Thank you for Test Booking Enquiry ! </h5>');
						$('#prescription_booking')[0].reset();
             		}
             		else
             		{
             			$('#prescription_booking_error_msg').html('<h5 class="text-center" style="color: #f00 !important;">Something went wrong !</h5>');
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
					url: "../scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#download_report_submit_page").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
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
        location.href = 'search/'+cityUrl+'/'+searchKeyword+'';
    }
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
                    url: "../scripts/ajax/index.php",
                    dataType:'json',
                    data: dataString,
                    success:function(data, textStatus, XMLHttpRequest)
                    {
                        $(element).removeAttr('disabled','disabled');
                        $(element).html("Submit <span class='circle'></span>");
                        if(data.RESULT=="1")
                        {
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
				url: "../scripts/ajax/index.php",
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
					url: "../scripts/ajax/index.php",
					dataType:'json',
					data: dataString,
					success:function(data, textStatus, XMLHttpRequest){
						$("#direct_pay_order_btn").removeAttr('disabled','disabled');
						if(data.RESULT=="OK")
						{
							$('#encRequest').val(data.paymentGateway.encRequest);
							$('#access_code').val(data.paymentGateway.access_code);
							$("#redirect").submit();
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

