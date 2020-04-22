<?php
	require_once "setup.php";
	$set = new Setup();
	$all = $_POST;
	$returnValue = false;
	$returnValue = $set->deleteMedia($all['id_media'],$all['id_product']);
	
	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>