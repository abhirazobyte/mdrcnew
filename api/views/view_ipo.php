<!--plugin-css-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/plugin.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- template-style-->
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<!-- Bootstrap Select -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css'>
<link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php 
include 'includes/header.php'; 
include 'modules/phpqrcode/qrlib.php';
?>
<style>
	.list-style- li {
    line-height: 36px;
    list-style-type: disc;
    font-size: 20px;
}
 
.ipo-ul li a{
color: black;
}
 
.ipo-ul a:hover{
color: #555;
}
</style>
<!--End Header -->
<section class="about-lead-gen" data-background="images/bg_banner.png">
	<div class="col-lg-12 col-md-12 col-12">
		<img src="images/investor-relation/ipo-banner.png" alt="image" class="w-100">
	</div>
</section>
<section class="teb-section  pb50 pt40 ">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="common-heading-2">
					<h2 class="mb10">IPO / Offer Documents</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12 col-12">
				<div class="tabs-layout">
					<div class="tab-content" id="myTabContent1">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								<div class="col-lg-9 common-heading-2 text-start col-xs-12 col-12">
									<ul class="list-style- text-202024 ipo-ul">
										<?php 
											foreach ($this->rs_pdf as $item) 
											{
												$img = $this->utility->get_image_path($item['file_name'], 'ipo_pdfs', "large");

												$PNG_TEMP_DIR = ABS_PATH . '/uploads/ipo_pdfs/';
												$filename = $PNG_TEMP_DIR.$item['file_name'] . '.png';
												$code =$img;
												QRcode::png($code, $filename, 'L', '3', '1');
												$image='<img src="../uploads/ipo_pdfs/' . basename($filename) . '"  style="width: 130px;">';
											?>
											<li>
											<?php if ($item['qr_code']=='Yes') { ?>
												<a href="javascript:void(0)" class="getQr"  data-id="<?=$item['id']?>"><?= $item['title'] ?></a>
												<div class="qrImage pdfImage<?=$item['id']?>" style="display:none;">
													<div class="form-block fdgn2">
														<div class="box">
															<table>
																<tr>
																	<td style="width: 100%;">
																		<?=$image?>
																	</td>
																</tr>
															</table>
														</div>
													</div>
												</div>
												<?php } else { ?>
													<a href="<?=$img?>" download><?= $item['title'] ?></a>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--Start Footer -->
<?php include 'includes/footer.php'; ?>
<!--End Footer -->
<!-- js placed at the end of the document so the pages load faster -->
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/plugin.min.js"></script>
<script src="js/preloader.js"></script>
<!--common script file-->
<script src="js/main.js"></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js'></script>
<script id="rendered-js">
	$(document).ready(function() {
		// $('.my-select').selectpicker();
		// $(function () {
		// $('select').selectpicker();
		// });
	});
	//# sourceURL=pen.js
</script>
<script>
	//Owl-Carousel - awards card
	var owl = $('.niwax-review-slider');
	owl.owlCarousel({
		items: 3,
		loop: false,
		center: false,
		autoplay: true,
		margin: 10,
		nav: true,
		navText: [
			'<img src="images/black-arrow-left.png" />',
			'<img src="images/black-arrow-right.png" />'
		],
		navContainer: '.testimonials .custom-nav',
		dots: false,
		autoplayTimeout: 3500,
		autoplayHoverPause: true,
		smartSpeed: 2000,
		responsive: {
			0: {
				items: 1,
			},
			520: {
				items: 1
			},
			768: {
				items: 2
			},
			1200: {
				items: 2
			},
			1400: {
				items: 3
			},
			1600: {
				items: 3
			},
		}
	});
	$(document).on("click",".getQr", function ()
	{
		getId=$(this).data("id");
		$('.pdfImage' + getId).slideToggle();
	});
</script>
<?php include 'includes/general_data.php'; ?>