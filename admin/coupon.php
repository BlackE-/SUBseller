<?php
	$id_coupon = $_GET['id_coupon'];
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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/coupon.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<?php
			$coupon = $set->getCoupon($id_coupon);

		?>
		<form id="newCouponForm">
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="coupons"><i class="fas fa-angle-left"></i> Cupones</a>
				<h1>Cupón</h1>	
			</div>
			<div class="leftDiv">
				<div class="detailsContainer">
					<p class="title">Código</p> 
					<p><?php echo $coupon['code'];?></p>
					<p class="title">Tipo</p>
					<p><?php echo $coupon['discount_type'];?></p>
					<p class="title">Valor</p>
					<p><?php echo $coupon['amount'];?></p>

					<?php
							$products_id = explode(",",$coupon['product_ids']);
							if(sizeof($products_id)>=1){
								echo '<p class="title">Productos incluidos</p>';
								foreach ($products_id as $key => $row){
									echo '<div  class="productContainer">';
			                    	$product = $set->getProduct($row);
			                    	$imgPrincipal = $set->getMedia($product['id_product'],'product');
			                    	if(!$imgPrincipal){ echo '<td><p>No Image</p></td>';}
			                    	else{echo '<td><img class="thumb" src="../'.$imgPrincipal[0]['url'].'"/></td>';}
			                    	echo '<p>'.$product['sku'].'</p>';
			                    	echo '</div>';
			                	}	
							}
					?>
				</div>
			</div>
			<div class="rightDiv">
				<div class="settingContainer">
					<p class="title">Fecha Expiración</p>
					<?php
						$date = date_create($coupon['date_expires']);
		                echo '<td><p>'.date_format($date, 'Y-m-d').'</p></td>';
					?>
					<p class="title">Descripción</p>
					<p><?php echo $coupon['description'];?></p>
				</div>
				
			</div>
		</div>
		</form>
	</div>
	<?php include('footer.php');?>
	
</body>
</html>
	