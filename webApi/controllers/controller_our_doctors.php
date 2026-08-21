<?
class _our_doctors extends controller
{

	function init() {}

	function onload()
	{
		$obj_model_table= $this->app->load_model("doctor");
        $obj_model_table->join_table("doctor_category", "left", array("name"), array("category_id"=>"id"));
        $rs_doctor= $obj_model_table->execute("SELECT",false,"","doctor.status='Active'","doctor.sort_order ASC");

        $doctors=[];
        for($i=0;$i<count($rs_doctor);$i++){
            $image = $this->app->utility->get_image_path($rs_doctor[$i]['image'], 'doctor', 'large');
			$doctors[] = [
				"image" => $image,
				"name" => $rs_doctor[$i]['name'],
				"category" => $rs_doctor[$i]['doctor_category_name'],
				"description" => $rs_doctor[$i]['about_info'],
			];
		}

		$obj_meta = $this->app->load_model('page_info');
		$meta_data = $obj_meta->execute("SELECT", false, "","page_name='our_doctors' and status!='Trash'");

		$result = [
			"meta_title" => $meta_data[0]['page_title'],
			"meta_keyword" => $meta_data[0]['meta_keywords'],
			"meta_description" => $meta_data[0]['meta_description'],
			"meta_schema" => $meta_data[0]['meta_schema'],
			"favicon" => 'https://www.mdrcindia.com/images/favicon.png',
			"doctors" => $doctors
		];
		$message = array("message" => "success", "msgCode" => "1", "data" => $result);

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
