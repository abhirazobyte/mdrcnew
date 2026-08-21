<?php
$id=$app->getGetVar('id');
	
	




?>

<div class="popup-modals modal-ad-style">

  <div class="modal infosmal" id="modal-UploadPrescription" tabindex="-1" >

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <div class="common-heading">

            <h4 class="mt0 mb0"></h4>

          </div>

          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body  ">

        	<div class="col-lg-12  text-center col-12">

        			<h4 class="text-dark">Upload Prescription</h4>

        			<p class="text-dark">PNG, JPG and GIF are allowed</p>

        	</div>

          <div class="form-block fdgn2 mt20 mb10">

            <form action="" method="post" name="preForm" id="preForm" enctype="multipart/form-data">
             <input type="hidden" name="cartID" id="cartID" value="<?=$id?>">

              <div class="row">

					        <div class="col-md-12">

					          <div class="form-group">

					            <div class="preview-zone hidden">

					              <div class="box box-solid">

					                <div class="box-header with-border">

					                  <div><b>Preview</b></div>

					                  <div class="box-tools pull-right">

					                    <button type="button" class="btn btn-danger btn-sm remove-preview">

					                      <i class="fa fa-times"></i> Reset This Form

					                    </button>

					                  </div>

					                </div>

					                <div class="box-body"></div>

					              </div>

					            </div>

					            <div class="dropzone-wrapper">

					              <div class="dropzone-desc">

					                <i class="fas fa-upload"></i>

					                <p>Choose an image file or drag it here.</p>

					              </div>

					              <input type="file" name="img_logo" class="dropzone">

					            </div>

					          </div>

					        </div>

					    </div>


						
                         
                          
                          


					      <div class="row">

					        <div class="col-md-12 mt-4">

					          <button type="submit" class="lnk btn-main bg-btn w-auto float-end item_modal_submit">Upload</button>

					        </div>

					      </div>
                          
                          
                          <div class="row">

					        <div class="col-md-12 errorDiv mt-4">

					          
                              

					        </div>

					      </div>




            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>













