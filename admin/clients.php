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
	<link rel="stylesheet" type="text/css" href="css/clients.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main productosContainer">
			<div id="newProductTitle"><h1>Clientes</h1></div>
			<div>
				<?php
					$clients = $set->getClients();
	            	if(!$clients){
				?>
					<p>Sin Clientes</p>
				<?php
					}else{
	                echo '<table id="example" class="display" style="width:100%">';
	                echo '<thead><tr><th></th><th>Cliente</th><th># ordenes</th><th>$</th><th></th></thead><tbody>';
	                foreach ($clients as $key => $value) {
	                    echo '<tr>';
	                        echo '<td><p class="id_client">'.$value['id_client'].'</p></td>';
	                        echo '<td><p class="name">'.$value['name'].'</p></td>';
	                        echo '<td><p class="ordes">'.$value['NUM'].'</p></td>';
	                        echo '<td><p class="total">$'.number_format($value['TOTAL'],2,'.',',').'</p></td>';
	                        echo '<td><a href="client.php?id_client='.$value['id_client'].'"><button><i class="fas fa-arrow-circle-right"></i></button></a></td>';
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
	<script type="text/javascript" src="script/clients.js"></script>
</body>
</html>