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
<link href="css/custom.css?v=1.6" rel="stylesheet">
<style>
	.select-btn {
		border-radius: 8px !important;
		padding: 10px;
		font-size: 15px;
	}

	.search-input-news {
		border-top-right-radius: 0;
		border-bottom-right-radius: 0;
		border-radius: 12px 0 0 12px;
	}

	.input-group .btn {
		border-radius: 0 12px 12px 0;
		height: 47px;
		padding: 0 25px;
	}

	.search-input-news:focus,
	.select-news:focus,
	.search-news-btn:focus {
		outline: none !important;
		box-shadow: none !important;
	}

	.btn-blue,
	.bg-darkblue {
		background-color: #1e73b1;
	}

	.btn-sky {
		background-color: #00afdf;
		border-radius: 12px;
	}

	.single-blog-img- img {
		width: 100%;
		height: 250px;
		object-fit: cover;
	}

	.single-blog-info- h4 {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		overflow: hidden;
		text-overflow: ellipsis;
		min-height: 60px;
	}

	.single-blog-info- p {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 3;
		overflow: hidden;
		text-overflow: ellipsis;
		min-height: 70px;
		line-height: 24px !important;

	}
</style>
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<!--Breadcrumb Area-->
<section class="breadcrumb-area banner-6">
	<div class="text-block">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-start v-center">
					<div class="bread-inner">
						<div class="bread-menu wow fadeInUp" data-wow-delay=".2s">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li><a href="blogs">Blog</a></li>
								<?php if ($this->array_bread != '') { ?>
									<li><a href="javascript:void()"><?= $this->array_bread ?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="bread-title wow fadeInUp" data-wow-delay=".5s">
							<?php if ($this->array_bread != '') {
								$title = $this->array_bread;
							} else {
								$title = 'Blogs';
							}
							?>
							<h1 class="f-bold fs-2 text-white"><?= $title ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Breadcrumb Area-->
<!--Start Blog Grid-->
<section class="blog-page  pt00">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 col-12">
				<div class="common-heading-2 text-l my-4 ">
					<h2 class="fs-2 fw-bold border-bottom border-secondary pb-1">Blogs</h2>
				</div>
			</div>
			<div class="col-lg-9 col-md-6 col-12 text-center mb-3 mb-lg-0">
				<div class="input-group  ">
					<input type="text" class="form-control search-input-news shadow-sm" id="serach_keyword" name="serach_keyword" placeholder="Search">
					<button class="btn btn-blue text-white search-news-btn shadow-sm" type="button"><i class="fas fa-search me-1"></i> Search</button>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12 text-lg-end text-start">
				<div class="dropdown d-inline">
					<span class="me-2 text-muted">Sort By</span>
					<select id="sort_by" name="sort_by" class="form-select form-select-sm select-news d-inline-block w-auto text-black bg-light select-btn p-5 py-2 ps-2">
						<!-- <option value="">Select</option> -->
						<option value="latest">Latest</option>
						<option value="old">Old</option>
					</select>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-8">
				<div class="row" id="result_data"></div>
			</div>
			<div class="col-lg-4">
				<?php if (count($this->rs_category) > 0) { ?>
					<div class="recent-post widgets mt60">
						<div class="common-heading-2 text-l">
							<h2 class="mb-10 fs-4 text-blue">Blog Category</h2>
						</div>
						<div class="blog-categories">
							<ul>
								<?php for ($i = 0; $i < count($this->rs_category); $i++) { ?>
									<li class="border rounded mb-2 bg-darkblue">
										<a href="blog/category/<?= $this->rs_category[$i]['slug'] ?>" class="p-2 text-white"><?= $this->rs_category[$i]['name'] ?> <span class="categories-number text-white pe-2">(<?= $this->rs_category[$i]['blog_count'] ?>)</span></a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="nonvalued">
			<input type="hidden" name="catv" id="catv" value="<?= $this->CatId ?>">
			<input type="hidden" name="tagv" id="tagv" value="<?= $this->TagId ?>">
			<input type="hidden" name="total_blogs" id="total_blogs" value="<?= count($this->rs_data) ?>">
		</div>

		<div class="row" style="margin-top:50px;text-align:left">
			<div class="col-lg-12">
				<button class="btn bg-darkblue text-white animation_image" id="load_more_blog" align="center">Load More </button>
			</div>
		</div>


	</div>
</section>
<!--End Blog Grid-->
<?php
// include 'includes/get_in_touch_form.php';
?>
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
<?php include 'includes/general_data.php'; ?>