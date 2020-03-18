<?php
	class Setup{
		private $db;

	    // your construct method here will ONLY except a `DB` class instance/object as $db. 
	    // Try it with anything else and learn from the errors to understand what I mean.
	    function __construct(DB $db){
	        $this->db = $db;
	    }

	    function registerAdmin(){

	    	$this->db->closeAll();
	    }

	    function getMetaTags(){
			$this->db->DBLogin();
			$qry = 'SELECT * FROM settings';
			$data = $this->db->selectQuery($qry);
			if(!$data){
				$this->db->HandleDBError($qry);
				$returnValue['errorMessage']=$this->db->error_message;
			}
			$returnValue['return'] = true;

			$array_data = [];
			while($row = $this->db->fetchArray($data)){
				array_push($array_data,['key'=>$row['name'],'value'=>$row['value']]);
			}
			$returnValue = $array_data;

			$this->db->closeAll();
			return $returnValue;

	    }

		function setConfigData($data){
			$returnValue['return'] = false;
			foreach( $data as $key=>$value ) {
				$qry = 'UPDATE settings SET value="'.$value.'" WHERE name="'.$key.'"';
				if($this->db->updateQuery($qry)){
					$returnValue['return'] = true;
				}else{
					$this->db->HandleDBError($qry);
					$returnValue['errorMessage']=$this->db->error_message;
					break;
				}
			}
			$this->db->closeAll();
			return $returnValue;
		}

		function getConfigData(){
			$returnValue['return'] = false;
			$this->db->DBLogin();
			$qry = 'SELECT * FROM settings';
			$data = $this->db->selectQuery($qry);
			if(!$data){
				$this->db->HandleDBError($qry);
				$returnValue['errorMessage']=$this->db->error_message;
			}
			$returnValue['return'] = true;

			$array_data = [];
			while($row = $this->db->fetchArray($data)){
				array_push($array_data,['key'=>$row['name'],'value'=>$row['value']]);
			}
			$returnValue['data'] = $array_data;

			$this->db->closeAll();
			return $returnValue;
		}
	}

?>