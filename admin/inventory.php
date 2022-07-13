<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		echo $set->getErrorMessage();
		header("Location: login"); 
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<link rel="stylesheet" type="text/css" href="script/datatables/datatables.min.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/inventory.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main productosContainer">
			<div id="newProductTitle"><h1>Inventario</h1></div>
			<div>
				<?php
					$products = $set->getProducts();
					if(!$products){
				?>
					<p>Sin productos</p>
				<?php
					}else{
					 echo '<table id="example" class="display " style="width:100%">';
		                echo '<thead><tr><th>Foto</th><th>SKU</th><th>Cantidad</th><th>Actualizar</th></tr></thead><tbody>';
		                foreach ($products as $key => $row){
		                    echo '<tr>';
		                    $imgPrincipal = $set->getMedia($row['id_product'],'product');
		                    if(!$imgPrincipal){ echo '<td><p>No Image</p></td>';}
		                    else{echo '<td><img class="thumb" src="../'.$imgPrincipal[0]['url'].'"/></td>';}
		                    echo '<td><a href="product?id_product='.$row['id_product'].'">'.$row['sku'].'</a></td>';
		                    $totalInventario = $set->getInventario($row['id_product']);
		                    echo '<td><p class="inventario" id="inventario_'.$row['id_product'].'">'.$totalInventario.' <i class="fas fa-caret-right"></i><input type="number" id="qty_update_'.$row['id_product'].'"/></p></td>';
		                    echo '<td>';
		                    echo '<form class="formUpdateQty" id="updateQry_'.$row['id_product'].'">';
								// echo '<input type="number" min="0" class="inputQty" id="'.$row['id_product'].'"/>';
								echo '<input type="number" class="inputQty" id="'.$row['id_product'].'"/>';
								echo '<input type="submit" value="Guardar" disabled>';
							echo '</form>';
		                    echo '</td>';
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
	<?php include('modal.php');?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="script/datatables/datatables.min.js"></script>
		<script src="script/inventory.js"></script>
</body>
</html>