<?php include('includes/header.php');
include('modules/phpqrcode/qrlib.php');
?>

<style>
	.ipo-ul {
		list-style: disc;
		padding-left: 20px;
	}

</style>
<!-- Main Start -->
<main class="pb-4 bg-white page-common">
	<!-- About banner start -->
	<div class="card bg-theme rounded-0 border-0">
		<div>
			<img src="https://www.mdrcindia.com/images/investor-relation/policies-banner.png" alt="" class="w-100 h-100 img-fluid">
		</div>
	</div>
	<!-- About banner end -->
	<!-- About tab start -->
	<div class="about-tab mb-3">
		<h2 class="font-lg text-center mb-3 mt-3">Policies</h2>
		<div class="tab-content px-3" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills-nabl" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-9 common-heading-2 text-start col-xs-12 col-12">
						<ul class="text-202024 ipo-ul">
							<?php 
								foreach ($this->rs_pdf as $item) 
								{
									$img = $this->utility->get_image_path($item['file_name'], 'ipo_pdfs', "large");

									$PNG_TEMP_DIR = ABS_PATH . '/uploads/ipo_pdfs/';
									$filename = $PNG_TEMP_DIR.$item['file_name'] . '.png';
									$code =$img;
									QRcode::png($code, $filename, 'L', '3', '1');
									$image='<img src="../uploads/ipo_pdfs/' . basename($filename) . '"  style="width: 130px;">';
								?>
								<li>
								<?php if ($item['qr_code']=='Yes') { ?>
									<a href="javascript:void(0)" class="getQr"  data-id="<?=$item['id']?>"><?= $item['title'] ?></a>
									<div class="qrImage pdfImage<?=$item['id']?>" style="display:none;">
										<div class="form-block fdgn2">
											<div class="box">
												<table>
													<tr>
														<td style="width: 100%;">
															<?=$image?>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<?php } else { ?>
										<a href="<?=$img?>" download><?= $item['title'] ?></a>
									<?php } ?>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- About tab end -->
</main>

<?php include('includes/footer.php'); ?>


<script>
	$(document).on("click",".getQr", function ()
	{
		getId=$(this).data("id");
		$('.pdfImage' + getId).slideToggle();
	});
</script>