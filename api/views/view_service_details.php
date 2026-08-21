<style>
.common-heading-2 p {
    font-size: 19px !important;
    color: #000;
    margin-bottom: 15px !important;
}

.common-heading-2 h3, h4{
	margin-bottom:10px !important;
	}

.common-heading-2 ul{
list-style: disc;
margin-bottom: 15px;
}

.common-heading-2 ul li{
   margin: 10px 0px 0px 20px;
    color: #000;
    font-size: 19px;
}

</style>
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
<!--Start Hero-->
<section class=" pt50 pb50"  data-background="images/bg_banner.png">
	 <div class="text-block">
		<div class="container">
		   <div class="row align-items-center">
				<div class="col-lg-6">
					<h1 class="wow fadeInUp f-bold text-white" data-wow-delay=".2s"><?=$this->records_doctors['title']?></h1>
					<p class="text-white mt-4 mb-5 d-inline-block f-normal"><?=$this->records_doctors['short_desc']?></p>
					<?php if($this->records_doctors['button_name']!=''){?>
					<a href="<?=$this->records_doctors['button_name']?>" class="scrollTo niwax-btn2 wow fadeIn" data-wow-delay="0.8s"><?=$this->records_doctors['button_name']?> <i class="fas fa-chevron-right fa-ani"></i></a>
					<?php }?>
				</div>
				<?php $image = $this->utility->get_image_path($this->records_doctors['image'], 'for_doctors_services', 'large'); ?>?>
				<div class="col-lg-4 offset-lg-1 mt-3 mt-lg-0 mt-md-0 h-scl-base">
		            <div class="img-block-ca2 position-relative text-center h-scl-base m-mt30">
						<img src="<?=$image?>" alt="about" class="abt-ca2">
						<div class="shape-dg-1 dg-hero-shp1"><img src="images/shape/dots-dg.png" alt="shape" class="img-fluid dot-sp-ca2"></div>
					</div>
				</div>
		   </div>
		</div>
	 </div>
</section>
<!--End Hero-->
<section class="pad-tb pt60 pt60">
	<div class="container">
		<div class="row">
			<div class="col-lg-7">
				<div class="common-heading-2 text-l">
					<?=$this->records_doctors['decsription']?>
				</div>
			</div>
			<div class="col-lg-4 offset-lg-1 callBackForm">
				<div class="form-block formcover shadow pt-4 bg-gradient4">
	                <h4>Get a call back</h4>
	                <form id="GetCallBackForm" name="GetCallBackForm" class="shake mt40">
	                  <div class="row">
	                    <div class="form-group col-sm-12">
	                    	<label>Patient Name <span class="text-danger">*</span></label>
	                      <input type="text" id="name" name="name" placeholder="Enter name" required="" data-error="Please fill Out">
	                      <div class="help-block with-errors"></div>
	                    </div>
	                    <div class="form-group col-sm-12">
	                    	<label>Mobile Number <span class="text-danger">*</span></label>
	                      <input class="numbers numbersOnly" type="text" id="phone" name="phone" placeholder="Enter Phone" required="">
	                      <div class="help-block with-errors"></div>
	                    </div>
	                  </div>
	                  <div class="row">
	                    <div class="form-group col-sm-12">
                    		<label>Select City <span class="text-danger">*</span></label>
	                      	<select name="city" id="city" required="">
	                        	<option value="">Select City</option>
	                        	<?php for ($i=0; $i < count($this->rs_gs_city) ; $i++) { ?>
									<option value="<?=$this->rs_gs_city[$i]['name']?>"><?=$this->rs_gs_city[$i]['name']?></option>
								<?php }?>	
	                     	</select>
	                     	<div class="help-block with-errors"></div>
	                    </div>
	                  </div>
	                  <button type="submit" id="form-submit" data-form="GetCallBackForm"  class="btn btn-main mt-4 bg-btn3 get-call-back-submit">Submit <span class="circle"></span></button>
	                  <div id="msgSubmit" class="h3 text-center hidden"></div>
	                  <div class="clearfix"></div>
	                </form>
	            </div>
			</div>
		</div>
	</div>
</section>

<?php if(count($this->items)>0){?>
<section class="pb40 pt40 healthSection">
    <div class="container">
        <div class="row section-title">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="common-heading-2 text-start">
                    <h2 class="mb30 text-white"><?=$this->records_doctors['title']?> Test/Package</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
				<hr class="line"/>
			</div>
        </div>
        <div class="row">
			<div class="tab-content" id="myTabContent4">
				<div class="tab-pane tabi1 fade active show" id="tabHealthdd1" role="tabpanel" aria-labelledby="tabHealth1bba1">
		            <div class="col-sm-12 position-relative mt30">
						<div class="package-slider1 owl-carousel">
                        <?php for($c=0;$c<count($this->items);$c++){
							$item=$this->items[$c];
							$id=$item['id'];
							$item_price_id=$item['item_price_id'];
							$slug=$item['slug'];
							$name=$item['name'];
							$test_count=$item['test_count'];
							$image=$item['image'];
							$folder=$item['folder'];
							$price=$item['item_price_price'];
							$mrp=$item['item_price_mrp'];
							$url='tests/'.$item['slug'].'/'.$_SESSION['citySlug'];
							$sch_price=$item['item_price_sch_price'];
							$sch_start_date=$item['item_price_sch_start_date'];
							$sch_end_date=$item['item_price_sch_end_date'];
							if($sch_price>0 && $sch_start_date!='' && $sch_end_date!='')
							{
								$today_date=date('d-m-Y');
								$todaySlot=strtotime($today_date);
								$startSlot=strtotime($sch_start_date);
								$endSlot=strtotime($sch_end_date);
								if($todaySlot>=$startSlot && $todaySlot<=$endSlot)
								{
									$price=$sch_price;
								}
							}
							$price_html=$this->utility->packagePrice($id,$price,$mrp);
							$description1=strip_tags($item['item_other_data_description']);
							$description_li='';
							if($description1!='')
							{
								$description=$this->utility->string_truncate($description1,100);
								$description_li='<li><span>'.$description.'</span></li>';
							}
							$test_parameters_html=strip_tags($item['item_description_test_parameters']);
							if($test_parameters_html!='')
							{
								$test_parameters_html='<li><span>'.$this->utility->string_truncate($test_parameters_html,100).'</span></li>';
							}

							if (in_array($id, $_SESSION['cartitemIds']))
							{
								$Book_Now='<a href="'.$url.'" class="btn-main bg-btn1 btn-green lnk wow fadeInUp text-uppercase book-now">Added <span class="circle"></span></a>';
								$cartbtn='<a href="cart" class="add_to_cart btncart btncart-green float-end"><img src="images/icon-cart.png" alt="" /> <span class="circle"></span></a>';
							}
							else
							{
								$Book_Now='<a href="'.$url.'" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase book-now">Book Now <span class="circle"></span></a>';
								$cartbtn='<a href="javascript:void(0)" data-item_price_id="'.$item_price_id.'" data-item_id="'.$id.'" class="add_to_cart btncart float-end"><img src="images/icon-cart.png" alt="" /> <span class="circle"></span></a>';
							}

							?>
							<div class="items">
								<div class="pricing-table ">
									<div class="inner-table">
                                    <a class="d-inline-block w-100" href="<?=$url?>"><span class="title"><?=$name?></span></a>
										<ul class="list-style-  disc-list mt-3 mb30 pb5">
											<li><span>Total no.of Tests : <?=$test_count?></span></li>
											<?=$description_li?>
											<?=$test_parameters_html;?>
										</ul>
										<div class="d-info d-inline-block w-100">
											<h4><?=$price_html?></h4>
											<?=$Book_Now?>
											<?=$cartbtn?>
										</div>
									</div>
								</div>
							</div>
                         <?php }?>
						</div>
						<div class="owl-theme">
							<div class="owl-controls">
								<div class="custom-nav owl-nav"></div>
							</div>
						</div>
					</div>
				</div>     
	        </div>
	   </div>
    </div>
</section>
<?php }?>

<!--Start Hero-->
<section class="sliders-section otherService pb50 pt40 bg-gradient7">
    <div class=" container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="common-heading-2">
                    <h3 class="mb20 fs-3">Other Services</h3>
                </div>
            </div>
        </div>
        <div class="row normal position-relative">
            <div class="col-lg-12">
                <div class="hero-right-scmm">
                    <div class="hero-service-cards mt-0">
                        <div class="owl-carousel service-card-prb1">
                        	 <?php for ($i=0; $i < count($this->records_services); $i++) {
                  				$image = $this->utility->get_image_path($this->records_services[$i]['image'], 'for_doctors_services', 'large'); ?>
                            <div class="service-slide card-bg-a" data-tilt data-tilt-max="10" data-tilt-speed="1000">
                                <a href="service/<?=$this->parent_slug;?>/<?=$this->records_services[$i]['slug']?>">
                                    <div class="service-card-hh">
                                        <div class="image-sr-mm">
                                            <img alt="custom-sport" src="<?=$image?>">
                                        </div>
                                        <div class="title-serv-c"><?=$this->records_services[$i]['title']?></div>
                                    </div>
                                </a>
                            </div>
                       		 <?php }?>
                          
                      
                        </div>
                    </div>
						<div class="owl-theme">
							<div class="owl-controls">
								<div class="custom-nav owl-nav"></div>
							</div>
						</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Hero-->
<section class="pb30 pt40 healthSection packages d-none">
    <div class="container">
        <div class="row align-items-end section-title">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="common-heading-2 text-start">
                    <h2 class="mb20 ">Popular Packages in <?=$this->city_name?></h2>
					<span>Home > Radiology Packages </span>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-12 text-end">
				<div class="sortby mb10">
					Sort By
					<select>
						<option>Popularity</option>
						<option>Popularity</option>
						<option>Popularity</option>
					</select>
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
				<hr class="line"/>
			</div>
        </div>
        <div class="row mt20">
            <div class="col-lg-12 col-md-12 col-12">
				<div class="row" id="results">
            		<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/testing-new-items"><span class="title">Testing New Items</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>500.00 <del><i class="fas fa-rupee-sign"></i>600.00</del></span></h4>
									<a href="detail/testing-new-items" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/sgpt-serum-glutamic-pyruvic-transferase"><span class="title">SGPT (Serum Glutamic Pyruvic Transferase)</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>190.00 </span></h4>
									<a href="detail/sgpt-serum-glutamic-pyruvic-transferase" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
            		<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/testing-new-items"><span class="title">Testing New Items</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>500.00 <del><i class="fas fa-rupee-sign"></i>600.00</del></span></h4>
									<a href="detail/testing-new-items" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/sgpt-serum-glutamic-pyruvic-transferase"><span class="title">SGPT (Serum Glutamic Pyruvic Transferase)</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>190.00 </span></h4>
									<a href="detail/sgpt-serum-glutamic-pyruvic-transferase" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
            		<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/testing-new-items"><span class="title">Testing New Items</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>500.00 <del><i class="fas fa-rupee-sign"></i>600.00</del></span></h4>
									<a href="detail/testing-new-items" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-12 position-relative mb30">
						<div class="pricing-table ">
							<div class="inner-table">
								<a class="d-inline-block w-100" href="detail/sgpt-serum-glutamic-pyruvic-transferase"><span class="title">SGPT (Serum Glutamic Pyruvic Transferase)</span></a>
								<ul class="list-style-  disc-list mt-3 mb30 pb5">
									<li><span>Total no.of Tests : 1</span></li>
									<li><span>4D Stress Echo and Dobutamine</span></li>
									<li><span>Under supervision of Cardiologist</span></li>
								</ul>
								<div class="d-info d-inline-block w-100">
									<h4><span class="float-end-removed"><i class="fas fa-rupee-sign"></i>190.00 </span></h4>
									<a href="detail/sgpt-serum-glutamic-pyruvic-transferase" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
									<a href="javascript:void(0)" class="btncart float-end"><img src="images/icon-cart.png" alt=""> <span class="circle"></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="nonvalued">
              <input type="hidden" name="type_ids" id="type_ids" value="">
              <input type="hidden" name="dieses_ids" id="dieses_ids" value="">
              <input type="hidden" name="category_ids" id="category_ids" value="">
               <input type="hidden" name="sort_by" id="sort_by" value="">
               <input type="hidden" name="search_data" id="search_data" value="">
               <input type="hidden" name="city_id" id="city_id" value="<?=$this->city_id?>">
                <input type="hidden" name="department_id" id="department_id" value="<?=$this->department_id?>">
              <input type="hidden" name="total_data" id="total_data" value="0">
            </div>
            	<div class="row">
                <div class="col-lg-12 loaderDiv d-none" style="text-align:center">
                <img src="images/loader.gif">
              </div>
              <div class="col-lg-12 " style="text-align:center">
                <button class="btn-main bg-btn1 bg-grengradi text-white lnk wow fadeInUp animation_image" id="l_more" align="center"  style="display:none">Load More <span class="circle"></span></button>
              </div>
            </div>
			</div>
		</div>
    </div>
</section>
<!--End Faqs-->
<?php if(count($this->rs_testimonial)>0){?>
<section class="pb130 pt40 testimonials raiolog">
	<div class="container">
		<div class="row">
			<div class="col-lg-4  col-md-7">
				<div class="common-heading-2 text-start">
					<h2 class="mb0 lh-16">What Customer say </h2>
					<p class="text-101010">Lorem ipsum is a placeholder text commonly </p>
				</div>
			</div>
			<div class="col-lg-8  col-md-5 mt-3 mt-lg-0 mt-md-0 border-start ps-lg-5 m-minus reviewimgs">
				<a class="me-3 me-lg-5 me-md-3" href="#"><img src="images/review-google.png" alt="Review Google" /></a>
			</div>
		</div>
		<div class="row normal position-relative">
			<div class="col-md-12 p-0 mt20">
				<div class="niwax-review-slider owl-carousel center-dots">
					<?php for($i=0;$i<count($this->rs_testimonial);$i++){
                        $image = $this->utility->get_image_path($this->rs_testimonial[$i]['image'], 'testimonial', 'large');?>
					<div class="reviews-card pr-shadow">
						<div class="-client-details-">
							<div class="-reviewr">
								<img src="<?=$image?>" alt="<?=$this->rs_testimonial[$i]['name']?>" class="img-fluid">
							</div>
							<div class="reviewer-text">
								<h4><?=$this->rs_testimonial[$i]['name']?></h4>
								<p><?=$this->rs_testimonial[$i]['city']?><br/>Service Rated <a href="javascript:void(0)" class="chked"><i class="fa fa-star"></i></a> <?=$this->rs_testimonial[$i]['ratting']?></p>
							</div>
						</div>
						<div class="review-text text-start">
							<div class="col"> <span class="revbx-lr"><img src="images/img-quote.png" alt="quote"/></span> </div>
							  <p><?=$this->rs_testimonial[$i]['content']?></p>
						</div>
					</div>
				<?php }?>

		
				</div>
				<div class="owl-theme">
					<div class="owl-controls">
						<div class="custom-nav owl-nav"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }?>
<?php include 'includes/get_in_touch_form.php';?>
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