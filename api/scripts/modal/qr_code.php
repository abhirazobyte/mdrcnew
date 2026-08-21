<?php
include '../../modules/phpqrcode/qrlib.php';

$id=$app->getGetVar('id');

$obj_model_table= $app->load_model("ipo_pdfs");
$rs_pdf= $obj_model_table->execute("SELECT",false,"","id='".$id."'","");

$img = $app->utility->get_image_path($rs_pdf[0]['file_name'], 'ipo_pdfs', "large");
$PNG_TEMP_DIR = ABS_PATH . '/uploads/ipo_pdfs/';
$filename = $PNG_TEMP_DIR.$rs_pdf[0]['file_name'] . '.png';
$code =$img;
QRcode::png($code, $filename, 'L', '3', '1');
$image='<img src="../uploads/ipo_pdfs/' . basename($filename) . '"  style="width: 216px;">';
?>
<div class="form-block fdgn2">
  <div class="box">
    <table>
      <tr>
        <td style="width: 100%;">
        <?=$image?>
        </td>
      </tr>
    </table>
  </div>
</div>
       
