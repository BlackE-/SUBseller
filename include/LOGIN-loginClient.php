<?php
	require_once "_setup.php";
	$set = new Setup();
	$returnValue = true;

	//DATA POST
	$email = $_POST['email'];
	$password = $_POST['password'];

	//EVALUAR SI EL EMAIL YA FUE REGISTRADO
	$loginClient = $set->loginClient($email,$password);
	if(!$loginClient){//if return false means the email is not on DB
	    $returnValue = false;
	}	

	header("Content-Type: application/json; charset=utf-8", true);
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	echo json_encode($json_return);
?>