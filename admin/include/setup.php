<?php
	// require_once dirname(__FILE__) . '/include/db.php';
	require_once 'db.php';
	class Setup{
		private $db;
		private $rand_key = '3MsATrB8kN0mj17xhMEMQMRc1khY349a';

	    // your construct method here will ONLY except a `DB` class instance/object as $db. 
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

	    function loginAdmin($email,$password){
	    	$returnValue = true;
	    	$formvars = array();
			$formvars['email'] = $this->Sanitize($email);	
			$qry = "SELECT id_user,_password FROM _user WHERE email='".$formvars['email']."'";
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleDBError("1.No tenemos registro de: ".$email);
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError("2.No tenemos registro de: ".$email);
		            $returnValue = false;
		        }else{
		        	$row = $this->db->fetchArray($result);
		        	$hash = $row['_password'];
		        	$auth = password_verify($password,$hash);
		        	if(!$auth){
		        		$this->db->HandleError("Contraseña incorrecta");
		            	$returnValue = false;
		        	}else{
		        		if(!isset($_SESSION)){ session_start(); }
				        $_SESSION[$this->GetLoginSessionVar()] = $row['id_user'];
				        $_SESSION['timeout'] = time() + (1 * 24 * 60 * 60);
				        						// 1 day; 24 hours; 60 mins; 60 secs
		        	}
		        } 
			}
		    $this->db->closeAll();
		    return $returnValue;
	    }

	    function register_user($email,$password){
	    	$returnValue = true;
	    	$formvars = array();
			$formvars['email'] = $this->Sanitize($email);
			$formvars['password'] = password_hash($password, PASSWORD_DEFAULT);
			$formvars['type'] = $this->Sanitize('admin');		
			$qry = "INSERT into _user (email,type,_password,date_created) values ('"
					.$formvars['email'] . "','"
					.$formvars['type'] . "','"
					.$formvars['password']."',NOW())";
			$this->db->HandleError($qry);
			if(!$this->db->insertQuery($qry)){
				$returnValue = false;
			}
		    $this->db->closeAll();
		    return $returnValue;
	    }

	    function createTablesAndRegisterAdmin($email,$password){
	    	$returnValue = true;
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

				$qry = "INSERT into settings (name,value) values 
											('mailchimp_id_list','')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('admin_email','".$formvars['email'] . "')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('from_email','".$formvars['email'] . "')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('contacto_email','".$formvars['email'] . "')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('limit_free_delivery','1000')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('delivery_cost','250')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('limit_conekta','5000')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value) values 
											('limit_oxxo_conekta','10000')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
		    }
		    $this->db->closeAll();
		    return $returnValue;
		}
		function insertSettings(){

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

		/*
		UTIL FUNCTIONS
		*/

		function GetLoginSessionVar(){
	        $retvar = md5($this->rand_key);
	        $retvar = 'user_'.substr($retvar,0,10);
	        return $retvar;
	    }
	    function GetAbsoluteURLFolder(){
	        return $_SERVER['SERVER_NAME'];
	    }	
	    function RedirectToURL($url){
	        header("Location: $url");
	        exit;
	    }

		/*	

			FUNCTIONS TO WORK WITH MYSQL


		*/
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

	    

	    

	}

?>