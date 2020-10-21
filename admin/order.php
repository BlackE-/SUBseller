<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		header("Location: login"); 
		exit;
	}
	$id_order = $_GET['id_order'];
	$path = '/subseller';
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>

	<link rel="stylesheet" type="text/css" href="css/order.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="orders"><i class="fas fa-angle-left"></i> Ordenes</a>
				<h1>Orden</h1>	
			</div>
			<?php
				$order = $set->getOrder($id_order);
				$transation = $set->getTransation($id_order);
				$shipping = $set->getShipping($order['shipping_id_shipping']);
				$billing = $set->getBilling($order['billing_id_billing']);

				echo '<input id="id_order" type="hidden" value="'.$id_order.'"/>';
			?>
			<div class="leftDiv">
				<div class="order_details">
					<?php
						echo '<div><p>Pedido</p></div><div><p>'.$order['cve_order'].'</p></div>';
						echo '<div><p>Cliente</p></div>';
						$id_client = $order['client_id_client'];
	                    $name = $set->getClientNameById($id_client);
						echo '<div><a href="client?id_client='.$id_client.'"><p>'.$name.'</p></a></div>';
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
								echo '<p style="border:1px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
							break;
							case 'oxxo':
								echo '<p>REFERENCIA</p>';
								echo '<p style="border:1px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
								echo '<p>Tienes un plazo de 2 días para realizar tu pago.</p>';
							break;
							case 'card':
								echo 'Código de authorización';
								echo '<p style="border:1px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
							break;
							case 'paypal':
								echo 'Código';
								echo '<p style="border:1px solid #2361f0;text-align:center;padding:15px;"><b>'.$transation['code'].'</b></p>';
							break;
						}
						echo '</div>';
						
						if($order['coupon_id_coupon'] != ''){
							$coupon = $set->getCoupon($order['coupon_id_coupon']);
							echo '<div><p>Datos de cupon utilizado</p></div>';
							echo '<div>';
							echo 	'<p>'.$coupon['code'].'</p>';
							echo 	'<p>'.$coupon['description'].'</p>';
							echo '</div>';
						}
						if($order['billing_id_billing'] != ''){
							echo '<div><p>Datos de facturación</p></div>';
							echo '<div>';
							echo 	'<p>'.$billing['rfc'].'</p>';
							echo 	'<p>'.$billing['razon_social'].'</p>';
							echo 	'<p>'.$billing['email'].'</p>';
							echo 	'<p>'.$billing['cfdi'].'</p>';
							echo 	'<p>'.$billing['address_line_1'].'</p>';
							echo 	'<p>'.$billing['address_line_2'].'</p>';
							echo 	'<p>'.$billing['cp'].', '.$billing['city'].'</p>';
							echo 	'<p>'.$billing['country'].', '.$billing['state'].'</p>';
							echo '</div>';
						}

						
					?>
				</div>
				<?php
					//div con info de shipping

					//div con info de billing
				?>
			</div>
			<div class="rightDiv">
				<div class="editContainer">
					<p>Status</p>
					<select id="status">
						<?php
							switch ($order['status']) {
								case 'PROCESSING':
									echo '<option value="PENDING PAYMENT" >PENDING PAYMENT</option>';
									echo '<option value="PROCESSING" selected>PROCESSING</option>';
									echo '<option value="CANCELED" >CANCELED</option>';
									echo '<option value="COMPLETED" >COMPLETED</option>';
									echo '<option value="EXPIRED" >EXPIRED</option>';
									break;
								case 'PENDING PAYMENT':
									echo '<option value="PENDING PAYMENT" selected >PENDING PAYMENT</option>';
									echo '<option value="PROCESSING">PROCESSING</option>';
									echo '<option value="CANCELED" >CANCELED</option>';
									echo '<option value="COMPLETED" >COMPLETED</option>';
									echo '<option value="EXPIRED" >EXPIRED</option>';
									break;
								case 'CANCELED':
									echo '<option value="PENDING PAYMENT">PENDING PAYMENT</option>';
									echo '<option value="PROCESSING">PROCESSING</option>';
									echo '<option value="CANCELED" selected>CANCELED</option>';
									echo '<option value="COMPLETED" >COMPLETED</option>';
									echo '<option value="EXPIRED" >EXPIRED</option>';
									break;
								case 'COMPLETED':
									echo '<option value="COMPLETED" selected>COMPLETED</option>';
									break;
								case 'EXPIRED':
									echo '<option value="EXPIRED" selected>EXPIRED</option>';
									break;
								
								default:
									# code...
									break;
							}
						?>
					</select>
					<div class="nextContainer"><button id="updateStatus">Update</button></div>
					<p class="little">Una vez que el status este en COMPLETE, ya no puede cambiarse el status</p>
					<p id="error"></p>
				</div>

				<div class="cartContainer">
					<hr>
	    			<div id="cartItemsContainer">
							<?php
							$totalRows = 0;
								$cart = $set->getItemsFromSessionClient($order['session_client_id_session_client']);
									foreach ($cart as $key => $value) {
										$pro = $set->getProduct($value['id_product']);
										$proImg = $set->getMedia($value['id_product'],'product');
										$price_sale = $value['price'];
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
										echo '<div>'.$value['description'].'</div>';
										if(!$value['prescription']){

										}else{
											echo '<p>Receta</p>';
											echo '<a href="..'.$value['prescription'].'"><img style="width:100%;" src="..'.$value['prescription'].'"/></a>';
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
				</div>
			</div>
		</div>
	</div>



	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/order.js"></script>
</body>
</html>