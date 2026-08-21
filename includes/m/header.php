<?php
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
$query_str = parse_url($url, PHP_URL_QUERY);
parse_str($query_str, $query_params);
if ($query_params['callfrom'] != 'app') { ?>
    <?php include('loader.php'); ?>
<?php } ?>

<input type="hidden" name="cityUrl" id="cityUrl" value="<?= $_SESSION['citySlug']; ?>">

<?php if ($this->getCurrentView() == 'home') { ?>
    <!-- Header Start -->

    <header class="header header-home-1">
        <div class="header-top bg-theme">
            <div class="d-flex justify-content-between">
                <!-- <a href="https://play.google.com/store/apps/details?id=com.mdrcindia.booking" class="h-top-left d-flex gap-2 align-items-center">
        <i class="fas fa-mobile-alt text-white"></i>  
          <p class="m-0 text-white small">Download Mobile App</p>
        </a> -->
                <div class="d-flex align-items-center">
                    <a href="https://play.google.com/store/apps/details?id=com.mdrcindia.booking" target="_blank">
                        <img alt="" class="lazy" src="assets/images/android.png" style="max-width:55px">
                    </a>
                    <a href="https://apps.apple.com/us/app/modern-diagnostic-health-app/id6504657715" target="_blank">
                        <img alt="" class="ms-2 lazy" src="assets/images/apple.png" style="max-width:55px">
                    </a>
                </div>
                <div class="h-top-right d-flex gap-2 align-items-center">
                    <div>
                        <div id="google_translate_element"></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                                new google.translate.TranslateElement({
                                    pageLanguage: 'en',
                                    includedLanguages: 'hi,gu,bn,te,ta,ur,en,kn,mr,ml',
                                }, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </div>
                    <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" class="top-icon">
                        <span>
                            <i class="fab fa-whatsapp text-success"></i>
                        </span>
                    </a>
                    <a href="tel:<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91124-6712000'; ?>" class="top-icon">
                        <span class="rotate-1">
                            <i class="fas fa-phone-volume"></i>
                        </span>
                    </a>
                    <!-- <p class="m-0 text-white small"><a class="text-white" href="tel:<?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91124-6712000'; ?>"><?php echo !empty($_SESSION['cityPhone']) ? $_SESSION['cityPhone'] : '+91124-6712000'; ?></a></p> -->
                </div>
            </div>

        </div>
        <div class="d-flex header-bottom align-items-center">
            <div class="logo-wrap">
                <img src="assets/images/mdrc/icons/menu.svg" alt="" class="iconly-Category icli nav-bar img-fluid">
                <div class="d-flex justify-content-center head-logo ms-2">
                    <img src="assets/images/mdrc/logo/logo.webp" alt="" class="d-block img-fluid">
                </div>
            </div>

            <?php if ($_SESSION['cityCertificateImage'] != '') { ?>
                <span class="font-sm d-flex align-items-center ms-2 m-site-header-certificate">
                    <img src="<?= $_SESSION['SERVER_ROOT']; ?>/uploads/city/<?= $_SESSION['cityCertificateImage']; ?>" alt="Certificates" class="w-100">
                </span>
            <?php } ?>
            <span class="font-sm d-flex align-items-center ms-2 msite-header-city-name">
                <a href="javascript:void(0)" class="font-md fw-600 changeCityClick ">
                    <img src="assets/images/mdrc/icons/current-location.svg" alt="" class="img-fluid d-none">
                    <span class="d-block small text-secondary s-text">Your Location</span>
                    <div class="d-flex align-items-center  h-location-text">
                        <?= $_SESSION['cityName']; ?> <i data-feather="chevron-down" class="wd-18 ht-18"></i>
                    </div>
                </a>
            </span>

            <div class="avatar-wrap">
                <!-- <a href="tel:+91-124-6712000"><img src="assets/images/mdrc/home/call-mobile-header.png" alt="" class="icon-size-3 me-2"></a> -->
                <?php if ($_SESSION['MDRCCustID'] <= 0) { ?>
                    <a href="javascript:void(0)" class="ms-2 loginModal position-relative">
                        <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
                        <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?= count($this->rs_cartmini) ?></span>
                    </a>
                <?php } else { ?>
                    <a href="<?= SERVER_ROOT; ?>/cart" class="position-relative">
                        <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
                        <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?= count($this->rs_cartmini) ?></span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </header>
    <!-- Header End -->
<?php } ?>

<?php
$pageName = '';
$backLink = '';
if ($this->getCurrentView() == 'news_and_events') {
    $pageName = 'News and Events';
}
if ($this->getCurrentView() == 'news_and_events_details') {
    $pageName = 'News and Events Detail';
    $backLink = M_SERVER_ROOT . '/news-and-events';
}

if ($this->getCurrentView() == 'my_wallet') {
    $pageName = 'My Wallet';
}
if ($this->getCurrentView() == 'my_family_friends') {
    $pageName = 'My Family Friends';
}

if ($this->getCurrentView() == 'test_booking_enquiry') {
    $pageName = 'Upload Prescription';
}
if ($this->getCurrentView() == 'test_booking_enquiry_new') {
    $pageName = 'Upload Prescription';
}

if ($this->getCurrentView() == 'page') {
    $pageName = 'Detail';
    $backLink = M_SERVER_ROOT . '/my-account';
}
if ($this->getCurrentView() == 'download_reports') {
    $pageName = 'Download Reports';
}

if ($this->getCurrentView() == 'diseases') {
    $pageName = 'Diseases';
}
if ($this->getCurrentView() == 'category') {
    $pageName = 'Category';
}

if ($this->getCurrentView() == 'search') {
    $pageName = 'Search';
}
if ($this->getCurrentView() == 'home_sample_collection') {
    $pageName = 'Blood Sample Collection';
}

if ($this->getCurrentView() == 'detail') {
    $pageName = 'Detail';
}
if ($this->getCurrentView() == 'checkout') {
    $pageName = 'Checkout';
    $backLink = M_SERVER_ROOT . '/cart';
}

if ($this->getCurrentView() == 'my_profile') {
    $pageName = 'My Profile';
}
if ($this->getCurrentView() == 'my_orders') {
    $pageName = 'My Orders';
}
if ($this->getCurrentView() == 'my_account') {
    $pageName = 'My Account';
}
if ($this->getCurrentView() == '404') {
    $pageName = 'Page Not Found';
}
if ($this->getCurrentView() == 'about_us') {
    $pageName = 'About Us';
}
if ($this->getCurrentView() == 'ipo') {
    $pageName = 'Ipo';
}
if ($this->getCurrentView() == 'policies') {
    $pageName = 'Policies';
}
if ($this->getCurrentView() == 'tdm') {
    $pageName = 'Therapeutic Drug Monitoring';
}
if ($this->getCurrentView() == 'oncology') {
    $pageName = 'Oncology';
}
if ($this->getCurrentView() == 'pregnancy_care') {
    $pageName = 'Pregnancy Care';
}
if ($this->getCurrentView() == 'blog') {
    $pageName = 'Blog';
}
if ($this->getCurrentView() == 'career') {
    $pageName = 'Career';
}
if ($this->getCurrentView() == 'gallery') {
    $pageName = 'Gallery';
}
if ($this->getCurrentView() == 'video_gallery') {
    $pageName = 'Video Gallery';
}
if ($this->getCurrentView() == 'radiology') {
    $pageName = 'Book your Test';
}
if ($this->getCurrentView() == 'pathology') {
    $pageName = 'Book your Test';
}
if ($this->getCurrentView() == 'cart') {
    $pageName = 'Cart';
}
if ($this->getCurrentView() == 'help_support') {
    $pageName = 'Help';
}
if ($this->getCurrentView() == 'paynow') {
    $pageName = 'Pay Now';
}

if ($this->getCurrentView() == 'our_doctors') {
    $pageName = 'Our Doctors';
}

if ($this->getCurrentView() == 'for_doctors') {
    $pageName = 'Our Expertise';
}
if ($this->getCurrentView() == 'service_details') {
    $pageName = 'Detail';
}

if ($this->getCurrentView() == 'faq') {
    $pageName = 'FAQs';
}

if ($this->getCurrentView() == 'contact_us') {
    $pageName = 'Reach Us';
}
if ($this->getCurrentView() == 'premium_health_checkup') {
    $pageName = 'Premium Health Checkup';
}
if ($this->getCurrentView() == 'blog_details') {
    $pageName = 'Blog Detail';
    $backLink = M_SERVER_ROOT . '/blog';
}
if ($this->getCurrentView() == 'order_details') {
    $pageName = 'Order Detail';
    $backLink = M_SERVER_ROOT . '/my-orders';
}

if ($this->getCurrentView() == 'payment_success') {
    $pageName = 'Booking Success';
    $backLink = M_SERVER_ROOT . '/my-orders';
}
if ($this->getCurrentView() == 'payment_failed') {
    $pageName = 'Booking Failed';
    $backLink = M_SERVER_ROOT . '/my-orders';
}

$backLink == '' ? M_SERVER_ROOT : $backLink;
?>

<?php if ($pageName != '') { ?>
    <!-- Header Start -->
    <header class="header header-2-single">
        <div class="logo-wrap">
            <?php if ($backLink == '') { ?>
                <img src="assets/images/mdrc/icons/menu.svg" alt="" class="iconly-Category icli nav-bar img-fluid">
            <?php } else { ?>
                <a href="<?= $backLink; ?>"><i data-feather="chevron-left"></i></a>
            <?php } ?>

            <a href="<?= SERVER_ROOT; ?>" class="homeIcon ps-2 pe-2 d-block"><i data-feather="home"></i></a>

            <h2 class="fw-bold font-md"><?= $pageName; ?></h2>
        </div>
        <div class="avatar-wrap">
            <!--  <a href="search/<?= $_SESSION['citySlug']; ?>/a">
            <img src="assets/images/mdrc/icons/icon-search.svg" alt="">
        </a> -->
            <?php if ($_SESSION['MDRCCustID'] <= 0) { ?>
                <a href="javascript:void(0)" class="ms-2 loginModal position-relative">
                    <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
                    <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?= count($this->rs_cartmini) ?></span>
                </a>
            <?php } else { ?>
                <a href="<?= SERVER_ROOT; ?>/cart" class="ms-2 position-relative">
                    <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
                    <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?= count($this->rs_cartmini) ?></span>
                </a>
            <?php } ?>
        </div>
    </header>
    <!-- Header End -->
<?php } ?>

<!-- Sidebar Start -->
<?php include('sidebar.php'); ?>
<!-- Sidebar End -->

<?php
if ($query_params['callfrom'] == 'app') { ?>
    <style>
        header,
        .whatsapp-sticky,
        .msite-footer,
        .msite-footer-bottom-space,
        .msite-footer-payment {
            display: none !important;
            visibility: hidden !important;
        }

        .page-common {

            margin-top: 0px !important;
        }
    </style>
<?php } ?>