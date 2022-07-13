<?php
	$path = './subseller/';
	require_once  $_SERVER['DOCUMENT_ROOT'].$path."include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if(!$login){
		$set->RedirectToURL('../login');
		exit();
	}
	$name = $set->getClientName();
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../phone/client");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/CLIENT-index.css">
</head>
</head>
<body>
	<?php include('header.php');?>
	<div id="main">
		<?php include('sidebar.php');?>
		<div class="body">
			<h2>Datos</h2>
			<?php
				$data = $set->getClientData();
			?>
			<form id="dataForm" class="dataForm">
				<?php
				echo '<div class="row"><input type="text" id="nameRegister" placeholder="Nombre" value="'.$data['name'].'"/></div>';
	            echo '<div class="row"><input type="number" id="phoneRegister" placeholder="Telefono: 10 dígitos" value="'.$data['phone'].'"/></div>';
	            echo '<div class="row"><input type="email" id="emailRegister" placeholder="Correo Electrónico" value="'.$data['email'].'"/></div>';
	            ?>
	            <?php
	            	$dob = explode("-",$data['birthday']);
	            	$year = $dob[0];
	            	$month = $dob[1];
	            	$day = $dob[2];
	            ?>
	            	<div class="row">
            			<p>Fecha de nacimiento:</p>
	            		<div class="selectBirthdayContainer">
    		            		    <div class="selectdivdate">
            	                        <select id="day" /> 
            	                        <?php
            	                            for($i=1;$i<=31;$i++){
            	                            	if($day == $i){
            	                            		echo '<option value="'.$i.'" selected>'.$i.'</option>';
            	                            	}else{
            	                            		echo '<option value="'.$i.'">'.$i.'</option>';
            	                            	}   
            	                            }
            	                        ?>
            	                        </select>
            	                    </div>
            	                    <div class="selectdivdate">
        						        <select id="month">
        						        	<?php
		        	                            for($j=1;$j<=12;$j++){
		        	                            	$monthEcho = '';
		        	                            	switch ($j) {
		        	                            		case '1':$monthEcho = 'Enero';break;
		        	                            		case '2':$monthEcho = 'Febrero';break;
		        	                            		case '3':$monthEcho = 'Marzo';break;
		        	                            		case '4':$monthEcho = 'Abril';break;
		        	                            		case '5':$monthEcho = 'Mayo';break;
		        	                            		case '6':$monthEcho = 'Junio';break;
		        	                            		case '7':$monthEcho = 'Julio';break;
		        	                            		case '8':$monthEcho = 'Agosto';break;
		        	                            		case '9':$monthEcho = 'Septiembre';break;
		        	                            		case '10':$monthEcho = 'Octubre';break;
		        	                            		case '11':$monthEcho = 'Noviembre';break;
		        	                            		case '12':$monthEcho = 'Diciembre';break;
		        	                            	}
		        	                            	if($month == $j){
		        	                            		echo '<option value="'.$j.'" selected>'.$monthEcho.'</option>';
		        	                            	}else{
		        	                            		echo '<option value="'.$j.'">'.$monthEcho.'</option>';
		        	                            	}   
		        	                            }
		        	                        ?>   
                						</select>
                					</div>
            	                    <div class="selectdivdate">
                						<select id="year">
                        				<?php
                        					$actual = date("Y");
                        					$max = $actual - 12;
                        					$min = $actual - 99;
                        					for($x=$max;$x>=$min;$x--){
                        						if($year == $x){
                        							echo '<option value="'.$x.'" selected>'.$x.'</option>';	
                        						}else{
                        							echo '<option value="'.$x.'">'.$x.'</option>';
                        						}
                        						
                        					}		
                        				?>
                						</select>
                					</div>
        				</div>		
						<p class="little">Te daremos ofertas especiales de cumpleaños.</p>
	            	</div>
	            	<div class="row">
	            		    <div class="selectdivsex">
		            			<select class="sexRegister" id="sexRegister">
		            				<?php
		            					if($data['sex'] == 'F'){
		            						echo '<option value="F" selected>Mujer</option>';
		            						echo '<option value="M">Hombre</option>';
		            					}else{
		            						echo '<option value="F">Mujer</option>';
		            						echo '<option value="M" selected>Hombre</option>';
		            					}
		            				?>
		            			</select>
		            		</div>
	            			<p class="little">Te daremos ofertas personalizadas.</p>
	            	</div>
	            	<div class="row" id="checkboxNewsletter">
	            		<?php
	            			if($data['newsletter']){
	            				echo '<input id="checkNewsletter" type="checkbox" checked/>';
	            			}else{
	            				echo '<input id="checkNewsletter" type="checkbox"/>';
	            			}
	            		?>
	            		<label for="checkNewsletter"><i class="fas fa-check"></i></label>
	            		<p class="newsletterText">Suscríbeme al boletín de ofertas y consejos</p>
	            	</div>
	            	<div class="row">
	            		<input class="submitRegister" id="submitRegister" type="submit" value="Guardar Cambios"/>
	            	</div>
            </form>
		</div>
	</div>

	<?php include('footer.php');?>
	<?php include('../modal.php');?>
	<script type="text/javascript" src="script/CLIENT-index.js"></script>
</body>
</html>