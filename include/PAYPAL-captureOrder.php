<?php
	//PayPal REST API endpoints
   	define("SANDBOX_ENDPOINT", "https://api.sandbox.paypal.com/");
    define("LIVE_ENDPOINT", "https://api.paypal.com/");
    $urlHeader = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
	$urlHeader .= $_SERVER['HTTP_HOST'];
	header('Content-Type: application/json');

	require_once "_setup.php";
	require_once "_curl.php";
	$set = new Setup();
	$curl = new Curl();
	$path = '/subseller';	
	$shipping = 0.00;$total = 0.00;$totalRow = 0.00;$subtotal = 0.00;

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

    $id_order = $_GET['id_order'];
	
	$str_public = 'paypal_key_public_'.$status;
	$str_private = 'paypal_key_private_'.$status;
	$paypal_client_id = $set->getWebsiteSetting($str_public);
	$paypal_secret_id = $set->getWebsiteSetting($str_private);


	//GET ACCESS TOKEN
	if(!isset($_SESSION)){session_start();}
	if(!isset($_SESSION['access_token'])){
		$urlAccessToken = $url.'v1/oauth2/token';
		$access_token = $curl->getAccessToken($urlAccessToken,$paypal_client_id,$paypal_secret_id);
		if(array_key_exists("error",$access_token)){	//si la llave ERROR esta en el ARRAY no hubo token
			$returnValue['statusCode'] = '401';
			$returnValue['resp'] = $access_token['error'];
			unset($set);
			echo json_encode($returnValue);
			exit();
		}
		$_SESSION['access_token'] = $access_token['access_token'];
	}


	// //Capture ORDER
	// $id_order = $_SESSION['order_id']
	$urlCaptureOrder = $url.'v2/checkout/orders/'.$id_order.'/capture';
	$createOrder = $curl->captureOrder($_SESSION['access_token'],$urlCaptureOrder);
	$returnValue = $createOrder;	
	unset($set);
	echo json_encode($returnValue);
	exit();

?>