<?php

namespace App\Service\MogNet\Messages;

/**
 * An single text message
 */
class Text
{
    public $content;
    // if set to true, it will be sent as a DM instead
    public $isPrivate = false;

    public function __construct($content = null, $isPrivate = false)
    {
        if (empty($content)) {
            throw new \Exception('Empty message provided to Text($content)');
        }

        $this->content = trim($content);
        $this->isPrivate = $isPrivate;
    }
}
