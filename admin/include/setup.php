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

	    function getErrorMessage(){return $this->db->error_message;}

	    /*
			LOGIN
	    */
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
	    /*
			REGISTER
	    */
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
			if(!$this->db->insertQuery($qry)){
				$returnValue = false;
			}
		    $this->db->closeAll();
		    return $returnValue;
	    }
	    /*
			CONFIG FUNCTIONS
	    */
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
				//conekta
				$qry = "INSERT into settings (name,value,type) values 
											('conekta_status','dev','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}

				$qry = "INSERT into settings (name,value,type) values 
											('conekta_key_public_dev','','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('conekta_key_private_dev','','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}

				$qry = "INSERT into settings (name,value,type) values 
											('conekta_key_public_prod','','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('conekta_key_private_prod','','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('conekta_limit','5000','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('conekta_limit_oxxo','10000','payment_conekta')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}


				//paypal
				$qry = "INSERT into settings (name,value,type) values 
											('paypal_status','dev','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('paypal_key_public_dev','','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('paypal_key_private_dev','','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}

				$qry = "INSERT into settings (name,value,type) values 
											('paypal_key_public_prod','','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('paypal_key_private_prod','','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}


				//mailchimp
				$qry = "INSERT into settings (name,value,type) values 
											('mailchimp_id_list','','email_mailchimp')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				
				//email
				$qry = "INSERT into settings (name,value,type) values 
											('from_email','".$formvars['email'] . "','email_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('contacto_email','".$formvars['email'] . "','email_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}



				//envios
				$qry = "INSERT into settings (name,value,type) values 
											('limit_free_delivery','1000','delivery_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('delivery_cost','250','delivery_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}



				//social media
				$qry = "INSERT into settings (name,value,type) values 
											('instagram','','socialmedia_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}$qry = "INSERT into settings (name,value,type) values 
											('facebook','','socialmedia_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}$qry = "INSERT into settings (name,value,type) values 
											('twitter','','socialmedia_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}$qry = "INSERT into settings (name,value,type) values 
											('whatsapp','','socialmedia_website')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				
		    }
		    $this->db->closeAll();
		    return $returnValue;
		}

		
		
		/*
			Orders
		*/
		function getOrders(){
			$this->checkDBLogin();
			$qry = 'SELECT * FROM _order ORDER BY id_order';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No orders');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$returnValue = $result;
				}
			}
			return $returnValue; 
		}
		function getClientNameById($id_client){
			$this->checkDBLogin();
			$qry = 'SELECT name FROM client WHERE id_client = '.$id_client;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['name'];
				}
			}
			return $returnValue;
		}
		function getTypeTransation($id_order){
			$this->checkDBLogin();
			$qry = 'SELECT type FROM transaction WHERE order_id_order = '.$id_order;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['type'];
				}
			}
			return $returnValue;
		}


		/*
			Products
		*/
		function getProducts(){
			$this->checkDBLogin();
			$qry = 'SELECT * FROM products ORDER BY id_products';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No productos');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No productos');
					$returnValue = false;
				}else{
					$returnValue = $result;
				}
			}
			return $returnValue;
		}

		/*
			SETTINGS
		*/
	    function getMetaTags(){
			$this->db->DBLogin();
			$qry = 'SELECT * FROM settings ';
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
			$this->db->DBLogin();
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
			$qry = 'SELECT * FROM settings ORDER by id_settings DESC';
			$data = $this->db->selectQuery($qry);
			if(!$data){
				$this->db->HandleDBError($qry);
				$returnValue['errorMessage']=$this->db->error_message;
			}
			$returnValue['return'] = true;

			$array_data = [];
			while($row = $this->db->fetchArray($data)){
				array_push($array_data,['key'=>$row['name'],'value'=>$row['value'],'type'=>$row['type']]);
			}
			$returnValue['data'] = $array_data;

			$this->db->closeAll();
			return $returnValue;
		}

		/*
		UTIL FUNCTIONS
		*/
		function CheckLogin(){
			$returnValue = true;
	        if(!isset($_SESSION)){ session_start(); }
	        $sessionvar = $this->GetLoginSessionVar();
	        if(empty($_SESSION[$sessionvar])){
	            $this->db->HandleError("Session expiro!");
	            return false;
	        }
	        if($_SESSION['timeout'] < time()){
	            $this->db->HandleError("Session time expiro!" . $_SESSION['timeout'] . time());
	            $returnValue = false;
	        }
	        return $returnValue;
	    }
		function GetLoginSessionVar(){
	        $retvar = md5($this->rand_key);
	        $retvar = 'user_'.substr($retvar,0,10);
	        return $retvar;
	    }
	    function GetAbsoluteURLFolder(){return $_SERVER['SERVER_NAME'];}	
	    function RedirectToURL($url){header("Location: $url");exit;}

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