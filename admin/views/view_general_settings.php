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
              <li class="breadcrumb-item"><a href="#">System Settings</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                <?=$this->manage_for?>
              </li>
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
      <? $this->htmlBuilder->buildTag("form", array("action"=>"","data-parsley-validate"=>"","class"=>"form-horizontal form-bordered form-validate"), "frm_generel_settings");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"update_data"), "act");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->rs_data['free_product_id']), "free_product_id");?>        
            
        <div class="row">
        <div class="col-lg-12">    
              
          <div data-label="General Settings" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Business Title</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$this->rs_data['project_title']), "project_title") ?>
                </div>
              </div>
              
             <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Business Mail Header</label>
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new" >
                      <?php $img='../uploads/project_image/'.$this->rs_data['logo']; ?>
                      <img src="<?=$img;?>" class="up_img"> </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "logo1") ?>
                      </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
                  </div>
                </div>
            </div>
            
            
            
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Website</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$this->rs_data['website']), "website") ?>
                </div>
                
                
              </div>
              
              <div class="col-lg-12">
              
              
                <div class="form-group">
                  <label class="" for="example-email">Invoice Footer Text</label>
                  <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control","value"=>$this->rs_data['order_invoice_msg']), "order_invoice_msg") ?>
                </div>
              </div>
             </div>
             </div> 
              
            
            
          
          
   
           <div data-label="Contact Us & Social Information" class="df-example demo-forms">
            <div class="row">
            
            
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Facebook Link </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "facebook_link") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Linkedin Link </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "linkedin_link") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Twitter Link </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "twitter_link") ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Instagram Link </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "instagram_link") ?>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Pinterest Link </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "pinterest_link") ?>
                </div>
              </div>
            
              
              
              
              
              
              
              
              
              
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label" for="example-email">Contact number </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly number"), "contact_number") ?>
                </div>
              </div>
              
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label" for="example-email">Whatsapp number </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control numbersOnly number"), "contact_number1") ?>
                </div>
              </div>
              
              
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label" for="example-email">Email </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "contact_email") ?>
                </div>
              </div>
              
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label" for="example-email">Email 2 </label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "contact_email1") ?>
                </div>
              </div>

               <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label" for="example-email">Time</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "time") ?>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Display Coupon Code</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control"), "display_coupon_code") ?>
                </div>
              </div>
              
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Feedback Text</label>
                  <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control"), "feedback_msg") ?>
                </div>
              </div>

               <div class="col-lg-12">
                <div class="form-group">
                  <label class="" for="example-email">Contact  Text</label>
                  <? $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control"), "contact_text") ?>
                </div>
              </div>
              
              
            </div>
            </div>
            


             <div data-label="" class="df-example demo-forms">
            <div class="row">
            
            
            
     
            
            
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Notification Email</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$this->rs_data['notification_email']), "notification_email") ?>
                </div>
              </div>
              

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Notification Email CC</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$this->rs_data['notification_email_cc']), "notification_email_cc") ?>
                </div>
              </div>
              

            
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="" for="example-email">Notification Phone Number</label>
                  <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control","value"=>$this->rs_data['notification_phone']), "notification_phone") ?>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Home Image</label>
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new" >
                      <?php $img_home='../uploads/home/'.$this->rs_data['home_image']; ?>
                      <img src="<?=$img_home;?>" class="up_img"> </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "form_home_image") ?>
                      </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="d-block">Home Image 2</label>
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new" >
                      <?php $img_home2='../uploads/home/'.$this->rs_data['home_image_2']; ?>
                      <img src="<?=$img_home2;?>" class="up_img"> </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div> <span class="btn btn-file btn-default"> <span class="mg-t-5 fileupload-new btn btn-white btn-xs">Select image</span><span class="fileupload-exists btn btn-white btn-xs">Change</span>
                      <? $this->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "form_home_image_2") ?>
                      </span> <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> </div>
                  </div>
                </div>
              </div>
            </div>
                  
          </div> 
              
           
           
        </div>
        
      </div>
      <div class="row mg-t-15">
        <div class="col-lg-12">
          <button class="btn btn-primary" type="submit">Submit</button>
          <button class="btn btn-secondary" type="reset">Cancel</button>
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
<script>
      // Adding placeholder for search input
      (function($) {
        'use strict'
        var Defaults = $.fn.select2.amd.require('select2/defaults');
        $.extend(Defaults.defaults, {
          searchInputPlaceholder: ''
        });
        var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
        var _renderSearchDropdown = SearchDropdown.prototype.render;
        SearchDropdown.prototype.render = function(decorated) {
          // invoke parent method
          var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
          this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
          return $rendered;
        };
      })(window.jQuery);
      $(function(){
        'use strict'
        // Basic with search
        $('.select2').select2({
          placeholder: 'Choose one',
          searchInputPlaceholder: 'Search options'
        });
      });
    </script>
<script src="assets/js/dashforge.aside.js"></script>
<script src="assets/js/dashforge.js"></script>
<!-- other include -->
<script src="lib/alert/js/sweet-alert.min.js"></script>
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script>
<!-- file upload  -->
<script src="lib/bootstrap-file/js/fileupload.js"></script>
<!-- image popup -->
<script src="lib/magnific-popup/js/jquery.magnific-popup.js"></script>
<script src="lib/validate/js/jquery.validate.min.js"></script>
<!-- Custom -->
<script src="scripts/js/subziwalla.js"></script>
<link href='lib/selectdropdown/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='lib/selectdropdown/jquery-ui.min.js' type='text/javascript'></script>
<script>
 $( function() {
  
        $( "#p_type" ).autocomplete({
			
			
			
			
			
            source: function( request, response ) {
				
				
				
                
                $.ajax({
                   	url: "..//scripts/ajax/index.php",
                    type: 'post',
                    dataType: "json",
                    data:'method=sales_product_suggession&queryString='+request.term,
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			minLength: 0,
            select: function (event, ui) {
                $('#p_type').val(''); // display the selected text
				
				 
				 
				
				 
				 addproduct_to_table(ui.item.value,1);
				//  fill_data(ui.item.value);
				 
				
				 
				  // save selected id to input
                return false;
            }
        }).focus(function () {
			  $(this).autocomplete("search");
		});
    });
	
	
	
	
		function addproduct_to_table(product_id,cust_id)
	{
		
		
		$('#free_product_id').val(0);
		
		
		$.ajax(
		{

			type: "POST",
			dataType: 'json',
			url: "../scripts/ajax/index.php",
			data: "method=get_product_detail_order_new&product_id="+product_id+'&cust_id='+cust_id,

			success: function(data){
					if(data.RESULT=='OK')
					{
				
				
				
				
				$('#free_product_id').val(product_id);
				$('#p_type').val(data.product_name+' - '+data.p_type+' - $'+data.product_unit_cost);
				
					
					 $('#p_type').attr("disabled",true);
				
					$('#p_type').attr("readonly","readonly");
				
					}
			}
		}
	);	
	}
	
	 function remove_data()
 {
	 
				$('#free_product_id').val(0);
				$('#p_type').val('');
				
				//$('#phone').removeAttr("readonly","readonly");
				
				$('#p_type').attr("disabled",false);
				
				$('#p_type').removeAttr("readonly","readonly");
				
				
	 
 }

</script>
