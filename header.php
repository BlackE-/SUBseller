<header>
	<div class="container">
		<div id="logoContainer">
			<a href="index">
		<?php
			$logo = $set->getWebsiteSetting('website_logo');
			echo $logo;
		?>
			</a>
		</div>
		<div id="topContainer">
			<p>Envío nacional gratis en compras mayores a $500</p>
			<div id="socialMediaHeader">
				<?php
					$fb = $set->getWebsiteSetting('facebook');
					echo '<a target="_blank" href="'.$fb.'"><i class="fab fa-facebook-square"></i></a>';

					$ig = $set->getWebsiteSetting('instagram');
					echo '<a target="_blank" href="'.$ig.'"><i class="fab fa-instagram"></i></a>'; 
				?>
			</div>
			<div id="userContainer">
		        <?php
		            if(!$login){echo '<a href="login"><i class="far fa-user" aria-hidden="true"></i><span>INICIAR SESIÓN</span></a>';}
		            else{echo '<a href="client/index"><i class="far fa-user" aria-hidden="true"></i><span>MI CUENTA</span></a>';}
		        ?>
		    </div>
	        <div id="cartContainer">
	        	<a href="cart">
	        		<table><tr><td>
		        	<svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18">
					  <path id="cart" fill="#fff" fill-rule="evenodd" d="M1075.13,12.365h-16.26l-0.22-.862c-0.01-.015-0.01-0.027-0.02-0.042s-0.01-.047-0.02-0.069l-0.03-.055a0.225,0.225,0,0,1-.04-0.058c-0.01-.017-0.03-0.033-0.04-0.049a0.212,0.212,0,0,0-.05-0.05c-0.01-.013-0.03-0.025-0.04-0.037s-0.04-.029-0.06-0.042a0.191,0.191,0,0,0-.05-0.026,0.641,0.641,0,0,0-.06-0.031c-0.02-.007-0.04-0.012-0.06-0.017a0.364,0.364,0,0,0-.07-0.017c-0.02,0-.04-0.005-0.06-0.007L1058,11h-3.33a0.673,0.673,0,0,0-.67.676,0.712,0.712,0,0,0,.67.72h2.81l3.13,10.889a0.981,0.981,0,0,0,.88.88h10.73a0.993,0.993,0,0,0,.87-0.88l2.91-10.04A0.875,0.875,0,0,0,1075.13,12.365Zm-3.3,10.4h-9.96l-2.63-9.006h15.22Zm-8.2,2.054a2.09,2.09,0,1,0,2.07,2.09A2.082,2.082,0,0,0,1063.63,24.821Zm0,2.964a0.874,0.874,0,1,1,.87-0.874A0.873,0.873,0,0,1,1063.63,27.786Zm6.19-2.964a2.09,2.09,0,1,0,2.07,2.09A2.076,2.076,0,0,0,1069.82,24.821Zm0,2.964a0.874,0.874,0,1,1,.86-0.874A0.873,0.873,0,0,1,1069.82,27.786Z" transform="translate(-1054 -11)"/>
					</svg>
					</td><td>
					<?php
						$items = $set->getCartItems();
						echo '<span>('.$items.') PRODUCTOS</span>';
					?>
					</td></tr>
					</table>
				</a>
	        </div>
		</div>
		<div id="menuContainer">
			<div id="tiendaLinkContainer">
				<a href="store">Tienda</a>
			</div>
			<?php
                $categories = $set->getCategories();
                if(!$categories){

                }else{
	                foreach ($categories as $key => $value) {
	                	echo '<div class="categoryDiv">';
	                	$category = $value['category'];
	                	echo '<a href="store?page=category&id='.$category['id_category'].'">'.$category['name'].'</a>';
	                	//echo '<a href="store/category/'.$category['id_category'].'">'.$category['name'].'</a>';
	                	echo '</div>';
	                }
	                
	            }
            ?>
			<div id="searchContainer">
				<?php
	                $products = $set->getProducts();
	                $tipos = $set->getTypes();
	                if(!$products){

	                }else{
		                echo '<select id="productDrop">';
		                foreach ($products as $key => $value) {
		                	$product = $value['product'];
		                	echo '<option value="product?id='.$product['id_product'].'">'.$product['name'].'</option>';
		                }
		                foreach ($tipos as $key => $value) {
		                	$type = $value['type'];
		                	echo '<option value="store?page=type&id='.$type['id_type'].'">'.$type['name'].'</option>';
		                }
		                echo '</select>';
		            }
	            ?>
			</div>
		</div>
	</div>
</header>