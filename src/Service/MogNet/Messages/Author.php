<?php

namespace App\Service\MogNet\Messages;

/**
 * Field for rich embeds
 */
class Author
{
    public $name;
    public $url;
    public $iconUrl = false;

    public function __construct($name, $url = null, $iconUrl = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->iconUrl = $iconUrl;
    }
}
