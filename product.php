<?php
	$id_product = '';
	if(!isset($_GET)){
		header('index');
	}else{
		$id_product = $_GET['id'];
	}
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
         	<?php
         		echo 'window.location.replace("phone/product?id='.$id_product.'")';
         	?>
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
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
						$thumb = $data[1]['media'][0];
						// print_r($thumb);
						echo '<div class="thumbContainer">';
						echo 	'<img id="thumbSelected" src="'.$path.'/'.$thumb['url'].'"/>';
						echo '</div>';
						$secondary = $data[2]['media_secondary'];
						if(!empty($secondary)){
							echo '<div class="mosaico">';
            		            echo '<ul>';
            		            	echo '<li><img id="0" class="thumb selected" src="'.$path.'/'.$thumb['url'].'"/>';
            		            foreach($secondary as $key=>$value){
        		                    echo '<li><img id="'.($key+1).'" class="thumb" src="'.$path.'/'.$value['url'].'"/>';
        		                }
            		            echo '</ul>';
            		        echo '</div>';
						}
					?>
				</div>
				<div class="infoContainer">
					<?php
						$brand = $set->getProductBrand($product['brand_id_brand']);
						$type = $set->getProductTypeName($product['type_id_type']);		
						echo '<div class="typeContainer"><p>'.$type.'</p></div>';
	        		    echo 	'<div class="detailsContainer">';
	        		    echo 		'<p class="brand">'.$brand.'</p>';
	        		    echo 		'<p class="name">'.$product['name'].'</p>';
	        		    echo 		'<p>Tiempo de uso: '.$product['tiempo_de_uso'].'</p>';
	        		    echo 	'</div>';
	        		    echo 	'<div class="numbersContainer">';
	        		    $price_sale = $product['price_sale'];
                        if($product['discount'] != 0){
                        	$price_sale = number_format($product['price_sale']*$product['discount'],2,'.',',');
                        }
                        echo '<input type="hidden" id="price" value="'.$price_sale.'">';
                        $price = explode('.',$price_sale);
	                	echo 		'<div class="qtyBox">';
	            		echo 			'<button id="minus"><i class="fas fa-minus"></i></button>';
	            		echo 			'<input type="number" id="qty" class="quantity" placeholder="1" value="1" disabled/>';
						echo 			'<button id="more"><i class="fas fa-plus"></i></button>';
	            		echo 		'</div>';
	            		echo 		'<div>';
	            		echo 		'<p class="price" >$'.$price[0].'.<sup>'.$price[1].'</sup></p>';	
	            		echo 		'<p class="little">Precio Unitario</p>';
	            		echo 		'</div>';	
	            		echo 	'</div>';
	            		echo '<p>Receta<br>Ingresa los datos de tu receta para tu pedido.</p>';
	            		echo '<div class="receta" id="receta">';
	            		echo '<table>';
	            		echo '<tr><th></th><th>Esfera</th><th>Cilindro</th><th>Eje</th><th>Add</th></tr>';
	            		echo '<tr><th class="od"><p><i class="fas fa-eye"></i><i class="fas fa-eye"></i><span>OD</span></th>';
	            		echo '<td><input type="text" id="od_esfera" placeholder="+2.25"/></td>';
	            		echo '<td><input type="text" id="od_cilindro" placeholder="-3.00"/></td>';
	            		echo '<td><input type="text" id="od_eje" placeholder="180"/></td>';
	            		echo '<td><input type="text" id="od_add" placeholder="optional"/></td>';
	            		echo '</tr>';
	            		echo '<tr><th class="id"><p><i class="fas fa-eye"></i><i class="fas fa-eye"></i><span>OI</span></p></th>';
	            		echo '<td><input type="text" id="oi_esfera"/></td>';
	            		echo '<td><input type="text" id="oi_cilindro"/></td>';
	            		echo '<td><input type="text" id="oi_eje"/></td>';
	            		echo '<td><input type="text" id="oi_add"/></td>';
	            		echo '</tr>';
	            		echo '<tr>';
	            		echo '<td colspan="5">';
	            		echo '<textarea id="notes" placeholder="Observaciones"></textarea>';
	            		echo '</td>';
	            		echo '</tr>';

	            		echo '</table>';
	            		echo '</div>';
	            		echo '<div class="buttonContainer"><button id="addToCart"><i class="fas fa-plus"></i> Agregar al carrito</button></div>';
	        		    echo '<div class="informationContainer">';
	        		    echo 		'<p class="description">'.$product['description'].'</p>';
	        		    echo 		'<p class="description_short">'.$product['description_short'].'</p>';
	        		    echo 	'</div>';
	        		    
	        		    echo '</div>';
	        		    
            		    
                    		    
					?>
				</div>
			</div>

		</div>
		
	</div>

	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/product.js"></script>
</body>
</html>