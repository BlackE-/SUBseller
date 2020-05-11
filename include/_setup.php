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
	    function getErrorMessage(){return $this->db->error_message;}

	    /*
			LOGIN
	    */
	    function loginClient($email,$password){
	    	$returnValue = true;
	    	$formvars = array();
			$formvars['email'] = $this->Sanitize($email);	
			$qry = "SELECT id_cliente,_password FROM _client WHERE email='".$formvars['email']."'";
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

	    function checkLoginForHeader(){
	        if(!isset($_SESSION)){ session_start(); }
	        $sessionvar = $this->GetLoginSessionVar();
	        if(empty($_SESSION[$sessionvar])){
	            $this->HandleError("Session expiro!");
	            return false;
	        }
	        if(!$this->DBLogin()){
	            $this->HandleError("Database login failed!");
	            return false;
	        }
	        $qry = "SELECT id_cliente,name,id_facebook FROM cliente WHERE id_cliente = " . $_SESSION[$sessionvar];
	        $result = mysql_query($qry,$this->connection);
	        $row = mysql_fetch_array($result);
	        if(mysql_num_rows($result)<=0){
	            $this->HandleError("Error. Datos Incorrectos.");
	            return false;
	        }
	        return array("id_cliente"=>$row['id_cliente'],"name"=>$row['nombre'],'id_facebook'=>$row['id_facebook']);
	    }

	    function checkLoginFacebook(){
	        $id_facebook = $_POST['id_facebook'];
	        $returnValue = true;
	        $this->checkDBLogin();
	        if(!isset($_SESSION)){ session_start(); }
	        $qry = "SELECT id_client,id_facebook FROM client WHERE id_facebook='$id_facebook'";
	        $result = $this->db->selectQuery($qry);
			if(!$result){
				$this->db->HandleError('No login with Facebook');
				$returnValue = false;
			}else{
				if(!$this->db->numRows($result)){
					$returnValue = false;
				}else{
					$row = $this->db->fetchArray($result);
			        $_SESSION[$this->GetLoginSessionVar()] = $row['id_client'];
			        $_SESSION['timeout'] = time();
				}
			}
	       return $returnValue;
	   	}

	    /*
			REGISTER
	    */
	    function insertClient($name,$email,$password,$sex,$id_conekta,$cumple,$telefono){
	    	$returnValue = true;
	    	$this->checkDBLogin();

	    	$formvars = array();
			$formvars['email'] = $this->Sanitize($email);
			$formvars['password'] = password_hash($password, PASSWORD_DEFAULT);
			$formvars['type'] = $this->Sanitize('admin');
			$formvars['sex'] = $this->Sanitize($sex);
			$formvars['conekta'] = $this->Sanitize($id_conekta);
        	$formvars['cumple'] = $this->Sanitize($cumple);
        	$formvars['telefono'] = $this->Sanitize($telefono);	

			// $qry = 'INSERT INTO client (name,email,_password,sex,id_conekta,birthday,phone,date_created)
   //              values(
   //              "' . $formvars['name'] . '",
   //              "' . $formvars['email'] . '",
   //              "' . $formvars['password'] . '",
   //              "' . $formvars['sex'] . '",
   //              "' . $formvars['conekta'] .'",
   //              "'. $formvars['cumple'] .'",
   //              "'. $formvars['telefono'] .'",
   //              NOW())'; 
			// if(!$this->db->insertQuery($qry)){
			// 	$returnValue = false;
			// }
		    $this->db->closeAll();
		    return $returnValue;
	    }

	    /*
	    	
	    	CART

	    */

	    function getCartItems(){
	    	$returnValue = 0;
	        if(!isset($_SESSION)){ session_start(); }
	        if(!isset($_SESSION['cart'])){
	        	$_SESSION['cart'] = array();
	        	$returnValue = count($_SESSION['cart']); 
	        }
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
				$this->HandleError('no products filter');
				$returnValue = false;
			}else{
				$array_data = [];
				while($row = $this->db->fetchArray($result)){
					array_push($tempArray, $row['id_product']);
				}

				if($type != ""){
		            $selectTipo = "SELECT id_product FROM product WHERE type_id_type=".$type;
		            $resultType = mysql_query($selectTipo,$this->connection);
		            $result = $this->db->selectQuery($resultType);
					if(!$result){
						$this->HandleError('no products filter');
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
						$this->HandleError('no products filter');
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
		            $selectBrands = "SELECT id_product FROM products WHERE brand_id_brand=".$brand;
		            $result = $this->db->selectQuery($selectBrands);
					if(!$result){
						$this->HandleError('no products filter');
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
		/*
			PRODUCT
		*/
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