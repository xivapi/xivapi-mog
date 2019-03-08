<?php

namespace App\Service\MogRest;

use App\Service\MogNet\Messages\Embed;
use App\Service\MogNet\Messages\Text;

trait MogRestTrait
{
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
