<?php
	require_once "_setup.php";
	$set = new Setup();
	$returnValue = true;
	//conekta
    require_once('conekta-php/lib/Conekta.php');
    \Conekta\Conekta::setLocale('es');
    $keyConekta = $set->getConektaSecretKey();
	\conekta\Conekta::setApiKey($keyConekta);

	//mailchimp
	require_once('mailchimp-api/src/MailChimp.php');

	//DATA POST
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$sex = $_POST['sex'];
	$dob = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
	$cumple = date("Y-m-d",strtotime($dob));
	$newsletter = $_POST['newsletter'];


	$id_conekta = $set->getClientConekta();

	//EVALUAR SI EL EMAIL YA FUE REGISTRADO
	try {
		$customer = \Conekta\Customer::find($id_conekta);
		$customer->update( [
		    'name'  => $name,
		    'email' => $email,
		    'phone' => $phone
		  ]
        );
        $insert = $set->updateClient($name,$email,$sex,$cumple,$phone,$newsletter);
        if(!$insert){
            $returnValue = false;
        }
        else{
   //      	$mailchimp_key = $set->getMailchimpKey();
			// $mailchimp_id_list = $set->getMailchimpList();
			// $MailChimp = new MailChimp($mailchimp_key); 
			// $subscriber_hash = $MailChimp->subscriberHash($email);
			// $result = $MailChimp->get("lists/$list_id/members/$subscriber_hash");
   //          if ($result['status'] == '404') {
   //          	if($newsletter){
   //          		//no se hacae nada, ya esta guardado
   //          		//no se ha guardado en mailchimp
	  //           	$result = $MailChimp->post("lists/$mailchimp_id_list/members", [
	  //       				'email_address' => $email,
	  //       				'status'        => 'subscribed',
	  //       		]);
	  //       		if (!$MailChimp->success()) {
	  //               	$returnValue = false;
	  //               	$set->setErrorMessage('No se guardo cliente en mailchimp');   
	  //               }
   //          	}
   //          }else{
   //          	//ya esta guardado
   //          	if(!$newsletter){
   //          		//eliminar
   //      			$returnValue = $MailChimp->delete("lists/$list_id/members/$subscriber_hash");
   //          	}
   //          }
	    }
	}
	catch (Conekta\ProccessingError $error){
        $returnValue = false;
        $set->setErrorMessage($error->getMessage());
    } catch (Conekta\ParameterValidationError $error){
    	$returnValue = false;
        $set->setErrorMessage($error->getMessage());
    } catch (Conekta\Handler $error){
       	$returnValue = false;
        $set->setErrorMessage($error->getMessage());
    }



	header("Content-Type: application/json; charset=utf-8", true);
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	echo json_encode($json_return);
?>