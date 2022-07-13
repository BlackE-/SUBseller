<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		header("Location: login"); 
		exit;
	}
	$id_client = $_GET['id_client'];
	$path = '/subseller';
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>

	<link rel="stylesheet" type="text/css" href="script/datatables/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="css/client.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="clients"><i class="fas fa-angle-left"></i> Clients</a>
				<h1>Client</h1>	
			</div>
			<?php
				$data = $set->getClient($id_client);

				echo '<input id="id_client" type="hidden" value="'.$id_client.'"/>';
			?>
			<div class="leftDiv">
				<div class="order_details">
					<?php
					$orders = $set->getClientOrders($id_client);
					if(!$orders){
						echo '<p><i class="fas fa-inbox"></i> Sin ordenes</p>';
					}else{
						echo '<p>Lista de Pedidos del cliente</p>';
					echo '<table id="example" class="display" style="width:100%">';
	                echo '<thead><tr><th>Order</th><th>Date</th><th>Status</th><th>Type</th><th>Total</th><th></th></tr></thead><tbody>';
	                foreach ($orders as $key => $value) {
	                    echo '<tr>';
	                        echo '<td><p class="id_order">'.$value['id_order'].'</p></td>';
	                        echo '<td><p class="date_created">'.$value['date_created'].'</p></td>';
	                        switch($value['status']){
	                        	case 'PROCESSING':echo '<td><p class="processing">'.$value['status'].'</p></td>';break;
	                        	case 'PENDING PAYMENT':echo '<td><p class="payment">'.$value['status'].'</p></td>';break;
	                        	case 'CANCELED':echo '<td><p class="canceled">'.$value['status'].'</p></td>';break;
	                        	case 'EXPIRED':echo '<td><p class="expired">'.$value['status'].'</p></td>';break;
	                        	case 'COMPLETED':echo '<td><p class="complete">'.$value['status'].'</p></td>';break;
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
			<div class="rightDiv">
				<div class="editContainer">
					<p>Datos del cliente</p>
					<?php
						//details client
						echo '<a href="mailto:"'.$data['email'].'"><p>'.$data['email'].'</p></a>';
						echo '<p>'.$data['name'].'</p>';
						echo '<p>Telefono: '.$data['phone'].'</p>';
						echo '<p>Genero: '.$data['sex'].'</p>';
						echo '<p>Cumpleaños: '.$data['birthday'].'</p>';
					?>
				</div>

				<div class="cartContainer">
					<p>Direciones del cliente</p>
					<?php
						//lista de direcciones guardadas
						$shipping = $set->getClientShippings($id_client);
						if(!$shipping){
							echo '<p><i class="fas fa-home"></i> Sin direcciones</p>';
						}else{
							foreach ($shipping as $key => $value) {
								echo '<details>';
								echo '<summary><b>'.$value['name'].'</b></summary>';
									echo '<div class="shippingBox">';
									echo '<p>Domicilio:</p><p>'.$value['address_line_1'].'</p>';
									echo '<p></p><p>'.$value['address_line_2'].'</p>';
									echo '<p>CP</p><p>'.$value['cp'].'</p>';
									echo '<p>Ciudad</p><p>'.$value['city'].'</p>';
									echo '<p>Estado</p><p>'.$value['state'].'</p>';
									echo '<p>Pais</p><p>'.$value['country'].'</p>';
									echo '</div>';
								echo '</details>';
							}
						}
					?>
				</div>

				<div class="cartContainer">
					<p>Datos fiscales del cliente</p>
					<?php
						//lista de RFC
						$billling = $set->getClientBillings($id_client);
						if(!$billling){
							echo '<p><i class="far fa-file-code"></i> Sin datos fiscales</p>';
						}else{
							foreach ($billling as $key => $value) {
								echo '<details>';
								echo '<summary><b>'.$value['rfc'].'</b></summary>';
									echo '<div class="shippingBox">';
									echo '<p>Razon Social:</p><p>'.$value['razon_social'].'</p>';
									echo '<p>Email</p><p>'.$value['email'].'</p>';
									echo '<p>CFDI</p><p>'.$value['cfdi'].'</p>';
									echo '<p>Dirección</p><p>'.$value['address_line_1'].'</p>';
									echo '<p></p><p>'.$value['address_line_2'].'</p>';
									echo '<p>CP</p><p>'.$value['cp'].'</p>';
									echo '<p>Ciudad</p><p>'.$value['city'].'</p>';
									echo '<p>Estado</p><p>'.$value['state'].'</p>';
									echo '<p>Pais</p><p>'.$value['country'].'</p>';
									echo '</div>';
								echo '</details>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>



	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="script/datatables/datatables.min.js"></script>
		<script src="script/datatables/dataTables.buttons.min.js"></script>
		<script src="script/datatables/buttons.html5.min.js"></script>
		<script src="script/datatables/jszip/jszip.min.js"></script>
		<script src="script/datatables/pdfmaker/pdfmake.min.js"></script>
		<script src="script/datatables/pdfmaker/vfs_fonts.js"></script>
	<script type="text/javascript" src="script/client.js"></script>
</body>
</html>