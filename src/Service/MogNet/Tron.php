<?php

namespace App\Service\MogNet;

use Psr\Log\LoggerInterface;
use CharlotteDunois\Yasmin\Client;

/**
 * Extended by each bot
 */
class Tron
{
    protected $loop;
    /** @var Client */
    protected $client;
    /** @var MogNetEvents */
    protected $events;
    /** @var LoggerInterface */
    protected $logger;

    public function __construct(MogNetEvents $events, LoggerInterface $logger)
    {
        $this->events = $events;
        $this->logger = $logger;
    }
}
