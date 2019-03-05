<?php

namespace App\Service\MogNet\Messages;

/**
 * Field for rich embeds
 */
class Field
{
    public $name;
    public $value;
    public $inline = false;

    public function __construct(string $name, $value, $inline = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->inline = $inline;
    }
}
