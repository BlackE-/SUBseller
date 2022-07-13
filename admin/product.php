<?php
	$id_product = $_GET['id_product'];
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		echo $set->getErrorMessage();
		header("Location: login"); 
		exit;
	}
	$path = explode('admin',$_SERVER['REQUEST_URI']);
	$url = $path[0];
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>

	<link rel="stylesheet" type="text/css" href="script/chosen/chosen.min.css">
	<link rel="stylesheet" type="text/css" href="css/product.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<form id="productForm">
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="products"><i class="fas fa-angle-left"></i> Productos</a>
				<h1>Producto</h1>	
			</div>
			<?php
				$product = $set->getProduct($id_product);
				echo '<input id="id_product" type="hidden" value="'.$id_product.'"/>';
			?>
			<div class="leftDiv">
				<div class="product_data">
					<p>Nombre</p>
					<?php echo '<input type="text" id="name" value="'.$product['name'].'"/>';?>
					<p>Descripción</p>
					<?php echo '<textarea name="description" id="description">'.$product['description'].'</textarea>';?>
					<p>Descripcion corta</p>
					<?php echo '<input type="text" id="description_short" value="'.$product['description_short'].'"/>';?>
					<p>Tiempo de uso</p>
					<?php echo '<input type="text" id="tiempo_de_uso" value="'.$product['tiempo_de_uso'].'"/>';?>
				</div>
				<div class="product_img">
					<h4>Imagenes</h4>
					<div>
						<?php 
							$imgPrincipal = $set->getMedia($id_product,'product');
							if(!$imgPrincipal){
								echo '<input type="file" name="" title="'.$id_product.'" id="product_primary" class="pickThumbnail">
										<label for="product_primary">Elegir imagen thumbnail</label>';
							}else{
								echo '<input type="file" name="'.$imgPrincipal[0]['id_media'].'" title="'.$id_product.'" id="product_primary" class="pickThumbnail">
										<label for="product_primary">Cambiar imagen thumbnail</label>';
								echo '<img src="'.$url.$imgPrincipal[0]['url'].'" />';
								
							}
							
						?>
						
					</div>
					<div class="secondaryContainerDiv">
						<?php
							echo '<input type="file" title="'.$id_product.'" name="product_secondary" id="product_secondary" class="pickSecundary">
								<label for="product_secondary">Elegir imagenes de producto</label>';

							$imgSecundary = $set->getMedia($id_product,'product_secondary');
							if(!$imgSecundary){

							}else{
								foreach ($imgSecundary as $key => $value) {
									$img = $value;
									echo '<div class="secondaryContainer"><img class="secondary" src="'.$url.$img['url'].'" /><label id="'.$img['id_media'].'" name="'.$id_product.'" class="removeImage">&times;</label></div>';
								}
							}
							

							
						?>
						
					</div>
				</div>
				<div class="product_price">
					<h4>Precio</h4>
					<div class="priceContainer">
						<p>Precio Venta</p>
						<div>
							<label>$</label>
							<?php echo '<input type="number" id="price_sale" placeholder="0.0" value="'.$product['price_sale'].'"/>';?>
						</div>
					</div>
					<div class="priceContainer">
						<p>Precio Unitario</p>
						<div>
							<label>$</label>
							<?php echo '<input type="number" id="price_base" placeholder="0.0" value="'.$product['price_base'].'"/>';?>
						</div>
					</div>
					<div>
						<p style="display: inline-block;">Descuento</p>
						<div class="statusContainerDiv">
							<div class="statusContainer">
								<?php
									if($product['discount']==0){
										echo '<input type="checkbox" class="status" id="discountStatus">';
									}
									else{
										echo '<input type="checkbox" class="status" id="discountStatus" checked>';
									}
								?>
								<label for="discountStatus"></label>
							</div>
						</div>
						
					</div>

					<div>
						<?php
							if($product['discount']==0){
								echo '<input type="number" name="discount" id="discount" placeholder="%">';
							}
							else{
								$discount = $product['discount'];
								echo '<input type="number" name="discount" id="discount" placeholder="% value="'.$discount.'">';
							}
						?>
						
					</div>					
					<!-- <p>Impuesto</p> -->
					<!-- <input type="name" name="tax"> -->
				</div>
				<div class="product_inventory">
					<h4>Inventario</h4>
					<div>
						<p>SKU</p>
						<?php echo '<input disabled type="text" id="sku" value="'.$product['sku'].'"/>';?>
					</div>
				</div>
			</div>
			<div class="rightDiv">
				<div class="saveContainer">
					<a href="products" id="cancel">Cancelar</a>
					<input type='submit' id="saveNewProduct" value="GUARDAR"/>
				</div>
				<div class="product_settings">
					<h4>Organización</h4>
					<p>Marca</p>
					<?php
						$brands = $set->getBrands();
						echo '<select id="brandSelect">';
	                    foreach ($brands as $key => $value) {
	                    	$brand = $value['brand'];
	                    	if($brand['id_brand'] == $product['brand_id_brand']){echo '<option value="'.$brand['id_brand'].'" selected>'.$brand['name'].'</option>';}
	                        else{echo '<option value="'.$brand['id_brand'].'">'.$brand['name'].'</option>';}     
	                    }
	                    echo '</select>';
					?>
					<p>Categoría</p>
					<div>
						<?php
							echo '<select id="categorySelect" multiple data-placeholder="Elegir categoria">';
							$product_categories = $set->getProductCategories($id_product);
							$categories = $set->getCategories();
							if(!$product_categories){
								foreach ($categories as $key => $value) {
			                    	$category = $value['category'];
			                        echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>';      
			                    }
							}else{
								foreach ($categories as $key => $value) {
			                    	$category = $value['category'];
			                    	if(in_array($category['id_category'], $product_categories)){
			                    		echo '<option value="'.$category['id_category'].'" selected>'.$category['name'].'</option>';
			                    	}else{
			                    		echo '<option value="'.$category['id_category'].'">'.$category['name'].'</option>'; 
			                    	}    
			                    }
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
	                    	if($type['id_type']){echo '<option value="'.$type['id_type'].'" selected>'.$type['name'].'</option>';}
	                        else{echo '<option value="'.$type['id_type'].'">'.$type['name'].'</option>';  }    
	                    }
	                    echo '</select>';
					?>
					<p>Unidad</p>
					<select name="unit" id="unit">
						<?php
							$str = '';
							if($product['unit'] == 'Pieza'){
								$str = '<option value="Pieza" selected>Pieza</option>';
							}
							else{
								$str='<option value="Pieza">Pieza</option>';
							}
							echo $str;
						?>
						<?php
							if($product['unit'] == 'Caja'){
								$str = '<option value="Caja" selected>Caja</option>';
							}
							else{
								$str='<option value="Caja">Caja</option>';
							}
							echo $str;
						?>
						<?php
							if($product['unit'] == 'Kilo'){
								$str = '<option value="Kilo" selected>Kilo</option>';
							}
							else{
								$str='<option value="Kilo">Kilo</option>';
							}
							echo $str;
						?>
						<?php
							if($product['unit'] == 'Litro'){
								$str = '<option value="Litro" selected>Litro</option>';
							}
							else{
								$str='<option value="Litro">Litro</option>';
							}
							echo $str;
						?>
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
										<?php
											if($product['status'] == 0){
												echo '<input type="checkbox" class="status" id="status">';
											}
											else{
												echo '<input type="checkbox" class="status" id="status" checked>';
											}
										?>
										<label for="status"></label>
									</div>
								</div>
							</td>
							<td>
								<div class="favoriteContainerDiv">
									<p>Favorito</p>
									<div class="statusContainer">
										<?php
											if($product['fav'] == 0){
												echo '<input type="checkbox" class="favorite" id="favorite">';
											}
											else{
												echo '<input type="checkbox" class="favorite" id="favorite" checked>';
											}
										?>
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
								echo '<select id="productsSelect" multiple data-placeholder="Elegir productos relacionados">';
								if($product['product_related'] == 0){
									foreach ($products as $key => $value) {
										if($value['id_product'] != $id_product){echo '<option value="'.$value['id_product'].'">'.$value['name'].'</option>';}      
			                    	}	
								}else{
									$product_related = explode(',', $product['product_related']);
									foreach ($products as $key => $value) {
										if($value['id_product'] != $id_product){
											if(in_array($value['id_product'], $product_related)){
					                        	echo '<option value="'.$value['id_product'].'" selected>'.$value['name'].'</option>';  
					                        }else{
					                        	echo '<option value="'.$value['id_product'].'">'.$value['name'].'</option>';  
					                        }  
										}
										
			                    	}
								}
			                    
			                    echo '</select>';
							}
						?>
					</div>

					<div class="tagsContainerDiv">
						<p>Tags</p>
						<select name="" id="taggable" multiple data-placeholder="Elegir tags">
						<?php
							$tags = $set->getTags();
							$product_tags = $set->getProductTags($id_product);
							if(!$tags){

							}else{
								echo '';
								if(!$product_tags){
									foreach ($tags as $key => $value) {
										echo '<option value="'.$value['id_tag'].'">'.$value['name'].'</option>';
									}
								}else{
									foreach ($tags as $key => $value) {
										if(in_array($value['id_tag'], $product_tags)){
											echo '<option value="'.$value['id_tag'].'" selected>'.$value['name'].'</option>';}
										else{echo '<option value="'.$value['id_tag'].'">'.$value['name'].'</option>';}
										
									}
								}
							}

						?>
						</select>
						<div class="addTag">
							<input type="text" id="addTag" placeholder="Agregar Tag"/>
							<p class="saveTag"><i class="fas fa-save"></i></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="script/product.js"></script>
</body>
</html>