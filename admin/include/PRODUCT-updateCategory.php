<?php
	require_once "setup.php";
	$set = new Setup();
	$returnValue = false;
	$all = $_POST;
	$returnValue = $set->updateCategoryProduct($all['id_product'],$all['id_category'],$all['type']);
	
	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>