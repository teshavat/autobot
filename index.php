<?php

require_once('./vendor/autoload.php'); 

// Namespace 
use \LINE\LINEBot\HTTPClient\CurlHTTPClient; 
use \LINE\LINEBot; 
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'pyXzvm4/zvH7FT3DbwNuFIQd6Ql8y9zL9aHb/9otnLEUDoHupFrNx1MqZprwKYevmeUX+GnCBRWfu/u20qgaStD0dZ3WsOBZsyBJnqKpsvoXxjog6vq+fUaAmHUsOKp7ne6JFs9bZrX2IJ6AZg0nfAdB04t89/1O/w1cDnyilFU='; 
$channel_secret = '843086e01502017642384904eaf042c5';

// Get message from Line API 
$content = file_get_contents('php://input'); 
$events = json_decode($content, true); 

if (!is_null($events['events'])) { 
  // Loop through each event 
  foreach ($events['events'] as $event) { 
    // Line API send a lot of event type, we interested in message only. 
    if ($event['type'] == 'message') { 

      // Get replyToken 
      $replyToken = $event['replyToken']; 

      switch($event['message']['type']) {

          case 'image': 
            $messageID = $event['message']['id']; 
            $respMessage = 'Hello, your image ID is '. $messageID;       
            break;
          
          case 'text': 
            
            //tmt: moved to above
            //// Get replyToken 
            //$replyToken = $event['replyToken']; 
          
            // Reply message 
            $respMessage = 'Hello, your message is '. $event['message']['text'];
          
            $httpClient = new CurlHTTPClient($channel_token); 
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
            $textMessageBuilder = new TextMessageBuilder($respMessage); 
            $response = $bot->replyMessage($replyToken, $textMessageBuilder); 
            break; 
          
           default: 
            $respMessage = 'Please send image only';            
            break;
      } 
    } 
  } 
} 

echo "OK";
