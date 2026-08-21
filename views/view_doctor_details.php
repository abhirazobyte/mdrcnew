<link href="<?= SERVER_ROOT ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= SERVER_ROOT ?>/css/plugin.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="<?= SERVER_ROOT ?>/css/style.css" rel="stylesheet">
<link href="<?= SERVER_ROOT ?>/css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<link href="<?= SERVER_ROOT ?>/css/custom.css?v=2.2" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

.doctor-detail-section {
    background: #fff;
}
.doctor-detail-card {
    background: #fff;
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #e8e8e8;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
}

.doctor-detail-card:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
    transform: translateY(-3px);
}

.doctor-detail-photo {
    overflow: hidden;
    border-radius: 7px;
    background: #f5f5f5;
}

.doctor-detail-photo img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    object-position: center top;
    display: block;
    transition: transform 0.4s ease;
}

.doctor-detail-card:hover .doctor-detail-photo img {
    transform: scale(1.02);
}

.doctor-detail-info {
    padding: 10px 10px 10px 25px;
}

.doctor-category-badge {
    display: inline-block;
    padding: 6px 14px;
    margin-bottom: 15px;
    background: #f1f7f7;
    color: #1c7c7c;
    border: 1px solid #dceeee;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
}

.doctor-detail-info h2 {
    margin: 0 0 25px;
    color: #222;
    font-size: 36px;
    line-height: 1.3;
    font-weight: 700;
}


/* Meta Information */
.doctor-detail-meta {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.doctor-meta-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 18px;
    background: #fafafa;
    border: 1px solid #eeeeee;
    border-radius: 7px;
    transition: all 0.3s ease;
}

.doctor-meta-item:hover {
    background: #fff;
    border-color: #d5e8e8;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.doctor-meta-item > i {
    width: 44px;
    height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef7f7;
    color: #1c7c7c;
    border-radius: 50%;
    font-size: 17px;
}

.doctor-meta-item strong {
    display: block;
    color: #333;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 3px;
}

.doctor-meta-item span {
    display: block;
    color: #777;
    font-size: 14px;
}


/* Buttons */
.doctor-detail-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.doctor-cta-btn {
    border-radius: 4px !important;
    padding: 11px 20px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.doctor-cta-btn i {
    margin-right: 5px;
}

.doctor-cta-btn:hover {
    transform: translateY(-2px);
}


/* About Doctor */
.doctor-about-box {
    position: relative;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    padding: 30px 35px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.doctor-about-box h3 {
    position: relative;
    color: #222;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eeeeee;
}

.doctor-about-box h3::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -1px;
    width: 55px;
    height: 2px;
    background: #1c7c7c;
}

.doctor-about-content {
    color: #666;
    font-size: 15px;
    line-height: 1.8;
}

.doctor-about-content p {
    margin-bottom: 10px;
}


/* Related Doctors */
.related-doctors-wrap {
    margin-top: 10px;
}

.related-doctors-title {
    position: relative;
    color: #222;
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 35px;
    padding-bottom: 12px;
}

.related-doctors-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 2px;
    background: #1c7c7c;
}


/* Related Doctor Card */
.related-doctor-card {
    display: block;
    height: 100%;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    overflow: hidden;
    text-decoration: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.related-doctor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
}

.related-doctor-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    object-position: center top;
    display: block;
    transition: transform 0.4s ease;
}

.related-doctor-card:hover img {
    transform: scale(1.03);
}

.related-doctor-info {
    padding: 16px 18px 18px;
}

.related-doctor-info h5 {
    color: #222;
    font-size: 17px;
    font-weight: 600;
    margin: 0 0 6px;
    transition: color 0.3s ease;
}

.related-doctor-card:hover .related-doctor-info h5 {
    color: #1c7c7c;
}

.related-doctor-info p {
    color: #777;
    font-size: 13px;
    margin: 0;
    line-height: 1.5;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

.doctor-detail-meta {
    font-family: 'Roboto', sans-serif;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.doctor-detail-meta .doctor-meta-item {
    font-family: 'Roboto', sans-serif;
}

.doctor-detail-meta .doctor-meta-item strong {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    letter-spacing: 0.2px;
}

.doctor-detail-meta .doctor-meta-item span {
    font-size: 14px;
    font-weight: 400;
    color: #666;
    line-height: 1.5;
}

@media (max-width: 991px) {

    .doctor-detail-info {
        padding: 25px 0 10px;
    }

    .doctor-detail-info h2 {
        font-size: 32px;
    }

    .doctor-detail-photo img {
        height: 450px;
    }

    .doctor-about-box {
        padding: 28px;
    }
}


@media (max-width: 767px) {

    .doctor-detail-section {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .doctor-detail-info {
        padding: 25px 0 5px;
    }

    .doctor-detail-info h2 {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .doctor-detail-photo img {
        height: 380px;
    }

    .doctor-detail-actions {
        flex-direction: column;
    }

    .doctor-cta-btn {
        width: 100%;
    }

    .doctor-about-box {
        padding: 22px;
    }

    .doctor-about-box h3 {
        font-size: 22px;
    }

    .related-doctors-title {
        font-size: 24px;
    }

    .related-doctor-card img {
        height: 280px;
    }
}


@media (max-width: 480px) {

    .doctor-detail-photo img {
        height: 330px;
    }

    .doctor-detail-info h2 {
        font-size: 25px;
    }

    .doctor-meta-item {
        padding: 13px;
    }

    .doctor-meta-item > i {
        width: 40px;
        height: 40px;
        min-width: 40px;
        font-size: 15px;
    }

    .doctor-about-box {
        padding: 20px;
    }

    .related-doctor-card img {
        height: 250px;
    }
}
</style>

<?php include 'includes/header.php';?>

<section class="breadcrumb-area banner-6">
  <div class="text-block">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-start v-center">
          <div class="bread-inner">
            <div class="bread-menu">
              <ul>
                <li><a href="<?= SERVER_ROOT ?>/">Home</a></li>
                <li><a href="<?= SERVER_ROOT ?>/our-doctors">Our Doctors</a></li>
                <li style="color:#FFFFFF;">Doctor Profile</li>
              </ul>
            </div>
            <div class="bread-title">
              <h1 class="f-bold fs-2 text-white"><?= htmlspecialchars($this->doctor['name']) ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="doctor-detail-section pad-tb">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-5">
        <div class="doctor-detail-card">
          <?php
          $doctor_image = $this->utility->get_image_path($this->doctor['image'], 'doctor', 'large');
          ?>
          <div class="doctor-detail-photo">
            <img src="<?= $doctor_image ?>" alt="<?= htmlspecialchars($this->doctor['name']) ?>" class="img-fluid">
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="doctor-detail-info">
          <?php if (!empty($this->doctor['doctor_category_name'])) { ?>
            <span class="doctor-category-badge"><?= htmlspecialchars($this->doctor['doctor_category_name']) ?></span>
          <?php } ?>

          <h2><?= htmlspecialchars($this->doctor['name']) ?></h2>

          <div class="doctor-detail-meta">
            <?php if (!empty($this->doctor['doctor_category_name'])) { ?>
            <div class="doctor-meta-item">
              <i class="fas fa-stethoscope"></i>
              <div>
                <strong>Department</strong>
                <span><?= htmlspecialchars($this->doctor['doctor_category_name']) ?></span>
              </div>
            </div>
            <?php } ?>

            <?php if (!empty($this->doctor['designation'])) { ?>
            <div class="doctor-meta-item">
              <i class="fas fa-user-md"></i>
              <div>
                <strong>Designation</strong>
                <span><?= htmlspecialchars($this->doctor['designation']) ?></span>
              </div>
            </div>
            <?php } ?>
          </div>

          <div class="doctor-detail-actions mt-4">
            <a href="<?= SERVER_ROOT ?>/mdrc-test-booking-enquiry" class="btn btn-primary doctor-cta-btn">
              <i class="fas fa-calendar-check"></i> Book Appointment
            </a>
            <a href="<?= SERVER_ROOT ?>/our-doctors" class="btn btn-outline-primary doctor-cta-btn">
              <i class="fas fa-arrow-left"></i> All Doctors
            </a>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($this->doctor['about_info']) && $this->doctor['display_about'] == 'Active') { ?>
    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="doctor-about-box">
          <h3>About <?= htmlspecialchars($this->doctor['name']) ?></h3>
          <div class="doctor-about-content">
            <?= $this->doctor['about_info'] ?>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

    <?php if (count($this->rs_related) > 0) { ?>
    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="related-doctors-wrap">
          <h3 class="related-doctors-title">Other <?= htmlspecialchars($this->doctor['doctor_category_name']) ?>s</h3>
          <div class="row">
            <?php for ($i = 0; $i < count($this->rs_related); $i++) {
              $rel_image = $this->utility->get_image_path($this->rs_related[$i]['image'], 'doctor', 'large');
              $rel_url = SERVER_ROOT . '/our-doctors/detail/' . $this->rs_related[$i]['slug'];
            ?>
            <div class="col-lg-3 col-md-6 mb-4">
              <a href="<?= $rel_url ?>" class="related-doctor-card">
                <img src="<?= $rel_image ?>" alt="<?= htmlspecialchars($this->rs_related[$i]['name']) ?>">
                <div class="related-doctor-info">
                  <h5><?= htmlspecialchars($this->rs_related[$i]['name']) ?></h5>
                  <?php if (!empty($this->rs_related[$i]['designation'])) { ?>
                    <p><?= htmlspecialchars($this->rs_related[$i]['designation']) ?></p>
                  <?php } ?>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

<?php include 'includes/get_in_touch_form.php';?>
<?php include 'includes/footer.php';?>

<script src="<?= SERVER_ROOT ?>/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="<?= SERVER_ROOT ?>/js/jquery.min.js"></script>
<script src="<?= SERVER_ROOT ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?= SERVER_ROOT ?>/js/plugin.min.js"></script>
<script src="<?= SERVER_ROOT ?>/js/preloader.js"></script>
<script src="<?= SERVER_ROOT ?>/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<?php include 'includes/general_data.php';?>
