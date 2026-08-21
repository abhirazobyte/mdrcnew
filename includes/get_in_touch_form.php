<!-- <section class="getTouch ">
	<div class="container">
		<div class="row align-items-center ">
			<div class="col-lg-5 col-md-6">
				<div class="common-heading-2 mt20 text-l">
					<h2 class="mb0 text-white">Get In Touch With Us</h2>
					<p class="text-white">Feel Free to Connect With Us For Any Queries</p>
					<div class="form-block mb-3">
						<form id="GetCallBackForm1" name="GetCallBackForm1" class="shake">
							<div class="row">
								<div class="form-group col-sm-4">
									<input type="text" id="name" name="name" placeholder="Name" data-error="Please fill Out">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-4">
									<input type="text" id="phone" name="phone" class="numbers numbersOnly" placeholder="Mobile No.">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-4">
									<select name="city" id="city">
	                        			<option value="">Select City</option>
	                        			<?php for ($i=0; $i < count($this->rs_gs_city) ; $i++) { ?>
											<option value="<?=$this->rs_gs_city[$i]['name']?>"><?=$this->rs_gs_city[$i]['name']?></option>
										<?php }?>	
	                        		</select>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-sm-8">
									<input type="text" id="fmessage" name="fmessage" placeholder="Message" data-error="Please fill Out">
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-sm-4">
									<div class="help-block with-errors"></div>
									<button type="submit" id="form-submit" data-form="GetCallBackForm1" class="btn1 bg-btn1 get-call-back-submit">Submit <span class="circle"></span></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 ms-auto text-end mtopminus">
				<img src="images/doctors.png" class="img-fluid">
			</div>
		</div>
	</div>
</section> -->