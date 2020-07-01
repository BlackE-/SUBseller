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
	$phone = '';
	$password = '';
	$sex = '';
	$dob = '';
	$cumple = '';
	$newsletter = $_POST['newsletter'];
	$id_facebook = $_POST['id_facebook'];


	//EVALUAR SI EL EMAIL YA FUE REGISTRADO
	$checkCustomer = $set->checkEmailForRegister($email);
	if($checkCustomer){//if return false means the email is not on DB
	    $returnValue = false;
	}
	else{
		try {
		    $customer = \conekta\Customer::create(array(
	              "name" =>$name,
	              "email" => $email,
	              "phone" => $phone
	            )
	        );
	        $insert = $set->insertClient($name,$email,$password,$sex,$id_facebook,$customer->id,$cumple,$phone,$newsletter);
	        if(!$insert){
	            $returnValue = false;
	        }
	        else{
	            if($newsletter){
	            	$mailchimp_key = $set->getMailchimpKey();
					$mailchimp_id_list = $set->getMailchimpList();
					$MailChimp = new MailChimp($mailchimp_key); 
	                
	                $result = $MailChimp->post("lists/$mailchimp_id_list/members", [
	            				'email_address' => $email,
	            				'status'        => 'subscribed',
	            			]);	
	                if (!$MailChimp->success()) {
	                	$returnValue = false;
	                	$set->setErrorMessage('No se guardo cliente en mailchimp');   
	                }
		        }
		        $set->loginClientFacebook($id_facebook);
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