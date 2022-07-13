<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
         	<?php
         		echo 'window.location.replace("phone/contacto")';
         	?>
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/contacto.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="bodyContainer">
		<div id="cartHeader">
			<div class="container">
				<h1>CONTACTO</h1>
			</div>
		</div>
		<div class="box">
			<div class="container">
				<div class="boxContainer">
					<p>Misdec tiene su oficina y Óptica física en:</p>
					<a href="https://goo.gl/maps/nG3vmMNSijcq9rsF7"><i class="fas fa-map-marker-alt"></i><p> Blvd. Agustín Téllez Cruces 2326-B, Col. San José del Consuelo II, C.P. 37217,León, Gto.</p>
					<a href="mailto:contacto@mislendecon.com"><i class="fas fa-envelope"></i><p>contacto@mislendecon.com</p></a>
					<a href="tel:4773119647"><i class="fas fa-phone"></i><p>4773119647</p></a>
				</div>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3720.9610806233936!2d-101.6470525653352!3d21.15394708226645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842bbec57862f75d%3A0xbefade83dc96129b!2sBulevar%20Agustin%20T%C3%A9llez%20Cruces%202326%2C%20Predio%20Unidad%20Deportiva%20II%20Poniente%2C%20Le%C3%B3n%2C%20Gto.!5e0!3m2!1sen!2smx!4v1604637499700!5m2!1sen!2smx" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
			</div>
		</div>
	</div>

	<?php include('footer.php');?>
</body>
</html>