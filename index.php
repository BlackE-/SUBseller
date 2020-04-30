<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		require_once('header_meta.php');
	?>
	<title></title>
</head>
<body>
	<?php include('header.php');?>
	<div class="carouselHome">
		<?php
			$carousel = $set->getCarousel();
			
			if(!$carousel){
				echo $set->getErrorMessage();
			}else{
				print_r($carousel);
				echo '<div id="glideCarousel">';
				echo '<div class="glide__arrows" data-glide-el="controls">
						<button class="glide__arrow glide__arrow--left" data-glide-dir="<">
							 <svg height="10" width="10">
							  <polygon points="0,5 10,0 10,10"/>
							</svg> 
						</button>
						<button class="glide__arrow glide__arrow--right" data-glide-dir=">">
							<svg height="10" width="10">
							  <polygon points="0,0 10,5 0,10"/>
							</svg> 
						</button>
					</div>';
				echo '</div>';
				
				// <div class="glide__track" data-glide-el="track">
				// 	<ul class="glide__slides">
				// 		<li class="glide__slide">
			}
		?>
	</div>



	<?php include('footer.php');?>

	<script type="text/javascript">
		new Selectr('#productDrop', {
		    searchable: true,
		    defaultSelected:false,
		    placeholder:"Buscar condición visual o producto"
		});
	</script>
</body>
</html>