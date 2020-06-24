<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		header("Location: login"); 
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<link rel="stylesheet" type="text/css" href="script/datatables/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="css/orders.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main productosContainer">
			<div id="newProductTitle"><h1>Ordernes</h1></div>
			<div>
				<?php
					$orders = $set->getOrders();
	            	if(!$orders){
				?>
					<p>Sin PEDIDOS</p>
				<?php
					}else{
	                echo '<table id="example" class="display" style="width:100%">';
	                echo '<thead><tr><th>Order</th><th>Date</th><th>Client</th><th>Status</th><th>Type</th><th>Total</th><th></th></tr></thead><tbody>';
	                foreach ($orders as $key => $value) {
	                    echo '<tr>';
	                        echo '<td><p class="id_order">'.$value['id_order'].'</p></td>';
	                        echo '<td><p class="date_created">'.$value['date_created'].'</p></td>';
	                        $id_client = $value['client_id_client'];
	                        $name = $set->getClientNameById($id_client);
	                        echo '<td><p class="date_created">'.$name.'</p></td>';
	                        switch($value['status']){
	                        	case 'PROCESSING':echo '<td><p class="processing">'.$value['status'].'</p></td>';break;
	                        	case 'PENDING PAYMENT':echo '<td><p class="payment">'.$value['status'].'</p></td>';break;
	                        	case 'CANCELED':echo '<td><p class="canceled">'.$value['status'].'</p></td>';break;
	                        	case 'REFUNDED':echo '<td><p class="refunded">'.$value['status'].'</p></td>';break;
	                        	case 'COMPLETE':echo '<td><p class="complete">'.$value['status'].'</p></td>';break;
	                        }
	                        echo '<td>';
	                        $typeTransaction = $set->getTypeTransation($value['id_order']);
	                        switch($typeTransaction){
	                            case 'oxxo'://OXXO
	                                echo '<p class="type"><span>OXXO</span><i class="fas fa-dollar-sign"></i></p>';
	                            break; 
	                            case 'card'://tarjeta
	                                echo '<p class="type"><span>CARD</span><i class="fas fa-credit-card"></i></p>';
	                            break;
	                            case 'spei'://SPEI
	                                echo '<p class="type"><span>SPEI</span><i class="fas fa-exchange-alt"></i></p>';
	                            break;
	                            case 'PayPal'://paypal
	                                echo '<p class="type"><span>PAYPAL</span><i class="fab fa-cc-paypal"></i></p>';
	                            break;
	                        }
	                        echo '</td>';
	                        echo '<td><p class="total">$'.number_format($value['total'],2,'.',',').'</p></td>';
	                        echo '<td><a href="order.php?id_order='.$value['id_order'].'"><button><i class="fas fa-arrow-circle-right"></i></button></a></td>';
	                    echo '</tr>';
	                }
	                echo '</tbody>';
	                echo '</table>';
	            }
	        ?>
			</div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="script/datatables/datatables.min.js"></script>
		<script src="script/datatables/dataTables.buttons.min.js"></script>
		<script src="script/datatables/buttons.html5.min.js"></script>
		<script src="script/datatables/jszip/jszip.min.js"></script>
		<script src="script/datatables/pdfmaker/pdfmake.min.js"></script>
		<script src="script/datatables/pdfmaker/vfs_fonts.js"></script>
	<script type="text/javascript" src="script/orders.js"></script>
</body>
</html>