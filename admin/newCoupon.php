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
	<link rel="stylesheet" type="text/css" href="css/couponNew.css">
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<form id="newCouponForm">
		<div id="main" class="main">
			<div class="returnDiv">
				<a href="coupons"><i class="fas fa-angle-left"></i> Cupones</a>
				<h1>Nuevo Cupón</h1>	
			</div>
			<div class="leftDiv">
				<div class="codeContainer">
					<p>Código</p> <p class="codeGenerator">Generar Código</p>
					<input type="text" name="code" id="code" placeholder="Max:20 char">
				</div>
				<div class="typeContainer">
					<p>Tipo</p>
					<input type="radio" name="type" value="percetage" id="percetage" required><label for="percetage">Porcentaje</label>
					<input type="radio" name="type" value="fixed" id="fixed" required><label for="fixed">Cantidad</label>
					<input type="radio" name="type" value="free_shipping" id="free_shipping" required><label for="free_shipping">Envio Gratis</label>
				</div>
				<div class="amountContainer">
					<p>Valor</p>
					<div class="amountDiv">
						<label class="amountLabel"></label>
						<input type="number" name="amount" id="amount">
					</div>
					<div class="appliesToContainer">
						<p>Aplicar a:</p>
						<input type="radio" name="appliesTo" value="total" id="total"><label for="total">Total del pedido</label>
						<input type="radio" name="appliesTo" value="products" id="products"><label for="products">Productos Especificos</label>
					</div>		

					<?php
						$products = $set->getProducts();
						if(!$products){
					?>
						<p>Sin productos</p>
					<?php
						}else{
						 echo '<table id="example" class="display " style="width:100%">';
			                echo '<thead><tr><th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                        <th>Foto</th><th>SKU</th></tr></thead><tbody>';
			                foreach ($products as $key => $row){
			                    echo '<tr>';
			                    echo '<td class="dt-body-center"><input type="checkbox" id="'.$row['id_product'].'"></td>';
			                    $imgPrincipal = $set->getMedia($row['id_product'],'product');
			                    if(!$imgPrincipal){ echo '<td><p>No Image</p></td>';}
			                    else{echo '<td><img class="thumb" src="../'.$imgPrincipal[0]['url'].'"/></td>';}
			                    echo '<td><p>'.$row['sku'].'</p></td>';
			                    echo '</tr>';
			                }
			                echo '</tbody>';
			                echo '</table>';
			            }
					?>
				</div>
			</div>
			<div class="rightDiv">
				<div class="saveContainer">
					<a href="products" id="cancel">Cancelar</a>
					<input type='submit' id="saveNewProduct" value="GUARDAR"/>
				</div>
				<div class="settingContainer">
					<p>Fecha Expiración</p>
					<input type="date" name="" id="date_expires">
					<p>Descripción</p>
					<textarea name="description" id="description"></textarea>
				</div>
				
			</div>
		</div>
		</form>
	</div>
	<?php include ('modal.php');?>
	<?php include('footer.php');?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="script/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="script/newCoupon.js"></script>
</body>
</html>