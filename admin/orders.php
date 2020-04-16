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
	<link rel="stylesheet" type="text/css" href="css/order.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="pedidosContainer">
				<h1>ORDERS</h1>
        		<p>Lista de PEDIDOS de la tienda</p>
			<?php
	            $orders = $set->getOrders();
	            if(!$orders){
	                echo $set->getErrorMessage();
	            }else{
	                echo '<table id="example" class="display" style="width:100%">';
	                echo '<thead><tr><th>Order</th><th>Date</th><th>Client</th><th>Type</th><th>Status</th><th>Total</th></tr></thead><tbody>';
	                while($row = $set->db->fetchArray($productos)){
	                    echo '<tr>';
	                        echo '<td><p class="id_order">'.$row['id_order'].'</p></td>';
	                        echo '<td><p class="date_order">'.$row['date_order'].'</p></td>';
	                        $id_client = $row['client_id_client'];
	                        $name = $set->getClientNameById($id_client);
	                        echo '<td><p class="date_order">'.$row['date_order'].'</p></td>';
	                        echo '<td><p>'.$row['status'].'</p></td>';
	                        echo '<td><p>'.$row['total'].'</p></td>';
	                        echo '<td>';
	                        $typeTransaction = $set-getTypeTransation($row['id_order']);
	                        switch($typeTransaction){
	                            case 'oxxo'://OXXO
	                                echo '<i class="far fa-money-bill-alt"></i>';
	                            break; 
	                            case 'card'://tarjeta
	                                echo '<i class="far fa-credit-card"></i>';
	                            break;
	                            case 'spei'://SPEI
	                                echo '<i class="fas fa-file-invoice-dollar"></i>';
	                            break;
	                            case 'paypal'://paypal
	                                echo '<i class="fab fa-cc-paypal"></i>';
	                            break;
	                        }
	                        echo '</td>';
	                        echo '<td><a href="order.php?id_order='.$row['id_order'].'"><button><i class="fas fa-arrow-circle-right"></i></button></a></td>';
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
</body>
</html>