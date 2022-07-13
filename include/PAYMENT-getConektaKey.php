<?php
	require_once "_setup.php";
	$set = new Setup();
	$status = $set->getWebsiteSetting('conekta_status');
	$str = 'conekta_key_public_'.$status;
	$returnValue = $set->getWebsiteSetting($str);

	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>