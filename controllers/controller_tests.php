<?
class _tests extends controller {

	function init() {
	}

	function onload() {


		// $obj_model_item= $this->app->load_model("item_lab");
		// $obj_model_item->join_table("city", "left", array(), array("city_id"=>"id"));
		// $rs_data= $obj_model_item->execute("SELECT",false,"","item_lab.status='Active'");
		// $city=[];
		// foreach($rs_data as $item)
		// {
		// 	$city[strtolower($item['city_name'])]=$item['panel_id'];
		// }
		// print_r($city);exit;
		echo 'hi';
		exit;
		

		//removing price 
		$obj_model_item= $this->app->load_model("item");
		$obj_model_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$rs_data= $obj_model_item->execute("SELECT",false,"","item.status='Active' and item_department_ids=1");

		for($i=0;$i<count($rs_data);$i++)
		{
			$obj_model_item_price= $this->app->load_model("item_price");
			$obj_model_item_price->execute("DELETE",false,"","(city_id=15 or city_id=16 or city_id=17) and item_id=".$rs_data[$i]['id']."");
		}

		echo 'hi';
		exit;
		
		//for add new city
		$obj_model_item= $this->app->load_model("item");
		$obj_model_item->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
		$rs_data= $obj_model_item->execute("SELECT",false,"","item.status='Active' and FIND_IN_SET('2',item_department_ids)");
		
		
 
		for($i=0;$i<count($rs_data);$i++)
		{
			$city_ids=explode(',',$rs_data[$i]['city_ids']);
			//$state_ids=explode(',',$rs_data[$i]['state_ids']);
			
			$update=false;
			$data_item = array();
			if(!in_array('18',$city_ids))
			{
				$data_item['city_ids'] = $rs_data[$i]['city_ids'].',18';
				$update=true;
			}
			if(!in_array('1',$state_ids))
			{
				$data_item['state_ids'] = $rs_data[$i]['state_ids'].',8,9,10';
				$update=true;
			}
			if($update)
			{
				$obj_model_item2 = $this->app->load_model("item");
				$obj_model_item2->map_fields($data_item);
				$obj_model_item2->execute("UPDATE",false,"","id='".$rs_data[$i]['id']."'");
			}

			$obj_model_item_price= $this->app->load_model("item_price");
			$rs_price= $obj_model_item_price->execute("SELECT",false,"","city_id=1 and item_id=".$rs_data[$i]['id']."");
			if(count($rs_price)>0)
			{
				
				$data = array();
				$data['item_id'] = $rs_data[$i]['id'];
				$data['city_id'] = '18';
				$data['state_id'] = '1';
				$data['api_city_id'] = '410';
				$data['api_state_id'] = '26';
				$data['price'] = $rs_price[0]['price'];
				$data['mrp'] = $rs_price[0]['mrp'];
				$data['sch_price'] = '0';
				$data['sch_start_date'] = '';
				$data['sch_end_date'] = '';
				$data['item_certificate_ids'] = $rs_price[0]['item_certificate_ids'];
				$data['item_lab_ids'] = '';
				$data['entry_date_time'] = date('d-m-Y H:i:s');
				$obj_model_item = $this->app->load_model("item_price");
				$obj_model_item->map_fields($data);
				$obj_model_item->execute("INSERT",false,"","");

				// $data = array();
				// $data['item_id'] = $rs_data[$i]['id'];
				// $data['city_id'] = '15';
				// $data['state_id'] = '8';
				// $data['api_city_id'] = '148';
				// $data['api_state_id'] = '11';
				// $data['price'] = $rs_price[0]['price'];
				// $data['mrp'] = $rs_price[0]['mrp'];
				// $data['sch_price'] = '0';
				// $data['sch_start_date'] = '';
				// $data['sch_end_date'] = '';
				// $data['item_certificate_ids'] = $rs_price[0]['item_certificate_ids'];
				// $data['item_lab_ids'] = '';
				// $data['entry_date_time'] = date('d-m-Y H:i:s');
				// $obj_model_item = $this->app->load_model("item_price");
				// $obj_model_item->map_fields($data);
				// $obj_model_item->execute("INSERT",false,"","");

				// $data = array();
				// $data['item_id'] = $rs_data[$i]['id'];
				// $data['city_id'] = '16';
				// $data['state_id'] = '9';
				// $data['api_city_id'] = '148';
				// $data['api_state_id'] = '11';
				// $data['price'] = $rs_price[0]['price'];
				// $data['mrp'] = $rs_price[0]['mrp'];
				// $data['sch_price'] = '0';
				// $data['sch_start_date'] = '';
				// $data['sch_end_date'] = '';
				// $data['item_certificate_ids'] = $rs_price[0]['item_certificate_ids'];
				// $data['item_lab_ids'] = '';
				// $data['entry_date_time'] = date('d-m-Y H:i:s');
				// $obj_model_item = $this->app->load_model("item_price");
				// $obj_model_item->map_fields($data);
				// $obj_model_item->execute("INSERT",false,"","");

				// $data = array();
				// $data['item_id'] = $rs_data[$i]['id'];
				// $data['city_id'] = '17';
				// $data['state_id'] = '10';
				// $data['api_city_id'] = '148';
				// $data['api_state_id'] = '11';
				// $data['price'] = $rs_price[0]['price'];
				// $data['mrp'] = $rs_price[0]['mrp'];
				// $data['sch_price'] = '0';
				// $data['sch_start_date'] = '';
				// $data['sch_end_date'] = '';
				// $data['item_certificate_ids'] = $rs_price[0]['item_certificate_ids'];
				// $data['item_lab_ids'] = '';
				// $data['entry_date_time'] = date('d-m-Y H:i:s');
				// $obj_model_item = $this->app->load_model("item_price");
				// $obj_model_item->map_fields($data);
				// $obj_model_item->execute("INSERT",false,"","");	
			}
		}
	}
}
?>