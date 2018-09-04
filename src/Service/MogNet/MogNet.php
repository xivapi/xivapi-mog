<?php

namespace App\Service\MogNet;

use CharlotteDunois\Yasmin\Client;
use React\EventLoop\Factory;

/**
 * This bot is intended to run
 * at all times and listen for user messages
 */
class MogNet extends Tron
{
    public function run()
    {
        $this->loop = Factory::create();
        $this->client = new Client([], $this->loop);

        // ----------------------------
        // Events: https://charlottedunois.github.io/Yasmin/master/CharlotteDunois/Yasmin/ClientEvents.html#method_ready
        // todo - handle disconnecting
        // ----------------------------

        $this->client->on('ready', function() {
            $this->logger->info('Bot is running!');
        });

        $this->client->on('message', function($message) {
            $this->events->onMessage($message);
        });

        // ----------------------------

        // log the bot in
        $this->client->login(getenv('BOT_TOKEN'));

        // run the bot
        $this->loop->run();
    }
}
