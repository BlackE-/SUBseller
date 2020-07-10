<header>
	<div class="container" id="navbar">
		<div id="menuIcon">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div id="searchIcon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25">
			  <path id="lupa" fill="#2361f0" fill-rule="evenodd" d="M1181.26,87.678l-5.31-5.4a10.075,10.075,0,0,0-1.3-12.392,9.648,9.648,0,0,0-13.79,0,10.05,10.05,0,0,0,0,14.023,9.657,9.657,0,0,0,5.48,2.806,9.506,9.506,0,0,0,5.92-1.022l5.48,5.568a2.461,2.461,0,0,0,3.52,0A2.568,2.568,0,0,0,1181.26,87.678Zm-19.29-4.9a8.421,8.421,0,0,1,0-11.775,8.1,8.1,0,0,1,11.58,0,8.473,8.473,0,0,1,.76,10.881,0.8,0.8,0,0,0,.07,1.04l5.77,5.873a0.957,0.957,0,0,1,0,1.333,0.94,0.94,0,0,1-1.31,0l-5.89-5.995a0.784,0.784,0,0,0-.55-0.233,0.764,0.764,0,0,0-.41.115A8.059,8.059,0,0,1,1161.97,82.783Zm12.97-5.887a7.3,7.3,0,0,0-2.1-5.169h0a7.1,7.1,0,0,0-10.16,0,7.393,7.393,0,0,0,0,10.338,7.1,7.1,0,0,0,10.16,0A7.3,7.3,0,0,0,1174.94,76.9Zm-3.21,4.044a5.559,5.559,0,0,1-7.95,0,5.8,5.8,0,0,1,0-8.089,5.559,5.559,0,0,1,7.95,0A5.782,5.782,0,0,1,1171.73,80.94Z" transform="translate(-1158 -67)"/>
			</svg>
			<p>&#10005;</p>
		</div>
		<div id="logoContainer">
			<a href="index">
		<?php
			$logo = $set->getWebsiteSetting('website_logo');
			echo $logo;
		?>
			</a>
		</div>
		<div id="userContainer">
		        <?php
		            if(!$login){echo '<a href="login"><i class="far fa-user" aria-hidden="true"></i></a>';}
		            else{echo '<a href="client/index"><i class="far fa-user" aria-hidden="true"></i></a>';}
		        ?>
		</div>
		<div id="storeContainer">
			<a href="cart">
	        	<svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18">
				  <path id="cart" fill="#2361f0" fill-rule="evenodd" d="M1075.13,12.365h-16.26l-0.22-.862c-0.01-.015-0.01-0.027-0.02-0.042s-0.01-.047-0.02-0.069l-0.03-.055a0.225,0.225,0,0,1-.04-0.058c-0.01-.017-0.03-0.033-0.04-0.049a0.212,0.212,0,0,0-.05-0.05c-0.01-.013-0.03-0.025-0.04-0.037s-0.04-.029-0.06-0.042a0.191,0.191,0,0,0-.05-0.026,0.641,0.641,0,0,0-.06-0.031c-0.02-.007-0.04-0.012-0.06-0.017a0.364,0.364,0,0,0-.07-0.017c-0.02,0-.04-0.005-0.06-0.007L1058,11h-3.33a0.673,0.673,0,0,0-.67.676,0.712,0.712,0,0,0,.67.72h2.81l3.13,10.889a0.981,0.981,0,0,0,.88.88h10.73a0.993,0.993,0,0,0,.87-0.88l2.91-10.04A0.875,0.875,0,0,0,1075.13,12.365Zm-3.3,10.4h-9.96l-2.63-9.006h15.22Zm-8.2,2.054a2.09,2.09,0,1,0,2.07,2.09A2.082,2.082,0,0,0,1063.63,24.821Zm0,2.964a0.874,0.874,0,1,1,.87-0.874A0.873,0.873,0,0,1,1063.63,27.786Zm6.19-2.964a2.09,2.09,0,1,0,2.07,2.09A2.076,2.076,0,0,0,1069.82,24.821Zm0,2.964a0.874,0.874,0,1,1,.86-0.874A0.873,0.873,0,0,1,1069.82,27.786Z" transform="translate(-1054 -11)"/>
				</svg>
			</a>
		</div>
		<!--	MENU	-->
		<div id="menu">
			<ul class="menuList">
				<!-- <li><a href="store">Tienda</a></li> -->
				<?php
                $categories = $set->getCategories();
	                if(!$categories){

	                }else{
		                foreach ($categories as $key => $value) {
		                	$category = $value['category'];
		                	echo '<li><a href="store?page=category&id='.$category['id_category'].'">'.$category['name'].'</a></li>';
		                }
		                
		            }
	            ?>
			</ul>
		</div>
		<!-- search -->
		<div id="search">
			<div id="searchContainer">
				<?php
	                $products = $set->getProducts();
	                if(!$products){

	                }else{
		                echo '<select id="productDrop">';
		                foreach ($products as $key => $value) {
		                	$product = $value['product'];
		                	echo '<option value="product?id='.$product['id_product'].'">'.$product['name'].'</option>';
		                }
		                echo '</select>';
		            }
	            ?>
			</div>
		</div>
	</div>
	<!-- <div class="container" id="caption">
		<p>Envio nacional gratis en compras mayores a $500</p>
	</div> -->
</header>