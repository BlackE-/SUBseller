<?php
	// http://localhostlocalhost/subseller/pswnew?email=elizabeth@studio-sub.com
	require_once "_setup.php";
	$set = new Setup();
	$returnValue = $set->passwordNew();

	//JSON RETURN
	header('Content-Type: application/json');
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	unset($set);
	echo json_encode($json_return);

?>