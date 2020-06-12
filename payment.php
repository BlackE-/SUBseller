<?php
	require_once('include/conekta-php/lib/Conekta.php');
    require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('login');
		exit();
	}
	\Conekta\Conekta::setLocale('es');
    $keyConekta = $set->getConektaSecretKey();
	\conekta\Conekta::setApiKey($keyConekta);

	$cart = $set->getCart();
	$path = '/subseller';
?>

<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/payment");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/animate.css">
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
			<div class="leftContainer">
	            <div id="typePaymentContainer">
	            	<input type="radio" name="typePayment" id="card" checked><label for="card"><i class="fas fa-credit-card"></i> <p>Tarjeta</p></label>
	            	<input type="radio" name="typePayment" id="spei"><label for="spei"><i class="fas fa-mobile-alt"></i><p>SPEI</p></label>
	            	<input type="radio" name="typePayment" id="oxxo"><label for="oxxo"><i class="fas fa-dollar-sign"></i><p>OXXO</p></label>
	            </div>
				<div id="typePaymentBoxesContainer">
					<div class="typePaymentBox active" id="box-card">
						<form id="cardForm">
						<?php
	                        //check if saved cards
	                        $id_conekta = $set->getConektaId();
	                        $keyConekta = $set->getConektaSecretKey();
							\conekta\Conekta::setApiKey($keyConekta);
	                        try{
	                        	$customer = \conekta\Customer::find($id_conekta);
	                        	$totalCards = $customer->payment_sources->total;
	                        	$cards = $customer->payment_sources;
	                            foreach($cards as $key=>$value){
	                               echo '<div class="row">';
	                               echo     '<div class="tarjetaBox">';
	                               echo         '<input type="radio" name="card" class="card" value="'.$value['id'].'" id="card'.$key.'">';
	                               echo         '<label for="card'.$key.'"></label>';
	                               switch($value['brand']){
	                                   case "VISA":echo '<i class="fab fa-cc-visa"></i>';break;
	                                   case "MC":echo '<i class="fab fa-cc-mastercard"></i>';break;
	                               }
	                               echo 		'<p>xxxx-xxxx-xxxx-'.$value['last4'].'</p>';
	                               echo         '</div>';
	                               echo  '</div>';
	                            }
	                            echo '<input type="radio" name="card" class="card" value="0" id="new"><label for="new"></label>';
	                        }
	                        catch(Exception $e){
	                            echo '<input type="radio" name="card" class="card" value="0" id="new" checked><label for="new"></label>';
	                        }
	                    ?>
                    		<div class="row"><input id="nameCard" type="text" size="20" placeholder="Nombre en la tarjeta" data-conekta="card[name]"/></div>
							<div class="row"><input id="numberCard" type="password" size="20" placeholder="Número tarjeta" data-conekta="card[number]"/></div>
							<div class="row" id="cardDetailsContainer">
								<div id="expiresContainer">
									<input type="text" id="mTarjeta" size="2" data-conekta="card[exp_month]" placeholder="MM"/><input type="text" size="4" id="yTarjeta" data-conekta="card[exp_year]" placeholder="AAAA"/>
									<p class="little">Vencimiento</p>
								</div>
								<div id="cvcContainer">
									<input id="CVCtarjeta" type="text" size="4" placeholder="CVC" data-conekta="card[cvc]"/>
									<label><i class="fas fa-question" title="Los digitos que estan en la parte de atras de tu tarjeta"></i></label>
									<p class="little">Codigo CVC</p>
								</div>
							</div>
							<div class="row" id="saveCardContainer">
								<input id="saveCard" type="checkbox"/><label for="guardarTarjeta"><i class="fas fa-check"></i></label>
								<p>Guardar Tarjeta</p>
							</div>
						</form>
					</div>
					<div class="typePaymentBox" id="box-spei">
						<p>Los pagos por medio de transferencias bancarias a través de SPEI.<br>creará una CLABE de pago, con ella podras pagar en el banco de tu preferencia</p><p>En la siguiente pantalla tendras ésta información, además será enviada a tu correo electrónico.</p>
					</div>
					<div class="typePaymentBox" id="box-oxxo">
						<p>Los pagos en efectivo:</p>
                        <ul>
                            <li><p>OXXO<br>Al seleccionar esta opción se generara una referencia para poder hacer el pago en el OXXO mas cercano.</p></li>
                        </ul>
                        <p>Esta información además de poder visualizarla en la siguiente ventana, será enviada a tu correo.<br>Una vez realizado el pago se nos notificara para poder hacer el envío de tu pedido.</p>
					</div>
				</div>
				<div id="termsContainer">
                    <input id="checkTerminos" type="checkbox"/><label for="checkTerminos"><i class="fas fa-check"></i></label>
                    <p>Aceptar <a href="avisodeprivacidad.pdf">Términos y Condiciones</a></p>
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
									// print_r($product);
									$pro = $product[0]['product'];
									// print_r($pro);
									$proImg = $product[1]['media'];
									$price_sale = $pro['price_sale'];
			                        if($pro['discount'] != 0){
			                        	$price_sale = $pro['price_sale']*$pro['discount'];
			                        }
			                        $price = explode('.',$price_sale);
			                        $totalRow = number_format($value['price'] * $value['qty'], 2, '.', '');
			                        $priceRow = explode('.',$totalRow);
			                        $totalRows += $totalRow;

									echo '<div class="item">';
									echo 	'<img class="thumb" src="'.$path.$proImg[0]['url'].'"/>';
									echo 	'<div class="itemDetails">';
									echo 		'<p class="name">'.$pro['name'].'</p>';
			                		echo 		'<p class="sale_price">'.$value['qty'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
			                		echo 	'</div>';
			                		echo 	'<div>';
									echo 		'<p class="totalRow">$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p>';
									echo 	'</div>';
									echo '</div>';
								}
						?>
				</div>
				<hr>
				<div id="detailsContainer">
					<?php
						$subtotal = number_format($totalRows, 2, '.', '');
						$subtotalShow = explode('.', $subtotal);
						echo '<div class="subtotalContainer"><p><b>Subtotal:</b></p><p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p></div>';

						$freeDelivery = $set->getLimitFreeDelivery();
						$total = $subtotal;
						$deliveryCost = number_format(0, 2, '.', '');
                        if($subtotal >= $freeDelivery ){
                        }else{
                        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', '');
                        	$total += $deliveryCost;
                        }
						$total = number_format($total, 2, '.', '');
						$totalShow = explode('.', $total);
						$deliveryShow = explode('.', $deliveryCost);
						echo '<div class="deliveryCostContainer"><p><b>Gastos de envío:</b></p><p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p></div>';
						echo '<div class="totalContainer">';
						echo 	'<p><b>Total:</b></p>';
						echo 	'<p class="lightLabel2" id="total">$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></p>';
						echo '</div>';
					?>
				</div>
				<div id="couponContainer">
					<input type="text" name="coupon" placeholder="Cupon">
					<button id="checkCoupon">Verificar</button>
				</div>
				<div class="nextContainer"><button id="next">Pagar</button></div>
    		</div>
    	</div>
	</div>


	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/payment.js"></script>
</body>
</html>