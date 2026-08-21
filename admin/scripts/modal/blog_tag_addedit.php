<?php

$id=$app->getGetVar('id');

if($id!='')

{

	//Edit blog_tag

	$obj_blog_tag = $app->load_model("blog_tag");

	$result = $obj_blog_tag->execute("SELECT", false, "", "id='".$id."'");			

	

	$name=$result[0]['name'];

	$sort_order=$result[0]['sort_order'];

	$status=$result[0]['status'];

	$slug=$result[0]['slug'];

	$set_at_home=$result[0]['set_at_home'];

	$folder='blog_tag';

	//image

	$image=$result[0]["image"];



	

	

}

else

{

	//Add blog_tag

	$blog_tag_img='images/img_upl.gif';	

}

?>



<div class="modal fade" id="modal_blog_tag_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content tx-14">

      <div class="modal-header">

        <h6 class="modal-title" id="exampleModalLabel2">Tag Form</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>

      <form method="post" name="blog_tag_form" id="blog_tag_form"  data-parsley-validate>

        <? $app->htmlBuilder->buildTag("input", array("type"=>"hidden","class"=>"form-control","value"=>$id), "id") ?>

        <div class="modal-body">





	 	 <div class="form-row">

            <div class="form-group col-md-12">

              <label for="inputEmail4">Name<span class="tx-danger">*</span></label>

              <? $app->htmlBuilder->buildTag("input", array("type"=>"text","class"=>"form-control ","value"=>$name,"required"=>""), "name") ;?>

            </div>

            

          </div>

          

          

          



	<div class="form-row">

      

        

			

            

            <div class="form-group col-md-4">

              <label for="inputEmail4">Sort Order</label>

           		<? $app->htmlBuilder->buildTag("select", array("class"=>"form-control ","selected"=>$sort_order, "values"=>$app->utility->sort_order('blog_tag'),"required"=>""), "sort_order") ;?>

           </div>


            <div class="form-group col-md-4">

              <label for="inputEmail4">Most Used</label>

              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$set_at_home, "values"=>array("No"=>"No","Yes"=>"Yes"),"required"=>""), "set_at_home") ;?>

            </div>

           

           <div class="form-group col-md-4">

              <label for="inputEmail4">Status</label>

              <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control","selected"=>$status, "values"=>array("Active"=>"Active","Inactive"=>"Inactive"),"required"=>""), "status") ;?>

            </div>

          </div>

          



        

          

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary tx-13 submit_btn blog_tag_modal_submit">Submit</button>

        </div>

      </form>

    </div>

  </div>

</div>

