<?

include '../modules/phpqrcode/qrlib.php';

class _ipo extends controller
{
	function init() {}
	function onload()
	{

		$category = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar("category"));


		$obj_model_table = $this->app->load_model("ipo_pdfs");
		$rs_pdf = $obj_model_table->execute("SELECT", false, "", "status='Active' and page_type='" . $category . "'", "sort_order ASC");

		foreach ($rs_pdf as $pdf) {
			$img = $this->app->utility->get_image_path($pdf['file_name'], 'ipo_pdfs', "large");
			$PNG_TEMP_DIR = ABS_PATH . '/uploads/ipo_pdfs/';
			$filename = $PNG_TEMP_DIR . $pdf['file_name'] . '.png';
			$code = $img;
			QRcode::png($code, $filename, 'L', '3', '1');
			$image = SERVER_ROOT . '/uploads/ipo_pdfs/' . basename($filename);

			$ipos[] = [
				"name" => $pdf['title'],
				"file" => $img,
				"qr" => $pdf['qr_code'] == 'Yes' ? $image : '',
			];
		}

		if($category == 'News Releases') {
			$other = [
				'title' => 'News Releases',
				'description' => 'Official repository of regulatory filings, including the DRHP, RHP and public announcements for the MDRC India Initial Public Offer.'
			];
		} elseif($category == 'Policies') {
			$other = [
				'title' => 'Policies',
				'description' => 'Official repository of regulatory filings, including the DRHP, RHP and public announcements for the MDRC India Initial Public Offer.'
			];
		} elseif($category == 'IPO') {
			$other = [
				'title' => 'IPO / Offer Documents',
				'description' => 'Official repository of regulatory filings, including the DRHP, RHP and public announcements for the MDRC India Initial Public Offer.'
			];
		} else {
			$other = [
				'title' => '',
				'description' => ''
			];
		}

		$result = ["ipos" => $ipos, "other" => $other];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
