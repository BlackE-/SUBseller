<?php
	require_once dirname(__FILE__) . '/include/setup.php';
	$set = new Setup();
	$CheckLogin = $set->CheckLogin();
	if(!$CheckLogin){
		header("Location: login"); 
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('header_meta.php');?>
	<link rel="stylesheet" type="text/css" href="css/settings.css" />
</head>
<body>
	<?php include('header.php');?>
	<div class="mainContainer" id="mainContainer">
		<?php include('sidebar.php');?>
		<div id="main" class="main">
		    <form id="setup_form">
		      	<?php
					$data = $set->getConfigData();
					$type = '';
					$count = 0;
					foreach($data['data'] as $value){

						if($type != $value['type']){
							if($count !== 0){echo '</div>';}
							$type = $value['type'];
							echo '<div class="type_'.$type.'">';
							switch($type){
								case 'delivery_website': echo '<h2>Entregas/Envíos</h2>'; break;
								case 'email_mailchimp': echo '<h2>Mailchimp</h2>';break;
								case 'website_settings':	echo '<h2>Sitio / Correos Electrónicos</h2>';break;
								case 'payment_conekta':	echo '<h2>Conekta</h2>';break;
								case 'payment_paypal':	echo '<h2>Paypal</h2>';break;
								case 'socialmedia_website':echo '<h2>Social Media</h2>';break;
							}
						}
						echo '<p>'.$value['key'].'</p>';
						if(strpos($value['key'], 'status') !== false){
							if($value['value'] === 'dev'){
								echo '<div class="switch">
									      <input type="radio" class="switch-input" name="'.$value['key'].'" value="dev" id="'.$value['key'].'_dev" checked>
									      <label for="'.$value['key'].'_dev" class="switch-label switch-label-off">DEV</label>
									      <input type="radio" class="switch-input" name="'.$value['key'].'" value="prod" id="'.$value['key'].'_prod">
									      <label for="'.$value['key'].'_prod" class="switch-label switch-label-on">PROD</label>
									      <span class="switch-selection"></span>
									    </div>';
							}
							else{
								echo '<div class="switch">
								      <input type="radio" class="switch-input" name="'.$value['key'].'" value="dev" id="'.$value['key'].'_dev">
								      <label for="'.$value['key'].'_dev" class="switch-label switch-label-off">DEV</label>
								      <input type="radio" class="switch-input" name="'.$value['key'].'" value="prod" id="'.$value['key'].'_prod" checked>
								      <label for="'.$value['key'].'_prod" class="switch-label switch-label-on">PROD</label>
								      <span class="switch-selection"></span>
								    </div>';
							}
						}else{
							if(strpos($value['key'], 'private') !== false){
								echo '<input type="password" name="'.$value['key'].'" value='.$value['value'].'>';
							}
							else{
								echo '<input type="text" name="'.$value['key'].'" value='.$value['value'].'>';
							}
						}
						$count++;
					}
				?>
				</div>
				<input type="submit" value="GUARDAR CAMBIOS" />
			</form>

			    </div>
			</div>
		</div>
	</div>
	<?php include('modal.php');?>
	<?php include('footer.php');?>
	<script type="text/javascript" src="script/settings.js"></script>
</body>
</html>
	
	