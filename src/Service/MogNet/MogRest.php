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
    /**
     * Send a message to a room
     */
    public function message($channelId, $message)
    {
        $discord = new DiscordClient(['token' => getenv('BOT_TOKEN')]);

        $options = [
            'channel.id' => $channelId,
        ];

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

        // send message
        $discord->channel->createMessage($options);
    }
}
