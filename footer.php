<footer>
	<div class="container">
		<div class="column" id="column1">
			<a href="index" class="title">INICIO</a>
			<a href="index">lENTES DE CONTACTO</a>
			<a href="index">CONDICIÓN VIISUAL</a>
			<a href="index">TIEMPO DE USO</a>
			<a href="index">Por laboratorio</a>
			<a href="index">Soluciones</a>
		</div>
		<div class="column" id="column2">
			<a href="category/" class="title">LENTES GRADUADOS</a>
			<a href="brand/">RENU</a>
			<a href="brand/">PUREVISIÓN</a>
			<a href="brand/">PUREVISIÓN</a>
		</div>
		<div class="column" id="column3">
			<div>
				<a href="category/" class="title">LENTES DE SOL</a>
				<a href="brand/">RENU</a>
				<a href="brand/">PUREVISIÓN</a>
				<a href="brand/">PUREVISIÓN</a>
				<a href="brand/">PUREVISIÓN</a>
				<a href="avisodeprivacidad.pdf" class="title">AVISO DE PRIVACIDAD</a>
			</div>
			<div>
				<div id="socialMediaContainer">
					<?php
						echo '<a href="'.$fb.'"><i class="fab fa-facebook-square"></i></a>';
						echo '<a href="'.$ig.'"><i class="fab fa-instagram"></i></a>'; 
					?>
				</div>
			</div>
		</div>
		<div class="column" id="column4">
			<a href="index">
				<?php
					$logo = $set->getWebsiteSetting('website_logo');
					echo $logo;
				?>
			</a>
			<p>Copyright MISDEC 2020. Todos los derechos reservados. Sitio por <a href="http://studio-sub.com">SUB</a></p>
		</div>
	</div>
</footer>
<script type="text/javascript" src="script/selectr/selectr.min.js"></script>
<script type="text/javascript">
	new Selectr('#productDrop', {
		    searchable: true,
		    defaultSelected:false,
		    placeholder:"Buscar condición visual o producto"
		});
</script>
