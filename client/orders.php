<?php
	$path = './subseller/';
	require_once  $_SERVER['DOCUMENT_ROOT'].$path."include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('../login');
		exit();
	}
	$name = $set->getClientName();
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
	<link rel="stylesheet" type="text/css" href="css/CLIENT-orders.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div id="main">
		<?php include('sidebar.php');?>
		<div class="body">
			<h2>Pedidos</h2>
			<div id="ordersList">
				    <input class="search" placeholder="Busca tu numero de pedido" />
                <?php
                    $history = $set->getOrdersClient();
            		if(!$history){
            			echo '<p><i class="fas fa-inbox"></i> Sin Ordenes</p>';
            		}
            		else{
            		    echo '<ul class="list">';
            	        foreach ($history as $key => $value) {
            	            echo '<li>';
            	            echo '<a href="order?id_order='.$value['id_order'].'"><div class="liBox">';
                	        echo '<p class="id_pedido">Pedido: #'.$value['cve_order'].'</p>';
                	        switch ($value['status']) {
                	        	case 'PENDING PAYMENT':echo '<p class="status payment">ESPERANDO PAGO</p>';break;
                	        	case 'PROCESSING':echo '<p class="status processing">PAGADO</p>';break;
                	        	case 'CANCELED':echo '<p class="status canceled">CANCELADO</p>';break;
                	        	case 'EXPIRED':echo '<p class="status expired">EXPIRADO</p>';break;
                	        	case 'COMPLETED':echo '<p class="status complete">COMPLETADO</p>';break;
                	        }
                	        $totalFormat = number_format($value['total'],2,'.',',');
                	        $total = explode(".", $totalFormat);
                	        echo '<p class="total">$'.$total[0].'.<sup>'.$total[1].'</sup></p>';
                	        echo '<i class="fas fa-angle-right"></i>';
            	            echo '</div></a>';
            	            echo '</li>';
            	        }
            	        echo '</ul>';
            	        echo '<ul class="pagination"></ul>';
            		    
            		}
                ?>
            </div>
		</div>
	</div>

	<?php include('footer.php');?>
	<script src="../node_modules/list.js/dist/list.min.js"></script>
	<script type="text/javascript" src="script/CLIENT-orders.js"></script>

</body>
</html>