<?php
    $body = @file_get_contents('php://input');
    $data = json_decode($body);
    http_response_code(200); // Return 200 OK
    
    if ($data->type == 'charge.paid'){
	        //ACTUALIZAR PEDIDO A PAGADO
	    $payment_method = $data->charges->data->object->payment_method->type;
	    $msg = "Tu pago ha sido comprobado.";
	    mail('<a href="mailto:client@email.com">client@email.com</a>',"Pago ". $payment_method ." confirmado",$msg);
    }
?>