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
            <a href="pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="footer-link">
                <i data-feather="search" class="text-white"></i>
            </a>
        </li>
        <li class="footer-item">
            <a href="<?=M_SERVER_ROOT;?>" class="footer-link">
                <span class="bottom-bar-logo">
                    <figure class="mb-0">
                        <img src="assets/images/favicon.png" />
                    </figure>
                </span>
            </a>
        </li>
        <li class="footer-item">
            <a href="help-support" class="footer-link">
                <i data-feather="phone" class="text-white"></i>
            </a>
        </li>
        <li class="footer-item">
            <? if($_SESSION['MDRCCustID']>0) { ?>
            <a href="my-account" class="footer-link"><img src="assets/images/mdrc/icons/profile.svg" alt=""></a>
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

<?php include('includes/modal.php'); ?>

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
<script src="assets/js/custom.js"></script>

<link rel="stylesheet" href="assets/js/notify/jquery.toastmessage.css">
<script src="assets/js/notify/jquery.toastmessage.js"></script>

<link href="assets/js/alert/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<script src="assets/js/alert/js/sweet-alert.min.js"></script>
<script src="assets/js/alert/js/jquery.sweet-alert.init.js"></script>

<!-- EXTERNAL API REMOVED: Google Maps -->
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

<?php if($this->rs_customer['name']=='' && $_SESSION['MDRCCustID']!=''){?>
<script>
$(document).ready(function(){            
	if ($.cookie('MDRCProfileDetail')) { //if cookie isset
	   
	} else {
		$.cookie("MDRCProfileDetail", "Yes", { expires: 1, secure: true , domain: 'mdrcindia.com'});
		$('#signup').offcanvas('show');
	}       
});
</script>
<?php }?>
