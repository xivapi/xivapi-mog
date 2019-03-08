<?php

namespace App\Service\SerAymeric;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    /**
     * Send a direct message to a user via Ser Aymeric
     */
    public function sendDirectMessage(int $userId, string $message)
    {
        $client = new Client([
            'base_uri' => getenv('SA_BASE_URI'),
            'verify'   => false,
        ]);

        $client->post(getenv('SA_ENDPOINT') . $userId, [
            RequestOptions::HEADERS  => [
                'Authorization' => getenv('SA_AUTH'),
            ],
            RequestOptions::JSON => [
                'content' => $message,
            ]
        ]);
    }
}
