<?php
	ini_set("max_execution_time", "0");
	ini_set("max_input_time", "0");
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	ini_set('display_errors', true);
	
	//load main libraries
	require("includes/classes/class_Controller.php");
	require("includes/classes/class_Database.php");
	require("includes/classes/class_DB.php");
	require("includes/classes/class_View.php");
	require("includes/classes/class_File.php");
	require("includes/classes/class_ModuleQuery.php");
	require("includes/classes/class_Pagination.php");
	require("includes/classes/class_PhotoUpload.php");
	
	//load module classes libraries
	require("includes/modules/class_Product.php");
	
	//load configuration
	require("conf/config.php");
	require("conf/constants.inc.php");
	
	//load utility libraries
	require("includes/common/utilities.php");	
	require("includes/common/forms.php");	
	
	$controller = new Controller();

	if($_REQUEST['mod'] == 'index.php'){
		$controller->redirect(APP_ROOT."/dashboard");
	}
	if($_REQUEST['mod'] != 'login' && (!isset($_SESSION['user']) || empty($_SESSION['user']['admin_id']))){
		$controller->redirect(APP_ROOT."/login");
	}

	$controller->module = (isset($_REQUEST['mod']) && $_REQUEST['mod']!="" && $_REQUEST['mod']!="index.php") ? $_REQUEST['mod'] : "dashboard";
	$controller->parseFile();	

	$action 	= $controller->getAction();
	$breadcrumb = $controller->getBreadcrumb();

	if($action){
		include($action);
		$page = $controller->getPage();
		if($page){
			if(!is_object($view)){
				$view = new View();
			}
			$view->page = $page;
			
			if(!$controller->isAjax()){
				header("Content-type: text/html; charset=UTF-8");
				$template = $controller->getTemplate();
				include($template);
			}
			else{
				include($view->page);
			}
		}
		exit();
	}

	$controller->redirect("notFound");
?>
