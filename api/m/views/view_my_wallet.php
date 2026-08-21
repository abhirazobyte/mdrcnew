<?php include('includes/header.php'); ?>

<!-- Main Start -->
<?php if($this->wallet>0) { ?>
<main class="page-common">
	<!-- Card  -->
	<div class="card  p-3 border-0">
		<div class="d-flex align-items-center justify-content-between">
			<div class="d-flex align-items-start">
				<img src="assets/images/mdrc/icons/wallet.svg" alt="">
				<div class="ms-2">
					<h3 class="font-md fw-bold mb-1">Wallet Balance</h3>
					<?php $wallet = $this->utility->moneyFormatIndia($this->rs_customer['wallet']); ?>
					<p class="mb-0 th-color-green fw-bold"><span><?= $wallet ?></span></p>
				</div>
			</div>
			<!-- <a href="wallet-add.php" type="button" class="btn th-btn-solid-sm">
                    Add Money
                </a> -->
		</div>
	</div>
	<!-- Waller Summary Start -->

	<div class="search-box search-box2 mx-3 pt-3 mb-3">
		<input type="text" name="search_keyword" id="search_keyword" placeholder="Search...." class="form-control">
	</div>

	<div id="results">
	</div>

	<div class="nonvalued">
		<input type="hidden" name="total_products" id="total_products" value="<?= count($this->rs_data) ?>">
		<input type="hidden" name="serach_keyword" id="serach_keyword" value="">
		<input type="hidden" name="p_core_collection_v" id="p_core_collection_v" value="no">
		<input type="hidden" name="p_new_arrivals_v" id="p_new_arrivals_v" value="no">
	</div>

	<div class="col-12">
		<div class="mb-5">
			<button class="btn btn-solid rounded-pill w-100 animation_image" id="l_more">Load More</button>
		</div>
	</div>
	<!-- Wallet Summary End -->

</main>
<!-- Main End -->
<?php } ?>

<?php if($this->wallet==0) { ?>
<!-- Main Start -->
<main class="success-page bg-white main-wrap">

	<div class="d-flex align-item-center justify-content-center pt-5 pb-5">
		<img src="assets/images/mdrc/img/payment-sucessful.png" alt="img-fluid d-block">
	</div>
	<div>
		<h2 class="fw-bold text-center mb-3 font-lg theme-color">Your Wallet is Empty</h2>
		<p class="fw-600 text-center font-md text-secondary lh-sm">Look Like there are no credit in your
			wallet at the moment.</p>
	</div>
	<!-- <div class="d-flex justify-content-center mt-5">
		<a href="#" class="btn btn-outline-solid btn-md d-flex align-items-center"><i data-feather="plus" class="icon-size-1 me-1"></i>Add Money</a>
	</div> -->
</main>
<!-- Main End -->
<?php } ?>

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<script src="scripts/js/load_wallet_transction.js"></script>
<!-- ============================== Date Image Start =========================================================================== -->

