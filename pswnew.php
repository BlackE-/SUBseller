<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$email = '';
	if(isset($_GET['email'])){
		$email = $_GET['email'];
	}
	$login = $set->checkLogin();
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
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/psw.css">
</head>
</head>
<body>

	<?php include('header.php');?>
	<div id="formsContainer">
		<div class="container" id="box">
			<?php
				if($email){
			?>
				<div class="pasoContainer">
	                <p><b>Recuperar Contraseña</b></p>
	                <p>Ingresa tu correo electrónico</p>
	            </div>
	    		<div class="error"></div>
	            <div class="registerContainer">
	            	<form id="newForm">
		            	<div class="row"><input type="email" id="email" value="<?php echo $email?>" disabled/></div>
						<div class="row"><input type="password" id="passwordNew" placeholder="Nueva Contraseña"/></div>
						<div class="row"><p class="little">Al menos 8 caracteres: 1 letra Mayúscula, 1 letra Minúscula, 1 Número y 1 carácter especial</p></div>

		            	<button class="submitPswNew">Enviar</button>
		            </form>
	    		</div>
			<?php
				}
				else{
			?>
				<div class="errorLinkContainer">
	                <p><b>Recuperar Contraseña</b></p>
	                <p>Enlace incorrecto</p>
	                <a href="pswreset"><button>Recuperar contraseña</button></a>
	            </div>
			<?php
				}
			?>
    		
    	</div>
	</div>


	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/pswnew.js"></script>
</body>
</html>