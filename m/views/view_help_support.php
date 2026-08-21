<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="support-page bg-white page-common">
	<!-- Call center image start -->
	<div class="bg-white p-3">
		<figure>
			<img src="assets/images/mdrc/support/call-center.png" alt="" class="img-fluid d-block mx-auto">
		</figure>
		<p class="font-md fw-bold text-center">Our MDRC Experts Are Here <br>To Help You</p>
	</div>
	<!-- Call center image End -->
	<!-- Support contant start -->
	<div class="d-flex gap-3 justify-content-center pd-3 mb-3">
		<a href="tel:<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+911246712000'; ?>" class="border rounded px-4 py-3 d-flex flex-column align-items-center">
			<figure class="mb-0">
				<img src="assets/images/mdrc/support/phone-call.svg" alt="" class="img-fluid">
			</figure>
			<p class="mb-0 fw-bold">Call Us</p>
		</a>
		<a href="mailto:info@mdrcindia.com" class="border rounded px-4 py-3 d-flex flex-column align-items-center">
			<figure class="mb-0">
				<img src="assets/images/mdrc/support/envelopes.svg" alt="" class="img-fluid">
			</figure>
			<p class="mb-0 fw-bold">Mail Us</p>
		</a>
		<a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" class="border rounded px-4 py-3 d-flex flex-column align-items-center">
			<figure class="mb-0">
				<img src="assets/images/mdrc/support/whatsapp.svg" alt="" class="img-fluid">
			</figure>
			<p class="mb-0 fw-bold">Chat</p>
		</a>
	</div>
	<!-- Support contant End -->
	<div class="freq-ques px-3 pt-3 bg-white" style="display: none;">
		<h2 class="font-lg mb-3">
			Frequently Asked Questions
		</h2>
		<div class="accordion mb-5" id="accordionExample">
			<!-- Accordion item -->
			<div class="accordion-item">
				<h2 class="accordion-header fw-bold" id="headingOne">
					<button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">
						What is Lorem Ipsum?
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<p>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</p>
					</div>
				</div>
			</div>
			<!-- Accordion item -->
			<div class="accordion-item">
				<h2 class="accordion-header fw-bold" id="headingOne">
					<button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="false" aria-controls="collapseTwo">
						What is Lorem Ipsum?
					</button>
				</h2>
				<div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<p>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</p>
					</div>
				</div>
			</div>
			<!-- Accordion item -->
			<div class="accordion-item">
				<h2 class="accordion-header fw-bold" id="headingOne">
					<button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="false" aria-controls="collapseTwo">
						What is Lorem Ipsum?
					</button>
				</h2>
				<div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<p>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</p>
					</div>
				</div>
			</div>
			<!-- Accordion item -->
			<div class="accordion-item">
				<h2 class="accordion-header fw-bold" id="headingOne">
					<button class="accordion-button title-color collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapseTwo">
						What is Lorem Ipsum?
					</button>
				</h2>
				<div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<p>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</p>
					</div>
				</div>
			</div>
			<!-- Accordion End -->
		</div>
	</div>
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->