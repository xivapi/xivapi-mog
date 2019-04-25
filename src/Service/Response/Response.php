<?php

namespace App\Service\Response;

class Response
{
    public $code;
    
    public $message;

    public $data;
    
    public function __construct(int $code, string $message, $data = null)
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->data     = $data;
    }
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
