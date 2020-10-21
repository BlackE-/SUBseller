<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	$path = '/subseller';
?>

<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/index");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>

	<link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="bodyContainer">
		<div id="carouselContainer">
			<?php
				$carousel = $set->getCarousel();
				if(!$carousel){
					echo $set->getErrorMessage();
				}else{
					echo '<div id="glideCarousel">';
						echo '<div class="glide__track" data-glide-el="track">';
						echo 	'<ul class="glide__slides">';
						$count = 0;
						foreach ($carousel as $key => $value) {
							$slide = $value['carousel'];
							$img = $value['media'];
							$imgMobile = $value['media_mobile'];
							echo '<li class="glide__slide">';
							if($slide['url'] != ''){
								echo '<a href="'.$slide['url'].'">';'</a>';
							}
							echo '<img class="slideImg" src="'.$path.$img[0]['url'].'"/>';
							echo '<img class="slideImgMobile" src="'.$path.$imgMobile[0]['url'].'"/>';
							if($slide['url'] != ''){
								echo '</a>';
							}
							echo '</li>';
							$count++;
						}
						echo 	'</ul>';
						echo '</div>';
						if($count > 1){
							echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
							for ($i=0; $i < $count ; $i++) { 
								echo '<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
							}
							echo '</div>';
						}
					echo '</div>';
				}
			?>
		</div>
		<div id="tagsContainer">
			<div class="container">
	            <?php
	                $tags = $set->getFavouriteTags();
	                if(!$tags){
	                    
	                }else{
	                    echo '<p>BÚSQUEDAS POPULARES:</p>';
	                    echo '<ul>';
	                    foreach ($tags as $key => $value) {
	                    	echo '<li><a href="store?page=tag&id='.$value['id_tag'].'">'.$value['name'].'</a></li>';
	                    }
	                    echo '</ul>';
	                }
	            ?>
	        </div>
		</div>
		<div id="favouriteContainer">
			<?php
				$bestSellers = $set->getBestSellers();
				if(!$bestSellers){}else{
			?>	
				<div class="container" >
		            <h1>Más Vendidos</h1>
		        </div>
		       	<div class="container">
		            <div id="glideBestSellers">
						<div class="glide__track" data-glide-el="track">
							<ul class="glide__slides">
			                <?php
			                	$count = 0;
			                	foreach ($bestSellers as $key => $value) {
			                		$product = $value['product'];
			                		$product_img = $value['media'];
			                		$type = $set->getProductTypeName($product['type_id_type']);
			                		$price_sale = $product['price_sale'];
			                		if($product['discount'] != 0){$price_sale = number_format($product['price_sale'] * $product['discount'],2,'.',',');}
			                		$price = explode('.',$price_sale);
			                		echo '<li>';
			                		echo '<div class="box">';
			                		echo 	'<div class="typeContainer"><p>'.$type.'</p></div>';
			                		echo 	'<div class="boxBorder">';
				                	echo 		'<a href="product?id='.$product['id_product'].'">';
				                	echo 			'<div class="thumbContainer" style="background-image:url('.$path.$product_img[0]['url'].')"/></div>';
				                	echo 		'</a>';
				                	echo 		'<div class="textContainer">';
				                	echo 			'<p>Tiempo de uso:'.$product['tiempo_de_uso'].'</p>';
				                	echo 			'<p class="title">'.$product['name'].'<br>'.$product['description_short'].'</p>';
				                	echo 		'</div>';
				                	echo 		'<div class="priceContainer">$'.$price[0].'.<sup>'.$price[1].'</sup></div>';
				                	echo 		'<div class="addCartContainer">';
				                	echo 			'<a href="product?id='.$product['id_product'].'"><i class="fas fa-plus"></i> Ver producto</a>';
				                	echo 		'</div>';
			                		echo 	'</div>';
			                		echo '</div>';
			                		echo '</li>';
			                		$count++;
			                	}
			                ?>
			            	</ul>
			            </div>
		            	<?php
							if($count > 2){
								echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
								for ($i=0; $i < $count ; $i++) { 
									echo '<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
								}
								echo '</div>';
							}
		            	?>
		            </div>
		        </div> 
			<?php
				}
			?>
		</div>
		<div id="categoriesContainer">
			<div class="container"><h1>ENCUENTRA POR CATEGORIA</h1></div>
			<div class="container">
				<?php
					$categories = $set->getCategories();
					if(!$categories){

					}else{
						foreach ($categories as $key => $value) {
							$category = $value['category'];
							$category_img = $value['media'];
							echo '<a href="store?page=category&id='.$category['id_category'].'">';
							echo '<div class="box">';
							echo '<img src="'.$path.$category_img[0]['url'].'"/>';
							echo '<p>'.$category['name'].'</p>';
							echo '</div>';
							echo '</a>';
						}
					}
				?>
			</div>
		</div>
		<div id="brandsContainer">
			<div class="container">
				<?php
					$brands = $set->getBrands();
					if(!$brands){

					}else{
						echo '<div id="glideBrands">';
						echo	'<div class="glide__track" data-glide-el="track">';
						echo		'<ul class="glide__slides">';
								foreach ($brands as $key => $value) {
									$brand = $value['brand'];
									$brand_img = $value['media'];
									echo '<li class="glide__slide">';
									echo '<div>';
									echo '<a href="store?page=brand&id='.$brand['id_brand'].'"><img src="'.$path.$brand_img[0]['url'].'"/></a>';
									echo '</div>';
									echo '</li>';
								}
						echo 		'</ul>
				            	</div>';
				        echo '<div class="glide__arrows" data-glide-el="controls">';
						echo 	'<button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>';
						echo 	'<button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>';
						echo '</div>';
						echo '</div>';
					}
	            ?>
	        </div>
	    </div>
	    <div id="htmlContentContainer">
	    	<?php
	    		$htmlContent = $set->getHTMLContentIndex('desktop');
	    		if(!$htmlContent){

	    		}else{
	    			echo $htmlContent[0]['text'];
	    		}
	    	?>
	    </div>
	    <div id="newsletter">
	        <div class="container">
	                <div class="boletinBox">
	                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
						  <path fill="#2361f0" fill-rule="evenodd" d="M253.688,2306.01a4.631,4.631,0,0,1-3.292-1.37l-16.037-16.03a4.631,4.631,0,0,1-1.364-3.3,4.7,4.7,0,0,1,1.364-3.29l18.091-18.09A6.514,6.514,0,0,1,257.1,2262h15.243a4.652,4.652,0,0,1,4.655,4.66v15.23a6.547,6.547,0,0,1-1.926,4.66l-18.093,18.09A4.68,4.68,0,0,1,253.688,2306.01Zm3.416-41.13a3.676,3.676,0,0,0-2.621,1.08l-18.09,18.1a1.787,1.787,0,0,0-.522,1.25,1.755,1.755,0,0,0,.522,1.26l16.037,16.04a1.827,1.827,0,0,0,2.517,0l18.09-18.09a3.7,3.7,0,0,0,1.085-2.63v-15.23a1.792,1.792,0,0,0-.521-1.26,1.75,1.75,0,0,0-1.257-.52H257.1Zm9.112,13.15a5.233,5.233,0,1,1,3.7-1.53A5.236,5.236,0,0,1,266.216,2278.03Zm-0.006-7.6a2.362,2.362,0,1,0,2.181,1.46A2.364,2.364,0,0,0,266.21,2270.43Zm-9.945,19.42a2.51,2.51,0,1,1-2.51-2.51A2.508,2.508,0,0,1,256.265,2289.85Zm0,7.11a2.51,2.51,0,1,1-2.51-2.51A2.508,2.508,0,0,1,256.265,2296.96Z" transform="translate(-233 -2262)"/>
						</svg>

	                    <p><b>10% de descuento<br></b>Suscríbete al boletín</p>
	                </div>
	                <form id="newsletterForm">
	                    <input type="text" class="emailNewsletter" placeholder="Ingresa tu correo electrónico"/><button class="sendNewsletter">ENVIAR</button>
	                </form>
	        </div>
		</div>
		<div id="hr"><div class="container"><hr></div></div>
		<div id="paymentContainer">
			<p class="title">FORMAS DE PAGO:</p>
		    <div class="container" >
		        <div>
		            <p>EFECTIVO</p>
		            <img src="img/oxxo.png"/>
		        </div>
		        <div>
		            <p>CRÉDITO Y DÉBITO</p>
		            <img src="img/amex.png"/>
		            <img src="img/carnet.png"/>
		            <img src="img/mastercard.png"/>
		            <img src="img/visa.png"/>
		            <img src="img/pagaflex.png"/>
		        </div>
		        <div>
		            <p>TRANSFERENCIA</p>
		            <img src="img/spei.png"/>
		        </div>
		        <div>
		            <img src="img/paypal.png"/>
		        </div>
		        <div>
		            <p>PAGO PROTEGIDO POR:</p>
		            <img src="img/logo_conekta.svg">
		        </div>
		    </div>
		</div>
	</div>
    

	<?php include('modal.php');?>
	<?php include('footer.php');?>
	<script src="node_modules/@glidejs/glide/dist/glide.min.js"></script>
	<script type="text/javascript" src="script/index.js"></script>
</body>
</html>