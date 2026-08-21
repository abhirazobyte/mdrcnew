<?
	class _site_map extends controller{
		
		function init(){
		}
		
		function onload(){
			$data = $this->app->compile();
			$this->load_parser($data);
			$this->parser->assign("MESSAGE", $this->app->utility->get_message());
			$this->parser->parse('main');			
			$this->update_ouput($this->parser->text('main'));
			$this->unload_parser();
		}
	
		function update_data(){
			$allowExtensions = array('xml');
			if(empty($_FILES['file_1']['name']) && empty($_FILES['file_2']['name'])){
				$this->app->utility->set_message("Please select file.", "ERROR");
				$this->app->redirect("index.php?view=site_map");
				exit;
			}
			if(!empty($_FILES['file_1']['name']))
			{	
				$fileName = $_FILES['file_1']['name'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps)); 
				if (in_array($fileExtension, $allowExtensions)) 
				{
					$path=ABS_PATH.'/sitemap/'.$_FILES['file_1']['name'];
					move_uploaded_file($_FILES['file_1']['tmp_name'], $path);
				}	
				else
				{
					$this->app->utility->set_message("Please select <b>.xml</b> file.", "ERROR");
					$this->app->redirect("index.php?view=site_map");
					exit;
				}	
			}
			
			if(!empty($_FILES['file_2']['name']))
			{	
				$fileName = $_FILES['file_2']['name'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps)); 
				if (in_array($fileExtension, $allowExtensions)) 
				{
					$path_1=ABS_PATH.'/'.$_FILES['file_2']['name'];
					move_uploaded_file($_FILES['file_2']['tmp_name'], $path_1);	
				}	
				else
				{
					$this->app->utility->set_message("Please select <b>.xml</b> file.", "ERROR");
					$this->app->redirect("index.php?view=site_map");
					exit;
				}
			}
			$this->app->utility->set_message("File Upload successfully...", "SUCCESS");
			$this->app->redirect("index.php?view=site_map");
		
		}	
		
	}	
?>