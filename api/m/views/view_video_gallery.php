<?php include('includes/header.php'); ?>

<!-- Main Start -->
<main class="main-btm-pd bg-white page-common">
  <!-- About banner start -->
  <div class="card bg-theme rounded-0 border-0 p-3">
    <h2 class="font-lg text-center text-white mb-0">Gallery</h2>
  </div>
  <!-- About banner end -->
  <div id="container" class="">
    <?php for($i=0;$i<count($this->rs_gallery);$i++){?>               
      <div class="col-lg-12 col-md-12 ">
        <iframe width="100%" height="280" src="<?=$this->rs_gallery[$i]['video_link']?>" frameborder="0" class="GlryVdo" allowfullscreen=""></iframe>
      </div>
    <?php } ?>
  </div>
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
