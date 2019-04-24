<?php

namespace App\Service\SerAymeric;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    public static $payload;
    
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
    public function sendMessage(int $userId, string $content = null, $embed = null)
    {
        $options = [];

        if ($content) {
            $options['content'] = $content;
        }

        if ($embed) {
            $options['embed'] = json_decode(json_encode($embed), true);
        }
    
        SerAymeric::$payload = $options;

        $this->send($userId, $options);
    }
}
