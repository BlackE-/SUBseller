<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$checkDBLogin = $set->checkDBLogin();
	if(!$checkDBLogin['return']){
		header('Location: init.php');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body>
	    <div class="container" id="registerContainer">
	    	<h1>Bienvenido a SUBcommerce</h1>
	    	<img class="logo" src="../img/subseller.svg">
	        <form class="loginForm" id="form1">
	        	<p class="topRegister"><b>REGISTRO</b></p>
	        	<p class="topRegister">Para continuar crea tu usuario</p>
	        	<div class="row">
	        	    <input type="email" name="email" placeholder="email@gmail.com" required/>
	        	</div>
	        	<div class="row">
	        		<input type="password" name="pass1" placeholder="Minimo 5 letras y un número" required/>
	        	</div>
	        	<div class="row">
	        		<input type="submit" class="submitLogin" value="REGISTER">
	        	</div>
	        	<div class="error" id="error"></div>
	    	</form>
	    	<div class="noShow" id="divToLogin">
	    		<h1>Success</h1>
	    		<p>Usuario registrado.</p>
	    		<a href="login"><button>INICIAR SESIÓN</button></a>
	    	</div>
	    	
			
		</div>

		<?php include("modal.php");?> 
		
	    <?php include("footer.php");?>  
			<script src="script/register.js"></script>
	</body>
</html>
