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
<link href="css/custom.css?v=2.1" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php'; ?>
<!--End Header -->
<!--Breadcrumb Area-->
<style>
    .blog-page ul,
    .blog-page ol {
        font-size: 17px;
        line-height: 28px;
        padding-left: 0;
        margin-bottom: 20px;
        color: #000;
    }

    .blog-page ol {
        padding-left: 19px;
    }

    .blog-page ul li,
    .blog-page ol li {
        margin-bottom: 10px;
        color: #000;
    }

    .btn-red {
        background-color: #ec1c24;
        width: 100%;
    }

    .btn-red img {
        filter: brightness(0) invert(1);
        height: 20px;
        width: 20px;
        display: flex;
    }

    .blog-recent-post .media .post-info h3 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .blog-recent-post .media .post-image img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.375rem;
    }

    .btn-blue,
    .bg-darkblue {
        background-color: #1e73b1;
    }

    .custom-form-wrapper {
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .custom-form-header {
        background-color: #33b5e5;
        color: #fff;
        padding: 12px 0;
        border-radius: 10px 10px 0 0;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .custom-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .custom-input:focus {
        outline: none;
        border-color: #33b5e5;
        box-shadow: 0 0 5px rgba(51, 181, 229, 0.5);
    }

    .custom-checkbox-label {
        font-size: 0.85rem;
        color: #555;
    }

    .custom-submit-btn {
        background-color: #33b5e5;
        color: #fff;
        padding: 10px 30px;
        font-weight: 600;
        border-radius: 6px;
        border: none;
    }

    .custom-submit-btn:hover {
        background-color: #28a4d9;
        color: white;
    }

    @media (max-width: 576px) {
        .custom-form-wrapper {
            padding: 20px 15px;
        }
    }

    .error {
        height: auto;
    }
</style>

<section class="breadcrumb-area banner-6">
    <div class="text-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-start v-center">
                    <div class="bread-inner">
                        <div class="bread-menu wow fadeInUp" data-wow-delay=".2s">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="blog-details">Blog Details</a></li>
                            </ul>
                        </div>
                        <div class="bread-title wow fadeInUp" data-wow-delay=".5s">
                            <h2 class="fs-2 text-white">Blog Details</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Breadcrumb Area-->
<!--Start Blog Grid-->
<section class="blog-page pad-tb pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php
                $id = $this->records['id'];
                $blog_category_name = $this->records['blog_category_name'];
                $name = $this->records['name'];
                $about_info = $this->records['about_info'];
                $folder = $this->records['folder'];
                $image = $this->records['image'];
                $blogImage = $this->utility->get_image_path($image, 'blog/' . $folder . '/', 'large');
                $date = $this->records['entry_date_time'];
                $old_date = date_create($date);
                $new_date = date_format($old_date, "M d, Y");
                $formattedDate = date('j M Y', strtotime($date));
                ?>
                <div class="blog-header">
                    <h5 class="text-202024"><?= $blog_category_name ?></h5>
                    <!-- <h5 class="text-202024 text-blue">Last updated on: <?= $formattedDate ?></h5> -->
                    <h1 class="text-202024"><?= $name ?></h1>
                    <div class="row mt20 mb20">
                        <div class="col-md-8 col-9">
                            <div class="media">
                                <div class="media-body user-info">
                                    <h5>By Admin</h5>
                                    <p><?= $new_date ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-3">
                        </div>
                    </div>
                </div>
                <div class="image-set"><img src="<?= $blogImage ?>" alt="blog images" class="img-fluid" /></div>
                <div class="blog-content mt30">
                    <div><?= $about_info ?></div>
                    <div class="row mt30">
                        <div class="col-lg-8 col-md-8 mt30 mb30">
                            <div class="blog-post-tag">
                                <h5>Releted Tags</h5>
                                <?php for ($i = 0; $i < count($this->rs_blog_tag); $i++) { ?>
                                    <a href="blog/tag/<?= $this->rs_blog_tag[$i]['slug'] ?>"><?= $this->rs_blog_tag[$i]['name'] ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 mt30 mb30">
                            <div class="blog-share-icon text-left text-md-right">
                                <span>Share: </span>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                <a href="#"><i class="fab fa-vimeo-v"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Blog Details-->
            <!--Start Sidebar-->
            <div class="col-lg-6">

                <div class="custom-form-wrapper  shadow-lg rounded">
                    <h3 class="custom-form-header text-center mb-3">Book Your Blood Test</h3>
                    <p class="text-center mb-0">Schedule your appointment in less than a minute.</p>

                    <form id="GetCallBackForm1" name="GetCallBackForm1" class="shake p-3">
                        <div class="row g-3 mb-3">
                            <div class="form-group col-md-6">
                                <input type="text" id="name" name="name" placeholder="Name *" class="custom-input" data-error="Please fill Out">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="phone" name="phone" class="numbers numbersOnly custom-input" placeholder="Mobile No. *">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">

                            <div class="form-group col-md-6">
                                <select name="city" id="city" class="custom-input">
                                    <option value="">Select City *</option>
                                    <?php for ($i = 0; $i < count($this->rs_gs_city); $i++) { ?>
                                        <option value="<?= $this->rs_gs_city[$i]['name'] ?>"><?= $this->rs_gs_city[$i]['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="fmessage" name="fmessage" placeholder="Message" class="custom-input" data-error="Please fill Out">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="row g-3 mb-0">

                            <div class="form-group col-md-12">
                                <div class="help-block with-errors"></div>
                                <button type="submit" id="form-submit" data-form="GetCallBackForm1" class="btn custom-submit-btn w-100 get-call-back-submit">Submit <span class="circle"></span></button>
                            </div>
                            <span class="d-none thankYouMessage text-success">Thank You For Appointment Inquiry</span>
                        </div>
                    </form>
                </div>

                <div class="sidebar">

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
                    <!--End Blog Category-->
                    <!--Start Recent post-->
                    <?php if (count($this->recent_blog) > 0) { ?>
                        <div class="recent-post widgets">
                            <h3 class="mb30">Recent post</h3>
                            <?php for ($i = 0; $i < count($this->recent_blog); $i++) {
                                $name = $this->recent_blog[$i]['name'];
                                $folder = $this->recent_blog[$i]['folder'];
                                $image = $this->recent_blog[$i]['image'];
                                $blogImage = $this->utility->get_image_path($image, 'blog/' . $folder . '/', 'large');
                                $date = $this->recent_blog[$i]['entry_date_time'];
                                $old_date = date_create($date);
                                $new_date = date_format($old_date, "M d, Y");
                                $slug = $this->recent_blog[$i]['slug'];
                                $detail_slug = 'blog/detail/' . $slug . '';
                            ?>
                                <div class="media">
                                    <div class="post-image bdr-radius">
                                        <a href="<?= $detail_slug ?>"><img src="<?= $blogImage ?>" alt="" class="img-fluid" /></a>
                                    </div>
                                    <div class="media-body post-info">
                                        <h5><a href="<?= $detail_slug ?>"><?= $name ?></a></h5>
                                        <p><?= $new_date ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <!--Start Recent post-->
                    <!--Start Tags-->
                    <?php if (count($this->rs_tag) > 0) { ?>
                        <div class="recent-post widgets mt60">
                            <h3 class="mb30">Most Used Tags</h3>
                            <div class="tabs">
                                <?php for ($i = 0; $i < count($this->rs_tag); $i++) { ?>
                                    <a href="blog/tag/<?= $this->rs_tag[$i]['slug'] ?>"><?= $this->rs_tag[$i]['name'] ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Blog Grid-->

<?php if ($this->items_records != '' && count($this->items_records) > 0) { ?>
    <section class="pt40 pb50  radio-scantest-new healthSection-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 section-title text-center mb20">
                    <div class="common-heading-2">
                        <h3 class="fs-2 fw-bold text-202024">Other Health Tests & Packages</h3>
                    </div>
                </div>
            </div>
            <div class="row position-relative">
                <div class="col-12">
                    <div class="radiology-scans owl-carousel common-slider">
                        <?php for ($c = 0; $c < count($this->items_records); $c++) {
                            $item = $this->items_records[$c];
                            $id = $item['id'];
                            if ($item['image'] != '') {
                                $image = $this->get_user_config("item") . $item['folder'] . '/' . $item['image'];
                            } else {
                                $image = 'uploads/default.png';
                            }
                            $name = $item['name'];
                            $test_count = $item['test_count'];
                            $price = $item['item_price_price'];
                            $item_price_id = $item['item_price_id'];
                            $mrp = $item['item_price_mrp'];
                            $url = 'tests/' . $item['slug'] . '/' . $_SESSION['citySlug'];
                            $price_html = $this->utility->packagePrice($id, $price, $mrp);
                        ?>
                            <div class="health-test rounded p-2 pricing-table">
                                <img data-src="<?= $image ?>" alt="health test" class="img-fluid owl-lazy rounded">
                                <div class="py-2">
                                    <a href="<?= $url ?>" class="text-blue fs-5">
                                        <?= $name ?></a>
                                    <div class="my-3">
                                        <p class="badge bg-secondary rounded-pill px-3 py-2e fw-normal">
                                            Total no. of tests : <?= $test_count ?>
                                        </p>
                                    </div>
                                    <h4 class="fs-4 text-dark"><?= $price_html ?></h4>
                                    <a href="javascript:void(0)" data-item_price_id="<?= $item_price_id ?>" data-item_id="<?= $id ?>" class="add_to_cart btn-main bg-btn1 lnk btn-red rounded text-white book-now mt-3 d-inline-flex align-items-center justify-content-center btncart" style="font-size:16px;">Book Now</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="owl-theme">
                    <div class="owl-controls">
                        <div class="custom-nav owl-nav"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

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