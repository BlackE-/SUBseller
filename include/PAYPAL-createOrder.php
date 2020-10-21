<?php
	//PayPal REST API endpoints
   	define("SANDBOX_ENDPOINT", "https://api.sandbox.paypal.com/");
    define("LIVE_ENDPOINT", "https://api.paypal.com/");
    $urlHeader = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
	$urlHeader .= $_SERVER['HTTP_HOST'];
	header('Content-Type: application/json');

	require_once "_setup.php";
	require_once "_email.php";
	require_once "_curl.php";
	$set = new Setup();
	$curl = new Curl();
	$path = '/subseller';	
	$shipping = 0.00;$total = 0.00;$totalRow = 0.00;$subtotal = 0.00;
	$website_title = $set->getWebsiteSetting('website_title');

    //Merchant ID
    $merchant_id = $set->getWebsiteSetting('paypal_merchand_id');
    $status = $set->getWebsiteSetting('paypal_status');
    switch ($status) {
    	case 'dev':
    		$url = SANDBOX_ENDPOINT;
    		break;
    	case 'prod':
    		$url = LIVE_ENDPOINT;
    		break;
    }
	
	$str_public = 'paypal_key_public_'.$status;
	$str_private = 'paypal_key_private_'.$status;
	$paypal_client_id = $set->getWebsiteSetting($str_public);
	$paypal_secret_id = $set->getWebsiteSetting($str_private);


	//GET ACCESS TOKEN
	$urlAccessToken = $url.'v1/oauth2/token';
	$access_token = $curl->getAccessToken($urlAccessToken,$paypal_client_id,$paypal_secret_id);
	if(array_key_exists("error",$access_token)){	//si la llave ERROR esta en el ARRAY no hubo token
		$returnValue['statusCode'] = '401';
		$returnValue['resp'] = $access_token['error'];
		unset($set);
		echo json_encode($returnValue);
		exit();
	}
	else{//GET CART
		if(!isset($_SESSION)){session_start();}
		$items = '';
		if(isset($_SESSION['id_coupon'])){//WITH COUPON
			$couponCode = $set->checkCouponForPaypal($_SESSION['id_session']);
			if(!$couponSetup){//no se actualizo en DB el carrito
				$returnValue['return'] = false;
				$returnValue['message'] = $set->getErrorMessage();
				unset($set);
				echo json_encode($returnValue);
				exit();
			}
			$cart = $couponSetup['products'];
			$last_array_value = end($cart);
			foreach ($cart as $key => $value) {
				$product = $set->getProduct($value['id_product']);
				$pro = $product[0]['product'];

			    $items .= '{';
				$items .= 	'"name":"'.$pro['name'].'",';
				$items .= 	'"sku":"'.$pro['sku'].'",';
				$items .= 	'"unit_amount":{';
				$items .= 			'"currency_code":"MXN",';
				$items .= 			'"value":"'.$value['newPrice'].'"';
				$items .=	'},';
				$items .= 	'"quantity":"'.$value['number_items'].'"';
				// if ($key === array_key_last($cart)){$items .= '}';}
				if ($value === $last_array_value) {$items .= '}';}
				else{$items .= '},';}
			}
			$total = $couponSetup['total'];
			$subtotal = $couponSetup['subtotal'];
			$shipping = $couponSetup['shipping'];
		}	
		else{
			//sin coupon
			$cart = $set->getCart();
			$last_array_value = end($cart);
			foreach ($cart as $key => $value) {
				$product = $set->getProduct($value['id_product']);
				$pro = $product[0]['product'];
				$price_sale = $value['price'];
		        $totalRow = $value['price'] * $value['number_items'];

				$items .= '{';
				$items .= 	'"name":"'.$pro['name'].'",';
				$items .= 	'"sku":"'.$pro['sku'].'",';
				$items .= 	'"unit_amount":{';
				$items .= 			'"currency_code":"MXN",';
				$items .= 			'"value":"'.$value['price'].'"';
				$items .=	'},';
				$items .= 	'"quantity":"'.$value['number_items'].'"';
				// if ($key === array_key_last($cart)){$items .= '}';}
				if ($value === $last_array_value) {$items .= '}';}
				else{$items .= '},';}

			   $subtotal += $totalRow;
			}
			$freeDelivery = $set->getLimitFreeDelivery();
			$total = $subtotal;
			$shipping = 0;
	        if($subtotal < $freeDelivery ){
	        	$total+= $set->getDeliveryCost();
	        	$shipping = $set->getDeliveryCost();
	        }
	    }
		$id_shipping = $_SESSION['id_shipping'];
		$shippingAddress = $set->getShipping($id_shipping);
		$address = '{
	                    "address_line_1": "'.$shippingAddress['address_line_1'].'",
	                    "address_line_2": "'.$shippingAddress['address_line_2'].'",
	                    "admin_area_2": "'.$shippingAddress['city'].'",
	                    "admin_area_1": "'.$shippingAddress['state'].'",
	                    "postal_code": "'.$shippingAddress['cp'].'",
	                    "country_code": "MX"
			        }';		
		$nameClient = $set->getClientName();


		$postData = '{
					  	"intent": "CAPTURE",
					  	"application_context": {
				            "shipping_preference": "SET_PROVIDED_ADDRESS"
				        },
					  	"purchase_units": [{
					    	"amount": {
					        	"currency_code": "MXN",
					        	"value": "'.$total.'",
					        	"breakdown":{
					        		"item_total":{
					        			"currency_code":"MXN",
					        			"value":"'.$subtotal.'"
					        		},
					        		"shipping":{
							  			"currency_code":"MXN",
							  			"value":"'.$shipping.'"
							  		}
					        	}
					      	},
					      	"items":['.$items.'],
					      	"shipping": {
					      		"name": {
                        			"full_name":"'.$nameClient.'"
                    			},
			                    "address": '.$address.'
			                }
					    }]
					}';

		// //CREATE ORDER https://github.com/paypal/Checkout-NodeJS-SDK/blob/master/samples/CaptureIntentExamples/createOrder.js
		$urlCreateOrder = $url.'v2/checkout/orders';
		$createOrder = $curl->createOrder($access_token['access_token'],$urlCreateOrder,$postData);
		//if(!in_array("ERROR", $createOrder)){
		//	$_SESSION['order_id'] = $createOrder['access_token'];
		//}
		$returnValue = $createOrder;
		unset($set);
		echo json_encode($returnValue);
		exit();
	}
?>