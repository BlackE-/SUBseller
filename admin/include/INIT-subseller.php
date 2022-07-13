<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	$all = $_POST;
	$status = false;

	if(isset($all) && !empty($all) ){
		$status = true;

		$myfile = fopen("setup.ini", "w") or die("Unable to open file!");
		$txt = 'host='.$all['host'].';'.PHP_EOL;
		$txt .= 'database='.$all['database'].';'.PHP_EOL;
		$txt .= 'username='.$all['username'].';'.PHP_EOL;
		$txt .= 'pwd='.$all['password'].';';
		

		fwrite($myfile, $txt);
		fclose($myfile);

	}

	//JSON RETURN
	$json_return = array(
		"return" => $status,
		"msg" => "SETUP is set",
		'data' => $all
	);
	echo json_encode($json_return);
?>