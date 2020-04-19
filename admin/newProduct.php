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
	<link rel="stylesheet" type="text/css" href="script/selectr/selectr.css">
	<link rel="stylesheet" type="text/css" href="css/productNew.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="products.php"><i class="fas fa-angle-left"></i> Productos</a>
				<h1>Nuevo Producto</h1>	
			</div>
			<div class="leftDiv">
				<div class="product_data">
					<p>Nombre</p>
					<input type="text" name="name" id="name">
					<p>Descripción</p>
					<textarea name="description" id="description"></textarea>
					<p>Descripcion corta</p>
					<input type="text" name="description_short" id="description_short">
					<p>Tiempo de uso</p>
					<input type="text" name="tiempo_de_uso" id="tiempo_de_uso">
				</div>
				<div class="product_img">
					<h4>Imagenes</h4>
					<div>
						<input type="file" name="product_primary" id="product_primary" class="pickThumbnail">
						<label for="product_primary">Elegir imagen thumbnail</label>
					</div>
					
					<div>
						<input type="file" multiple="" name="product_secondary" id="product_secondary" class="pickSecundary">
						<label for="product_secondary">Elegir imagenes de producto</label>
					</div>
				</div>
				<div class="product_price">
					<h4>Precio</h4>
					<div class="priceContainer">
						<p>Precio Venta</p>
						<div><label>$</label><input type="number" id="price_sale" placeholder="0.0"></div>
					</div>
					<div class="priceContainer">
						<p>Precio Unitario</p>
						<div>
							<label>$</label><input type="number" id="price_base" placeholder="0.0">	
						</div>
					</div>
					<div>
						<p style="display: inline-block;">Descuento</p>
						<div class="statusContainerDiv">
							<div class="statusContainer">
								<input type="checkbox" class="status" id="discountStatus">
								<label for="discountStatus"></label>
							</div>
						</div>
						
					</div>

					<div>
						<input type="number" name="discount" id="discount" placeholder="%">
					</div>					
					<!-- <p>Impuesto</p> -->
					<!-- <input type="name" name="tax"> -->
				</div>
				<div class="product_inventory">
					<h4>Inventario</h4>
					<div>
						<p>SKU</p>
						<input type="text" id="sku">
					</div>
					<div>
						<p>Stock</p>
						<input type="number" id="stock">
					</div>
				</div>
			</div>
			<div class="rightDiv">
				<div class="saveContainer">
					<a href="products"><button id="cancel">Cancelar</button></a>
					<button id="saveNewProduct">Guardar</button>
				</div>
				<div class="product_settings">
					<h4>Organización</h4>
					<p>Marca</p>
					<?php
						$brands = $set->getBrands();
						echo '<select id="brandSelect">';
	                    foreach ($brands as $key => $value) {
	                    	$brand = $value['brand'];
	                        echo '<option value="'.$brand['id_brand'].'">'.$brand['name'].'</option>';      
	                    }
	                    echo '</select>';
					?>
					<p>Categoría</p>
					<div>
						<?php
							$categories = $set->getCategories();
							echo '<select id="categorySelect">';
		                    foreach ($categories as $key => $value) {
		                    	$category = $value['category'];
		                        echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';      
		                    }
		                    echo '</select>';
						?>
					</div>
					<p>Tipo</p>
					<?php
						$types = $set->getTypes();
						echo '<select id="typeSelect">';
	                    foreach ($types as $key => $value) {
	                    	$type = $value['type'];
	                        echo '<option value="'.$type['id_product_type'].'">'.$type['name'].'</option>';      
	                    }
	                    echo '</select>';
					?>
					<p>Unidad</p>
					<select name="unit" id="unit">
						<option value="pza">Pieza</option>
						<option value="box">Caja</option>
						<option value="kg">Kilo</option>
						<option value="lt">Litro</option>
					</select>
				</div>
				
				<div class="product_settings_2">
					<h4>Configuración</h4>
					<table>
						<tr>
							<td>
								<div class="statusContainerDiv">
									<p>Status</p>
									<div class="statusContainer">
										<input type="checkbox" class="status" id="status" checked>
										<label for="status"></label>
									</div>
								</div>
							</td>
							<td>
								<div class="favoriteContainerDiv">
									<p>Favorito</p>
									<div class="statusContainer">
										<input type="checkbox" class="favorite" id="favorite">
										<label for="favorite"></label>
									</div>
								</div>
							</td>
						</tr>
					</table>
					
					

					<div class="productorRelacionadosContainerDiv">
						<p>Productos relacionados</p>
						<?php
							$products = $set->getProducts();
							if(!$products){
								echo '<p>No hay productos dados de alta</p>';
							}else{
								echo '<select id="productsSelect">';
			                    foreach ($products as $key => $value) {
			                        echo '<option value="'.$value['id_product'].'">'.$value['name'].'</option>';      
			                    }
			                    echo '</select>';
							}
						?>
					</div>

					<div class="tagsContainerDiv">
						<p>Tags</p>
						<select name="" id="taggable">
						<?php
							$tags = $set->getTags();
							if(!$tags){

							}else{
								foreach ($tags as $key => $value) {
									echo '<option value="'.$value['id_tag'].'">'.$value['name'].'</option>';
								}
							}

						?>
						</select>	
					</div>
				</div>
				
			</div>
			
			
			
		</div>
	</div>
	<?php include ('modal.php');?>
	<?php include('footer.php');?>
	<script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="script/newProduct.js"></script>
</body>
</html>