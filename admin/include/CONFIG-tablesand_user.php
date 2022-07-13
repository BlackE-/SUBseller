<?php
	/*
		CREATE tables in DB
		&
		FIRST TIME REGISTER user
	*/
	require_once "setup.php";
	$set = new Setup();
	$set->checkDBLogin();
	$all = $_POST;
	$returnValue = true;

	if(isset($all['email']) && isset($all['password'])){
		if(!$set->createTablesAndRegisterAdmin($all['email'],$all['password'])){
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