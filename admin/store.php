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
										foreach ($brands as $key => $row) {
											echo '<div class="row">';
							                    echo $key +1;
							                    echo '<input type="text" value="'.$row['name'].'" id="brand_'.$row['id_brand'].'"/>';
							                    echo '<i class="fas fa-save save" title="Actualizar?" id="brand_update_'.$row['id_brand'].'"></i>';
							                    if($row['status'] == 0){
							                        echo '<div class="statusContainer"><input type="checkbox" class="status" id="brand_id_'.$row['id_brand'].'"><label for="brand_id_'.$row['id_brand'].'"></label></div>';
							                    }
							                    else{
							                        echo '<div class="statusContainer"><input type="checkbox" checked class="status" id="brand_id_'.$row['id_brand'].'"><label for="brand_id_'.$row['id_brand'].'"></label></div>';
							                    }
							                echo '</div>';
										}
							                
							       	// }

									}
								?>
							</div>
							
						</div>
					</div>
					<div class="option categorias">
						<h2>Categorias</h2>
					</div>
					<div class="option tipoProducto">
						<h2>Tipo de Producto</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php');?>
	<script type="text/javascript" src="script/store.js"></script>
</html>