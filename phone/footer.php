<footer>
    <div id="menuFooter">
        <div class="container">
             <?php
                    if(!$login){echo '<a href="login">INICIAR SESIÓN</span></a>';}
                    else{echo '<a href="client/index"><span>MI CUENTA</span></a>';}
                ?>
                <a href="faq">PREGUNTAS FRECUENTES</a>
                <a href="faq">AYUDA</a>
                <a href="aviso.pdf">AVISO DE PRIVACIDAD</a>
                <a href="terminos.pdf">TÉRMINOS Y CONDICIONES</a>
        </div>
    </div>
	<div id="newsletter">
        <div class="container">
                <div class="boletinBox">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
					  <path fill="#fff" fill-rule="evenodd" d="M253.688,2306.01a4.631,4.631,0,0,1-3.292-1.37l-16.037-16.03a4.631,4.631,0,0,1-1.364-3.3,4.7,4.7,0,0,1,1.364-3.29l18.091-18.09A6.514,6.514,0,0,1,257.1,2262h15.243a4.652,4.652,0,0,1,4.655,4.66v15.23a6.547,6.547,0,0,1-1.926,4.66l-18.093,18.09A4.68,4.68,0,0,1,253.688,2306.01Zm3.416-41.13a3.676,3.676,0,0,0-2.621,1.08l-18.09,18.1a1.787,1.787,0,0,0-.522,1.25,1.755,1.755,0,0,0,.522,1.26l16.037,16.04a1.827,1.827,0,0,0,2.517,0l18.09-18.09a3.7,3.7,0,0,0,1.085-2.63v-15.23a1.792,1.792,0,0,0-.521-1.26,1.75,1.75,0,0,0-1.257-.52H257.1Zm9.112,13.15a5.233,5.233,0,1,1,3.7-1.53A5.236,5.236,0,0,1,266.216,2278.03Zm-0.006-7.6a2.362,2.362,0,1,0,2.181,1.46A2.364,2.364,0,0,0,266.21,2270.43Zm-9.945,19.42a2.51,2.51,0,1,1-2.51-2.51A2.508,2.508,0,0,1,256.265,2289.85Zm0,7.11a2.51,2.51,0,1,1-2.51-2.51A2.508,2.508,0,0,1,256.265,2296.96Z" transform="translate(-233 -2262)"/>
					</svg>
                    <p><b>10% de descuento<br></b>Suscríbete al boletín</p>
                </div>
                <form>
                    <input type="text" class="emailNewsletter" placeholder="Ingresa tu correo electrónico"/><button class="sendNewsletter">ENVIAR</button>
                </form>
        </div>
	</div>
    <div id="copyRight">
        <div class="container">
            <?php
                echo '<p>Copyright <b>'.$title.'</b> '.date("Y").'. Todos los derechos reservados.</p>';
            ?>
            <p>Sitio por <a target="_blank" href="http://studio-sub.com">SUB</a></p>
        </div>
    </div>
</footer>

<script type="text/javascript" src="../script/selectr/selectr.js"></script>
<script type="text/javascript" src="script/header.js"></script>