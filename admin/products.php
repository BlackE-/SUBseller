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
	<link rel="stylesheet" type="text/css" href="css/products.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main productosContainer">
			<div id="newProductTitle"><h1>Productos</h1></div>
			<div id="newProductContainer">
				<div><input type="file" class="importProducts" id="import" accept=".csv"/><label for="import">Importar <i class="fas fa-upload"></i></label></div>
				<div><a href="newProduct"><button class="newProduct">Nuevo Producto <i class="fas fa-tags"></i></button></a></div>
			</div>
			<div>
				<?php
					$products = $set->getProducts();
					if(!$products){
				?>
					<p>Sin productos</p>
				<?php
					}else{
					 echo '<table id="example" class="display " style="width:100%">';
		                echo '<thead><tr><th>Foto</th><th>SKU</th><th>Nombre</th><th>Precio</th><th>Status</th><th>Fav</th><th>Inventario</th></tr></thead><tbody>';
		                foreach ($products as $key => $row){
		                    echo '<tr>';
		                    $imgPrincipal = $set->getMedia($row['id_product'],'product');
		                    if(!$imgPrincipal){ echo '<td><p>No Image</p></td>';}
		                    else{echo '<td><img class="thumb" src="../'.$imgPrincipal[0]['url'].'"/></td>';}
		                    echo '<td><p>'.$row['sku'].'</p></td>';
		                    echo '<td><a href="product?id_product='.$row['id_product'].'">'.$row['name'].'</a></td>';
		                    echo '<td><p class="price">$'.$row['price_sale'].'</p></td>';
		                    echo '<td><div class="statusContainer">';
		                    if($row['status']){echo '<input type="checkbox" checked class="status" id="'.$row['id_product'].'"><label for="'.$row['id_product'].'"/>';}
		                    else{echo '<input type="checkbox" class="status" id="'.$row['id_product'].'"><label for="'.$row['id_product'].'"/>';}
		                    echo '</div></td>';
		                    echo '<td><div class="favContainer">';
		                    if($row['fav']){echo '<input type="checkbox" checked class="fav" id="fav_'.$row['id_product'].'"><label for="fav_'.$row['id_product'].'"><span><i class="fas fa-star"></i></span></label>';}
		                    else{echo '<input type="checkbox" class="fav" id="fav_'.$row['id_product'].'"><label for="fav_'.$row['id_product'].'"><span><i class="fas fa-star"></i></span></label>';}
		                    echo '</div></td>';
		                    $totalInventario = $set->getInventario($row['id_product']);
		                    echo '<td><p class="inventario">'.$totalInventario.'</p></td>';
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
		<script src="script/datatables/dataTables.buttons.min.js"></script>
		<script src="script/datatables/buttons.html5.min.js"></script>
		<script src="script/datatables/jszip/jszip.min.js"></script>
		<script src="script/datatables/pdfmaker/pdfmake.min.js"></script>
		<script src="script/datatables/pdfmaker/vfs_fonts.js"></script>
		<script src="script/products.js"></script>
</body>
</html>