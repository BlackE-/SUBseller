<?php
	require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	$path = '/subseller/phone';
?>
<!DOCTYPE html>
<html>
<head>
    <?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" href="../node_modules/@glidejs/glide/dist/css/glide.core.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php include('header.php');?>
	<div id="carouselContainer">
		<?php
			$carousel = $set->getCarousel();
			if(!$carousel){
				echo $set->getErrorMessage();
			}else{
				// echo '<div id="glideCarousel">';
				// 	echo '<div class="glide__track" data-glide-el="track">';
				// 	echo 	'<ul class="glide__slides">';
				// 	$count = 0;
				// 	foreach ($carousel as $key => $value) {
				// 		$slide = $value['carousel'];
				// 		$imgMobile = $value['media_mobile'];
				// 		echo '<li class="glide__slide">';
				// 		echo '<img class="slideImg" src="'.$path.$img[0]['url'].'"/>';
				// 		echo '<img class="slideImgMobile" src="'.$path.$imgMobile[0]['url'].'"/>';
				// 		if($slide['url'] != ''){
				// 			echo '<div class="buttonContainer"><div class="container"><a href="'.$slide['url'].'"><button>'.$slide['text'].'</button></a></div></div>';
				// 		}
				// 		echo '</li>';
				// 		$count++;
				// 	}
				// 	echo 	'</ul>';
				// 	echo '</div>';
				// 	if($count > 1){
				// 		echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
				// 		for ($i=0; $i < $count ; $i++) { 
				// 			echo '<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
				// 		}
				// 		echo '</div>';
				// 	}
				// echo '</div>';
			}
		?>
	</div>
	<?php
		$bestSellers = $set->getBestSellers();
		if(!$bestSellers){

		}else{
	?>	
		<div id="favouriteContainer">
			<div class="container" >
	            <h1>Más Vendidos</h1>
	        </div>
	       	<div class="container">
	            <div id="glideBestSellers">
					<div class="glide__track" data-glide-el="track">
						<ul class="glide__slides">
		                <?php
		                	// $count = 0;
		                	// foreach ($bestSellers as $key => $value) {
		                	// 	$product = $value['product'];
		                	// 	$product_img = $value['media'];
		                	// 	echo '<li>';
		                	// 	$type = $set->getProductTypeName($product['type_id_type']);
		                		
		                	// 	echo '<div class="box">';
		                	// 	echo '<div class="typeContainer"><p>'.$type.'</p></div>';
		                	// 	echo '<div class="boxBorder">';
			                // 		echo '<div class="thumbContainer"><a href="product/'.$product['id_product'].'"><img class="bestSellersImg" data-src="'.$path.$product_img[0]['url'].'"/></a></div>';
			                // 		echo '<div class="textContainer"><p>Tiempo de uso:'.$product['tiempo_de_uso'].'</p><p class="title">'.$product['name'].'<br>'.$product['description_short'].'</p></div>';
			                // 		$price_sale = $product['price_sale'];
			                // 		if(!$product['discount']){
			                // 			$price_sale = $product['price_sale'] * $product['discount'];
			                // 		}
			                // 		echo '<div class="priceContainer">$'.number_format($price_sale, 2).'</div>';
			                // 		echo '<div class="addCartContainer"><a href="product/'.$product['id_product'].'"><i class="fas fa-plus"></i> Agregar al carrito</a></div>';
		                	// 	echo '</div>';
		                	// 	echo '</div>';
		                	// 	echo '</li>';
		                	// 	$count++;
		                	// }
		                ?>
		            	</ul>
		            </div>
		            	<?php
							// if($count > 2){
							// 	echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
							// 	for ($i=0; $i < $count ; $i++) { 
							// 		echo '<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
							// 	}
							// 	echo '</div>';
							// }
		            	?>
		            </div>
	            </div>
	        </div>
		</div>
	<?php
		}
	?>

	<div id="categoriesContainer">
		<div class="container"><h1>POR CATEGORIA</h1></div>
		<div class="container">
			<?php
				// $categories = $set->getCategories();
				// if(!$categories){

				// }else{
				// 	foreach ($categories as $key => $value) {
				// 		$category = $value['category'];
				// 		$category_img = $value['media'];
				// 		echo '<div class="box">';
				// 		echo '<img src="'.$path.$category_img[0]['url'].'"/>';
				// 		echo '<a href="store/category/'.$category['id_category'].'">'.$category['name'].'</a>';
				// 		echo '</div>';
				// 	}
				// }
			?>
		</div>
	</div>
	<div id="brandsContainer">
		<div class="container">
			<?php
				$brands = $set->getBrands();
				if(!$brands){

				}else{
					// echo '<div id="glideBrands">';
					// echo	'<div class="glide__track" data-glide-el="track">';
					// echo		'<ul class="glide__slides">';
					// 		foreach ($brands as $key => $value) {
					// 			$brand = $value['brand'];
					// 			$brand_img = $value['media'];
					// 			echo '<li class="glide__slide">';
					// 			echo '<div>';
					// 			echo '<a href="tienda/brand/'.$brand['id_brand'].'"><img src="'.$path.$brand_img[0]['url'].'"/></a>';
					// 			echo '</div>';
					// 			echo '</li>';
					// 		}
					// echo 		'</ul>
			  //           	</div>';
			  //       echo '<div class="glide__arrows" data-glide-el="controls">';
					// echo 	'<button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>';
					// echo 	'<button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>';
					// echo '</div>';
					// echo '</div>';
				}
            ?>
        </div>
    </div>
    <div id="htmlContentContainer">
    	<?php
    		$htmlContent = $set->getHTMLContentIndex();
    		if(!$htmlContent){

    		}else{
    			// echo $htmlContent[0]['text'];
    		}
    	?>
    </div>
	<!--FORMAS DE PAGO  -->
	<!-- <div id="paymentContainer">
		<p class="title">FORMAS DE PAGO:</p>
	    <div class="container" >
	        <div>
	        	<p>Efectivo, crédito, débito, transferencia y PayPal</p>
	            <img src="img/oxxo.png"/>
	            <img src="img/amex.png"/>
	            <img src="img/carnet.png"/>
	            <img src="img/mastercard.png"/>
	            <img src="img/visa.png"/>
	            <img src="img/pagaflex.png"/>
	            <img src="img/spei.png"/>
	            <img src="img/paypal.png"/>
	            <img src="img/conekta.png">
	        </div>
	    </div>
	</div>
    <div id="hr"><div class="container"><hr></div></div> -->

	<?php include('footer.php');?>
		<script src="../node_modules/@glidejs/glide/dist/glide.min.js"></script>
		<script type="text/javascript">
		if("IntersectionObserver" in window){	
			let observerIMG = new IntersectionObserver((entries, observer) => { 
				entries.forEach(entry => {
					if(entry.isIntersecting){
						let src = entry.target.getAttribute('data-src');
						if (!src) { return; }
	  					entry.target.src = src;
						// entry.target.classList.add('animated');
						// entry.target.classList.add('zoomIn');
					}
			  	});
			}, {threshold:1});
			// document.querySelectorAll('.slideImg').forEach( p => { observerIMG.observe(p) });
			// document.querySelectorAll('.slideImgMobile').forEach( p => { observerIMG.observe(p) });
			document.querySelectorAll('.bestSellersImg').forEach( p => { observerIMG.observe(p) });

		}
		else{
			console.log("no intersectionobserver");
		}
		// new Selectr('#productDrop', {
		//     searchable: true,
		//     defaultSelected:false,
		//     placeholder:"Buscar condición visual o producto"
		// });
		// new Glide('#glideCarousel',{
		// 	type: 'slide',
		// 	autoplay: 2000,
  // 			hoverpause: true,
		// }).mount();
		// const glideBestSellers = document.getElementById('glideBestSellers');
		// if(glideBestSellers !== 'undefined'){
		// 	new Glide('#glideBestSellers',{
		// 		type: 'slide',
		// 		breakpoints:{
		// 			// 640:{perView: 1},
		// 			990: {	perView: 2},
		// 	  		2000: { perView: 3}
		// 		}
		// 	}).mount();
		// }
		// const glideBrands = document.getElementById('glideBrands');
		// if(glideBrands !== 'undefined'){
		// 	new Glide('#glideBrands',{
		// 		type: 'carousel',
		// 		breakpoints:{
		// 			440:{perView: 1},
		// 			640:{perView: 2},
		// 			990: {	perView: 4},
		// 	  		2000: { perView: 6}
		// 		}
		// 	}).mount();
		// }
	</script>
</body>
</html>