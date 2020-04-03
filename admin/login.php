<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<?php
			include('header_meta.php');
		?>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
<body>   
    <div class="container" id="loginContainer">
    	<img class="logo" src="../img/subseller.svg">
        <form class="loginForm" id="loginForm">
        	<p class="topRegister"><b>INICIAR SESIÓN</b></p>
        	<div class="row">
        	    <input type="email" name="email" placeholder="Email" />
        	</div>
        	<div class="row">
        		<input type="password" name="pass" placeholder="Contraseña" />
        	</div>
        	<div class="row">
        		<input type="submit" class="submitLogin" value="INICIAR SESIÓN">
        		<p class="forgot"><a href="recoverPassword.php"><i>Olvidé mi contraseña</i></a></p>
        	</div>
        	<div class="error" id="error"></div>
    	</form>
	</div>

	<?php include("modal.php");?> 
	
    <?php include("footer.php");?>
		<script src="script/login.js"></script>
	</body>
</html>