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
	<link rel="stylesheet" type="text/css" href="css/products.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
			<div><a href="newProduct"><button>Nuevo Producto <i class="fas fa-tags"></i></button></a></div>
			<div>
				<?php
					$products = $set->getProducts();
					if(!$products){
				?>
					<p>Sin productos</p>
				<?php
					}
				?>

			</div>
		</div>
	</div>
	<?php include('footer.php');?>
</body>
</html>