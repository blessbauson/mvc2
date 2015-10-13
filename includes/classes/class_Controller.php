<?php

	class Controller{
		
		public $module;
		private $modules = array();
		private $actionFile = "conf/modules.ini";

		public function parseFile(){
			$this->modules = parse_ini_file($this->actionFile, true);
			return $this->modules;
		}

		public function getAction(){
			$action = "actions/".$this->modules[$this->module]['action'];
			if(file_exists($action) && $action!="actions/")
				return $action;
			else
				return false;
		}

		public function getPage(){
			$page = "pages/".$this->modules[$this->module]['page'];
			if(file_exists($page) && $page!="pages/")
				return $page;
			else
				return false;
		}

		public function setPage($path){
			$this->modules[$this->module]['page'] = "pages/".$path;
		}
		
		public function getTemplate(){
			$template = "templates/".$this->modules[$this->module]['template'];
			if(file_exists($template) && $template!="templates/")
				return $template;
			else
				return "templates/default.php";
		}
		
		public function isAjax(){
			if(isset($this->modules[$this->module]['ajax']) && $this->modules[$this->module]['ajax'])
				return true;
			else
				return false;
		}
		
		public function redirect($url, $absolute=false){
			if($absolute)
				$url = WEB_ROOT.($url[0]=='/' ? '':'/').$url;
				header("Location: $url");
			exit();
		}

		public function getBreadcrumb(){
			if(isset($this->modules[$this->module]['breadcrumbLabel']) && $this->modules[$this->module]['breadcrumbLabel'])
				return "<a href='".$this->modules[$this->module]['breadcrumUrl']."'>".$this->modules[$this->module]['breadcrumbLabel']."</a>";
			else
				return false;
		}
	}

?>
