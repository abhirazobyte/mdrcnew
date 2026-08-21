<?php
$id=$app->getGetVar('id');
	
	
$city_id=$_SESSION['cityID'];
$city_cond=" and FIND_IN_SET ('".$city_id."',item.city_ids) and item_price.city_id='".$city_id."'";			
$master_con=$city_cond;

$obj_model_all = $app->load_model("customer_members");
//$obj_model_all->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
//$obj_model_all->join_table("item_price", "left", array(), array("id"=>"item_id"));
//$obj_model_all->join_table("item_description", "left", array(), array("id"=>"item_id"));					
$rs_data = $obj_model_all->execute("SELECT",false,"","customer_members.id!=0 and customer_members.customer_id='".$_SESSION['MDRCCustID']."' and customer_members.status!='Trash'","customer_members.id DESC","");


?>



<div class="popup-modals modal-ad-style coup-modal">
  <div class="modal" id="Modalselect-add-patients" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="common-heading">
            <h4 class="mt0 mb0">SELECT / ADD PATIENTS</h4>
          </div>
          <button type="button" class="closes" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-0">
          <div class="form-block fdgn2 add-patient mt10">
            <form action="#" method="post" name="feedback-form">
            <input type="hidden" name="cartID" id="cartID" value="<?=$id?>">
            
            
            <?php if(count($rs_data)>0){?>
              <div class="fieldsets row m-auto bdr border-top-0">
              
              
              
              
			  <?php for($i=0;$i<count($rs_data);$i++){?>
                <div class="col-md-12 pt-3 pb-3 ps-4 pe-4">
                		<div class="custom-control custom-radio">
												<label class="custom-control-label">
													<input type="radio" value="<?=$rs_data[$i]['id']?>" name="members">
													<svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
														<path d="M9 20l-7-7 3-3 4 4L19 4l3 3z"></path>
													</svg>
													<span class="ml-3 adri"><span class="fw-semibold"><?=($i+1)?>. <?=$rs_data[$i]['prefix']?> <?=$rs_data[$i]['first_name']?> <?=$rs_data[$i]['last_name']?></span><br><?=$rs_data[$i]['gender']?> , <?=$rs_data[$i]['age']?> yrs.</span></label>
                        </div>
                </div>
                
                <?php }?>
                
                
                
                  <div class="col-md-12 mb-3 ps-5">
                    
                      <button type="button" name="submit" class="btn-main  bg-btn1 btn-blue lnk text-uppercase w-auto AddMemberData ms-2" data-id="<?=$id?>">Add Member <span class="circle"></span></button>
                      
                  </div>
                
              </div>
              
              
              <div class="fieldsets row m-auto pt-3 pb-3">
              
               <div class="col-lg-12 pt-2 pb-2 col-12 error_div" id="ListCouponDiv">
               
               </div>
            
           	  </div>
              
            
            
            
            
            
              <div class="fieldsets row m-auto pt-3 pb-3">
                	
                	<div class="col-md-6 ms-auto">
                    
                    
           			
                    <button type="button" name="submit" class="btn-main bg-btn1 btn-blue lnk text-uppercase w-100 selectMemberData">Select <span class="circle"></span></button>
                      
                        
                                
           			</div>
                    
              </div>
              <?php }else{?>
              
              <div class="fieldsets row m-auto pt-3 pb-3" style="text-align:center">
                	
                    <div class="col-md-12">
                    <p class="mb-3">No Members Added.</p>
                     <button type="button" name="submit" class="btn-main bg-btn1 btn-blue lnk text-uppercase w-auto AddMemberData" data-id="<?=$id?>">Add Member <span class="circle"></span></button>
                	</div>
                	
                    
                    
              </div>
              
              
              <?php }?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>








