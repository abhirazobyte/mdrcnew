<?



class _search extends controller{



	function init(){



	}



	function onload(){


		
			$REQUEST_URI=$_SERVER['REQUEST_URI'];
			$REQUEST_URI=str_replace(".html","",$REQUEST_URI);
			$explodeData=explode('/',$REQUEST_URI);
			
			$total_datas=count($explodeData);					
			$searchKeword=urldecode($explodeData[$total_datas-1]);
			$citySlug=urldecode($explodeData[$total_datas-2]);		
			
			$checkCity=$this->app->utility->checkCityData($citySlug);
			if($checkCity=='')
			{
				$this->app->redirect(SERVER_ROOT);
				exit;
			}
			
			
			

			$this->app->setTitle($this->app->meta['title']);
			$this->app->setKeywords($this->app->meta['keyword']);
			$this->app->setDescription($this->app->meta['description']);




		

			$department_id='';
			$city_id=$_SESSION['cityID'];
			$city_name=$_SESSION['cityName'];
			$pageType='Search';
	
	
			$this->app->assign("department_id",$department_id);
			$this->app->assign("city_id",$city_id);
			$this->app->assign("city_name",$city_name);
			$this->app->assign("searchKeword",$searchKeword);
			$this->app->assign("pageType",$pageType);

		

		

		

		

		



		

	



	}



	



	



	



}



?>