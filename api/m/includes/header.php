<?php include('includes/loader.php'); ?>

<input type="hidden" name="cityUrl" id="cityUrl" value="<?=$_SESSION['citySlug'];?>">

<?php if($this->getCurrentView()=='home') { ?>
<!-- Header Start -->
<header class="header">
    <div class="logo-wrap">
        <img src="assets/images/mdrc/icons/menu.svg" alt="" class="iconly-Category icli nav-bar img-fluid">
        <span class="font-sm d-flex align-items-center ms-2">
            <a href="javascript:void(0)" class="font-md fw-600 changeCityClick">
                <img src="assets/images/mdrc/icons/current-location.svg" alt="" class="img-fluid me-2"> <?=$_SESSION['cityName'];?> <i data-feather="chevron-down" class="wd-18 ht-18 mt-1"></i>
            </a>
        </span>
    </div>
    <div class="d-flex justify-content-center head-logo">
        <img src="assets/images/mdrc/logo/logo.png" alt="" class="d-block img-fluid">
    </div>
    <div class="avatar-wrap">
        <!-- <a href="tel:+91-124-6712000"><img src="assets/images/mdrc/home/call-mobile-header.png" alt="" class="icon-size-3 me-2"></a> -->
        <?php if($_SESSION['MDRCCustID']<=0){?>
        <a href="javascript:void(0)" class="ms-2 loginModal position-relative">
            <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
            <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?=count($this->rs_cartmini)?></span>
        </a>
        <?php } else {?>
        <a href="<?=SERVER_ROOT;?>/cart" class="position-relative">
            <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
            <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?=count($this->rs_cartmini)?></span>
        </a>
        <?php } ?>
    </div>
</header>
<!-- Header End -->
<?php } ?>

<?php 
$pageName='';
$backLink='';
if($this->getCurrentView()=='news_and_events') { $pageName='News and Events'; }
if($this->getCurrentView()=='news_and_events_details') { $pageName='News and Events Detail'; $backLink=M_SERVER_ROOT.'/news-and-events'; }

if($this->getCurrentView()=='my_wallet') { $pageName='My Wallet'; }
if($this->getCurrentView()=='my_family_friends') { $pageName='My Family Friends'; }

if($this->getCurrentView()=='test_booking_enquiry') { $pageName='Upload Prescription'; }

if($this->getCurrentView()=='page') { $pageName='Detail'; $backLink=M_SERVER_ROOT.'/my-account';}
if($this->getCurrentView()=='download_reports') { $pageName='Download Reports'; }

if($this->getCurrentView()=='diseases') { $pageName='Diseases'; }
if($this->getCurrentView()=='category') { $pageName='Category'; }

if($this->getCurrentView()=='search') { $pageName='Search'; }

if($this->getCurrentView()=='detail') { $pageName='Detail'; }
if($this->getCurrentView()=='checkout') { $pageName='Checkout'; $backLink=M_SERVER_ROOT.'/cart';}

if($this->getCurrentView()=='my_profile') { $pageName='My Profile'; }
if($this->getCurrentView()=='my_orders') { $pageName='My Orders'; }
if($this->getCurrentView()=='my_account') { $pageName='My Account'; }
if($this->getCurrentView()=='404') { $pageName='Page Not Found'; }
if($this->getCurrentView()=='about_us') { $pageName='About Us'; }
if($this->getCurrentView()=='blog') { $pageName='Blog'; }
if($this->getCurrentView()=='career') { $pageName='Career'; }
if($this->getCurrentView()=='gallery') { $pageName='Gallery'; }
if($this->getCurrentView()=='video_gallery') { $pageName='Video Gallery'; }
if($this->getCurrentView()=='radiology') { $pageName='Radiology'; }
if($this->getCurrentView()=='pathology') { $pageName='Pathology'; }
if($this->getCurrentView()=='cart') { $pageName='Cart'; }
if($this->getCurrentView()=='help_support') { $pageName='Help'; }

if($this->getCurrentView()=='our_doctors') { $pageName='Our Doctors'; }

if($this->getCurrentView()=='for_doctors') { $pageName='Our Expertise'; }
if($this->getCurrentView()=='service_details') { $pageName='Detail';  }

if($this->getCurrentView()=='faq') { $pageName='FAQs'; }

if($this->getCurrentView()=='contact_us') { $pageName='Reach Us'; }
if($this->getCurrentView()=='premium_health_checkup') { $pageName='Premium Health Checkup'; }
if($this->getCurrentView()=='blog_details') { $pageName='Blog Detail'; $backLink=M_SERVER_ROOT.'/blog'; }
if($this->getCurrentView()=='order_details') { $pageName='Order Detail'; $backLink=M_SERVER_ROOT.'/my-orders'; }

if($this->getCurrentView()=='payment_success') { $pageName='Booking Success'; $backLink=M_SERVER_ROOT.'/my-orders'; }
if($this->getCurrentView()=='payment_failed') { $pageName='Booking Failed'; $backLink=M_SERVER_ROOT.'/my-orders'; }

$backLink==''?M_SERVER_ROOT:$backLink;
?>

<?php if($pageName!='') { ?>
<!-- Header Start -->
<header class="header">
	<div class="logo-wrap">
        <?php if($backLink==''){ ?>
        <img src="assets/images/mdrc/icons/menu.svg" alt="" class="iconly-Category icli nav-bar img-fluid">
        <?php } else {?>
		<a href="<?=$backLink;?>"><i data-feather="chevron-left"></i></a>
        <?php } ?>
		<h2 class="fw-bold font-md"><?=$pageName;?></h2>
	</div>
    <div class="avatar-wrap">
       <!--  <a href="search/<?=$_SESSION['citySlug'];?>/a">
            <img src="assets/images/mdrc/icons/icon-search.svg" alt="">
        </a> -->
        <?php if($_SESSION['MDRCCustID']<=0){?>
        <a href="javascript:void(0)" class="ms-2 loginModal position-relative">
            <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
            <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?=count($this->rs_cartmini)?></span>
        </a>
        <?php } else {?>
        <a href="cart" class="ms-2 position-relative">
            <img src="assets/images/mdrc/icons/shopping-cart-2.svg" alt="">
            <span class="bg-white position-absolute border border-danger rounded-circle noti-count cartCount"><?=count($this->rs_cartmini)?></span>
        </a>
        <?php } ?>
    </div>
</header>
<!-- Header End -->
<?php } ?>

<!-- Sidebar Start -->
<?php include('includes/sidebar.php'); ?>
<!-- Sidebar End -->