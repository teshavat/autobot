<?php
define('CLIENT_ID', 'NCpfj9HOkj3UUfr3wAstja');
define('LINE_API_URI', 'https://notify-bot.line.me/oauth/authorize?');
define('CALLBACK_URI', 'http://simpeldev-autobot.herokuapp.com/noti-callback.php');

$queryStrings = [
    'response_type' => 'code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => CALLBACK_URI,
    'scope' => 'notify',
    'state' => md5(uniqid()),
];

$queryString = LINE_API_URI . http_build_query($queryStrings);

?>

<a href="<?php echo $queryString; ?>">Register HERE</a>
