<?php
	class Product extends ModuleQuery {

		public function __construct($table_def = array()){	
			global $_SESSION;
			if(!$this->connection){
				$this->connect();	
			}

			$this->defineModule();

			//form other variables if defined
			if(is_array($table_def)){
				foreach($table_def as $key => $val){
					$this->{$key} = $val;
				}
			}
		}

		public function defineModule(){
			$this->tableName  = 'product';			
			$this->primaryKey = 'product.product_id';
			$this->select 	  = 'product.*';
			
			//for dynamic dropdown
			$this->select_list_value 		= 'product_id';
			$this->select_list_text 		= 'name';
			$this->select_list_default		= '';
			$this->select_list_attributes	= 'name="product_id" id="product_id"';
			$this->select_list_first_val 	= array("value"=>"", "text"=>"");
			$this->select_list_last_val 	= array();
		}
	}
?>
