<?
class _check_city_data extends controller
{
	function init() {}
	function onload()
	{
		$cityName = $this->app->getPostVar("cityName");
		$cityName = ucfirst(strtolower($cityName));
		$cityName = mysqli_real_escape_string($this->app->set_db_conn(), $cityName);

		if ($cityName) {
			$obj_model_city = $this->app->load_model("city");
			$city = $obj_model_city->execute("SELECT", false, "", "name='" . $cityName . "'");
			$cityDetail = [];
			if ($city) {
				$folder = 'city';
				$image = $this->app->utility->get_image_path($city[0]['image'], $folder, 'large');
				$cityDetail = [
					"id" => $this->app->utility->encrypt($city[0]['id']),
					"name" => $city[0]['name'],
					"slug" => $city[0]['slug'],
					"phone" => $city[0]['phone'],
					"image" => $image
				];
				$result = ["cityDetail" => $cityDetail];
				$message = array("message" => "success", "msgCode" => "1", "result" => $result);
			} else {
				$message = array("message" => "City Details Not Found !", "msgCode" => "0");
			}
		} else {
			$message = array("message" => "cityName is Required !", "msgCode" => "0");
		}

		$opt = json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
