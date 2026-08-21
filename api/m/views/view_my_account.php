<?php include('includes/header.php'); ?>

<?php
$img_name=$this->rs_customer["image"];
$profile_img=$this->utility->get_image_path($img_name,'customer','thumb');
?>

<!-- Main Start -->
<main class="main-wrap account-page bg-gray page-common">
	<div class="account-wrap mt-3">
		<div class="row bg-white py-3 rounded mx-0 mb-3 align-items-center">
			<div class="col-9">
				<h2 class="fw-bolder font-md theme-color">Hi <?=$_SESSION['MDRCCustFirstName']?> <?=$_SESSION['MDRCCustLastName']?>!</h2>
				<p class="mb-0">+91 <?=$_SESSION['MDRCCustPhone']?></p>
			</div>
			<div class="col-3 d-flex justify-content-end">
				<figure class="mb-0 account-profile-img">
					<img src="<?=$profile_img?>" alt="" class="img-fluid">
				</figure>
			</div>
		</div>

		<div class="row align-items-stretch g-3">
			<div class="col-6 ">
				<a href="<?=M_SERVER_ROOT;?>/my-orders" class="d-flex align-items-center bg-white rounded p-3 h-100">
					<figure class="mb-0 me-2">
						<img src="assets/images/mdrc/sidebar/my-order.svg" alt="">
					</figure>
					<p class="mb-0 title-color font-sm">My Orders</p>
				</a>
			</div>
			<div class="col-6 ">
				<a href="<?=M_SERVER_ROOT;?>/help-support" class="d-flex align-items-center bg-white rounded p-3 h-100">
					<figure class="mb-0 me-2">
						<img src="assets/images/mdrc/sidebar/help-support.svg" alt="">
					</figure>
					<p class="mb-0 title-color font-sm">Help & Support</p>
				</a>
			</div>

		</div>

		<!-- Navigation Start -->
		<ul class="navigation">
			<li>
				<a href="<?=M_SERVER_ROOT;?>/my-profile" class="nav-link title-color font-sm">
					<div>
						<img src="assets/images/mdrc/sidebar/my-profile.svg" alt="" class="img-fluid">
						<span>My Profile</span>
					</div>
					<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
				
			</li>

			<li>
				<a href="my-wallet" class="nav-link title-color font-sm">
					<div>
						<img src="assets/images/mdrc/sidebar/wallet.svg" alt="" class="img-fluid">
						<span>My Wallet</span>
					</div>
					<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
				
			</li>

			<li>
				<a href="<?=M_SERVER_ROOT;?>/my-family-friends" class="nav-link title-color font-sm">
					<div>
					<img src="assets/images/mdrc/sidebar/users.svg" alt="" class="img-fluid">
					<span>My Family & Friends</span>
					</div>
					<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
				
			</li>

			<li>
				<a href="<?=M_SERVER_ROOT;?>/mdrc-test-booking-enquiry" class="nav-link title-color font-sm">
					<div>
					<img src="assets/images/mdrc/sidebar/file-text.svg" alt="" class="img-fluid">
					<span>Upload Prescription</span>				
					</div>
					<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
			</li>
		</ul>
		<!-- Navigation End -->

		<!-- Navigation 2 Start -->
		<ul class="navigation">
			<?php for ($i = 0; $i < count($this->rs_pages); $i++) {?>
			<li>
				<a href="<?=M_SERVER_ROOT;?>/page/<?=$this->rs_pages[$i]['slug'];?>" class="nav-link title-color font-sm">
					<div>
						<img src="assets/images/mdrc/sidebar/terms.svg" alt="" class="img-fluid">
						<span><?=$this->rs_pages[$i]['page_title'];?></span>
					</div>				
					<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
			</li>
			<?php }?>
		</ul>
		<!-- Navigation 2 End -->

		<!--Log Out Start -->
		<ul class="navigation">
			<li>
				<a href="<?=M_SERVER_ROOT;?>/logout" class="nav-link title-color font-sm">
					<div>
					<img src="assets/images/mdrc/account/log-out.svg" alt="" class="img-fluid">
					<span>Log Out</span>				
					</div>
				<span class="arrow"><i data-feather="chevron-right"></i></span>
				</a>
			</li>
		</ul>
		<!-- Log Out End -->
	</div>
</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer Start -->