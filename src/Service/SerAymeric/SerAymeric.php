<?php

namespace App\Service\SerAymeric;

use App\Service\MogRest\MogRest;
use App\Service\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SerAymeric
{
    /** @var MogRest */
    private $mog;
    
    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;
    }
    
    /**
     * Send a direct message to a user via Ser Aymeric
     */
    private function send(int $userId, array $json = null): Response
    {
        $client = new Client([
            'base_uri' => getenv('SA_BASE_URI'),
            'verify'   => false,
        ]);
        
        try {
            $client->post(getenv('SA_ENDPOINT') . $userId, [
                RequestOptions::HEADERS  => [
                    'Authorization' => getenv('SA_AUTH'),
                ],
                RequestOptions::JSON => $json
            ]);
    
            return new Response(200, 'Message Sent.');
        } catch (\Exception $ex) {
            return new Response($ex->getCode(), 'Could not send message.');
        }
    }

    /**
     * Send a direct message to a user via Ser Aymeric
     */
    public function sendMessage(int $userId, string $content = null, $embed = null): Response
    {
        $options = [];

        if ($content) {
            $options['content'] = $content;
        }

        if ($embed) {
            $options['embed'] = json_decode(json_encode($embed), true);
        }
    
        return $this->send($userId, $options);
    }
}
