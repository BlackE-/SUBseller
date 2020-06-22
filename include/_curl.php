<?php
	class Curl{
		private $ch;

		function getAccessToken($url, $clientId, $secret) {
			/*
				curl -v https://api.sandbox.paypal.com/v1/oauth2/token \
			   -H "Accept: application/json" \
			   -H "Accept-Language: en_US" \
			   -u "client_id:secret" \
			   -d "grant_type=client_credentials"
			*/
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_HEADER, false);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->ch, CURLOPT_POST, true);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($this->ch, CURLOPT_USERPWD, $clientId.":".$secret);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
			$response = curl_exec($this->ch);
			curl_close($this->ch);
			$returnValue = json_decode($response,true);
			return $returnValue;
		}

		function createOrder($access_token,$url,$postData){
			/*
				In sandbox environment you cannot have more then one unfinished 
				(non completed or voided) order with the same InvoiceId. 
				After creating a new sample order everything working fine.
			*/
			/*
				curl -v -X POST https://api.sandbox.paypal.com/v2/checkout/orders \
				 -H 'Content-Type: application/json' \
				 -H 'Authorization: Bearer Access-Token' \
				 -H 'PayPal-Partner-Attribution-Id: BN-Code' \
				 -d '{
				 "intent": "CAPTURE",
				 "purchase_units": [{
				   "amount": {
				     "currency_code": "USD",
				     "value": "100.00"
				   },
				   "payee": {
				     "email_address": "seller@example.com"
				   },
				   "payment_instruction": {
				     "disbursement_mode": "INSTANT",
				     "platform_fees": [{
				       "amount": {
				         "currency_code": "USD",
				         "value": "25.00"
				       }
				     }]
				   }
				 }]
				}'
			*/
			$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token);
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $curlHeader);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->ch, CURLOPT_POST, true);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postData);
			$response = curl_exec($this->ch);
			curl_close($this->ch);
			$returnValue = json_decode($response,true);
			return $returnValue;
		}

		function captureOrder(){
			/*
				curl -v -k -X POST https://api.paypal.com/v2/checkout/orders/5O190127TN364715T/capture \
				 -H 'PayPal-Request-Id: 7b92603e-77ed-4896-8e78-5dea2050476a' \
				 -H 'PayPal-Partner-Attribution-Id:  BN-Code' \
				 -H 'Authorization: Bearer Access-Token' \
				 -H 'Content-Type: application/json' \
				 -d '{}'
			*/
			$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token);
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_URL, $url);
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $curlHeader);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->ch, CURLOPT_POST, true);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postData);
			$response = curl_exec($this->ch);
			curl_close($this->ch);
			$returnValue = json_decode($response,true);
			return $returnValue;
		}
	}

?>