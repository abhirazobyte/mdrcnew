<link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="lib/typicons.font/typicons.css" rel="stylesheet">
<link href="lib/prismjs/themes/prism-vs.css" rel="stylesheet">

<link href="lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
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
              <li class="breadcrumb-item"><a href="#">Page</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                <?=$this->to_do?>
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
      <? $this->htmlBuilder->buildTag("form", array("action"=>"","data-parsley-validate"=>"","class"=>"form-horizontal form-bordered form-validate"), "frm_blog_addedit");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->getGetVar('pg_no')), "pg_no");?>
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"update_data"), "act");?>
      
      <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->rsblog['master_type']), "last_master_type");?>
      
            <? $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->folder), "folder");?>
      
      <input type="hidden" name="blog_option" value="multiple">
      <div class="row">
        <div class="col-lg-8">
          <div data-label="blog Basic Information" class="df-example demo-forms">
            <div class="form-group">
              <label class="d-block">Name <span class="tx-danger">*</span></label>
              <? $this->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","required"=>"","value"=>$this->rsblog['name']), "name1") ?>
            </div>
           
              <div class="form-group">
                <label class="d-block">Tags</label>
                <input id="input2" type="text" name="tags" class="form-control" name="taginput" value="<?=$this->rscat['tags']?>">
          
              </div>
          
            
              <div class="form-group">
                <label class="d-block">Short Description <span class="tx-danger">*</span></label>
                <? $this->htmlBuilder->buildTag("textarea", array("rows"=>"3","class"=>"form-control","required"=>""), "short_info") ?>
              </div>

            <div class="form-group">
              <label class="d-block">Description</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control ckeditor","style"=>"height:150px"), "about_info") ?>
            </div>

            <div class="form-group">
              <label class="d-block">Select Items</label>
              <select class="form-control select2" multiple="multiple" name="work_item1[]">
                <? $rs_work=$this->item;
                $ids_data=$this->rsblog['item_ids'];
                for($i=0;$i<count($rs_work);$i++)
                {
                  $micro_items=explode(',',$ids_data); ?>
                  <option  value="<?=$rs_work[$i]['id']; ?>" <?  for($j=0;$j<count($micro_items);$j++) {if($rs_work[$i]['id']==trim($micro_items[$j])){echo 'selected';}} ?>>
                    <?=$rs_work[$i]['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label class="d-block">Meta Title</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control "), "meta_title") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Meta Keywords</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control "), "meta_keywords") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Meta Description</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control "), "meta_description") ?>
            </div>
            <div class="form-group">
              <label class="d-block">Meta Schema</label>
              <? $this->htmlBuilder->buildTag("textarea", array("type"=>"text","class"=>"form-control "), "meta_schema") ?>
            </div>
            

          </div>
          
         
         
          
        </div>
        <div class="col-lg-4">
          
          
          
          
              <div data-label="blog Image" class="df-example demo-forms">
          
          <label class="d-block">Image</label>
          
          
           				 <?php
				  
				 		 $file_class="fileupload-new";
				  
				  		 if($this->getGetVar('id'))
				  		{
							 if($this->rscat['image']!='' &&  file_exists(ABS_PATH."/".$this->get_user_config("blog").'/'.$this->folder.'/'.$this->rscat['image']))
							 {
							 	$img='../uploads/blog/'.$this->folder.'/thumb'.$this->rscat['image'];
								
								$file_class="fileupload-exists";
								
								
									
								
							 }
							 else
							 {
								 $img='images/img_upl.gif';
							 }
						 }
						 else
						 {
							 $img='images/img_upl.gif';
						 }
						 
						 
						 
						 // $file_class="fileupload-new";
						 ?>
                         
                         
                  
                   <div class="fileupload <?=$file_class;?>" data-provides="fileupload">
                <div class="fileupload-new" > <img src="images/img_upl.gif" class="up_img"> </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"> <img src="<?=$img;?>" />  </div>
                <div>
                	<span class="btn btn-file btn-default"> 
                    	<span class="fileupload-new btn btn-white btn-xs">Select image</span>
                    	<span class="fileupload-exists btn btn-white btn-xs">Change</span>
                    	<? $this->htmlBuilder->buildTag("input", array("type"=>"file","class"=>""), "image") ?>
                    </span> 
                    <a href="#" class="btn btn-xs fileupload-exists btn-white" data-dismiss="fileupload">Remove</a> 
                </div>
              </div>
              
              <span class="tx-11-f tx-danger"><strong>Dimensions :</strong> 900 x 900 px</span>
                  
                  
                  </div>
         
         
          
          
          <div data-label="Category" class="df-example demo-forms">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Category <span class="tx-danger">*</span></label>
                   <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control select2","required"=>"", "values"=>$this->records1), "category_id") ?>
                </div>
              </div>
              
              
              
              
              
               
               
              
              
              
              
              
              
              
              
              
              
            </div>
          </div>
          
          <div data-label="blog Other Data" class="df-example demo-forms">
            <div class="row">
              
              
              
              
              
               
              
              
              
               <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Status</label>
                  <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control", "values"=>array("Active"=>"Active","Inactive"=>"Inactive")), "status") ?>
                </div>
              </div>
              
              
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Sort Order</label>
                  <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control", "values"=>$this->utility->sort_order('blog'),"selected"=>$this->sort_order), "sort_order") ?>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="form-group">
                  <label class="d-block">Set At Home</label>
                  <? $this->htmlBuilder->buildTag("select", array("class"=>"form-control", "values"=>array("No"=>"No","Yes"=>"Yes")), "set_at_home") ?>
                </div>
              </div>
              
              
              
              
              
              
              
              
              
              
              
              
            </div>
          </div>
        </div>
      </div>
      
       
       
       
          
         
         
         
      <div class="row mg-t-15">
        <div class="col-lg-12">
        <input type="hidden" name="save_btn" id="save_btn" value="Save">
          <button class="btn btn-primary" id="blog_btn" onclick="update_type('Save')"  type="submit">Save</button>
          
         
         
          <a class="btn btn-secondary" href="index.php?view=blog_list">Cancel</a> </div>
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

localStorage.clear();
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
    
    
    
    
    
     <script src="lib/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="lib/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="lib/handlebars/handlebars.min.js"></script>
    
    
    
<script src="assets/js/dashforge.aside.js"></script> 
<script src="assets/js/dashforge.js"></script> 

<!-- other include --> 

<script src="lib/alert/js/sweet-alert.min.js"></script> 
<script src="lib/alert/js/jquery.sweet-alert.init.js"></script> 
<script>



 
 function update_type(a)
 {
	 $("#save_btn").val(a);	
	 
	}

 

function change_dtypes(a)

{

	if(a=='in_pkt')

	{

		$(".dtype").html('Pkt');	

	}

	else if(a=='in_pcs')

	{

		$(".dtype").html('Pcs');	

	}

	else if(a=='in_ltr')

	{

		$(".dtype").html('Ml');	

	}

	else if(a=='in_gm')

	{

		$(".dtype").html('Gram');	

	}

	else

	{

		$(".dtype").html('Pkt');	

		

	}	

}





	  function show_suggestion(s)

 {

    var value = s.toLowerCase();

    $(".scrollbox .even").filter(function() {

      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

    });

  }

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
<script>
      $(function(){
        'use strict'
		

        // With TypeAhead
        var citynames = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: {
            url: 'scripts/ajax/index.php?method=blog_tags',
            filter: function(list) {
              return $.map(list, function(cityname) {
                return { name: cityname }; });
              }
            }
        });

        citynames.initialize();

        $('#input2').tagsinput({
          typeaheadjs: {
            name: 'citynames',
            displayKey: 'name',
            valueKey: 'name',
            source: citynames.ttAdapter()
          }
        });

        // Objects as Tags
      


      });
    </script>