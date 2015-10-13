<?php
	class ModuleQuery extends Database{
			
		public $tableName;		
		public $primaryKey;
		public $update;
		public $add;
		public $select;
		public $filter;	
		public $limit;
		public $order;
		public $joinParams = array();
		
		//for dynamic dropdown
		public $select_list_value;
		public $select_list_text;
		public $select_list_default;
		public $select_list_attributes;
		public $select_list_first_val 	= array();
		public $select_list_last_val 	= array();
		
		public function __construct($table_def){	
			global $_SESSION;
			if(!$this->connection)
				$this->connect();
		}		
				
		public function Select(){	 		
		 	return $this->getRowValue($this->tableName, $this->select, $this->filter, $this->order);
		}
		
		public function SelectAll(){		
		 	return $this->getAllRows($this->tableName, $this->select, $this->filter, $this->order, $this->limit);
		}
		
		public function SelectList(){	
			return $this->getSelectList($this->tableName, $this->select, $this->filter, $this->order, $this->limit, 
										$this->select_list_value,$this->select_list_text,$this->select_list_default,
										$this->select_list_attributes,$this->select_list_first_val,$this->select_list_last_val);
		}
		
		public function Count($filter = ""){		
			if(empty($filter))
				$filter = $this->filter;
			return $this->countRow($this->tableName, $filter);
		}
		
		public function Insert(){		
			return $this->insertIntoDB($this->tableName, $this->add);
		}
		
		public function Update(){			
			return $this->updateDB($this->tableName, $this->update, $this->filter);
		}
		
		public function Deactivate(){		
			return $this->updateDB($this->tableName, array('active_record' => '0'), $this->filter);
		}
		
		public function Activate(){		
			return $this->updateDB($this->tableName, array('active_record' => '1'), $this->filter);
		}
		
		public function Delete(){			
			return $this->deleteFromDB($this->tableName, $this->filter);
		}
		
		public function ResultSet(){			
			return $this->execSQL($this->tableName, $this->select, $this->filter, $this->order, $this->limit);	
		}	

		public function FormQuery(){			
			return $this->buildQuery($this->tableName, $this->select, $this->filter, $this->order, $this->limit);	
		}		
		
		public function AddJoin($type, $tableName, $filter=NULL, $fields=NULL){	
											
			if(!empty($fields))							
				$this->select .= ",".$fields;	
			$this->tableName .= "\n ".$type." ".$tableName;
			if(!empty($filter))
				$this->tableName .= "\n ON (".$filter.")";				
		}		
		
		public function AddFilter($filter){
			if(!empty($filter)){
				if(!empty($this->filter))
					$this->filter .= " AND ";
				$this->filter .= "(".$filter.")";
			}
		}	
		
		public function resetFilter(){
			$this->filter = "";
		}
			
		public function sanitizeReturnFields($tableName, $fields){
			$retval	   = "";
			$arrFields = explode(',', $fields);			
			foreach($arrFields as $field){
				$field = trim($field);
				if($field != '*')
					$field = "`".$field."`";					
				$field = (($field != '*')? "`".$field."`" : $field);
				if(!empty($retval))
					$retval .= ",";
				$retval .= $tableName . "." . $field;  	
			}
			return $retval;			
		}	
		
		public function loadListPageParams($base_path){
			
			global $_GET, $_REQUEST;
			$arrParams = array();	
			
			// filter params...
			$arrParams['currentPage']   = ((intval($_GET['pg3']) == 0) ? 1 : intval($_GET['pg3']));	
			$arrParams['sortFields']    = strip_tags($_GET['sf']);
			$arrParams['sortOrder']	    = strip_tags($_GET['so']);
			$arrParams['filterSearch']  = strip_tags($_REQUEST['fs']);	 								
			$arrParams['filterActive']  = ((!isset($_REQUEST['fa']))? 1 : (int)$_REQUEST['fa']);	
			$arrParams['pageFirstLoad'] = ((isset($_REQUEST['fs']))? false : true);	
			
			// navigation params..					
			$arrParams['currentFilterURL'] = $base_path.
											 '&so='.urlencode($arrParams['sortOrder']).
											 '&sf='.urlencode($arrParams['sortFields']).
											 '&pg3='.$arrParams['currentPage'];
											 										 
			$arrParams['currentSortURL']   = $base_path.
											 '&pg3='.$arrParams['currentPage'].
											 ((isset($_REQUEST['fs']))? '&fs='.urlencode($arrParams['filterSearch']) : '').
											 ((isset($_REQUEST['fa']))? '&fa='.urlencode($arrParams['filterActive']) : '');		
			
			$arrParams['currentNavURL']    = $base_path.
											 '&so='.urlencode($arrParams['sortOrder']).
										 	 '&sf='.urlencode($arrParams['sortFields']).
											 ((isset($_REQUEST['fs']))? '&fs='.urlencode($arrParams['filterSearch']) : '').
											 ((isset($_REQUEST['fa']))? '&fa='.urlencode($arrParams['filterActive']) : '');
			
			$arrParams['pageBreadCrumbs']  = $base_path.
											 '&pg3='.$arrParams['currentPage'].
											 '&so='.urlencode($arrParams['sortOrder']).
										 	 '&sf='.urlencode($arrParams['sortFields']).
											 ((isset($_REQUEST['fs']))? '&fs='.urlencode($arrParams['filterSearch']) : '').
											 ((isset($_REQUEST['fa']))? '&fa='.urlencode($arrParams['filterActive']) : '');										
			return $arrParams;								 	
		}
	}
?>
