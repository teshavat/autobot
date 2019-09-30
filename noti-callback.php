<?php
define('CLIENT_ID', 'NCpfj9HOkj3UUfr3wAstja');
define('CLIENT_SECRET', 'zQIYAL5KPJpTxB2do8p0U6KEEknGIYNemdPoMu9oQ7V');
define('LINE_TOKEN_URI', 'https://notify-bot.line.me/oauth/token');
define('CALLBACK_URI', 'http://simpeldev-autobot.herokuapp.com/noti-callback.php');

parse_str($_SERVER['QUERY_STRING'], $queries);
        
$fields = [
    'grant_type' => 'authorization_code',
    'code' => $queries['code'],
    'redirect_uri' => CALLBACK_URI,
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
];

try{ 
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, LINE_TOKEN_URI);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $res = curl_exec($ch);
    curl_close($ch);
} catch(Exception $e) {
    throw $e;
}

$token = json_decode($res, true);

$tokens = file_get_contents('tokens.json');
$tokens = json_decode($tokens, true);

$tokens[] = $token['access_token'];

file_put_contents('tokens.json', json_encode($tokens));
?>

Congrats! You have been registered!!!
