<?php
	require_once('../include/conekta-php/lib/Conekta.php');
    require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('login');
		exit();
	}
	if(!$set->checkDeliverySession()){
		$set->RedirectToURL('delivery');
		exit();
	}
	\Conekta\Conekta::setLocale('es');
    $keyConekta = $set->getConektaSecretKey();
	\conekta\Conekta::setApiKey($keyConekta);

	$cart = $set->getCart();
	$path = '/subseller/phone';
	$pathImg = '../';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../payment");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/payment.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	
	<div id="paymentContainer">
		<div class="pasoContainer">
	        <p>PASO 3:  <b> DATOS DE PAGO</b></p>
	        <div class="meter">
	          <span style="width: 75%"></span>
	        </div>
	    </div>
	    <div class="container">
	    	<div id="termsContainer">
                    <input id="checkTerminos" type="checkbox"/><label for="checkTerminos"><i class="fas fa-check"></i></label>
                    <p>Aceptar <a href="avisodeprivacidad.pdf">Términos y Condiciones</a></p>
                </div>
	    </div>
		<div class="container">
			<div class="rightContainer">
				<details>
					<summary>
						<?php
							$items = $set->getCartItems();
							echo '<span>Carrito <i>('.$items.') PRODUCTOS</i></span>';
						?>
					</summary>
					<hr>
	    			<a href="cart" class="edit"><div class="editContainer">Editar pedido</div></a>
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
					<hr>
					<div id="couponContainer">
						<input type="text" id="coupon" placeholder="Cupon" autocomplete="off">
						<button id="checkCoupon">Verificar</button>
					</div>
				</details>
	    	</div>
			<div class="leftContainer">
	            <div id="typePaymentContainer">
	            	<input type="radio" name="typePayment" id="card" checked><label for="card"><i class="fas fa-credit-card"></i> <p>Tarjeta</p></label>
	            	<input type="radio" name="typePayment" id="spei"><label for="spei"><i class="fas fa-exchange-alt"></i><p>SPEI</p></label>
	            	<input type="radio" name="typePayment" id="oxxo"><label for="oxxo"><i class="fas fa-dollar-sign"></i><p>OXXO</p></label>
	            </div>
				<div id="typePaymentBoxesContainer">
					<div class="typePaymentBox active" id="box-card">
						<!-- <p>Se muestran tarjetas guardadas anteriormente<i>(si es el caso)</i>, o bien ingresar nueva información.</p> -->
						<p>Los pagos por tarjeta bancaria:</p>
                        <ul>
                            <li><p>TARJETA<br>Al seleccionar esta opción se muestran tarjetas guardadas previamente (si es el caso)</p></li>
                        </ul>
                        <p>Una vez confirmado el pago, la información de tu pedido además de poder visualizarla en la siguiente ventana, será enviada a tu correo.</p>
						<form id="cardForm">
						<?php
	                        //check if saved cards
	                        $id_conekta = $set->getClientConekta();
	                        try{
	                        	$customer = \conekta\Customer::find($id_conekta);
	                        	$totalCards = $customer->payment_sources->total;
	                        	$cards = $customer->payment_sources;
	                            foreach($cards as $key=>$value){
	                               echo     '<div class="cardBox">';
	                               echo         '<input type="radio" name="card" class="card" value="'.$value['id'].'" id="card'.$key.'">';
	                               echo         '<label for="card'.$key.'">';
	                               switch($value['brand']){
	                                   case "visa":echo '<i class="fab fa-cc-visa"></i>';break;
	                                   case "mastercard":echo '<i class="fab fa-cc-mastercard"></i>';break;
	                                   default: echo '<i class="fas fa-credit-card"></i>';break;
	                               }
	                               echo         '</label>';
	                               echo 		'<p>xxxx-xxxx-xxxx-'.$value['last4'].'</p>';
	                               echo      '</div>';
	                            }
	                            echo '<div class="cardBox">';
	                            echo 	'<input type="radio" name="card" class="card" value="0" id="new" checked>';
	                            echo 	'<label for="new"><i class="fas fa-check"></i></label>';
	                            echo 	'<p>Ingresar nueva</p>';
	                            echo '</div>';
	                        }
	                        catch(Exception $e){
	                            echo '<input type="radio" name="card" class="card" value="0" id="new" checked><label for="new"></label>';
	                        }
	                    ?>
                    		<div class="row"><input id="nameCard" type="text" size="20" placeholder="Nombre en la tarjeta" data-conekta="card[name]"/></div>
							<div class="row"><input id="numberCard" type="text" size="20" placeholder="Número tarjeta" data-conekta="card[number]"/></div>
							<div class="row" id="cardDetailsContainer">
								<div id="expiresContainer">
									<input type="text" id="mTarjeta" size="2" data-conekta="card[exp_month]" placeholder="MM"/><input type="text" size="4" id="yTarjeta" data-conekta="card[exp_year]" placeholder="AAAA"/>
									<p class="little">Vencimiento</p>
								</div>
								<div id="cvcContainer">
									<input id="CVCtarjeta" type="password" size="4" placeholder="CVC" data-conekta="card[cvc]"/>
									<label id="question">
										<i class="fas fa-question" title="Los digitos que estan en la parte de atras de tu tarjeta"></i>
									</label>
									<p class="little">Codigo CVC</p>
								</div>
							</div>
							<div class="row" id="saveCardContainer">
								<input id="saveCard" type="checkbox"/><label for="saveCard"><i class="fas fa-check"></i></label>
								<p>Guardar Tarjeta</p>
							</div>
							<P class="little">Seleccionar si desea guardar la información para futuras compras.</P>
						</form>
					</div>
					<div class="typePaymentBox" id="box-spei">
						<p>Los pagos por transferencia bancaria:</p>
                        <ul>
                            <li><p>SPEI<br>Al seleccionar esta opción se creará una CLABE de pago, con ella podras pagar en el banco de tu preferencia.</p></li>
                        </ul>
                        <p>Esta información además de poder visualizarla en la siguiente ventana, será enviada a tu correo.<br>Una vez realizado el pago se nos notificara para poder hacer el envío de tu pedido.</p>
					</div>
					<div class="typePaymentBox" id="box-oxxo">
						<p>Los pagos en efectivo:</p>
                        <ul>
                            <li><p>OXXO<br>Al seleccionar esta opción se generara una referencia para poder hacer el pago en el OXXO mas cercano.</p></li>
                        </ul>
                        <p>Esta información además de poder visualizarla en la siguiente ventana, será enviada a tu correo.<br>Una vez realizado el pago se nos notificará para poder hacer el envío de tu pedido.</p>
					</div>
				</div>
			</div>
    	</div>
    	<div class="nextContainer">
			<div id="paypal-button-container"></div>
			<button id="next">Pagar</button>
		</div>
	</div>


	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
	<script type="text/javascript" src="script/payment.js"></script>
</body>
</html>