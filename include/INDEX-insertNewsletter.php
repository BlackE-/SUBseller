<?php
	require_once "_setup.php";
	require_once "_email.php";
	$set = new Setup();
	$returnValue = true;

	//mailchimp
	require_once('mailchimp-api/src/MailChimp.php');

	//DATA POST
	$email = $_POST['email'];
	//EVALUAR SI EL EMAIL YA FUE REGISTRADO
	
	$mailchimp_key = $set->getMailchimpKey();
	$mailchimp_id_list = $set->getMailchimpList();
	$MailChimp = new MailChimp($mailchimp_key); 
    
    $result = $MailChimp->post("lists/$mailchimp_id_list/members", [
				'email_address' => $email,
				'status'        => 'subscribed',
			]);	
    if (!$MailChimp->success()) {
    	$returnValue = false;
    	$set->setErrorMessage('No se guardo cliente en mailchimp');   
    }
	
	
	$urlHeader = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
	$urlHeader .= $_SERVER['HTTP_HOST'];
	$website_title = $set->getWebsiteSetting('website_title');
	$website_url = $set->getWebsiteSetting('website_url');
	$fromEmail = $set->getWebsiteSetting('from_email');
	$subject = 'Inscripción newsletter de '.$website_title;
	$contactoEmail = $set->getWebsiteSetting('contacto_email');



	$table0 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;"><tr><td align="center"><div style="margin:0 auto;width:230px;height:100px;padding:10px;"><img width="230" height="100" src="https://mislendecon.com/img/misdec_logo.jpg"></td></tr></table>';
	$table1 = '<table style="background:#fff;text-align: center;border:0;width:80%;margin:0 auto;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;"><tr><td><h1>¡BIENVENIDO!</h1></td></tr></table>';
	$table2 = '<table style="border:0;width:80%;margin:0 auto;text-align: center;">';
	$table2 .= '<tr><td><p>Gracias por inscribirte a nuestro newsletter.<br>Espera futuras ofertas.</p></td></tr>';
	$table2 .= '<tr><td><a href="'.$website_url.'"><button style="background: #2361f0;outline:none;border: 0;color: #fff;padding: 15px 50px;    margin: 15px 0 30px 0;border-radius:50px;-webkit-box-shadow: 0px 2px 2px 0px #616060;-moz-box-shadow: 0px 2px 2px 0px #616060;box-shadow: 0px 2px 2px 0px #616060;">'.$website_title.'</button></a></td></tr>';
	$table2 .= '</table>';
	$table3 = '<table style="width:80%;margin:0 auto;background-color: #fff;border-radius: 4px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.03);border: solid 1px #dee5ec;text-align: center;">';
	// $privacidad = $urlHeader.'/aviso-de-privacidad.pdf';
	// $terminos = $urlHeader.'/TERMINOSYCONDICIONES.pdf';
	$table9  = '<table style="width:80%;margin:0 auto;text-align:center;">';
	$table9 .= '<tr>';
	$table9 .= '<td>';
	$table9 .= '<p style="font-size:12px;"></p>';
	// $table9 .= '<p style="font-size:10px;"><a href="'.$privacidad.'">Aviso de Privacidad</a></p>';
	// $table9 .= '<p style="font-size:10px;"><a href="'.$terminos.'">Términos y Condiciones</a></p>';
	$table9 .= '<p style="font-size:10px;color:#ccc;"><a href="https://mislendecon.us10.list-manage.com/unsubscribe?u=663b1a7602f4e1e70b10c69df&id=194c373fa8">Unsubscribe</a></p>';
	$table9 .= '</td>';
	$table9 .= '</tr>';
	$table9 .= '</table>';


	$table10 = '<table style="width:100%;background:#f1f3f5;padding:20px;">';
	$table10 .= '<tr><td>'.$table0.'</td></tr>';
	$table10 .= '<tr><td>'.$table1.'</td></tr>';
	$table10 .= '<tr><td>'.$table2.'</td></tr>';
	$table10 .= '<tr><td>'.$table3.'</td></tr>';
	$table10 .= '<tr><td>'.$table9.'</td></tr>';
	$table10 .= '</table>';

	$emailAdmin = new Email();
	$emailAdmin->setTo($email);
	$emailAdmin->setFrom($fromEmail);
	$emailAdmin->setFromName($website_title);
	$emailAdmin->setSubject($subject);
	$emailAdmin->setMessage($table10);

	$sendEmail = $emailAdmin->sendEmail();
	$message = $emailAdmin->error_message;

	header("Content-Type: application/json; charset=utf-8", true);
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	echo json_encode($json_return);
?>