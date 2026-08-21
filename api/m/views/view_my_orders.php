<?php include('includes/header.php'); ?>

<!-- Main Start -->
<main class="main-wrap page-common">
	<!-- Card  -->
	<div class="mt-3" id="results">   
    </div>
	
	<div class="nonvalued">
		<input type="hidden" name="total_products" id="total_products" value="">
		<input type="hidden" name="p_core_collection_v" id="p_core_collection_v" value="no">
		<input type="hidden" name="p_new_arrivals_v" id="p_new_arrivals_v" value="no">
		<input type="hidden" name="serach_keyword" id="serach_keyword" value="">
	</div>

	<div class="col-12">
		<div class="mb-5">
			<button class="btn btn-solid rounded-pill w-100 animation_image" id="l_more">Load More</button>
		</div>
	</div>

</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->

<script src="scripts/js/load_my_orders.js"></script>