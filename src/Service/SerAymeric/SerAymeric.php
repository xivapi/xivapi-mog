<?php

namespace App\Service\SerAymeric;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    public function sendMessage(string $userId, string $message)
    {
        $client = new Client([
            'base_uri' => getenv('SA_BASE_URI'),
            'verify'   => false,
        ]);

        $client->get(getenv('SA_ENDPOINT') . $userId, [
            RequestOptions::HEADERS  => [
                'Authorization' => getenv('SA_AUTH'),
                'Content-Type'  => 'application/json',
            ],
            RequestOptions::JSON => [
                'content' => $message,
            ]
        ]);
    }
}
