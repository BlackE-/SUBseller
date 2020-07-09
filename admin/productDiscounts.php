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
	<link rel="stylesheet" type="text/css" href="css/productsDiscounts.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="coupons"><i class="fas fa-angle-left"></i> Descuentos</a>
				<h1>Productos Descuentos</h1>	
			</div>
			<div class="discountContainer">
				<div class="leftDiv">
					<p>A los productos seleccionados se les agregará el descuento ingresado.</p>
					<p class="little">Ingresar <i>0%</i> y el descuento se eliminará</p>
					<div class="setDescuento">
	                    <!-- <p>Seleccionar los productos a los que se les desea incluir un descuento</p> -->
	                    <p>Ingresar porcentaje de descuento</p>
	                    <input type="text" id="descuentoText" placeholder="%">
	                    <button id="applyDisc">Aplicar Descuento</button>
	                </div>
				</div>
				<div class="rightDiv">
					<?php
						$products = $set->getProducts();
						if(!$products){
					?>
						<p>Sin productos</p>
					<?php
						}else{
						 echo '<table id="example" class="display " style="width:100%">';
			                echo '<thead><tr><th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th><th>SKU</th><th>Foto</th><th>Nombre</th><th>Precio</th><th>Descuento</th></tr></thead><tbody>';
			                foreach ($products as $key => $row){
			                    echo '<tr>';
			                    echo '<td class="dt-body-center"><input type="checkbox" class="checkboxProduct" id="'.$row['id_product'].'"></td>';
			                    echo '<td><p>'.$row['sku'].'</p></td>';
			                    $imgPrincipal = $set->getMedia($row['id_product'],'product');
			                    if(!$imgPrincipal){ echo '<td><p>No Image</p></td>';}
			                    else{echo '<td><img class="thumb" src="../'.$imgPrincipal[0]['url'].'"/></td>';}
			                    echo '<td><a href="product?id_product='.$row['id_product'].'">'.$row['name'].'</a></td>';
			                    echo '<td><p class="price">$'.$row['price_sale'].'</p></td>';
			                    echo '<td><div class="statusContainer">';
			                    if($row['discount'] != '0'){
			                    	$discountShow = ((1 -  $row['discount']) / 1)*100;
			                    	echo '<p>'.$discountShow.' %</p>';
			                    }
			                    else{
			                    	echo 'Sin descuento';
			                    }
			                    echo '</div></td>';
			                    echo '</tr>';
			                }
			                echo '</tbody>';
			                echo '</table>';
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
		<script src="script/productsDiscounts.js"></script>
</body>
</html>