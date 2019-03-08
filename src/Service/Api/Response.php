<?php

namespace App\Service\Api;

class Response
{
    /** @var bool */
    private $status;
    /** @var string */
    private $message;

    public function __construct(bool $status, string $message)
    {
        $this->status  = $status;
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'status'  => $this->status,
            'message' => $this->message,
        ];
    }
}
