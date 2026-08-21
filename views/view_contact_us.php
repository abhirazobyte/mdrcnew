
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
	<link href="css/custom.css" rel="stylesheet">


<!--Start Header -->

<?php include 'includes/header.php';?>

<!--End Header -->

<!--Breadcrumb Area-->
<section class="breadcrumb-area banner-6">
  <div class="text-block">
	<div class="container">
	  <div class="row">
		<div class="col-lg-12 text-start v-center">
		  <div class="bread-inner">
			<div class="bread-menu wow fadeInUp" data-wow-delay=".2s">
			  <ul>
				<li><a href="index.html">Home</a></li>
				<li><a href="contact-us">Contact Us</a></li>
			  </ul>
			</div>
			<div class="bread-title wow fadeInUp" data-wow-delay=".5s">
			  <h1 class="f-bold fs-2 text-white">Contact Us</h1>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>
<!--End Breadcrumb Area-->



<!--Start Location-->
<section class="contact-info pad-tb">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-8 inside">
                <!-- <h5 class="mt30 mb30">Visit Our offices</h5> -->
                <div class="getintouchblock">
                    <div class="locations ">
                    
                    	<?php for($i=0;$i<count($this->rs_branch);$i++){?>
                        <div class="ouroffice mb30">
                            <h4><?=$this->rs_branch[$i]['name']?></h4>
							<div class="media mt15">
								<div class="icondive"><i class="fas fa-map-marker-alt"></i></div>
								<div class="media-body getintouchinfo">
									<span><?=$this->rs_branch[$i]['address']?></span>
								</div>
							</div>
                            <?php if($this->rs_branch[$i]['phone1']!=''){?>
							<div class="media mt15">
								<div class="icondive"><i class="fas fa-phone-alt"></i></div>
								<div class="media-body getintouchinfo">
									<a href="tel:<?=$this->rs_branch[$i]['phone1']?>"> <?=$this->rs_branch[$i]['phone1']?></a>
								</div>
							</div>
                            <?php }?>
                             <?php if($this->rs_branch[$i]['phone2']!=''){?>
							<div class="media mt15">
								<div class="icondive"><i class="fas fa-phone-alt"></i></div>
								<div class="media-body getintouchinfo">
									<a href="tel:<?=$this->rs_branch[$i]['phone2']?>"> <?=$this->rs_branch[$i]['phone2']?></a>
								</div>
							</div>
                            <?php }?>
                            
                             <?php if($this->rs_branch[$i]['email1']!=''){?>
							<div class="media mt15">
								<div class="icondive"><i class="fas fa-envelope"></i></div>
								<div class="media-body getintouchinfo">
									<a href="mailto:<?=$this->rs_branch[$i]['email1']?>"><?=$this->rs_branch[$i]['email1']?></a>
								</div>
							</div>
                             <?php }?>
                             <?php if($this->rs_branch[$i]['email2']!=''){?>
							<div class="media mt15">
								<div class="icondive"><i class="fas fa-envelope"></i></div>
								<div class="media-body getintouchinfo">
									<a href="mailto:<?=$this->rs_branch[$i]['email2']?>"><?=$this->rs_branch[$i]['email2']?></a>
								</div>
							</div>
                             <?php }?>
                             
                              <?php if($this->rs_branch[$i]['business_url']!=''){?>
                             
                            <a href="<?=$this->rs_branch[$i]['business_url']?>" target="blank">View on map <i class="fas fa-location-arrow fa-icon"></i></a>
                             <?php }?>
                        </div>
                        <?php }?>
                        
                        
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <h5 class="mt30 mb30">Dial a Call or Drop an Email</h5>
                <?php if($this->gs['contact_number']!=''){?>
                <div class="media mt15">
                    <div class="icondive"><img src="images/icons/call.svg" alt="icon"></div>
                    <div class="media-body getintouchinfo">
					   <a href="tel:<?=$this->gs['contact_number']?>"><?=$this->gs['contact_number']?> <span><?=$this->gs['time']?></span></a>
                    </div>
                </div>
                <?php }?>
                 <?php if($this->gs['contact_number1']!=''){?>
                <div class="media mt15">
                    <div class="icondive"><img src="images/icons/whatsapp.svg" alt="icon"></div>
                    <div class="media-body getintouchinfo">
                        <a href="https://wa.me/918586988847?text=Hello :) Thank you for contacting Modern Diagnostic and Research Centre. How can we help you please?" target="_blank"><?=$this->gs['contact_number1']?> <span><?=$this->gs['time']?></span></a>
                    </div>
                </div>
                <?php }?>
                 <?php if($this->gs['contact_email']!=''){?>
                <div class="media mt15">
                    <div class="icondive"><img src="images/icons/mail.svg" alt="icon"></div>
                    <div class="media-body getintouchinfo">
                        <a href="mailto:<?=$this->gs['contact_email']?>"><?=$this->gs['contact_email']?> <span>Online Support</span></a>
                    </div>
                </div>
                  <?php }?>
            </div>
        </div>
    </div>
</section>
<!--End Location-->


<!--Start Footer -->

<?php include 'includes/footer.php';?>

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

<?php include 'includes/general_data.php';?>