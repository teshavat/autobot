<?php 
define('LINE_API', 'https://notify-api.line.me/api/notify'); 

$message = array( 
  'message' => 'Hello', 
); 

$tokens = file_get_contents('tokens.json'); 
$tokens = json_decode($tokens, true); 

foreach($tokens as $token){ 
  line_notify($token, $message); 
  echo("token=",$token,", message=",$message);
} 
echo("----");

function line_notify($token, $message) { 
  $header = array( 
      'Content-type: application/x-www-form-urlencoded', 
      "Authorization: Bearer {$token}", ); 
  
  $data = http_build_query($message, '', '&'); 
  
  $cURL = curl_init(); 
  curl_setopt( $cURL, CURLOPT_URL, LINE_API); 
  curl_setopt( $cURL, CURLOPT_SSL_VERIFYHOST, 0); 
  curl_setopt( $cURL, CURLOPT_SSL_VERIFYPEER, 0); 
  curl_setopt( $cURL, CURLOPT_POST, 1); 
  curl_setopt( $cURL, CURLOPT_POSTFIELDS, $data); 
  curl_setopt( $cURL, CURLOPT_FOLLOWLOCATION, 1); 
  curl_setopt($cURL, CURLOPT_HTTPHEADER, $header); 
  curl_setopt( $cURL, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec( $cURL ); 
  curl_close( $cURL ); 
}

echo("SuperGiants");
