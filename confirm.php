<?php
	require_once('include/conekta-php/lib/Conekta.php');
    require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('login');
		exit();
	}

	//$set->updateSessionClient($_SESSION['id_session_client']);
	//unset($_SESSION['id_session_client']);
	//unset($_SESSION['id_shipping']);

	$cart = $set->getCart();
	$path = '/subseller';
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
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/confirm.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	
	<div id="confirmContainer">
		<div class="pasoContainer">
	        <p>PASO 4:  <b> DATOS DE PAGO</b></p>
	        <div class="meter">
	          <span style="width: 100%"></span>
	        </div>
	    </div>
		<div class="container">
			<div class="leftContainer">
				<div id="orderContainer">
					<p>Pedido: </p>
					<p> Dirección de envío</p>
					<p>Metodo de pago</p>
					<p>Datos en caso de cupon</p>
				</div>

				<div id="termsContainer"></div>

                <div class="facturaContainer">
                	<div class="facturaSavedContainer">
                		<div id="facturaCheckContainer">
	            			<input id="checkRFC" type="checkbox"/><label for="checkRFC"><i class="fas fa-check"></i></label>
	            			<p>Solicitar factura</p>
	            		</div>

                		<?php
                			$billings = $set->getBillingFromClient();
	            			if(is_array($billings)){
	            		?>
	            			<div class="billingsSavedContainer">
	            				<div class="billingsSaved">
			            			<select id="billings">
			            				<?php
			            					echo '<option value="0">Elegir un RFC</option>';
			            					foreach ($billings as $key => $value) {
			            						echo '<option value="'.$value['id_shipping'].'">'.$value['rfc'].'</option>';
			            					}
			            				?>
			            			</select>
			            		</div>
	            			</div>
	            		<?php
	            			}
	            		?>
                	</div>

                	<div id="facturaContainerBox">
                		<input type="text" name="rfc" placeholder="RFC*">
                		<input type="email" name="email" placeholder="Correo Electrónico*">
	                	<input type="text" name="razon_social" placeholder="Razon Social*">
	                	<input type="text" name="address1" placeholder="Domicilio">
	                	<input type="text" name="address2" placeholder="Domicilio (cont)">
	                	<input type="text" name="cp" length="6" placeholder="CP">
	                	<input type="text" name="city" placeholder="Alcaldia/Municipio">
	                	<input type="text" name="country" value="MEX" disabled>
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
	            		<div class="nextContainer"><button id="next">Solicitar</button></a></div>
                	</div>
                </div>

			</div>
    		<div class="rightContainer">
    			<hr>
    			<div id="cartItemsContainer">
						<?php
								$totalRows = 0;
								foreach ($cart as $key => $value) {
									$product = $set->getProduct($value['id_product']);
									$pro = $product[0]['product'];
									$proImg = $product[1]['media'];
									$price_sale = $pro['price_sale'];
			                        if($pro['discount'] != 0){
			                        	$price_sale = $pro['price_sale']*$pro['discount'];
			                        }
			                        $price = explode('.',$price_sale);
			                        $totalRow = $value['price'] * $value['number_items'];
			                        $totalRowFormat = number_format($totalRow,2,'.',','); 
			                        $priceRow = explode('.',$totalRowFormat);
			                        $totalRows += $totalRow;

									echo '<div class="item">';
									echo 	'<img class="thumb" src="'.$path.$proImg[0]['url'].'"/>';
									echo 	'<div class="itemDetails">';
									echo 		'<p class="name">'.$pro['name'].'</p>';
			                		echo 		'<p class="sale_price">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
			                		echo 	'</div>';
			                		echo 	'<div id="id_row_'.$value['id_product'].'">';
									echo 		'<p class="totalRow" >$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p>';
									echo 	'</div>';
									echo '</div>';
								}
						?>
				</div>
				<hr>
				<div id="detailsContainer">
					<?php
						$subtotal = $totalRows;
						$subtotalFormat = number_format($subtotal, 2, '.', ',');
						$subtotalShow = explode('.', $subtotalFormat);
						echo '<div>';
						echo 	'<p><b>Subtotal:</b></p>';
						echo 	'<div id="subtotalContainer">';
						echo 		'<p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p>';
						echo 	'</div>';
						echo '</div>';

						$freeDelivery = $set->getLimitFreeDelivery();
						$total = $subtotal;
						$deliveryCost = number_format(0, 2, '.', ',');
                        if($subtotal >= $freeDelivery ){
                        }else{
                        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', ',');
                        	$total += $deliveryCost;
                        }
						$total = number_format($total, 2, '.', ',');
						$totalShow = explode('.', $total);
						$deliveryShow = explode('.', $deliveryCost);
						echo '<div>';
						echo 	'<p><b>Gastos de envío:</b></p>';
						echo 	'<div id="deliveryCostContainer">';
						echo 		'<p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p>';
						echo 	'</div>';
						echo '</div>';
						echo '<div>';
						echo 	'<p><b>Total:</b></p>';
						echo 	'<div id="totalContainer">';
						echo 		'<p class="lightLabel2" id="total">$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></p>';
						echo 	'</div>';
						echo '</div>';
					?>
				</div>
    		</div>
    	</div>
	</div>
	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/confirm.js"></script>
</body>
</html>