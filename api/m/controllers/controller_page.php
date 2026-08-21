<? class _page extends controller{
 
 function init(){}
 function onload(){
 //echo 'i m a page';
if($this->app->getGetVar("page_id")!=NULL)
{		
 $obj_model_pages = $this->app->load_model("pages");
 $rspages = $obj_model_pages->execute("SELECT",false,"","slug='".$this->app->getGetVar("page_id")."'");
 if(count($rspages)>0)
 {
			 $this->assign("page",$rspages[0]);

			$this->assign("page_title",$rspages[0]['page_title']);

			if($rspages[0]['meta_title']==''){

				/* === code for set TITLE , META TAGS and DESCRIPTION ==== */

				$this->app->setTitle($rspages[0]["page_title"]."  -  ".$this->app->meta['title']);	
				$this->app->setKeywords($this->app->meta['keyword']);	
				$this->app->setDescription($this->app->meta['description']);

			} else {

				/* === code for set TITLE , META TAGS and DESCRIPTION - edited by Nilson 1 SEPT 2012 ==== */

				$this->app->setTitle($rspages[0]['meta_title']);	
				$this->app->setKeywords($rspages[0]["meta_keyword"]);	
				$this->app->setDescription($rspages[0]["meta_description"]);	

			}
	

			

			

			//echo $obj_model_pages->sql;	

			
			}
			else
			{
				$this->app->redirect(SERVER_ROOT);
				
			}


		}else{

			$this->app->redirect(SERVER_ROOT);

		}

	}

	
}	

?>