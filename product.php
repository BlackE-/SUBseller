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
         		echo 'window.location.replace("phone/product?id_product='.$id_product.'")';
         	?>
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" href="node_modules/nouislider/distribute/nouislider.css">
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
					$product = $set->getProduct($id_product);
					$type = $set->getProductTypeName($product['type_id_type']);
					echo '<li><a href="store?page=type&id='.$product['type_id_type'].'">'.$type.'</a></li>';
					echo '<li>'.$product['name'].'</li>';
				?>

				</ul>
			</div>
			<div class="productRow">
				<div class="imagesContainer">
					
				</div>
				<div class="infoContainer">
					
				</div>
			</div>

		</div>
		
	</div>

	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/product.js"></script>
</body>
</html>