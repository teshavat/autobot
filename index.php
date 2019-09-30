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
    if ($event['type'] == 'join') { 
      // Get replyToken 
      $replyToken = $event['replyToken']; 
      
      // Greeting 
      $respMessage = 'Hi guys, I am MR.Robot. You can ask me everything.'; 
      $httpClient = new CurlHTTPClient($channel_token); 
      $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
      $textMessageBuilder = new TextMessageBuilder($respMessage); 
      $response = $bot->replyMessage($replyToken, $textMessageBuilder); 
    }
    
    // LINE API send a lot of event type, we interested in message only. 
    if ($event['type'] == 'unfollow') { 
      // ไม่รู้จะทำอะไรต่อ เพรำะว่ำยูสเซอร์อันเฟรนบอทไปแล้ว 
      // บำงทีอำจจะแค่นับจำนวนคนอันเฟรนบอท แล้วบอกจำนวนให้กำรตลำดทรำบ 
    }
    
    // Line API send a lot of event type, we interested in message only. 
    if ($event['type'] == 'follow') { 
      // Get replyToken 
      $replyToken = $event['replyToken']; 
      
      // Greeting 
      $respMessage = 'Thanks you. I try to be your best friend.'; 
      
      $httpClient = new CurlHTTPClient($channel_token); 
      $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
      
      $textMessageBuilder = new TextMessageBuilder($respMessage); 
      $response = $bot->replyMessage($replyToken, $textMessageBuilder); 
    }    
    
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
          
            //tmt: moved to below
            //$httpClient = new CurlHTTPClient($channel_token); 
            //$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
            //$textMessageBuilder = new TextMessageBuilder($respMessage); 
            //$response = $bot->replyMessage($replyToken, $textMessageBuilder); 
            break; 
          
          case 'sticker': 
            $messageID = $event['message']['packageId']; 
            // Reply message 
            $respMessage = 'Hello, your Sticker Package ID is '. $messageID; 
            break;
           
          case 'video': 
            $messageID = $event['message']['id']; 
            // Create video file on server. 
            $fileID = $event['message']['id']; 
            $response = $bot->getMessageContent($fileID); 
            $fileName = 'linebot.mp4'; 
            $file = fopen($fileName, 'w'); 
            fwrite($file, $response->getRawBody()); 
            // Reply message
            $respMessage = 'Hello, your video ID is '. $messageID; 
            break;
          
          case 'audio': 
            $messageID = $event['message']['id']; 
            // Create audio file on server. 
            $fileID = $event['message']['id']; 
            $response = $bot->getMessageContent($fileID); 
            $fileName = 'linebot.m4a'; 
            $file = fopen($fileName, 'w'); 
            fwrite($file, $response->getRawBody()); 
            // Reply message 
            $respMessage = 'Hello, your audio ID is '. $messageID; 
            break;
          
          case 'location': 
            $address = $event['message']['address']; 
            // Reply message 
            $respMessage = 'Hello, your address is '. $address; 
            break;
          
          case 'file': 
            $messageID = $event['message']['id']; 
            $fileName = $event['message']['fileName']; 
            // Reply message 
            $respMessage = 'Hello, your file ID is '. $messageID . ' and file name is '. $fileName; 
            break;
          
          default: 
            $respMessage = 'Please send image only';            
            break;
      } 

      $httpClient = new CurlHTTPClient($channel_token); 
      $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
      $textMessageBuilder = new TextMessageBuilder($respMessage); 
      $response = $bot->replyMessage($replyToken, $textMessageBuilder); 
    } 
  } 
} 

echo "OK";
