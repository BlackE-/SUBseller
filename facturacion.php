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
            window.location.replace("phone/confirm");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/facturacion.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div class="bodyContainer">
		<div class="facturacionContainer">
			<div class="container"><h1>Facturación</h1></div>
			<div class="container" id="box">
			<?php
			if(!$login){
				echo '<div id="facturaContainer"><p style="text-align:center;">Iniciar Sesíón para facturar tu pedido</p>';
				echo '<div class="nextContainer"><a href="login"><button>INICIAR SESIÓN</button></a></div></div>';
			}else{
			?>
				<div id="facturaContainer">
	            		<?php
	        			$history = $set->getOrdersClient();
	        			if(!$history){
	            			echo '<p><i class="fas fa-inbox"></i> Sin Ordenes</p>';
	            		}else{
	            		?>
	            		<div class="facturaSavedContainer">
		            			<div class="billingsSavedContainer">
		            				<div class="billingsSaved">
				            			<select id="id_order">
				            				<?php
				            					echo '<option value="0">Elegir orden a facturar</option>';
				            					foreach ($history as $key => $value) {
				            						if(!$value['billing_id_billing']){
				            							echo '<option value="'.$value['id_order'].'">'.$value['cve_order'].'</option>';
				            						}
				            					}
				            				?>
				            			</select>
				            		</div>
		            			</div>
		            	</div>	
	            		<?php
	            			$billings = $set->getBillingsFromClient();
	            			if(is_array($billings)){
	            		?>
	            			<div class="facturaSavedContainer">
			            			<div class="billingsSavedContainer">
			            				<div class="billingsSaved">
					            			<select id="billings">
					            				<?php
					            					echo '<option value="0">Elegir un RFC</option>';
					            					foreach ($billings as $key => $value) {
					            						echo '<option value="'.$value['id_billing'].'">'.$value['rfc'].'</option>';
					            					}
					            				?>
					            			</select>
					            		</div>
			            			</div>
			            	</div>		
			            	<?php
			            	}
			            	?>
			            	<div id="facturaContainerBox">
		                		<input type="text" id="rfc" placeholder="RFC*" required>
		                		<input type="email" id="email" placeholder="Correo Electrónico*" required>
			                	<input type="text" id="razon_social" placeholder="Razon Social*" required>
			                	<div class="selectCDFI">
			            			<select id="cfdi">
			            				<option value="0">Elegir CFDI</option>
			            				<option value="01-AdquisionMercancia">01 - Adquisición Mercancias</option>
			            				<option value="03-GastosGeneral">03 - Gastos General</option>
			            			</select>
			            		</div>
			                	<input type="text" id="address1" placeholder="Domicilio">
			                	<input type="text" id="address2" placeholder="Domicilio (cont)">
			                	<input type="text" id="cp" length="6" placeholder="CP">
			                	<input type="text" id="city" placeholder="Alcaldia/Municipio">
			                	<input type="text" id="country" value="MEX" disabled>
		                		<div class="selectState">
			            			<select id="state">
			            				<option value="0">Elegir un estado</option>
						            	<?php
						            		$states = $set->getStates('MEX');
						            		foreach ($states as $key => $value) {
						            			echo '<option value="'.$value.'">'.$value.'</option>';
						            		}
						            	?>
			            			</select>
			            		</div>
			            		<div class="nextContainer"><button id="request">Solicitar</button></a></div>
		                	</div>

			            <?php
			            }
						?>
	            </div>
	        <?php
	    	}
	        ?>
				<div class="explicación">
			    	<p>Para factura elige los datos solicitados, en caso de que el pedido ya haya sido facturado, los datos no pueden ser cambiados.</p>
			    	<p>Si ya has facturado con nosotros, puedes elegir el mismo RFC seleccionandolo en el campo correspondiente. </p>
			    </div>

	    	</div>
	    	
    	</div>
	</div>
	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/facturacion.js"></script>
</body>
</html>