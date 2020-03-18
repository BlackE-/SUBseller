<?php
	require_once "db.php";
	require_once "setup.php";

	$db = new DB();
	$set = new Setup($db);
	
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