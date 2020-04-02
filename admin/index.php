<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$checkDBLogin = $set->checkDBLogin();
	if(!$checkDBLogin['return']){
		header("Location: init.php"); 
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<style type="text/css">
		body{font-family: sans-serif;}
		
	</style>
</head>
<body>
	<?php include('header.php');?>
	<?php include('sidebar.php');?>


	<?php include('footer.php');?>
</body>
</html>