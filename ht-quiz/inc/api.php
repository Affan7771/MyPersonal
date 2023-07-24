<?php

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

function htq_quiz_api($endpoint, $method = 'GET', $choice = null){
	
	if ( $choice == null || empty($choice) ) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://services.hackertrail.com/api/'. $endpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_HTTPHEADER => array(
		    'access_token: GS-bda9871689e5880cdb4baf3fe03b22c940fcf581'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}else{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://services.hackertrail.com/api/'. $endpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS =>'{
		    "choice_id" : "'.$choice.'"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
		
}

?>