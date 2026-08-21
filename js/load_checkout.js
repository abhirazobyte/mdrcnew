cartItems();
//general function call evrytime
function cartItems() {
  $(".cartError").html("");
  $.ajax({
    type: "POST",
    url: "scripts/ajax/index.php",
    dataType: "json",
    data: "method=checkout&actionType=cartItems",
    cache: false,
    success: function (data) {
      if (data.RESULT == "OK") {
        $(".sub_total").html(
          '<i class="fas fa-rupee-sign"></i>' + data.subtotal,
        );
        $(".CartItems").html(data.html);
        $(".HomeCollection").html(data.homeCollectionHtml);
        if (data.step_third_heading != "") {
          $("#step3_heading").html(data.step_third_heading);
        }
      } else {
        cartItems();
      }
    },
  });
}
$(document).on("click", ".prescriptionView", function () {
  getId = $(this).data("id");
  $.ajax({
    type: "POST",
    url: "scripts/modal/index.php?method=viewPrescription&id=" + getId,
    dataType: "html",
    data: $(this).serialize(),
  })
    .done(function (data) {
      $("#ajax_modal_container").html(data);
      $("#modal-UploadPrescription-details").modal("show");
    })
    .fail(function () {
      alert("Try again.");
    });
});
$("#homeAddressSelectForm").validate({
  rules: {
    item: {
      required: true,
      minlength: 5,
      maxlength: 5,
    },
  },
  submitHandler: function (form) {
    //$('.item_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
    $(".homeAddressError").html("");
    $(".homeAddressBtn").attr("disabled", true);
    var dataString = new FormData(form);
    dataString.append("method", "checkout");
    dataString.append("actionType", "homeAddressSelect");
    $.ajax({
      dataType: "json",
      type: "POST",
      url: "scripts/ajax/index.php",
      data: dataString,
      cache: false,
      contentType: false,
      processData: false,
      success: function (responseData) {
        //$('.item_modal_submit').html('Submit');
        $(".homeAddressBtn").attr("disabled", false);
        if (responseData.RESULT == 0) {
          $("#collapseNEw").removeClass("show");
          $(".collapseNEw").addClass("collapsed");
          if (responseData.payment_option == "Yes") {
            $("#collapseFour").addClass("show");
            $(".collapseFour").removeClass("collapsed");
          } else {
            $("#collapseThree").addClass("show");
            $(".collapseThree").removeClass("collapsed");
          }
        } else {
          //$(".errorDiv").html(responseData.msg);
          $(".homeAddressError").html(
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
              responseData.MSG +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
          );
        }
      },
      error: function (responseData) {
        console.log("Ajax request not recieved!");
      },
    });
    return false;
  },
});
$("#labSelectForm").validate({
  rules: {
    item: {
      required: true,
      minlength: 5,
      maxlength: 5,
    },
  },
  submitHandler: function (form) {
    //$('.item_modal_submit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
    $(".labSelectionError").html("");
    $(".labSelectionBtn").attr("disabled", true);
    var dataString = new FormData(form);
    dataString.append("method", "checkout");
    dataString.append("actionType", "labSelection");
    $.ajax({
      dataType: "json",
      type: "POST",
      url: "scripts/ajax/index.php",
      data: dataString,
      cache: false,
      contentType: false,
      processData: false,
      success: function (responseData) {
        //$('.item_modal_submit').html('Submit');
        $(".labSelectionBtn").attr("disabled", false);
        if (responseData.RESULT == 0) {
          $("#collapseThree").removeClass("show");
          $(".collapseThree").addClass("collapsed");
          $("#collapseFour").addClass("show");
          $(".collapseFour").removeClass("collapsed");
        } else {
          //$(".errorDiv").html(responseData.msg);
          $(".labSelectionError").html(
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
              responseData.MSG +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
          );
        }
      },
      error: function (responseData) {
        console.log("Ajax request not recieved!");
      },
    });
    return false;
  },
});
function WalletSelection() {
  var MainWallet = $("input[name='MDRCwallet']:checked").val();
  var PromoWallet = $("input[name='MDRCwalletPromo']:checked").val();
  show_order_total_calculation(MainWallet, PromoWallet);
}
function show_order_total_calculation(MainWallet, PromoWallet) {
  //$('.order_total_calculation').html('');
  $.ajax({
    type: "POST",
    url:
      "scripts/modal/index.php?method=checkout_order_total_calculation&MainWallet=" +
      MainWallet +
      "&PromoWallet=" +
      PromoWallet,
    dataType: "json",
    data: $(this).serialize(),
  })
    .done(function (data) {
      // show the response
      $(".order_total_calculation").html(data.RESULT);
      //$.getScript("js/custom/load_temp_js.js");
    })
    .fail(function () {
      // just in case posting your form failed
      alert("Try again.");
    });
}
function SelectPayMethod(payMethod) {
  $(".error_div").html("");
  $.ajax({
    type: "POST",
    url:
      "scripts/modal/index.php?method=checkout_payment_method_selection&payMethod=" +
      payMethod,
    dataType: "json",
    data: $(this).serialize(),
  })
    .done(function (data) {
      if (data.RESULT == 0) {
		if(data.show_coupon=='Yes'){
			$('.couponinfo').show();
		}else{
			$('.couponinfo').hide();
		}
		if(data.show_wallet=='Yes'){
			$('.walletinfo').show();
		}else{
			$('.walletinfo').hide();
		}
		if(data.show_min_price=='Yes')
		{
			$('.min_price_info').show();
		}
		else
		{
			$('.min_price_info').hide();
		}
      } else {
        $(".error_div").html(
          '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
            data.error_msg +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
        );
      }
      //$.getScript("js/custom/load_temp_js.js");
    })
    .fail(function () {
      // just in case posting your form failed
      alert("Try again.");
    });
}
$(document).on("click", ".PlaceOrderBtn", function () {
  //$('.final_place_btn').html('Wait..');
  $(".PlaceOrderBtn").prop("disabled", true);
  $(".error_div").html("");
  $("#CheckoutDiv").html("");
  $.ajax({
    type: "POST",
    url: "scripts/modal/index.php?method=checkout_order_data_check",
    dataType: "json",
    data: $(this).serialize(),
  })
    .done(function (data) {
      if (data.RESULT == 0) {
        $("#CheckoutForm").submit();
      } else {
        $("#CheckoutDiv").html(
          '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
            data.error_msg +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
        );
        $(".PlaceOrderBtn").prop("disabled", false);
      }
      //$.getScript("js/custom/load_temp_js.js");
    })
    .fail(function () {
      // just in case posting your form failed
      alert("Try again.");
    });
});
$(document).on("click", ".couponModal", function () {
  getId = $(this).data("id");
  $.ajax({
    type: "POST",
    url: "scripts/modal/index.php?method=checkout_coupon_data&id=" + getId,
    dataType: "html",
    data: $(this).serialize(),
  })
    .done(function (data) {
      $("#ajax_modal_container").html(data);
      $("#coupon-modal").modal("show");
    })
    .fail(function () {
      alert("Try again.");
    });
});
$(document).on("click", ".appyCouponBtn", function () {
  $(".error_div").html("");
  var coupon_code = $("input[name='coupon-check']:checked").val();
  $(".appyCouponBtn").prop("disabled", true);
  $("#appyCouponBtn").prop("disabled", true);
  if (coupon_code == undefined) {
    $(".appyCouponBtn").prop("disabled", false);
    $("#appyCouponBtn").prop("disabled", false);
    $("#ListCouponDiv").html(
      '<p class="alert alert-danger border-0 p-3 pl-5 rounded fs__12"><i class="las la-bell fs__22 mr-2 position-absolute top-15 left-15 text-dark"></i> Please Select Coupon.</p>',
    );
  } else {
    apply_coupon(coupon_code, "ListCouponDiv");
  }
});
$(document).on("click", "#appyCouponBtn", function () {
  $("#promo_code_form").validate({
    submitHandler: function (form) {
      $(".appyCouponBtn").prop("disabled", true);
      $("#appyCouponBtn").prop("disabled", true);
      var coupon_code = $("#coupon_code").val();
      apply_coupon(coupon_code, "CustomCouponDiv");
    },
  });
});
function apply_coupon(code, div) {
  $(".error_div").html("");
  $.ajax({
    type: "POST",
    url: "scripts/modal/index.php?method=checkout_coupon_apply&code=" + code,
    dataType: "json",
    data: $(this).serialize(),
  })
    .done(function (data) {
      $(".appyCouponBtn").prop("disabled", false);
      $("#appyCouponBtn").prop("disabled", false);
      if (data.RESULT == 0) {
        var MainWallet = $("input[name='MDRCwallet']:checked").val();
        var PromoWallet = $("input[name='MDRCwalletPromo']:checked").val();
        show_order_total_calculation(MainWallet, PromoWallet);
        $(".promo_success").html(data.promo_success);
        $("#coupon-modal").modal("hide");
        $(".promo_apply").hide();
      } else {
        $(".promo_success").html("");
        if (div == "CustomCouponDiv") {
          $("#" + div).html(data.error_msg);
        } else {
          $("#" + div).html(
            '<p class="alert alert-danger border-0 p-3 pl-5 rounded fs__12"><i class="las la-bell fs__22 mr-2 position-absolute top-15 left-15 text-dark"></i> ' +
              data.error_msg +
              "</p>",
          );
        }
        var MainWallet = $("input[name='MDRCwallet']:checked").val();
        var PromoWallet = $("input[name='MDRCwalletPromo']:checked").val();
        show_order_total_calculation(MainWallet, PromoWallet);
      }
    })
    .fail(function () {
      // just in case posting your form failed
      alert("Try again.");
    });
}
function remove_coupon_code() {
  $(".promo_error").html("");
  $(".promo_success").html("");
  $.ajax({
    type: "POST",
    url: "scripts/modal/index.php?method=checkout_coupon_apply&code=REMOVE11",
    dataType: "json",
    data: $(this).serialize(),
  })
    .done(function (data) {
      $(".promo_apply").show();
      if (data.RESULT == 0) {
        var MainWallet = $("input[name='MDRCwallet']:checked").val();
        var PromoWallet = $("input[name='MDRCwalletPromo']:checked").val();
        show_order_total_calculation(MainWallet, PromoWallet);
      } else {
        var MainWallet = $("input[name='MDRCwallet']:checked").val();
        var PromoWallet = $("input[name='MDRCwalletPromo']:checked").val();
        show_order_total_calculation(MainWallet, PromoWallet);
      }
    })
    .fail(function () {
      // just in case posting your form failed
      alert("Try again.");
    });
}
