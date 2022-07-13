<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('login');
		exit();
	}
	$cart = $set->getCart();
	$path = '/subseller';
?>

<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/delivery");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/delivery.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div class="bodyContainer">
		<div id="deliveryContainer">
			<div class="pasoContainer">
		        <p>PASO 2:  <b> DIRECCIÓN DE ENTREGA</b></p>
		       	<ul>
					<li class="completed">1</li>
					<li class="active">2</li>
					<li>3</li>
					<li>4</li>
				</ul>
	 		</div>
			<div class="container">
				<div class="leftContainer">
		            <div class="deliveryFormContainer">
		            	<form id="deliveryForm" class="deliveryForm">
		            		<?php
		            			$shippings = $set->getShippingsFromClient();
		            			if(is_array($shippings)){
		            		?>
		            			<div class="shippingSavedContainer">
		            				<p>Direcciones guardadas</p>
		            				<div class="shippingSaved">
				            			<select id="shippings">
				            				<?php
				            					echo '<option value="0">Elegir una opción</option>';
				            					foreach ($shippings as $key => $value) {
				            						echo '<option value="'.$value['id_shipping'].'">'.$value['name'].'</option>';
				            					}
				            				?>
				            			</select>
				            		</div>
		            			</div>
		            			
		            		<?php
		            			}
		            		?>
		            		<div class="row"><input type="text" id="address1" placeholder="Domicilio"/></div>
		            		<div class="row"><input type="text" id="address2" placeholder="Domicilio (cont)"/></div>
		            		<?php
		            			if(!$set->checkPhone()){//FALSE has no phone ASK FOR PHONE
		            				echo '<div class="row"><input type="number" id="phone" placeholder="Telefono: 10 dígitos"/></div>';
		            			}
		            		?>
			            	<div class="row" id="cpCityContainer">
			            		<input type="number" id="cp" placeholder="Código Postal: 6 dígitos"/>
			            		<input type="text" id="city" placeholder="Alcaldia/Municipio"/>
			            	</div>
			            	<div class="row" id="countryStateContainer">
			            		<input type="text" id="country" placeholder="MEX" value="MEX" disabled="" />
			            		<div class="selectState">
			            			<select id="state">
				            	<?php
				            		$states = $set->getStates('MEX');
				            		foreach ($states as $key => $value) {
				            			echo '<option value="'.$value.'">'.$value.'</option>';
				            		}
				            	?>
			            			</select>
			            		</div>
			            	</div>
			            	<div class="row">
			            		<textarea id="notes" placeholder="Notas"></textarea>
			            	</div>
			            	<div class="row" id="checkNameShipping">
			            			<input id="checkName" type="checkbox"/><label for="checkName"><i class="fas fa-check"></i></label>
			            			<input type="text" id="name" placeholder="Nombre de la direccion"/>
			            			<p class="little">Seleccionar para guardar dirección</p>
			            	</div>
		            	</form>
		            </div>
				</div>
	    		<div class="rightContainer">
	    			<div class="editContainer"><a href="cart" class="edit">Editar pedido</a></div>
	    			<hr>
	    			<div id="cartItemsContainer">
							<?php
									$totalRows = 0;
									foreach ($cart as $key => $value) {
										$product = $set->getProduct($value['id_product']);
										$pro = $product[0]['product'];
										$proImg = $product[1]['media'];
										$price_sale = $value['price'];
				                        $price = explode('.',$price_sale);
				                        $totalRow = $value['price'] * $value['number_items'];
				                        $totalRowFormat = number_format($totalRow, 2, '.', ',');
				                        $priceRow = explode('.',$totalRowFormat);
				                        $totalRows += $totalRow;

										echo '<div class="item">';
										echo 	'<img class="thumb" src="'.$path.$proImg[0]['url'].'"/>';
										echo 	'<div class="itemDetails">';
										echo 		'<p class="name">'.$pro['name'].'</p>';
				                		echo 		'<p class="sale_price">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
				                		echo 	'</div>';
				                		echo 	'<div>';
										echo 		'<p class="totalRow">$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p>';
										echo 	'</div>';
										// echo $value['description'];
										echo '</div>';
									}
							?>
						</div>
						<hr>
						<div id="detailsContainer">
							<?php
								$subtotal = $totalRows;
								$subtotalFormat = number_format( $subtotal, 2, '.', ',');
								$subtotalShow = explode('.', $subtotalFormat);
								echo '<div class="subtotalContainer"><p><b>Subtotal:</b></p><p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p></div>';

								$freeDelivery = $set->getLimitFreeDelivery();
								$total = $subtotal;
								$deliveryCost = number_format(0, 2, '.', '');
		                        if($subtotal >= $freeDelivery ){
		                        }else{
		                        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', '');
		                        	$total += $deliveryCost;
		                        }
								$total = number_format($total, 2, '.', ',');
								$totalShow = explode('.', $total);
								$deliveryShow = explode('.', $deliveryCost);
								echo '<div class="deliveryCostContainer"><p><b>Gastos de envío:</b></p><p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p></div>';
								echo '<div class="totalContainer"><p><b>Total:</b></p><p class="lightLabel2" id="total">$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></p></div>';
							?>
						</div>
						<div class="nextContainer"><button id="next">Siguiente</button></div>
	    		</div>
	    	</div>
		</div>
	</div>


	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/delivery.js"></script>
</body>
</html>