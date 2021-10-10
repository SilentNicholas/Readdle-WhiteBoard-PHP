<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;

const CLIENT_ID = 'id';
const CLIENT_SECRET = 'secret';
const REDIRECT_URL = 'url';
const CODE = 'code';

$httpClient = new Client([
    'timeout' => 4.0
]);


$authResponseBody = $httpClient->request("POST", 'https://app.asana.com/-/oauth_token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => CLIENT_ID,
            'client_secret' => CLIENT_SECRET,
            'redirect_uri' => REDIRECT_URL,
            'code' => CODE
        ]
    ]
)->getBody()->getContents();

$accessToken = json_decode($authResponseBody, true)['access_token'] ?? '';
$requestHeaders = ['Authorization' => 'Bearer ' . $accessToken];

$createTaskResponse = $httpClient->request('POST', 'https://app.asana.com/api/1.0/tasks', [
    'headers' => $requestHeaders,
    'form_params' => [
        'name' => 'Please, review Skalenko Nikolay integration',
        'projects' => [1201134145523440]
    ]
])->getBody()->getContents();

$taskId = json_decode($createTaskResponse, true)['data']['gid'] ?? '';

$attachmentResource = fopen('./Resources/whiteboard.txt', 'r');
$response = $httpClient->request('POST', "https://app.asana.com/api/1.0/tasks/{$taskId}/attachments", [
    'headers' => $requestHeaders,
    'multipart' => [
        [
            'name' => 'name',
            'contents' => 'whiteboard.txt',
        ],
        [
            'name' => 'file',
            'contents' => $attachmentResource,
        ]
    ]
]);

fclose($attachmentResource);