<?php
	/*
		REGISTER ANOTHER _USER
	*/
	require_once "setup.php";
	$set = new Setup();
	$set->checkDBLogin();
	$all = $_POST;
	$returnValue = true;

	if(isset($all['email']) && isset($all['password'])){
		if(!$set->register_user($all['email'],$all['password'])){
			$returnValue = false;
		}
	}

	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>