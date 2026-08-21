<?php include('includes/header.php'); ?>

<style>
#result_data .col-lg-4{
width: 100% !important;
}
</style>
<!-- Main Start -->
<main class="pb-5 bg-white page-common">
	<!-- Search Box Start -->
	<div class="bg-white pt-3">
		<div class="d-flex search-box search-box2 mx-3">
			<input class="form-control" type="search" name="serach_keyword" id="serach_keyword" placeholder="Search" />
			<!-- <button type="submit"><i class="iconly-Search icli search text-danger"></i></button> -->
		</div>
	</div>
	<div></div>
	<!-- Search Box End -->
	<div class="row mx-0 pt-4 g-3" id="result_data">
		<!-- 
		<div class="col-12">
			<div class="single-blog-post- shdo">
				<div class="single-blog-img-">
					<a href="blog-details.php">
						<img src="uploads/blog/list-1.jpg" alt="Blog List" class="img-fluid">
					</a>
					<div class="entry-blog-post dg-bg2">
						<span class="bypost-"><a href="#"><i class="fas fa-tag"></i>
								General</a></span>
						<span class="posted-on-">
							<a href="#"><i class="fas fa-clock"></i> Sep 24, 2022</a>
						</span>
					</div>
				</div>
				<div class="blog-content-tt">
					<div class="single-blog-info-">
						<h4>
							<a href="blog-details.php">
								Which Diagnostic Centres has Affordable Blood Test Packages?
							</a>
						</h4>
						<p>
							As the world scenario changes, it becomes increasingly difficult to keep track of every
							aspect of health.
						</p>
					</div>
				</div>
			</div>
		</div>
		-->
	</div>
	<div class="nonvalued">
      <input type="hidden" name="catv" id="catv" value="<?=$this->CatId?>">
      <input type="hidden" name="tagv" id="tagv" value="<?=$this->TagId?>">
      <input type="hidden" name="total_blogs" id="total_blogs" value="<?=count($this->rs_data)?>">
    </div>
	<div class="row mx-0 pt-4 text-center">
		<div class="col-lg-12">
			<button class="btn btn-solid animation_image" id="load_more_blog">Load More </button>
		</div>
	</div>
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<script src="scripts/js/blogscript.js"></script>