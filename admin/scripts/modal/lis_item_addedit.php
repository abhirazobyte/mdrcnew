<?php
$id = $app->getGetVar('id');
$obj_item = $app->load_model("item_lab");
$labs=$obj_item->execute("SELECT", false, "", "status='Active'");
$lab=array_column($labs,'name','id');

if ($id != '') {
    //
} else {
    //    
}
$result = [
  ['id' => 1, 'name' => 'Name'],
  ['id' => 2, 'name' => 'Price'],
];

// $obj_item = $app->load_model("item");
// $result = $obj_item->execute("SELECT", false, "", "id!='0'");
?>
<style>
  .da-card{
    max-height: 400px;
    overflow-x: auto;
  }
</style>
<div class="modal fade" id="modal_lis_item_addedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2">Sync LIS to Web Form</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" name="sync_web_item_form" id="sync_web_item_form" data-parsley-validate>
                <?php $app->htmlBuilder->buildTag("input", array("type" => "hidden", "class" => "form-control", "value" => $id), "id"); ?>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Select Column</label>          
                            <? $app->htmlBuilder->buildTag("select", array("class"=>"form-control select2","values"=>$lab,"required"=>"","multiple"=>""), "lab_ids[]") ;?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Select Column</label>
                            <ul id="itemList" class="ps-3" style="list-style: none;">
                                        <?php if (!empty($result)){ ?>
                                            <?php foreach ($result as $item){ ?>
                                                <li>
                                                    <label class="form-group mb-2" style="cursor:pointer">
                                                        <input type="checkbox" class="form-check-input" id="item_<?= $item['id']; ?>" name="items[]" value="<?= $item['name']; ?>">
                                                        <span class="form-check-label">
                                                            <?= htmlspecialchars($item['name']); ?>
                                                          </span>
                                                    </label>
                                                </li>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <li>NO COLUMN FOUND.</li>
                                        <?php } ?>
                                    </ul>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tx-13 submit_btn sync_web_item_modal_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

