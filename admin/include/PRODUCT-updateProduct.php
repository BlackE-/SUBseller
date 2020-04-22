<?php
	require_once "setup.php";
	$set = new Setup();
	$returnValue = false;
	$returnValue = $set->updateProduct();
	
	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>