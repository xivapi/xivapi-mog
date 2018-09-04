<?php

namespace App\Service\MogNet\Messages;

/**
 * An single error message
 */
class Error
{
    public $content;
    // if set to true, it will be sent as a DM instead
    public $isPrivate = false;

    public function __construct($content = null, $isPrivate = false)
    {
        $this->content = "[BeepBoop!] {$content}";
        $this->isPrivate = $isPrivate;
    }
}
