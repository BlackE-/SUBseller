<?php
	require_once "setup.php";
	$set = new Setup();
	$set->checkDBLogin();
	$all = $_POST;
	$returnValue = true;
	$returnData = '';

	if(isset($all['email']) && isset($all['password'])){
		$returnValue = true;
		if(!$set->registerAdmin($all['email'],$all['password'])){
			$returnValue = false;
		}
	}

	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	// $json_return['data'] = $all;
	$json_return['message'] = $set->getErrorMessage();
	echo json_encode($json_return);
?>