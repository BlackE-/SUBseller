<?php  
    require_once "include/_setup.php";
    $set = new Setup();
    $login = $set->checkLogin();
    $path = '/subseller';

    $contactoEmail = $set->getWebsiteSetting('contacto_email');
?>
<!DOCTYPE html>
<html>
<head>
    <script>
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("phone/faq");
        }
     </script>  
    <?php
        require_once('header_meta.php');
    ?>
    <link rel="stylesheet" href="node_modules/nouislider/distribute/nouislider.css">
    <link rel="stylesheet" type="text/css" href="css/faq.css">
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="bodyContainer">
        <div class="main">
            <div class="container" id="faqContainer">
                <div class="leftContainer">
                    <h1>Preguntas Frecuentes</h1>
                    <div class="filterContainer">
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="pagos" type="radio" checked/>
                                <label for="pagos"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">PAGOS</p>
                        </div>
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="pedidos" type="radio"/>
                                <label for="pedidos"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">PEDIDO</p>
                        </div>
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="envios" type="radio"/>
                                <label for="envios"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">ENVIOS Y ENTREGA</p>
                        </div>
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="devoluciones" type="radio"/>
                                <label for="devoluciones"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">DEVOLUCIONES</p>
                        </div>
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="productos" type="radio"/>
                                <label for="productos"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">PRODUCTOS</p>
                        </div>
                        <div class="row" id="checkboxNewsletter">
                                <input name="mycheckbox" id="cuenta" type="radio"/>
                                <label for="cuenta"><i class="fas fa-circle"></i></label>
                                <p class="newsletterText">MI CUENTA</p>
                        </div>
                    </div>
                </div>
                <div class="rightContainer">
                    <div class="preguntasContainer">
                            <section class="box active" id="caja_pagos">
                                <h2>PAGOS</h2>
                                <p>Podrás pagar con tu tarjeta bancaria (tarjeta de crédito o débito). El cobro en tu tarjeta bancaria se realizará cuando se formalice la compraventa en términos de la legislación aplicable y previo a la entrega de los bienes adquiridos.</p>
                                <p>El pago mediante tarjeta de crédito es totalmente seguro. La totalidad de la transacción se realiza de forma cifrada a través de un servidor de validación bancaria utilizándose el protocolo de encriptación SSL (Secure Socket Layer), así pues, el número de su tarjeta de crédito y la fecha de caducidad quedan instantáneamente encriptados en su ordenador antes de ser enviados al protocolo SSL.</p>
                                <p>Aceptamos pagos con tarjetas de crédito y débito para Visa y MasterCard y a través de PayPal con Visa, MasterCard y American Express. Adicionalmente aceptamos pagos en efectivo en tiendas de conveniencia (OXXO). El pago realizado en tiendas de conveniencia tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Comercializadora KUA.</p>

                                <div>
                                    <p class="titulo"><b>¿Cómo puedo saber si mi pago fue exitoso?</b></p>
                                    <p>En el momento que finalices tu compra recibirás una confirmación del pedido vía correo electrónico confirmado los productos adquiridos, así como el número asignado a tu pedido, si tienes alguna duda del proceso puedes escribir al correo 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?>
                                    donde con gusto te ayudarán.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>Realice una devolución y aún no tengo mi reembolso ¿Cuánto tiempo tardaré en ver reflejado mi dinero?</b></p>
                                    <p>El tiempo especificado en términos y condiciones hace referencia a 15 a 20 días hábiles que puede tardar en ser tramitado tu reembolso; sin embargo, haremos lo posible para que tu reembolso quede confirmado a la brevedad posible.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cuánto tiempo tengo para concretar mi pago si es en efectivo?</b></p>
                                    <p>Tendrás solamente 2 días naturales para poder concretar tu pago en efectivo; sin embargo, esperamos que éste se realice a la brevedad posible para no retrasar tu compra. Las órdenes se procesan una vez que se haya registrado el pago y a partir de ahí empieza a contar el tiempo de entrega.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>Me confirmaron que mi pago fue rechazado. ¿Cuánto tiempo debo esperar para mi reembolso?</b></p>
                                    <p>A pesar de que por parte de Comercializadora se realiza la devolución de forma automática a tu cuenta, tendrás que esperar un periodo el cual dependerá de la institución bancaria con la cual hayas realizado el pago esto en un tiempo aproximado de 24 a 72 horas hábiles para poder confirmar que el reembolso sea efectivo.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cuál es la forma de enviar mis datos bancarios para la confirmación de mi reembolso?</b></p>
                                    <p>Después de la confirmación de algún artículo faltante o de la solicitud de tu devolución, es importante considerar que en caso de que hayas pagado con tarjeta de crédito/débito, el reembolso de dinero se abonará al plástico que utilizaste para tu compra; para compras realizadas con pagos a través de tiendas de conveniencia, el reembolso de dinero se tramitará mediante retiro en ventanilla del banco seleccionado por Comercializadora KUA, en cualquier sucursal a nivel nacional.</p>
                                </div>
                            </section>
                            <section class="box" id="caja_pedidos">
                                <h2>PEDIDO</h2>
                                 <div>
                                    <p class="titulo"><b>¿Dónde puedo enviar mi pedido?</b></p>
                                    <p>Todos los pedidos se enviarán dentro del territorio mexicano.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cuándo recibiré exactamente mi pedido?</b></p>
                                    <p>Una vez procesada la orden, vamos a notificarte cuándo vas a recibir tu pedido.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Conoceré la fecha de entrega antes de realizar el pedido?</b></p>
                                    <p>Todos los pedidos cuentan con un estimado de entrega 3 a 7 días hábiles, una vez procesada la orden.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Puedo revisar el estado del pedido o hacer un seguimiento del envío?</b></p>
                                    <p>Sí, puedes revisar el estado de tu pedido en cualquier momento, iniciando sesión en tienda KUA. Una vez que tu pedido salga de nuestro almacén, recibirás la notificación de envío en tu correo electrónico.</p>
                                </div>

                                <div>
                                    <p class="titulo"><b>¿Cuáles son los estatus en los que se puede encontrar mi pedido?</b></p>
                                    <p>
                                        <ul>
                                            <li>ESPERANDO PAGO</li>
                                            <p>Indica que tu pedido ha sido recibido por el sistema, pero que aún no ha sido procesado por nuestro equipo de gestión de pedidos. Al realizar tu compra, recibirás en minutos un correo electrónico para confirmar que hemos recibido un pedido.</p>
                                            <li>PAGADO</li>
                                            <p>Tu pedido ha sido transferido al almacén y tus productos están siendo recogidos y preparados para ser enviados.</p>
                                            <li>COMPLETADO</li>
                                            <p>Tu pedido fue recibido en la dirección que solicitaste. Cuando esto ocurra, recibirás un correo electrónico de confirmación de entrega, con los datos de la persona que recibió. Sin embargo, también podrás revisar el detalle de tu envío a través de la página web del transportista.</p>
                                            <li>EXPIRADO</li>
                                            <p>En caso de que el pago de tu pedido no se haya realizado dentro de los 2 días siguientes a su solicitud, se procederá a su cancelación. Por ejemplo, al seleccionar pago a través de tiendas de conveniencia (OXXO), se genera un código de referencia único, con vigencia de 2 días; si el pago no ocurre, el código se invalida y el pedido se cancela automáticamente.</p>
                                            <li>CANCELADO</li>
                                            <p></p>
                                        </ul>
                                    </p>
                                </div>

                                <div>
                                    <p class="titulo"><b>¿Qué correos electrónicos puedo recibir con relación a mi pedido?</b></p>
                                    <p>Después de haber realizado tu pedido en la tienda en línea KUA, recibirás los siguientes mensajes de correo electrónico:
                                        <ul>
                                            <li><p>De confirmación del pedido. Si tu pedido se ha realizado correctamente, recibirás una confirmación minutos después, con el número de pedido, detalle de la orden, método de pago y dirección que solicitas para entrega. Todos los pedidos están sujetos a disponibilidad. Si un artículo no está disponible después de que hayas realizado tu pedido, nuestro servicio de atención al cliente se pondrá en contacto contigo.</p>
                                            </li>
                                            <li><p>De envío del pedido. Mediante este correo, confirmamos que tu pedido salió de nuestro almacén y está en camino a su destino. Aquí también podrás encontrar la información necesaria para dar seguimiento a detalle de la ruta de tu pedido.</p>
                                            </li>
                                        </ul></p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Puedo cambiar la dirección de envío de mi pedido?</b></p>
                                    <p>La dirección de envío no se puede cambiar una vez realizado el pedido. Si existe el caso, deberás de ponerte en contacto con nosotros.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Puedo modificar mi pedido?</b></p>
                                    <p>Una vez que se haya efectuado tu pedido, empezará a pasar automáticamente por el proceso de tramitación. Aunque no puedes modificar el pedido que acabas de efectuar, puedes devolver cualquier producto que no desees conservar siempre y cuando cumpla con nuestra <a href="TERMINOSYCONDICIONES.pdf" target="_blank">Política de devoluciones</a>. Si deseas encargar un nuevo producto, puedes realizar un nuevo pedido en línea.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Puedo cancelar mi pedido?</b></p>
                                    <p>Lamentablemente no es posible solicitar la cancelación de un pedido una vez que hayas realizado su pago.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Realicé mi compra y no he recibido el correo de confirmación?</b></p>
                                    <p>Es importante mencionar que si el pago lo realizaste a través de un pago en línea, el correo de confirmación por parte de Comercializadora KUA lo estarás recibiendo dentro de un plazo de 72 horas, si este plazo se ha excedido y el correo de confirmación aún no lo recibes, te pedimos por favor te comuniques a nuestro centro de servicio a clientes, o bien enviar un correo electrónico a 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?>, para que se pueda validar que la compra se haya realizado correctamente.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>No me llegó la factura de mi pedido, ¿cómo la solicito?</b></p>
                                    <p>Para solicitar una copia de su factura es necesario que se ponga en contacto mediante nuestro centro de Servicio al cliente KUA, enviando un correo a 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?>
                                     y a la brevedad nuestro equipo se pondrá en contacto contigo.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Por qué ha sido cancelado mi pedido?</b></p>
                                    <p>Tu pedido puede haber sido anulado por numerosas razones. La más común es que el producto que encargaste lamentablemente ya no está disponible en el almacén. Naturalmente, nos esforzamos en la medida de lo posible por entregar todos los pedidos de los clientes. No obstante, en raras ocasiones, podemos tener problemas con las existencias en el almacén. Para comprender claramente por qué se canceló tu pedido, te aconsejamos que mandes un correo a 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?>.</p>
                                </div>
                                 <div>
                                    <p class="titulo"><b>No me ha llegado el pedido que realicé, ¿quién me puede ayudar?</b></p>
                                    <p>Es importante tomar en cuenta que los tiempos normales de entrega son entre 3 y 7 días hábiles; sin embargo, durante el periodo de rebajas los pedidos pueden tardar un poco más en ser procesados. Te pedimos que si aún no recibes tu pedido mandes un correo a 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?>.</p>
                                </div>
                                 <div>
                                    <p class="titulo"><b>¿Cuál es el monto límite de compras en la tienda online?</b></p>
                                    <p>El límite de compras es de $5,000.00 pesos con tarjeta, $10,000.00 pagos en OXXO e ilimitado por transferencia.</p>
                                </div>
                            </section>
                            <section class="box" id="caja_envios">
                                <h2>ENVIOS Y ENTREGA</h2>
                                <div>
                                    <p class="titulo"><b>¿Cuánto tiempo tardaré en recibir mi pedido?</b></p>
                                    <p>Es importante tomar en cuenta que los tiempos normales de entrega son de 3 a 7 días hábiles; sin embargo, te sugerimos mantenerte al pendiente a través de tu historial de pedidos en <a href="client/index">Mi cuenta</a>, donde podrás consultar los detalles del pedido.</p>
                                    <p>Por favor toma en cuenta las siguientes normas y restricciones de envío:</p>
                                    <ul>
                                        <li><p>Los pedidos se envían solo en días hábiles. Los días hábiles son de lunes a viernes, excluyendo los festivos nacionales de México.</p></li>
                                        <li><p>No podemos realizar entregas en apartados de correos.</p></li>
                                        <li><p>Todas las entregas irán acompañadas con un acuse de recibo.</p></li>
                                        <li><p>No reembolsamos los costes de envío urgente en el caso de devolución de artículos.</p></li>
                                        <li><p>Debido a dificultades logísticas a la hora de realizar envíos a determinadas áreas remotas, nos reservamos el derecho a cancelar su pedido y/o a aplicar términos y condiciones adicionales a dicho pedido (incluyendo, sin limitación, la condición de que cada pedido alcance un importe mínimo).</p></li>
                                    </ul>
                                    <p>Nuestro servicio de atención al cliente te notificará la cancelación y/o la aplicación de estas condiciones tan pronto como sea posible después de que realices tu pedido.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Qué gastos de envío deberé pagar?</b></p>
                                    <p>Comercializadora no te cobrará envíos en pedidos mayores a $500.00, en montos menores a esta cantidad deberás cubrir la cuota de envío dependiendo las dimensiones del paquete.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Puedo indicar una dirección de entrega distinta de mi dirección de facturación?</b></p>
                                    <p>Sí, es posible. Durante el proceso de pago, puedes seleccionar diferentes direcciones. Te pedimos que tengas en cuenta que esta opción solo es válida para direcciones dentro del mismo país.</p>
                                </div>
                            </section>
                            <section class="box" id="caja_devoluciones">
                                <h2>DEVOLUCIONES Y REEMBOLSOS</h2>
                                <div>
                                    <p>No hay devoluciones a menos que cumplan con las <a href="TERMINOSYCONDICIONES.pdf" target="_blank"> Políticas de devoluciones.</a></p>
                                </div>   
                            </section>
                            <section class="box" id="caja_productos">
                                <h2>PRODUCTOS</h2>
                                <div>
                                    <p class="titulo"><b>¿Cómo encuentro el producto que estoy buscando?</b></p>
                                    <p>Si necesitas ayuda para encontrar un producto, utiliza nuestro buscador de productos situado en la parte superior de nuestra página. Solo tienes que introducir una o más palabras clave o un número de artículo en el campo de búsqueda y hacer clic en &quot;IR&quot;. En la página se mostrarán los resultados de la búsqueda acompañados de vínculos a productos o grupos de productos. Puedes redefinir tu búsqueda seleccionando varias categorías o marcas de producto en la parte izquierda de la página. Consejos de búsqueda:</p>
                                    <ul>      <li>  Comprueba la ortografía para obtener resultados de búsqueda más precisos.</li>
                                        <li>    Utiliza más de una palabra para buscar tipos de producto específicos.</li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Qué debería hacer si recibo un producto equivocado?</b></p>
                                    <p>Si has recibido un producto equivocado, te recomendamos ponerte en contacto con uno de nuestros asesores de atención al cliente al correo 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?></p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Qué debería hacer si he recibido el producto dañado o defectuoso?</b></p>
                                    <p>Si recibiste un producto dañado o defectuoso, te recomendamos que se ponga en contacto con nuestro equipo de atención al cliente al correo 
                                    <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?></p>
                                </div>
                            </section>
                            <section class="box" id="caja_cuenta">
                                <h2>MI CUENTA</h2>
                                <div>
                                    <p class="titulo"><b>Contraseñas olvidadas</b></p>
                                    <p>Si has olvidado tu contraseña, haz clic en "Inicia sesión" y después en "¿Has olvidado la contraseña?". Recibirás una nueva contraseña por email. <a href="pswreset.php">Reestablecer Contraseña</a></p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cómo puedo añadir productos a mi carrito?</b></p>
                                    <p>Para añadir productos a tu carrito de compra, sigue los siguientes pasos:
                                        <ul>
                                            <li><p>Selecciona una categoría y/o marca para localizar el producto que desees comprar.</p></li>
                                            <li><p>Da clic en el botón “Agregar al carrito” para visualizar los detalles del producto de tu interés.</p></li>
                                            <li><p>Selecciona la cantidad (cajas y/o piezas) de producto que deseas adquirir.</p></li>
                                            <li><p>Haz clic en el botón “Agregar al carrito” para que la cantidad de producto seleccionado se añada al carrito.</p></li>
                                        </ul></p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cómo hago cambios en mi carrito?</b></p>
                                    <p>Dentro de la tienda en línea KUA, en el apartado de carrito (parte superior derecha), existe la opción de modificar las cantidades de los productos elegidos, o en todo caso, eliminarlos con el ícono de bote de basura.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Cómo puedo resolver problemas para visualizar la tienda online?</b></p>
                                    <p>Si estás teniendo problemas para visualizar la tienda en línea KUA, recomendamos que elimines las cookies y los archivos temporales de Internet. Esto debería ser útil para resolver tus problemas de visualización. Por favor, asegúrate de tener habilitadas las cookies.</p>
                                    <p>Nuestro sitio web es compatible con los siguientes navegadores: Internet Explorer, Firefox y Google Chrome.</p>
                                </div>
                                <div>
                                    <p class="titulo"><b>¿Qué pasa si no puedo encontrar la respuesta a mi pregunta aquí?</b></p>
                                    <p>Si no puedes encontrar la respuesta a su pregunta aquí, te recomendamos que te   pongas en contacto con nosotros por medio de correo electrónico a <?php
                                        echo '<a href="mailto:'.$contactoEmail.'">'.$contactoEmail.'</a>';
                                    ?> </p>
                                </div>
                            </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php");?>
    <script type="text/javascript" src="script/faq.js"></script>
	</body>
</html>