<!-- Start: Admin Forgot Password -->
$(document).ready(function ()
{
    $('#adminForgotForm').validate({
		submitHandler: function (form)
		{
			$('.adminForgotSubmit').html('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> Loading...');
			$(".adminForgotSubmit").attr("disabled", true);
			var dataString ='method=admin&actionType=adminForgotPass&'+$('#adminForgotForm').serialize();
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
						$("#modal2").modal("hide");
					}
					else
					{
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
					}
					$('.adminForgotSubmit').html('Submit');
					$(".adminForgotSubmit").attr("disabled", false);
				},
                error: function (responseData) 
				{
					$('.adminForgotSubmit').html('Submit');
					$(".adminForgotSubmit").attr("disabled", false);
                    console.log('Ajax request not recieved!');
                }
            });
			
			return false;
        }
    });
});
<!-- End: Admin Forgot Password -->


<!-- Start: Admin Login -->
$(document).ready(function ()
{
    $('#adminLoginForm').validate({
		submitHandler: function (form)
		{
			$('.adminLoginSubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
			$(".adminLoginSubmit").attr("disabled", true);
			var dataString ='method=admin&actionType=adminLogin&'+$('#adminLoginForm').serialize();
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
						location.href = 'index.php?view=home';
					}
					else
					{
						$('.adminLoginSubmit').html('Sign In');
						$(".adminLoginSubmit").attr("disabled", false);
						$.bootstrapGrowl('<h4><strong>Notification</strong></h4> <p>'+responseData.msg+'</p>', {type:'danger',delay: 3000,allow_dismiss: true,offset: {from: 'top', amount: 20} });
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
<!-- End: Admin Login -->


