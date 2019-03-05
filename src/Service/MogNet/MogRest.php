<?php

namespace App\Service\MogNet;

use RestCord\DiscordClient;
use App\Service\MogNet\Messages\{Embed,Reply,Text};

/**
 * This bot is loaded during REST or
 * Commands and performs a single action
 */
class MogRest extends Tron
{
    public function discord(): DiscordClient
    {
        return new DiscordClient(['token' => getenv('BOT_TOKEN')]);
    }

    /**
     * Send a message to a room
     */
    public function message($channelId, $message)
    {
        $options = [
            'channel.id' => (int)$channelId,
        ];

        $options = array_merge($options, $this->handleMessage($message));

        // send message
        $this->discord()->channel->createMessage($options);
    }

    public function dm($userId, $message)
    {
        // create dm
        $dm = $this->discord()->user->createDm([
            'recipient_id' => (int)$userId,
        ]);

        $options = [
            'channel.id' => (int)$dm->id
        ];

        $options = array_merge($options, $this->handleMessage($message));

        // send message
        $this->discord()->channel->createMessage($options);
    }

    /**
     * Handles a message and returns the correct options
     */
    private function handleMessage($message)
    {
        $options = [];

        // handle options if the message is an embed
        if (get_class($message) === Embed::class) {
            /** @var Embed $message */
            $options['content'] = null;
            $options['embed'] = $message->getRestEmbed();
        }

        if (get_class($message) === Text::class) {
            /** @var Text $message */
            $options['content'] = $message->content;
        }

        return $options;
    }
}
