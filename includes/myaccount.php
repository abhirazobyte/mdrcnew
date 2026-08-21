<?php
if($this->getCurrentView()=='my_profile')
{
	$profile='active';
		
}
else if($this->getCurrentView()=='my_orders' || $this->getCurrentView()=='order_detail')
{
	$orders='active';
		
}
else if($this->getCurrentView()=='my_wallet')
{
	$wallet='active';
		
}
else if($this->getCurrentView()=='my_family_friends')
{
	$family='active';
		
}

else if($this->getCurrentView()=='my_addresses')
{
	$addresses='active';
		
}
else if($this->getCurrentView()=='my_prescription')
{
	$prescription='active';
		
}
else if($this->getCurrentView()=='help_support')
{
	$help='active';
		
}


$img_name=$this->rs_customer["image"];
$profile_img=$this->utility->get_image_path($img_name,'customer','thumb');
?>
<div class="col-lg-12 uinfo bg-white text-center col-12 p-5 mb20">
					<img class="rounded-circle userimg" src="<?=$profile_img?>" alt="customer">
					<h3 class="mb__10"><b>Hi</b> <?=$_SESSION['MDRCCustFirstName']?> <?=$_SESSION['MDRCCustLastName']?></h3>
					<p class="mb__0">+91 <?=$_SESSION['MDRCCustPhone']?></p>
				</div>
				<div class="col-lg-12 d-none d-lg-block d-md-block bg-white mb__20 col-12 links rounded p-0">
					<ul>
						<li><a class="<?=$profile?>" href="my-profile"><i class="fas fa-user"></i> My Profile</a></li>
						<li><a class="<?=$orders?>" href="my-orders"><i class="fas fa-box"></i> My Orders</a></li>
						<li><a class="<?=$wallet?>" href="my-wallet"><i class="fa fa-wallet"></i> My Wallet</a></li>
						<li><a class="<?=$family?>" href="my-family-friends"><i class="fas fa-users"></i> My Family & Friends</a></li>
						<li style="display:none"><a class="<?=$addresses?>" href="my-addresses"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
						<li><a class="<?=$prescription?>" href="mdrc-test-booking-enquiry"><i class="fas fa-file-alt"></i> Upload Prescription</a></li>
						<li><a class="<?=$help?>" href="help-support"><i class="fas fa-question-circle"></i> Help & Support</a></li>
						<li><a href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
					</ul>
				</div>