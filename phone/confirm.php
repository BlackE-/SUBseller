<?php
    require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('login');
		exit();
	}
	$id_order = $_GET['id_order'];
	if(!$set->checkOrder($id_order)){
		$set->RedirectToURL('index');
		exit();
	}
	unset($_SESSION['id_session_client']);
	unset($_SESSION['id_shipping']);

	$pathImg = '../';
?>

<!DOCTYPE html>
<html>
<head>
	<script>
         if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("/");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/confirm.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div class="bodyContainer">
		<div id="confirmContainer">
			<div class="pasoContainer">
		        <p>PASO 4:  <b>CONFIRMACIÓN</b></p>
		        <ul>
					<li class="completed">1</li>
					<li class="completed">2</li>
					<li class="completed">3</li>
					<li class="active">4</li>
				</ul>
		    </div>
	    <?php
			if($id_order == 'undefined'){
				echo '<div class="container"><div class="leftContainer"><div id="orderContainer">';
				echo '<p>El pedido no pudo ser guardado, pero la orden ya fue emitida, nos comunicaremos con usted para confirmar el pedido</p>';
				echo '</div></div></div>';
			}else{
				echo '<input type="hidden" id="id_order" value="'.$id_order.'"/>';
				$order = $set->getOrder($id_order);
				$transation = $set->getTransation($id_order);
				$shipping = $set->getShipping($order['shipping_id_shipping']);
		?>
			<div class="container">
				<div class="leftContainer">
					<div id="orderContainer">
						<?php
							echo '<div><p>Pedido</p></div><div><p>'.$order['cve_order'].'</p></div>';
							echo '<div><p>Dirección de envío</p></div>';
							echo '<div>';
							echo 	'<p>'.$shipping['address_line_1'].'</p>';
							echo 	'<p>'.$shipping['address_line_2'].'</p>';
							echo 	'<p>'.$shipping['cp'].', '.$shipping['city'].'</p>';
							echo 	'<p>'.$shipping['country'].', '.$shipping['state'].'</p>';
							echo 	'<p>'.$shipping['notes'].'</p>';
							echo '</div>';

							echo '<div><p>Detalles de pago</p></div>';
							echo '<div>';
							echo 	'<p class="type">'.$transation['type'].'</p>';
							switch($transation['type']){
								case 'spei':
									echo '<p>CLABE</p>';
									echo '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
								break;
								case 'oxxo':
									echo '<p>REFERENCIA</p>';
									echo '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
									echo '<p>Tienes un plazo de 2 días para realizar tu pago.</p>';
								break;
								case 'card':
									echo 'Código de authorización';
									echo '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
								break;
								case 'paypal':
									echo 'Código';
									echo '<p style="border:2px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
								break;
							}
							echo '</div>';
							echo 	'<div><p class="little">Toda esta información fue enviada por correo.</p></div>';
							
							if($order['coupon_id_coupon'] != ''){
								$coupon = $set->getCoupon($order['coupon_id_coupon']);
								echo '<div><p>Datos de cupon utilizado</p></div>';
								echo '<div>';
								echo 	'<p>'.$coupon['code'].'</p>';
								echo 	'<p>'.$coupon['description'].'</p>';
								echo '</div>';
							}
						?>
					</div>
				</div>
	    		<div class="rightContainer">
	    			<hr>
	    			<div id="cartItemsContainer">
							<?php
							$totalRows = 0;
								$cart = $set->getItemsFromSessionClient($order['session_client_id_session_client']);
									foreach ($cart as $key => $value) {
										$product = $set->getProduct($value['id_product']);
										$pro = $product[0]['product'];
										$proImg = $product[1]['media'];
										$price_sale = $value['price'];
				                        
				                        $price = explode('.',$price_sale);
				                        $totalRow = $value['price'] * $value['number_items'];
				                        $totalRowFormat = number_format($totalRow,2,'.',','); 
				                        $priceRow = explode('.',$totalRowFormat);
				                        $totalRows += $totalRow;

										echo '<div class="item">';
										echo 	'<img class="thumb" src="'.$pathImg.$proImg[0]['url'].'"/>';
										echo 	'<div class="itemDetails">';
										echo 		'<p class="name">'.$pro['name'].'</p>';
				                		echo 		'<p class="sale_price">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
				                		echo 	'</div>';
				                		echo 	'<div id="id_row_'.$value['id_product'].'">';
										echo 		'<p class="totalRow" >$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p>';
										echo 	'</div>';
										echo '</div>';
										echo '<div>'.$value['description'].'</div>';
										if(!$value['prescription']){

										}else{
											echo '<p>Receta</p>';
											echo '<img style="width:100%;" src="..'.$value['prescription'].'"/>';
										}
									}
							?>
					</div>
					<hr>
					<div id="detailsContainer">
						<?php
							$subtotal = $totalRows;
							$subtotalFormat = number_format($subtotal, 2, '.', ',');
							$subtotalShow = explode('.', $subtotalFormat);
							$deliveryCost = number_format($order['shipping_fee'], 2, '.', ',');
							$total = number_format($order['total'], 2, '.', ',');
							$totalShow = explode('.', $total);
							$deliveryShow = explode('.', $deliveryCost);

							echo '<div>';
							echo 	'<p><b>Subtotal:</b></p>';
							echo 	'<div id="subtotalContainer">';
							echo 		'<p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p>';
							echo 	'</div>';
							echo '</div>';
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

					<div class="nextContainer"><a href="store"><button id="">Seguir comprando</button></a></div>

					<div class="enableBilling">
			    		<div id="facturaCheckContainer">
			    			<input id="checkRFC" type="checkbox"/><label for="checkRFC"><i class="fas fa-check"></i></label>
			    			<p>Solicitar factura</p>
			    		</div>
			    	</div>
	    		</div>
	    		<div id="facturaContainer">
	                	<div class="facturaSavedContainer">
	                		<?php
	                			$billings = $set->getBillingsFromClient();
		            			if(is_array($billings)){
		            		?>
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
		            		<?php
		            			}
		            		?>
	                	</div>

	                	<div id="facturaContainerBox">
	                		<input type="text" id="rfc" placeholder="RFC*" required>
	                		<input type="email" id="email" placeholder="Correo Electrónico*" required>
		                	<input type="text" id="razon_social" placeholder="Razon Social*" required>
		                	<div class="selectCDFI">
		            			<select id="cfdi">
		            				<option value="0">Elegir CFDI*</option>
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
		            		<div class="nextContainer"><div class="container"><button id="request">Solicitar</button></div></div>
	                	</div>
	                </div>
	    	</div>
	    	
		<?php
			}//END ELSE
		?>
		</div>
	</div>
	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script type="text/javascript" src="script/confirm.js"></script>
</body>
</html>