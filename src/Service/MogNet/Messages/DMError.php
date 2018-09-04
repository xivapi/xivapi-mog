<?php

namespace App\Service\MogNet\Messages;

/**
 * An single error message
 */
class DMError extends Error
{
    public function __construct($content = null)
    {
        parent::__construct($content, true);
    }
}
