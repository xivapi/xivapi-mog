<?php

namespace App\Service\SerAymeric;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    /**
     * Send a direct message to a user via Ser Aymeric
     */
    private function send(int $userId, array $json = null)
    {
        $client = new Client([
            'base_uri' => getenv('SA_BASE_URI'),
            'verify'   => false,
        ]);

        $client->post(getenv('SA_ENDPOINT') . $userId, [
            RequestOptions::HEADERS  => [
                'Authorization' => getenv('SA_AUTH'),
            ],
            RequestOptions::JSON => $json
        ]);
    }

    /**
     * Send a direct message to a user via Ser Aymeric
     */
    public function sendMessage(int $userId, string $message)
    {
        $this->send($userId, [
            'content' => $message,
        ]);
    }

    /**
     * Send a direct embed to a user via Ser Aymeric
     */
    public function sendEmbed(int $userId, array $embed)
    {
        $this->send($userId, [
            'embed' => $embed,
        ]);
    }
}
