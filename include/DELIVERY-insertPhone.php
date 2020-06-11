<?php
	require_once "_setup.php";
	$set = new Setup();
	$returnValue = true;
	//conekta
    require_once('conekta-php/lib/Conekta.php');
    \Conekta\Conekta::setLocale('es');
    $keyConekta = $set->getConektaSecretKey();
	\conekta\Conekta::setApiKey($keyConekta);

	//DATA POST
	$phone = $_POST['phone'];

	//EVALUAR SI EL EMAIL YA FUE REGISTRADO
	$conektaId = $set->getConektaId();
	if(!$conektaId){//if return false means the email is not on DB
	    $returnValue = false;
	}else{
		try {
			$customer = \Conekta\Customer::find($conektaId);
			$customer->update([
			    'phone'  => $phone
			  ]
			);

	        $update = $set->updateClientPhone($phone);
	        if(!$update){
	            $returnValue = false;
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
	}


	header("Content-Type: application/json; charset=utf-8", true);
	$json_return['return'] = $returnValue;
	$json_return['message'] = $set->getErrorMessage();
	echo json_encode($json_return);
?>