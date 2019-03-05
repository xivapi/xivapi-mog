<?php

namespace App\Service\MogNet\Messages;

/**
 * Field for rich embeds
 */
class Image
{
    public $url;
    public $height;
    public $width = false;

    public function __construct(string $url, $height = null, $width = null)
    {
        $this->url    = $url;
        $this->height = $height;
        $this->width  = $width;
    }
}
