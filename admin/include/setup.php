<?php
	// require_once dirname(__FILE__) . '/include/db.php';
	require_once 'db.php';
	class Setup{
		private $db;

	    // your construct method here will ONLY except a `DB` class instance/object as $db. 
	    // Try it with anything else and learn from the errors to understand what I mean.
	    function __construct(){
	        $this->db = new DB();
	    }

	    function checkDBLogin(){
	    	if(!$this->db->DBLogin()){
	    		$returnValue['return'] = false;
	    		$returnValue['message'] = $this->db->error_message;
	    	}else{
	    		$returnValue['return'] = true;
	    		$returnValue['message'] = $this->db->error_message;
	    	}
	    	return $returnValue;
	    }

	    function registerAdmin($email,$password){
	    	$returnValue['return'] = true;
	    	if(!$this->db->createTables()){
	    		$returnValue = false;
	    	}else{
		    	$formvars = array();
				$formvars['email'] = $this->Sanitize($email);
				$formvars['password'] = password_hash($this->Sanitize($password), PASSWORD_DEFAULT);
				$formvars['type'] = $this->Sanitize('admin');		
				$qry = "INSERT into _user (email,type,_password,date_created) values ('"
						.$formvars['email'] . "','"
						.$formvars['type'] . "','"
						.$formvars['password']."',NOW())";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
		    }
		    $this->db->closeAll();
		    return $returnValue;
		}

		function getErrorMessage(){
			return $this->db->error_message;
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

		

	    function Sanitize($str,$remove_nl=true){
	        $str = $this->StripSlashes($str);
	        if($remove_nl){
	            $injections = array('/(\n+)/i','/(\r+)/i', '/(\t+)/i','/(%0A+)/i','/(%0D+)/i','/(%08+)/i','/(%09+)/i');
	            $str = preg_replace($injections,'',$str);
	        }
	        return $str; 
	    }
	    function SanitizeForSQL($str){
	        if( function_exists( "mysql_real_escape_string" ) ){$ret_str = mysql_real_escape_string( $str );}
	        else{$ret_str = addslashes( $str );}
	        return $ret_str;
	    } 
	    
	    function StripSlashes($str){
	        if(get_magic_quotes_gpc()){ $str = stripslashes($str);}
	        return $str;
	    }

	    function GetAbsoluteURLFolder(){
	        return $_SERVER['SERVER_NAME'];
	    }

	    function RedirectToURL($url){
	        header("Location: $url");
	        exit;
	    }

	    

	}

?>