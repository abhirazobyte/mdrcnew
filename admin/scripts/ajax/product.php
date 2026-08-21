<?php

$json_class = $app->load_module("JSON");

$obj_json = new $json_class(JSON_LOOSE_TYPE);



//get action

$get_actionType=$app->getGetVar("actionType");

$actionType=$app->getPostVar("actionType");



//Function for Admin Logins datatbale loading

if($get_actionType=="product_list")

{

	$table_name='product';
	$current_status=$app->getGetVar("current_status");

	if($current_status!='')
	{
		$status_cond=" AND product.status='".$current_status."'";
	}
	else
	{
		$status_cond="";
	}
	
	$category_id=$_SESSION['search_category'];
	if($category_id!='' && $category_id!='0')
	{
		$category_cond=" AND product.category_ids='".$category_id."'";
	}
	else
	{
		$category_cond="";
	}
	
	$brand_id=$_SESSION['search_brand'];
	
	if($brand_id!='' && $brand_id!='0')
	{
		$brand_cond=" AND product.brand_id='".$brand_id."'";
	}
	else
	{
		$brand_cond="";
	}
	
	
	
	
	
	
	
	if($_SESSION['search_sel_1']!='')
	{
		
		$trend_cond="  AND product.set_as_bestseller='".$_SESSION['search_sel_1']."'";	
	}
	else
	{
		$trend_cond="";	
	}
	
	if($_SESSION['search_sel_2']!='')
	{
		
		$trend_cond2="  AND product.set_as_new='".$_SESSION['search_sel_2']."'";	
	}
	else
	{
		$trend_cond2="";	
	}



	



	## Read value

	$draw = $app->getPostVar('draw');

	$row = $app->getPostVar('start');

	$rowperpage = $app->getPostVar('length'); // Rows display per page

	$orderArray = $app->getPostVar('order');

	$columnIndex = $orderArray[0]['column']; // Column index

	

	$columnArray = $app->getPostVar('columns');

	$columnName = $columnArray[$columnIndex]['data']; // Column name

	

	if($columnName=='checkbox' || $columnName=='btn' || $columnName=='image')

	{

		$columnName='id';

	}

	

	$columnSortOrder = $orderArray[0]['dir']; // asc or desc

	

	$searchArray=$app->getPostVar('search');

	$searchValue = $searchArray['value']; // Search value

	

	## Search 

	$searchQuery = " ";

	if($searchValue != '')

	{

		$searchQuery = " and (	

		".$table_name.".id like '%".$searchValue."%' or 

		product.name like '%".$searchValue."%' or

		product.model_no like '%".$searchValue."%' or

		product.sku like '%".$searchValue."%' or
		
		
		

		product.tag like '%".$searchValue."%' or
		
		product.in_stock like '%".$searchValue."%' or

		product.status like '%".$searchValue."%'

		) 

		";

	}

	

	## Total number of records without filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".* from ".$table_name."  where id!=0 ");

	$totalRecords = $result[0]['allcount'];

	

	

	## Total number of records with filtering

	$obj_table = $app->load_model($table_name);

	$result = $obj_table->execute("SELECT", false, "SELECT count(*) as allcount,".$table_name.".*,brand.name AS brand from ".$table_name." LEFT JOIN brand AS brand ON(".$table_name.".brand_id=brand.id) where  ".$table_name.".status!='Trash' ".$trend_cond." ".$trend_cond2." ".$status_cond." ".$category_cond." ".$brand_cond." ".$searchQuery);	



	$totalRecordwithFilter = $result[0]['allcount'];

	

	## Fetch records

	$obj_brand = $app->load_model($table_name);
	$obj_brand->join_table("brand", "left", array("name"), array("brand_id"=>"id"));
	$result = $obj_brand->execute("SELECT", false, "", "".$table_name.".id!=0  ".$trend_cond." ".$trend_cond2." ".$status_cond." ".$brand_cond." ".$category_cond." ".$searchQuery.""," ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage." ");

	

	

	$folder='product';


		$obj_model_generel_settings= $app->load_model("generel_settings");
		$rs_gs = $obj_model_generel_settings->execute("SELECT", false,"","");
	

	$data = array();

	for($i=0;$i<count($result);$i++)

	{

		

			//Mobile

			$image=$result[$i]["image"];

			$banner_img=$app->utility->get_image_path($image,$folder.'/'.$result[$i]['folder'].'/',"");

			$cat_list=$app->utility->getprocategories($result[$i]['id']);



			$price_btn='<button type="button" class="btn btn-xs btn-success btn-icon product_price_onclick" data-id="'.$result[$i]['id'].'"><i class="fas fa-rupee-sign"></i></button>';	
			
			
			
			
			



			

			$edit_btn='<a href="index.php?view=product_addedit&id='.$result[$i]['id'].'" type="button" class="btn btn-xs btn-primary btn-icon mg-r-5"><i class="fas fa-edit"></i></a>';	

						

			$delete_btn='<button type="button" class="btn btn-xs btn-danger btn-icon product_delete_onclick" data-id="'.$result[$i]['id'].'" ><i class="fas fa-trash"></i></button>';
			
			
			$img_btn='<a target="_blank" href="index.php?view=multi_image_upload&product_id='.$result[$i]['id'].'" type="button" class="btn btn-xs btn-success btn-icon mg-r-5"><i class="fas fa-image"></i></a>';					

			

			$option='<div class="btn-toolbar"><div>'.$edit_btn.' '.$delete_btn.' '.$img_btn.'</div></div>';

			
			
			
			

			$checkbox='<div class="custom-control custom-checkbox"><input type="checkbox" name="del[]" id="del'.$result[$i]['id'].'"  value="'.$result[$i]['id'].'" class="custom-control-input delAll" ><label class="custom-control-label" for="del'.$result[$i]['id'].'"></label></div>';




			if($result[$i]['in_stock']=='Yes')
			{
				$active_select1='selected="selected"';
				$inactive_select1='';
			}
			elseif($result[$i]['in_stock']=='No')
			{
				$active_select1='';
				$inactive_select1='selected="selected"';
			}
			else
			{
				$active_select1='';
				$inactive_select1='';
			}
			$status_soldout="<select onchange=\"update_soldout_status(this.value, this.id)\" id='".$result[$i]['id']."'\" class=\"form-control\">
			<option value=\"Yes\" ".$active_select1.">Yes</option>
			<option value=\"No\" ".$inactive_select1.">No</option>
			</select>";
			
			
			
			$price='<i class="fa fa-rupee-sign"></i> '.$result[$i]['master_price'];
			
			$status='<img src="assets/img/status/'.$result[$i]['status'].'.png" onclick="javascript:change_status(\''.$result[$i]['id'].'\', \'product\', \''.$result[$i]['status'].'\')" border="0" id="status_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['status'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['status'].'" />';
			
			
			
			$status1='<img src="assets/img/status/'.$result[$i]['set_as_bestseller'].'.png" onclick="javascript:change_status_1(\''.$result[$i]['id'].'\', \'product\', \''.$result[$i]['set_as_bestseller'].'\')" border="0" id="status_best_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['set_as_bestseller'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['set_as_bestseller'].'" />';
			
			
			
			$status2='<img src="assets/img/status/'.$result[$i]['set_as_new'].'.png" onclick="javascript:change_status_2(\''.$result[$i]['id'].'\', \'product\', \''.$result[$i]['set_as_new'].'\')" border="0" id="status_new_'.$result[$i]['id'].'" style="cursor:pointer" alt="'.$result[$i]['set_as_new'].'" data-toggle="tooltip" data-placement="right" title="Tooltip on right" title="'.$result[$i]['set_as_new'].'" />';
			
		
		
		
		
			$status_html='<p>'.$status.' : Status</p>';
			$status_html.='<p>'.$status1.' : '.$rs_gs[0]['display_title1'].'</p>';
			$status_html.='<p>'.$status2.' : '.$rs_gs[0]['display_title2'].'</p>';

		//data

		$data[] = array

		(

			"checkbox"=>$checkbox,

			"id"=>$result[$i]['id'],

			"category"=>$cat_list,

			"name"=>$result[$i]['name']."<br/>".$caption." ".$product_model,

			"image"=>'<a href="'.$banner_img['medium_image'].'" class="image-popup table-product-image-list"><img src="'.$banner_img['thumb_image'].'" class="up_img"></a>',
			
			"brand_name"=>$result[$i]['brand_name'],
			
			"price"=>$price,
			
			"sold_out"=>$status_soldout,

			"status"=>$status_html,	

			"btn"=>$option

		);

	}

	

	## Response

	$response = array(

		"draw" => $draw,

		"iTotalRecords" => $totalRecords,

		"iTotalDisplayRecords" => $totalRecordwithFilter,

		"aaData" => $data

	);

		

	echo json_encode($response);

	exit;

}







//Function for single Admin Logins delete

if($actionType=="productDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		$obj_change_table = $app->load_model('product');

		$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");

		

		if($update_id>0)

		{

			$msg='Sucess';

			$msgcode=0;

		}

		else

		{

			$msg='Please Try Again.';

			$msgcode=1;

		}

	}

	else

	{

		$msg='Please Try Again.';

		$msgcode=1;	

	}

}







//Function for single Admin Logins delete

if($actionType=="product_status_update")

{

	$getid=$app->getPostVar('getid');

	$value=$app->getPostVar('value');

	

	if($getid!= NULL && $getid>0 && $value!='')

	{

		$obj_change_table = $app->load_model('product');

		$update_id = $obj_change_table->execute("UPDATE",false,"UPDATE product SET status='".$value."' WHERE id='".$getid."'");

		

		if($update_id>0)

		{

			$msg='Sucess';

			$msgcode=0;

		}

		else

		{

			$msg='Please Try Again.';

			$msgcode=1;

		}

	}

	else

	{

		$msg='Please Try Again.';

		$msgcode=1;	

	}

}





//Function for multiple Admin Logins delete

if($actionType=="productMultiDelete")

{

	$ids=$app->getPostVar('ids');

	

	if($ids != NULL && $ids!='')

	{

		

		$obj_change_table = $app->load_model('product');

		$update_id = $obj_change_table->execute("DELETE",false,"","id IN (".$ids.")");

		

		if($update_id>0)

		{

			$msg='Sucess';

			$msgcode=0;

		}

		else

		{

			$msg='Please Try Again.';

			$msgcode=1;

		}

	}

	else

	{

		$msg='Please Try Again.';

		$msgcode=1;

	}		

}





//Function for multiple Admin Logins delete






//Function for Product Price delete

if($actionType=="productpriceDelete")

{

	$getid=$app->getPostVar('getid');

	

	if($getid!= NULL && $getid>0)

	{

		$obj_change_table = $app->load_model('product_price');

		$update_id = $obj_change_table->execute("DELETE",false,"","id='".$getid."'");

		

		if($update_id>0)

		{

			$msg='Sucess';

			$msgcode=0;

		}

		else

		{

			$msg='Please Try Again.';

			$msgcode=1;

		}

	}

	else

	{

		$msg='Please Try Again.';

		$msgcode=1;	

	}

}







//Function for Product Price addedit

if($actionType=="productpriceAddEdit")

{

	$product_id=$app->getPostVar('product_id');

	$rweights=$app->getPostVar("rweights");

	$rprices=$app->getPostVar('rprices');

	$mrps=$app->getPostVar('mrps');

	$max_quantitys=$app->getPostVar('max_quantitys');

	

	

	$id=$app->getPostVar('id');


	for($i=0;$i<count($rprices);$i++)

	{

		if($rprices[$i]!='' && $rweights[$i]!='')

		{
			
			if($rprices[$i]>$mrps[$i])
			{
			
				$msg="Price can not be more than mrp";

				$msgcode=1;
				echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
				exit;
			}

			$update_field = array();

			$update_field["product_id"]=$product_id;							

			$update_field["weight"] = $rweights[$i];

			$update_field["price"] = round($rprices[$i]);

			$update_field["mrp"] = round($mrps[$i]);

			

			$update_field["max_quantity"] = $max_quantitys[$i];

			

			

			

			$obj_model_user = $app->load_model("product_price");

			$obj_model_user->map_fields($update_field);

			

			if($id[$i]==0)

			{

				$rs=$obj_model_user->execute("INSERT",false,"");

				$insert=0;

				$update_title='Insert';

			}

			else

			{

				$rs=$obj_model_user->execute("UPDATE",false,"","id='".$id[$i]."'");

				$insert=0;

				$update_title='Update';

			}

		}

	}

	

	if($update_title!='')

	{

		$msg="Record ".$update_title." Successfully.";

		$msgcode=$insert;

	}

}



		




if($actionType=="SessionSet")
{
	$search_category=$app->getPostVar("search_category");
	$search_brand=$app->getPostVar("search_brand");
	
	$search_sel_1=$app->getPostVar("search_sel_1");
	$search_sel_2=$app->getPostVar("search_sel_2");
	
	$_SESSION['search_category']=$search_category;
	$_SESSION['search_brand']=$search_brand;
	
	$_SESSION['search_sel_1']=$search_sel_1;
	$_SESSION['search_sel_2']=$search_sel_2;

	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>'Success'));
	exit;
}




//Function for Product Price addedit
if($actionType=="productAddEdit")
{
	
	
	
	$master_type=$app->getPostVar("master_type");
	$master_price=$app->getPostVar("master_price_s");
	$master_mrp=$app->getPostVar("master_mrp_s");
	$attribute_title1=$app->getPostVar("attribute_title1_data");
	
	
	$attr1=$app->getPostVar("attr1");
	$mrps=$app->getPostVar("mrps");
	$prices=$app->getPostVar('prices');
	
	
	
	
	if($master_type=='Single')
	{
		
				if($master_price<=0 || $master_price=='')
				{
		
					$msg="Please Add Product Price";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				
				}
				
				if($master_price>$master_mrp && $master_mrp>0)
				{
		
					$msg="Product Price is Larger Than MRP.";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				
				}
				
			
	}
	else
	{
		
		if($attribute_title1=='')
		{
					$msg="Please Add Varient 1 Value";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
			
		}
		
		
		
		
		
	
	
	
		for($i=0;$i<count($prices);$i++)
		{
			
			
			
			if($attr1[$i]=='' && $prices[$i]>0)
			{
				
					
					$msg="Please Enter ".$attribute_title1." Value";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				
				
			}
			
			
			
			
			if(($prices[$i]<=0 || $prices[$i]=='') && $attr1[$i]!='')
			{
					$msg="Please Add Varient (".$attr1[$i].") Price";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
				
					exit;
			}
			
			
			if($prices[$i]>$mrps[$i] && $mrps[$i]>0)
				{
		
					$msg="Varient (".$attr1[$i].") Price is Larger Than MRP.";
					$msgcode=1;
					echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));
					exit;
				
				}
		}
	
	
	}
	
			
	echo $obj_json->encode(array("RESULT"=>0,"url"=>"","msg"=>''));
	exit;		
}

		

echo $obj_json->encode(array("RESULT"=>$msgcode,"url"=>"","msg"=>$msg));

?>