<?php
	$id_carousel = $_GET['id_carousel'];
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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

		<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="css/carousel.css">
	</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="theme"><i class="fas fa-angle-left"></i> Theme</a>
				<h1>Carousel Slides</h1>
			</div>
			<div class="carouselContainer">
					<?php
						echo '<input type="hidden" id="id_carousel" value="'.$id_carousel.'">';
							$carousel = $set->getCarousel($id_carousel);
							if(!$carousel){
								$num = 1;
							}else{
								$num = sizeof($carousel) + 1;
							}
					?>
					<form id="carouselSlideForm">
						<div><p>Versión Desktop</p><input type="file" id="typeProductFile"></div>
						<div><p>Versión Mobile</p><input type="file" id="typeProductFileMobile"></div>
						<input type="number" id="numberSlide" disabled <?php echo 'value='.$num;?> />
						<input type="text" id="url" placeholder="URL">
						<textarea id="carousel_slide_text" placeholder="Texto Button"></textarea>
						<input type="submit" name="" value="GUARDAR">
					</form>
					<div>
						<?php
							if(!$carousel){
								echo 'Sin slides';
							}else{
								echo '<ul id="sortable">';
								foreach ($carousel as $key => $value) {
									$slide = $value['carousel'];
									$slide_img = $value['media'];
									echo '<li class="ui-state-default slide" id="'.$slide['id_carousel_slide'].'">';
					                    echo '<div class="row">';
						                    echo '<p>'.$slide['number_slide'].'</p>';
						                    foreach ($slide_img as $key2 => $value2){

						                        echo '<div class="rowImg">';
							                    	echo '<img class="thumb" src="'.$url .$value2[0]['url'].'"/>';
							                    	if(strpos($value2[0]['url'],'mobile')){
							                    		echo '<input type="file" class="changeFotocarousel" title="'.$value2[0]['url'].'" id="media_'.$value2[0]['id_media'].'" name="carousel_mobile"/>
							                    	 		<label for="media_'.$value2[0]['id_media'].'"><span>Cambiar Imagen mobile</span></label>';
							                    	}
							                    	else{
							                    		echo '<input type="file" class="changeFotocarousel" title="'.$value2[0]['url'].'" id="media_'.$value2[0]['id_media'].'" name="carousel"/>
							                    	 <label for="media_'.$value2[0]['id_media'].'"><span>Cambiar Imagen</span></label>';
							                    	}
							                    echo '</div>';
											}
							                echo '<div class="editText">';
							                echo '<input type="text" value="'.$slide['url'].'" id="carousel_url_'.$slide['id_carousel_slide'].'" placeholder="URL"/>';
							                echo '<textarea id="carousel_text_'.$slide['id_carousel_slide'].'" placeholder="texto boton">'.$slide['text'].'</textarea>';
						                    echo '<i class="fas fa-save saveText" title="Actualizar?" id="slide_'.$slide['id_carousel_slide'].'"></i>';
						                    echo '</div>';
						                    echo '<div class="deleteContainer">';
						                	echo '<i class="fa fa-trash delete" title="Eliminar?" id="delete_'.$slide['id_carousel_slide'].'"></i>';
						                	echo '</div>';

						                echo '</div>';
							            
					                echo '</li>';
								
								}
								echo '</ul>';
							}
						?>
					</div>
			</div>
		</div>
	</div>
	<?php include('footer.php');?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../script/jqueryUI/jquery-ui-1.12.1.min.js"></script>
	<script carousel="text/javascript" src="script/carousel.js"></script>
	
</body>
</html>
