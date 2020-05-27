<?php
	$page = '';
	$id = '';
	if(isset($_GET['page'])){	
		$page = $_GET['page'];
		$id = $_GET['id'];
	}	
	require_once "../include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	$path = '/subseller/phone';
	$pathImg = '../';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../store");
        }
     </script>  
    <?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" href="/subseller/node_modules/nouislider/distribute/nouislider.css">
	<link rel="stylesheet" type="text/css" href="css/store.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="storeContainer">
		<div class="container" id="storeContainer">
			<div id="topProductsContainer">
            	<?php
            		echo '<input type="hidden" id="page" value="'.$page.'"/>';
            		echo '<input type="hidden" id="id" value="'.$id.'"/>';
                    $products = $set->getProducts();
                    $total = count($products);
                    echo '<div><p class="totalProductos"><input type="text" id="totalProductosInput" value="'.$total.'"/> productos</p></div>';
                ?>
                <div id="ordenContainer">
                    <p class="ordenText">Ordenar:</p>
                    <div class="ordenSelect">
                        <select class="orderTienda" id="sortList">
                            <option value="1">Lo último</option>
                            <option value="2">Precio menor a mayor</option>
                            <option value="3">Precio mayor a menor</option>
                        </select>
                    </div>
                </div>
                <div class="filterCategoryContainer">
                	
                <?php
					$categories = $set->getCategories();
	                if(!$categories){

	                }else{
	                	echo '<ul>';
		                foreach ($categories as $key => $value) {
		                	$category = $value['category'];
		                	$categoryImg = $value['media'];
		                	echo '<li>';
		                	echo '<input type="radio" name="category" value="'.$category['id_category'].'" id="c-option-'.$category['id_category'].'">';
		                	echo '<label for="c-option-'.$category['id_category'].'"><img src="'.$pathImg.$categoryImg[0]['url'].'"/></label>';
		                	echo '</li>';
		                }
		                echo '</ul>';
		            }
                ?>
                	<p class="clearFilter" id="clearCategories">Limpiar Filtros</p>
                </div>
                <details id="filterContainer">
					<summary>Más Filtros</summary>
					<div class="filterBox">
						<p>Marca</p>
							<p class="clearFilter" id="clearBrands">x</p>
							<ul>
								<?php
									$brands = $set->getBrands();
					                if(!$brands){

					                }else{
						                foreach ($brands as $key => $value) {
						                	$brand = $value['brand'];
						                	echo '<li>';
						                	echo '<input type="radio" name="brand" value="'.$brand['id_brand'].'" id="b-option-'.$brand['id_brand'].'">';
						                	echo '<label for="b-option-'.$brand['id_brand'].'"><span>'.$brand['name'].'</span></label>';
						                	echo '</li>';
						                }
						            }
					            ?>
							</ul>
					</div>
					<div class="filterBox">
						<p>Tipo</p>
							<p class="clearFilter" id="clearTypes">x</p>
							<ul>
								<?php
									$types = $set->getTypes();
					                if(!$types){

					                }else{
						                foreach ($types as $key => $value) {
						                	$type = $value['type'];
						                	echo '<li>';
						                	echo '<input type="radio" name="type" value="'.$type['id_type'].'" id="t-option-'.$type['id_type'].'">';
						                	echo '<label for="t-option-'.$type['id_type'].'"><span>'.$type['name'].'</span></label>';
						                	echo '</li>';
						                }
						            }
					            ?>
							</ul>
					</div>
					<div class="filterBox">
						<p>Precio</p>
	                    <div id="precioCollapseDiv"  class="collapseDiv">
	                    	<div id="slider-range"></div>
	                    </div>
					</div>

					<button id="filterProducts">Aplicar Filtros</button>
				</details>
	        </div>
		</div>
		<div class="container" id="tagContainer">
        	<?php
        		if($page == 'tag'){
        			$tagName = $set->getTag($id);
        			echo '<p>Mostrando los productos que contienen la etiqueta:</p>';
        			echo '<p><b><i>'.$tagName.'</i></b></p>';
        		}
        	?>
        </div>
		<div id="bottomProductsContainer">
			<?php
				$maxPrice = 0;
        	    if(!$products){
        	        echo 'No Productos';
        	    }else{
        	        $maxPrice = 0;
        	        echo '<div id="products">';
                        echo '<ul class="list">';
                        foreach ($products as $key => $value) {
                        	$row = $value['product'];
                        	$img = $value['media'];
            	            echo '<li><div class="liBox">';
                	               echo '<a href="product?id='.$row['id_product'].'"><div class="thumbContainer" 
                	               style="background-image:url('.$pathImg.$img[0]['url'].')"/></div></a>';
                	            echo '<p class="id_product">'.$row['id_product'].'</p>';
                                $brand = $set->getProductBrand($row['brand_id_brand']);
                                echo '<p class="brand"> '.$brand.'</p>';
                                echo '<p class="id_brand"> '.$row['brand_id_brand'].'</p>';
                                echo '<p class="time">Tiempo de uso: '.$row['tiempo_de_uso'].'</p>';
                	            echo '<p class="name">'.$row['name'].'</p>';
                                echo '<div class="priceContainer">';
                                $price_sale = $row['price_sale'];
                                if($row['discount'] != 0){
                                	$price_sale = $row['price_sale']*$row['discount'];
                                }
                                $price = explode('.',$price_sale);
		                		echo '<p class="price">$'.$price[0].'.<sup>'.$price[1].'</sup></p>';
                                echo '<p>'.$row['description_short'].'</p>';
                                echo '</div>';
                                $categories = $set->getProductCategories($row['id_product']);
                                if(!$categories){
                                }else{
                                	foreach ($categories as $key2 => $value2) {
                                		echo '<p class="category">'.$value2.'</p>';
                                	}
                                }
                                $typeProduct = $set->getProductTypeName($row['type_id_type']);
                                echo '<p class="type">'.$typeProduct.'</p>';
                                echo '<p class="id_type">'.$row['type_id_type'].'</p>';
                                echo '<div class="linkContainer"><a href="product?id='.$row['id_product'].'">AGREGAR AL CARRITO</a></div>';
            	            echo '</div></li>';
            	            if($maxPrice <$row['price_sale']){$maxPrice  = $row['price_sale']; }
            	        }
            	        echo '</ul>';
            	        echo '<ul class="pagination"></ul>';
        	        echo '</div>'; //id_priductos
        	        echo '<input type="hidden" id="maxPriceValue" value="'.$maxPrice.'">';
        	    }
			?>
		</div>
	</div>
	<?php include('../modal.php');?>
	<?php include('footer.php');?>
	<script src="/subseller/node_modules/list.js/dist/list.min.js"></script>
	<script src="/subseller/node_modules/nouislider/distribute/nouislider.js"></script>
	<script type="text/javascript" src="script/store.js"></script>
</body>
</html>