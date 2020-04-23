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
	<link rel="stylesheet" type="text/css" href="script/datatables/datatables.min.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/coupons.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main couponsContainer">
			<div id="newProductTitle"><h1>Cupones</h1></div>
			<div id="newProductContainer">
				<div><a href="productDiscounts"><button class="productDiscounts">Descuento Productos</button></a></div>
				<div><a href="newCoupon"><button class="newProduct">Nuevo Cupón</button></a></div>
			</div>
			<div>
				<?php
					$coupons = $set->getCoupons();
					if(!$coupons){
				?>
					<p>Sin Cupones</p>
				<?php
					}else{
					 echo '<table id="example" class="display " style="width:100%">';
		                echo '<thead><tr><th>Código</th><th>Status</th><th>Tipo</th><th>Fecha Expirar</th><th>Uso</th></tr></thead><tbody>';
		                foreach ($coupons as $key => $row){
		                    echo '<tr>';
		                   	echo '<td><a class="link_coupon" href="coupon?id_coupon='.$row['id_coupon'].'">'.$row['code'].'</a></td>';
		                   	echo '<td>';
		                    if($row['status']){echo '<p class="activo">Activo</p>';}
		                    else{echo '<p class="expirado">Expirado</p>';}
		                    echo '</td>';
		                    echo '<td><p>'.$row['discount_type'].'</p></td>';
		                    $date = date_create($row['date_expires']);
		                    echo '<td><p>'.date_format($date, 'Y-m-d').'</p></td>';
		                    echo '<td><p>'.$row['usage_count'].'</p></td>';
		                    echo '</tr>';
		                }
		                echo '</tbody>';
		                echo '</table>';
		            }
				?>

			</div>
		</div>
	</div>
	<?php include('footer.php');?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="script/datatables/datatables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			    $('#example').DataTable( {
			        dom: 'Bfrtip',
			        "info": false
			    } );
			});
		</script>
</body>
</html>