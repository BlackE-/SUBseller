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
	    	$this->checkDBLogin();
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
				$qry = "INSERT into settings (name,value,type) values 
											('paypal_merchand_id','','payment_paypal')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}


				
				
				//website_settings
				$qry = "INSERT into settings (name,value,type) values 
											('website_url','http://studio-sub.com','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('website_title','SUBselller','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('website_logo','img/logo.png','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('description','Sitio Ecommerce para vender tu marca','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('keywords','Ecommerce,SUBseller,tienda online','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('favicon_url','img/favicon/favicon.png','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('tracking_code','','website_settings')";
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
				$qry = "INSERT into settings (name,value,type) values 
											('limit_free_delivery','500','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('delivery_cost','250','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('mailchimp_id_list','','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('mailchimp_key','','website_settings')";
				if(!$this->db->insertQuery($qry)){
					$returnValue = false;
				}
				$qry = "INSERT into settings (name,value,type) values 
											('facebook_app_id','','website_settings')";
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
			clients
		*/
		function getTotalClients(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT COUNT(id_client) as SUMA FROM client';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No clients');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['SUMA'];
				}
			}
			return $returnValue;
		}

		function getClients(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM client ORDER BY id_client';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No clients');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$algo = array();
					while($row = $this->db->fetchArray($result)){
						array_push($algo, $row);
					}
					$returnValue = $algo;
				}
			}
			return $returnValue; 
		}
		
		/*
			Orders
		*/
		function getTotalSales(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT sum(total) as SUMA FROM _order';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No orders');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['SUMA'];
				}
			}
			return $returnValue; 
		}
		function getSalesByDay($dayDate){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT sum(total) as SUMA FROM _order WHERE date_created between "'.$dayDate.' 00:00:00" and "'.$dayDate.' 23:59:59"';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No orders');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['SUMA'];
					if(gettype($row['SUMA']) == 'NULL'){
						$returnValue = '0.0';
					}else{
						$returnValue = $row['SUMA'];
					}
				}
			}
			return $returnValue; 
		}
		function getOrders(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM _order ORDER BY id_order DESC';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No orders');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No orders');
					$returnValue = false;
				}else{
					$algo = array();
					while($row = $this->db->fetchArray($result)){
						array_push($algo, $row);
					}
					$returnValue = $algo;
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
			$qry = 'SELECT type FROM _transaction WHERE order_id_order = '.$id_order;
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
		function getOrder($id_order){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM _order WHERE id_order = '.$id_order;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row;
				}
			}
			return $returnValue;
		}

		function getTransation($id_order){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM _transaction WHERE order_id_order = '.$id_order;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row;
				}
			}
			return $returnValue;
		}
		function getShipping($id_shipping){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM shipping WHERE id_shipping = '.$id_shipping;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row;
				}
			}
			return $returnValue;
		}

		function getBilling($id_billing){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM billing WHERE id_billing = '.$id_billing;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row;
				}
			}
			return $returnValue;
		}

		function getItemsFromSessionClient($id_session_client){
	    	$returnValue = array();
	       	$login = $this->checkLogin();
	       	$qry = 'SELECT * FROM session_cart WHERE session_client_id_session_client='.$id_session_client;
	       	$result = $this->db->selectQuery($qry);
	       	if(!$result || !$this->db->numRows($result)){
	       		$this->db->HandleError('no se tienen elementos en el carrito');
	       	}
	       	else{
	       		$array_items = array();
	       		while($row = $this->db->fetchArray($result)){
	       			array_push($array_items, array('id_session_cart'=>$row['id_session_cart'],'id_product'=>$row['product_id_product'],'number_items'=>$row['number_items'],'price'=>$row['price']));
	       		}
	       		$returnValue = $array_items;
	       	}
	       	return $returnValue;
	    }


		/*
			Products
		*/
		function getProducts(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM product ORDER BY id_product';
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

		function getProduct($id_product){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM product WHERE id_product='.$id_product;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No producto');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No producto');
					$returnValue = false;
				}else{
					$returnValue = $this->db->fetchArray($result);
				}
			}
			return $returnValue;

		}

		function getInventario($id_product){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT stock FROM product_inventory WHERE product_id_product='.$id_product;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No productos');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No productos');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['stock'];
				}
			}
			return $returnValue;
		}

		function setProductStatus($id_product,$status){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE product SET status='.$status.' WHERE id_product ='.$id_product;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No update');
				$returnValue = false;
			}
			return $returnValue;
		}

		function setProductFav($id_product,$fav){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE product SET fav='.$fav.' WHERE id_product ='.$id_product;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleDBError('No update');
				$returnValue = false;
			}
			return $returnValue;
		}

		function importProducts(){
			$returnValue = true;
			$this->checkDBLogin();
			$error = false;
	        $archivo = $_FILES['file'];
	        if ($archivo["error"] == UPLOAD_ERR_OK) {
	            $folderName = "../files/";
	            
	            $coso = explode(".",$archivo['name']);
	            $name = $coso[0].date("m-d-Y_hia").".".$coso[1];
	            $tmp_name = $archivo["tmp_name"];
	            $ruta = $folderName . $name;
	            
	            if(!move_uploaded_file($tmp_name, $ruta)){
	                $this->HandleError("NO SE PUDO GUARDAR archivo ".$ruta);
	                $error = true;
	                $returnValue = false;
	            }
	        }
	        if($error == false){
	            $HANDLE = fopen($ruta,'r') or die ('CANT OPEN FILE');;
	            $DATA = fread($HANDLE,filesize($ruta));
	            fclose($HANDLE);
	            $renglones = explode(PHP_EOL,$DATA);
	            foreach($renglones as $key=>$value){
	            	if($key != 0){
		                $error1 = false;
		                $data = explode(",",$value);
		                if(sizeof($data)>1){
							$name = $data[0];
			                $description = $data[1];
			                $description_short = $data[2];
			                $tiempo_de_uso = $data[3];
			                $unidad = $data[4];
			                $price_base = $data[5];
			                $price_sale = $data[6];
			                $sku = $data[7];
			                $stock = $data[8];
			                
				            $qry = 'INSERT INTO product (name,description,description_short,tiempo_de_uso,price_base,price_sale,discount,sku,out_of_stock,brand_id_brand,type_id_type,unit,status,fav,product_related) 
							VALUES(
							"'.$this->Sanitize($name).'",
							"'.$this->Sanitize($description).'",
							"'.$this->Sanitize($description_short).'",
							"'.$this->Sanitize($tiempo_de_uso).'",
							'.(double)$price_base.',
							'.(double)$price_sale.',
							0,
							"'.$this->removeWhitespaces($sku).'",
							0,
							1,
							1,
							"'.$unidad.'",
							"1",
							"0",
							"0")';

							$result = $this->db->insertQuery($qry);
							if(!$result){
								$this->db->HandleDBError('No INSERT');
								$returnValue = false;
								break;
							}else{
								$id_product = $this->db->lastInsertID();
								$qry = 'INSERT INTO product_inventory (product_id_product,stock) VALUES ('.$id_product.','.$stock.')';
								$result = $this->db->insertQuery($qry);
								if(!$result){
									$this->db->HandleDBError('No insert');
									$returnValue = false;
								}

								$qry = 'INSERT INTO product_movement (product_id_product,stock,date_created,type) VALUES ('.$id_product.','.$stock.',NOW(),"INGRESO")';
								$result = $this->db->insertQuery($qry);
								if(!$result){
									$this->db->HandleDBError('No insert');
									$returnValue = false;
								}
							}
						}
					}
				}
	        }
	        return $returnValue;
		}



		/*	NEW PRODUCT 	*/
		function insertProduct(){
			$data = $_POST;
			$returnValue = true;

			$this->checkDBLogin();
			$qry = 'INSERT INTO product (name,description,description_short,tiempo_de_uso,price_base,price_sale,discount,sku,out_of_stock,brand_id_brand,type_id_type,unit,status,fav,product_related) 
				VALUES(
				"'.$this->Sanitize($data['name']).'",
				"'.$this->Sanitize($data['description']).'",
				"'.$this->Sanitize($data['description_short']).'",
				"'.$this->Sanitize($data['tiempo_de_uso']).'",
				'.(double)$data['price_base'].',
				'.(double)$data['price_sale'].',
				'.(double)$data['discount'].',
				"'.$this->removeWhitespaces($data['sku']).'",
				0,
				"'.$data['brand'].'",
				"'.$data['type'].'",
				"'.$data['unit'].'",
				"'.$data['status'].'",
				"'.$data['fav'].'",
				"'.$data['productsRelated'].'")';

			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleDBError('No se pudo guardar el producto');
				$returnValue = false;
				return $returnValue;
			}

			$id_product = $this->db->lastInsertID();

			//producto inventario
	        $qry = 'INSERT INTO product_inventory (product_id_product,stock) VALUES ("'.$id_product.'",'.$data['stock'].')';
	        $result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo guardar el inventario');
				$returnValue = false;
			}

			$qry = 'INSERT INTO product_movement (product_id_product,stock,date_created,type) VALUES ('.$id_product.','.$data['stock'].',NOW(),"INGRESO")';
			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No insert');
				$returnValue = false;
			}	
	    	
	    	//relacion producto categoria
	    	$categoryList = explode(',', $data['category']);
	    	foreach ($categoryList as $key => $value) {
	    		$qry = "INSERT INTO product_category (category_id_category,  product_id_product ) VALUES (".$value.",".$id_product.")";
		        $result = $this->db->insertQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo guardar la categoria');
					$returnValue = false;
				} 
	    	}
	    	
	    	//tags
	    	if(isset($data['tags']) && !empty($data['tags'])){
	    	    $allCheck = true;
	        	$tag = explode(",", $data['tags']);
	        	foreach($tag as $key3 => $value3){
	        	    $ins = "INSERT INTO product_tag (product_id_product,tag_id_tag) VALUES (".$id_product.",".$value3.")";
	            	$result = $this->db->insertQuery($qry);
					if(!$result){
						$this->db->HandleError('No se pudo guardar la tags');
						$returnValue = false;
					} 
	        	}
	    	    
	    	}
	    	if(isset($_FILES['file']) && !empty($_FILES['file'])){
           		$archivo = $_FILES['file'];
           		if ($archivo["error"] == UPLOAD_ERR_OK) {
           			$tmp_name = $archivo["tmp_name"];

           			//nuevo nombre de la imagen que se sube
           				$extension = explode(".",$archivo['name']);
	           			$name = $this->removeWhitespaces($this->Sanitize($data['sku']));
	           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
           			//path a la carpeta de brands
					$pathInsert = '../../img/product/';
					$pathInsert .= $name;

					$pathSave = '/img/product/';
					$pathSave .= $name;
					$img = $this->insertMedia('product',$id_product,$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
           		}
           		
           	}

           	if (isset($_FILES['file_secondary']) && !empty($_FILES['file_secondary'])) {
	            $numFiles = count($_FILES["file_secondary"]['name']);
	            for ($i = 0; $i < $numfiles; $i++) {
	                if ($_FILES["file_secondary"]["error"][$i] == UPLOAD_ERR_OK) {
	                    $tmp_name = $archivo["tmp_name"];

	           			//nuevo nombre de la imagen que se sube
	           				$extension = explode(".",$archivo['name']);
		           			$name = $this->removeWhitespaces($this->Sanitize($data['sku'].'-'.$i));
		           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
	           			//path a la carpeta de brands
						$pathInsert = '../../img/product/';
						$pathInsert .= $name;

						$pathSave = '/img/product/';
						$pathSave .= $name;
						$img = $this->insertMedia('product_secondary',$id_product,$tmp_name,$pathInsert,$pathSave);
						if(!$img){
							$returnValue = false;
						}
	                }
	            }
	        }
			return $returnValue;
		}

		/*
			PRODUCT
		*/
		function getProductCategories($id_product){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM  product_category WHERE product_id_product ='.$id_product;
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
						array_push($array_data, $row['category_id_category']);
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}

		function getProductTags($id_product){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM  product_tag WHERE product_id_product ='.$id_product;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No tags');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No tags');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						array_push($array_data,$row['tag_id_tag']);
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}

		function setImage(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
       		$archivo = $_FILES['file'];
       		if ($archivo["error"] == UPLOAD_ERR_OK) {
       			$tmp_name = $archivo["tmp_name"];

       			//nuevo nombre de la imagen que se sube
       				$extension = explode(".",$archivo['name']);
           			$name = $this->removeWhitespaces($this->Sanitize($data['sku']));
           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
       			//path a la carpeta de brands
				$pathInsert = '../../img/product/';
				$pathInsert .= $name;

				$pathSave = '/img/product/';
				$pathSave .= $name;


				if($data['id_media'] == 0){
					$img = $this->insertMedia($data['type'],$data['id_product'],$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
				}else{
					// function updateMedia($type,$id_media,$tmp_name,$pathInsert,$pathSave){
					$img = $this->updateMedia($data['type'],$data['id_media'],$tmp_name,$pathInsert,$pathSave);
					if(!$img){
						$returnValue = false;
					}
				}
       		}
			return $returnValue;
		}

		function updateProduct(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE  product SET name = "'.$this->Sanitize($data['name']).'",
										description="'.$this->Sanitize($data['description']).'",
										description_short="'.$this->Sanitize($data['description_short']).'",
										tiempo_de_uso="'.$this->Sanitize($data['tiempo_de_uso']).'",
										price_base='.(double)$data['price_base'].',
										price_sale='.(double)$data['price_sale'].',
										discount='.(double)$data['discount'].', 
										brand_id_brand="'.$data['brand'].'",
										type_id_type="'.$data['type'].'",
										unit="'.$data['unit'].'",
										status="'.$data['status'].'",
										fav="'.$data['fav'].'"
					WHERE id_product = '.$data['id_product'];
			// $returnValue = false;
			// $this->db->HandleError($qry);
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleDBError('No se pudo actualizar el producto');
				$returnValue = false;
				return $returnValue;
			}
			return $returnValue;
		}

		function updateProductRelated(){
			$data = $_POST;
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE  product SET product_related="'.$data['product_related'].'"
					WHERE id_product = '.$data['id_product'];
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleDBError('No se pudo actualizar el producto');
				$returnValue = false;
				return $returnValue;
			}
			return $returnValue;
		}

		function updateCategoryProduct($id_product,$id_category,$type){
			$returnValue = true;
			$this->checkDBLogin();
			switch ($type) {
				case 'add':
					$qry = 'INSERT INTO product_category (product_id_product,category_id_category) VALUES ('.$id_product.','.$id_category.')';
					$result = $this->db->insertQuery($qry);
					if(!$result){
						$this->db->HandleError('No se guardo category');
						$returnValue = false;
					}
					break;
				case 'delete':
					$qry = 'DELETE FROM product_category WHERE category_id_category='.$id_category . ' AND product_id_product='.$id_product;
					$result = $this->db->deleteQuery($qry);
					if(!$result){
						$this->db->HandleError('No se elimino category');
						$returnValue = false;
					}
					break;
			}
			return $returnValue;
		}

		function updateTagProduct($id_product,$id_tag,$type){
			$returnValue = true;
			$this->checkDBLogin();
			switch ($type) {
				case 'add':
					$qry = 'INSERT INTO product_tag (product_id_product,tag_id_tag) VALUES ('.$id_product.','.$id_tag.')';
					$result = $this->db->insertQuery($qry);
					if(!$result){
						$this->db->HandleDBError('No se guardo tag'.$qry);
						$returnValue = false;
					}
					break;
				case 'delete':
					$qry = 'DELETE FROM product_tag WHERE tag_id_tag='.$id_tag . ' AND product_id_product='.$id_product;
					$result = $this->db->deleteQuery($qry);
					if(!$result){
						$this->db->HandleDBError('No se elimino tag'.$qry);
						$returnValue = false;
					}
					break;
			}
			return $returnValue;
		}

		/*

			INVENTORY

		*/
		function updateInventory($id_product,$stock){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'UPDATE product_inventory SET stock=stock+'.$stock.' WHERE product_id_product='.$id_product;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No update');
				$returnValue = false;
			}else{
				$qry = 'INSERT INTO product_movement (product_id_product,stock,date_created,type) VALUES ('.$id_product.','.$stock.',NOW(),"INGRESO")';
				$result = $this->db->insertQuery($qry);
				if(!$result){
					$this->db->HandleError('No insert');
					$returnValue = false;
				}
			}
			return $returnValue;
		}

		/*
	
			COUPONS
	
		*/
		function checkCoupons(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM coupon ORDER BY id_coupon ASC';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No coupons');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No coupons');
					$returnValue = false;
				}else{
					$today = date("Y-m-d 00:00:00");
					while($row = $this->db->fetchArray($result)){
						if($row['date_expires'] < $today){
							if($row['status'] == '1'){
								$qry2 = 'UPDATE coupon SET status="0" WHERE id_coupon='.$row['id_coupon'];
								$this->db->updateQuery($qry2);
							}
						}
					}
				}
			}
			return $returnValue;
		}
		function getCoupons(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM coupon ORDER BY id_coupon DESC';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No coupons');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No coupons');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						array_push($array_data,$row);
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}

		function getCoupon($id_coupon){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM coupon WHERE id_coupon='.$id_coupon;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No coupons');
				$returnValue = false;
			}else{
				$returnValue = $this->db->fetchArray($result);
			}
			return $returnValue;
		}

		function insertCoupon(){
			$returnValue = true;
			$this->checkDBLogin();
			$data = $_POST;
			$qry = 'INSERT INTO coupon (date_created,code,description,discount_type,amount,status,date_expires,product_ids) VALUES (NOW(),"'.$data['code'].'","'.$data['description'].'","'.$data['type'].'",'.(double)$data['amount'].',1,"'.$data['date_expires'].'","'.$data['product_ids'].'")';
			$result = $this->db->insertQuery($qry);
			$returnValue = $qry;
			if(!$result){
				$this->db->HandleError('No insert coupon');
				$returnValue = false;
			}
			return $returnValue;	
		}


		function codeIsValid($code){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = "SELECT id_coupon FROM coupon WHERE code = '".$code."'";
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$returnValue = true;
			}else{
				if($this->db->numRows($result)){
					$returnValue = false;
				}
			}
			return $returnValue;
		}

	    function generateCode(){
	    	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	        $charactersLength = strlen($characters);
	        do
	        {
	            $code = '';
	            $codeLength = 8;
	            for ($i = 0; $i < $codeLength; $i++)
	            {
	                $code .= $characters[rand(0, $charactersLength - 1)];
	            }
	        } while (!$this->codeIsValid($code));
	        return $code;
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

           			//nuevo nombre de la imagen que se sube
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
					//llamada a la funcion insertMedia
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
        			//nuevo nombre de la imagen que se sube
       				$extension = explode(".",$archivo['name']);
           			$name = $this->removeWhitespaces($this->Sanitize($data['name']));
           			// $name .= date('Y-m-d', time()). '.' . $extension[1];
           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
           			//path a la carpeta de category
					$pathInsert = '../../img/category/';
					$pathInsert .= $name;

					$pathSave = '/img/category/';
					$pathSave .= $name;
					//llamada a la funcion insertMedia
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
			$qry = 'SELECT * FROM type ORDER BY id_type';
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
						$img = $this->getMedia($row['id_type'],'type');
						$img_mobile = $this->getMedia($row['id_type'],'type_mobile');
						if(!$img && !$img_mobile){
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
			$qry = 'INSERT INTO type(name,id_parent,status) VALUES ("'.$data['name'].'",0,1) ';
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
			$qry = 'UPDATE type SET name="'.$type_name.'", status="'.$type_status.'" WHERE id_type = '.$id_type;
			$result = $this->db->updateQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo actualizar tipo');
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

		function getTags(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM tag ORDER BY id_tag';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No tags aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No tags aun');
					$returnValue = false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						array_push($array_data, array('id_tag'=>$row['id_tag'],'name'=>$row['name']));
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}

		function insertTag($name){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'INSERT INTO tag (name) VALUES ("'.$name.'")';
			$result = $this->db->insertQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo guardar tag');
				$returnValue = false;
			}
			$returnValue = $this->db->lastInsertID();
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
			$qry = 'SELECT * FROM settings ORDER by id_settings ASC';
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
			THEME
		*/
			/*		CAROUSEL 	*/
			function getCarousels(){
				$returnValue = true;
				$this->db->DBLogin();
				$qry = 'SELECT * FROM carousel ORDER by id_carousel DESC';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleDBError('NO CAROUSELS');
					$returnValue=false;
				}else{
					$array_data = [];
					while($row = $this->db->fetchArray($result)){
						array_push($array_data,$row);
					}
					$returnValue = $array_data;
				}
				return $returnValue;
			}
			function getCarousel($id_carousel){
				$returnValue = true;
				$this->db->DBLogin();
				$qry = 'SELECT * FROM carousel_slide WHERE carousel_id_carousel='.$id_carousel .' ORDER BY number_slide ASC';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleDBError('NO slides');
					$returnValue=false;
				}else{
					$array_data = array();
					while($row = $this->db->fetchArray($result)){
						$img = $this->getMedia($row['id_carousel_slide'],'carousel');
						$img_mobile = $this->getMedia($row['id_carousel_slide'],'carousel_mobile');
						if(!$img && !$img_mobile){
							array_push($array_data, array('carousel'=>$row,'media'=>false));
						}else{
							$imgs = array($img,$img_mobile);
							array_push($array_data, array('carousel'=>$row,'media'=>$imgs));
						}
					}
					$returnValue = $array_data;
				}
				return $returnValue;
			}
			function updateCarousel($id_carousel,$name,$status){
				$returnValue = true;
				$this->checkDBLogin();
				$qry = 'UPDATE carousel SET name="'.$name.'", status='.$status.' WHERE id_carousel='.$id_carousel;
				$result = $this->db->updateQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo actualizar'.$qry);
					$returnValue = false;
				}
				return $returnValue;
			}
			function insertCarousel(){
				$returnValue = true;
				$data = $_POST;
				$this->checkDBLogin();
				$qry = 'INSERT INTO carousel(name,status) VALUES ("'.$data['name'].'",1) ';
				$result = $this->db->insertQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo guardar la marca');
					$returnValue = false;
				}

				$id_carousel = $this->db->lastInsertID();
				$returnValue = $id_carousel;
				return $returnValue;
			}
			function insertCarouselSlide(){
				$returnValue = true;
				$data = $_POST;
				$this->checkDBLogin();
				$qry = 'INSERT INTO carousel_slide(number_slide,url,text,carousel_id_carousel) 
											VALUES ("'.$data['number'].'",
													"'.$this->SanitizeForSQL($data['url']).'",
													"'.$this->SanitizeForSQL($data['text']).'",
													'.$data['id_carousel'].')';
				$result = $this->db->insertQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo guardar la marca');
					$returnValue = false;
				}
				$id_slider = $this->db->lastInsertID();
				// $id_slider = $data['id_carousel'];
				

				if(!empty($_FILES['file']['name'])){
	           		$archivo = $_FILES['file'];
	           		if ($archivo["error"] == UPLOAD_ERR_OK) {
	           			$tmp_name = $archivo["tmp_name"];
	           			$extension = explode(".",$archivo['name']);
		           		$name = $this->removeWhitespaces($this->Sanitize($extension[0]));
		           		$name .= date("m-d-Y_hia") . '.' . $extension[1];
						$pathInsert = '../../img/carousel/';
						$pathInsert .= $name;
						$pathSave = '/img/carousel/';
						$pathSave .= $name;
						$img = $this->insertMedia('carousel',$id_slider,$tmp_name,$pathInsert,$pathSave);
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
		           		$name = $this->removeWhitespaces($this->Sanitize($extension[0] . 'mobile'));
		           		$name .= date("m-d-Y_hia") . '.' . $extension[1];
						$pathInsert = '../../img/carousel/';
						$pathInsert .= $name;
						$pathSave = '/img/carousel/';
						$pathSave .= $name;
						$img = $this->insertMedia('carousel_mobile',$id_slider,$tmp_name,$pathInsert,$pathSave);
						if(!$img){
							$returnValue = false;
						}
	           		}	
	           	}
				return $returnValue;
			}
			function updateSlidesNumber(){
				$data = $_POST;
				$returnValue = true;
				$this->checkDBLogin();
				$lista = json_decode($_POST['lista']);
				foreach($lista as $key=>$value){
		            $qry = "UPDATE carousel_slide SET number_slide = ".$value[1]." WHERE id_carousel_slide=".$value[0];
					$result = $this->db->updateQuery($qry);
					if(!$result){
						$this->db->HandleError('No se pudo guardar la marca');
						$returnValue = false;
					}
		        }
				return $returnValue;
			}
			function updateSlide(){
				$data = $_POST;
				$returnValue = true;
				$this->checkDBLogin();
				$qry = 'UPDATE carousel_slide SET url="'.$data['url'].'", text="'.$this->SanitizeForSQL($data['text']).'" WHERE id_carousel_slide='.$data['id_carousel_slide'];
				$result = $this->db->updateQuery($qry);
				if(!$result){
					$this->db->HandleError('No se pudo actualizar slide');
					$returnValue = false;
				}
				return $returnValue;
			}
			function updateSlidePhoto(){
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
	       				if($type == 'carousel_mobile'){
	       					$name = $this->removeWhitespaces($this->Sanitize($extension[0] . 'mobile'));
	       				}else{
	       					$name = $this->removeWhitespaces($this->Sanitize($extension[0]));
	       				}
	           			$name .= date("m-d-Y_hia") . '.' . $extension[1];
						$pathInsert = '../../img/carousel/';
						$pathInsert .= $name;

						$pathSave = '/img/carousel/';
						$pathSave .= $name;
						$img = $this->updateMedia($type,$id_media,$tmp_name,$pathInsert,$pathSave);
						if(!$img){
							$returnValue = false;
						}
	           		}
	           		
	           	}
				return $returnValue;
			}
			function deleteSlide(){
				$data = $_POST;
				$returnValue = true;
				$this->checkDBLogin();
				$id_carousel = $data['id_carousel'];
				$img = $this->getMedia($data['id_carousel_slide'],'carousel');
				$img_mobile = $this->getMedia($data['id_carousel_slide'],'carousel_mobile');
				if(is_array($img) && is_array($img_mobile)){
					$this->deleteMedia($img[0]['id_media']);
					$this->deleteMedia($img_mobile[0]['id_media']);
				
				}
				$qry = 'DELETE FROM carousel_slide WHERE id_carousel_slide='.$data['id_carousel_slide'];
				$result = $this->db->deleteQuery($qry);
				if(!$result){
					$this->db->HandleDBError('No se pudo eliminar slide'.$qry);
					$returnValue = false;
				}


				$lista = $this->getCarousel($id_carousel);
		        $cont = 1;
		        
		        foreach ($lista as $key => $value) {
		        	$carousel = $value['carousel'];
		        	$qry = "UPDATE carousel_slide SET number_slide = ".$cont." WHERE id_carousel_slide=".$carousel['id_carousel_slide']; 
					$returnValue = $qry;
		            $result = $this->db->deleteQuery($qry);
					if(!$result){
						$this->db->HandleDBError('No se pudo eliminar slide'.$qry);
						$returnValue = false;
					}
		            $cont++;
		        }
				return $returnValue;
			}
			/*

					HTML

			*/
			function getHTML(){
				$returnValue = true;
				$this->db->DBLogin();
				$qry = 'SELECT * FROM html_content WHERE mobile=1 ORDER by id_html_content DESC';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleDBError('NO HTML');
					$returnValue=false;
				}else{
					$array_data = [];
					while($row = $this->db->fetchArray($result)){
						array_push($array_data,$row); 
					}
					$returnValue = $array_data;
				}
				return $returnValue;
			}

			function insertHTMLContent(){
				$returnValue = true;
				$this->db->DBLogin();
				$data = $_POST;
				switch ($data['type']) {
					case '1':
						//insert HTML empty to get last_id_inserted
						$qry = 'INSERT INTO html_content (page,status,type,mobile) VALUES ("'.$data['url_page'].'",1,"'.$data['type'].'",0)';
						$result = $this->db->insertQuery($qry);
						if(!$result){
							$this->db->HandleError('No se pudo guardar html content');
							$returnValue = false;
						}
						$id_html = $this->db->lastInsertID();
						
						//insertar img in MEDIA
						if(!empty($_FILES['file']['name'])){
			           		$archivo = $_FILES['file'];
			           		if ($archivo["error"] == UPLOAD_ERR_OK) {
			           			$tmp_name = $archivo["tmp_name"];
			           			$extension = explode(".",$archivo['name']);
				           		$name = $this->removeWhitespaces($this->Sanitize($extension[0]));
				           		$name .= date("m-d-Y_hia") . '.' . $extension[1];
								$pathInsert = '../../img/html/';
								$pathInsert .= $name;
								$pathSave = './img/html/';
								$pathSave .= $name;
								$img = $this->insertMedia('html',$id_html,$tmp_name,$pathInsert,$pathSave);
								if(!$img){						
									$returnValue = false;
								}
			           		}
			           	}

				        //create HTML OF type 1
				        $html = '<div class="contenidoBox" style="background-image:url('.$pathSave.');">';
				        $html .= '<div class="container">';
						$html .= '<p class="text1">'.$data['text1'].'</h1>';  
                        $html .= '<p class="text2">'.$data['text2'].'</p>';
                        $html .= '<a href="'.$data['url'].'"><button>'.$data['textButton'].'</button></a>';
                    	$html .= '</div>';
                    	$html .= '</div>';
				    	//update 

                    	$qry = "UPDATE html_content 
                    					SET text='$html'
                    					WHERE id_html_content='$id_html'";
						$result = $this->db->updateQuery($qry);
						if(!$result){
							$this->db->HandleDBError('No se pudo actualizar HTML CONTENT'.$qry);
							$returnValue = false;
						}


						//insert mobile version
						$qryMobile = 'INSERT INTO html_content (page,status,type,mobile,id_html_content_parent) VALUES ("'.$data['url_page'].'",1,"'.$data['type'].'",1,'.$id_html.')';
						$result = $this->db->insertQuery($qryMobile);
						if(!$result){
							$this->db->HandleDBError('No se pudo guardar html content'.$qryMobile);
							$returnValue = false;
						}

						$id_html_mobile = $this->db->lastInsertID();
						//create HTML OF type 1
				        $html = '<div class="contenidoBox" style="background-image:url(.'.$pathSave.');">';
				        $html .= '<div class="container">';
						$html .= '<p class="text1">'.$data['text1'].'</h1>';  
                        $html .= '<p class="text2">'.$data['text2'].'</p>';
                        $html .= '<a href="'.$data['url'].'"><button>'.$data['textButton'].'</button></a>';
                    	$html .= '</div>';
                    	$html .= '</div>';
						$qry = "UPDATE html_content 
                    					SET text='$html'
                    					WHERE id_html_content='$id_html_mobile'";
						$result = $this->db->updateQuery($qry);
						if(!$result){
							$this->db->HandleDBError('No se pudo actualizar HTML CONTENT'.$qry);
							$returnValue = false;
						}


						break;
					default:
						# code...
						break;
				}
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
				$this->db->HandleError('No media aun'.$qry);
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No media aun'.$qry);
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
					$this->db->HandleError('No se pudo guardar en tabla: MEDIA'.$qry);
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
		function deleteMedia($id_media){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'DELETE FROM media WHERE id_media='.$id_media;
			$result = $this->db->deleteQuery($qry);
			if(!$result){
				$this->db->HandleError('No se pudo eliminar de la tabla: MEDIA');
				$returnValue = false;
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