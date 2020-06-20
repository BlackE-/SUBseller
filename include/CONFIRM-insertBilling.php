<?php
	require_once "_setup.php";
	require_once "_email.php";
	$set = new Setup();
	$returnValue = $set->insertBilling();
	if(!$returnValue){

	}else{
		//PASO CREAR Y ENVIAR CORREO A CLIENTE
		// $billing = $set->getBilling($returnValue['id_billing']);
		// $fromEmail = $set->getWebsiteSetting('from_email');
		// $website_title = $set->getWebsiteSetting('website_title');
		// $subject = 'Información Factura de pedido:'.$returnValue['id_order'].' en'.$website_title;

		// $email = new Email();
		// $email->setTo($emailClient);
		// $email->setFrom($fromEmail);
		// $email->setFromName($website_title);
		// $email->setSubject($subject);
		// $email->setMessage($table);

		// $sendEmail = $email->sendEmail();
		// $message = $email->error_message; //si es TRUE el mensaje es 'EMAIL ENVIADO'

	}
	
	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>