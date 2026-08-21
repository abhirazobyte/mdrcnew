<?php include 'includes/header.php'; ?>

<main class="p-3 page-common">

<h2 class="font-lg theme-color mb-3"><?=$this->heading;?></h2>

<div class="row">
            <div class="col-md-12 ">
                <div class="accordion" id="accordionExample">
                    <?php 
                    $i=0;
                    foreach($this->faq as $key=>$value) { 
                    $i++;
                    $default_string = array("{CITY}");
			        $new_string   = array($_SESSION['cityName']);
                    $question=str_replace($default_string, $new_string,$value['question']);  
                    $answer=str_replace($default_string, $new_string,$value['answer']);
                    ?>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header ps-3 pe-2" id="heading-<?=$i;?>">
                            <button class="accordion-button collapsed fw-bold font-md" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?=$i;?>" aria-expanded="true" aria-controls="collapseOne">
                               <?=$question;?>
                            </button>
                        </h2>
                        <div id="collapse-<?=$i;?>" class="accordion-collapse collapse ps-3 pe-2" aria-labelledby="heading-<?=$i;?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="data-reqs">
                                    <?=$answer;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

</main>





<!--Start Footer -->
<?php include 'includes/footer.php'; ?>