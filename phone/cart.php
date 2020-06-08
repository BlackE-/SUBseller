<?php
	require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if($login){
		$cart = $set->getCart();
	}else{
		if(!isset($_SESSION)){ session_start(); }
		if(isset($_SESSION['cart'])){$cart = $_SESSION['cart'];}
		else{$cart = array();}
		
	}
	$path = '/subseller/phone';
	$pathImg = '../';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../cart");
        }
     </script>  
    <?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/cart.css">
</head>
<body>
	<?php include('header.php');?>
	<div id="cartHeader">
		<div class="container">
			<h1>Carrito</h1>
		</div>
	</div>
	<?php
		if(empty($cart)){
	?>
		<div id="emptyCartContainer">
			<div class="container">
				<div id="emptyCart">
					<p>Tu carrito esta vacío</p>
					<a href="store">Tienda</a>
				</div>
			</div>
		</div>
	<?php
		}
		else{
	?>
		<div id="cartBoxContainer">
			<div class="container">
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
		                        $totalRow = number_format($value['price'] * $value['qty'], 2, '.', '');
		                        $priceRow = explode('.',$totalRow);
		                        $totalRows += $totalRow;

								echo '<div class="item">';
								echo 	'<img class="thumb" src="'.$pathImg.$proImg[0]['url'].'"/>';
								echo 	'<div class="itemDetails">';
								echo 		'<p class="name">'.$pro['name'].'</p>';
		                		echo 		'<p class="sale_price">'.$value['qty'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
		                		echo 	'</div>';
		                		echo 	'<div class="qtyBox">';
		                		echo 		'<input type="hidden" id="price_'.$value['id_product'].'" value="'.$price_sale.'"/>';
								echo 		'<button class="minus" name="'.$value['id_product'].'"><i class="fas fa-minus"></i></button>';
		            		    echo        '<input type="number" class="quantity" placeholder="1" value="'.$value['qty'].'" id="'.$value['id_product'].'" name="'.$key.'"/>';
		            		    echo        '<button class="more" name="'.$value['id_product'].'"><i class="fas fa-plus"></i></button>';
		            		    echo 	'</div>';
								echo 	'<div class="delete" id="delete_'.$value['id_product'].'" title="¿Seguro que deseas eliminar el producto?">';
		                	    echo 		'<i class="far fa-trash-alt"></i>';
		                	    echo 	'</div>';
								echo '</div>';
							}
					?>
				</div>
				<div id="detailsContainer">
					<?php
						$subtotal = number_format($totalRows, 2, '.', '');
						$subtotalShow = explode('.', $subtotal);
						$freeDelivery = $set->getLimitFreeDelivery();
						$total = $subtotal;
						$deliveryCost = number_format(0, 2, '.', '');
						$enable = false;
						if($subtotal >= $freeDelivery ){
                           $enable = true;
                        }else{
                        	$deliveryCost = number_format($set->getDeliveryCost(), 2, '.', '');
                        	$total += $deliveryCost;
                        }
						$total = number_format($total, 2, '.', '');
						$totalShow = explode('.', $total);
						$deliveryShow = explode('.', $deliveryCost);


						echo '<div class="subtotalContainer">';
						echo 	'<p><b>Subtotal:</b></p>';
						echo 	'<p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p>';
						echo '</div>';
						if($enable){
							echo '<div class="freeDelivery"><p>ALCANZASTE EL MONTO NECESARIO, TU <span>ENVIO</span> ES <span>GRATIS</span></p></div>';
						}
						echo '<div class="deliveryCostContainer">';
						echo 	'<p><b>Gastos de envío:</b></p>';
						echo 	'<p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p>';
						echo '</div>';
						echo '<div class="totalContainer">';
						echo 	'<p><b>Total:</b></p>';
						echo 	'<p class="lightLabel2" id="total">$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></p>';
						echo '</div>';
					?>
				</div>
			</div>
			<div class="nextContainer"><a href="delivery"><button>Siguiente <i class="fas fa-arrow-circle-right"></i></button></a></div>
		</div>
	<?php
		} //end ELSE if cart is empty	
	?>


	<?php include('../modal.php');?>
	<?php include('footer.php');?>
	<script type="text/javascript" src="script/cart.js"></script>
</body>
</html>