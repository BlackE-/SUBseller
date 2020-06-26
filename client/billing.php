<?php
	$path = './subseller/';
	require_once  $_SERVER['DOCUMENT_ROOT'].$path."include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('../login');
		exit();
	}
	$name = $set->getClientName();
	$id_billing = $_GET['id_billing'];
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../phone/client");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/CLIENT-billing.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div id="main">
		<?php include('sidebar.php');?>
		<div class="body">
			<a class="return" href="billings"><i class="fas fa-angle-left"></i> Lista</a>
			<h2>Datos de Facturación</h2>
			<form id="facturaContainerBox" class="facturaContainerBox">
			<?php
				$billing = $set->getBilling($id_billing);
				echo '<input type="text" id="rfc" placeholder="RFC" value="'.$billing['rfc'].'"/>';
				echo '<input type="text" id="razon_social" placeholder="Nombre" value="'.$billing['razon_social'].'"/>';
				echo '<input type="email" id="email" placeholder="Email" value="'.$billing['email'].'"/>';
				echo '<div class="selectCDFI"><select id="cfdi">';
				switch ($billing['cfdi']) {
					case '01-AdquisionMercancia':
					echo '	<option value="01-AdquisionMercancia" selected>01 - Adquisición Mercancias</option>
							<option value="03-GastosGeneral">03 - Gastos General</option>';
					break;
					case '03-GastosGeneral':
					echo '	<option value="01-AdquisionMercancia">01 - Adquisición Mercancias</option>
							<option value="03-GastosGeneral" selected>03 - Gastos General</option>';
					break;
					
					default:
						# code...
						break;
				}
				echo '</select></div>';
				echo '<input type="text" id="address1" placeholder="Domicilio" value="'.$billing['address_line_1'].'"/>';
				echo '<input type="text" id="address2" placeholder="Domicilio (cont)" value="'.$billing['address_line_2'].'"/>'; 
            	echo 	'<input type="text" id="cp" placeholder="Código Postal: 6 dígitos" value="'.$billing['cp'].'"/>';
            	echo 	'<input type="text" id="city" placeholder="Alcaldia/Municipio" value="'.$billing['city'].'"/>';
            	echo 	'<input type="text" id="country" placeholder="MEX" value="'.$billing['country'].'" disabled />';
           	?>
            		<div class="selectState">

            			<select id="state">
	            	<?php
	            		$states = $set->getStates('MEX');
	            		foreach ($states as $key => $value) {
	            			if($billing['state'] == $value){
	            				echo '<option value="'.$value.'" selected>'.$value.'</option>';
	            			}
	            			else{
	            				echo '<option value="'.$value.'">'.$value.'</option>';
	            			}
	            		}
	            	?>
            			</select>
            		</div>
            	<div class="row">
	            		<input class="submitBilling" id="submitBilling" type="submit" value="Guardar Cambios"/>
	            </div>
	        </form>
		</div>
	</div>

	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script src="../node_modules/list.js/dist/list.min.js"></script>

</body>
</html>