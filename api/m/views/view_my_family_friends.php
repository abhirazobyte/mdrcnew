<?php include('includes/header.php'); ?>
<!-- Main Start -->
<main class="main-wrap bg-white page-common">
	<a href="javascript:void(0);" class="btn btn-solid rounded-pill w-100 font-md my-3 d-block cust_member_addedit_onclick" data-id="">
		<img src="assets/images/mdrc/icons/plus-fill-white.svg" alt="" class="img-fluid me-1 mb-1">
		Add More Member
	</a>

	<?php if(count($this->rs_members)>0){?>

	<?php for($i=0;$i<count($this->rs_members);$i++){?>
	<div class="card p-3 mb-3 row_data_<?=$this->rs_members[$i]['id']?>">
		<div class="d-flex justify-content-between">
			<div>
				<h3 class="font-md fw-600 mb-2"><?=$i+1;?>.  <?=$this->rs_members[$i]['first_name']?> <?=$this->rs_members[$i]['last_name']?></h3>
				<p class="mb-0 text-secondary"><?=$this->rs_members[$i]['relation']?></p>
				<p class="mb-0 text-secondary"><span><?=$this->rs_members[$i]['gender']?> </span><span class="bdot ms-3"></span><?=$this->utility->getAge($this->rs_members[$i]['dob'])?> yrs.<br>
				<?=$this->rs_members[$i]['line1']?>,<?=$this->rs_members[$i]['area']?><br>
				<?=$this->rs_members[$i]['city_name']?>,<?=$this->rs_members[$i]['pincode']?>
			</p>
			</div>
			<div class="d-flex flex-column gap-3 align-items-end">
				<a href="javascript:void(0)" class="cust_member_addedit_onclick" data-id="<?=$this->rs_members[$i]['id']?>">
					<img src="assets/images/mdrc/icons/edit.svg" alt="" class="img-fluid">
					<span class="font-md fw-600 theme-color">Edit</span>
				</a>
				<a href="javascript:void(0)" type="button" class="member_delete" data-id="<?=$this->rs_members[$i]['id']?>">
					<img src="assets/images/mdrc/icons/trash.svg" alt="" class="img-fluid">
				</a>

			</div>
		</div>
	</div>
	<?php }?>

	<?php }?>

	
	
</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->