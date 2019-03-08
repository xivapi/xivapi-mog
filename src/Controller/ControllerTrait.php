<?php

namespace App\Controller;

trait ControllerTrait
{
    /**
     * Get a discord room from the content in the request
     */
    public function getChannelFromRequestContent(\stdClass $content)
    {
        $channel = $content->channel ?? null;

        if ($channel === null) {
            throw new \Exception('A channel must be provided in the request.');
        }

        return $channel;
    }
}
