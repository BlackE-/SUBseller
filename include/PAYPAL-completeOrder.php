<?php
	//PayPal REST API endpoints
    $urlHeader = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
	$urlHeader .= $_SERVER['HTTP_HOST'];
	header('Content-Type: application/json');


	require_once "_setup.php";
	require_once "_email.php";
	$set = new Setup();
	$shipping = 0.00;$total = 0.00;$totalRow = 0.00;$subtotal = 0.00;

    $id_paypal = $_POST['id_paypal'];
    //setups
	
		//session
	if(!isset($_SESSION)){session_start();}
	$id_client =  $_SESSION[$set->GetLoginSessionVar()];
	$id_session_client = $_SESSION['id_session_client'];
	$id_shipping = $_SESSION['id_shipping'];
	$id_coupon = 'NULL';
	if(isset($_SESSION['id_coupon'])){//WITH COUPON
		$couponCode = $set->getCoupon($_SESSION['id_session']);
		$couponSetup = $set->checkCouponSetCart($couponCode['code']);
		if(!$couponSetup){//no se actualizo en DB el carrito
			$returnValue['return'] = false;
			$returnValue['message'] = $set->getErrorMessage();
			unset($set);
			echo json_encode($returnValue);
			exit();
		}
		$cart = $couponSetup['products'];
		foreach ($cart as $key => $value){
			$product = $set->getProduct($value['id_product']);
			$pro = $product[0]['product'];
			$proImg = $product[1]['media'];
		    $priceProduct = number_format($value['newPrice'], 2, '.', ',');
		    $price = explode('.', $priceProduct);
		    $priceRowFormat = number_format($value['newPrice'] * $value['number_items'],2,'.',',');
		    $priceRow = explode('.',$priceRowFormat);

		    $table3 .= '<tr style="border-bottom:1px solid #ccc;">';
	        $table3 .= '<td><img style="width:100px;" src="'.$urlHeader.$proImg[0]['url'].'"/></td>';
	        $table3 .= '<td>';
	        $table3 .= '<p style="font-size: 12px;font-weight:800;">'.$pro['name'].'</p>';
	        $table3 .= '<p style="font-size: 12px;">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
	        $table3 .= '</td>';
	        $table3 .= '<td>'.$value['description'].'</td>';
	        $table3 .= '<td><p style="color:#12f9e7;font-size:12px;">$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p></td>';
			$table3 .= "</tr>";
		}
		$table3 .= "</table>";
		$id_coupon = $couponSetup['id_coupon'];
		$total = $couponSetup['total'];
		$subtotal = $couponSetup['subtotal'];
		$shipping = $couponSetup['shipping'];
		$subtotalFormat = number_format($subtotal, 2, '.', ',');
		$subtotalShow = explode('.', $subtotalFormat);
		$deliveryCost = number_format($shipping, 2, '.', '');
		$deliveryShow = explode('.', $deliveryCost);
		$totalLabel = number_format($total, 2, '.', ',');
		$totalShow = explode('.', $totalLabel);
		$couponLabel = 'Coupon:' . $coupon;
	}
	else{
		//paso 1: CREAR TABLE PEDIDO CON CARRITO
		$table3 = '<table style="width:80%;margin:0 auto;background-color: #fff;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;text-align: center;">';
		$cart = $set->getCart();
		foreach ($cart as $key => $value){
			$product = $set->getProduct($value['id_product']);
			$pro = $product[0]['product'];
			$proImg = $product[1]['media'];
			$price_sale = $value['price'];
	        $price = explode('.',$price_sale);
	        $totalRow = $value['price'] * $value['number_items'];
			$totalRowFormat = number_format($totalRow,2,'.',','); 
	        $priceRow = explode('.',$totalRowFormat);
	        $subtotal += $totalRow;

	        $table3 .= '<tr style="border-bottom:1px solid #ccc;">';
	        $table3 .= '<td><img style="width:100px;" src="'.$urlHeader.$proImg[0]['url'].'"/></td>';
	        $table3 .= '<td>';
	        $table3 .= '<p style="font-size: 12px;font-weight:800;">'.$pro['name'].'</p>';
	        $table3 .= '<p style="font-size: 12px;">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
	        $table3 .= '</td>';
	        $table3 .= '<td>'.$value['description'].'</td>';
	        $table3 .= '<td><p style="color:#12f9e7;font-size:12px;">$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p></td>';
			$table3 .= "</tr>";
		}
		$table3 .= "</table>";
		
		$subtotal = $totalRow;
		$subtotalFormat = number_format($subtotal, 2, '.', ',');
		$subtotalShow = explode('.', $subtotalFormat);
		$freeDelivery = $set->getLimitFreeDelivery();
		$total = $subtotal;
		$deliveryCost = number_format(0, 2, '.', '');
        if($subtotal < $freeDelivery ){
        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', '');
        	$total += $deliveryCost;
        }
        $totalLabel = number_format($total, 2, '.', ',');
		$totalShow = explode('.', $totalLabel);
		$deliveryShow = explode('.', $deliveryCost);
		$couponLabel = 'Sin Cupon';
	}

	$table4 = '<table style="width:80%;margin:0 auto;">';	
	$table4 .= '<tr>';	
	$table4 .= '<td align="center"><p><i>'.$couponLabel.'</i></p></td>';	
	$table4 .= '<td align="right">';
	$table4 .= '<p>Subtotal</p>';
	$table4 .= '<p>Costo Envío</p>';
	$table4 .= '<p style="font-size:14px;"><b>Total</b></p>';
	$table4 .= '</td>';
	$table4 .= '<td align="right">';
	$table4 .= '<p>$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p>';
	$table4 .= '<p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p>';
	$table4 .= '<p style="color:#2361f0;font-size:20px;"><b>$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></b></p>';
	$table4 .= '</td>';	
	$table4 .= '</tr>';	
	$table4 .= '</table>';

	//paso 3 ARREGLO DE DETAILS
	$nameClient = $set->getClientName();
	$emailClient = $set->getClientEmail();

	$table1 = '<table style="background:#fff;text-align: center;border:0;width:80%;margin:0 auto;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;"><tr><td><h1>ORDEN DE COMPRA</h1></td></tr><tr><td><p>¡'.$nameClient.' gracias por tu compra!</h5></p></tr></table>';
	$table1Admin = '<table style="background:#fff;text-align: center;border:0;width:80%;margin:0 auto;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;"><tr><td><h1>ORDEN DE COMPRA</h1></td></tr><tr><td><p>'.$nameClient.' a realizado una compra</h5></p></tr></table>';
	$table2 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td><h2>PEDIDO</h2></td></tr></table>';

	//paso 4 ARREGLO shipment
	$shippingAddress = $set->getShipping($id_shipping);
	$table5 = '<table style="width:80%;margin:0 auto;"><tr><td align="center"><h2>DETALLES</h2></td></tr></table>';
	$table6 = '<table style="width:80%;margin:10px auto;">';
	$table6 .= '<tr><td><h2>Dirección de entrega</h2></td></tr>';
	$table6 .= '<tr><td>';
	$table6 .= '<p>'.$shippingAddress['address_line_1'].'</p>';
	$table6 .= '<p>'.$shippingAddress['address_line_2'].'</p>';
	$table6 .= '<p>'.$shippingAddress['cp'].', '.$shippingAddress['city'].'</p>';
	$table6 .= '<p>'.$shippingAddress['country'].', '.$shippingAddress['state'].'</p>';
	$table6 .= '<p>Notas: '.$shippingAddress['notes'].'</p>';
	$table6 .= '</td></tr>';
	$table6 .= '</table>';

	//paso 5: tipo de pago / CREAR orden con conekta
	$cve_order = $set->generateCVEorder();
	$type = 'PayPal';
	$status = 'PROCESSING';
	$table7 = '<table style="width:80%;margin:10px auto;text-align:center;">';
	$table7 .= '<tr><td><h2>Pago</h2></td></tr>';
	$table7 .= '<tr>';
	$table7 .= '<td>';
	$table7 .= '<p>Orden: <b>'.$cve_order.'</b></p>';
	$table7 .= '<p>Tipo de Pago: <span style="text-transform:uppercase;">'.$type.'</span></p>';
	$table7 .= '<p>ORDEN</p>';
	$table7 .= '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$id_paypal.'</b></p>';
	$table7 .= '</td>';
	$table7 .= '</tr>';
	$table7 .= '</table>';

	$table8  = '<table style="width:80%;margin:0 auto;background-color: #fff;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;">';
	$table8 .= '<tr>';
	$table8 .= '<td>';
	$table8 .= $table6;
	$table8 .= '</td>';
	$table8 .= '<td style="vertical-align: top;">';
	$table8 .= $table7;
	$table8 .= '</td>';
	$table8 .= '</tr>';
	$table8 .= '</table>';


	$privacidad = $urlHeader.'/aviso-de-privacidad.pdf';
	$terminos = $urlHeader.'/TERMINOSYCONDICIONES.pdf';
	$table9  = '<table style="width:80%;margin:0 auto;text-align:center;">';
	$table9 .= '<tr>';
	$table9 .= '<td>';
	$table9 .= '<p style="font-size:12px;">Tu pedido se entrega de 3 a 7 días hábiles a partir de que se refleje tu pago, el pago toma de 24 a 48 horas en reflejarse.</p>';
	$table9 .= '<p style="font-size:10px;"><a href="'.$privacidad.'">Aviso de Privacidad</a></p>';
	$table9 .= '<p style="font-size:10px;"><a href="'.$terminos.'">Términos y Condiciones</a></p>';
	$table9 .= '</td>';
	$table9 .= '</tr>';
	$table9 .= '</table>';

	$table9Admin  = '<table style="width:80%;margin:0 auto;text-align:center;">';
	$table9Admin .= '<tr>';
	$table9Admin .= '<td>';
	$table9Admin .= '<p style="font-size:12px;">En caso de que el cliente solicite factura, se enviara un nuevo correo con los datos.</p>';
	$table9Admin .= '<p style="font-size:12px;">Toda la información del pedido se puede ver desde el administrador.</p>';
	$table9Admin .= '</td>';
	$table9Admin .= '</tr>';
	$table9Admin .= '</table>';


	$logo = $set->getWebsiteSetting('website_logo');
	$table0 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td align="center"><div style="margin:0 auto;width:230px;height:100px;padding:10px;">'.$logo.'</td></tr></table>';


	$table10 = '<table style="width:100%;background:#f1f3f5;padding:20px;">';
	$table10 .= '<tr><td>'.$table0.'</td></tr>';
	$table10 .= '<tr><td>'.$table1.'</td></tr>';
	$table10 .= '<tr><td>'.$table2.'</td></tr>';
	$table10 .= '<tr><td>'.$table3.'</td></tr>';
	$table10 .= '<tr><td>'.$table4.'</td></tr>';
	$table10 .= '<tr><td>'.$table5.'</td></tr>';
	$table10 .= '<tr><td>'.$table8.'</td></tr>';
	$table10 .= '<tr><td>'.$table9.'</td></tr>';
	$table10 .= '</table>';

	$table10Admin = '<table style="width:100%;background:#f1f3f5;padding:20px;">';
	$table10Admin .= '<tr><td>'.$table0.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table1Admin.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table2.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table3.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table4.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table5.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table8.'</td></tr>';
	$table10Admin .= '<tr><td>'.$table9Admin.'</td></tr>';
	$table10Admin .= '</table>';


	//PASO 6: guardar DATA en DB
	$id_chargeConekta = '';
	$transaction_code = $id_paypal;
	$id_order = $set->insertOrder($status,$total,$shipping,$cve_order,$id_client,$id_shipping,$id_coupon,$type,$id_chargeConekta,$transaction_code,$id_session_client);
	if(!$id_order){
		$returnValue['return'] = 'undefined';
		$returnValue['message'] = 'El pedido no pudo ser guardado, pero la orden ya fue emitida, nos comunicaremos con usted para confirmar el pedido';
		unset($set);
		echo json_encode($returnValue);
		exit();
	}

	foreach ($cart as $key => $value){
		$set->updateInventory($value['id_product'],$value['number_items']);
	}

	//PASO CREAR Y ENVIAR CORREO A CLIENTE
	$fromEmail = $set->getWebsiteSetting('from_email');
	$website_title = $set->getWebsiteSetting('website_title');
	$subject = 'Orden de Compra en '.$website_title;

	$email = new Email();
	$email->setTo($emailClient);
	$email->setFrom($fromEmail);
	$email->setFromName($website_title);
	$email->setSubject($subject);
	$email->setMessage($table10);

	$sendEmail = $email->sendEmail();
	$message = $email->error_message; //si es TRUE el mensaje es 'EMAIL ENVIADO'

	$contactoEmail = $set->getWebsiteSetting('contacto_email');
	$emailAdmin = new Email();
	$emailAdmin->setTo($contactoEmail);
	$emailAdmin->setFrom($fromEmail);
	$emailAdmin->setFromName($website_title);
	$emailAdmin->setSubject($subject);
	$emailAdmin->setMessage($table10Admin);

	$sendEmail = $emailAdmin->sendEmail();
	$message = $emailAdmin->error_message; //si es TRUE el mensaje es 'EMAIL ENVIADO'

	$returnValue['return'] = $id_order;
	$returnValue['message'] = $message;
	unset($set);
	echo json_encode($returnValue);
	exit();

?>