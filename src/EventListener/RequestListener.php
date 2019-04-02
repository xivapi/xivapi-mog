<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestListener
{
    /** @var Request */
    private $request;

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        /** @var Request $request */
        $this->request = $event->getRequest();

        // ensure cd key
        $this->checkAccessKeyProvided();
    }

    /**
     * All requests should have the Mog Key
     */
    private function checkAccessKeyProvided()
    {
        if ($this->request->get('key') != getenv('BOT_USAGE_KEY')) {
            throw new NotFoundHttpException();
        }
    }
}
