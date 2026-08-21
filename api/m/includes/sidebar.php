<?php
if ($this->getCurrentView() == 'my_profile') {
    $profile = 'active';
} else if ($this->getCurrentView() == 'my_orders' || $this->getCurrentView() == 'order_detail') {
    $orders = 'active';
} else if ($this->getCurrentView() == 'my_wallet') {
    $wallet = 'active';
} else if ($this->getCurrentView() == 'my_family_friends') {
    $family = 'active';
} else if ($this->getCurrentView() == 'my_addresses') {
    $addresses = 'active';
} else if ($this->getCurrentView() == 'my_prescription') {
    $prescription = 'active';
} else if ($this->getCurrentView() == 'help_support') {
    $help = 'active';
}
$img_name = $this->rs_customer["image"];
$profile_img = $this->utility->get_image_path($img_name, 'customer', 'thumb');
?>
<!-- Sidebar Start -->
<a href="javascript:void(0)" class="overlay-sidebar"></a>
<aside class="header-sidebar">
    <div class="wrap">
        <? if ($_SESSION['MDRCCustID'] > 0) { ?>
            <div class="user-panel">
                <div class="media">
                    <a href="my-profile"> <img src="<?= $profile_img ?>" alt="<?= $_SESSION['MDRCCustFirstName'] ?>" /></a>
                    <div class="media-body">
                        <a href="my-profile" class="title-color font-sm"><?= $_SESSION['MDRCCustFirstName'] ?> <?= $_SESSION['MDRCCustLastName'] ?>
                            <span class="content-color font-xs">+91 <?= $_SESSION['MDRCCustPhone'] ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="user-panel">
                <div class="media">
                    <div class="media-body">
                        <a href="javascript:void(0)" class="title-color font-sm loginModal">Hello, Guest
                            <span class="content-color font-xs">Sing In / Sing Up</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Navigation Start -->
        <nav class="navigation">
            <ul>
                <? if ($_SESSION['MDRCCustID'] > 0) { ?>
                    <li>
                        <a href="javascript:void(0);" class="nav-link title-color font-sm">
                            <div>
                                <img src="assets/images/mdrc/sidebar/my-profile.svg" alt="">
                                <span>My Profile</span>
                            </div>
                            <span class="arrow"><i data-feather="chevron-right"></i></span>
                        </a>

                        <ul class="siderbar-submenu">
                            <li><a href="my-account">Edit Profile</a></li>
                            <li><a href="my-orders">My Orders</a></li>
                            <li><a href="my-wallet">My Wallet</a></li>
                            <li><a href="my-family-friends">My Family & Friends</a></li>
                        </ul>
                    </li>
                <? } ?>

                <li>
                    <a href="javascript:void(0)" class="nav-link title-color font-sm">
                        <div>
                            <img src="assets/images/mdrc/sidebar/file-text.svg" alt="">
                            <span>About Us</span>
                        </div>
                        <span class="arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="siderbar-submenu">
                        <li><a href="about-us">About</a></li>
                        <li><a href="our-doctors">Our Doctor</a></li>
                        <li><a href="news-and-events">News & Events</a></li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="gallery">Gallery</a></li>
                    </ul>
                </li>

                <?php if(count($this->rs_for_doctors)>0){?>
                <li>
                    <a href="javascript:void(0)" class="nav-link title-color font-sm">
                        <div>
                            <img src="assets/images/mdrc/sidebar/users.svg" alt="">
                            <span>Our Expertise</span>
                        </div>
                        <span class="arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="siderbar-submenu">
                        <?php for ($i=0; $i < count($this->rs_for_doctors) ; $i++) { ?>
                            <li><a href="<?=$this->rs_for_doctors[$i]['slug']?>"><?=$this->rs_for_doctors[$i]['title']?></a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php } ?>

                <li>
                    <a href="javascript:void(0)" class="nav-link title-color font-sm">
                        <div>
                            <img src="assets/images/mdrc/sidebar/help-support.svg" alt="">
                            <span>Reach Us</span>
                        </div>
                        <span class="arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="siderbar-submenu">
                        <li><a href="reach-us">Contact</a></li>
                        <li><a href="help-support">Help & Support</a></li>
                        <li><a href="career">Career</a></li>
                        
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)" class="nav-link title-color font-sm">
                        <div>
                            <img src="assets/images/mdrc/sidebar/my-order.svg" alt="">
                            <span>Book A Test</span>
                        </div>
                        <span class="arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="siderbar-submenu">
                        <li><a href="radiology/imaging-lab-tests-near/<?= $_SESSION['citySlug']; ?>">Radiology Scan Test</a></li>
                        <li><a href="pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Pathology Blood Test</a></li>
                        <li><a href="premium-health-checkup/<?= $_SESSION['citySlug']; ?>">Premium Health Checkup</a></li>
                        <li><a href="mdrc-test-booking-enquiry">Chat With Us</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)" class="nav-link title-color font-sm">
                        <div>
                            <img src="assets/images/mdrc/sidebar/faq.svg" alt="">
                            <span>FAQs</span>
                        </div>
                        <span class="arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="siderbar-submenu">
                        <li><a href="faq/frequently-asked-questions-imaging">Radiology Scan Test</a></li>
                        <li><a href="faq/frequently-asked-questions-pathology">Pathology Blood Test</a></li>
                    </ul>
                </li>

                <? if ($_SESSION['MDRCCustID'] > 0) { ?>
                    <li>
                        <a href="logout" class="nav-link title-color font-sm">
                            <div>
                                <i data-feather="log-in" class="theme-color wd-20 ht-20"></i>
                                <span>Log Out</span>
                            </div>
                            <span class="arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </nav>
        <!-- Navigation End -->
    </div>
</aside>
<!-- Sidebar End -->