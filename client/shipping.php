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
	$id_shipping = $_GET['id_shipping'];
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
	<link rel="stylesheet" type="text/css" href="css/CLIENT-shipping.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div id="main">
		<?php include('sidebar.php');?>
		<div class="body">
			<a class="return" href="shippings"><i class="fas fa-angle-left"></i> Direcciones</a>
			<h2>Dirección</h2>
			<form id="deliveryForm" class="deliveryFormContainer">
			<?php
				$shipping = $set->getShipping($id_shipping);
				echo '<div class="row"><input type="text" id="name" placeholder="Nombre" value="'.$shipping['name'].'"/></div>';
				echo '<div class="row"><input type="text" id="address1" placeholder="Domicilio" value="'.$shipping['address_line_1'].'"/></div>';
				echo '<div class="row"><input type="text" id="address2" placeholder="Domicilio (cont)" value="'.$shipping['address_line_2'].'"/></div'; 
            	echo '<div class="row" id="cpCityContainer">';
            	echo 	'<input type="number" id="cp" placeholder="Código Postal: 6 dígitos"/>';
            	echo 	'<input type="text" id="city" placeholder="Alcaldia/Municipio"/>';
	            echo '</div>';
            	echo '<div class="row" id="countryStateContainer">';
            	echo 	'<input type="text" id="country" placeholder="MEX" value="'.$shipping['country'].'" disabled />';
           	?>
            		<div class="selectState">

            			<select id="state">
	            	<?php
	            		$states = $set->getStates('MEX');
	            		foreach ($states as $key => $value) {
	            			if($shipping['state'] == $value){
	            				echo '<option value="'.$value.'" selected>'.$value.'</option>';
	            			}
	            			else{
	            				echo '<option value="'.$value.'">'.$value.'</option>';
	            			}
	            		}
	            	?>
            			</select>
            		</div>
            	</div>
            	<div class="row">
            		<?php
            		echo '<textarea id="notes" placeholder="Notas">'.$shipping['notes'].'</textarea>';
            		?>
            	</div>
            	<div class="row">
	            		<input class="submitShipping" id="submitShipping" type="submit" value="Guardar Cambios"/>
	            </div>
	        </form>
		</div>
	</div>

	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script src="../node_modules/list.js/dist/list.min.js"></script>

</body>
</html>