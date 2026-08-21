<?php include('includes/header.php'); ?>
<!-- gallery css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet">

<?php 
    $id=$this->records['id'];
    $blog_category_name=$this->records['blog_category_name'];
    $name=$this->records['name'];
    $about_info=$this->records['about_info'];
    $folder=$this->records['folder'];
    $image=$this->records['image'];
    $blogImage=$this->utility->get_image_path($image,'blog/'.$folder.'/','large');
    $date=$this->records['entry_date_time'];
    $old_date=date_create($date);
    $new_date=date_format($old_date,"M d, Y");    
?>

<!-- Main Start -->
<main class="main-btm-pd bg-white page-common">
    <!-- blog details -->
    <div class="row mx-0">
        <div class="col-12">
            <div class="blog-header">
                <h2 class="text-202024 theme-color font-lg fw-bold"><?=$name?></h2>
                <div class="row mt20 mb20">
                    <div class="col-md-8 col-9">
                        <div class="media">
                            <div class="media-body user-info">
                                <p><?=$new_date?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-3">
                    </div>
                </div>
            </div>
            
            <div class="blog-content mt-3">
            <div><?=$about_info?></div>
            <div class="row mt30">
                <div class="col-lg-12 col-md-12 mt30 mb30 isotope">
                    <?php if(count($this->event_gallery)>0) { ?>
                    <div class="masonary-gallery-mdrc mt30">
                        <?php foreach($this->event_gallery as $img){
                        $img=SERVER_ROOT.'/uploads/event/'.$img['folder'].'/'.$img['image'];
                        ?>
                        <a class="popupimg" href="<?=$img;?>">
                            <img src="<?=$img;?>" alt="">
                        </a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- blog details -->
</main>
<!-- Main End -->
<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->
<!-- gallery js -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js'></script>