<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/dashforge.auth.css">
<link href="lib/select2/css/select2.min.css" rel="stylesheet">
<!-- DashForge CSS -->
<link rel="stylesheet" href="assets/css/dashforge.css">
<link rel="stylesheet" href="assets/css/dashforge.demo.css">
<!-- Skin CSS -->
<link rel="stylesheet" href="assets/css/skin.cool.css">
<!--<link rel="stylesheet" href="assets/css/skin.charcoal.css">-->
<!--Sweet Alert CSS & JS -->
<link href="lib/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- file upload  -->
<link href="lib/bootstrap-file/css/fileupload.css" rel="stylesheet" type="text/css" />
<!--image popup -->
<link href="lib/magnific-popup/css/magnific-popup.css" rel="stylesheet" type="text/css" />
<!-- new added by developer -->
<link rel="stylesheet" href="assets/css/custom.css">
<style>
.scrollbox {
	overflow-y: scroll;
	max-height: 220px;
	border: 1px solid #dae0e8;
}
.even {
	margin-left: 20px;
}
.price_varient {
	padding:0;
	margin:0;
}
</style>
<?php include('includes/menu.php');?>
<div class="content ht-100v pd-0">
  <?php include('includes/header.php');?>
  <!-- content-header -->
  <div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="#">SYSTEM SETTING</a></li>
              <li class="breadcrumb-item active" aria-current="page">Meta Settings </li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">
            <?=$this->to_do?>
            <?=$this->manage_for?>
          </h4>
        </div>
        <div class="d-none d-md-block"> </div>
      </div>
      <?=$this->utility->get_message()?>
      <? $this->htmlBuilder->buildTag("form", array("action"=>"","data-parsley-validate"=>"","class"=>"form-horizontal form-bordered form-validate"), "frm_profile");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"update_data"), "act");?>
      <div class="row">
        <div class="col-lg-12">
          <div data-label="" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Title <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","required"=>""), "title") ?>
            </div>
            
            <div class="form-group">
              <label class="d-block">Keyword</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control"), "keyword") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Description</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control"), "description") ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4" style="display:none">
          <div data-label="" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Image</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new" >
                  <?php $img='../uploads/staff/'.$this->rscat['image']; ?>
                  <img src="<?=$img;?>" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "image") ?>
                  </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mg-t-15">
        <div class="col-lg-12">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </div>
      </form>
      <?php include('includes/footer.php');?>
    </div>
    <!-- container -->
  </div>
</div>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/feather-icons/feather.min.js"></script>
<script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="lib/prismjs/prism.js"></script>
<script src="lib/parsleyjs/parsley.min.js"></script>
<script src="lib/select2/js/select2.min.js"></script>
<script src="assets/js/dashforge.aside.js"></script>
<script src="assets/js/dashforge.js"></script>
<!-- other include -->
<script src="lib/alert/js/sweet-alert.min.js"></script>
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
<script>
	  function show_suggestion(s)
 {
    var value = s.toLowerCase();
    $(".scrollbox .even").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  }
	 </script>
<script>
function add_attr_fields()
{
	var tabname_rows=$("#tabname_1").html();
	var tabqty_rows=$("#tabqty_1").html();
	var tabmember=$("#tabsq").html();
	var total_rows=$("#use_rows tr").length;
	var row_id=parseInt(total_rows)+1;
	var html_table_row='<tr id="row_'+row_id+'">';
	
	html_table_row+='<td> <input type="text"id="mrp_'+row_id+'" name="mrps[]" class="form-control span12"  /></td>';
	html_table_row+='<td> <input type="text"id="rprice_'+row_id+'" name="rprices[]" class="form-control span12 required number"  /> </td>';
	html_table_row+='<td> <input type="text"id="d_weights_'+row_id+'" name="d_weights[]" class="form-control span12"  /> </td>';
	html_table_row+='<td> <input type="text"id="rweight_'+row_id+'" name="weights[]" class="form-control numbersOnly span12 required number"  /> </td>';
	html_table_row+='<td> <input type="text"id="rstock_'+row_id+'" name="stocks[]" class="form-control numbersOnly span12 required number"  /> </td>';
	html_table_row+='<td> <input type="text"id="astock_'+row_id+'" name="alertstocks[]" class="form-control numbersOnly span12 required number"  /> </td>';
	html_table_row+='<td> <a class="btn btn-sm btn-danger" href="javascript:remove_user_row('+row_id+')"> <i class="icon-remove"></i>  <strong>X</strong> </a></td>';
	html_table_row+='</tr>';
	$('#use_rows tr:last').after(html_table_row);
	  jQuery(document).ready(function($) {
	});
	 remove_error_class();
}

</script>
<script>
/*ON BLUR REMOVING ERROR*/
function remove_error_class()
{
	jQuery('.required').blur(function(){
		if($(this).hasClass("email"))
		{
				if($(this).val()!="")
				 {
						var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
						 if( !emailReg.test($(this).val()))
						 {
								$(this).parent().addClass('has-error');
						}
						else
						{
						$(this).parent().removeClass('has-error');
						}
			  }
			  else
			 {
			 $(this).parent().addClass('has-error');
			 }
		}
		else if($(this).hasClass("number"))
		{
				if($(this).val()!="")
				{
						var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
						if(!numberRegex.test($(this).val()))
						{
							$(this).parent().addClass('has-error');
						}
						else
						{
								$(this).parent().removeClass('has-error');
						}
				}
				else
				{
					$(this).parent().addClass('has-error');
				}
		}
		else if($(this).val()=="")
		{
		$(this).parent().addClass('has-error');
		}
		else
		{
		$(this).parent().removeClass('has-error');
		}
	 });
}
$(document).ready(function() {
    remove_error_class();
});
/*ON BLUR REMOVING ERROR*/
function remove_user_row(del_id)
	{
	var row_id="row_"+del_id;
	$("#"+row_id).remove();
	get_total();
    }
	function remove_user_row1(del_id)
	{
	var row_id="row_"+del_id;
	$("#"+row_id).remove();
	 get_total();
    }
	
	
	
$(document).on("click",".record_delete_attribute_onclick", function () 

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

							  url: "scripts/ajax_module/index.php",

							  data: "method=product_module&action=product_option_delete&tableid="+tableid+"&getid="+getid+"&tablename="+tablename,

							  success: function(data)

							  {

								  if(data.RESULT==0)

								  {

									  

									  

										
										$('.rowd_'+getid).html('');

										

									  

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
</script>
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/grocery.js"></script>
<!-- ckeditor -->
<script src="lib/editor/ckeditor/ckeditor.js"></script>
