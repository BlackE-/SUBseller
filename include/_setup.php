<?php
	// require_once dirname(__FILE__) . '/include/db.php';
	require_once '_db.php';
	class Setup{
		private $db;
		private $rand_key = 'qUAV7HXAr8oN4ytArLx84PgUDNHmaWNR';

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
	    function setErrorMessage($message){$this->db->HandleError($message);}
	    function getErrorMessage(){return $this->db->error_message;}
	    /*
			LOGIN
	    */
	    function loginClient($email,$password){
	    	$returnValue = true;
	    	$this->checkDBLogin();

	    	$formvars = array();
			$formvars['email'] = $this->Sanitize($email);	
			$qry = "SELECT id_client,_password FROM client WHERE email='".$formvars['email']."'";
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
				        $_SESSION[$this->GetLoginSessionVar()] = $row['id_client'];
				        $_SESSION['timeout'] = time() + (1 * 24 * 60 * 60);
				        						// 1 day; 24 hours; 60 mins; 60 secs

				        //guardar en DB lo que este en SESSION
				        $this->setCart();
		        	}
		        } 
			}
		    $this->db->closeAll();
		    return $returnValue;
	    }

	  //   function checkLoginForHeader(){
	  //       if(!isset($_SESSION)){ session_start(); }
	  //       $sessionvar = $this->GetLoginSessionVar();
	  //       if(empty($_SESSION[$sessionvar])){
	  //           $this->HandleError("Session expiro!");
	  //           return false;
	  //       }
	  //       if(!$this->DBLogin()){
	  //           $this->HandleError("Database login failed!");
	  //           return false;
	  //       }
	  //       $qry = "SELECT id_cliente,name,id_facebook FROM cliente WHERE id_cliente = " . $_SESSION[$sessionvar];
	  //       $result = mysql_query($qry,$this->connection);
	  //       $row = mysql_fetch_array($result);
	  //       if(mysql_num_rows($result)<=0){
	  //           $this->HandleError("Error. Datos Incorrectos.");
	  //           return false;
	  //       }
	  //       return array("id_cliente"=>$row['id_cliente'],"name"=>$row['nombre'],'id_facebook'=>$row['id_facebook']);
	  //   }

	  //   function checkLoginFacebook(){
	  //       $id_facebook = $_POST['id_facebook'];
	  //       $returnValue = true;
	  //       $this->checkDBLogin();
	  //       if(!isset($_SESSION)){ session_start(); }
	  //       $qry = "SELECT id_client,id_facebook FROM client WHERE id_facebook='$id_facebook'";
	  //       $result = $this->db->selectQuery($qry);
			// if(!$result){
			// 	$this->db->HandleError('No login with Facebook');
			// 	$returnValue = false;
			// }else{
			// 	if(!$this->db->numRows($result)){
			// 		$returnValue = false;
			// 	}else{
			// 		$row = $this->db->fetchArray($result);
			//         $_SESSION[$this->GetLoginSessionVar()] = $row['id_client'];
			//         $_SESSION['timeout'] = time();
			// 	}
			// }
	  //      return $returnValue;
	  //  	}

	    /*  ------------------------    LOGOUT  --------------------------- */
		function Logout(){
		    session_start();
		    $sessionvar = $this->GetLoginSessionVar();
		    $_SESSION[$sessionvar]=NULL;
		    unset($_SESSION[$sessionvar]);
		    return true;
		}
	    /*
			REGISTER
	    */
		function checkEmailForRegister($email){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM client WHERE email="'.$email.'"';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No email in DB');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No email in DB');
					$returnValue = false;
				}
			}
			return $returnValue; 
		}

	    function insertClient($name,$email,$password,$sex,$id_conekta,$cumple,$telefono){
	    	$returnValue = true;
	    	$this->checkDBLogin();

	    	$formvars = array();
			$formvars['name'] = $this->Sanitize($name);
			$formvars['email'] = $this->Sanitize($email);
			$formvars['password'] = password_hash($password, PASSWORD_DEFAULT);
			$formvars['type'] = $this->Sanitize('admin');
			$formvars['sex'] = $this->Sanitize($sex);
			$formvars['conekta'] = $this->Sanitize($id_conekta);
        	$formvars['cumple'] = $this->Sanitize($cumple);
        	$formvars['telefono'] = $this->Sanitize($telefono);	

			$qry = 'INSERT INTO client (name,email,_password,sex,id_conekta,birthday,phone,date_created)
                values(
                "' . $formvars['name'] . '",
                "' . $formvars['email'] . '",
                "' . $formvars['password'] . '",
                "' . $formvars['sex'] . '",
                "' . $formvars['conekta'] .'",
                "'. $formvars['cumple'] .'",
                "'. $formvars['telefono'] .'",
                NOW())'; 
			if(!$this->db->insertQuery($qry)){
				$returnValue = false;
			}
		    $this->db->closeAll();
		    return $returnValue;
	    }


		
		
		/*
			Orders
		*/
		function getOrdersClient($id_client){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM _order WHERE cliente_id_cliente='.$id_client.' ORDER BY id_order';
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
					$array_data = [];
					while($row = $this->db->fetchArray($result)){
						$media = $this->getMedia($row['id_product'],'product');
						if(!$media){
							array_push($array_data, array('product'=>$row,'media'=>''));
						}else{
							array_push($array_data, array('product'=>$row,'media'=>$media));
						}
					}
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}
		
		function getBestSellers(){
			$returnValue = false;
			$this->checkDBLogin();
			$qry = 'SELECT product.id_product,product.status,
							product_movement.product_id_product,product_movement.type,COUNT(*) AS count
					FROM product,product_movement
					WHERE product_movement.type="EGRESO"
					AND product.status=1
					AND product.id_product = product_movement.product_id_product
					GROUP BY product_movement.product_id_product ORDER BY count DESC LIMIT 4';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$qry = 'SELECT * FROM product WHERE status=1 ORDER BY RAND() LIMIT 4';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleError('NO HAY PRODUCTOS');
					$returnValue = false;
				}
			}else{
				if($this->db->getNumRows($result) < 4){
					$qry = 'SELECT * FROM product WHERE status=1 ORDER BY RAND() LIMIT 4';
					$result = $this->db->selectQuery($qry);
					if(!$result){
						$this->db->HandleError('NO HAY PRODUCTOS');
						$returnValue = false;
					}else{
						$this->db->HandleError('HAY PRODUCTOS');
						$array_data = [];
						while($row = $this->db->fetchArray($result)){
							$media = $this->getMedia($row['id_product'],'product');
							if(!$media){
								array_push($array_data, array('product'=>$row,'media'=>''));
							}else{
								array_push($array_data, array('product'=>$row,'media'=>$media));
							}
						}
						$returnValue = $array_data;
					}
				}else{
					$this->db->HandleError('HAY PRODUCTOS');
					$array_data = [];
					while($row = $this->db->fetchArray($result)){
						$media = $this->getMedia($row['id_product'],'product');
						if(!$media){
							array_push($array_data, array('product'=>$row,'media'=>''));
						}else{
							array_push($array_data, array('product'=>$row,'media'=>$media));
						}
					}
					$returnValue = $array_data;
				}	
			}
			return $returnValue;
		}
		function filterProducts(){
			$returnValue = false;
			$this->checkDBLogin();

			$category = $_POST['category'];
			$brand = $_POST['brand'];
			$type = $_POST['type'];
			$min_price = $_POST['min_price'];
			$max_price = $_POST['max_price'];

			$finalArray = [];
        	$tempArray = [];        //1ra busqueda
        	$tempArray2 = [];       //2da busqueda filtrado

			$qry = "SELECT id_product FROM product WHERE price_sale>=".$min_price." AND price_sale <=".$max_price;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('no products PRICE filter');
				$returnValue = false;
			}else{
				$array_data = [];
				while($row = $this->db->fetchArray($result)){
					array_push($tempArray, $row['id_product']);
				}

				if($type != ""){
		            $selectType = "SELECT id_product FROM product WHERE type_id_type=".$type;
		            $result = $this->db->selectQuery($selectType);
					if(!$result){
						$this->db->HandleError('no products filter type');
						$returnValue = false;
					}else{
						while($row = $this->db->fetchArray($result)){
		                	array_push($tempArray2, $row['id_product']);
		            	}
		            	foreach($tempArray as  $key=>$value){if(!in_array($value, $tempArray2)){unset($tempArray[$key]);}}
					}
		            $tempArray2 = [];
		        }


		        if($category != ""){
		            $selectCategory = "SELECT product_id_product FROM product_category WHERE category_id_category=".$category;
		            $result = $this->db->selectQuery($selectCategory);
					if(!$result){
						$this->db->HandleError('no products filter category');
						$returnValue = false;
					}else{
			            while($row = $this->db->fetchArray($result)){
			                array_push($tempArray2, $row['product_id_product']);
			            }
			            foreach($tempArray as  $key=>$value){if(!in_array($value, $tempArray2)){unset($tempArray[$key]);}}
			        }
		            $tempArray2 = [];
		        }

		        if($brand != ""){
		            $selectBrands = "SELECT id_product FROM product WHERE brand_id_brand=".$brand;
		            $result = $this->db->selectQuery($selectBrands);
					if(!$result){
						$this->db->HandleError('no products filter brand');
						$returnValue = false;
					}else{
			            while($row = $this->db->fetchArray($result)){
			                array_push($tempArray2, $row['id_product']);
			            }
			            foreach($tempArray as  $key=>$value){if(!in_array($value, $tempArray2)){unset($tempArray[$key]);}}
			        }
		            $tempArray2 = [];
		        }

		   //      if(gettype($brand) == "array"){
		   //          $sizeBrands = sizeof($brand);
		   //          $selectBrands = "SELECT id_producto FROM product WHERE ";
		   //          foreach ($brand as $key => $value) {
		   //              if($key == $sizeBrands-1){
		   //                  $selectBrands .= 'brand_id_brand='.$value;
		   //              }else{
		   //                  $selectBrands .= 'brand_id_brand='.$value . " OR ";           
		   //              }
		   //          }
					// $result = $this->db->selectQuery($selectBrands);
		   //          if(!$result){
					// 	$this->HandleError('no products filter');
					// 	$returnValue = false;
					// }else{
			  //           while($row = $this->db->fetchArray($result)){
			  //               array_push($tempArray2, $row['id_product']);
			  //           }

			  //           foreach($tempArray as  $key=>$value){if(!in_array($value, $tempArray2)){unset($tempArray[$key]);}}
			  //           $tempArray2 = [];
			  //       }
		   //      }
			}
			$returnValue = $tempArray;
			return $returnValue;
		}
		function filterProductsByTag(){
			$returnValue = false;
			$this->checkDBLogin();

			$id_tag = $_POST['id_tag'];
			$qry = 'SELECT product_id_product FROM product_tag WHERE tag_id_tag='.$id_tag;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('no products filter by tag');
				$returnValue = false;
			}
			else{
				$array_data = [];
				while($row = $this->db->fetchArray($result)){
					array_push($array_data, $row['product_id_product']);
				}
			}
			$returnValue = $array_data;
			return $returnValue;
		}
		/*
			PRODUCT
		*/
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
					$array_data = [];
					$row = $this->db->fetchArray($result);
					array_push($array_data, array('product'=>$row));
					//media thumbnai
					$media = $this->getMedia($row['id_product'],'product');
					if(!$media){array_push($array_data, array('media'=>''));
					}else{array_push($array_data, array('media'=>$media));}

					// //media secondary thumbnail
					$media_secondary = $this->getMedia($row['id_product'],'product_secondary');
					array_push($array_data, array('media_secondary'=>$media_secondary));
					$returnValue = $array_data;
				}
			}
			return $returnValue;
		}
		function getProductCategories($id_product){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT product.id_product,
							product_category.product_id_product,product_category.category_id_category,
							category.id_category,category.name as CATEGORY_NAME,
					 FROM  product,product_category,category
					 WHERE product.id_product = product_category.product_id_product
					 		AND product_category.category_id_category = category.id_category
					 		AND product.product_id_product ='.$id_product;

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
						array_push($array_data, $row['CATEGORY_NAME']);
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
		


		/*
	    	
	    	CART

	    */
	    function getCart(){
	    	//return items from DB client already LOGGED IN
	    	$returnValue = array();
	    	$this->checkDBLogin();
	       	if(!isset($_SESSION)){ session_start(); }
	    	if(isset($_SESSION['id_session_client'])){
				//ya se tiene en session el id a recuperar
				$id_session_client = $_SESSION['id_session_client'];
				$returnValue = $this->getItemsFromSessionClient($id_session_client);
			}
			else{
				$sessionvar = $this->GetLoginSessionVar();
				$qry = 'SELECT * from session_client WHERE client_id_client='.$_SESSION[$sessionvar]. ' AND status=0';
				$result = $this->db->selectQuery($qry);
				if(!$result || !$this->db->numRows($result)){
					$qry = 'INSERT into session_client (status,client_id_client) VALUES (0,'.$_SESSION[$sessionvar].')';
					$result = $this->db->insertQuery($qry);
					if(!$result){
						$this->db->HandleError('No se pudo guardar in session_client');
					}else{
						$id_session_client = $this->db->lastInsertID();
						$_SESSION['id_session_client'] = $id_session_client;
					}
				}else{
					$row = $this->db->fetchArray($result);
					$id_session_client = $row['id_session_client'];
					$_SESSION['id_session_client'] = $id_session_client;
					$returnValue = $this->getItemsFromSessionClient($id_session_client);
				}
			}
			return $returnValue;
	    }
	    function getCartItems(){
	    	$returnValue = 0;
	    	$this->checkDBLogin();
	       	if(!isset($_SESSION)){ session_start(); }
	       	$login = $this->checkLogin();
	    	//if client is logged in return items from DB
			if($login){
				if(isset($_SESSION['id_session_client'])){
					//ya se tiene en session el id a recuperar
					$id_session_client = $_SESSION['id_session_client'];
					$items = $this->getItemsFromSessionClient($id_session_client);
					$returnValue = count($items);
				}
				else{
					$sessionvar = $this->GetLoginSessionVar();
					$qry = 'SELECT * from session_client WHERE client_id_client='.$_SESSION[$sessionvar]. ' AND status=0';
					$result = $this->db->selectQuery($qry);
					if(!$result || !$this->db->numRows($result)){
						$qry = 'INSERT into session_client (status,client_id_client) VALUES (0,'.$_SESSION[$sessionvar].')';
						$result = $this->db->insertQuery($qry);
						if(!$result){
							$returnValue = false;
							$this->db->HandleError('No se pudo guardar in session_client');
						}else{
							$id_session_client = $this->db->lastInsertID();
							$_SESSION['id_session_client'] = $id_session_client;
						}
					}else{
						$row = $this->db->fetchArray($result);
						$id_session_client = $row['id_session_client'];
						$_SESSION['id_session_client'] = $id_session_client;
						$items = $this->getItemsFromSessionClient($id_session_client);
						$returnValue = count($items);
					}

				}
			}//else
			else{
				if(!isset($_SESSION['cart'])){
		        	$_SESSION['cart'] = array();
		        }
		        $returnValue = count($_SESSION['cart']); 
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
	       			array_push($array_items, array('id_product'=>$row['product_id_product'],'qty'=>$row['number_items'],'price'=>$row['price']));
	       		}
	       		$returnValue = $array_items;
	       	}
	       	return $returnValue;
	    }

	    function insertSessionClient($id_client){
	    	$returnValue = 0;
	    	$this->checkDBLogin();
	    	if(!isset($_SESSION)){session_start();}
	    	$qry = "INSERT INTO session_client (client_id_client, status) VALUES(".$id_client.",0)";
            $result = $this->db->insertQuery($qry);
            if(!$result){
                $this->db->HandleError('No se pudo guardar status en DB');
                $returnValue = false;
            }else{
            	$id_session_client = $this->db->lastInsertID();
            	$_SESSION['id_session_client'] = $id_session_client;
            }
	    	return $id_session_client;
	    }

	    function insertSessionCart($id_session_client,$id_product,$qty,$price){
	    	$returnValue = true;
			$this->checkDBLogin();
			$qry = "INSERT into session_cart (session_client_id_session_client,product_id_product,number_items,price)
						VALUES(".$id_session_client.", ".$id_product.",".$qty.",".$price.")";
			$result = $this->db->insertQuery($qry);
			if(!$result){
			    $this->db->HandleError("No se pudo guardar el producto");
				$returnValue = false;
			}
			return $returnValue;
	    }

	    function updateSessionCart($id_session_cart,$qty,$price){
	    	$returnValue = true;
			$this->checkDBLogin();
			$qry = "UPDATE session_cart SET number_items=".$qty.", price=".$price." WHERE id_session_cart=".$id_session_cart;
			$result = $this->db->updateQuery($qry);
			if(!$result){
			    $this->db->HandleError($qry . "No se pudo actualizar el carrito");
				$returnValue = false;
			}
			return $returnValue;
	    }

	    function updateSessionClient($id_session_client){
	    	$returnValue = true;
			$this->checkDBLogin();
			$qry = "UPDATE session_client SET status=1 WHERE id_session_client=".$id_session_client;
			$result = $this->db->updateQuery($qry);
			if(!$result){
			    $this->db->HandleError($qry . "No se pudo actualizar session_client");
				$returnValue = false;
			}
			return $returnValue;
	    }

	    function checkInventory($id_product,$quantity){
	    	$returnValue = true;
			$this->checkDBLogin();
			$qry = "SELECT stock FROM product_inventory WHERE product_id_product=".$id_product;
			$result = $this->db->selectQuery($qry);
			if(!$result){
			    $this->db->HandleError("No contamos con el producto en el inventario");
				$returnValue = false;
			}
			else{
				$row = $this->db->fetchArray($result);
				if($row['stock'] < intval($quantity)){
					 $this->db->HandleError("No contamos con la cantidad (".$quantity.") solicitada.");
					 $returnValue = false;
				}
				
			}
			return $returnValue;
	    }

		function addProductToCart(){
			$id_product = $_POST['id_product'];
			$quantity = $_POST['quantity'];
	        $price = $_POST['price'];
	        
	        $returnValue = true;
			$this->checkDBLogin();
			$result = $this->checkInventory($id_product,$quantity);
			if($result){
				if(!isset($_SESSION)){ session_start(); }
				if($this->CheckLogin()){
		        	//if client is logged in store cart in DB
		        	$id_client =  $_SESSION[$this->GetLoginSessionVar()];
		        	$id_session_client = $_SESSION['id_session_client'];
		        	//check if product is in DB
		        	$qry = 'SELECT * from session_cart WHERE product_id_product='.$id_product.' AND session_client_id_session_client='.$id_session_client;
		        	$result = $this->db->selectQuery($qry);
		        	if(!$result){
		        		$returnValue = $this->insertSessionCart($id_session_client,$id_product,$quantity,$price);
		        	}else{
		        		if(!$this->db->numRows($result)){
		        			$returnValue = $this->insertSessionCart($id_session_client,$id_product,$quantity,$price);
		        		}else{
		        			$row = $this->db->fetchArray($result);
		        			$newQty = intval($row['number_items']) + intval($quantity);
		        			$returnValue = $this->updateSessionCart($row['id_session_cart'],$newQty,$price);
		        		}
		        	}
		        }
		        else{
		        	//not logged in
					//	GUARDAR TODOS LOS DATOS EN SESSION
					if(!isset($_SESSION)){ session_start(); }
					if(!isset($_SESSION['shop'])){ $_SESSION['cart'] = array();}
		            $found = false;
		            foreach($_SESSION['cart'] as $key => $value){
	                    if($value['id_product'] == $id_product){
	                        $found=true;
	                        $_SESSION['cart'][$key]['qty'] = $value['quantity'] + $quantity;
	                    }
		            }
		            if(!$found)
					    array_push($_SESSION['cart'],array("id_product" => $id_product, "qty"=>$quantity,"price"=>$price,"id_session_cart"=>""));
						//array_push($_SESSION['cart'],array("id_producto" => $id_product, "quantity"=>$quantity,"price"=>$price,"id_carrito_producto"=>""));
		        }
			}else{
				$returnValue = false;
			}
			return $returnValue;
		}

		function updateCart(){
			$returnValue = true;
			$this->checkDBLogin();
			$id_product = $_POST['id_product'];
			$quantity = $_POST['quantity'];
			$result = $this->checkInventory($id_product,$quantity);
			if($result){
				if(!isset($_SESSION)){ session_start(); }
				if($this->CheckLogin()){
					$id_product = $_POST['id_product'];
					$qty = $_POST['quantity'];
					$price = $_POST['price'];

					$id_session_client = $_SESSION['id_session_client'];
					$qry = 'SELECT * from session_cart WHERE product_id_product='.$id_product.' AND session_client_id_session_client='.$id_session_client;
		        	$result = $this->db->selectQuery($qry);
		        	$row = $this->db->fetchArray($result);
		        	$id_session_cart = $row['id_session_cart'];
		        	
		        	$returnValue = $this->updateSessionCart($id_session_cart,$qty,$price);
		        }
		        else{
		        	$carTemp = $_SESSION['cart'];
		        	foreach($cartTemp as $key=>$value){
			            $cartTemp[$key]['qty'] = $_POST[$key];
			            $update_query = "UPDATE session_cart SET number_items=".$_POST[$key]." WHERE session_client_id_session_client=".$value['id_session_client'];
			            $result = $this->db->updateQuery($update_query);
					}
					$_SESSION['cart'] = $cartTemp;
		        }
		    }
		    else{
				$returnValue = false;
			}
			return $returnValue;
		}

		function clearDBCart(){
	        if(!isset($_SESSION)){session_start();}
	        $returnValue = true;
			$this->checkDBLogin();
			
	        $update_query = "UPDATE session_client SET status=1 WHERE id_session_client=".$_SESSION['id_session_client'];
	        $result = $this->db->updateQuery($update_query,$this->connection);
	        return $returnValue;
	    }

	    function setCart(){
	    	if(!isset($_SESSION)){session_start();}
	        $returnValue = true;
	        $queries = array(); //variable para ir entendiendo el proceso, cada paso se mete al array
			$this->checkDBLogin();
			if(!isset($_SESSION)){ session_start(); }
	        if(!$this->CheckLogin()){
	        	array_push($queries, 'no login');
	            $this->db->HandleError("Sin Login");
	            $returnValue = false;
	        }else{
	        	array_push($queries, 'is login');
				$id_client =  $_SESSION[$this->GetLoginSessionVar()];
		        $qry = "SELECT * from session_client WHERE status = 0 AND client_id_client=".$id_client;
		        $result = $this->db->selectQuery($qry);
		        if(!$this->db->numRows($result)){
		        	array_push($queries, 'no habia carrito');
		        	//NO HAY carrito guardado en DB 
	            	array_push($queries, 'se creo un carrito, para guardar todo lo de SESSION');
	            	$id_session_client = $this->insertSessionClient($id_client);
		            $cartTemp = $_SESSION['cart'];
		            foreach($cartTemp as $key2=>$cartValue){
		                //GUARDARLO EN LA BASE
		                $insert = "INSERT INTO session_cart (session_client_id_session_client,product_id_product,number_items,price) 
		                			VALUES (".$id_session_client.",".$cartValue['id_product'].",".$cartValue['qty'].",".$cartValue['price'].")";
		                $query = $this->db->insertQuery($insert);
		                if(!$query){
		                    $this->db->HandleError('No se pudo guardar el carrito en DB');
		                    $returnValue = false;
		                }
		            }
		            //unset($_SESSION['CART']);
		        }else{
		        	// array_push($queries, 'SI HABIA CARRITO');
		        	//SI HAY UN carrito 	recuperar ID_CARRITO_SESION
		            $session_client = $this->db->fetchArray($result);
		            $id_session_client = $session_client['id_session_client'];$_SESSION['id_session_client'] = $id_session_client;

		            $qry = "SELECT *  FROM session_cart WHERE session_client_id_session_client=".$id_session_client;
		            $items = $this->db->selectQuery($qry);
		            $cartTemp = $_SESSION['cart'];

		            //meter todos los ID productos del carrito DB en un array
		            $id_items = array();
		            $numResults = $this->db->getNumRows($items);

		            $array_products_in_db = array();
		            $array_products_missing_in_db = array();
		            $array_products_to_insert = array();
		            //recorrer todo SESSION 'cart'
	                // array_push($queries, "RECORRER SESSION foreach");
	                foreach($cartTemp as $key2=>$cartValue){
	                    $found = false;
	                    while($prod = $this->db->fetchArray($items)){
	                    	// array_push($queries, array('prod'=>$prod));
	                    	// array_push($queries, array('1 left'=>$cartValue['id_product']));
	                    	// array_push($queries, array('1 right'=>$prod['product_id_product']));
	                    	
	                    	if(!in_array($prod['product_id_product'],$array_products_in_db,true)){
	                    		array_push($array_products_in_db,$prod['product_id_product']);
	                    		// array_push($queries, array('2 prod_in_db'=>$array_products_in_db));
	                    	}
	                    	if($cartValue['id_product'] == $prod['product_id_product']){//producto encontrado en DB y en carrito se actualiza
	                            $found = true;
	                            // array_push($queries, array('3 found true'=>$prod['product_id_product']));
	                            $qty = intval($cartValue['qty']) + intval ($prod['number_items']);
	                            $update = "UPDATE session_cart SET number_items=".$qty." WHERE product_id_product=".$cartValue['id_product']." AND id_session_cart=".$prod['id_session_cart'];
	                            $this->db->updateQuery($update);
	                            // array_push($queries, $update);
	                        }
	                        else{
	                        	// array_push($queries, array('5 product_not_found'=>$prod['product_id_product']));
	                        	if(!in_array($cartValue['id_product'], $array_products_in_db,true)){
	                        		// array_push($queries, array('6 prod_not_in_array_db'=>$cartValue['id_product']));
	                        		// array_push($queries, array('6 prod_not_in_array_db'=>$array_products_in_db));
	                        		// SE TIENE QUE INSERTAR EN LA BASE DE DATOS 	//evaluar si ya se guardo el producto en una iteracion anterior
		                            if(!in_array($cartValue['id_product'], $array_products_missing_in_db,true)){
		                                // array_push($queries, array('7 prod_not_in_array_insert'=>$cartValue['id_product']));
		                                array_push($array_products_missing_in_db,$prod['product_id_product']);
		                                array_push($array_products_to_insert, 
		                                	array(	"id_product"=>$cartValue['id_product'],
		                                			"qty"=>$cartValue['qty'],
		                                			"price"=>$cartValue['price']));
		                            }
	                        	}
	                        }
	                    }
	                }
	                // array_push($queries, '8 recorrer los que productos a insertar');
	                foreach ($array_products_to_insert as $key => $value) {
	                	if(!in_array($value['id_product'],$array_products_in_db)){
							$insert = "INSERT INTO session_cart (session_client_id_session_client,product_id_product,number_items,price) 
	                             	VALUES(".$id_session_client.",".$value['id_product'].",".$value['qty'].",".$value['price'].")";
							// array_push($queries, $insert);
							$this->db->insertQuery($insert);
	                	}
	                }
	            }
		    }
		    $returnValue = $queries;
		    return $returnValue;
	    }


		/*

			INVENTORY

		*/
		function getInventory($id_product){
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
		/*
	
			COUPONS
	
		*/
		function checkCoupon($coupon){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM coupon WHERE code="'.$coupon.'"';
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No coupons');
				$returnValue = false;
			}else{
				$returnValue = $this->db->fetchArray($result);
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
		
		/*
			brand
		*/
		function getBrands(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM brand WHERE status=1 ORDER BY id_brand';
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

		function getProductBrand($id_brand){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT name FROM brand WHERE id_brand='.$id_brand;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No marcas');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No marcas');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['name'];
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
			$qry = 'SELECT * FROM category WHERE status=1 ORDER BY id_category ';
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
		function getProductTypeName($id_type){
	        $returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM type WHERE id_type='.$id_type;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No tipos aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No tipos aun');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['name'];

				}
			}
			return $returnValue;
	    }
		/*
			TAGS
		*/
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

		function getFavouriteTags(){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM tag ORDER BY RAND() LIMIT 5';
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

		function getTag($id_tag){
			$returnValue = true;
			$this->checkDBLogin();
			$qry = 'SELECT * FROM tag WHERE id_tag='.$id_tag;
			$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No tags aun');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$this->db->HandleError('No tags aun');
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['name'];
				}
			}
			return $returnValue;
		}
		/*
			SETTINGS
		*/

		function getWebsiteSetting($name){
			$returnValue = true;
			$this->db->DBLogin();
			$qry = 'SELECT * FROM settings WHERE name="'.$name.'"';
			$data = $this->db->selectQuery($qry);
			if(!$data){
				$this->db->HandleDBError($qry);
				$returnValue = false;
			}else{
				$row = $this->db->fetchArray($data);
				$returnValue = $row['value'];
			}
			$this->db->closeAll();
			return $returnValue;
		}
	    function getMetaTags(){
	    	$returnValue = true;
			$this->db->DBLogin();
			$qry = 'SELECT * FROM settings WHERE type="website_settings"';
			$data = $this->db->selectQuery($qry);
			if(!$data){
				$this->db->HandleDBError($qry);
				$returnValue = false;
			}else{
				$array_data = [];
				while($row = $this->db->fetchArray($data)){
					array_push($array_data,$row);
				}
				$returnValue = $array_data;
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

		function getMailchimpKey(){
			$returnValue = '';
	    	$this->checkDBLogin();
	    	$qry = 'SELECT * FROM settings WHERE name="mailchimp_key"';
	    	$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No conekta');
				$returnValue = false;
			}else{
				$row = $this->db->fetchArray($result); 
				$returnValue = $row['value'];
			}
			return $returnValue; 
		}

		function getMailchimpList(){
			$returnValue = '';
	    	$this->checkDBLogin();
	    	$qry = 'SELECT * FROM settings WHERE name="mailchimp_id_list"';
	    	$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No conekta');
				$returnValue = false;
			}else{
				$row = $this->db->fetchArray($result); 
				$returnValue = $row['value'];
			}
			return $returnValue; 
		}
			/*

						conekta

			*/
		function getConektaSecretKey(){
	    	$returnValue = '';
	    	$this->checkDBLogin();
	    	$qry = 'SELECT * FROM settings WHERE name="conekta_status"';
	    	$result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No conekta');
				$returnValue = false;
			}else{
				$row = $this->db->fetchArray($result); //RETURN dev || prod
				$qry = 'SELECT * FROM settings WHERE name="conekta_key_private_'.$row['value'].'"';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleError('No coneketa key');
					$returnValue = '';
				}
				else{
					$row = $this->db->fetchArray($result);
					$returnValue = $row['value'];
				}
			}
			return $returnValue; 
	    }

		/*
			THEME
		*/
			/*		CAROUSEL 	*/
			function getCarousel(){
				$returnValue = true;
				$this->db->DBLogin();
				$qry = 'SELECT id_carousel FROM carousel WHERE status=1';
				$result = $this->db->selectQuery($qry);
				if(!$result){
					$this->db->HandleDBError('NO carousel');
					$returnValue=false;
				}else{
					$row = $this->db->fetchArray($result);
					$id_carousel = $row['id_carousel'];
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
								array_push($array_data, array('carousel'=>$row,'media'=>false,'media_mobile'=>false));
							}else{
								array_push($array_data, array('carousel'=>$row,'media'=>$img,'media_mobile'=>$img_mobile));
							}
						}
						$returnValue = $array_data;
					}
				}
				return $returnValue;
			}

			/*

					HTML

			*/
			function getHTMLContentIndex($type){
				$returnValue = true;
				$this->db->DBLogin();
				if($type === 'mobile'){
					$qry = 'SELECT * FROM html_content WHERE page="index" AND status=1 AND mobile=1';
				}else{
					$qry = 'SELECT * FROM html_content WHERE page="index" AND status=1 AND mobile=0';
				}
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
			function getHTML(){
				$returnValue = true;
				$this->db->DBLogin();
				$qry = 'SELECT * FROM html_content ORDER by id_html_content DESC';
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
		/*

			UTIL FUNCTIONS
		
		*/
		function checkLogin(){
			$returnValue = true;
	        if(!isset($_SESSION)){ session_start(); }
	        $sessionvar = $this->GetLoginSessionVar();
	        if(empty($_SESSION[$sessionvar])){
	            $this->db->HandleError("Session expiro!");
	            return false;
	        }
	        if($_SESSION['timeout'] < time()){
	            $this->db->HandleError("Session time expiro!");
	            $returnValue = false;
	        }
	        return $returnValue;
	    }
		function GetLoginSessionVar(){
	        $retvar = md5($this->rand_key);
	        $retvar = 'client_'.substr($retvar,0,10);
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