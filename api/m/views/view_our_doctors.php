<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="pb-4 bg-white page-common">
	<!-- top banner Start -->

	<!-- Our Doctors start -->
	<div class="our-doctors p-3">
		<div class="row g-3">
			<?php for($i=0;$i<count($this->rs_doctor);$i++){
				$image = $this->utility->get_image_path($this->rs_doctor[$i]['image'], 'doctor', 'large');
			?>
			<div class="col-6">
				<div class="our-doctors-box">
					<div class="doctor-img">
						<img src="<?=$image?>" alt="<?=$this->rs_doctor[$i]['name']?>" class="img-fluid">
					</div>
					<h4><?=$this->rs_doctor[$i]['name']?></h4>
					<p><?=$this->rs_doctor[$i]['doctor_category_name']?></p>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->