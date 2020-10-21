<?php
	require_once "setup.php";
	$set = new Setup();
	
	$all = $_POST;
	$returnValue = false;

	$returnValue = $all;
	if(isset($all)){
		$products = explode(',', $_POST['products']);
		$discount = $_POST['discount'];
		foreach ($products as $key => $value) {
			$returnValue = $set->setDiscount($value,$discount);	
		}
	}


	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>