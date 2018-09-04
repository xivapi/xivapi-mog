<?php

namespace App\Service\MogNet\Messages;

/**
 * An single reply text message
 */
class Reply
{
    public $content;
    // if set to true, it will be sent as a DM instead
    public $isPrivate = false;

    public function __construct($content = null, $isPrivate = false)
    {
        $this->content = $content;
        $this->isPrivate = $isPrivate;
    }
}
