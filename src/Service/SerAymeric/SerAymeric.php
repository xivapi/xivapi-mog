<?php

namespace App\Service\SerAymeric;

use App\Service\MogRest\MogRest;
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
    private function send(int $userId, array $json = null)
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
        } catch (\Exception $ex) {
            $this->mog->sendMessage(
                '569968196455759907',
                "```Discord Bot Exception: {$ex->getMessage()}``` ```". json_encode($json, JSON_PRETTY_PRINT) ."```"
            );
        }
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
    
        $this->send($userId, $options);
    }
}
