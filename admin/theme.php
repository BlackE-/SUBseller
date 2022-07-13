<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
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
	<link rel="stylesheet" type="text/css" href="css/theme.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="storeContainer">
				<div class="nav">
					<button class="buttonOption active" name='carousel'>Carousel</button>
					<button class="buttonOption" name='html'>HTML Contenido</button>
				</div>
				<div class="optionsContainers">
					<div class="option carousel active">
						<div class="carouselContainer">
							<form id="carouselForm">
								<input type="text" id="carouselNew" placeholder="Agregar Nuevo Carousel">
								<input type="submit" name="" value="GUARDAR">
							</form>
							<div>
								<h2>Carousels</h2>
								<?php
									$carousels = $set->getCarousels();
									if(!$carousels){
										echo '<p>Sin Carousels aún</p>';
									}else{
										foreach ($carousels as $key => $value) {
											echo '<div class="row">';
							                    echo '<a href="carousel?id_carousel='.$value['id_carousel'].'"><button>'.$value['id_carousel'].'</button></a>';
							                    echo '<input type="text" value="'.$value['name'].'" id="carousel_'.$value['id_carousel'].'"/>';
							                    echo '<i class="fas fa-save save" title="Actualizar?" id="carousel_update_'.$value['id_carousel'].'"></i>';
							                    if($value['status'] == 0){
    												echo '<div class="statusContainer"><input type="checkbox" class="status" id="carousel_id_'.$value['id_carousel'].'"><label for="carousel_id_'.$value['id_carousel'].'"></label></div>';
							                    }
							                    else{
							                        echo '<div class="statusContainer"><input type="checkbox" checked class="status" id="carousel_id_'.$value['id_carousel'].'"><label for="carousel_id_'.$value['id_carousel'].'"></label></div>';
							                    }
							                echo '</div>';
										}

									}
								?>
							</div>
						</div>
					</div>
					<div class="option html">
						<div class="categoriasContainer">
							<form id="htmlForm">
								<select id="type">
									<option value="1" selected="">Opción 1 - Background</option>
								</select>
									<div id="div_1">
										<select id="url_page_1">
											<option value="index">Home</option>
										</select>
										<input type="file" id="file_1">
										<input type="text" id="text1_1" placeholder="Texto 1">
										<input type="text" id="text2_1" placeholder="Texto 2">
										<input type="text" id="textButton1" placeholder="Texto Button">
										<input type="text" id="url_1" placeholder="URL button">
									</div>
								<div>
									<input type="submit" name="" value="GUARDAR">
								</div>
							</form>
							<div>
								<h2>HTML Contenido</h2>
								<?php
									$htmls = $set->getHTML();
									if(!$htmls){
										echo 'Sin contenido aún';
									}else{
										foreach ($htmls as $key => $value) {
											// print_r($value);
											echo '<div class="htmlDiv">';
											if($value['status'] == 0){
												echo '<div class="statusContainer"><input type="checkbox" class="statusHTML" id="html_id_'.$value['id_html_content'].'"><label for="html_id_'.$value['id_html_content'].'"></label></div>';
						                    }
						                    else{
						                        echo '<div class="statusContainer"><input type="checkbox" checked class="statusHTML" id="html_id_'.$value['id_html_content'].'"><label for="html_id_'.$value['id_html_content'].'"></label></div>';
						                    }
											// echo '<textarea disabled>'.$value['text'].'</textarea>';
											echo '<div style="border:1px solid #ccc;">'.$value['text'].'</div>';
											// echo '<i class="fas fa-save saveHTML" title="Actualizar?" id="'.$value['id_html_content'].'"></i>';
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
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/theme.js"></script>
</html>