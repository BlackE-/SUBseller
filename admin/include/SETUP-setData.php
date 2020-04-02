<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	// require_once "setup.php";
	// $set = new Setup();
	
	$all = $_POST;
	$returnValue = false;
	$returnData = '';

	if(isset($all)){

		$returnData = $set->setConfigData($all);
		if($returnData['return']){
			$returnValue = true;
		}else{
			$json_return['errorMessage'] = $returnData['errorMessage'];
		}

	}
	$db->closeAll();


	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	echo json_encode($json_return);
?>