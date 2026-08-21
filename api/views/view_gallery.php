<!--plugin-css-->

<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/plugin.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">

<link
  href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
  rel="stylesheet">

<!-- template-style-->

<link href="css/style.css" rel="stylesheet">

<link href="css/responsive.css" rel="stylesheet">

<!-- Bootstrap Select -->

<link rel='stylesheet'
  href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css'>

<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css'> -->



<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css'>

<link href="css/custom.css" rel="stylesheet">





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

                <li><a href="gallery">Gallery</a></li>

              </ul>

            </div>

            <div class="bread-title wow fadeInUp" data-wow-delay=".5s">
              <h1 class="text-white fs-3">Gallery</h1>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!--End Breadcrumb Area-->







<!--Start Portfolio-->

<section class="portfolio-page pad-tb">

  <div class="container">

    <div class="row justify-content-left">

      <div class="col-lg-3 slinlk v-center">

        <a class="active" href="gallery">Photo Gallery</a>

        <a class="lts" href="video">Video Gallery</a>

      </div>

      <div class="col-lg-9 v-center">

        <div class="filters">

          <ul class="filter-menu">

            <li data-filter="*" class="is-checked">All</li>
            <?php for ($i = 0; $i < count($this->rs_category); $i++) { ?>

              <li data-filter=".cat<?= $this->rs_category[$i]['id'] ?>"><?= $this->rs_category[$i]['name'] ?></li>
            <?php } ?>




          </ul>

        </div>

      </div>

    </div>

    <div class="row card-list">

      <div class="col-lg-4 col-md-6 grid-sizer"></div>


      <?php for ($i = 0; $i < count($this->rs_gallery); $i++) { ?>

        <div class="col-lg-4 col-sm-6 single-card-item cat<?= $this->rs_gallery[$i]['gallery_category_id'] ?>">

          <div class="isotope_item hover-scale">

            <div class="item-image">

              <a data-fancybox="gallery" data-src="uploads/gallery/<?= $this->rs_gallery[$i]['image'] ?>">

                <img src="uploads/gallery/<?= $this->rs_gallery[$i]['image'] ?>" alt="gallery" class="img-fluid" />

              </a>

            </div>

          </div>

        </div>

      <?php } ?>



    </div>

  </div>

</section>

<!--End Portfolio-->





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





<script src='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js'></script>

<script id="rendered-js">

  const myCarousel = new Carousel(document.querySelector("#myCarousel"), {

    preload: 1
  });





  Fancybox.assign('[data-fancybox="carousel-gallery"]', {

    closeButton: "top",

    Thumbs: false,

    Carousel: {

      Dots: true,

      on: {

        change: that => {

          myCarousel.slideTo(myCarousel.getPageforSlide(that.page), {

            friction: 0
          });



        }
      }
    }
  });

</script>



<?php include 'includes/general_data.php'; ?>