<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		header("Location: login"); 
		exit;
	}
	$url = substr($_SERVER['REQUEST_URI'], 0, -12);
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<link rel="stylesheet" type="text/css" href="script/datatables/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="css/store.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="storeContainer">
				<div class="nav">
					<button class="buttonOption active" name='marcas'>Marcas</button>
					<button class="buttonOption" name='categorias'>Categorias</button>
					<button class="buttonOption" name='tipoProducto'>Tipo de Producto</button>
				</div>
				<div class="optionsContainers">
					<div class="option marcas active">
						<div class="marcasContainer">
							<form id="brandForm">
								<input type="file" id="brandFile">
									
								<input type="text" id="brandNewName" placeholder="Agregar Nueva Marca">
								<input type="submit" name="" value="GUARDAR">
							</form>
							<div>
								<h2>Marcas</h2>
								<?php
									$brands = $set->getBrands();
									if(!$brands){
										echo '<p>Sin marcas aún</p>';
									}else{
										foreach ($brands as $key => $value) {
											$brand = $value['brand'];
											$brand_img = $value['media'];
											echo '<div class="row">';
							                    echo $key +1;
							                    echo '<img src="'.$url .$brand_img[0]['url'].'"/>';
							                    echo '<input type="file" class="changeFotoBrand" id="brand_file_'.$brand_img[0]['id_media'].'" name="'.$brand['name'].'"/><label for="brand_file_'.$brand_img[0]['id_media'].'"><span>Cambiar Imagen</span></label>';
							                    echo '<input type="text" value="'.$brand['name'].'" id="brand_'.$brand['id_brand'].'"/>';
							                    echo '<i class="fas fa-save save" title="Actualizar?" id="brand_update_'.$brand['id_brand'].'"></i>';
							                    if($brand['status'] == 0){
    												echo '<div class="statusContainer"><input type="checkbox" class="status" id="brand_id_'.$brand['id_brand'].'"><label for="brand_id_'.$brand['id_brand'].'"></label></div>';
							                    }
							                    else{
							                        echo '<div class="statusContainer"><input type="checkbox" checked class="status" id="brand_id_'.$brand['id_brand'].'"><label for="brand_id_'.$brand['id_brand'].'"></label></div>';
							                    }
							                echo '</div>';
										}

									}
								?>
							</div>
						</div>
					</div>
					<div class="option categorias">
						<div class="categoriasContainer">
							<form id="categoryForm">
									<input type="file" id="categoryFile">
									<input type="text" id="categoryNewName" placeholder="Agregar Nueva Categoria">
									
									<input type="submit" name="" value="GUARDAR">
							</form>
							<div>
								<h2>Categorias</h2>
								<?php
									$categories = $set->getCategories();
									if(!$categories){
										echo 'Sin categorias aún';
									}
									else{
										foreach ($categories as $key => $value) {
											$category = $value['category'];
											$category_img = $value['media'];
											echo '<div class="row">';
							                    echo $key +1;
							                    echo '<img src="'.$url.$category_img[0]['url'].'"/>';
							                    echo '<input type="file" class="changeFotoCategory" id="category_file_'.$category_img[0]['id_media'].'" name="'.$category['name'].'"/><label for="category_file_'.$category_img[0]['id_media'].'"><span>Cambiar Imagen</span></label>';
							                    echo '<input type="text" value="'.$category['name'].'" id="category_'.$category['id_category'].'"/>';
							                    echo '<i class="fas fa-save saveCategory" title="Actualizar?" id="category_update_'.$category['id_category'].'"></i>';
							                    if($category['status'] == 0){
    												echo '<div class="statusContainer"><input type="checkbox" class="statusCategory" id="category_id_'.$category['id_category'].'"><label for="category_id_'.$category['id_category'].'"></label></div>';
							                    }
							                    else{
							                        echo '<div class="statusContainer"><input type="checkbox" checked class="statusCategory" id="category_id_'.$category['id_category'].'"><label for="category_id_'.$category['id_category'].'"></label></div>';
							                    }
							                echo '</div>';
										}
									}
								?>
							</div>
						</div>
						
					</div>
					<div class="option tipoProducto">
						<div class="tipoContainer">
							<form id="typeProductForm">
								<div><p>Versión Desktop</p><input type="file" id="typeProductFile"></div>
								<div><p>Versión Mobile</p><input type="file" id="typeProductFileMobile"></div>
								<input type="text" id="typeProductNewName" placeholder="Agregar Nuevo Tipo de Producto">
								<input type="submit" name="" value="GUARDAR">
							</form>
							<div>
								<h2>Tipo de Producto</h2>
								<?php
									$types = $set->getTypes();
									if(!$types){
										echo '<p>Sin tipos de Productos aún</p>';
									}else{
										foreach ($types as $key => $value) {
											$type = $value['type'];
											$type_img = $value['media'];
											echo '<div class="row">';
							                    echo '<div class="typeRow">';
								                    echo $key +1;
								                   	
								                    echo '<input type="text" value="'.$type['name'].'" id="type_'.$type['id_product_type'].'"/>';
								                    echo '<i class="fas fa-save saveType" title="Actualizar?" id="type_update_'.$type['id_product_type'].'"></i>';
								                    if($type['status'] == 0){
	    												echo '<div class="statusContainer"><input type="checkbox" class="statusType" id="type_id_'.$type['id_product_type'].'"><label for="type_id_'.$type['id_product_type'].'"></label></div>';
								                    }
								                    else{
								                        echo '<div class="statusContainer"><input type="checkbox" checked class="statusType" id="type_id_'.$type['id_product_type'].'"><label for="type_id_'.$type['id_product_type'].'"></label></div>';
								                    }
								                echo '</div>';
							                    foreach ($type_img as $key2 => $value2) {
							                    	echo '<img src="'.$url .$value2[0]['url'].'"/>';
							                    	echo '<input type="file" class="changeFototype" title="'.$value2[0]['url'].'" id="type_file_'.$value2[0]['id_media'].'" name="'.$type['name'].'"/><label for="type_file_'.$value2[0]['id_media'].'"><span>Cambiar Imagen</span></label>';
							                    
							                    }
							                echo '</div>';
										}

									}
								?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script type="text/javascript" src="script/store.js"></script>
</html>