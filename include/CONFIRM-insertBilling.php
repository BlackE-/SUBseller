<?php
	require_once "_setup.php";
	require_once "_email.php";
	$set = new Setup();
	$returnValue = $set->insertBilling();
	if(!$returnValue){

	}else{
		//PASO CREAR Y ENVIAR CORREO A CLIENTE
		$billing = $set->getBilling($returnValue['id_billing']);
		$fromEmail = $set->getWebsiteSetting('from_email');
		$website_title = $set->getWebsiteSetting('website_title');
		$subject = 'Factura de pedido:'.$returnValue['id_order'].' en'.$website_title;
		$contactoEmail = $set->getWebsiteSetting('contacto_email');


		$table0 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td align="center"><div style="margin:0 auto;width:230px;height:100px;padding:10px;">'.$logo.'</td></tr></table>';
		$table1 = '<table style="background:#fff;text-align: center;border:0;width:80%;margin:0 auto;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;"><tr><td><h1>SOLICITUD DE FACTURA</h1></td></tr><tr><td></tr></table>';
		$table2 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td><h2>PEDIDO: '.$order['cve_order'].'</h2></td></tr></table>';

		$table6 = '<table style="width:80%;margin:10px auto;vertical-align:top;">';
		$table6 .= '<tr><td><h2>Datos de facturación</h2></td></tr>';
		$table6 .= '<tr style="border-bottom:1px solid #eff4ff">';
		$table6 .= '<td><p>RFC</p></td>';
		$table6 .= '<td><p>'.$billing['rfc'].'</p></td>';
		$table6 .= '</tr>';
		$table6 .= '<tr>';
		$table6 .= '<tr style="border-bottom:1px solid #eff4ff">';
		$table6 .= '<td><p>Razon Social</p></td>';
		$table6 .= '<td><p>'.$billing['razon_social'].'</p></td>';
		$table6 .= '</tr>';
		$table6 .= '<tr style="border-bottom:1px solid #eff4ff">';
		$table6 .= '<td><p>Email</p></td>';
		$table6 .= '<td><p>'.$billing['email'].'</p></td>';
		$table6 .= '</tr>';
		$table6 .= '<tr style="border-bottom:1px solid #eff4ff">';
		$table6 .= '<td><p>CFDI</p></td>';
		$table6 .= '<td><p>'.$billing['cfdi'].'</p></td>';
		$table6 .= '</tr>';
		$table6 .= '<tr style="border-bottom:1px solid #eff4ff">';
		$table6 .= '<td style="vertical-align: top;"><p>Dirección:</p></td>';
		$table6 .= '<td>';
		$table6 .= '<p>'.$billing['address_line_1'].'</p>';
		$table6 .= '<p>'.$billing['address_line_2'].'</p>';
		$table6 .= '<p>'.$billing['cp'].', '.$billing['city'].'</p>';
		$table6 .= '<p>'.$billing['country'].', '.$billing['state'].'</p>';
		$table6 .= '</td></tr>';
		$table6 .= '</table>';

		$table8  = '<table style="width:80%;margin:0 auto;background-color: #fff;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;">';
		$table8 .= '<tr>';
		$table8 .= '<td>';
		$table8 .= $table6;
		$table8 .= '</td>';
		$table8 .= '</tr>';
		$table8 .= '</table>';

		$table9  = '<table style="width:80%;margin:0 auto;text-align:center;">';
		$table9 .= '<tr>';
		$table9 .= '<td>';
		$table9 .= '<p style="font-size:12px;">Toda la información del pedido se puede ver desde el administrador.</p>';
		$table9 .= '</td>';
		$table9 .= '</tr>';
		$table9 .= '</table>';


		$table10 = '<table style="width:100%;background:#f1f3f5;padding:20px;">';
		$table10 .= '<tr><td>'.$table0.'</td></tr>';
		$table10 .= '<tr><td>'.$table1.'</td></tr>';
		$table10 .= '<tr><td>'.$table2.'</td></tr>';
		$table10 .= '<tr><td>'.$table8.'</td></tr>';
		$table10 .= '<tr><td>'.$table9.'</td></tr>';
		$table10 .= '</table>';


		$emailAdmin = new Email();
		$emailAdmin->setTo($contactoEmail);
		$emailAdmin->setFrom($fromEmail);
		$emailAdmin->setFromName($website_title);
		$emailAdmin->setSubject($subject);
		$emailAdmin->setMessage($table10Admin);

		$sendEmail = $emailAdmin->sendEmail();
		$message = $emailAdmin->error_message; //si es TRUE el mensaje es 'EMAIL ENVIADO'

	}
	
	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>