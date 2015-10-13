<?php

class View{
	
	public $title = "MC2 - Marketing Results";
	
	private static $scripts 		= array();
	private static $styles 			= array();
	private static $metaTags 		= array();
	private static $bodyAttributes 	= array();
	private static $errors 			= array();
	private static $messages 		= array();
	public $page = "";

	public function __construct(){
		//TODO: load all page settings here
	}

	protected function getErrors(){
		return $this->errors;
	}

	protected function getError($key){
		return $this->errors[$key];
	}

	protected function addError($key, $value){
		$this->errors = array_merge($this->errors, array($key=>$value));
	}

	protected function getMessages(){
		return $this->messages;
	}

	protected function getMessage($key){
		return $this->messages[$key];
	}

	protected function addMessage($key, $value){
		$this->messages = array_merge($this->messages, array($key=>$value));
	}

}

?>
