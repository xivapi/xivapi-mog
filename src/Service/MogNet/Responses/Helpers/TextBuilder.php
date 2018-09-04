<?php

namespace App\Service\MogNet\Responses\Helpers;

class TextBuilder
{
    private $strings = [];

    public function add($text)
    {
        $this->strings[] = $text;
        return $this;
    }

    public function get()
    {
        return implode(PHP_EOL, $this->strings);
    }

    public function gap()
    {
        $this->add('_ _');
        return $this;
    }

    public function space($count = 1)
    {
        for($i = 0; $i < $count; $i++) {
            $this->add(PHP_EOL);
        }
        
        return $this;
    }

    public function code($language = '')
    {
        return sprintf("```{$language}\n%s\n```", $this->get());
    }
}
