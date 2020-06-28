<?php
	$id_product = '';
	if(!isset($_GET)){
		header('index');
	}else{
		$id_product = $_GET['id'];
	}
	require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	$path = '/subseller/phone';
	$pathImg = '..';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
         	<?php
         		echo 'window.location.replace("../product?id_product='.$id_product.'")';
         	?>
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" href="../node_modules/@glidejs/glide/dist/css/glide.core.min.css">
	<link rel="stylesheet" type="text/css" href="css/product.css">
</head>
<body>
	<?php include('header.php');?>

	<div class="productContainer">
		<div class="container" id="productContainer">
			<div class="breadcrumbContainer">
				<ul class="breadcrumb">
					<li><a href="index">Inicio</a></li>
				<?php
					echo '<input type="hidden" id="id_product" value="'.$id_product.'">';
					$data = $set->getProduct($id_product);
					$product = $data[0]['product'];
					$type = $set->getProductTypeName($product['type_id_type']);
					echo '<li><a href="store?page=type&id='.$product['type_id_type'].'">'.$type.'</a></li>';
					echo '<li>'.$product['name'].'</li>';
				?>
				</ul>
			</div>
			<div class="productRow">
				<div class="imagesContainer">
					<?php
						$count = 1;
						$thumb = $data[1]['media'][0];
						echo '<div id="thumbContainer">';
						echo 	'<div class="glide__track" data-glide-el="track">';
						echo 		'<ul class="glide__slides">';
						echo 			'<li class="glide__slide">';
						echo 				'<img id="thumbSelected" src="'.$pathImg.$thumb['url'].'"/>';
						echo 			'</li>';
						$secondary = $data[2]['media_secondary'];
						if(!empty($secondary)){
        		            foreach($secondary as $key=>$value){
    		                    echo '<li><img id="'.($key+1).'" class="thumb" src="'.$pathImg.'/'.$value['url'].'"/>';
    		                    $count++;
    		                }
						}
						echo 		'</ul>';
						echo 	'</div>';
						if($count > 1){
							echo '<div class="glide__bullets" data-glide-el="controls[nav]">';
							for ($i=0; $i < $count ; $i++) { 
								echo '<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
							}
							echo '</div>';
						}
						echo '</div>';
					?>
				</div>
				<div class="infoContainer">
					<?php
						$brand = $set->getProductBrand($product['brand_id_brand']);
						$type = $set->getProductTypeName($product['type_id_type']);		
						echo '<div class="typeContainer"><p>'.$type.'</p></div>';
	        		    echo 	'<div class="detailsContainer">';
	        		    echo 		'<p class="name">'.$product['name'].'</p>';
	        		    echo 		'<p class="description">'.$product['description'].'</p>';
	        		    
	        		    echo 	'</div>';
	        		    echo '<div class="sideBySideContainer">';
	        		    echo 	'<div class="numbersContainer">';
	        		    $price_sale = $product['price_sale'];
                        if($product['discount'] != 0){
                        	$price_sale = $product['price_sale']*$product['discount'];
                        }
                        echo '<input type="hidden" id="price" value="'.$price_sale.'">';
                        $price = explode('.',$price_sale);
	                	echo 		'<p class="price" >$'.$price[0].'.<sup>'.$price[1].'</sup></p>';
	                	echo 		'<div class="qtyBox">';
	            		echo 			'<button id="minus"><i class="fas fa-minus"></i></button>';
	            		echo 			'<input type="number" id="qty" class="quantity" placeholder="1" value="1" disabled/>';
						echo 			'<button id="more"><i class="fas fa-plus"></i></button>';
	            		echo 		'</div>';
	            		echo 	'</div>';
	        		    echo 	'<div class="informationContainer">';
	        		    echo 		'<p class="brand">'.$brand.'</p>';
	        		    echo 		'<p>Tiempo de uso: '.$product['tiempo_de_uso'].'</p>';
	        		    echo 		'<p class="description_short">'.$product['description_short'].'</p>';
	        		    echo 	'</div>';
	        		    echo '</div>';
	        		    
	        		    echo '</div>';	    
					?>
				</div>
			</div>

		</div>
	</div>

	<div id="productFooterFixed">
		<div class="buttonContainer"><button id="addToCart"><i class="fas fa-plus"></i> Agregar al carrito</button></div>
	</div>

	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script src="../node_modules/@glidejs/glide/dist/glide.min.js"></script>
	<script type="text/javascript" src="script/product.js"></script>
</body>
</html>