<?php

class CurlRequest {

    public $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function sendGet() {


    }

    public function sendPost($response) {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}

//$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken;
//$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
//curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//curl_exec($ch);
//curl_close($ch);

?>