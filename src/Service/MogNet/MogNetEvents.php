<?php

namespace App\Service\MogNet;

use App\Service\MogNet\Messages\{
    DMEmbed, DMText, Embed, Error, Reply, Text
};
use CharlotteDunois\Yasmin\Models\DMChannel;
use CharlotteDunois\Yasmin\Models\Message;
use Psr\Log\LoggerInterface;

class MogNetEvents
{
    /** @var MogNet */
    private $bot;
    /** @var LoggerInterface */
    private $logger;
    /** @var MogNetMessageHandler */
    private $messenger;

    public function __construct(LoggerInterface $logger, MogNetMessageHandler $messenger)
    {
        $this->logger = $logger;
        $this->messenger = $messenger;
    }

    public function setBot(MogNet $bot)
    {
        $this->bot = $bot;
        return $this;
    }

    public function onMessage(Message $message)
    {
        $response = $this->messenger->handle($message);

        if (!$response) {
            return;
        }

        // if there are multiple responses
        if (is_array($response)) {
            foreach($response as $res) {
                $this->sendResponse($message, $res);
            }

            return;
        }

        $this->sendResponse($message, $response);
    }

    /**
     * Sends a response back, this is done here so that multiple responses
     * can be sent back
     */
    private function sendResponse(Message $message, $response)
    {
        // if response is private, leave as is otherwise set to what the original message is
        $isPrivate = $response->isPrivate ? $response->isPrivate : $message->isPrivate;

        $this->logger->info(($isPrivate ? '[PRIVATE]' : '[PUBLIC] ') .
            ' Responding with a: '. get_class($response));

        // handle sending visibility
        if ($isPrivate) {
            $this->sendResponsePrivate($message, $response);
        } else {
            $this->sendResponsePublic($message, $response);
        }
    }

    /**
     * Send a normal message publicly
     */
    private function sendResponsePublic(Message $message, $response)
    {
        // Respond with a reply to the author
        if (get_class($response) === Reply::class) {
            /** @var Reply $response */
            $message->reply($response->content)->otherwise(function ($error) {
                $this->logger->error($error);
            });
        }

        // Respond with a normal Text to everyone
        if (get_class($response) === Text::class || get_class($response) === Error::class) {
            $message->channel->send($response->content)->otherwise(function ($error) {
                $this->logger->error($error);
            });
        }

        // Respond with an Embed
        if (get_class($response) === Embed::class) {
            /** @var Embed $response */
            $message->channel->send('', ['embed' => $response->getCliEmbed()])->otherwise(function ($error) {
                $this->logger->error($error);
            });
        }
    }

    /**
     * Send a direct message to the user
     */
    private function sendResponsePrivate(Message $message, $response)
    {
        /** @var DMChannel $dmChannel */
        $dmChannel = $message->author->dmChannel;

        // if no dm, create one
        if (!$dmChannel) {
            $this->logger->info('Creating DM');
            $message->author->createDM()->then(function($dmChannel) use ($message, $response) {
                /** @var DMChannel $dmChannel */
                $dmChannel->send($response->content);
            });
        } else {
            $dmChannel->send($response->content);
        }
    }
}
