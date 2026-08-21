<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="mycart-page page-common">
	<!-- Cart Steps Start -->
	<div class="row py-3 cart-steps-row m-0">
		<div class="col-12 stepsinfo text-center">
			<ul>
				<li class="active">
					<a href="javascript:void(0)"><span>1</span><br>Cart</a>
				</li>
				<li>
					<a href="javascript:void(0)"><span>2</span><br>Schedule &amp; Book</a>
				</li>
				<li>
					<a href="javascript:void(0)"><span>3</span><br>Booked</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- Cart Steps End -->

	<div class="CartItems">
	</div>

	<div class="col-lg-12 cartError">
				<?= $this->utility->get_message() ?>
	</div>

	<!-- Collection Service Start -->
	<div class="HomeCollection">
	</div>
	<!-- Collection Service End -->

	<!-- Booking Summary Start -->
	<div class="booking-summary bg-white px-3 pt-3 pb-1">
		<h4 class="font-md fw-bold border-bottom pb-2 mb-2">Booking Summary</h4>
		<div class="d-flex justify-content-between align-items-center pb-2">
			<p class="mb-0 font-md fw-bold">Subtotal</p>
			<p class="mb-0 font-md fw-bold"><span class="sub_total"><?=$this->utility->moneyFormatIndia($_SESSION['sub_total']) ?></span></p>
		</div>
	</div>
	<!-- Booking Summary End -->
	<p class="px-3 pt-3">*inclusive of all the taxes, fees and subject to availability</p>
	<!-- Tests Start -->

	<!-- links -->
	<div class="d-flex align-items-center justify-content-center px-3 py-2 bg-white tests mb-3">
		<!-- <a href="radiology/imaging-lab-tests-near/<?=$_SESSION['citySlug'];?>" class="font-md theme-color d-flex align-items-center border-end px-3 d-block lh-sm"><i data-feather="plus" class="icon-size-2 me-2"></i>Pathology tests</a>
		<a href="pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="font-md theme-color d-flex align-items-center px-3 d-block lh-sm"><i data-feather="plus" class="icon-size-2 me-2"></i>Pathology tests</a> -->

		<a href="<?=SERVER_ROOT;?>/premium-health-checkup/<?=$_SESSION['citySlug'];?>" class="font-md theme-color d-flex align-items-center px-3 d-block lh-sm"><i data-feather="plus" class="icon-size-2 me-2"></i>Annual Health Checkups</a>
	</div>
	<!-- links -->

	<div class="d-flex align-items-center justify-content-evenly p-3 bg-white tests mb-3">
		<div class="d-block">
			<div class="d-flex flex-column justify-content-center align-items-center px-3 ">
				<img src="assets/images/mdrc/my-cart/appointment-slot.png" alt="" class="img-fluid mb-1">
				<p class="theme-color text-center mb-0 lh-sm">
					Online <br> Appointment Slot
				</p>
			</div>
		</div>
		<div class="d-block">
			<div class="border-start border-end d-flex flex-column justify-content-center align-items-center px-3 ">
				<img src="assets/images/mdrc/my-cart/online-report.png" alt="" class="img-fluid mb-1">
				<p class="text-center theme-color mb-0 lh-sm">
					Online Reports
				</p>
			</div>
		</div>
		<div class="d-block">
			<div class="d-flex flex-column justify-content-center align-items-center px-3">
				<img src="assets/images/mdrc/my-cart/nabh-centers.png" alt="" class="img-fluid mb-1">
				<p class="theme-color text-center mb-0 lh-sm">
					NABH Accredited <br> Centres
				</p>
			</div>
		</div>
	</div>
	<!-- Tests End -->
</main>
<!-- Main End -->
<!-- ============================ Start Modal========================================== -->



<!-- ============================ End Modal========================================== -->
<!--============================ Footer Price-bottom Sticky Start ===================== -->
<div class="price-bottom">
	<div class="d-flex align-items-center justify-content-between py-3 price-list w-100">
		<div>
			<span class="font-sm d-block"><span class="cartCount"></span> Items</span>
			<p class="font-lg fw-bold mb-0"><span class="sub_total"></span></p>
		</div>
		<?php
		if ($_SESSION['MDRCCustID'] > 0) {
			$extraItemsHtml = 'onclick="paynow()" href="javascript:void(0)" ';
			$extraItemsHtmlClass = '';
		} else {
			$extraItemsHtml = '';
			$extraItemsHtmlClass = 'loginModal';
		}
		?>
		<a <?=$extraItemsHtml;?> type="button" class="btn btn-solid text-white font-sm d-flex align-items-center rounded-pill <?=$extraItemsHtmlClass;?>">
			Schedule & Book
		</a>
	</div>
</div>
<!--============================ Footer Price-bottom Sticky End ===================== -->
<?php include('includes/footer.php'); ?>

<script src="scripts/js/load_cart.js?ver=1.0"></script>

<?php if ($_SESSION['HomeCollectionModalShow'] == 'Yes') { ?>
<script>
	$(window).on('load', function() {
		$('#modal-homeCollection').modal('show');
	});
</script>
<?php } ?>

<script id="rendered-js">
	function readFile(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				var htmlPreview =
					'<img width="200" src="' + e.target.result + '" />' +
					'<p>' + input.files[0].name + '</p>';
				var wrapperZone = $(input).parent();
				var previewZone = $(input).parent().parent().find('.preview-zone');
				var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
				wrapperZone.removeClass('dragover');
				previewZone.removeClass('hidden');
				boxZone.empty();
				boxZone.append(htmlPreview);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	function reset(e) {
		e.wrap('<form>').closest('form').get(0).reset();
		e.unwrap();
	}
</script>