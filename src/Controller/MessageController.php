<?php

namespace App\Controller;

use App\Service\Directory\Channels;
use App\Service\MogRest\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /** @var MogRest */
    private $mog;
    
    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;
    }

    /**
     * Send a message to a channel
     *
     * @Route("/mog/notify")
     */
    public function say(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $message = $content['message'] ?? null;
        $embed   = $content['embed']   ?? null;
        $channel = $content['channel'] ?? null;

        $channel = $channel ?: Channels::ADMIN_MOG;

        if ($embed) {
            $this->mog->sendEmbed($channel, $embed);
        } else {
            $this->mog->sendMessage($channel, $message);
        }

        return $this->json([ true, 'Message sent ']);
    }
}
