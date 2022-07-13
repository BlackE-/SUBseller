<footer>
	<div class="container">
		<div class="column" id="column1">
			<a href="../" class="title">INICIO</a>
			<?php
				if(!$categories){

				}else{
				    foreach ($categories as $key => $value) {
				    	$category = $value['category'];
				    	echo '<a href="../store?page=category&id='.$category['id_category'].'">'.$category['name'].'</a>';
				    }
				    
				}
			?>
		</div>
		<div class="column" id="column2">
			<a href="../store" class="title">TIENDA</a>
			<?php
			if(!$categories){

			}else{
			foreach ($tipos as $key => $value) {
            	$type = $value['type'];
            	echo '<a href="../store?store?page=type&id='.$type['id_type'].'">'.$type['name'].'</a>';}
        	}
			?>
		</div>
		<div class="column" id="column3">
			<div>
				<a href="../faq">Ayuda</a>
				<a href="../avisodeprivacidad.pdf" class="title">AVISO DE PRIVACIDAD</a>
			</div>
			<div>
				<div id="socialMediaContainer">
					<?php
						echo '<a href="'.$fb.'" target="_blank"><i class="fab fa-facebook-square"></i></a>';
						echo '<a href="'.$ig.'" target="_blank"><i class="fab fa-instagram"></i></a>'; 
					?>
				</div>
			</div>
		</div>
		<div class="column" id="column4">
			<a href="/">
				<?php
					$logo = $set->getWebsiteSetting('website_logo');
					echo $logo;
				?>
			</a>
			<p>Copyright MISDEC <?php echo date('Y');?>. Todos los derechos reservados. Sitio por <a target="_blank" href="http://studio-sub.com">SUB</a></p>
		</div>
	</div>
</footer>
<script type="text/javascript" src="../script/selectr/selectr.min.js"></script>
<script type="text/javascript" src="../script/header.js"></script>
<script type="text/javascript" src="script/CLIENT-header.js"></script>
