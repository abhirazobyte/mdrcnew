<section class="msite-footer main-wrap pb-3 pt-3">
    <div class="row g-3 align-items-stretch">
      <div class="col-6">
        <h5 class="font-md">Quick Link</h5>
        <ul class="navigation">
            <li><a href="<?=M_SERVER_ROOT;?>/modern-imaging">Modern Imaging</a></li>
            <li><a href="<?=M_SERVER_ROOT;?>/super-specialised-services">Super Specialised Services</a></li>
            <li><a href="<?=M_SERVER_ROOT;?>/imaging-test-information">Imagine test Information</a></li>
            <li><a href="<?=M_SERVER_ROOT;?>/pathology-lab-information">Pathology Lab Test Information</a></li>
            <li><a href="<?=M_SERVER_ROOT;?>/home-sample-collection/<?=$_SESSION['citySlug'];?>">Home Sample Collection</a></li>
            <li><a href="<?=M_SERVER_ROOT;?>/paynow">Pay Now</a></li>
        </ul>
      </div>
      <div class="col-6">
        <h5 class="font-md">Premium Health Checkup</h5>
        <ul class="navigation">
            <?php for($i=0;$i<count($this->rs_footer_popular_item);$i++){?>
                <li><a href="<?=M_SERVER_ROOT;?>/tests/<?=$this->rs_footer_popular_item[$i]['slug']?>/<?=$_SESSION['citySlug'];?>"><?=$this->rs_footer_popular_item[$i]['name']?></a></li>
            <?php }?>
        </ul>
      </div>
      <div class="col-12 pt-3 d-flex justify-content-center">
        <h5 class="">Follow us on &nbsp;</h5>
        <div class="footer-social-media-icons">
            <a href="https://m.facebook.com/MdrcIndia/" target="blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://youtube.com/channel/UCwZECfhGeCu8o6CvAST95CQ" target="blank"><i class="fab fa-youtube"></i></a>
            <a href="https://www.linkedin.com/company/modern-diagnostic-research-centre/" target="blank"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://mobile.twitter.com/mdrcindia" target="blank"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
</section>

<section class="main-wrap pb-3 pt-3 bg-white">
    <div class="row g-3 align-items-stretch">
        <div class="col-12">
            <h5 class="font-md" style="font-weight: 700;">Payment Option <br />
                <img src="<?=SERVER_ROOT;?>/images/img-cards.png" alt="Payment method" style="max-width: 340px;">
            </h5>
        </div>
    </div>
</section>

<section class="msite-footer-bottom-space main-wrap pb-3 pt-3">
    <div class="row g-3 align-items-stretch">
      <div class="col-12">
        ©2023 All right reserved. Modern Diagnostic & Research Centre Pvt. Ltd.
      </div>
    </div>
</section>

<?php
$pages=['home',"my_profile","my_account"];
?>
<?php if(in_array($this->getCurrentView(),$pages)){ ?>
<!-- Footer Start ---------------------->
<footer class="footer-wrap">
    <ul class="footer">
        <li class="footer-item active">
            <a href="<?=M_SERVER_ROOT;?>" class="footer-link">
                <i class="iconly-Home icli"></i>
            </a>
        </li>
        <li class="footer-item">
            <a href="<?=M_SERVER_ROOT;?>/pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="footer-link">
                <i data-feather="search" class="text-white"></i>
            </a>
        </li>
        <li class="footer-item">
            <a href="<?=M_SERVER_ROOT;?>/premium-health-checkup/<?=$_SESSION['citySlug'];?>" class="footer-link">
                <span class="bottom-bar-logo">
                    <figure class="mb-0">
                        <img src="assets/images/favicon.png" />
                    </figure>
                </span>
            </a>
        </li>
        <li class="footer-item">
            <a href="<?=M_SERVER_ROOT;?>/help-support" class="footer-link">
                <i data-feather="phone" class="text-white"></i>
            </a>
        </li>
        <li class="footer-item">
            <? if($_SESSION['MDRCCustID']>0) { ?>
            <a href="<?=M_SERVER_ROOT;?>/my-account" class="footer-link"><img src="assets/images/mdrc/icons/profile.svg" alt=""></a>
            <?php } else {?>
            <a href="javascript:void(0)" class="footer-link loginModal"><img src="assets/images/mdrc/icons/profile.svg" alt=""></a>
            <?php } ?>
        </li>
    </ul>
</footer>
<!-- Footer End ------------------->
<?php } ?>

<?php if($this->getCurrentView()!='checkout') { ?>
<!-- Whats App image Sticky Start -->
<div class="whatsapp-sticky">
  <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?"><img src="assets/images/mdrc/home/chat-healthagent.png" alt="" class="img-fluid object-cover"></a>
</div>
<!-- Whats App image Sticky End -->
<?php } ?>

<div id="ajax_modal_container" class="ajax_modal_container"></div>

<?php include('modal.php'); ?>

<!-- jquery 3.6.0 -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Js -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- Lord Icon -->
<script src="assets/js/lord-icon-2.1.0.js"></script>
<!-- Feather Icon -->
<script src="assets/js/feather.min.js"></script>
<!-- Slick Slider js -->
<script src="assets/js/slick.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/slick-custom.js"></script>
<!-- Add To Home  js -->
<script src="assets/js/homescreen-popup.js"></script>
<!-- Theme Setting js -->
<script src="assets/js/theme-setting.js"></script>
<!-- Script js -->
<script src="assets/js/script.js"></script>

<?php if($this->getCurrentView()=='gallery') { ?>
<!-- Custom js -->
<script src="assets/js/gallery.js"></script>
<?php } ?>

<link rel="stylesheet" href="assets/js/searchjs/jquery-ui.min.css">
<script src="assets/js/searchjs/jquery-ui.min.js"></script>

<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/custom.js?ver=1"></script>

<link rel="stylesheet" href="assets/js/notify/jquery.toastmessage.css">
<script src="assets/js/notify/jquery.toastmessage.js"></script>

<link href="assets/js/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<script src="assets/js/alert/js/sweet-alert.min.js"></script>
<script src="assets/js/alert/js/jquery.sweet-alert.init.js"></script>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCx56a0ngffZltDpaIyCZQ06UJKRVXT6g4"></script>
<script src="assets/js/map/google.js"></script>


<script>
    $( document ).ready(function() {
        $(function() {
    $(".header-sidebar .nav-link").click(function() {
        $(this).next('.siderbar-submenu') .slideToggle(500);        
        $(this).children('.arrow').toggleClass("arrow-rotate");
    });
}); 
});

</script>

