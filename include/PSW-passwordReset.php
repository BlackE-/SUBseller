<?php
	require_once "_setup.php";
	require_once "_email.php";
	$set = new Setup();
	$returnValue = $set->passwordReset();

	$message = '';
	if(is_array($returnValue)){
			//array is for send email
			$email = new Email();
			$email->setTo($returnValue['to']);
			$email->setFrom($returnValue['from']);
			$email->setFromName('FROM');
			$email->setSubject($returnValue['subject']);
			$email->setMessage($returnValue['message']);

			$returnValue = $email->sendEmail();
			$message = $email->error_message;
	}else{
		$message = $set->getErrorMessage();
	}

	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $message;
	unset($set);
	echo json_encode($json_return);
?>