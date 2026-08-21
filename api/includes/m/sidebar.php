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
                    <a href="<?= M_SERVER_ROOT; ?>/my-profile"> <img src="<?= $profile_img ?>" alt="<?= $_SESSION['MDRCCustFirstName'] ?>" /></a>
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
                        <a href="javascript:void(0)" class="text-white font-sm loginModal">Hello, Guest
                            <span class="text-white font-xs">Sign In / Sign Up</span>
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
                            <li><a href="<?= M_SERVER_ROOT; ?>/my-account">Edit Profile</a></li>
                            <li><a href="<?= M_SERVER_ROOT; ?>/my-orders">My Orders</a></li>
                            <li><a href="<?= M_SERVER_ROOT; ?>/my-wallet">My Wallet</a></li>
                            <li><a href="<?= M_SERVER_ROOT; ?>/my-family-friends">My Family & Friends</a></li>
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
                        <li><a href="<?= M_SERVER_ROOT; ?>/about-us">About Us</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/our-doctors">Our Doctor</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/news-and-events">News & Events</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/blog">Blog</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/gallery">Gallery</a></li>
                    </ul>
                </li>

                <?php if (count($this->rs_for_doctors) > 0) { ?>
                    <li>
                        <a href="javascript:void(0)" class="nav-link title-color font-sm">
                            <div>
                                <img src="assets/images/mdrc/sidebar/users.svg" alt="">
                                <span>Our Expertise</span>
                            </div>
                            <span class="arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="siderbar-submenu">
                            <?php for ($i = 0; $i < count($this->rs_for_doctors); $i++) { ?>
                                <li><a href="<?= M_SERVER_ROOT; ?>/<?= $this->rs_for_doctors[$i]['slug'] ?>"><?= $this->rs_for_doctors[$i]['title'] ?></a></li>
                            <?php } ?>
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
                        <li><a href="<?= M_SERVER_ROOT; ?>/reach-us">Contact</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/help-support">Help & Support</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/career">Career</a></li>

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
                        <li><a href="<?= M_SERVER_ROOT; ?>/radiology/imaging-lab-tests-near/<?= $_SESSION['citySlug']; ?>">Radiology Scan Test</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/pathology/lab-blood-test-near/<?= $_SESSION['citySlug']; ?>">Pathology Blood Test</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/premium-health-checkup/<?= $_SESSION['citySlug']; ?>">Premium Health Checkup</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/mdrc-test-booking-enquiry">Chat With Us</a></li>
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
                        <li><a href="<?= M_SERVER_ROOT; ?>/faq/frequently-asked-questions-imaging">Radiology Scan Test</a></li>
                        <li><a href="<?= M_SERVER_ROOT; ?>/faq/frequently-asked-questions-pathology">Pathology Blood Test</a></li>
                    </ul>
                </li>

                <? if ($_SESSION['MDRCCustID'] > 0) { ?>
                    <li>
                        <a href="<?= M_SERVER_ROOT; ?>/logout" class="nav-link title-color font-sm">
                            <div>
                                <i data-feather="log-in" class="theme-color wd-20 ht-20"></i>
                                <span>Log Out</span>
                            </div>
                            <span class="arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                    </li>
                <? } ?>
            </ul>
            <p class="s-down-text">Download the Modern Diagnostic App <br> <span>4.8 Rating <sup><i class="fas fa-star text-warning"></i></sup></span></p>
            <div class="mb-2">
                <a href="https://play.google.com/store/apps/details?id=com.mdrcindia.booking" class="instal-b-img">
                    <img src="assets/images/mdrc/logo/android.png" alt="">
                </a>
            </div>
            <div>

                <a href="https://apps.apple.com/us/app/modern-diagnostic-health-app/id6504657715" class=" instal-b-img" target="_blank">
                    <img src="assets/images/mdrc/logo/apple.png" alt="" class="">
                </a>
            </div>


        </nav>
        <!-- Navigation End -->
    </div>
</aside>
<!-- Sidebar End -->