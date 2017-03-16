<?php
// parameters
$hubVerifyToken = 'ThisIsTestBot1234qwer';
$accessToken = "EAAFxRVWdUIoBAPsGfKPIrKRmGm1XkbDkvhdY7YqvkSaPkXIKDi3GWs3QZAc6yK9muQHbXz3ROnRMAdZAKYzyGXPxAIbuoqA3Mb8uiWz6o4ZCuvuRafZBr953XMu6eIOz7zLalUZCCrurh6F2fiyw3AbK4ULeLembsP2fBd98h3QZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    print_r($_GET['hub_challenge']);
    exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

file_put_contents('fb_response.txt', $input);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];

$answer = 'test';

$welcomeMessage = [
    'czesc',
    'cześć',
    'witam',
    'siema',
    'elo',
    'siemanko',
    'witaj'
];
$welcomeMessageResponse = [
    'Witaj',
    'Cześć',
    'Dzień dobry',
];

$goodbyeMessage = [
    'do widzenia',
    'nara',
    'do zobaczenia'
];

$goodbyeMessageResponse = [
    'Do zobaczenia',
    'Do widzenia'
];

if (in_array(strtolower($messageText), $goodbyeMessage)) {
    $answer = $goodbyeMessageResponse[rand(0, count($goodbyeMessageResponse) - 1)];
} elseif (in_array(strtolower($messageText), $welcomeMessage)) {
    $answer = $welcomeMessageResponse[rand(0, count($welcomeMessageResponse) - 1)];
} elseif ($messageText == 'test') {
    $answer = 'przestań pisać test!!!';
} else {
    $answer = "Niestety nie rozumiem. Aby rozpocząć rozmowę napisz 'witaj'.";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
