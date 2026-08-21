<?
class _search extends controller
{
	function init()
    {
	}

	function onload()
	{
        // $cityID="MTQ=";
		// $cityID=$cityID==''?"MTQ=":$this->app->utility->decrypt($cityID);

        $cityID=mysqli_real_escape_string($this->app->set_db_conn(),$this->app->getPostVar('cityID'));
		$cityID=$cityID!=''?$this->app->utility->decrypt($cityID):"1";
        
        if($cityID!=''){
            $obj_model= $this->app->load_model("item");
            $obj_model->join_table("item_other_data", "left", array(), array("id"=>"item_id"));
            $allItems = $obj_model->execute("SELECT", false, "","FIND_IN_SET ('".$cityID."',item.city_ids) and (item.status='Active')","item.name asc");
            if(count($allItems)>0)
            {
                foreach($allItems as $item)
                {
                    $itemLabel=$item['item_other_data_item_type_id']==1?"Package":"Test";
                    $ID=$this->app->utility->encrypt($item['id']);
                    $itemList[] = array("itemID"=>$ID,"name"=>$item['name'],"slug"=>$item['slug'],"tags"=>$item['tags'],"label"=>$itemLabel);
                }
            }
            else
            {
                $itemList=[];
            }
            $result=["itemList"=>$itemList];
            $message=array("message"=>'',"msgCode"=>"1","result"=>$result);
        }
        else
        {
            $message=array("message"=>"Date missing.","msgCode"=>"0");
        }
        $opt=json_encode($message, JSON_UNESCAPED_UNICODE);
		echo $this->app->utility->indent($opt);
		exit;
	}
}
?>