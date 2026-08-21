
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/plugin.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<!-- template-style-->
	<link href="css/style.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<!-- Bootstrap Select -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css'>
	<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css'> -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css'>
	<link href="css/custom.css" rel="stylesheet">
<!--Start Header -->
<?php include 'includes/header.php';?>
<!--End Header -->
<section class=" business-startup banner-sec pt30 pb10">
    <div class="text-block">
        <div class="container">
            <div class="row">
				<div class="col-lg-8 normal position-relative">
					<?php if(count($this->rs_banner)>0){?>
					<div class="banner-slider owl-carousel">
						<?php for($i=0;$i<count($this->rs_banner);$i++){
							$folder='main_banner_images';
					 		$image=$this->utility->get_image_path($this->rs_banner[$i]['banner_image'],$folder,"large");
							$url='javascript:void(0)';
							if($this->rs_banner[$i]['banner_link']!='')
							{
								$url=$this->rs_banner[$i]['banner_link'];
							}
							?>
						<div class="items">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-12">
									<a href="<?=$url?>"><img class="w-100" src="<?=$image?>" alt="" /></a>
								</div>
							</div>
						</div>
                        <?php }?>
					</div>
                    <?php }?>
				</div>
				<div class="col-lg-4 mt-3 mt-lg-0 mt-md-2">
					<div class="wide-block d-flex bord fts mt-0 mb15 ftdiv" data-tilt="" data-tilt-max="2" data-tilt-speed="600">
						 <div class="block-space- text-start ">
						 	<img src="images/up-prescription.png"/>
							<h4 class="mt0 mb0">Not Able to <br>Find Test?</h4>
							<span class="mt0 mb-1 d-block">Let Us Help</span>
							<a href="mdrc-test-booking-enquiry" class="btn-main bg-btn1 btn-white lnk wow fadeInUp mt10" data-wow-delay=".6s">Submit Query<span class="circle"></span></a>
						 </div>
						 <div class="block-space- text-start ms-auto">
						 	<img src="images/bo-test.png"/>
							<h4 class="mt0 mb0">1700+ Tests <br />at Home</h4>
							<span class="mt0 mb-1 d-block">Book Home Collection</span>
							<a href="pathology/lab-blood-test-near/<?=$_SESSION['citySlug'];?>" class="btn-main bg-btn1 btn-white lnk wow fadeInUp mt10" data-wow-delay=".6s">Book Now<span class="circle"></span></a>
						 </div>
					</div>
					<!-- <div class="wide-block service-img1 banner-2 mb15" data-tilt="" data-tilt-max="2" data-tilt-speed="600">
						 <div class="block-space- text-end ms-auto">
							<h4 class="mt0 mb0">Upload</h4>
							<span class="mt0 mb-1 d-block">Prescription</span>
							<a href="#" class="btn-main bg-btn1 btn-white lnk wow fadeInUp mt10" data-wow-delay=".6s">Upload Now<span class="circle"></span></a>
						 </div>
					</div> -->
					<div class="wide-block service-img1 smah banner-2 mb15" data-tilt="" data-tilt-max="2" data-tilt-speed="600">
						 <div class="block-space- text-end ms-auto">
							<h4 class="mt0 mb0">Radiology</h4>
                            <?php if(count($this->rs_item_banner_category)>0){?>
							<span class="mt0 mb0 tt">
                            <?php for($i=0;$i<count($this->rs_item_banner_category);$i++){
								 $folder='item_category';
					 			 $item_cat_img=$this->utility->get_image_path($this->rs_item_banner_category[$i]['image'],$folder,"large");
								?>
                            <a class="tooltip-with-img radiologyCatClick"  data-name="<?=$this->rs_item_banner_category[$i]['name']?>" data-id="<?=$this->rs_item_banner_category[$i]['id']?>" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="<h4><img src='<?=$item_cat_img?>' width='180'> </h4>"><?=$this->rs_item_banner_category[$i]['name']?></a> <?php if($i<count($this->rs_item_banner_category)-1){?>| <?php }?>
                            <?php }?>
                            </span>
                            <?php }?>
						 </div>
					</div>
					<div class="wide-block service-img1 banner-1 smalli mb15" data-tilt="" data-tilt-max="2" data-tilt-speed="600">
						 <div class="block-space- text-end ms-auto">
							<h4 class="mt0 mb0">Download</h4>
							<span class="mt0 mb-1 d-block">Test Report</span>
							<!-- <a class="btn-main bg-btn1 btn-white lnk wow fadeInUp mt10" data-wow-delay=".6s" data-bs-toggle="offcanvas" href="#offcanvasExample-download">Download Now<span class="circle"></span></a> -->
							<a class="btn-main bg-btn1 btn-white lnk wow fadeInUp mt10" href="download-reports">Download Now<span class="circle"></span></a>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Hero-->
<?php if(count($this->rs_item_diseases)>0){?>
<section class="pb60 pt40 testsbyCondition">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="common-heading-2">
                    <h1 class="mb30 fs-3 text-202024">Tests by Condition</h1>
                </div>
            </div>
        </div>
        <div class="row position-relative">
            <div class="col-lg-12 text-center">
				<div class="logo-weworkfor owl-carousel">
				  <?php for($i=0;$i<count($this->rs_item_diseases);$i++){
					  $name=$this->rs_item_diseases[$i]['name'];
					  $image=$this->rs_item_diseases[$i]['image'];
					  $slug=$this->rs_item_diseases[$i]['slug'];
					  $folder='item_diseases';
					  $item_diseases_img=$this->utility->get_image_path($image,$folder,"large");
					  $url=SERVER_ROOT.'/diseases/'.$_SESSION['citySlug'].'/'.$slug.'';
					  ?>
				  <div class="items"><a href="<?=$url?>"><div class="imgDiv"><img src="<?=$item_diseases_img?>" alt="<?=$name?>" class=""></div><br/><span><?=$name?></span></a></div>
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
</section>
<?php }?>
<section class="pb60 testsbyCondition2" style="display:none">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="row">
					<div class="col-lg-4 col-md-4 mb-3 mb-md-0 mb-lg-0">
						<div class="col-12 p-0 position-relative radi">
							<img src="images/wellness.png" alt="" />
							<span class="align">Wellness</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 mb-3 mb-md-0 mb-lg-0">
						<div class="col-12 p-0 position-relative radi">
							<img src="images/img-oncology.png" alt="" />
							<span class="align">Genetic Testing</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 mb-3 mb-md-0 mb-lg-0">
						<a href="pregnancy-care">
							<div class="col-12 p-0 position-relative radi">
								<img src="images/img-pregnancy.png" alt="" />
								<span class="align">Pregnancy Care</span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="how-work" class="pt50 pb80 d-none">
    <div class="container">
        <div class="row section-title">
            <div class="col-sm-6 col-8">
                <div class="common-heading-2 text-start">
                    <h2 class="mb30">Book Home Collection</h2>
                </div>
            </div>
            <div class="col-sm-6 col-4 text-end">
				<a href="mdrc-test-booking-enquiry" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
            </div>
        </div>
        <div class="row section-title">
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <img class="harrow" src="images/harrow.png" alt="" />
                    <div class="img"><img src="images/hstep1.png" alt="" /></div>
                    <h5>
                        <span>Step 1</span><br />
                        Convenient<br/> & Time Saving
                    </h5>
                </div>
            </div>
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <img class="harrow mid" src="images/harrow.png" alt="" />
                    <div class="img"><img src="images/hstep2.png" alt="" /></div>
                    <h5 class="midd">
                        <span>Step 2</span><br />
                        Vast test menu of 2500+<br/> test at your doorstep
                    </h5>
                </div>
            </div>
            <div class="col-sm-4 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <div class="img"><img src="images/hstep3.png" alt="" /></div>
                    <h5>
                        <span>Final Step</span><br />
                        Online Access<br/> to Reports
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="how-work" class="pt50 pb80 ste4 d-none">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11">
				<div class="row section-title">
					<div class="col-sm-6 col-8">
						<div class="common-heading-2 text-start">
							<h2 class="mb30">Book Home Collection</h2>
						</div>
					</div>
					<div class="col-sm-6 col-4 text-end">
						<a href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
					</div>
				</div>
			</div>
        </div>
        <div class="row section-title">
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <img class="harrow" src="images/harrow.png" alt="" />
                    <div class="img"><img src="images/searchtest.png" alt="" /></div>
                    <h5>
                        <span>Search & add your test</span><br />
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <img class="harrow mid" src="images/harrow.png" alt="" />
                    <div class="img"><img src="images/secudletest.png" alt="" /></div>
                    <h5 class="midd">
                        <span>Schedule<br/>Your Tests</span><br />
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <img class="harrow mid" src="images/harrow.png" alt="" />
                    <div class="img"><img src="images/sampletest.png" alt="" /></div>
                    <h5 class="midd">
                        <span>Sample<br/>Collection</span><br />
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <div class="img"><img src="images/dwnload_report.png" alt="" /></div>
                    <h5>
                        <span>Download<br/> report online</span><br />
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(count($this->rs_item_home_category)>0){?>
<section class="pb40 pt40 healthSection">
    <div class="container">
        <div class="row section-title">
            <div class="col-lg-3 col-md-3 col-12">
                <div class="common-heading-2 text-start">
                    <h2 class="mb30 text-white">Our Health Packages</h2>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 cust-ul col-12 text-start text-lg-end text-md-end scrollmobile">
				<ul class="nav nav-tabs float-end" id="myTab4" role="tablist">
                <?php
				$m=1;
				for($i=0;$i<count($this->rs_item_home_category);$i++){
					if($i==0)
					{
						$active='active';
					}
					else
					{
						$active='';
					}
					?>
				  <li class="nav-item">
					<a class="nav-link <?=$active?>" id="tabHealth1bba<?=$m?>" data-bs-toggle="tab" href="#tabHealthdd<?=$m?>" role="tab" aria-controls="tabHealthdd<?=$m?>" aria-selected="true"><?=$this->rs_item_home_category[$i]['name']?></a>
				  </li>
                  <?php $m++;}?>
				</ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
				<hr class="line"/>
			</div>
        </div>
        <div class="row">
			<div class="tab-content" id="myTabContent4">
             <?php
				$m=1;
				for($i=0;$i<count($this->rs_item_home_category);$i++){
					if($i==0)
					{
						$active='active show';
					}
					else
					{
						$active='';
					}
					$caturl=SERVER_ROOT.'/category/'.$_SESSION['citySlug'].'/'.$this->rs_item_home_category[$i]['slug'].'';
					$sort_cond="item.sort_order ASC";
					$city_cond=" and FIND_IN_SET ('".$_SESSION['cityID']."',item.city_ids) and item_price.city_id='".$_SESSION['cityID']."'";
					$cat_cond=" and (FIND_IN_SET ('".$this->rs_item_home_category[$i]['id']."',item_other_data.item_category_ids))";
					$master_con=$g_search_query.$city_cond.$department_cond.$type_cond.$dieses_cond.$cat_cond.$popular_pack_cond;
					$obj_model_all = $this->load_model("item");
					$obj_model_all->join_table("item_description", "left", array('test_parameters'), array("id"=>"item_id"));
					$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
					$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
					$records = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.status='Active' and  item.set_at_home='Yes'   ".$master_con."","".$sort_cond." limit 0,8","");
					?>
				<div class="tab-pane tabi1 fade <?=$active?>" id="tabHealthdd<?=$m?>" role="tabpanel" aria-labelledby="tabHealth1bba<?=$m?>">
		            <div class="col-sm-12 position-relative mt30">
						<div class="package-slider<?=$m?> owl-carousel">
                        <?php for($c=0;$c<count($records);$c++){
							$item=$records[$c];
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
		            <div class="col-sm-12 col-12 mt-2 text-center">
						<a href="<?=$caturl?>" class="vallbtn">View All <img src="images/right-arrow-white.png" alt="" /></a>
		            </div>
				</div>
                  <?php $m++;}?>
	        </div>
	   </div>
       <!--  <div class="row">
            <div class="col-lg-12 pt40">
               <img src="images/info-orange.png" alt="">
        	</div>
	    </div> -->
    </div>
</section>
<?php }?>
<section id="" class="pt40 d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
               <img src="images/info-skyblue.png" alt="">
        	</div>
        </div>
    </div>
</section>
<section id="how-work" class="pt40 middi pb80 ste4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
				<div class="row section-title">
					<div class="col-sm-6 col-8">
						<div class="common-heading-2 text-start">
							<h3 class="mb30 fs-3 text-202024">Book Home Collection</h3>
						</div>
					</div>
					<div class="col-sm-6 col-4 text-end">
						<a data-bs-toggle="modal" data-bs-target="#modalform-full" href="#" class="btn-main bg-btn1 btn-blue lnk wow fadeInUp text-uppercase">Book Now <span class="circle"></span></a>
					</div>
				</div>
			</div>
        </div>
        <div class="row section-title">
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow" src="images/harrow.png" alt=""> -->
                    <div class="img"><img src="images/searchtest.png" alt=""></div>
                    <h5>
                        <span>Search &amp; add<br> your test</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow mid" src="images/harrow.png" alt=""> -->
                    <div class="img" style="
    padding: 11px;
"><img src="images/secudletest.png" alt=""></div>
                    <h5 class="midd">
                        <span>Schedule<br>Your Tests</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <!-- <img class="harrow mid" src="images/harrow.png" alt=""> -->
                    <div class="img" style="
    padding: 26px 19px;
"><img src="images/sampletest.png" alt="" style="
    max-width: 81px;
"></div>
                    <h5 class="midd">
                        <span>Collect Sample <br>From Your Home</span><br>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3 text-start text-lg-center text-md-center position-relative">
                <div class="how-works-block text-start">
                    <div class="img" style="
    padding: 19px 19px;
    min-width: 119px;
    text-align: center;
"><img src="images/dwnload_report.png" alt=""></div>
                    <h5>
                        <span>Download<br> report online</span><br>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about-lead-gen pt30 pb50">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 tex-center col-md-6 lead-intro-  col-12">
				<div class="vid-img gap10">
					<img src="images/img-about.png" alt="image" class="img-fluid">
	               <a class="video-link play-video" href="https://www.youtube.com/watch?v=EsZ0IVlCGRY"><span class="triangle-play"></span></a>
              	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
				<div class="common-heading-2 text-l">
					<h4 class="mb20 fs-2 text-202024">Why Us?</h4>
					<p class="text-202024">MDRC started its operations in the year 1985 from New Railway Road, Gurugram and have become the pioneer in the field of Pathology and Imaging. The journey which started with a Lab and X-Ray machine in the beginning, has today reached a stage where MDRC today is in top league in terms of the range and quality of diagnostic facilities, with the capability to perform more than 2500 tests in house.  </p>
					<p class="mt20 text-202024">Modern Diagnostic & Research Centre offers complete range of diagnostic facilities in Radiology and High end Pathology.</p>
					<h4 class="mt40 mb20 text-202024">Accreditations</h4>
					<div class="opl">
						<ul>
							<li class="wow fadeIn" data-wow-delay=".2s">
								<div class="clients-logo">
									<div>
										<img src="images/nabh-logo.png" alt="text" class="img-fluid">
										<!-- <img src="images/accred-1.png" alt="text" class="img-fluid"> -->
										<span>MIS- 2017-0045</span>
									</div>
								</div>
							</li>
							<li class="wow fadeIn" data-wow-delay=".2s">
								<div class="clients-logo">
									<div>
										<img src="images/cap-logo.png" alt="text" class="img-fluid">
										<!-- <img src="images/accred-2.png" alt="text" class="img-fluid"> -->
										<span>CAP No. 8498566</span>
									</div>
								</div>
							</li>
							<li class="wow fadeIn" data-wow-delay=".2s">
								<div class="clients-logo">
									<div>
										<img src="images/nabl-new-logo.png" alt="text" class="img-fluid">
										<!-- <img src="images/accred-3.png" alt="text" class="img-fluid"> -->
										<span>MC-2334</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if(count($this->rs_services)>0){?>
<section class="pb40 pt40 expertiseSection">
    <div class="container">
        <div class="row section-title">
            <div class="col-sm-4">
                <div class="common-heading-2 text-start">
                    <h5 class="mb0  text-202024 fs-3">Our Expertise</h5>
                </div>
            </div>
            <div class="col-sm-8 text-end">
				<ul class="nav nav-tabs float-end" id="myTab3" role="tablist">
				<?php for ($i=0; $i < count($this->rs_services) ; $i++) {
					$active='';
					if($i==0)
					{
						$active='active';
					}
				 ?>
				  <li class="nav-item">
					<a class="nav-link <?=$active?>" id="tab<?=$i?>a" data-bs-toggle="tab" href="#tab<?=$i?>" role="tab" aria-controls="tab<?=$i?>" aria-selected="true"><?=$this->rs_services[$i]['deatail']['title']?></a>
				  </li>
				<?php }?>
				  
				</ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
				<hr class="line m-0"/>
			</div>
        </div>
        <div class="row">
            <div class="col-sm-12 position-relative mt15">
				<div class="tab-content" id="myTabContent3">

				<?php for ($i=0; $i < count($this->rs_services) ; $i++){
					$active1='';
					if($i==0)
					{
						$active1='active show';
					}
					$k=$i+1;
				?>
					<div class="tab-pane tabi<?=$k?> fade <?=$active1?>" id="tab<?=$i?>" role="tabpanel" aria-labelledby="tab<?=$i?>a">

						<div class="expert-slider<?=$k?> owl-carousel">
							<?php for ($j=0; $j < count($this->rs_services[$i]['services']) ; $j++) {

							$image = $this->utility->get_image_path($this->rs_services[$i]['services'][$j]['image'], 'for_doctors_services', 'large');

							 ?>
							<div class="items">
								<div class="col-12 p-0 position-relative radi">
									<a href="service/<?=$this->rs_services[$i]['deatail']['slug'];?>/<?=$this->rs_services[$i]['services'][$j]['slug']?>"><img src="<?=$image?>" alt="" /></a>
									<a href="service/<?=$this->rs_services[$i]['deatail']['slug'];?>/<?=$this->rs_services[$i]['services'][$j]['slug']?>"><span class="align"><?=$this->rs_services[$i]['services'][$j]['title']?></span></a>
								</div>
							</div>
							<?php }?>
						</div>
						
						<div class="row mt20">
							<div class="col-lg-6 col-md-6 col-6">
								<a class="v-all text-202024 fw-medium" href="<?=$this->rs_services[$i]['deatail']['slug']?>">View All</a>
							</div>
							<div class="col-lg-6 simple-nav col-md-6 col-6">
								<div class="owl-theme">
									<div class="owl-controls">
										<div class="custom-nav owl-nav"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }?>

				
				</div>
			</div>
        </div>
    </div>
</section>
<?php }?>
<section class="bg-art-pic">
	<section class="pb60 pt30 testimonials">
		<div class="container">
			<div class="row">
				<div class="col-lg-4  col-md-7">
					<div class="common-heading-2 text-start">
						<h2 class="mb0 lh-16">What Customer say </h2>
						<!--<p class="text-101010">Lorem ipsum is a placeholder text commonly </p>-->
					</div>
				</div>
				<div class="col-lg-8  col-md-5 mt-3 mt-lg-0 mt-md-0 border-start ps-lg-5 m-minus reviewimgs">
					<a class="revi-text" href="#"><img src="images/review-google.png" alt="Review Google" /><div class="ps-3">4.8<br/><span>3000+ Reviews</span></div></a>
				</div>
			</div>
            <?php if(count($this->rs_testimonial)>0){
				?>
			<div class="row normal position-relative">
				<div class="col-md-12 p-0 mt20">
					<div class="niwax-review-slider owl-carousel center-dots">
                    	<?php for($i=0;$i<count($this->rs_testimonial);$i++){
							$image = $this->utility->get_image_path($this->rs_testimonial[$i]['image'], 'testimonial', 'large');
							?>
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
            <?php }?>
		</div>
	</section>
	<section class="downloadSection pt0 pb50 d-none">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-5 lead-intro-">
					<img src="images/app-mobile.png" alt="image" class="img-fluid">
				</div>
				<div class="col-lg-4 col-md-7">
					<div class="common-heading-2 text-l">
						<h2 class="mb0">Download Our App Now</h2>
						<p class="mb25">Keeping a check on your health made easy with the app. Available on both Google Play Store and App Store. Get easy access to health check ups with quick turnaround time.</p>
						<a class="imggoogle me-3" href="#"><img src="images/img-gplay.png" alt="Google Play"></a>
						<a class="imgstore" href="#"><img src="images/img-appstore.png" alt="App Store"></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<section class="pb40 pt30 photoGallery">
    <div class="container-fluid p-0">
        <div class="row m-auto justify-content-center">
            <div class="col-lg-8">
                <div class="common-heading-2">
                    <h2 class="mb40">Take a look of Photo Gallery</h2>
                </div>
            </div>
        </div>
        <div class="row m-auto">
            <!-- <div class="col-lg-12 ">
				<ul>
					<li><a data-fancybox="gallery" data-src="images/look-1.png"><img src="images/look-1.png" alt="" class=""></a></li>
					<li><a data-fancybox="gallery" data-src="images/look-2.png"><img src="images/look-2.png" alt="" class=""></a></li>
					<li><a data-fancybox="gallery" data-src="images/look-3.png"><img src="images/look-3.png" alt="" class=""></a></li>
					<li class="multiImg">
						<a data-fancybox="gallery" data-src="images/look-4.png"><img src="images/look-4.png" alt="" class=""></a>
						<a data-fancybox="gallery" data-src="images/look-5.png"><img src="images/look-5.png" alt="" class=""></a>
					</li>
					<li><a data-fancybox="gallery" data-src="images/look-6.png"><img src="images/look-6.png" alt="" class=""></a></li>
				</ul>
			</div> -->
            <div class="col-lg-12 ">
				<ul>
					<li><a data-fancybox="gallery" data-src="images/takegal-1.png"><img src="images/takegal-1.png" alt="" class=""></a></li>
					<li><a data-fancybox="gallery" data-src="images/takegal-2.png"><img src="images/takegal-2.png" alt="" class=""></a></li>
					<li><a data-fancybox="gallery" data-src="images/takegal-3.png"><img src="images/takegal-3.png" alt="" class=""></a></li>
					<li class="multiImg">
						<a data-fancybox="gallery" data-src="images/takegal-4.png"><img src="images/takegal-4.png" alt="" class=""></a>
						<a data-fancybox="gallery" data-src="images/takegal-5.png"><img src="images/takegal-5.png" alt="" class=""></a>
					</li>
					<li><a data-fancybox="gallery" data-src="images/takegal-6.png"><img src="images/takegal-6.png" alt="" class=""></a></li>
				</ul>
			</div>
        </div>
    </div>
</section>
<!--Start Faqs-->
<section class="pt10 pb190 faqSection mdrc-blog-section">
	<div class="container">
		
		<?php if(count($this->rs_blog)>0) { ?>
		<div class="row">
			<div class="col-lg-12">
                <div class="common-heading-2">
                    <h6 class="mb20 mt40 fs-3 text-202024">Blogs</h6>
                </div>
            </div>
			<div class="blog-section-slider owl-carousel">
				<?php 
				//for blog
				$array_bg=array('dg-bg2','bg-gradient12');
				$array_bg_rand=array_rand($array_bg,2);

				for($i=0;$i<count($this->rs_blog);$i++) {
					$blog=$this->rs_blog[$i];
					$id=$blog['id'];
					$blog_category_name=$blog['blog_category_name'];
					$name=$blog['name'];
					$short_info=$blog['short_info'];
					$folder=$blog['folder'];
					$image=$blog['image'];
					$blogImage=$this->utility->get_image_path($image,'blog/'.$folder.'/','large');
					$date=$blog['entry_date_time'];
					$old_date=date_create($date);
					$new_date=date_format($old_date,"M d, Y");
					$blog_category_slug=$blog['blog_category_slug'];
					$slug=$blog['slug'];
					$category_slug='blog/category/'.$blog_category_slug.'';
					$detail_slug='blog/detail/'.$slug.'.html'; 
				?>
				<div class="items">
					<div class="single-blog-post- shdo">
						<div class="single-blog-img-">
							<a href="<?=$detail_slug;?>"><img src="<?=$blogImage;?>" alt="" class="img-fluid"></a>
							<div class="entry-blog-post <?=$array_bg[$array_bg_rand[0]];?>">
								<span class="bypost-"><a href="<?=$category_slug;?>"><i class="fas fa-tag"></i>  <?=$blog_category_name;?></a></span>
								<span class="posted-on-">
									<a href="#"><i class="fas fa-clock"></i>  <?=$new_date;?></a>
								</span>
							</div>
						</div>
						<div class="blog-content-tt">
							<div class="single-blog-info-">
								<h4><a href="<?=$detail_slug;?>"><?=$name;?></a></h4>
								<p><?=$short_info;?></p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
		<?php } ?>
							
		<div class="row  d-none">
			
		   <div class="col-md-6 col-md-6 mt-3 mt-lg-0 mt-md-0">
			  <div class="common-heading-2 text-start">
				 <h3 class="mb20">Frequently Asked Questions</h3>
			  </div>
				<div class="accordion" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="heading-1">
						  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapseOne">
							What does LOREM mean?
						  </button>
						</h2>
						<div id="collapse-1" class="accordion-collapse collapse show" aria-labelledby="heading-1" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="data-reqs">
								<p>Lorem ipsum dolor sit amet, consectetur adipisici elitis dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document.  ‘Lorem ipsum dolor sit amet, consectetur adipisici elit dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for exf the finished document. </p>
							 </div>
						  </div>
						</div>
					  </div>
					  <div class="accordion-item">
						<h2 class="accordion-header" id="heading-2">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="true" aria-controls="collapseOne">
							Where can I subscribe to your newsletter?
						  </button>
						</h2>
						<div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="data-reqs">
								<p>Lorem ipsum dolor sit amet, consectetur adipisici elitis dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document.  ‘Lorem ipsum dolor sit amet, consectetur adipisici elit dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for exf the finished document. </p>
							 </div>
						  </div>
						</div>
					  </div>
					  <div class="accordion-item">
						<h2 class="accordion-header" id="heading-3">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="true" aria-controls="collapseOne">
							Where can in edit my address?
						  </button>
						</h2>
						<div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="data-reqs">
								<p>Lorem ipsum dolor sit amet, consectetur adipisici elitis dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document.  ‘Lorem ipsum dolor sit amet, consectetur adipisici elit dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for exf the finished document. </p>
							 </div>
						  </div>
						</div>
					  </div>
				 </div>
			</div>
		</div>
	</div>
</section>
<!--End Faqs-->
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
<script src='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js'></script>
<script id="rendered-js" >
const myCarousel = new Carousel(document.querySelector("#myCarousel"), {
  preload: 1 });
Fancybox.assign('[data-fancybox="carousel-gallery"]', {
  closeButton: "top",
  Thumbs: false,
  Carousel: {
    Dots: true,
    on: {
      change: that => {
        myCarousel.slideTo(myCarousel.getPageforSlide(that.page), {
          friction: 0 });
      } } } });
</script>
<?php include 'includes/general_data.php';?>
