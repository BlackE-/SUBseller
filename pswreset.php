<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if($login){
		$set->RedirectToURL('store');
		exit();
	}
	$path = '/subseller';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/login");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>

	<link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
	<link rel="stylesheet" type="text/css" href="css/psw.css">
</head>
</head>
<body>

	<?php include('header.php');?>
	<div id="formsContainer">
		<div class="container" id="box">
    		<div class="pasoContainer">
                <p><b>Recuperar Contraseña</b></p>
                <p>Ingresa tu nueva contraseña</p>
            </div>
    		<div class="error"></div>
            <div class="registerContainer">
            	<form id="resetForm">
	            	<div class="row"><input type="email" id="emailReset" placeholder="Correo Electrónico"/></div>
	            	<button class="submitPswRst" id="">Enviar</button>
	            </form>
    		</div>
    	</div>
	</div>


	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/pswreset.js"></script>
</body>
</html>