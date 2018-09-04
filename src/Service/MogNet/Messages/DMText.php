<?php

namespace App\Service\MogNet\Messages;

/**
 * (Private) An single text message
 */
class DMText extends Text
{
    public function __construct($content = null)
    {
        parent::__construct($content, true);
    }
}
