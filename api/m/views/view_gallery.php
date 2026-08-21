<?php include('includes/header.php'); ?>
<!-- gallery css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet">
<!-- Main Start -->
<main class="pb-4 bg-white page-common">
  <!-- About banner start -->
  <div class="card bg-theme rounded-0 border-0 p-3">
    <h2 class="font-lg text-center text-white mb-0">Gallery</h2>
  </div>
 <style>
  .grid-item img {
    -webkit-filter:none !important;

}
 </style>
  <!-- About banner end -->
  <div class="filters filter-button-group">
    <ul>
      <li class="active"><a href="javascript:void(0);" data-filter="*" class="font-md fw-600">All</a></li>
      <?php for($i=0;$i<count($this->rs_category);$i++){?>
        <li><a href="javascript:void(0);" data-filter="cat<?=$this->rs_category[$i]['id']?>" class="font-md fw-600"><?=$this->rs_category[$i]['name']?></a></li>
      <?php }?>
    </ul>
  </div>
  <div id="container" class="isotope">
    <?php for($i=0;$i<count($this->rs_gallery);$i++){?>               
      <div class="col-lg-4 col-md-6 grid-item cat<?=$this->rs_gallery[$i]['gallery_category_id']?>" data-filter="cat<?=$this->rs_gallery[$i]['gallery_category_id']?>">
        <a class="popupimg" href="<?=IMAGE_SERVER_ROOT;?>/uploads/gallery/<?=$this->rs_gallery[$i]['image']?>">
          <img src="<?=IMAGE_SERVER_ROOT;?>/uploads/gallery/<?=$this->rs_gallery[$i]['image']?>">
        </a>
      </div>
    <?php } ?>
  </div>
  <div class="isotope-pager d-none" style="padding-top: 15px; text-align:center;"></div>
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<!-- gallery js -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js'></script>