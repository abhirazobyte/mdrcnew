<?php include 'includes/header.php';?>

<main class="bg-white page-common">
	<div class="card bg-theme molecular-diagnostics rounded-0 border-0 p-3">
		<h2 class="font-lg text-center text-white mb-3"><?=$this->records_doctors['title']?></h2>
		<p class="text-white text-center">
		<?=$this->records_doctors['short_desc']?>
		</p>
		<?php $image = $this->utility->get_image_path($this->records_doctors['image'], 'for_doctors_services', 'large'); ?>
		<div class="molecular-divimg mx-auto">
			<img src="<?=$image?>" alt="" class="w-100 h-100 img-fluid">
		</div>
	</div>
	
	<div class="sample-collection-form p-3">
		

	<div class="about-tab mt-3 mb-4">
	<?=$this->records_doctors['decsription']?>
	</div>


	<div class="form-block fdgn2 mt10 mb10 mb-4">
		<h2 class="font-lg mb-2">Get a call back</h2>
			<form method="post" id="GetCallBackForm" name="GetCallBackForm">
				<div class="fieldsets row">
					<div class="col-md-12"><input required="required" type="text" placeholder="Full Name*" name="name" id="name" value="" class="required"></div>
					<div class="col-md-12"><input required="required" type="phone" placeholder="Phone*" class="numbersOnly required" value="" name="phone" id="phone"></div>
				
					<div class="col-md-12">
						<select required="required" name="city" id="city" class="form-select">
							<option value="">Select City</option>
							<?php for ($i=0; $i < count($this->rs_gs_city) ; $i++) { ?>
							<option value="<?=$this->rs_gs_city[$i]['name']?>"><?=$this->rs_gs_city[$i]['name']?></option>
							<?php }?>	
						</select>
					</div>
					
				<div class="fieldsets row m-0 mt30 pb20 justify-content-center">
					<div class="col-md-12 p-0">
						<button type="submit" id="form-submit" data-form="GetCallBackForm" class="btn btn-solid rounded-pill w-100 get-call-back-submit">Submit</button>
						<div id="msgSubmit" class="h3 text-center hidden"></div>
					</div>
				</div>
			</form>
		</div>

	</div>

	



	<!-- Other Services to start -->
	<div class="banner-section profolio-caters mt-3">
		<h2 class="font-lg text-center mb-3 fw-bold">Other Services</h2>
		<div class="about-porfolio-slider">
			<?php for ($i=0; $i < count($this->records_services); $i++) {
				$image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
			<div>
				<a href="<?=SERVER_ROOT;?>/service/<?=$this->parent_slug;?>/<?=$this->records_services[$i]['slug']?>" class="banner-box">
					<div class="card bg-white rounded px-3 pt-3">
						<div class="ht-200">
						<img src="<?=$image?>" alt="" class="img-fluid w-100 h-100 d-block">
						</div>
						<span class="my-2 font-md fw-600 text-center"><?=$this->records_services[$i]['title']?></span>
					</div>
				</a>
			</div>
			<?php }?>
		</div>
	</div>
	<!-- Our portfolio caters to end -->
		
</main>

<!--Start Footer -->
<?php include 'includes/footer.php';?>
<!--End Footer -->