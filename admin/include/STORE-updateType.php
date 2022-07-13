<?php
	require_once "setup.php";
	$set = new Setup();
	
	$all = $_POST;
	$returnValue = false;
	$returnData = '';

	if(isset($all)){
		if($set->updateType($all['id_type'],$all['type_name'],$all['type_status'])){
			$returnValue = true;
		}
	}


	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);
?>