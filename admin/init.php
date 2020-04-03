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
	        	<p class="topRegister"><b>BASE DE DATOS</b></p>
	        	<p class="topRegister">Para comenzar a utilizar la plataforma necesitamos la siguiente información</p>
		        	<div class="row">
		        	    <input type="text" name="host" placeholder="Host" required/>
		        	</div>
		        	<div class="row">
		        	    <input type="text" name="database" placeholder="Database" required/>
		        	</div>
		        	<div class="row">
		        	    <input type="text" name="username" placeholder="Username" required/>
		        	</div>
		        	<div class="row">
		        		<input type="password" name="pass1" placeholder="Password" required/>
		        	</div>
		        	<div class="row">
		        		<input type="submit" class="submitLogin" value="Guardar">
		        	</div>
	        	<div class="error"></div>
	    	</form>
		</div>

		<?php include("modal.php");?> 
		
	    <?php include("footer.php");?>  
			<script src="script/init.js"></script>
	</body>
</html>
