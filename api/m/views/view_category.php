<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="health-package-page page-common">
	<!-- Banner Section Start -->
	<?php if(count($this->rs_banner)>0){ ?>
	<!-- Banner Section Start -->
	<section class="banner-section ratio2_1 p-3">
		<div class="h-banner-slider">
			<?php for($i=0;$i<count($this->rs_banner);$i++){
				$folder='main_banner_images';
				$image=$this->utility->get_image_path($this->rs_banner[$i]['mobile_image'],$folder,"large");
				$url='javascript:void(0)';
				if($this->rs_banner[$i]['banner_link']!='')
				{
					$url=$this->rs_banner[$i]['banner_link'];
				}
			?>
			<div>
				<a href="<?=$url;?>">
				<div class="banner-box <?=$this->rs_banner[$i]['mobile_image']?>">
					<img src="<?=$image?>" alt="banner" class="bg-img" />
				</div>
				</a>
			</div>
			<?php } ?>

			<?php for($i=0;$i<count($this->item_category_banner);$i++){
				$folder='item_category_banner';
				$image=$this->utility->get_image_path($this->item_category_banner[$i]['mobile_image'],$folder,"large");
				$url='javascript:void(0)';
				if($this->item_category_banner[$i]['banner_link']!='')
				{
					$url=$this->item_category_banner[$i]['banner_link'];
				}
			?>
			<div>
				<a href="<?=$url;?>">
				<div class="banner-box">
					<img src="<?=$image?>" alt="banner" class="bg-img" />
				</div>
				</a>
			</div>
			
			<?php } ?>

		</div>
	</section>
	<!-- Banner Section End -->
	<?php } ?>

	<!-- Packgae Banner Start -->
	<div class="package-banner">
		<img src="assets/images/mdrc/health-package/banner1.png" alt="" class="img-fluid w-100 object-cover">
	</div>
	<!-- Package Banner End -->

	<!-- Search Box Start -->
	<div class="health-package-search pt-3">
		<div class="search-box search-box2 mx-3 mb-3">
			<input class="form-control" type="text" placeholder="Find your Test/Package/Scan" id="serach_keyword" name="serach_keyword" onkeyup="searchData(this.value)" />
			<i class="iconly-Search icli search text-danger"></i>
		</div>
	</div>
	<!-- Search Box End -->
	<!-- Health Package List Start -->
	
	<!-- Package List 1 -->
	<div id="results">
	</div>

	<div class="nonvalued">
		<input type="hidden" name="type_ids" id="type_ids" value="">
		<input type="hidden" name="dieses_ids" id="dieses_ids" value="">
		<input type="hidden" name="category_ids" id="category_ids" value="<?=$this->data_id?>">
		<input type="hidden" name="sort_by" id="sort_by" value="">
		<input type="hidden" name="search_data" id="search_data" value="">
		<input type="hidden" name="city_id" id="city_id" value="<?=$this->city_id?>">
		<input type="hidden" name="department_id" id="department_id" value="<?=$this->department_id?>">
		<input type="hidden" name="total_data" id="total_data" value="0">
		<input type="hidden" name="pageType" id="pageType" value="<?=$this->pageType?>">
	</div>

	<div class="col-lg-12 loaderDiv" style="text-align:center">
		<img src="assets/images/loader.gif">
	</div>

	<div class="col-12">
		<div class="mb-5">
			<button class="btn btn-solid rounded-pill w-100 animation_image" id="l_more">Load More</button>
		</div>
	</div>

	<!-- Health Package List End -->
	</div>
</main>
<!-- Main End -->

<!-- Sticky Kart Start -->
<a href="cart" class="d-block">
	<div class="sticky-kart bg-theme">
		<div>
			<span class="text-white"><span class="cartCount"><?=count($this->rs_cartmini)?></span> Items</span>
			<p class="text-white mb-0 font-md"><i class="fas fa-rupee-sign"></i> <span class="font-md cartLineTotal"><?=$_SESSION['sub_total'];?></span></p>
		</div>
		<div>
			<a href="cart" class="d-flex align-items-center">
				<img src="assets/images/mdrc/icons/shopping-cart-white-size-2.svg" alt="" class="me-2">
				<span class="text-white font-md">View Cart</span>
			</a>
		</div>
	</div>
</a>
<!-- Sticky Kart End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<script src="scripts/js/packages.js?v=1.1"></script>