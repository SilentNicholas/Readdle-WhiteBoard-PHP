<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;

const CLIENT_ID = 'id';
const CLIENT_SECRET = 'secret';
const REDIRECT_URL = 'test.cpm';


$httpClient = new Client([
    'base_uri' => sprintf('https://app.asana.com/-/', CLIENT_ID, REDIRECT_URL),
    'timeout' => 2.0
]);


$authResponseBody = $httpClient->post(
    'oauth_token',
    [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => CLIENT_ID,
            'client_secret' => CLIENT_SECRET,
            'redirect_uri' => REDIRECT_URL,
            'code' => "some code"
        ]
    ]
)->getBody();