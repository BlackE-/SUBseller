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
				
				//website_settings
				$qry = "INSERT into settings (name,value,type) values 
											('website_url','','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('from_email','".$formvars['email'] . "','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('contacto_email','".$formvars['email'] . "','website_settings')";
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
			$returnValue = true;
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
			$returnValue = true;
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
			$returnValue = true;
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
			$returnValue = true;
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
			STORE
		*/

			/*
				brand
			*/
		function getBrands(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM brand ORDER BY id_brand';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No marcas');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No marcas');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						$img = $this->getMedia($row['id_brand'],'brand');
						if(!$img){
							array_push($array_data, array('brand'=>$row,'media'=>false));
						}else{
							array_push($array_data, array('brand'=>$row,'media'=>$img));
						}
					}
					$returnValue = $array_data;

				}
			}
			return $returnValue;
		}

		function insertBrand(){
			$returnValue = true;
			$data = $_POST;
			$this->checkDBLogin();
			$qry = 'INSERT INTO brand(name,status) VALUES ("'.$data['name'].'",1) ';
			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo guardar la marca');
				$returnValue = false;
			}

			$id_brand = $this->db->lastInsertID();
			

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];

   //         			//nuevo nombre de la imagen que se sube
           				$extension = explode(".",$archivo['name']);
	           			$name = $this->removeWhitespaces($this->Sanitize($data['name']));
	           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
           			//path a la carpeta de brands
					$pathInsert = '../../img/brand/';
					$pathInsert .= $name;

					$pathSave = '/img/brand/';
					$pathSave .= $name;
					$img = $this->insertMedia('brand',$id_brand,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
           		}
           		
           	}
			return $returnValue;

			return $returnValue;
		}

		function updateBrand($id_brand,$brand_name,$brand_status){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE brand SET name="'.$brand_name.'", status="'.$brand_status.'" WHERE id_brand = '.$id_brand;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo actualizar la marca');
				$returnValue = false;
			}
			return $returnValue;
		}


		function updateBrandPhoto(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			
			$id_media = $data['id_media'];

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];

           				$extension = explode(".",$archivo['name']);
	           			$name = $this->removeWhitespaces($this->Sanitize($data['name']));
	           			$name .= date("m-d-Y_hia") . '.' . $extension[1];

           			//path a la carpeta de category
					$pathInsert = '../../img/brand/';
					$pathInsert .= $name;

					$pathSave = '/img/brand/';
					$pathSave .= $name;
			// 		//llamada a la funcion insertMedia
					$img = $this->updateMedia('brand',$id_media,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						
						$returnValue = false;
					}
           		}
           		
           	}
			return $returnValue;
		}

			/*
				category
			*/
		function getCategories(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM category ORDER BY id_category';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No categorias aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No categorias aun');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						$img = $this->getMedia($row['id_category'],'category');
						if(!$img){
							array_push($array_data, array('category'=>$row,'media'=>false));
						}else{
							array_push($array_data, array('category'=>$row,'media'=>$img));
						}
					}
					$returnValue = $array_data;

				}
			}
			return $returnValue;
		}

		function insertCategory(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'INSERT INTO category(name,status) VALUES ("'.$data['name'].'",1) ';
			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo guardar la marca');
				$returnValue = false;
			}
			$id_category = $this->db->lastInsertID();
			

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];
//         			//nuevo nombre de la imagen que se sube
       				$extension = explode(".",$archivo['name']);
           			$name = $this->removeWhitespaces($this->Sanitize($data['name']));
           			// $name .= date('Y-m-d', time()). '.' . $extension[1];
           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
           			//path a la carpeta de category
					$pathInsert = '../../img/category/';
					$pathInsert .= $name;

					$pathSave = '/img/category/';
					$pathSave .= $name;
			// 		//llamada a la funcion insertMedia
					$img = $this->insertMedia('category',$id_category,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						// $this->db->HandleError($path);
						$returnValue = false;
					}
           		}
           		
           	}
			return $returnValue;
		}

		function updateCategory($id_category,$category_name,$category_status){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE category SET name="'.$category_name.'", status="'.$category_status.'" WHERE id_category = '.$id_category;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo actualizar la categoria');
				$returnValue = false;
			}
			return $returnValue;
		}

		function updateCategoryPhoto(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			
			$id_media = $data['id_media'];

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];

           				$extension = explode(".",$archivo['name']);
	           			$name = $this->removeWhitespaces($this->Sanitize($data['name']));
	           			$name .= date("m-d-Y_hia") . '.' . $extension[1];

           			//path a la carpeta de category
					$pathInsert = '../../img/category/';
					$pathInsert .= $name;

					$pathSave = '/img/category/';
					$pathSave .= $name;
			// 		//llamada a la funcion insertMedia
					$img = $this->updateMedia('category',$id_media,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						// $this->db->HandleError($path);
						$returnValue = false;
					}
           		}
           		
           	}
			return $returnValue;
		}

		/*
			TYPES
		*/
		function getTypes(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM product_type ORDER BY id_product_type';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No tipos aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No tipos aun');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						$img = $this->getMedia($row['id_product_type'],'type');
						$img_mobile = $this->getMedia($row['id_product_type'],'type_mobile');
						if(!$img && !$img2){
							array_push($array_data, array('type'=>$row,'media'=>false));
						}else{
							$imgs = array($img,$img_mobile);
							array_push($array_data, array('type'=>$row,'media'=>$imgs));
						}
					}
					$returnValue = $array_data;

				}
			}
			return $returnValue;
		}
		function insertType(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'INSERT INTO product_type(name,id_parent,status) VALUES ("'.$data['name'].'",0,1) ';
			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo guardar la marca');
				$returnValue = false;
			}
			$id_type = $this->db->lastInsertID();
			

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];
           			$extension = explode(".",$archivo['name']);
	           		$name = $this->removeWhitespaces($this->Sanitize($data['name']));
	           		$name .= date("m-d-Y_hia") . '.' . $extension[1];
					$pathInsert = '../../img/type/';
					$pathInsert .= $name;
					$pathSave = '/img/type/';
					$pathSave .= $name;
					$img = $this->insertMedia('type',$id_type,$tmp_name,$pathInsert,$pathSave);
					if(!$img){						
						$returnValue = false;
					}
           		}
           	}

           	if(!empty($_FILES['fileMobile']['name'])){
           		$archivo = $_FILES['fileMobile'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];
           			$extension = explode(".",$archivo['name']);
	           		$name = $this->removeWhitespaces($this->Sanitize($data['name'] . 'mobile'));
	           		$name .= date("m-d-Y_hia") . '.' . $extension[1];
					$pathInsert = '../../img/type/';
					$pathInsert .= $name;
					$pathSave = '/img/type/';
					$pathSave .= $name;
					$img = $this->insertMedia('type_mobile',$id_type,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
           		}	
           	}
			return $returnValue;
		}
		function updateType($id_type,$type_name,$type_status){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE product_type SET name="'.$type_name.'", status="'.$type_status.'" WHERE id_product_type = '.$id_type;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo actualizar la categoria');
				$returnValue = false;
			}
			return $returnValue;
		}
		function updateTypePhoto(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			
			$id_media = $data['id_media'];
			$type = $data['type'];

			if(!empty($_FILES['file']['name'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];
       				$extension = explode(".",$archivo['name']);
       				if($type == 'type_mobile'){
       					$name = $this->removeWhitespaces($this->Sanitize($data['name'] . 'mobile'));
       				}else{
       					$name = $this->removeWhitespaces($this->Sanitize($data['name']));
       				}
           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
					$pathInsert = '../../img/type/';
					$pathInsert .= $name;

					$pathSave = '/img/type/';
					$pathSave .= $name;
					$img = $this->updateMedia($type,$id_media,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
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

			MEDIA

		*/
		function getMedia($id_type,$type){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM media WHERE type="'.$type.'" and id_type='.$id_type;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No categorias aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No categorias aun');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						array_push($array_data, array('id_media'=>$row['id_media'],'url'=>$row['url']));
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}

		function insertMedia($type,$id_type,$tmp_name,$pathInsert,$pathSave){
			$returnValue = true;
			$this->checkDBLogin();
			if(!move_uploaded_file($tmp_name, $pathInsert)){
 	            $this->db->HandleError("NO SE PUDO GUARDAR archivo ".$path);
 	            $returnValue = false;
 	        }else{
 	        	$qry = 'INSERT INTO media (url,type,id_type) VALUES("'.$pathSave.'","'.$type.'",'.$id_type.')';
 	        	$result = $this->db->insertQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo guardar en tabla: MEDIA');
					$returnValue = false;
				}
 	        }
 	        return $returnValue;
		}

		function updateMedia($type,$id_media,$tmp_name,$pathInsert,$pathSave){
			/*
				change URL from MEDIA using id_media and new URL
			*/
			$returnValue = true;
			$this->checkDBLogin();
			if(!move_uploaded_file($tmp_name, $pathInsert)){
 	            $this->db->HandleError("NO SE PUDO GUARDAR archivo ");
 	            $returnValue = false;
 	        }else{
 	        	$qry = 'UPDATE media SET url="'.$pathSave.'" WHERE id_media='.$id_media;
 	        	$result = $this->db->updateQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo actualizar en tabla: MEDIA');
					$returnValue = false;
				}
 	        }
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
		function removeWhitespaces($str){
			$str = str_replace(' ', '', $str);
			return $str;
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
	}
?>