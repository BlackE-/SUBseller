<?php
	require_once dirname(__FILE__) . '/include/db.php';
	require_once dirname(__FILE__) . '/include/setup.php';
	$db = new DB();
	$set = new Setup($db);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include('header_meta.php');?>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body>
	    <div class="container" id="registerContainer">
	    	<h1><?php echo $site_name;?></h1>
	        <img class="logo" src="<?php echo $logo?>">
	        <form class="loginForm" id="form1">
	        	<p class="topRegister"><b>REGISTRO</b></p>
	        	<div class="row">
	        	    <input type="email" name="email" placeholder="email@gmail.com" required/>
	        	</div>
	        	<div class="row">
	        		<input type="password" name="pass1" placeholder="Minimo 5 letras y un número" required/>
	        	</div>
	        	<div class="row">
	        		<input type="submit" class="submitLogin" value="REGISTER">
	        		<p class="forgot"><a href="recoverPassword.php"><i>Olvidé mi contraseña</i></a></p>
	        	</div>
	        	<div class="error"></div>
	    	</form>
		</div>

		<?php include("modal.php");?> 
		
	    <?php include("footer.php");?>  
			<script src="script/register.js"></script>
	</body>
</html>
