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

/*
 * get user data
 */

$user_info_url = "https://graph.facebook.com/v2.6/".$senderId."?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token=".$accessToken;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $user_info_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

curl_close ($ch);
$user = json_decode($result);

var_dump($user);






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

function prepareResponse ($senderId, $answer) {
    $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer]
    ];
    return $response;
}

if (in_array(strtolower($messageText), $goodbyeMessage)) {
    $answer = $goodbyeMessageResponse[rand(0, count($goodbyeMessageResponse) - 1)];
    $response = prepareResponse($senderId, $answer);
} elseif (in_array(strtolower($messageText), $welcomeMessage)) {
    $answer = $welcomeMessageResponse[rand(0, count($welcomeMessageResponse) - 1)];
    $response = prepareResponse($senderId, $answer);
} elseif ($messageText == 'test') {
    $answer = 'przestań pisać test!!!';
    $response = prepareResponse($senderId, $answer);
} elseif ($messageText == 'opcje' || $messageText == 'pomoc' || $messageText == 'help') {
    $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'attachment' => ['type' => 'template',
            'payload' => ['template_type' =>'button',
                'text' => 'wybierz coś',
                'buttons' => [[
                    'type' => 'web_url',
                    'url' => 'https://www.google.pl',
                    'title' => 'go to google'],
                    [
                        'type' => 'web_url',
                        'url' => 'https://www.onet.pl',
                        'title' => 'go to onet']]]]]];
} elseif ($messageText == 'regulamin') {
    $response = [
        'recipient' => ['id' => $senderId],
        'message' => ['attachment' => ['type' => 'file',
                                       'payload' => ['url' => 'https://fbbot-patryktok137412.codeanyapp.com/regulamin.txt']]]
    ];
} else {
    $answer = "Niestety nie rozumiem. Aby rozpocząć rozmowę napisz 'witaj'. Aby poznać opcje napisz 'help'.";
    $response = prepareResponse($senderId, $answer);
}

//if (in_array(strtolower($messageText), $words->goodbyeMessage)) {
//
//    $answer = $words->goodbyeMessageResponse[rand(0, count($words->goodbyeMessageResponse) - 1)];
//    $response = prepareResponse($senderId, $answer);
//
//} elseif (in_array(strtolower($messageText), $words->welcomeMessage)) {
//
//    $answer = $words->welcomeMessageResponse[rand(0, count($words->welcomeMessageResponse) - 1)];
//    $response = prepareResponse($senderId, $answer);
//
//} elseif ($messageText == 'test') {
//    $answer = 'test';
//    $response = prepareResponse($senderId, $answer);
//} elseif (in_array(strtolower($messageText), $words->help)) {
//    $response = [
//        'recipient' => [ 'id' => $senderId ],
//        'message' => [ 'attachment' => ['type' => 'template',
//            'payload' => ['template_type' =>'button',
//                'text' => 'wybierz coś',
//                'buttons' => [[
//                    'type' => 'web_url',
//                    'url' => 'https://www.google.pl',
//                    'title' => 'go to google'],
//                    [
//                        'type' => 'web_url',
//                        'url' => 'https://www.onet.pl',
//                        'title' => 'go to onet']]]]]];
//} elseif (in_array(strtolower($messageText), $words->regulations)) {
//
//    $response = [
//        'recipient' => ['id' => $senderId],
//        'message' => ['attachment' => ['type' => 'file',
//            'payload' => ['url' => 'https://fbbot-patryktok137412.codeanyapp.com/regulamin.txt']]]
//    ];
//
//} elseif ($messageText == 'kiedy otwarte' || $messageText == 'kiedy otwarte?' || $messageText == 'godziny otwarcia') {
//
//    $answer = 'Zapraszamy od pon do pt w godzinach 8 - 16.';
//    $response = prepareResponse($senderId, $answer);
//
//} elseif ($messageText == 'fota') {
//
//    $response = [
//        'recipient' => ['id' => $senderId],
//        'message' => ['attachment' => ['type' => 'image',
//            'payload' => ['url' => 'https://fbbot-patryktok137412.codeanyapp.com/asdf.jpg']]]
//    ];
//
//} else {
//    $answer = "Niestety nie rozumiem. Aby wybrać scenariusz rozmowy napisz 'help'. Aby pobrać regulamin napisz 'regulamin'.";
//    $response = prepareResponse($senderId, $answer);
//}

//     $word = new WordsSimilarity($words->welcomeMessage, $messageText);
//     $check = $word->response();
//     if($check['status']) {
//         $answer = $welcomeMessageResponse[rand(0, count($welcomeMessageResponse) - 1)];
//         $response = prepareResponse($senderId, $answer);
//     } else {
//         $response = prepareResponse($senderId, $check['message']);
//     }


$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
