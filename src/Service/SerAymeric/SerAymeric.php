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
    public function sendMessage(int $userId, string $content, array $embed)
    {
        $options = [];

        if ($content) {
            $options['content'] = $content;
        }

        if ($embed) {
            $options['embed'] = $embed;
        }

        $this->send($userId, $options);
    }
}
