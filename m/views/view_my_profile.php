<?php include('includes/header.php'); ?>

<!-- Main Start -->
<main class="myprofile-page bg-white p-3 main-btm-pd">
	<form action="" method="post" name="customerForm" id="customerForm">
		<div class="row g-4">
			<div class="col-12">
				<div class="border rounded p-3 position-relative">
					<label for="fname" class="profile-label">First Name<span class="text-danger">*</span></label>
					<input type="text" name="first_name" id="first_name" class="border-0 fw-bold required" value="<?=$this->rs_customer['name']?>">
				</div>
			</div>
			<div class="col-12">
				<div class="border rounded p-3 position-relative">
					<label for="lname" class="profile-label">Last Name<span class="text-danger">*</span></label>
					<input type="text" class="border-0 fw-bold required" name="last_name" id="last_name" value="<?=$this->rs_customer['last_name']?>">
				</div>
			</div>
			<div class="col-12">
				<div class="border rounded p-3 position-relative">
					<label for="email" class="profile-label">Mobile No.</span></label>
					<input type="text" class="border-0 fw-bold" name="phone1" id="phone1" readonly="readonly" disabled="disabled" value="<?=$this->rs_customer['phone']?>">
				</div>
			</div>
			<div class="col-12">
				<div class="border rounded p-3 position-relative">
					<label for="phone" class="profile-label">Email</label>
					<input type="text" class="border-0 fw-bold" name="email" id="email" value="<?=$this->rs_customer['email']?>">
				</div>
			</div>

			<div class="col-12">
				<div class="border rounded p-3 position-relative">
					<label for="phone" class="profile-label">Profile Photo</label>
					<input type="file" class="border-0 fw-bold" name="profile_image" id="profile_image">
				</div>
			</div>

			<div class="col-12">
				<div class="mb-5">
					<button type="submit" class="btn btn-solid rounded-pill w-100 customerFormSubmit">Save Details</button>
				</div>
			</div>

		</div>
	</form>
</main>
<!-- Main End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->