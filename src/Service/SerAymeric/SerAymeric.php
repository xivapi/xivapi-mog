<?php

namespace App\Service\SerAymeric;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    /**
     * Send a direct message to a user via Ser Aymeric
     */
    public function send(int $userId, string $message = null, array $embed = null)
    {
        $client = new Client([
            'base_uri' => getenv('SA_BASE_URI'),
            'verify'   => false,
        ]);

        $params = $embed ? [ 'embed' => $embed ] : [ 'content' => $message ];

        $client->post(getenv('SA_ENDPOINT') . $userId, [
            RequestOptions::HEADERS  => [
                'Authorization' => getenv('SA_AUTH'),
            ],
            RequestOptions::JSON => $params
        ]);
    }

    /**
     * Send a direct message to a user via Ser Aymeric
     */
    public function sendMessage(int $userId, string $message)
    {
        $this->send($userId, $message);
    }

    /**
     * Send a direct embed to a user via Ser Aymeric
     */
    public function sendEmbed(int $userId, array $embed)
    {
        $this->send($userId, null, $embed);
    }
}
