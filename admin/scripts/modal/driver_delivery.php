<?php
$id=$app->getGetVar('id');

if($id!='')
{		
	
	$obj_model_dispatched = $app->load_model("order_master");
	$obj_model_dispatched->join_table("user", "left", array( "name"), array("user_id"=>"id"));
	$obj_model_dispatched->join_table("delivery_vans", "left", array("van_no","person_name"), array("van_id"=>"id")); 
	$obj_model_dispatched->join_table("order_shipping_address", "left", array( ), array("id"=>"order_master_id"));
	//$obj_model_dispatched->join_table("invoice", "left", array(), array("id"=>"order_master_id"));
	$rs_dispatched = $obj_model_dispatched->execute("SELECT", false, "","order_status='On Delivery' and van_id=".$id."");
	
	
	$obj_model_dv = $app->load_model("delivery_vans");	
	$rs_dv = $obj_model_dv->execute("SELECT", false, "","id=".$id."");

}


?>

<style>
@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  
  #printSection, #printSection * {
    visibility:visible;
  }

.modal-header {
    display: none;
  }
  
  #printSection {
    position:absolute;
	background:#fff;
    left:0;
    top:0;
	width:100%
  }
}



</style>

<div class="modal fade" id="modal_driver_delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content tx-14" id="printThis">
      <div class="modal-header">

      <button type="button" id="btnPrint" class="btn btn-xs btn-warning btn-icon"><i class="fas fa-print"></i></button>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>

      <div class="modal-body" >
        <div class="form-row">
          <div class="form-group col-md-12">
          
 
      

            <table class="table" style="border: hidden;">
             <thead>
              <tr>
               <td style="width:50%; text-align:left;"><div style="display:inline-block;"> <img src="../images/logo.png" alt=""> </div></td>
               <td style="text-align:right; width:50%;"><div style="display:inline-block;">
                 <h4 class="inv">Delivery List</h4>
                 <p style="font-weight:bold;">Date: <?php echo date("d-M-Y"); ?></p>
                  <p style="font-weight:bold;">Van No: <?php echo $rs_dv[0]['van_no'] ?></p>
                </div></td>
              </tr>
             </thead>
            </table>

          
            <table class="table table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Sr No</th>
                  <th scope="col">Order No</th>
                  <th scope="col">User detail</th>
                  <th scope="col">Collect Amount</th>
                  <th scope="col">Customer Sign</th>
                </tr>
              </thead>
              <tbody>
                <?php for($i=0;$i<count($rs_dispatched);$i++){?>
                <tr>
                  <th scope="row"><?=$i+1?></th>
                  <th>#<?=$rs_dispatched[$i]['id']?></th>
                  <td><strong>
                    <?=$rs_dispatched[$i]['order_shipping_address_first_name']?>
                    </strong><br />
                    <?=$rs_dispatched[$i]['order_shipping_address_address_line1']?>
                    ,<br />
                    <strong>
                    <?=$rs_dispatched[$i]['order_shipping_address_shipping_area_name']?>
                    </strong> <br/><strong> Phone:
                    <?=$rs_dispatched[$i]['order_shipping_address_contact_number']?>
                    </strong></td>
                    <th><i class="fas fa-rupee-sign"></i><?=$rs_dispatched[$i]['pay_value']?></th> 
                  <td></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script>