<?php include('includes/header.php'); ?>
<main class="main-btm-pd bg-white page-common main-wrap">
	<div class="conatcdetails mb-3 pt-3">
		<div class="row g-3 justify-content-center">
			<?php if($this->gs['contact_number']!=''){?>
			<div class="col-12">
				<div class="card shadow1 rounded-15 bg-white py-2 px-3">
					<div class="d-flex align-items-center">
						<figure class="mb-2">
							<img src="assets/images/mdrc/contact/call.svg" alt="" class="wd-30 ht-30">
						</figure>
						<a href="tel:<?=$this->gs['contact_number']?>" class="text-dark font-sm fw-600 ms-2"><?=$this->gs['contact_number']?></a>
					</div>
				</div>
			</div>
			<?php }?>
			<?php if($this->gs['contact_number1']!=''){?>
			<div class="col-12">
				<div class="card shadow1 rounded-15 bg-white py-2 px-3">
					<div class="d-flex align-items-center">
						<figure class="mb-2">
							<img src="assets/images/mdrc/contact/whatsapp.svg" alt="" class="wd-30 ht-30">
						</figure>
						<a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" class="text-dark font-sm fw-600 d-block ms-2"><?=$this->gs['contact_number1']?></a>
					</div>
				</div>
			</div>
			<?php }?>
			<?php if($this->gs['contact_email']!=''){?>
			<div class="col-12">
				<div class="card shadow1 rounded-15 bg-white py-2 px-3">
					<div class="d-flex align-items-center">
						<figure class="mb-2">
							<img src="assets/images/mdrc/contact/mail.svg" alt="" class="wd-30 ht-30">
						</figure>
						<a href="mailto:<?=$this->gs['contact_email']?>" class="text-dark font-sm fw-600 d-block ms-2"><?=$this->gs['contact_email']?></a>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
	<div class="contact-addresss mb-3 ">
		<div class="row g-3">
			
			<?php for($i=0;$i<count($this->rs_branch);$i++){?>
			<div class="col-12">
				<div class="card p-3">
					<h3 class="font-md fw-600 mb-3"><?=$this->rs_branch[$i]['name']?></h3>
					<div class="d-flex align-items-center mb-2">
						<span><i data-feather="map-pin" class="icon-size-2 theme-color"></i></span>
						<p class="mb-0 text-secondary font-xs ms-2"><?=$this->rs_branch[$i]['address']?></p>
					</div>
					<?php if($this->rs_branch[$i]['phone1']!=''){?>
					<div class="d-flex align-items-center mb-2">
						<span><i data-feather="phone" class="icon-size-2 theme-color"></i></span>
						<a href="tel:<?=$this->rs_branch[$i]['phone1']?>" class="d-block text-secondary font-xs ms-2"><?=$this->rs_branch[$i]['phone1']?></a>
					</div>
					<?php }?>
					<?php if($this->rs_branch[$i]['phone2']!=''){?>
					<div class="d-flex align-items-center mb-2">
						<span><i data-feather="phone" class="icon-size-2 theme-color"></i></span>
						<a href="tel:<?=$this->rs_branch[$i]['phone2']?>" class="d-block text-secondary font-xs ms-2"><?=$this->rs_branch[$i]['phone2']?></a>
					</div>
					<?php }?>
					<?php if($this->rs_branch[$i]['email1']!=''){?>
					<div class="d-flex align-items-center">
						<span><i data-feather="mail" class="icon-size-2 theme-color"></i></span>
						<a href="mailto:<?=$this->rs_branch[$i]['email1']?>" class="d-block text-secondary font-xs ms-2"><?=$this->rs_branch[$i]['email1']?></a>
					</div>
					<?php }?>
					<?php if($this->rs_branch[$i]['email2']!=''){?>
					<div class="d-flex align-items-center">
						<span><i data-feather="mail" class="icon-size-2 theme-color"></i></span>
						<a href="mailto:<?=$this->rs_branch[$i]['email2']?>" class="d-block text-secondary font-xs ms-2"><?=$this->rs_branch[$i]['email2']?></a>
					</div>
					<?php }?>
					<?php if($this->rs_branch[$i]['business_url']!=''){?>
					<a href="<?=$this->rs_branch[$i]['business_url']?>" class="fw-600 theme-color font-sm d-block mt-2" target="_blank">
						Veiw on Map
						<i data-feather="send" class="icon-size-2 theme-color ms-1"></i>
					</a>
					<?php }?>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->