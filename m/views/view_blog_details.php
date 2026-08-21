<?php include('includes/header.php'); ?>

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
                <h2 class="text-202024 font-lg fw-bold theme-color"><?=$name?></h2>
                <div class="row mt20 mb20">
                    <div class="col-md-8 col-9">
                        <div class="media">
                            <div class="media-body user-info">
                                <h5 class="mb-2">By Admin</h5>
                                <!-- <p><?=$new_date?></p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-3">
                    </div>
                </div>
            </div>
            <div class="image-set"><img src="<?=$blogImage?>" alt="blog images" class="img-fluid"></div>
            <div class="blog-content mt-3">
            <div><?=$about_info?></div>
            <div class="row mt30">
                <div class="col-lg-8 col-md-8 mt30 mb30">
                    <div class="blog-post-tag">
                        <h5>Releted Tags</h5>
                        <?php for($i=0;$i<count($this->rs_blog_tag);$i++){?>
                        <a href="blog/tag/<?=$this->rs_blog_tag[$i]['slug']?>"><?=$this->rs_blog_tag[$i]['name']?></a>
                        <?php }?>
                        
                    </div>
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