<?php
	require_once "include/_setup.php";
	$set = new Setup();
	$login = $set->checkLogin();
	if($login){
		$set->RedirectToURL('cart');
		exit();
	}
	$path = '/subseller';
?>
<!DOCTYPE html>
<html>
<head>
	<script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/login");
        }
     </script>  
	<?php
		require_once('header_meta.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
</head>
<body>

	<?php include('header.php');?>
	<div id="formsContainer">
		<div class="container" id="box">
    		<div class="pasoContainer">
                <p>PASO 1: <b>COMPLETA TU IDENTIDAD</b></p>
                <div class="meter">
                  <span style="width: 25%"></span>
                </div>
            </div>
    		<div class="error"></div>
    		
    		<div class="radio-tabs" role="tablist">
    		    <input class="state" type="radio" title="Starks" name="houses-state" id="starks" role="tab" aria-controls="starks-panel"  />
    		    <input class="state" type="radio" title="Lanisters" name="houses-state" id="lannisters" role="tab" aria-controls="lannisters-panel" aria-selected="true" checked />
    		
    		    <div class="tabs" aria-hidden="true">
    		        <label for="starks" id="starks-tab" class="tab" >REGISTRATE</label>
    		        <label for="lannisters" id="lannisters-tab" class="tab" aria-selected="true">INICIA SESIÓN</label>
    		    </div>
    		
    		    <div class="panels">
    		        <ul id="starks-panel" class="panel" role="tabpanel" aria-labelledby="starks-tab">
    		            <div class="facebookRegisterContainer">
    		            	<a href="#" id="registerFacebook"><i class="fab fa-facebook-square"></i> Crear cuenta usando Facebook</a>
    		            	<hr>
    		            </div>
    		            <div class="registerContainer">
    		            	<form id="registerForm" class="registerForm">
    		            		<p class="topRegister"><b>o usar tu correo electrónico</b></p>
    		            		<div class="row"><input type="text" id="nameRegister" placeholder="Nombre"/></div>
    		            		<div class="row"><input type="text" id="apellidoRegister" placeholder="Apellido"/></div>
	    		            	<div class="row"><input type="number" id="phoneRegister" placeholder="Telefono: 10 dígitos"/></div>
	    		            	<div class="row"><input type="email" id="emailRegister" placeholder="Correo Electrónico"/><p class="little">Aquí enviaremos la confirmación del pedido.</p></div>
	    		            	<div class="row"><input type="password" id="password1" placeholder="Contraseña" minlength="8" />
	    		            		<p class="little">Al menos <span id="8char">8 caracteres</span>, <span id="MAY">1 letra Mayúscula</span>, <span id="min">1 letra Minúscula</span>, <span id="num1">1 Número</span></p></div>
	    		            	<div class="row"><input type="password" id="password2" placeholder="Confirmar Contraseña" minlength="8"/></div>
	    		            	<div class="row">
    		            			<p>Fecha de nacimiento:</p>
	    		            		<div class="selectBirthdayContainer">
			    		            		    <div class="selectdivdate">
			            	                        <select id="day" /> 
			            	                        <?php
			            	                            for($i=1;$i<=31;$i++){
			            	                                echo '<option value="'.$i.'">'.$i.'</option>';
			            	                            }
			            	                        ?>
			            	                        </select>
			            	                    </div>
			            	                    <div class="selectdivdate">
			        						        <select id="month">
			        						            <option value="1">Enero</option>
			        						            <option value="2">Febrero</option>
			        						            <option value="3">Marzo</option>
			        						            <option value="4">Abril</option>
			        						            <option value="5">Mayo</option>
			        						            <option value="6">Junio</option>
			        						            <option value="7">Julio</option>
			        						            <option value="8">Agosto</option>
			        						            <option value="9">Septiembre</option>
			        						            <option value="10">Octubre</option>
			        						            <option value="11">Noviembre</option>
			        						            <option value="12">Diciembre</option>    
			                						</select>
			                					</div>
			            	                    <div class="selectdivdate">
			                						<select id="year">
			                        				<?php
			                        					$actual = date("Y");
			                        					$max = $actual - 12;
			                        					$min = $actual - 99;
			                        					for($x=$max;$x>=$min;$x--){
			                        						echo '<option value="'.$x.'">'.$x.'</option>';
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
	        		            				<option value="0">Género</option>
	        		            				<option value="F">Mujer</option>
	        		            				<option value="M">Hombre</option>
	        		            			</select>
	        		            		</div>
	    		            			<p class="little">Te daremos ofertas personalizadas.</p>
	    		            	</div>
	    		            	<div class="row" id="checkboxNewsletter">
	    		            			<input id="checkNewsletter" type="checkbox"/><label for="checkNewsletter"><i class="fas fa-check"></i></label>
	    		            			<p class="newsletterText">Suscríbeme al boletín<br>de ofertas y consejos</p>
	    		            	</div>
	    		            	<div class="row">
	    		            		<input class="submitRegister" id="submitRegister" type="submit" value="Registrarse"/>
	    		            	</div>
    		            	</form>
    		            	<p class="terminos">Al hacer una cuenta aceptas nuestros <br><a href="/SMB-TerminosYCondiciones.pdf" target="_BLANK"><i>Términos y condiciones</i></a><br><br>Conoce nuestro <a target="_blank" href="/SMB-AvisoDePrivacidad.pdf">Aviso de privacidad</a></p>
    		            </div>
    		        </ul>
    		        <ul id="lannisters-panel" class="panel active" role="tabpanel" aria-labelledby="lannisters-tab">
    		            <div class="facebookRegisterContainer">
    		            	<a href="#" id="loginFacebook"><i class="fab fa-facebook-square"></i> Iniciar Sesion </a>
    		            	<hr>
    		            </div>
    		            <div class="registerContainer">
    		            	<form id="loginForm">
	    		            	<p class="topRegister"><b>o usar tu correo electrónico</b></p>
	    		            	<div class="row"><input type="email" id="emailLogin" placeholder="Correo Electrónico"/></div>
	    		            	<div class="row"><input type="password" id="passwordLogin" placeholder="Contraseña"/></div>
	    		            	<div class="row">
	    		            		<input type="submit" class="submitLogin" value="Iniciar Sesión">
	    		            		<p class="forgot"><a href="pswreset"><i>Olvidé mi contraseña</i></a></p>
	    		            	</div>
	    		            </form>
    		            </div>
    		        </ul>
    		    </div>
    		</div>
    	</div>
	</div>


	<?php include('footer.php');?>
	<?php include('modal.php');?>
	<script type="text/javascript" src="script/login.js"></script>
</body>
</html>