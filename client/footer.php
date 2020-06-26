<footer>
	<div class="container">
		<div class="column" id="column1">
			<a href="/" class="title">INICIO</a>
			<a href="/">lENTES DE CONTACTO</a>
			<a href="/">CONDICIÓN VIISUAL</a>
			<a href="/">TIEMPO DE USO</a>
			<a href="/">Por laboratorio</a>
			<a href="/">Soluciones</a>
		</div>
		<div class="column" id="column2">
			<a href="../store?page=category&id=1" class="title">LENTES GRADUADOS</a>
			<a href="store?page=brand&id=1">RENU</a>
			<a href="store?page=brand&id=2">PUREVISIÓN</a>
			<a href="store?page=brand&id=3">PUREVISIÓN</a>
		</div>
		<div class="column" id="column3">
			<div>
				<a href="store?page=category&id=2" class="title">LENTES DE SOL</a>
				<a href="store?page=brand&id=1">RENU</a>
				<a href="store?page=brand&id=2">PUREVISIÓN</a>
				<a href="store?page=brand&id=2">PUREVISIÓN</a>
				<a href="store?page=brand&id=2">PUREVISIÓN</a>
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
			<a href="/">
				<?php
					$logo = $set->getWebsiteSetting('website_logo');
					echo $logo;
				?>
			</a>
			<p>Copyright MISDEC 2020. Todos los derechos reservados. Sitio por <a target="_blank" href="http://studio-sub.com">SUB</a></p>
		</div>
	</div>
</footer>
<script type="text/javascript" src="../script/selectr/selectr.min.js"></script>
<script type="text/javascript" src="../script/header.js"></script>
<script type="text/javascript" src="script/CLIENT-header.js"></script>
