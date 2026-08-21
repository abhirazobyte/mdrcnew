<?php

$id=$app->getGetVar('id');
$city_id=$_SESSION['cityID'];

$city_cond=" and FIND_IN_SET ('".$city_id."',item.city_ids) and item_price.city_id='".$city_id."'";			
$master_con=$city_cond;

$obj_model_all = $app->load_model("item");
$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));					
$rs_data = $obj_model_all->execute("SELECT",false,"","item.id!=0 and item.id='".$id."'  ".$master_con."","item.sort_order ASC limit 0,1","");

$item_type=$rs_data[0]['item_other_data_item_type_id'];

if($item_type==1)
{
	$obj_model_packages = $app->load_model("item_package_data");
	$obj_model_packages->join_table("item_description", "left", array(), array("data_id"=>"item_id"));
	$rs_package_data = $obj_model_packages->execute("SELECT",false,"","item_package_data.item_id='".$rs_data[0]['id']."'","");
}
?>

<div class="niwaxofcanvas offcanvas offcanvas-end package-details-info" tabindex="-1" id="offcanvasExample-package-details">

  <div class="offcanvas-body">

    <div class="cbtn animation">

      <div class="btnclose"> <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>

    </div>

    <div class="form-block sidebarform ">

      <h5 class="pt-3 pb-0">Package Details</h5>

      <h4 class="mt-3"><?=$rs_data[0]['name']?></h4>

      <p>Inclusions : <?=$rs_data[0]['test_count']?> tests</p>

     

     

       <?php if(count($rs_package_data)>0){

					 

					 $pName=array();

					 for($i=0;$i<count($rs_package_data);$i++)

					 {

						 $pName[]=$rs_package_data[$i]['item_description_item_name'];

						 

					}

					

					

					

					

					 ?>

                  

                  <p class=""><?=implode(', ',$pName)?></p>

                  

                  <?php }?>

      

      <h5 class="mt-3">Test Parameters</h5>

      <p>Helps you know your test better</p>

      

      

			<div class="col-md-12 p-0 mt20">

					<div class="accordion" id="accordionExample-details">

                    <?php if($rs_data[0]['item_other_data_item_type_id']==1)

						{?>

                        

                        <?php for($i=0;$i<count($rs_package_data);$i++){?>

							<div class="accordion-item">

								<h2 class="accordion-header" id="heading-detail-<?=$i?>">

									  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-<?=$i?>" aria-expanded="false" aria-controls="collapseOne">

										<?=$rs_package_data[$i]['item_description_item_name']?>

									  </button>

								</h2>

								<div id="collapse-detail-<?=$i?>" class="accordion-collapse collapse" aria-labelledby="heading-detail-<?=$i?>" data-bs-parent="#accordionExample-details" style="">

									  <div class="accordion-body">

											<div class="data-reqs">
                                            	<?php if($rs_package_data[$i]['item_description_sample_remark']!=''){?>

												 <p> <strong>Sample Remark</strong> : <?=$rs_package_data[$i]['item_description_sample_remark']?></p>
                                                 <?php }?>
                                                 
                                                 <?php if($rs_package_data[$i]['item_description_sample_type_name']!=''){?>

                                   <p> <strong>Sample Type</strong> : <?=$rs_package_data[$i]['item_description_sample_type_name']?></p>
                                    <?php }?>
                                    
                                    <?php if($rs_package_data[$i]['item_description_sample_remark1']!=''){?>

                                   <p> <strong>Sample Remark1</strong> : <?=$rs_package_data[$i]['item_description_sample_remark1']?></p>
                                    <?php }?>
                                    
                                    <?php if($rs_package_data[$i]['item_description_test_parameters']!=''){?>

                                   <div> <strong>Test Parameters</strong> : <?=$rs_package_data[$i]['item_description_test_parameters']?></div>
                                   <?php }?>

                                    

											 </div>

									  </div>

								</div>

						  </div>

                          

                          <?php }?>

                          

                          

                         <?php }else{?>

						  <div class="accordion-item">

									<h2 class="accordion-header" id="heading-detail-2">

										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-detail-2" aria-expanded="false" aria-controls="collapseOne">

											 <?=$rs_data[0]['item_description_item_name']?>

										  </button>

									</h2>

									<div id="collapse-detail-2" class="accordion-collapse collapse" aria-labelledby="heading-detail-2" data-bs-parent="#accordionExample-details" style="">

										  <div class="accordion-body">

												<div class="data-reqs">
                                                	<?php if($rs_data[0]['item_description_sample_remark']!=''){?>

													 <p> <strong>Sample Remark</strong> : <?=$rs_data[0]['item_description_sample_remark']?></p>
                                                     <?php }?>
                                                     
                                                     <?php if($rs_data[0]['item_description_sample_type_name']!=''){?>

                                   <p> <strong>Sample Type</strong> : <?=$rs_data[0]['item_description_sample_type_name']?></p>
                                    <?php }?>
                                    
                                     <?php if($rs_data[0]['item_description_sample_remark1']!=''){?>

                                   <p> <strong>Sample Remark1</strong> : <?=$rs_data[0]['item_description_sample_remark1']?></p>
                                    <?php }?>
                                    
                                     <?php if($rs_data[0]['item_description_test_parameters']!=''){?>

                                   <div> <strong>Test Parameters</strong> : <?=$rs_data[0]['item_description_test_parameters']?></div>
                                    <?php }?>

                                    

												 </div>

										  </div>

									</div>

						  </div>

                           <?php }?>

						  

                          

                          

						  

                          

						</div>

        </div>

    </div>

  </div>

</div>











