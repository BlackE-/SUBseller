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
			<div class="product_data">
				<p>Nombre</p>
				<input type="text" name="name">
				<p>Descripción</p>
				<textarea name="description"></textarea>
				<p>Descripcion corta</p>
				<input type="text" name="description_short">
				<p>Tiempo de uso</p>
				<input type="text" name="tiempo_de_uso">
			</div>
			<div class="product_settings">
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
                        echo '<option value="'.$type['id_type'].'">'.$type['name'].'</option>';      
                    }
                    echo '</select>';
				?>
				<p>Unidad</p>
				<select name="unit">
					<option value="pza">Pieza</option>
					<option value="box">Caja</option>
					<option value="kg">Kilo</option>
					<option value="lt">Litro</option>
				</select>
			</div>
			<div class="product_img"></div>
			<div class="product_settings">
				<div class="statusContainerDiv">
					<p>Status</p>
					<div class="statusContainer">
						<input type="checkbox" class="status" id="status" checked>
						<label for="status"></label>
					</div>
				</div>
				<div class="favoriteContainerDiv">
					<p>Favorito</p>
					<div class="favoriteContainer">
						<input type="checkbox" class="favorite" id="favorite">
						<label for="favorite"></label>
					</div>
				</div>

				<div class="productorRelacionadosContainerDiv">
					<p>Productos relacionados</p>
					<p>select multiple</p>
				</div>

				<div class="tagsContainerDiv">
					<p>Tags</p>
					<form action="">
						<select name="" id="taggable">
							<option value="foo">foo</option>
						</select>			
					</form>	
				</div>



			</div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="script/newProduct.js"></script>
</body>
</html>