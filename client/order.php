<?php
	$path = '/subseller';
	require_once  $_SERVER['DOCUMENT_ROOT'].$path."/include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('../login');
		exit();
	}
	$name = $set->getClientName();
    $id_order = $_GET['id_order'];
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
	<link rel="stylesheet" type="text/css" href="css/CLIENT-order.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div id="main">
		<?php include('sidebar.php');?>
		<div class="body">
            <a class="return" href="orders"><i class="fas fa-angle-left"></i> Pedidos</a>
			<h2>Pedido</h2>
			<div id="confirmContainer">
            <?php
                $order = $set->getOrder($id_order);
                $transation = $set->getTransation($id_order);
                $shipping = $set->getShipping($order['shipping_id_shipping']);
            ?>
                <div class="leftContainer">
                    <div id="orderContainer">
                        <?php
                            echo '<div><p>Pedido</p></div><div><p>'.$order['cve_order'].'</p></div>';
                            echo '<div><p>Dirección de envío</p></div>';
                            echo '<div>';
                            echo    '<p>'.$shipping['address_line_1'].'</p>';
                            echo    '<p>'.$shipping['address_line_2'].'</p>';
                            echo    '<p>'.$shipping['cp'].', '.$shipping['city'].'</p>';
                            echo    '<p>'.$shipping['country'].', '.$shipping['state'].'</p>';
                            echo    '<p>'.$shipping['notes'].'</p>';
                            echo '</div>';

                            echo '<div><p>Detalles de pago</p></div>';
                            echo '<div>';
                            echo    '<p class="type">'.$transation['type'].'</p>';
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
                            
                            if(gettype($order['billing_id_billing']) != 'NULL'){

                                $billing = $set->getBilling($order['billing_id_billing']);
                                echo '<div><p>Datos de facturación</p></div>';
                                echo '<div>';
                                echo    '<p>'.$billing['rfc'].'</p>';
                                echo    '<p>'.$billing['razon_social'].'</p>';
                                echo    '<p>'.$billing['cfdi'].'</p>';
                                echo    '<p>'.$billing['email'].'</p>';
                                echo    '<p>'.$billing['address_line_1'].'</p>';
                                echo    '<p>'.$billing['address_line_2'].'</p>';
                                echo    '<p>'.$billing['cp'].', '.$billing['city'].'</p>';
                                echo    '<p>'.$billing['country'].', '.$billing['state'].'</p>';
                                echo '</div>';
                            }
                            

                            // echo    '<div><p class="little">Toda esta información fue enviada por correo.</p></div><div></div>';
                            
                            if($order['coupon_id_coupon'] != ''){
                                $coupon = $set->getCoupon($order['coupon_id_coupon']);
                                echo '<div><p>Datos de cupon utilizado</p></div>';
                                echo '<div>';
                                echo    '<p>'.$coupon['code'].'</p>';
                                echo    '<p>'.$coupon['description'].'</p>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="rightContainer">
                    <?php
                        switch ($order['status']) {
                            case 'PENDING PAYMENT':echo '<p class="status payment">ESPERANDO PAGO</p>';break;
                            case 'PROCESSING':echo '<p class="status processing">PAGADO</p>';break;
                            case 'CANCELED':echo '<p class="status canceled">CANCELED</p>';break;
                            case 'EXPIRED':echo '<p class="status expired">EXPIRADO</p>';break;
                            case 'COMPLETED':echo '<p class="status complete">COMPLETADO</p>';break;
                        }
                    ?>
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
                                        echo    '<img class="thumb" src="..'.$proImg[0]['url'].'"/>';
                                        echo    '<div class="itemDetails">';
                                        echo        '<p class="name">'.$pro['name'].'</p>';
                                        echo        '<p class="sale_price">'.$value['number_items'] . 'x $' . $price[0].'.<sup>'.$price[1].'</sup></p>';
                                        echo    '</div>';
                                        echo    '<div id="id_row_'.$value['id_product'].'">';
                                        echo        '<p class="totalRow" >$'.$priceRow[0].'.<sup>'.$priceRow[1].'</sup></p>';
                                        echo    '</div>';
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
                            $deliveryCost = number_format($order['shipping_fee'], 2, '.', ',');
                            $total = number_format($order['total'], 2, '.', ',');
                            $totalShow = explode('.', $total);
                            $deliveryShow = explode('.', $deliveryCost);

                            echo '<div>';
                            echo    '<p><b>Subtotal:</b></p>';
                            echo    '<div id="subtotalContainer">';
                            echo        '<p class="lightLabel2" id="subtotal">$'.$subtotalShow[0].'.<sup>'.$subtotalShow[1].'</sup></p>';
                            echo    '</div>';
                            echo '</div>';
                            echo '<div>';
                            echo    '<p><b>Gastos de envío:</b></p>';
                            echo    '<div id="deliveryCostContainer">';
                            echo        '<p id="deliveryCost">$'.$deliveryShow[0].'.<sup>'.$deliveryShow[1].'</sup></p>';
                            echo    '</div>';
                            echo '</div>';
                            echo '<div>';
                            echo    '<p><b>Total:</b></p>';
                            echo    '<div id="totalContainer">';
                            echo        '<p class="lightLabel2" id="total">$'.$totalShow[0].'.<sup>'.$totalShow[1].'</sup></p>';
                            echo    '</div>';
                            echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
	<?php include('footer.php');?>
</body>
</html>