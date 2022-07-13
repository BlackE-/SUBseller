<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	$cart = $set->getCart();
	$path = '/subseller';
	$nameClient = $set->getClientName();
	$type = 'card';
	$clabe = '646180111812345678';
	$referncia = '123456789012';
	$coupon = 'Sin cupon';
	$cve_order = $set->generateCVEorder();
	$cardlast4  = '0045';
	$cardType = 'Credit';

	$urlHeader = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
	$urlHeader .= $_SERVER['HTTP_HOST'];
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		require_once('header_meta.php');
	?>
</head>
<body>
	<?php include('header.php');?>
		

	<?php
		$table1 = '<table style="background:#fff;text-align: center;border:0;width:80%;margin:0 auto;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;"><tr><td><h1>ORDEN DE COMPRA</h1></td></tr><tr><td><p>¡'.$nameClient.' gracias por tu compra!</h5></p></tr></table>';
		$table2 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td><h2>PEDIDO</h2></td></tr></table>';
		$table3 = '<table style="width:80%;margin:0 auto;background-color: #fff;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;text-align: center;">';
		$totalRows = 0;
		foreach ($cart as $key => $value) {
			$product = $set->getProduct($value['id_product']);
			$pro = $product[0]['product'];
			$proImg = $product[1]['media'];
			$price_sale = $value['price'];
            $price = explode('.',$price_sale);
            $totalRow = $value['price'] * $value['number_items'];
			$totalRowFormat = number_format($totalRow,2,'.',','); 
            $priceRow = explode('.',$totalRowFormat);
            $totalRows += $totalRow;

            $table3 .= '<tr style="border-bottom:1px solid #ccc;">';
            $table3 .= '<td><img style="width:100px;" src="'.$urlHeader.$path.$proImg[0]['url'].'"/></td>';
            $table3 .= '<td>';
            $table3 .= '<p style="font-size: 12px;font-weight:800;">'.$pro['name'].'</p>';
            $table3 .= '<p style="font-size: 12px;">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
            $table3 .= '</td>';
            $table3 .= '<td><p style="color:#12f9e7;font-size:12px;">$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p></td>';
			$table3 .= "</tr>";
		}
		$table3 .= "</table>";



		$subtotal = $totalRows;
		$subtotalFormat = number_format($subtotal, 2, '.', ',');
		$subtotalShow = explode('.', $subtotalFormat);
		$freeDelivery = $set->getLimitFreeDelivery();
		$total = $subtotal;
		$deliveryCost = number_format(0, 2, '.', '');
        if($subtotal < $freeDelivery ){
        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', '');
        	$total += $deliveryCost;
        }
        $total = number_format($total, 2, '.', ',');
		$totalShow = explode('.', $total);
		$deliveryShow = explode('.', $deliveryCost);

		$table4 = '<table style="width:80%;margin:0 auto;">';	
		$table4 .= '<tr>';	
		$table4 .= '<td align="center"><p><i>'.$coupon.'</i></p></td>';	
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

		$table5 = '<table style="width:80%;margin:0 auto;"><tr><td align="center"><h2>DETALLES</h2></td></tr></table>';

		$id_shipping = $_SESSION['id_shipping'];
		$shipping = $set->getShipping($id_shipping);
		$table6 = '<table style="width:80%;margin:10px auto;">';
		$table6 .= '<tr><td><h2>Dirección de entrega</h2></td></tr>';
		$table6 .= '<tr><td>';
		$table6 .= '<p>'.$shipping['address_line_1'].'</p>';
		$table6 .= '<p>'.$shipping['address_line_2'].'</p>';
		$table6 .= '<p>'.$shipping['cp'].', '.$shipping['city'].'</p>';
		$table6 .= '<p>'.$shipping['country'].', '.$shipping['state'].'</p>';
		$table6 .= '<p>Notas: '.$shipping['notes'].'</p>';
		$table6 .= '</td></tr>';
		$table6 .= '</table>';


		$table7 = '<table style="width:80%;margin:10px auto;text-align:center;">';
		$table7 .= '<tr><td><h2>Pago</h2></td></tr>';
		$table7 .= '<tr>';
		$table7 .= '<td>';
		$table7 .= '<p>Orden: <b>'.$cve_order.'</b></p>';
		$table7 .= '<p>Tipo de Pago: <span style="text-transform:uppercase;">'.$type.'</span></p>';
		switch ($type) {
			case 'spei':
				$table7 .= '<p>CABLE</p>';
				$table7 .= '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$clabe.'</b></p>';
				break;
			case 'oxxo':
				$table7 .= '<p>REFERENCIA</p>';
				$table7 .= '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$referncia.'</b></p>';
				$table7 .= '<p>Tienes un plazo de 2 días para realizar tu pago.</p>';
				break;
			case 'card':
				$table7 .= '<p>Tarjeta</p>';
				$table7 .= '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$cardlast4.'-'.$cardType.'</b></p>';
				$table7 .= '<p>La información de su tarjeta es manejada por Conekta</p>';
				break;
		}
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


		$table10 = '<table style="width:100%;background:#f1f3f5;padding:20px;">';
		$table10 .= '<tr><td>'.$table1.'</td></tr>';
		$table10 .= '<tr><td>'.$table2.'</td></tr>';
		$table10 .= '<tr><td>'.$table3.'</td></tr>';
		$table10 .= '<tr><td>'.$table4.'</td></tr>';
		$table10 .= '<tr><td>'.$table5.'</td></tr>';
		$table10 .= '<tr><td>'.$table8.'</td></tr>';
		$table10 .= '<tr><td>'.$table9.'</td></tr>';
		$table10 .= '</table>';
		
		echo $table10;

	?>


	

</body>
</html>