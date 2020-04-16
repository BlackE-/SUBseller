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
	<link rel="stylesheet" type="text/css" href="script/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="css/product.css">
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
					// echo '<select data-placeholder="Marca" class="chosen-select">';
     //                while($prodR = mysql_fetch_array($prod)){
     //                    echo '<option value="'.$prodR['id_producto'].'">'.$prodR['nombre'].'</option>';
     //                }
     //                echo '</select>';
				?>
				<p>Categoría</p>
				<div>
					<?php
						// echo '<select data-placeholder="Elegir tags" multiple class="chosen-select-categories">';
      //                   while($prodR = mysql_fetch_array($prod)){
      //                       echo '<option value="'.$prodR['id_tag'].'">'.$prodR['valor'].'</option>';
      //                   }
      //                   echo '</select>';
					?>
				</div>
				<p>Tipo</p>
				<?php
					//$type = $set->getType();
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
			<div class="product_img"></div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script src="script/chosen/chosen.jquery.js"></script>
	<script type="text/javascript" src="newProduct.js"></script>
</body>
</html>